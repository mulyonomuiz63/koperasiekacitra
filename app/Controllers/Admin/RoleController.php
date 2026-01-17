<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $menuId;


    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->menuId = $this->setMenu('roles');
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
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }


        $request = $this->request->getPost();
        $result  = $this->roleModel->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {

            $data[] = [
                'id'         => $row['id'],
                'name'       => $row['name'],
                'description' => $row['description'],
                
                // 🔐 PERMISSION (INTI)
                'can_edit'   => can($this->menuId, 'update'),
                'can_delete' => can($this->menuId, 'delete'),
            ];
        }


        return $this->response->setJSON([
            'draw'            => intval($request['draw']),
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ]);
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
