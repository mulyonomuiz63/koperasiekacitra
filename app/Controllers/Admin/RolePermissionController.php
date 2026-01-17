<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RolePermissionModel;

class RolePermissionController extends BaseController
{
    public function index($roleId)
    {
        $menus = db_connect()->table('menus')->get()->getResult();

        $model = new RolePermissionModel();
        $perms = $model->where('role_id',$roleId)->findAll();

        $map = [];
        foreach ($perms as $p) {
            $map[$p['menu_id']] = $p;
        }

        return view('admin/roles/permission', [
            'role_id'         => $roleId,
            'menus'           => $menus,
            'rolePermissions' => $map
        ]);
    }

    public function save()
    {
        $roleId      = $this->request->getPost('role_id');
        $permissions = $this->request->getPost('permissions');

        $model = new RolePermissionModel();
        $model->resetRolePermissions($roleId);

        if ($permissions) {
            foreach ($permissions as $menuId => $acts) {
                $model->insert([
                    'role_id'    => $roleId,
                    'menu_id'    => $menuId,
                    'can_view'   => isset($acts['view'])   ? 1 : 0,
                    'can_create' => isset($acts['create']) ? 1 : 0,
                    'can_update' => isset($acts['update']) ? 1 : 0,
                    'can_delete' => isset($acts['delete']) ? 1 : 0,
                ]);
            }
        }

        return redirect()->to('roles')->with('success','Role permission berhasil disimpan');
    }
}
