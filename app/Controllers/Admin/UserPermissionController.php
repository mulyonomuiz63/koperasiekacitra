<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UserPermissionController extends BaseController
{
    public function index($userId)
    {
        $menuModel = db_connect()->table('menus');
        $permModel = new \App\Models\UserPermissionModel();

        $menus = $menuModel->get()->getResult();

        $permissions = $permModel
            ->where('user_id', $userId)
            ->findAll();

        // Map supaya gampang di view
        $map = [];
        foreach ($permissions as $p) {
            $map[$p['menu_id']] = $p;
        }

        return view('admin/users/permission', [
            'user_id'        => $userId,
            'menus'          => $menus,
            'userPermissions'=> $map
        ]);
    }


    public function save()
    {
        $userId = $this->request->getPost('user_id');
        $permissions = $this->request->getPost('permissions');

        $model = new \App\Models\UserPermissionModel();

        // 🔥 Hapus override lama (supaya clean)
        $model->where('user_id', $userId)->delete();

        if ($permissions) {
            foreach ($permissions as $menuId => $acts) {
                $model->insert([
                    'user_id'    => $userId,
                    'menu_id'    => $menuId,
                    'can_view'   => isset($acts['view'])   ? 1 : 0,
                    'can_create' => isset($acts['create']) ? 1 : 0,
                    'can_update' => isset($acts['update']) ? 1 : 0,
                    'can_delete' => isset($acts['delete']) ? 1 : 0,
                ]);
            }
        }

        return redirect()->to('users')->with('success','Permission user berhasil disimpan');
    }


}