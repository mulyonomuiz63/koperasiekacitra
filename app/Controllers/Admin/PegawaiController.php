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
        return view('admin/pegawai/create', [
            'users'      => $this->user
                            ->whereNotIn('id', function ($builder) {
                                return $builder->select('user_id')->from('pegawai');
                            })->findAll(),
            'perusahaan' => $this->perusahaan->findAll(),
            'jabatan'    => $this->jabatan->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        if (! $this->validasi->validateCreate($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validasi->getErrors());
        }
        $this->pegawai->insert($this->request->getPost());

        return redirect()->to('/pegawai')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
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

        if (! $this->validasi->validateUpdate($data, $id)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validasi->getErrors());
        }

        $data = [
            'nip'            => $this->request->getPost('nip'),
            'nama'           => $this->request->getPost('nama'),
            'jenis_kelamin'  => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir'  => $this->request->getPost('tanggal_lahir'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'perusahaan_id'  => $this->request->getPost('perusahaan_id'),
            'jabatan_id'     => $this->request->getPost('jabatan_id'),
            'tanggal_masuk'  => $this->request->getPost('tanggal_masuk'),
            'status'         => $this->request->getPost('status'),
            'status_iuran'   => $this->request->getPost('status_iuran'),
            'alamat'         => $this->request->getPost('alamat'),
        ];

        $this->pegawai->update($id, $data);

        return redirect()->to('/pegawai')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /* =========================
     * DELETE
     * ========================= */
    public function delete($id)
    {
        $this->pegawai->delete($id);
        return redirect()->back()->with('success', 'Pegawai berhasil dihapus');
    }
}
