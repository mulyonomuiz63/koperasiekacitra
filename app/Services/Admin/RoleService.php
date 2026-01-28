<?php

namespace App\Services\Admin;

use App\Models\RoleModel;

class RoleService
{
    protected $role;

    public function __construct()
    {
        $this->role = new RoleModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->role->getDatatable($request);

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
            'name'       => $row['name'],
            'description' => $row['description'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function createRole(array $data)
    {
        $saveData = [
            'name'        => $data['name'],
            // Mengubah 'Super Admin' menjadi 'super_admin' agar konsisten sebagai key
            'role_key'    => strtolower(str_replace(' ', '_', $data['role_key'])),
            'description' => $data['description'] ?? ''
        ];

        return $this->role->insert($saveData);
    }

    public function getRoleById(string $id)
    {
        $role = $this->role->find($id);

        if (!$role) {
            throw new \Exception('Role tidak ditemukan.');
        }

        // Contoh logika tambahan: Proteksi role sistem
        // if ($role['role_key'] === 'superadmin') {
        //     throw new \Exception('Role sistem tidak dapat diubah.');
        // }

        return $role;
    }

    public function updateRole(string $id, array $data)
    {
        try {
            // 1. Pastikan data ada sebelum diupdate
            $role = $this->role->find($id);
            if (!$role) {
                throw new \Exception('Role tidak ditemukan.');
            }

            // 2. Normalisasi data
            $updateData = [
                'name'        => $data['name'],
                'role_key'    => strtolower(str_replace(' ', '_', $data['role_key'])),
                'description' => $data['description']
            ];

            // 3. Eksekusi Update
            return $this->role->update($id, $updateData);
        } catch (\Throwable $e) {
            throw new \Exception("Gagal memperbarui role: " . $e->getMessage());
        }
    }

    public function deleteRole(string $id)
    {
        try {
            // 1. Pastikan role ada
            $role = $this->role->find($id);
            if (!$role) {
                throw new \Exception('Role tidak ditemukan.');
            }

            // 2. Proteksi Role Sistem (Opsional tapi sangat disarankan)
            if ($role['role_key'] === 'superadmin' || $role['role_key'] === 'admin') {
                throw new \Exception('Role sistem utama tidak dapat dihapus.');
            }

            // 3. Cek apakah Role masih digunakan oleh User
            $db = \Config\Database::connect();
            $userCount = $db->table('users')->where('role_id', $id)->countAllResults();

            if ($userCount > 0) {
                throw new \Exception("Gagal menghapus! Role ini masih digunakan oleh $userCount user.");
            }

            // 4. Eksekusi Hapus
            return $this->role->delete($id);
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
