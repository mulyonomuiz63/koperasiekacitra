<?php
namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Libraries\PdfService;
use App\Models\PembayaranModel;
use App\Services\InvoiceService;
use App\Services\Pengguna\HistoriService;
use CodeIgniter\Exceptions\PageNotFoundException;

class HistoriController extends BaseController
{
    protected $pembayaran;
    protected $invoiceService;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->pembayaran = new PembayaranModel();
        $this->invoiceService = new InvoiceService();
        $this->menuId = $this->setMenu('histori-iuran');
        $this->service = new HistoriService();
    }

    public function index()
    {
        return $this->view('anggota/histori/index');
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
    public function histori($id)
    {
        try {
            $data = $this->service->getHistoriDetail((int) $id);

            return view('anggota/histori/detail', $data);

        } catch (PageNotFoundException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menampilkan histori pembayaran.');
        }
    }

    public function download($id)
    {
            $data = $this->invoiceService->getInvoiceData($id);

            $data['title']     = 'Invoice Pembayaran';
            $data['header']    = 'INVOICE PEMBAYARAN';
            $data['subheader'] = 'Sistem Iuran Bulanan';
            $data['footer']    = 'Dokumen resmi';

            $pdf = new PdfService();

            return $pdf->render('pdf/invoice', $data, 'invoice-' . $id . '.pdf');

    }
}
