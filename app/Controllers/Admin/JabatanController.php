<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Services\Admin\JabatanService;

class JabatanController extends BaseController
{
    protected $jabatan;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->service = new JabatanService();
        $this->menuId = $this->setMenu('jabatan');
    }

    public function index()
    {
        return $this->view('admin/jabatan/index');
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
        return view('admin/jabatan/create');
    }

    public function store()
    {
        try {
            // Ambil data dari post
            $data = $this->request->getPost();

            // Panggil service
            $this->service->createJabatan($data);

            return redirect()->to('/jabatan')->with('success', 'Jabatan berhasil ditambahkan');
        } catch (\Throwable $e) {
            // Tangkap jika ada error database atau logika
            return redirect()->to('/jabatan/create')->withInput()->with('error', 'Gagal menambah jabatan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin/jabatan/edit', [
            'jabatan' => $this->jabatan->find($id),
        ]);
    }

    public function update($id)
    {
        try {
            $data = $this->request->getPost();

            // Panggil service
            $this->service->updateJabatan($id, $data);

            return redirect()->to('/jabatan')->with('success', 'Jabatan berhasil diupdate');
        } catch (\Throwable $e) {
            // Kembali ke form sebelumnya jika gagal
            return redirect()->to('/jabatan/edit/'. $id)->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Pastikan data ada
        $jabatan = $this->jabatan->find($id);

        if (!$jabatan) {
            return redirect()->to('/jabatan')->with('error', 'Jabatan tidak ditemukan');
        }

        // Hapus parent + semua child
        $this->jabatan->delete($id);

        return redirect()->to('/jabatan')->with('success', 'Jabatan berhasil dihapus');
    }
}
