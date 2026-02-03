<?php

namespace App\Services\Pengguna;

use App\Models\PembayaranModel;
use App\Models\IuranBulananModel;
use App\Models\PegawaiModel;
use App\Models\PembayaranDetailModel;
use Config\Database;

class PembayaranService
{
    protected $pembayaranModel;
    protected $iuranModel;
    protected $pegawaiModel;
    protected $detailModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->iuranModel      = new IuranBulananModel();
        $this->detailModel     = new PembayaranDetailModel();
    }

    public function prosesPembayaran(array $data): array
    {
        $db = \Config\Database::connect();
        $db->transBegin(); // Mulai transaksi

        try {
            $pegawaiId = $data['pegawai_id'] ?? null;
            $iuranIds  = $data['iuran_ids'] ?? [];
            $total     = $data['total_bayar'] ?? 0;
            $bulan     = $data['bulan'] ?? null;
            $tahun     = $data['tahun'] ?? null;

            if (!$pegawaiId || empty($iuranIds)) {
                throw new \Exception('Data pembayaran tidak valid');
            }

            // 1. Insert ke Tabel Pembayaran
            $pembayaranId = $this->pembayaranModel->insert([
                'pegawai_id'      => $pegawaiId,
                'jenis_transaksi' => 'bulanan',
                'bulan'           => $bulan,
                'tahun'           => $tahun,
                'jumlah_bayar'    => $total,
                'status'          => 'P', // Pending
            ]);

            if (!$pembayaranId) {
                throw new \Exception('Gagal menyimpan data pembayaran utama');
            }

            // 2. Loop Detail & Update Status Iuran
            foreach ($iuranIds as $iuranId) {
                $iuran = $this->iuranModel->find($iuranId);
                if (!$iuran) continue;

                $this->detailModel->insert([
                    'pembayaran_id' => $pembayaranId,
                    'iuran_id'      => $iuranId,
                    'jumlah_bayar'  => $iuran['jumlah_iuran'],
                ]);

                // Update status iuran menjadi P (Pending)
                $this->iuranModel->update($iuranId, ['status' => 'P']);
            }

            // Cek apakah ada error database selama proses di atas
            if ($db->transStatus() === false) {
                $db->transRollback();
                throw new \Exception('Transaksi Database Gagal');
            }

            $db->transCommit();

            return [
                'status'   => 'success',
                'message'  => 'Pembayaran berhasil diproses',
                'redirect' => base_url('sw-anggota/histori-iuran/' . $pembayaranId)
            ];
        } catch (\Exception $e) {
            $db->transRollback(); // Pastikan rollback jika ada error apapun
            return [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function uploadBuktiPembayaran(string $pembayaranId, $file, array $data = []): array
    {
        $db = Database::connect();
        $db->transBegin();

        $filename = null;

        try {
            if (!$pembayaranId || !$file || !$file->isValid()) {
                throw new \Exception('Input tidak valid');
            }

            $pembayaran = $this->pembayaranModel->find($pembayaranId);

            if (!$pembayaran) {
                throw new \Exception('Data pembayaran tidak ditemukan');
            }

            if ($pembayaran['status'] !== 'P') {
                throw new \Exception('Bukti pembayaran tidak dapat diupload');
            }

            $allowedExt  = ['jpg', 'jpeg', 'png'];
            $allowedMime = ['image/jpeg', 'image/png'];

            $extension = strtolower($file->getExtension());
            $mimeType  = $file->getMimeType();

            if (!in_array($extension, $allowedExt) || !in_array($mimeType, $allowedMime)) {
                throw new \Exception('Format file harus JPG atau PNG');
            }

            if ($file->getSizeByUnit('mb') > 2) {
                throw new \Exception('Ukuran file maksimal 2MB');
            }

            $filename = sprintf(
                'bukti_%s_%s.%s',
                $pembayaranId,
                date('YmdHis'),
                $extension
            );

            $uploadPath = FCPATH . 'uploads/bukti-bayar/';

            if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);

            $file->move($uploadPath, $filename);

            // Update pembayaran
            $this->pembayaranModel->update($pembayaranId, [
                'bukti_bayar' => $filename,
                'tgl_bayar' => $data['tgl_bayar'],
                'nama_pengirim' => $data['nama_pengirim'],
                'status'      => 'V',
                'updated_at'  => date('Y-m-d H:i:s')
            ]);

            // Update iuran
            $details = $this->detailModel->where('pembayaran_id', $pembayaranId)->findAll();
            foreach ($details as $d) {
                $this->iuranModel->update($d['iuran_id'], [
                    'status'     => 'V',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            $db->transCommit();

            $pegawai = $this->pegawaiModel
            ->where('user_id', session()->get('user_id'))
            ->first();

            send_notification('Bendahara', [
                'title'   => 'Upload pembayaran iuran',
                'message' => 'Ada bukti baru dari ' . $pegawai['nama'],
                'link'    => 'iuran-bulanan/' . $pembayaranId
            ]);

            return [
                'status'  => 'success',
                'message' => 'Bukti pembayaran berhasil diupload dan menunggu verifikasi'
            ];
        } catch (\Throwable $e) {
            if ($db->transStatus()) $db->transRollback();
            if ($filename) {
                $path = FCPATH . 'uploads/bukti-bayar/' . $filename;
                if (is_file($path)) unlink($path);
            }
            return [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
