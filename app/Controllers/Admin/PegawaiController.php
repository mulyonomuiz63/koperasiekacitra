<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\PerusahaanModel;
use App\Models\JabatanModel;

class PegawaiController extends BaseController
{
    protected $user;
    protected $pegawai;
    protected $perusahaan;
    protected $jabatan;
    protected $menuId;

    public function __construct()
    {
        $this->menuId = $this->setMenu('pegawai');
        $this->user = new UserModel();
        $this->pegawai = new PegawaiModel();
        $this->perusahaan = new PerusahaanModel();
        $this->jabatan = new JabatanModel();
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
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }


        $request = $this->request->getPost();
        $result  = $this->pegawai->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {

            $data[] = [
                'id'         => $row['id'],
                'namaPegawai'       => $row['namaPegawai'],
                'perusahaan' => $row['nama_perusahaan'],
                'jabatan'    => $row['nama_jabatan'],

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
        $rules = [
            'user_id' => [
                'rules'  => 'required|is_unique[pegawai.user_id]',
                'errors' => [
                    'required'  => 'User wajib dipilih.',
                    'is_unique' => 'User sudah terdaftar sebagai pegawai.'
                ]
            ],
            'nip' => [
                'rules'  => 'permit_empty|is_unique[pegawai.nip]',
                'errors' => [
                    'is_unique' => 'NIP sudah digunakan.'
                ]
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ]
            ],
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp'          => 'required',
            'perusahaan_id'  => 'required',
            'jabatan_id'     => 'required',
            'tanggal_masuk'  => 'required',
            'status'         => 'required',
            'alamat'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
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
        $pegawai = $this->pegawai
            ->select('pegawai.*, users.username')
            ->join('users', 'users.id = pegawai.user_id')
            ->find($id);

        if (!$pegawai) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pegawai tidak ditemukan');
        }

        $data = [
            'pegawai'    => $pegawai,
            'perusahaan' => $this->perusahaan->findAll(),
            'jabatan'    => $this->jabatan->findAll(),
        ];

        return view('admin/pegawai/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nip' => [
                'rules'  => "permit_empty|is_unique[pegawai.nip,id,{$id}]",
                'errors' => [
                    'is_unique' => 'NIP sudah digunakan.'
                ]
            ],
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp'          => 'required',
            'perusahaan_id'  => 'required',
            'jabatan_id'     => 'required',
            'tanggal_masuk'  => 'required',
            'status'         => 'required',
            'alamat'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
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
