<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\PdfService;
use App\Models\PembayaranModel;
use App\Services\Admin\IuranBulananService;

class IuranBulananController extends BaseController
{
    protected $menuId;
    protected $service;

    public function __construct()
    {
        $this->service = new IuranBulananService();
        $this->menuId = $this->setMenu('iuran-bulanan');
    }

    public function index()
    {
        return $this->view('admin/iuranbulanan/index');
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

     // =============================
    // HISTORI PEMBAYARAN
    public function detail($id)
    {
        $data = $this->service->getPembayaranDetail($id);
        if (!$data['pembayaran']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        // contoh rekening statis (nanti bisa dari tabel bank)
        $data['rekening'] = [
            'bank'   => setting('nama_bank'),
            'no'     => setting('norek'),
            'nama'   => setting('nama_pemilik')
        ];
        return view('admin/iuranbulanan/detail', $data);
    }

    public function verifikasi()
    {
        try {
            $message = $this->service->verifikasi(
                (string) $this->request->getPost('pembayaran_id'),
                (string) $this->request->getPost('aksi'),
                $this->request->getPost('catatan')
            );
            return redirect()->back()->with('success', $message);

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function download($id)
    {
        $data = $this->service->getPembayaranDetail($id);
        if (!$data['pembayaran']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

     
        $pdf = new PdfService();

        return $pdf->render('pdf/invoice', $data, 'invoice-' . $id . '.pdf');
    }
}
