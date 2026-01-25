<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4 mb-xl-10">
        <div class="card card-flush  shadow-sm">
            <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-200px"
                style="background-image:url('assets/media/svg/shapes/top-green.png')" data-bs-theme="light">
                <h3 class="card-title align-items-start flex-column text-white pt-10">
                    <span class="fw-bold fs-1 mb-2 text-white"><?= setting('app_name') ?></span>
                    <span class="text-white opacity-75 fw-semibold fs-6">Ringkasan Statistik Konten</span>
                </h3>
            </div>

            <div class="card-body mt-n15">
                <div class="position-relative">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="bg-light-primary rounded-3 px-6 py-5 border border-dashed border-primary border-opacity-25">
                                <div class="symbol symbol-35px mb-4">
                                    <span class="symbol-label bg-primary">
                                        <i class="ki-outline ki-basket fs-1 text-white"></i>
                                    </span>
                                </div>
                                <div class="m-0">
                                    <span class="text-gray-800 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">3</span>
                                    <span class="text-gray-600 fw-semibold fs-7">Produk</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="bg-light-success rounded-3 px-6 py-5 border border-dashed border-success border-opacity-25">
                                <div class="symbol symbol-35px mb-4">
                                    <span class="symbol-label bg-success">
                                        <i class="ki-outline ki-people fs-1 text-white"></i>
                                    </span>
                                </div>
                                <div class="m-0">
                                    <span class="text-gray-800 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?= number_format($total_pegawai, 0, ',', '.') ?></span>
                                    <span class="text-gray-600 fw-semibold fs-7">Anggota</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="bg-light-info rounded-3 px-6 py-5 border border-dashed border-info border-opacity-25">
                                <div class="symbol symbol-35px mb-4">
                                    <span class="symbol-label bg-info">
                                        <i class="ki-outline ki-document fs-1 text-white"></i>
                                    </span>
                                </div>
                                <div class="m-0">
                                    <span class="text-gray-800 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?= number_format($total_berita, 0, ',', '.') ?></span>
                                    <span class="text-gray-600 fw-semibold fs-7">Berita</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="bg-light-warning rounded-3 px-6 py-5 border border-dashed border-warning border-opacity-25">
                                <div class="symbol symbol-35px mb-4">
                                    <span class="symbol-label bg-warning">
                                        <i class="ki-outline ki-picture fs-1 text-white"></i>
                                    </span>
                                </div>
                                <div class="m-0">
                                    <span class="text-gray-800 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1"><?= number_format($total_galeri, 0, ',', '.') ?></span>
                                    <span class="text-gray-600 fw-semibold fs-7">Galeri</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xl-8 mb-xl-10">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10">
            <div class="col-xl-6">
                <div class="card card-flush h-xl-100 shadow-sm" style="background-color: #F8FDFF">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800 fs-3" id="display-judul">Total Saldo Koperasi</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Akumulasi pendaftaran & iuran bulanan</span>
                        </h3>
                    </div>
                    <div class="card-body d-flex align-items-end pt-0">
                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-5">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-5">
                                        <div class="symbol-label bg-light-primary">
                                            <i class="ki-outline ki-wallet fs-2x text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="m-0">
                                        <span class="fw-bold text-gray-400 d-block fs-8 text-uppercase" id="display-label">TOTAL SALDO</span>
                                        <span class="fw-bolder text-gray-800 fs-2qx lh-1" id="display-nominal">Rp <?= ringkas_uang($total_saldo) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="h-4px w-100 bg-light-primary rounded mb-7">
                                <div class="bg-primary rounded h-4px" style="width: 100%"></div>
                            </div>

                            <div class="row w-100 g-2">
                                <div class="col-4">
                                    <div class="btn-filter border border-primary bg-light-primary d-flex flex-column align-items-center justify-content-center p-3 rounded-3 cursor-pointer h-100"
                                        data-judul="Total Saldo Koperasi" data-label="TOTAL SALDO" data-nominal="Rp <?= ringkas_uang($total_saldo) ?>">
                                        <i class="ki-outline ki-element-11 fs-2 text-primary mb-1"></i>
                                        <span class="text-gray-800 fw-bold fs-8">Semua</span>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="btn-filter border border-gray-300 d-flex flex-column align-items-center justify-content-center p-3 rounded-3 cursor-pointer h-100"
                                        data-judul="Saldo Pendaftaran" data-label="PENDAFTARAN" data-nominal="Rp <?= ringkas_uang($saldo_pendaftaran) ?>">
                                        <i class="ki-outline ki-abstract-26 fs-2 text-success mb-1"></i>
                                        <span class="text-gray-800 fw-bold fs-8">Daftar</span>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="btn-filter border border-gray-300 d-flex flex-column align-items-center justify-content-center p-3 rounded-3 cursor-pointer h-100"
                                        data-judul="Saldo Iuran" data-label="IURAN BULANAN" data-nominal="Rp <?= ringkas_uang($saldo_bulanan) ?>">
                                        <i class="ki-outline ki-calendar-8 fs-2 text-danger mb-1"></i>
                                        <span class="text-gray-800 fw-bold fs-8">Iuran</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card card-flush h-xl-100 shadow-sm" style="background-color: #FFFDF8">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800 fs-3" id="trx-judul">Transaksi Bulan Ini</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Rekap perputaran uang koperasi</span>
                        </h3>
                    </div>
                    <div class="card-body d-flex align-items-end pt-0">
                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-5">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-5">
                                        <div class="symbol-label bg-light-warning">
                                            <i class="ki-outline ki-arrows-loop fs-2x text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="m-0">
                                        <span class="fw-bold text-gray-400 d-block fs-8 text-uppercase" id="trx-label">BULAN INI</span>
                                        <span class="fw-bolder text-gray-800 fs-2qx lh-1" id="trx-nominal">Rp <?= ringkas_uang($trx_bulan_ini) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="h-4px w-100 bg-light-warning rounded mb-7">
                                <div class="bg-primary rounded h-4px" style="width: 100%"></div>
                            </div>

                            <div class="row w-100 g-3">
                                <div class="col-6">
                                    <div class="btn-trx border border-warning bg-light-warning d-flex flex-column align-items-center justify-content-center p-4 rounded-3 cursor-pointer h-100"
                                        data-judul="Transaksi Bulan Ini" data-label="BULAN INI" data-nominal="Rp <?= ringkas_uang($trx_bulan_ini) ?>">
                                        <i class="ki-outline ki-calendar fs-1 text-warning mb-2"></i>
                                        <span class="text-gray-800 fw-bold fs-7">Bulan Ini</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="btn-trx border border-gray-300 d-flex flex-column align-items-center justify-content-center p-4 rounded-3 cursor-pointer h-100"
                                        data-judul="Transaksi Tahun Ini" data-label="TAHUN INI" data-nominal="Rp <?= ringkas_uang($trx_tahun_ini) ?>">
                                        <i class="ki-outline ki-chart-line fs-1 text-primary mb-2"></i>
                                        <span class="text-gray-800 fw-bold fs-7">Tahun Ini</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card border-transparent" data-bs-theme="light" style="background-color: #004a99; background-image: linear-gradient(to right, #004a99, #0066cc);">
                    <div class="card-body d-flex ps-xl-15">
                        <div class="m-0 py-2">
                            <div class="position-relative fs-2x z-index-2 fw-bold text-white mb-5">
                                <span class="me-2">Informasi Penting
                                    <span class="position-relative d-inline-block text-warning">
                                        <span class="text-warning opacity-90">Koperasi Eka Citra Mandiri</span>
                                        <span class="position-absolute opacity-50 bottom-0 start-0 border-4 border-warning border-bottom w-100"></span>
                                    </span>
                                </span>
                                <br>
                                <div class="fs-6 fw-semibold text-white opacity-75 mt-4 mb-2" style="max-width: 600px; line-height: 1.6;">
                                    Mulai **19 Agustus 2025**, pembayaran iuran resmi dialihkan langsung ke rekening Koperasi Eka Citra Mandiri Bank BCA KCP Pasar Minggu (BCA 1280835702). Mari wujudkan kesejahteraan bersama dengan semangat gotong royong.
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-4 mb-7">
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2 px-4 py-3">
                                    <span class="text-white opacity-75 fs-8 d-block fw-bold">PENDAFTARAN</span>
                                    <span class="text-warning fw-bolder fs-5">Rp 250.000</span>
                                </div>
                                <div class="bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2 px-4 py-3">
                                    <span class="text-white opacity-75 fs-8 d-block fw-bold">IURAN WAJIB</span>
                                    <span class="text-warning fw-bolder fs-5">Rp 50.000<small class="fs-9 opacity-75">/bln</small></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-warning fw-bold me-3 px-8 shadow-sm">
                                    Bayar Iuran
                                </a>
                                <a href="#" class="btn btn-white bg-white bg-opacity-10 bg-hover-opacity-20 text-white fw-semibold px-6">
                                    Detail Rekening
                                </a>
                            </div>
                        </div>
                        <img src="assets/media/illustrations/sigma-1/10.png" class="position-absolute me-3 bottom-0 end-0 h-200px d-none d-lg-block" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filters = document.querySelectorAll('.btn-filter');
        const displayJudul = document.getElementById('display-judul');
        const displayLabel = document.getElementById('display-label');
        const displayNominal = document.getElementById('display-nominal');

        filters.forEach(item => {
            item.addEventListener('click', function() {
                // 1. Ambil data
                const judul = this.getAttribute('data-judul');
                const label = this.getAttribute('data-label');
                const nominal = this.getAttribute('data-nominal');

                // 2. Update Teks Utama
                displayJudul.innerText = judul;
                displayLabel.innerText = label;
                displayNominal.innerText = nominal;

                // 3. Update Visual Tombol (Highlight)
                filters.forEach(f => f.classList.remove('active-state', 'shadow-sm'));
                this.classList.add('active-state', 'shadow-sm');
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trxFilters = document.querySelectorAll('.btn-trx');

        trxFilters.forEach(btn => {
            btn.addEventListener('click', function() {
                // 1. Update Konten
                document.getElementById('trx-judul').innerText = this.getAttribute('data-judul');
                document.getElementById('trx-label').innerText = this.getAttribute('data-label');
                document.getElementById('trx-nominal').innerText = this.getAttribute('data-nominal');

                // 2. Update Visual (Toggle Warna Kuning)
                trxFilters.forEach(f => {
                    f.classList.remove('border-warning', 'bg-light-warning');
                    f.classList.add('border-gray-300');
                });

                this.classList.remove('border-gray-300');
                this.classList.add('border-warning', 'bg-light-warning');
            });
        });
    });
</script>
<?= $this->endSection() ?>