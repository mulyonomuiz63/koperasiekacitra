<?php

namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Services\Pengguna\PembayaranService;

class PembayaranController extends BaseController
{
    protected $service;
    public function __construct()
    {
        $this->service = new PembayaranService();
    }

    public function proses()
    {
        try {
            $data = $this->request->getPost();
            $result = $this->service->prosesPembayaran($data);

            return $this->response->setJSON(array_merge($result, [
                'csrfHash' => csrf_hash()
            ]));

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => $e->getMessage(),
                'csrfHash' => csrf_hash()
            ]);
        }
    }

    public function uploadBukti()
    {
        try {
            $pembayaranId = $this->request->getPost('pembayaran_id');
            $file         = $this->request->getFile('bukti_bayar');

            $result = $this->service->uploadBuktiPembayaran($pembayaranId, $file);

            if ($result['status'] === 'success') {
                return redirect()->back()->with('success', $result['message']);
            }

            return redirect()->back()->with('error', $result['message']);

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
