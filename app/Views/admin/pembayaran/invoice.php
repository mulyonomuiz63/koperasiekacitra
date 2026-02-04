<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="d-flex flex-stack d-print-none mb-5">
        <div class="d-flex align-items-center">
            <a href="<?= base_url('pembayaran') ?>" class="btn btn-light-primary btn-sm me-3">
                <i class="ki-outline ki-arrow-left fs-3"></i> Kembali
            </a>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary btn-sm" onclick="window.print();">
                <i class="ki-outline ki-printer fs-3"></i> Cetak Invoice
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-lg-20">
            <div class="d-flex flex-column flex-sm-row justify-content-between mb-15">
                <div class="mb-5 mb-sm-0">
                    <h1 class="fw-boldest text-success mb-2" style="font-size: 2.5rem;">KOPERASI EKA CITRA</h1>
                    <div class="text-gray-600 fw-semibold fs-7">
                        <?= setting('alamat_perusahaan') ?><br>
                        Email: <?= setting('app_email') ?> | Telp: <?= setting('app_phone') ?>
                    </div>
                </div>
                <div class="text-sm-end">
                    <h1 class="fw-boldest text-gray-800" style="font-size: 3rem;">INVOICE</h1>
                    <div class="text-gray-700 fw-bolder fs-4">#INV-<?= $pembayaran['invoice_no'] ?></div>
                </div>
            </div>

            <div class="row g-5 mb-15">
                <div class="col-sm-6">
                    <div class="fw-bold fs-7 text-gray-500 text-uppercase mb-2">Ditagihkan Kepada:</div>
                    <div class="fs-4 fw-boldest text-gray-800 mb-1"><?= esc($pembayaran['nama_pegawai']) ?></div>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <div class="fw-bold fs-7 text-gray-500 text-uppercase mb-2">Detail Pembayaran:</div>
                    <div class="fw-semibold fs-7 text-gray-600">
                        Tanggal Terbit: <span class="text-gray-800 fw-bold"><?= $pembayaran['validated_at'] ?></span><br>
                        Metode: <span class="text-gray-800 fw-bold text-uppercase">Transfer Bank</span><br>
                        Status: <span class="badge badge-light-success fw-bold">LUNAS</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-15">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-300px">Deskripsi Layanan/Pendaftaran</th>
                            <th class="min-w-100px text-end">Jumlah</th>
                            <th class="min-w-150px text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 fw-semibold">
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-0">
                                        <div class="fs-6 fw-bold text-gray-800 text-hover-primary">Pendaftaran Anggota Koperasi</div>
                                        <div class="fs-7 text-muted">Periode pembayaran tanggal <?= date('d/m/Y', strtotime($pembayaran['tgl_bayar'])) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">1x</td>
                            <td class="text-end fw-boldest text-gray-900">Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <div class="mw-300px w-100">
                    <div class="d-flex flex-stack mb-3">
                        <div class="fw-semibold fs-6 text-gray-600">Subtotal:</div>
                        <div class="fw-bold fs-6 text-gray-800">Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?></div>
                    </div>
                    <div class="d-flex flex-stack mb-3">
                        <div class="fw-semibold fs-6 text-gray-600">Pajak (0%):</div>
                        <div class="fw-bold fs-6 text-gray-800">Rp 0</div>
                    </div>
                    <div class="separator separator-dashed border-gray-300 my-3"></div>
                    <div class="d-flex flex-stack">
                        <div class="fw-boldest fs-3 text-gray-800">Grand Total:</div>
                        <div class="fw-boldest fs-3 text-success">Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-between mt-20">
                <div class="mb-10 mb-sm-0">
                    <div class="text-gray-500 fs-7 italic mb-2 italic">Catatan:</div>
                    <div class="text-gray-600 fs-8 fw-semibold border-start border-3 border-success ps-4">
                        Bukti ini sah dan dihasilkan secara otomatis oleh sistem.<br>
                        Terima kasih atas kontribusi Anda terhadap koperasi.
                    </div>
                </div>
                <div class="text-center" style="min-width: 200px;">
                    <div class="position-relative d-inline-block">
                        <div class="text-success opacity-25 fw-boldest fs-1 position-absolute top-0 start-50 translate-middle" style="transform: rotate(-15deg) !important; border: 4px solid; padding: 10px; border-radius: 10px; pointer-events: none;">PAID</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .container, .container * { visibility: visible; }
    .container { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
    .d-print-none { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>

<?= $this->endSection() ?>