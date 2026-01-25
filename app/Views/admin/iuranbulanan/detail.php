<?= $this->extend('pages/layout') ?>
<?= $this->section('style') ?>
<style>
@media print {

    body * {
        visibility: hidden !important;
    }

    #invoice-print-area,
    #invoice-print-area * {
        visibility: visible !important;
    }

    #invoice-print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
    }

    /* Hilangkan button */
    .btn,
    .card-header,
    .no-print {
        display: none !important;
    }

    /* Paksa 1 halaman */
    @page {
        size: A4;
        margin: 15mm;
    }

    html, body {
        height: auto;
        overflow: hidden;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-body py-20">

        <div class="mw-lg-950px mx-auto w-100">
            <div id="invoice-print-area">
                <!-- ================= HEADER ================= -->
                <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                    <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">
                        <?= $pembayaran['status'] === 'A'
                            ? 'INVOICE PEMBAYARAN'
                            : 'INVOICE TAGIHAN' ?>
                    </h4>

                    <div class="text-sm-end">
                        <div class="mt-7">
                            <?php if (!empty($pembayaran['invoice_no'])): ?>
                                <div class="fw-bolder fs-5 text-gray-800 mb-1">
                                    Invoice #<?= esc($pembayaran['invoice_no']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="fw-semibold fs-6 text-gray-600">
                                <?= esc($pembayaran['nama_pegawai']) ?>
                            </div>

                            <?php if (!empty($pembayaran['validated_at'])): ?>
                                <div class="fs-7 text-muted">
                                    <?= tglIndo($pembayaran['validated_at']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ================= BODY ================= -->
                <div class="border-bottom pb-12">

                    <!-- LIST IURAN -->
                    <div class="table-responsive border-bottom mb-14">
                        <table class="table">
                            <thead>
                                <tr class="border-bottom fs-6 fw-bold text-muted text-uppercase">
                                    <th>Periode Iuran</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detail as $item): ?>
                                    <tr class="fw-semibold text-gray-700 fs-6">
                                        <td><?= bulanIndo($item['bulan']) ?> <?= $item['tahun'] ?></td>
                                        <td class="text-end fw-bolder text-dark">
                                            Rp <?= number_format($item['jumlah_bayar'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ================= PAYMENT INFORMATION ================= -->
                    <div class="row g-5 mb-10">

                        <!-- BUKTI PEMBAYARAN -->
                        <div class="col-md-7">
                            <div class="card card-flush h-100">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Bukti Pembayaran</h3>
                                </div>

                                <div class="card-body text-center">

                                    <?php if (! empty($pembayaran['bukti_bayar'])): ?>
                                        <a href="<?= base_url('uploads/bukti-bayar/' . $pembayaran['bukti_bayar']) ?>"
                                        target="_blank">

                                            <img src="<?= base_url('uploads/bukti-bayar/' . $pembayaran['bukti_bayar']) ?>"
                                                class="img-fluid rounded shadow-sm"
                                                style="max-height: 420px;"
                                                alt="Bukti Pembayaran">
                                        </a>

                                        <div class="mt-4 fs-7 text-muted">
                                            Klik gambar untuk memperbesar
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted fs-6">
                                            Bukti pembayaran belum tersedia
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                        <!-- RINGKASAN -->
                        <div class="col-md-5">
                            <div class="card card-flush h-100 bg-light">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Ringkasan Pembayaran</h3>
                                </div>

                                <div class="card-body text-center">

                                    <div class="text-muted fw-semibold mb-2">
                                        TOTAL TAGIHAN
                                    </div>

                                    <div class="fs-1 fw-bolder text-dark mb-5">
                                        Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>
                                    </div>

                                    <?php
                                        $badge = [
                                            'P' => ['warning', 'Menunggu Pembayaran'],
                                            'V' => ['info', 'Menunggu Verifikasi'],
                                            'A' => ['success', 'LUNAS'],
                                            'R' => ['danger', 'Ditolak'],
                                        ];
                                        [$color, $label] = $badge[$pembayaran['status']] ?? ['secondary', 'Unknown'];
                                    ?>

                                    <span class="badge badge-light-<?= $color ?> fs-7 px-5 py-3">
                                        <?= $label ?>
                                    </span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= FORM VERIFIKASI ================= -->
                <?php if ($pembayaran['status'] === 'V'): ?>
                <div class="card card-flush mt-10">
                    <div class="card-header">
                        <h3 class="card-title fw-bold">Verifikasi Pembayaran</h3>
                    </div>

                    <div class="card-body">

                        <form action="<?= base_url('iuran-bulanan/verifikasi') ?>"
                              method="post">

                            <?= csrf_field() ?>

                            <input type="hidden"
                                   name="pembayaran_id"
                                   value="<?= $pembayaran['id'] ?>">

                            <div class="mb-7">
                                <label class="form-label fw-semibold">
                                    Catatan Verifikasi (Opsional)
                                </label>
                                <textarea name="catatan"
                                          class="form-control"
                                          rows="4"
                                          placeholder="Contoh: Bukti pembayaran valid dan sesuai nominal"></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <button type="submit"
                                        name="aksi"
                                        value="tolak"
                                        class="btn btn-light-danger">
                                    Tolak Pembayaran
                                </button>

                                <button type="submit"
                                        name="aksi"
                                        value="setujui"
                                        class="btn btn-success">
                                    Setujui Pembayaran
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- ================= FOOTER ================= -->
            <?php if ($pembayaran['status'] === 'A'): ?>
                <div class="d-flex flex-stack flex-wrap mt-20 pt-13">

                    <button type="button"
                            class="btn btn-success me-3"
                            onclick="window.print()">
                        Print Invoice
                    </button>

                    <a href="<?= base_url('iuran-bulanan/download/' . $pembayaran['id']) ?>"
                       class="btn btn-light-success">
                        Download Invoice
                    </a>

                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
