<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;

class JabatanController extends BaseController
{
    protected $jabatan;
    protected $menuId;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->menuId = $this->setMenu('jabatan');
    }

    public function index()
    {
        return $this->view('admin/jabatan/index');
    }

    public function datatable()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }


        $request = $this->request->getPost();
        $result  = $this->jabatan->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {

            $data[] = [
                'id'                    => $row['id'],
                'nama_jabatan'          => $row['nama_jabatan'],
                'keterangan'            => $row['keterangan'],
                
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

    public function create()
    {
        return view('admin/jabatan/create');
    }

    public function store()
    {
        $this->jabatan->insert($this->request->getPost());
        return redirect()->to('/jabatan')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin/jabatan/edit', [
            'jabatan' => $this->jabatan->find($id),
        ]);
    }

    public function update($id)
    {
        $this->jabatan->update($id, $this->request->getPost());
        return redirect()->to('/jabatan')->with('success', 'Jabatan berhasil diupdate');
    }

    public function delete($id)
    {
        // Pastikan data ada
        $jabatan = $this->jabatan->find($id);

        if (!$jabatan) {
            return redirect()->back()->with('error', 'Jabatan tidak ditemukan');
        }

        // Hapus parent + semua child
        $this->jabatan->delete($id);

        return redirect()->back()->with('success', 'Jabatan berhasil dihapus');
    }

}
