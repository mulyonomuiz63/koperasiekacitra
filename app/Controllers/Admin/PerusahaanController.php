<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;
use App\Services\Admin\PerusahaanService;

class PerusahaanController extends BaseController
{
    protected $perusahaan;
    protected $menuId;
    protected $service;

    public function __construct()
    {
        $this->perusahaan = new PerusahaanModel();
        $this->menuId = $this->setMenu('perusahaan');
        $this->service = new PerusahaanService();
    }

    public function index()
    {
        return $this->view('admin/perusahaan/index');
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
