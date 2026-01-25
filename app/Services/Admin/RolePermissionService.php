<?php

namespace App\Services\Admin;

use App\Models\RolePermissionModel;
use App\Models\MenuModel;
use Config\Database;

class RolePermissionService
{
    protected $db;
    protected $rolePermission;
    protected $menu;

    public function __construct()
    {
        $this->db             = Database::connect();
        $this->rolePermission = new RolePermissionModel();
        $this->menu           = new MenuModel(); // atau pakai query builder jika belum ada
    }

    /**
     * Ambil data permission role untuk halaman index
     */
    public function getRolePermissionData(string $roleId): array
    {
        // Ambil menu terurut
        $menus = $this->menu
            ->orderBy('parent_id', 'ASC')
            ->orderBy('menu_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();

        // Ambil permission role
        $permissions = $this->rolePermission
            ->where('role_id', $roleId)
            ->findAll();

        // Map permission
        $permissionMap = [];
        foreach ($permissions as $perm) {
            $permissionMap[$perm['menu_id']] = $perm;
        }

        return [
            'role_id'         => $roleId,
            'menus'           => $this->buildMenuTree($menus),
            'rolePermissions' => $permissionMap,
        ];
    }


    private function buildMenuTree(array $menus, ?string $parentId = null): array
    {
        $branch = [];

        foreach ($menus as $menu) {
            $menuParent = $menu['parent_id'] ?: null;

            if ($menuParent === $parentId) {

                $children = $this->buildMenuTree($menus, $menu['id']);

                if ($children) {
                    $menu['children'] = $children;
                }

                $branch[] = $menu;
            }
        }

        return $branch;
    }





    /**
     * Simpan ulang permission role (reset & insert)
     */
    public function savePermissions(string $roleId, ?array $permissions): void
    {
        $this->db->transBegin();

        try {
            // reset semua permission role
            $this->rolePermission->resetRolePermissions($roleId);

            if (!empty($permissions)) {
                foreach ($permissions as $menuId => $acts) {
                    $this->rolePermission->insert([
                        'role_id'    => $roleId,
                        'menu_id'    => $menuId,
                        'can_view'   => isset($acts['view'])   ? 1 : 0,
                        'can_create' => isset($acts['create']) ? 1 : 0,
                        'can_update' => isset($acts['update']) ? 1 : 0,
                        'can_delete' => isset($acts['delete']) ? 1 : 0,
                    ]);
                }
            }

            $this->db->transCommit();

        } catch (\Throwable $e) {

            if ($this->db->transStatus()) {
                $this->db->transRollback();
            }

            throw $e;
        }
    }
}
