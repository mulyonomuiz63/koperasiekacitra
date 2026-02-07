<?php

namespace App\Services\Admin;

use App\Models\JabatanModel;
use App\Models\PegawaiModel;
use App\Models\PembayaranModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;

class PegawaiService
{
    protected $pegawai;
    protected $perusahaan;
    protected $jabatan;
    protected $pembayaranModel;
    protected $user;

    public function __construct()
    {
        $this->pegawai = new PegawaiModel();
        $this->perusahaan = new PerusahaanModel();
        $this->jabatan    = new JabatanModel();
        $this->pembayaranModel    = new PembayaranModel();
        $this->user    = new UserModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->pegawai->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {
            $data[] = $this->mapRow($row, $menuId);
        }

        return [
            'draw'            => (int) $request['draw'],
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ];
    }

    protected function mapRow(array $row, string $menuId): array
    {
        return [
            'id'         => $row['id'],
            'namaPegawai'       => $row['namaPegawai'] != '' ? $row['namaPegawai'] : '-',
            'status_iuran' => $row['status_iuran'],
            'status' => $row['status'],
            'jabatan'    => $row['nama_jabatan'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function getCreateData(): array
    {
        // Logika: Ambil user yang ID-nya tidak ada di kolom user_id tabel pegawai
        $availableUsers = $this->user->whereNotIn('id', function ($builder) {
            return $builder->select('user_id')->from('pegawai');
        })->findAll();

        return [
            'users'      => $availableUsers,
            'perusahaan' => $this->perusahaan->findAll(),
            'jabatan'    => $this->jabatan->findAll(),
        ];
    }

    public function createPegawai(array $data)
    {
        try {
            // Logika Tambahan: Misalnya, otomatis set status 'Aktif' jika tidak dikirim
            if (!isset($data['status'])) {
                $data['status'] = 'A';
            }

            // Simpan ke database
            return $this->pegawai->insert($data);
        } catch (\Throwable $e) {
            throw new \Exception("Gagal menyimpan data pegawai: " . $e->getMessage());
        }
    }

    public function getEditData(string $pegawaiId): array
    {
        $pegawai = $this->pegawai
            ->select('pegawai.*, users.username')
            ->join('users', 'users.id = pegawai.user_id')
            ->where('pegawai.id', $pegawaiId)
            ->first();

        if (! $pegawai) {
            return [
                'pegawai' => null,
            ];
        }

        return [
            'pegawai'    => $pegawai,
            'perusahaan' => $this->perusahaan->findAll(),
            'jabatan'    => $this->jabatan->findAll(),
        ];
    }

    public function updatePegawai(string $id, array $data)
    {
        try {
            // 1. Cek keberadaan data
            $pegawai = $this->pegawai->find($id);
            if (!$pegawai) {
                throw new \Exception('Data pegawai tidak ditemukan.');
            }

            return $this->pegawai->update($id, $data);
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function uploadBukti($file)
    {
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/bukti-bayar', $newName);
            return $newName;
        }
        return null;
    }

    /**
     * Logika simpan ke database
     */
    public function simpanPendaftaran(string $id, array $data)
    {
        $db = \Config\Database::connect();

        // Gunakan transBegin (Bukan transStart) untuk kontrol penuh dalam try-catch
        $db->transBegin();
        $fileName = null;
        try {
            // 1. Update status pegawai
            // Pastikan $this->pegawai adalah model
            $updatePegawai = $this->pegawai->update($id, [
                'status'        => 'A',
                'status_iuran'  => 'A',
            ]);

            if (!$updatePegawai) {
                throw new \Exception("Gagal update status pegawai: " . json_encode($this->pegawai->errors()));
            }

            // 2. Insert data pembayaran
            $tgl_bayar = date('Y-m-d H:i:s', strtotime($data['tgl_bayar']));
            $file = $data['bukti_bayar'];

            if (empty($tgl_bayar)) {
                throw new \Exception('Tanggal bayar harus diisi.');
            }

            // 1. Upload file terlebih dahulu
            if ($file && $file->getError() !== 4) {
                $fileName = $this->uploadBukti($file);

                if (!$fileName) {
                    throw new \Exception('Gagal mengunggah bukti pembayaran.');
                }
            }

            $bulan = date('n', strtotime($tgl_bayar));
            $tahun = date('Y', strtotime($tgl_bayar));

            $dataPembayaran = [
                'invoice_no'      => generateBigInvoiceNumber(),
                'invoice_at'      => date('Y-m-d H:i:s'),
                'pegawai_id'      => $id,
                'jenis_transaksi' => 'pendaftaran',
                'bulan'           => (int)$bulan,
                'tahun'           => (int)$tahun,
                'jumlah_bayar'    => $data['jumlah_bayar'],
                'bukti_bayar'     => $fileName,
                'tgl_bayar'       => $tgl_bayar,
                'status'          => "A",
                'validated_at'    => date('Y-m-d H:i:s'),
            ];
            
            $insertPembayaran = $this->pembayaranModel->insert($dataPembayaran);

            if (!$insertPembayaran) {
                throw new \Exception("Gagal simpan pembayaran: " . json_encode($this->pembayaranModel->errors()));
            }

            // 3. Selesaikan Transaksi
            if ($db->transStatus() === false) {
                $db->transRollback();
                throw new \Exception("Transaksi Database Gagal.");
            } else {
                $db->transCommit();
                return true;
            }
        } catch (\Throwable $e) {
            $db->transRollback();
            if ($fileName) {
                $filePath = FCPATH . 'uploads/bukti-bayar/' . $fileName;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            // Lemparkan error asli agar terbaca di Controller
            throw new \Exception($e->getMessage());
        }
    }

    public function deletePegawai(string $id)
    {
        try {
            // 1. Cek apakah data pegawai ada
            $pegawai = $this->pegawai->find($id);
            if (!$pegawai) {
                throw new \Exception('Data pegawai tidak ditemukan.');
            }

            // 2. Eksekusi hapus
            // Jika Anda menggunakan SoftDeletes di Model, data hanya akan terisi kolom deleted_at
            return $this->pegawai->delete($id);
        } catch (\Throwable $e) {
            throw new \Exception("Gagal menghapus pegawai: " . $e->getMessage());
        }
    }
}
