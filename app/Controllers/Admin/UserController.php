<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\Admin\UserService;

class UserController extends BaseController
{
    protected $userModel;
    protected $service;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->menuId = $this->setMenu('users');
        $this->service = new UserService();
    }

    public function index()
    {
        $this->setMenu('users');
        return $this->view('admin/users/index');
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
    public function create()
    {
        return view('admin/users/create', [
            'roles' => db_connect()->table('roles')->where(['name !=' => 'Superadmin'])->get()->getResult()
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        if (! $this->service->validateCreate($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->service->getErrors());
        }

        try {
            $this->service->create($data);
            return redirect()->to('/users')
                ->with('success', 'User berhasil ditambah');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambah user: ' . $e->getMessage());
        }
    }



    public function edit($id)
    {

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error','User tidak ditemukan');
        }

        return view('admin/users/edit', [
            'user'  => $user,
            'roles' => db_connect()->table('roles')->where(['name !=' => 'Superadmin'])->get()->getResult()
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if (! $this->service->validateUpdate($data, $id)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->service->getErrors());
        }

        try {
            $this->service->update($id, $data);
            return redirect()->to('/users')
                ->with('success', 'User berhasil diperbarui');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Eksekusi penghapusan melalui service
            $this->service->deleteUser($id);

            return redirect()->to(base_url('users'))
                ->with('success', 'Data user berhasil dihapus.');
        } catch (\Throwable $e) {
            // Tangkap pesan error jika data tidak ditemukan atau gagal hapus
            return redirect()->to(base_url('users'))
                ->with('error', $e->getMessage());
        }
    }


}
