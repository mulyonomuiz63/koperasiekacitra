<?= $this->extend('pages/layoutAnggota') ?>
<?= $this->section('content') ?>

<div class="row g-5 g-xl-10">
    <div class="col-xl-4">
        <div class="card card-flush shadow-sm mb-5 mb-xl-10">
            <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-150px"
                style="background-image:url('assets/media/svg/shapes/top-green.png')" data-bs-theme="light">
                <h3 class="card-title align-items-start flex-column text-white pt-10">
                    <span class="fw-bold fs-1 mb-2 text-white"><?= setting('app_name') ?></span>
                    <span class="text-white opacity-75 fw-semibold fs-6">Ringkasan Statistik Konten</span>
                </h3>
            </div>

            <div class="card-body mt-n15">
                <div class="row g-3 g-lg-4">
                    <?php
                    $stats = [
                        ['label' => 'Produk', 'val' => 3, 'color' => 'primary', 'icon' => 'ki-basket'],
                        ['label' => 'Anggota', 'val' => $total_pegawai, 'color' => 'success', 'icon' => 'ki-people'],
                        ['label' => 'Berita', 'val' => $total_berita, 'color' => 'info', 'icon' => 'ki-document'],
                        ['label' => 'Galeri', 'val' => $total_galeri, 'color' => 'warning', 'icon' => 'ki-picture'],
                    ];
                    foreach ($stats as $s):
                    ?>
                        <div class="col-6">
                            <div class="bg-light-<?= $s['color'] ?> rounded-3 px-4 py-5 border border-dashed border-<?= $s['color'] ?> border-opacity-25 h-100">
                                <i class="ki-outline <?= $s['icon'] ?> fs-1 text-<?= $s['color'] ?> mb-3 d-block"></i>
                                <span class="text-gray-800 fw-bolder d-block fs-2qx lh-1 mb-1"><?= is_numeric($s['val']) ? number_format($s['val'], 0, ',', '.') : $s['val'] ?></span>
                                <span class="text-gray-600 fw-semibold fs-7"><?= $s['label'] ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="row g-5 g-xl-10">
            <div class="col-12 mb-6">
                <div class="card card-flush shadow-sm h-100 border-0"
                    style="background: linear-gradient(135deg, #ffffff 0%, #f8fdff 100%); border-radius: 1.25rem;">

                    <div class="card-header pt-6 pt-md-7 px-6 px-md-9 border-0">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder text-gray-900 fs-3 fs-md-2" id="display-judul">Total Saldo Iuran Anda</span>
                            <span class="text-muted mt-1 fw-medium fs-7 fs-md-6">Saldo disini merupakan iuran bulanan</span>
                        </h3>
                    </div>

                    <div class="card-body px-6 px-md-9 py-5">
                        <div class="d-flex align-items-center mb-2">
                            <div class="symbol symbol-50px symbol-md-65px symbol-circle me-4 me-md-6">
                                <div class="symbol-label shadow-sm" style="background-color: #ffffff; border: 1px solid #eef3f7;">
                                    <i class="ki-outline ki-wallet fs-2x fs-md-3x text-primary"></i>
                                </div>
                            </div>

                            <div class="overflow-hidden">
                                <span class="fw-bold text-gray-500 d-block fs-9 fs-md-8 text-uppercase ls-1 mb-1" id="display-label">SALDO ANDA</span>
                                <span class="fw-bolder text-gray-900 fs-1 fs-md-2qx lh-1 d-block text-truncate" id="display-nominal" style="letter-spacing: -1px;">
                                    Rp <?= ringkas_uang($total_saldo) ?>
                                </span>
                            </div>
                        </div>

                        <div class="separator separator-dashed border-gray-200 my-4"></div>

                        <div class="d-flex flex-stack">
                            <span class="text-gray-500 fs-9 fw-bold">UPDATE OTOMATIS</span>
                            <span class="badge badge-light-primary fw-bold fs-9">TERVERIFIKASI</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(90deg, #004a99 0%, #0066cc 100%);">
                    <div class="card-body p-8 p-lg-12">
                        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
                            <div class="flex-grow-1 z-index-2">
                                <h3 class="text-white fw-bold fs-2x mb-4">
                                    Informasi Penting <span class="text-warning text-decoration-underline">Koperasi</span>
                                </h3>
                                <p class="text-white opacity-75 fs-6 mb-8 max-w-600px">
                                    Mulai <strong>19 Agustus 2025</strong>, iuran resmi dialihkan ke Bank BCA KCP Pasar Minggu
                                    <span class="badge badge-light-warning fw-bold fs-6 ms-1">1280835702</span>.
                                </p>
                                <div class="d-flex flex-wrap gap-3 mb-8">
                                    <div class="bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2 px-5 py-3 text-center">
                                        <div class="text-white opacity-75 fs-9 fw-bold">PENDAFTARAN</div>
                                        <div class="text-warning fw-bolder fs-4">Rp 250rb</div>
                                    </div>
                                    <div class="bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2 px-5 py-3 text-center">
                                        <div class="text-white opacity-75 fs-9 fw-bold">IURAN WAJIB</div>
                                        <div class="text-warning fw-bolder fs-4">Rp 50rb<span class="fs-9 opacity-50">/bln</span></div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <a href="<?= base_url('sw-anggota/iuran') ?>" class="btn btn-warning fw-bold px-8 shadow-sm">Bayar Iuran</a>
                                </div>
                            </div>
                            <?= img_lazy('assets/media/illustrations/sigma-1/10.png', '-', ['style' => 'object-fit: contain', 'class' => 'h-150px h-lg-250px mt-10 mt-lg-0 ms-lg-n10 d-none d-md-block']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>