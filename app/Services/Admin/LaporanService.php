<?php

namespace App\Services\Admin;

use App\Models\JabatanModel;

class LaporanService
{
    protected $jabatan;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->jabatan->getDatatable($request);

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
            'nama_jabatan'          => $row['nama_jabatan'],
            'keterangan'            => $row['keterangan'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function createJabatan(array $data)
    {
        // Anda bisa menambahkan logika tambahan di sini
        // Contoh: memastikan nama jabatan disimpan dalam huruf kapital
        if (isset($data['nama_jabatan'])) {
            $data['nama_jabatan'] = strtoupper($data['nama_jabatan']);
        }

        return $this->jabatan->insert($data);
    }
    public function updateJabatan(string $id, array $data)
    {
        // 1. Validasi keberadaan data
        $jabatan = $this->jabatan->find($id);

        if (!$jabatan) {
            throw new \Exception('Data jabatan tidak ditemukan.');
        }

        // 2. Tambahan: Normalisasi data jika perlu
        if (isset($data['nama_jabatan'])) {
            $data['nama_jabatan'] = strtoupper($data['nama_jabatan']);
        }

        // 3. Eksekusi update
        return $this->jabatan->update($id, $data);
    }

    public function deleteJabatan(string $id)
    {
        // 1. Cari datanya
        $jabatan = $this->jabatan->find($id);

        if (!$jabatan) {
            throw new \Exception('Jabatan tidak ditemukan.');
        }

        // 2. Cek Relasi: Apakah masih ada pegawai dengan jabatan ini?
        // Asumsi Anda punya PegawaiModel atau tabel 'pegawai'
        $db = \Config\Database::connect();
        $isUsed = $db->table('pegawai')->where('jabatan_id', $id)->countAllResults();

        if ($isUsed > 0) {
            throw new \Exception('Jabatan tidak bisa dihapus karena masih digunakan oleh ' . $isUsed . ' pegawai.');
        }

        // 3. Eksekusi Hapus
        return $this->jabatan->delete($id);
    }
}
