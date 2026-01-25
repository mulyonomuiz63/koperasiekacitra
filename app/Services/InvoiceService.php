<?php

namespace App\Services;

use App\Models\PembayaranModel;
use App\Models\PembayaranDetailModel;

class InvoiceService
{
    protected PembayaranModel $pembayaranModel;
    protected PembayaranDetailModel $detailModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->detailModel     = new PembayaranDetailModel();
    }

    /**
     * Ambil data invoice lengkap
     */
    public function getInvoiceData(string $pembayaranId): array
    {
        $pembayaran = $this->pembayaranModel
            ->getPembayaranWithPegawai($pembayaranId);

        if (! $pembayaran) {
            throw new \RuntimeException('Pembayaran tidak ditemukan');
        }

        $detail = $this->detailModel
            ->getDetailByPembayaran($pembayaranId);

        return [
            'pembayaran' => $pembayaran,
            'detail'     => $detail,
        ];
    }
}
