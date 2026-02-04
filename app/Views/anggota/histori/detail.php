<?= $this->extend('pages/layoutAnggota') ?>
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

        html,
        body {
            height: auto;
            overflow: hidden;
        }
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card  card-flush">
    <div class="card-body py-20">

        <div class="mw-lg-950px mx-auto w-100">
            <div id="invoice-print-area">
                <!-- HEADER -->
                <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                    <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">
                        <?php
                        if ($pembayaran['status'] === 'A'):
                            echo 'INVOICE PEMBAYARAN';
                        else:
                            echo 'INVOICE TAGIHAN';
                        endif;
                        ?>
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

                <!-- BODY -->
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
                                        <td>
                                            <?= bulanIndo($item['bulan']) ?> <?= $item['tahun'] ?>
                                        </td>
                                        <td class="text-end fw-bolder text-dark">
                                            Rp <?= number_format($item['jumlah_bayar'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- PAYMENT INFORMATION -->
                    <div class="card border-0 shadow rounded-3 mb-5 
                        <?= $pembayaran['status'] === 'P' ? 'border-start border-4 border-warning' : '' ?>">

                        <div class="card shadow-sm mb-5">
                            <div class="card-body p-5">
                                <div class="row g-4">

                                    <?php if ($pembayaran['status'] !== 'A'): ?>
                                        <div class="col-md-7">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="symbol symbol-45px symbol-circle bg-light-primary me-3">
                                                    <i class="ki-outline ki-wallet fs-2 text-primary"></i>
                                                </div>
                                                <div>
                                                    <h4 class="fw-bold mb-0 text-dark">Metode Pembayaran</h4>
                                                    <span class="text-muted fs-7">Silakan transfer ke rekening berikut</span>
                                                </div>
                                            </div>

                                            <div class="border rounded-3 p-4">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Bank</span>
                                                    <span class="fw-semibold"><?= $rekening['bank'] ?></span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">No. Rekening</span>
                                                    <span class="fw-bold text-primary"><?= $rekening['no'] ?></span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Atas Nama</span>
                                                    <span class="fw-semibold"><?= $rekening['nama'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="col-md-7">
                                            <div class="border border-dashed border-success rounded-3 p-9 h-100 d-flex flex-column flex-center bg-light-success">
                                                <i class="ki-outline ki-check-circle fs-3x text-success mb-2"></i>
                                                <div class="fw-bolder text-success fs-4">Pembayaran Lunas</div>
                                                <div class="text-muted fs-7">Terima kasih, pesanan Anda sedang kami proses.</div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-md-5">
                                        <div class="bg-light rounded-3 p-4 h-100 text-center d-flex flex-column flex-center">
                                            <div class="text-muted fw-semibold mb-2">TOTAL TAGIHAN</div>
                                            <div class="fs-1 fw-bolder text-dark mb-3">
                                                Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>
                                            </div>

                                            <?php if ($pembayaran['status'] === 'P'): ?>
                                                <span class="badge badge-light-warning fs-7 px-4 py-2">Menunggu Pembayaran</span>
                                            <?php elseif ($pembayaran['status'] === 'V'): ?>
                                                <span class="badge badge-light-info fs-7 px-4 py-2">Sedang Diverifikasi</span>
                                            <?php elseif ($pembayaran['status'] === 'A'): ?>
                                                <span class="badge badge-light-success fs-7 px-4 py-2">Lunas</span>
                                            <?php else: ?>
                                                <span class="badge badge-light-danger fs-7 px-4 py-2">Pembayaran Gagal</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- UPLOAD BUKTI -->
            <?php if (empty($pembayaran['bukti_bayar']) && $pembayaran['status'] === 'P'): ?>
                <div class="mt-15">

                    <h4 class="fw-bold mb-5">Upload Bukti Pembayaran</h4>
                    <form action="<?= base_url('sw-anggota/pembayaran/upload-bukti') ?>" method="post" enctype="multipart/form-data">

                        <?= csrf_field() ?>
                        <input type="hidden" name="pembayaran_id" value="<?= $pembayaran['id'] ?>">

                        <div class="row g-5">
                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Tanggal Bayar</label>
                                <input type="text" name="tgl_bayar" class="form-control form-control-solid datepicker-indo"
                                    value="<?= $pembayaran['tgl_bayar'] ?>" required>
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fs-6 fw-semibold mb-2">Nama Pengirim</label>
                                <input type="text" name="nama_pengirim" class="form-control form-control-solid"
                                    placeholder="Nama di rekening/struk"
                                    value="<?= $pembayaran['nama_pengirim'] ?>" required>
                            </div>
                        </div>

                        <div class="fv-row mt-8">
                            <label class="fs-6 fw-semibold mb-2">Unggah Bukti Transfer</label>

                            <label for="buktiBayar" id="uploadBox"
                                class="card card-dashed h-250px w-100 d-flex flex-center cursor-pointer border-primary bg-light-primary border-2">

                                <div id="previewContainer" class="d-none text-center p-5">
                                    <img id="imagePreview" src="#" alt="Preview" class="rounded shadow-sm mb-3" style="max-height: 150px; width: auto;">
                                    <div id="fileNameDisplay" class="fs-7 fw-bold text-primary"></div>
                                </div>

                                <div class="text-center" id="uploadContent">
                                    <i class="bi bi-cloud-arrow-up fs-3x text-primary mb-3"></i>
                                    <div class="fs-5 fw-bolder text-gray-800">Klik atau Seret File ke Sini</div>
                                    <div class="fs-7 fw-semibold text-muted mt-1">JPG, PNG, atau PDF (Maks. 2MB)</div>
                                </div>
                            </label>

                            <input type="file" id="buktiBayar" name="bukti_bayar"
                                accept="image/jpeg, image/png, application/pdf" hidden required>
                        </div>

                        <button type="submit" id="btn-kirim" class="btn btn-primary w-100 mt-8 py-4 fw-bold">
                            <span class="indicator-label">Kirim Bukti Pembayaran</span>
                        </button>
                    </form>
                </div>
            <?php endif; ?>



            <!-- ================= FOOTER ================= -->
            <?php if ($pembayaran['status'] === 'A'): ?>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-end gap-3">

                    <button type="button"
                        class="btn btn-success px-9 py-4 shadow-sm order-2 order-sm-1"
                        onclick="window.print()">
                        <i class="ki-outline ki-printer fs-2 me-2"></i>
                        Cetak Invoice
                    </button>

                    <a href="<?= base_url('sw-anggota/histori-iuran/download/' . $pembayaran['id']) ?>"
                        class="btn btn-light-success px-9 py-4 order-1 order-sm-2">
                        <i class="ki-outline ki-download fs-2 me-2"></i>
                        Unduh PDF
                    </a>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    function copyRekening() {
        const text = document.getElementById("noRek").innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert("Nomor rekening berhasil disalin");
        });
    }
</script>
<script>
    const fileInput = document.getElementById('buktiBayar');
    const uploadBox = document.getElementById('uploadBox');
    const fileName = document.getElementById('fileName');
    const content = document.getElementById('uploadContent');

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {

            // tampilkan nama file
            fileName.classList.remove('d-none');
            fileName.innerText = this.files[0].name;

            // ubah tampilan (metronic utility)
            uploadBox.classList.remove('border-gray-300', 'bg-light-light');
            uploadBox.classList.add('border-success', 'bg-light-success');

            // ubah icon & teks
            content.querySelector('i').className =
                'bi bi-check-circle fs-2x text-success mb-3';

            content.querySelector('.fw-semibold').innerText =
                'File berhasil dipilih';
        }
    });
</script>

<?= $this->endSection() ?>