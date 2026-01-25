<?php

namespace App\Services\Admin;

use App\Models\UserPermissionModel;

class UserPermissionService
{
    protected $permModel;
    protected $menuTable;

    public function __construct()
    {
        $this->permModel = new UserPermissionModel();
        $this->menuTable = db_connect()->table('menus');
    }

    /**
     * Ambil data menu & permission user
     */
    public function getUserPermissions($userId)
    {
        $menus = $this->menuTable->get()->getResult();
        $permissions = $this->permModel
            ->where('user_id', $userId)
            ->findAll();

        // Map supaya gampang di view
        $map = [];
        foreach ($permissions as $p) {
            $map[$p['menu_id']] = $p;
        }

        return [
            'user_id'         => $userId,
            'menus'           => $menus,
            'userPermissions' => $map,
        ];
    }

    /**
     * Simpan permission user
     */
    public function saveUserPermissions($userId, $permissions)
    {
        // Hapus permission lama supaya bersih
        $this->permModel->where('user_id', $userId)->delete();

        if ($permissions) {
            foreach ($permissions as $menuId => $acts) {
                $this->permModel->insert([
                    'user_id'    => $userId,
                    'menu_id'    => $menuId,
                    'can_view'   => isset($acts['view'])   ? 1 : 0,
                    'can_create' => isset($acts['create']) ? 1 : 0,
                    'can_update' => isset($acts['update']) ? 1 : 0,
                    'can_delete' => isset($acts['delete']) ? 1 : 0,
                ]);
            }
        }

        return true;
    }
}
