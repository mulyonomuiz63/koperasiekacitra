<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;

class PerusahaanController extends BaseController
{
    protected $perusahaan;
    protected $menuId;

    public function __construct()
    {
        $this->perusahaan = new PerusahaanModel();
        $this->menuId = $this->setMenu('perusahaan');
    }

    public function index()
    {
        return $this->view('admin/perusahaan/index');
    }

    public function datatable()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }


        $request = $this->request->getPost();
        $result  = $this->perusahaan->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {

            $data[] = [
                'id'                    => $row['id'],
                'nama_perusahaan'       => $row['nama_perusahaan'],
                'alamat'                => $row['alamat'],
                
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
        return view('admin/perusahaan/create');
    }

    public function store()
    {
        $this->perusahaan->insert($this->request->getPost());
        return redirect()->to('/perusahaan')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin/perusahaan/edit', [
            'perusahaan' => $this->perusahaan->find($id),
        ]);
    }

    public function update($id)
    {
        $this->perusahaan->update($id, $this->request->getPost());
        return redirect()->to('/perusahaan')->with('success', 'Perusahaan berhasil diupdate');
    }

    public function delete($id)
    {
        // Pastikan data ada
        $perusahaan = $this->perusahaan->find($id);

        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Perusahaan tidak ditemukan');
        }

        // Hapus parent + semua child
        $this->perusahaan->delete($id);

        return redirect()->back()->with('success', 'Perusahaan berhasil dihapus');
    }

}
