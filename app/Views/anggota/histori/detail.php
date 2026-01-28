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

                        <div class="card-body p-5">

                            <!-- HEADER -->
                            <div class="d-flex align-items-center mb-4">
                                <div class="symbol symbol-45px symbol-circle bg-light-primary me-3">
                                    <i class="bi bi-wallet2 fs-2 text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">Informasi Pembayaran</h4>
                                    <span class="text-muted fs-7">
                                        Segera lakukan pembayaran agar pesanan diproses
                                    </span>
                                </div>
                            </div>

                            <div class="row g-4">

                                <!-- BANK INFO -->
                                <div class="col-md-7">
                                    <div class="border rounded-3 p-4 h-100">

                                        <div class="fw-semibold fs-6 mb-3 text-primary">
                                            TRANSFER BANK
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Bank</span>
                                            <span class="fw-semibold"><?= $rekening['bank'] ?></span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">No. Rekening</span>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-bold fs-6 me-3" id="noRek">
                                                    <?= $rekening['no'] ?>
                                                </span>
                                                <button type="button"
                                                    class="btn btn-sm btn-light-primary"
                                                    onclick="copyRekening()">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Atas Nama</span>
                                            <span class="fw-semibold"><?= $rekening['nama'] ?></span>
                                        </div>

                                    </div>
                                </div>

                                <!-- TOTAL & STATUS -->
                                <div class="col-md-5">
                                    <div class="bg-light rounded-3 p-4 h-100 text-center">

                                        <div class="text-muted fw-semibold mb-2">
                                            TOTAL TAGIHAN
                                        </div>

                                        <div class="fs-1 fw-bolder text-dark mb-3">
                                            Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>
                                        </div>

                                        <?php if ($pembayaran['status'] === 'P'): ?>
                                            <span class="badge badge-light-warning fs-7 px-4 py-2 mb-3">
                                                Menunggu Pembayaran
                                            </span>

                                            <!-- COUNTDOWN
                                            <div class="mt-3 text-danger fw-semibold fs-7">
                                                Batas pembayaran:
                                                <span id="countdown"></span>
                                            </div> -->

                                        <?php elseif ($pembayaran['status'] === 'V'): ?>
                                            <span class="badge badge-light-info fs-7 px-4 py-2">
                                                Sedang Diverifikasi
                                            </span>
                                        <?php elseif ($pembayaran['status'] === 'A'): ?>
                                            <span class="badge badge-light-success fs-7 px-4 py-2">
                                                LUNAS
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-light-danger fs-7 px-4 py-2">
                                                Pembayaran Gagal
                                            </span>
                                        <?php endif; ?>

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
                                <input type="date" name="tgl_bayar" class="form-control form-control-solid"
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
                <div class="d-flex flex-stack flex-wrap mt-20 pt-13">

                    <button type="button"
                        class="btn btn-success me-3"
                        onclick="window.print()">
                        Print Invoice
                    </button>

                    <a href="<?= base_url('sw-anggota/histori-iuran/download/' . $pembayaran['id']) ?>"
                        class="btn btn-light-success">
                        Download Invoice
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