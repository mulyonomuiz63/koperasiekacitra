<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\PerusahaanModel;
use App\Models\JabatanModel;
use App\Services\Admin\PegawaiService;
use App\Services\Validation\PegawaiValidationService;

class PegawaiController extends BaseController
{
    protected $user;
    protected $pegawai;
    protected $perusahaan;
    protected $jabatan;
    protected $menuId;
    protected $service;
    protected $validasi;

    public function __construct()
    {
        $this->menuId = $this->setMenu('pegawai');
        $this->user = new UserModel();
        $this->pegawai = new PegawaiModel();
        $this->perusahaan = new PerusahaanModel();
        $this->jabatan = new JabatanModel();
        $this->service = new PegawaiService();
        $this->validasi = new PegawaiValidationService();
    }

    /* =========================
     * INDEX
     * ========================= */
    public function index()
    {
        $this->setMenu('pegawai');
        return $this->view('admin/pegawai/index');
    }

    /* =========================
     * DATATABLE
     * ========================= */
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

    /* =========================
     * CREATE
     * ========================= */
    public function create()
    {
        // Mengambil data yang sudah difilter dari Service
        $data = $this->service->getCreateData();

        return view('admin/pegawai/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        // 1. Validasi tetap di Controller agar mudah handling redirect back + errors
        if (!$this->validasi->validateCreate($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validasi->getErrors());
        }

        try {
            // 2. Eksekusi simpan melalui Service
            $this->service->createPegawai($data);

            return redirect()->to('/pegawai')
                ->with('success', 'Data pegawai berhasil ditambahkan.');
        } catch (\Throwable $e) {
            // 3. Tangkap error jika terjadi kegagalan di level Service/Database
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    /* =========================
     * EDIT
     * ========================= */
    public function edit($id)
    {
        $data = $this->service->getEditData($id);

        if (empty($data['pegawai'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Data pegawai tidak ditemukan'
            );
        }

        return view('admin/pegawai/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        // 1. Validasi tetap di Controller
        if (!$this->validasi->validateUpdate($data, $id)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validasi->getErrors());
        }

        try {
            // 2. Serahkan pemetaan data dan proses update ke Service
            $this->pegawai->updatePegawai($id, $data);

            return redirect()->to('/pegawai')
                ->with('success', 'Data pegawai berhasil diperbarui.');
        } catch (\Throwable $e) {
            // 3. Tangkap error jika ID tidak ditemukan atau terjadi masalah database
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
    /* =========================
     * DELETE
     * ========================= */
    public function delete($id)
    {
        try {
            // Panggil service
            $this->service->deletePegawai($id);

            return redirect()->back()->with('success', 'Pegawai berhasil dihapus');
        } catch (\Throwable $e) {
            // Tangkap pesan error jika ID tidak valid
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
