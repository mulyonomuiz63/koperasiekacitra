<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Services\Admin\RoleService;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $menuId;
    protected $service;


    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->menuId = $this->setMenu('roles');
        $this->service = new RoleService();
    }

    // =============================
    // LIST ROLE
    // =============================
    public function index()
    {
        $this->setMenu('roles');
        return $this->view('admin/roles/index');
    }

    public function datatable()
    {
        if (! $this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }

        return $this->response->setJSON(
            $this->service->get(
                $this->request->getPost(),
                $this->menuId
            )
        );
    }

    // =============================
    // FORM CREATE ROLE
    // =============================
    public function create()
    {
        return view('admin/roles/create');
    }

    // =============================
    // SIMPAN ROLE
    // =============================
    public function store()
    {
        $this->roleModel->insert([
            'name'        => $this->request->getPost('name'),
            'role_key'    => $this->request->getPost('role_key'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/roles')
            ->with('success','Role berhasil ditambahkan');
    }

    // =============================
    // FORM EDIT ROLE
    // =============================
    public function edit($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->back()->with('error','Role tidak ditemukan');
        }

        return view('admin/roles/edit', [
            'role' => $role
        ]);
    }

    // =============================
    // UPDATE ROLE
    // =============================
    public function update($id)
    {
        $this->roleModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'role_key'    => $this->request->getPost('role_key'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/roles')
            ->with('success','Role berhasil diperbarui');
    }

    // =============================
    // DELETE ROLE
    // =============================
    public function delete($id)
    {
        $this->roleModel->delete($id);

        return redirect()->to('/roles')
            ->with('success','Role berhasil dihapus');
    }
}
