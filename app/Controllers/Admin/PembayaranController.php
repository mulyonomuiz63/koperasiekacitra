<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PembayaranModel;
use App\Services\Admin\PembayaranService;
use Config\Database;

class PembayaranController extends BaseController
{
    protected $pembayaran;
    protected $pegawai;
    protected $menuId;
    protected $service;
    protected $db;

    public function __construct()
    {
        $this->db         = Database::connect();
        $this->pembayaran = new PembayaranModel();
        $this->pegawai = new PegawaiModel();
        $this->menuId = $this->setMenu('pembayaran');
        $this->service = new PembayaranService();

    }

    public function index()
    {
        return $this->view('admin/pembayaran/index');
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

   
    public function edit($id)
    {
        $data = $this->service->getEditData($id);

        if (empty($data['pembayaran'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Data pembayaran tidak ditemukan'
            );
        }

        return view('admin/pembayaran/edit', $data);
    }

    public function update($id)
    {
        try {
            $data = $this->request->getPost();
            $this->service->updateStatus(
                $id,
                $data['status'],
                $data['reject_reason'] ?? null
            );

            return redirect()->to(base_url('pembayaran'))
                ->with('success', 'Pembayaran berhasil diproses');

        } catch (\Throwable $e) {

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
