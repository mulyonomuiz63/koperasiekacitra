<?php

namespace App\Services\Admin;

use App\Models\JabatanModel;
use App\Models\PegawaiModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;

class PegawaiService
{
    protected $pegawai;
    protected $perusahaan;
    protected $jabatan;
    protected $user;

    public function __construct()
    {
        $this->pegawai = new PegawaiModel();
        $this->perusahaan = new PerusahaanModel();
        $this->jabatan    = new JabatanModel();
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
