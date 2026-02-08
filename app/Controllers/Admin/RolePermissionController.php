<?php

namespace App\Controllers\Admin;

use App\Services\Admin\RolePermissionService;
use App\Controllers\BaseController;

class RolePermissionController extends BaseController
{
    protected $service;

    public function __construct()
    {
        $this->service = new RolePermissionService();
    }

    public function index($roleId)
    {
        $data    = $this->service->getRolePermissionData($roleId);
        return view('admin/roles/permission', $data);
    }

    public function save()
    {
        $roleId      = $this->request->getPost('role_id');
        $permissions = $this->request->getPost('permissions');

        if (empty($roleId)) {
            return redirect()->to('roles')
                ->with('error', 'Role tidak valid');
        }

        try {

            $this->service->savePermissions($roleId, $permissions);

            return redirect()->to('roles')
                ->with('success', 'Role permission berhasil disimpan');

        } catch (\Throwable $e) {

            return redirect()->to('roles')
                ->with('error', $e->getMessage());
        }
    }
}
