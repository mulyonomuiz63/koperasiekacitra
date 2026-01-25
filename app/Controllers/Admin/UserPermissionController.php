<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\Admin\UserPermissionService;

class UserPermissionController extends BaseController
{
    protected $service;

    public function __construct()
    {
        $this->service = new UserPermissionService();
    }
    public function index($userId)
    {
        $data = $this->service->getUserPermissions($userId);
        return view('admin/users/permission', $data);
    }

    public function save()
    {
        $userId = $this->request->getPost('user_id');
        $permissions = $this->request->getPost('permissions');

        $this->service->saveUserPermissions($userId, $permissions);

        return redirect()->to('users')
            ->with('success', 'Permission user berhasil disimpan');
    }



}