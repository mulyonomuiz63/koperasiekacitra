<?php

namespace App\Services\Admin;

use App\Models\MenuModel;

class MenuService
{
    protected $menu;

    public function __construct()
    {
        $this->menu = new MenuModel();
    }

    public function datatable(array $request): array
    {
        $result = $this->menu->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {
            $data[] = [
                'id'         => $row['id'],
                'name'       => $row['name'],
                'url'        => $row['url'],
                'menu_order' => $row['menu_order'],
                'is_active'  => $row['is_active'],
                'parent_id'  => $row['parent_id'],
                'has_child'  => $row['has_child'],
            ];
        }

        return [
            'draw'            => intval($request['draw']),
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ];
    }

    /**
     * Ambil children menu
     */
    public function getChildren(string $parentId): array
    {
        return $this->menu
            ->where('parent_id', $parentId)
            ->orderBy('menu_order', 'ASC')
            ->findAll();
    }

    public function createMenu(array $data)
    {
        // Logika tambahan: Pastikan parent_id adalah integer
        $saveData = [
            'nama_menu' => $data['nama_menu'],
            'url'       => $data['url'] ?? '#',
            'icon'      => $data['icon'] ?? 'bi bi-grid',
            'parent_id' => !empty($data['parent_id']) ? (string)$data['parent_id'] : 0,
            'urutan'    => !empty($data['urutan']) ? (int)$data['urutan'] : 1,
            'is_active' => 1
        ];

        return $this->menu->insert($saveData);
    }

    public function updateMenu(string $id, array $data)
    {
        // 1. Cari data menu
        $menu = $this->menu->find($id);
        if (!$menu) {
            throw new \Exception('Menu tidak ditemukan.');
        }

        // 2. Validasi Hirarki: Menu tidak boleh jadi anak dari dirinya sendiri
        if (isset($data['parent_id']) && $data['parent_id'] == $id) {
            throw new \Exception('Menu tidak boleh menjadi Parent bagi dirinya sendiri.');
        }

        // 3. Susun data update
        $updateData = [
            'nama_menu' => $data['nama_menu'],
            'url'       => $data['url'] ?? $menu['url'],
            'icon'      => $data['icon'] ?? $menu['icon'],
            'parent_id' => isset($data['parent_id']) ? (string)$data['parent_id'] : $menu['parent_id'],
            'urutan'    => isset($data['urutan']) ? (int)$data['urutan'] : $menu['urutan'],
        ];

        return $this->menu->update($id, $updateData);
    }

    public function deleteMenuRecursive(string $id)
    {
        $db = \Config\Database::connect();

        // Mulai Database Transaction
        $db->transBegin();

        try {
            $menu = $this->menu->find($id);

            if (!$menu) {
                throw new \Exception('Menu tidak ditemukan.');
            }

            // Jalankan rekursi internal
            $this->executeRecursiveDelete($id);

            // Jika semua lancar, simpan perubahan
            $db->transCommit();
            return true;
        } catch (\Throwable $e) {
            // Jika ada error, batalkan semua penghapusan
            $db->transRollback();
            throw new \Exception('Gagal menghapus menu: ' . $e->getMessage());
        }
    }

    private function executeRecursiveDelete($parentId)
    {
        // Cari semua sub-menu
        $children = $this->menu->where('parent_id', $parentId)->findAll();

        foreach ($children as $child) {
            // Rekursi ke level yang lebih dalam
            $this->executeRecursiveDelete($child['id']);

            // Hapus sub-menu
            $this->menu->delete($child['id']);
        }

        // Terakhir hapus menu utama (parent)
        return $this->menu->delete($parentId);
    }
}
