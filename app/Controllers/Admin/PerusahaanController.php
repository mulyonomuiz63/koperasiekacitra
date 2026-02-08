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
        try {
            $data = $this->request->getPost();

            // Panggil service untuk eksekusi
            $this->service->createPerusahaan($data);

            return redirect()->to('/perusahaan')->with('success', 'Data perusahaan berhasil ditambahkan');
        } catch (\Throwable $e) {
            // Tangkap jika ada error
            return redirect()->to('/perusahaan/create')->withInput()->with('error', 'Gagal menambah perusahaan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin/perusahaan/edit', [
            'perusahaan' => $this->perusahaan->find($id),
        ]);
    }

    public function update($id)
    {
        try {
            $data = $this->request->getPost();

            // Panggil service
            $this->service->updatePerusahaan($id, $data);

            return redirect()->to('/perusahaan')->with('success', 'Perusahaan berhasil diupdate');
        } catch (\Throwable $e) {
            // Kembali ke form dengan pesan error yang jelas
            return redirect()->to('/perusahaan/edit/'.$id)->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Panggil logika hapus dari service
            $this->service->deletePerusahaan($id);

            return redirect()->to('/perusahaan')->with('success', 'Perusahaan berhasil dihapus');
        } catch (\Throwable $e) {
            // Tangkap pesan error (ID tidak ada atau masih ada pegawai)
            return redirect()->to('/perusahaan')->with('error', $e->getMessage());
        }
    }
}
