<?php

namespace App\Services\Admin;

use App\Models\PerusahaanModel;

class PerusahaanService
{
    protected $perusahaan;

    public function __construct()
    {
        $this->perusahaan = new PerusahaanModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->perusahaan->getDatatable($request);

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
            'id'                    => $row['id'],
            'nama_perusahaan'       => $row['nama_perusahaan'],
            'alamat'                => $row['alamat'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function createPerusahaan(array $data)
    {
        // Contoh logika tambahan: Pastikan nama perusahaan rapi (Title Case)
        if (isset($data['nama_perusahaan'])) {
            $data['nama_perusahaan'] = ucwords(strtolower($data['nama_perusahaan']));
        }

        return $this->perusahaan->insert($data);
    }
    public function updatePerusahaan(string $id, array $data)
    {
        // 1. Validasi keberadaan data
        $perusahaan = $this->perusahaan->find($id);

        if (!$perusahaan) {
            throw new \Exception('Data perusahaan tidak ditemukan.');
        }

        // 2. Normalisasi data (Opsional: Membuat nama perusahaan rapi)
        if (isset($data['nama_perusahaan'])) {
            $data['nama_perusahaan'] = ucwords(strtolower($data['nama_perusahaan']));
        }

        // 3. Eksekusi update
        return $this->perusahaan->update($id, $data);
    }
    public function deletePerusahaan(string $id)
    {
        // 1. Validasi keberadaan data
        $perusahaan = $this->perusahaan->find($id);

        if (!$perusahaan) {
            throw new \Exception('Perusahaan tidak ditemukan.');
        }

        // 2. Proteksi Relasi: Cek apakah masih ada pegawai di perusahaan ini
        $db = \Config\Database::connect();
        $employeeCount = $db->table('pegawai')->where('perusahaan_id', $id)->countAllResults();

        if ($employeeCount > 0) {
            throw new \Exception("Gagal menghapus! Masih terdapat $employeeCount pegawai yang terdaftar di perusahaan ini.");
        }

        // 3. Eksekusi Hapus
        return $this->perusahaan->delete($id);
    }
}
