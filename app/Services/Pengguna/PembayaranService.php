<?php

namespace App\Services\Pengguna;

use App\Models\PembayaranModel;
use App\Models\IuranBulananModel;
use App\Models\PembayaranDetailModel;
use Config\Database;
use CodeIgniter\Files\File;

class PembayaranService
{
    protected $pembayaranModel;
    protected $iuranModel;
    protected $detailModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->iuranModel      = new IuranBulananModel();
        $this->detailModel     = new PembayaranDetailModel();
    }

    public function prosesPembayaran(array $data): array
    {
        $db = Database::connect();
        $db->transBegin();

        $pegawaiId = $data['pegawai_id'] ?? null;
        $iuranIds  = $data['iuran_ids'] ?? [];
        $total     = $data['total_bayar'] ?? 0;
        $bulan     = $data['bulan'] ?? null;
        $tahun     = $data['tahun'] ?? null;

        if (!$pegawaiId || empty($iuranIds)) {
            throw new \Exception('Data pembayaran tidak valid');
        }

        $pembayaranId = $this->pembayaranModel->insert([
            'pegawai_id'      => $pegawaiId,
            'jenis_transaksi' => 'bulanan',
            'bulan'           => $bulan,
            'tahun'           => $tahun,
            'jumlah_bayar'    => $total,
            'status'          => 'P',
        ]);

        if (!$pembayaranId) {
            $db->transRollback();
            throw new \Exception('Gagal menyimpan pembayaran');
        }

        foreach ($iuranIds as $iuranId) {
            $iuran = $this->iuranModel->find($iuranId);
            if (!$iuran) continue;

            $this->detailModel->insert([
                'pembayaran_id' => $pembayaranId,
                'iuran_id'      => $iuranId,
                'jumlah_bayar'  => $iuran['jumlah_iuran'],
            ]);

            $this->iuranModel->update($iuranId, ['status' => 'P']);
        }

        $db->transCommit();

        return [
            'status'   => 'success',
            'redirect' => base_url('sw-anggota/histori-iuran/' . $pembayaranId)
        ];
    }

    public function uploadBuktiPembayaran(string $pembayaranId, $file): array
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
