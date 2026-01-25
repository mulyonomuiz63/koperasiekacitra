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
        $this->iuranBulanan->insert($this->request->getPost());
        return redirect()->to('/iuran-bulanan')->with('success', 'Iuran Bulanan berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('anggota/iuran_bulanan/edit', [
            'iuranBulanan' => $this->iuranBulanan->find($id),
        ]);
    }

    public function update($id)
    {
        $this->iuranBulanan->update($id, $this->request->getPost());
        return redirect()->to('/iuran-bulanan')->with('success', 'Iuran Bulanan berhasil diupdate');
    }
}
