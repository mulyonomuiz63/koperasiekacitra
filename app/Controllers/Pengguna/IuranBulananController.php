<?php

namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Models\IuranBulananModel;
use App\Services\Pengguna\IuranBulananService;

class IuranBulananController extends BaseController
{
    protected $iuranBulanan;
    protected $menuId;
    protected $service;
    public function __construct()
    {
        $this->iuranBulanan = new IuranBulananModel();
        $this->menuId = $this->setMenu('iuran-bulanan');
        $this->service = new IuranBulananService();
    }

    public function index()
    {
        return $this->view('anggota/iuran_bulanan/index');
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
        return view('anggota/iuran_bulanan/create');
    }

    public function store()
    {
        try {
            $data = $this->request->getPost();

            // Kirim data ke service
            $this->service->createIuran($data);

            return redirect()->to('/iuran-bulanan')
                ->with('success', 'Iuran Bulanan berhasil ditambahkan');
        } catch (\Throwable $e) {
            // Jika ada error (misal: data tidak valid atau db error)
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            // Ambil data melalui service
            $data['iuranBulanan'] = $this->service->getIuranById($id);

            return view('anggota/iuran_bulanan/edit', $data);
        } catch (\Throwable $e) {
            // Jika ID salah atau data sudah divalidasi (jika logika tambahan diaktifkan)
            return redirect()->to('/iuran-bulanan')->with('error', $e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            $data = $this->request->getPost();

            // Eksekusi update melalui service
            $this->service->updateIuran($id, $data);

            return redirect()->to('/iuran-bulanan')
                ->with('success', 'Iuran Bulanan berhasil diperbarui');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
