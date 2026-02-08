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
        try {
            $data = $this->request->getPost();

            // Eksekusi via service
            $this->service->createRole($data);

            return redirect()->to('/roles')
                ->with('success', 'Role berhasil ditambahkan');
        } catch (\Throwable $e) {
            // Tangkap error jika role_key sudah ada atau masalah DB lainnya
            return redirect()->to('/roles/create')->withInput()
                ->with('error', 'Gagal menambah role: ' . $e->getMessage());
        }
    }

    // =============================
    // FORM EDIT ROLE
    // =============================
    public function edit($id)
    {
        try {
            $role = $this->service->getRoleById($id);

            return view('admin/roles/edit', [
                'role' => $role
            ]);
        } catch (\Throwable $e) {
            return redirect()->to('/roles')->with('error', $e->getMessage());
        }
    }

    // =============================
    // UPDATE ROLE
    // =============================
    public function update($id)
    {
        try {
            $data = $this->request->getPost();

            // Kirim data ke service untuk diproses
            $this->service->updateRole($id, $data);

            return redirect()->to('/roles')
                ->with('success', 'Role berhasil diperbarui');
        } catch (\Throwable $e) {
            // Jika gagal, kembali dengan input sebelumnya dan pesan error
            return redirect()->to('/roles/edit/'.$id)
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // =============================
    // DELETE ROLE
    // =============================
    public function delete($id)
    {
        try {
            // Eksekusi penghapusan aman melalui service
            $this->service->deleteRole($id);

            return redirect()->to('/roles')
                ->with('success', 'Role berhasil dihapus');
        } catch (\Throwable $e) {
            // Jika gagal karena proteksi sistem atau relasi data
            return redirect()->to('/roles')
                ->with('error', $e->getMessage());
        }
    }
}
