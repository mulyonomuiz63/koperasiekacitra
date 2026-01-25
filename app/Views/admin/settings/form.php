<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-body">
        <!--begin:::Tabs-->
        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-5 active" data-bs-toggle="tab" href="#tab_general" role="tab">
                    <i class="ki-duotone ki-home fs-2 me-2"></i>General
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#tab_sosial_media" role="tab">
                    <i class="ki-duotone ki-link fs-2 me-2"></i>Sosial Media
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#tab_smtp" role="tab">
                    <i class="ki-duotone ki-link fs-2 me-2"></i>SMTP
                </a>

            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#tab_iuran_bulanan" role="tab">
                    <i class="ki-duotone ki-link fs-2 me-2"></i>Iuran Bulanan
                </a>

            </li>
        </ul>
        <!--end:::Tabs-->

        <!--begin:::Form (satu form untuk semua tab)-->
        <form action="<?= base_url('settings/update') ?>" method="post" enctype="multipart/form-data" class="form fv-plugins-bootstrap5 fv-plugins-framework">
            <?= csrf_field() ?>

            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">

                <!--begin:::Tab pane General-->
                <div class="tab-pane fade show active" id="tab_general" role="tabpanel">

                    <!-- Nama Aplikasi -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Nama Aplikasi</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="app_name" value="<?= old('app_name', $settings['app_name'] ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Icon Aplikasi -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">favicon Aplikasi</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" class="form-control form-control-solid" name="app_icon">
                            <?php if(!empty($settings['app_icon'])): ?>
                                <img src="<?= base_url('uploads/app-icon/' . $settings['app_icon']) ?>" alt="App Icon" class="mt-2" style="width:50px;height:50px;">
                            <?php endif; ?>
                        </div>
                    </div>
                     <!-- Icon Aplikasi -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Logo Perusahaan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" class="form-control form-control-solid" name="logo_perusahaan">
                            <?php if(!empty($settings['logo_perusahaan'])): ?>
                                <img src="<?= base_url('uploads/app-icon/' . $settings['logo_perusahaan']) ?>" alt="App Icon" class="mt-2" style="width:50px;height:50px;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Email Aplikasi -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Email Perusahaan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control form-control-solid" name="app_email" value="<?= old('app_email', $settings['app_email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Telepon Perusahaan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="app_phone" value="<?= old('app_phone', $settings['app_phone'] ?? '') ?>">
                        </div>
                    </div>

                     <!-- Alamat -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Alamat Lengkap</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="alamat_perusahaan" value="<?= old('alamat_perusahaan', $settings['alamat_perusahaan'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Tahun Google Maps -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Google Maps Perusahan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="google_maps" value="<?= old('google_maps', $settings['google_maps'] ?? '') ?>">
                            <div class="form-text">
                                Cara ambil: Buka Google Maps > Share > Embed a map > Copy hanya isi <strong>src="..."</strong> nya saja.
                            </div>
                        </div>
                    </div>

                    <!-- Tahun berdiri -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Tahun Berdiri Perusahan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="tahun_berdiri" value="<?= old('tahun_berdiri', $settings['tahun_berdiri'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Versi Aplikasi -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Versi Aplikasi</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="app_versi" value="<?= old('app_versi', $settings['app_versi'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                <!--end:::Tab pane General-->

                <!--begin:::Tab pane Footer Links-->
                <div class="tab-pane fade" id="tab_sosial_media" role="tabpanel">

                    <!-- Contoh: Facebook -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Facebook</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_facebook" value="<?= old('footer_facebook', $settings['footer_facebook'] ?? '') ?>" placeholder="link facebook">
                        </div>
                    </div>

                    <!-- Contoh: Instagram -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Instagram</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_instagram" value="<?= old('footer_instagram', $settings['footer_instagram'] ?? '') ?>" placeholder="link instagram">
                        </div>
                    </div>

                    <!-- Contoh: Youtube -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Youtube</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_youtube" value="<?= old('footer_youtube', $settings['footer_youtube'] ?? '') ?>" placeholder="link youtube">
                        </div>
                    </div>

                    <!-- Contoh: LinkedIn -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">LinkedIn</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_linkedin" value="<?= old('footer_linkedin', $settings['footer_linkedin'] ?? '') ?>" placeholder="link linkedin">
                        </div>
                    </div>

                </div>
                <!--end:::Tab pane Footer Links-->

                <!--begin:::Tab pane SMTP-->
                <div class="tab-pane fade" id="tab_smtp" role="tabpanel">

                    <!-- SMTP Host -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">SMTP Host</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control form-control-solid"
                                name="smtp_host"
                                value="<?= old('smtp_host', $settings['smtp_host'] ?? '') ?>"
                                placeholder="smtp.gmail.com">
                        </div>
                    </div>

                    <!-- SMTP User -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">SMTP User</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control form-control-solid"
                                name="smtp_user"
                                value="<?= old('smtp_user', $settings['smtp_user'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- SMTP Password -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">SMTP Password</label>
                        </div>
                        <div class="col-md-9">
                            <input type="password"
                                class="form-control form-control-solid"
                                name="smtp_pass"
                                placeholder="********">
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengubah password
                            </small>
                        </div>
                    </div>

                    <!-- SMTP Port -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">SMTP Port</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number"
                                class="form-control form-control-solid"
                                name="smtp_port"
                                value="<?= old('smtp_port', $settings['smtp_port'] ?? 587) ?>">
                        </div>
                    </div>

                    <!-- SMTP Crypto -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">SMTP Crypto</label>
                        </div>
                        <div class="col-md-9">
                            <select name="smtp_crypto" class="form-select form-select-solid">
                                <option value="">None</option>
                                <option value="tls" <?= ($settings['smtp_crypto'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS</option>
                                <option value="ssl" <?= ($settings['smtp_crypto'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                            </select>
                        </div>
                    </div>

                    <!-- From Email -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">From Email</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email"
                                class="form-control form-control-solid"
                                name="smtp_from_email"
                                value="<?= old('smtp_from_email', $settings['smtp_from_email'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- From Name -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">From Name</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control form-control-solid"
                                name="smtp_from_name"
                                value="<?= old('smtp_from_name', $settings['smtp_from_name'] ?? '') ?>">
                        </div>
                    </div>

                </div>
                <!--end:::Tab pane SMTP-->

                <!--begin:::Tab pane Iuran Bulanan-->
                <div class="tab-pane fade" id="tab_iuran_bulanan" role="tabpanel">

                    <!-- Contoh: Nominal Iuran -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Nominal Iuran Bulanan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="nominal_iuran" value="<?= old('nominal_iuran', $settings['nominal_iuran'] ?? '') ?>" placeholder="Nominal Iuran Bulanan">
                        </div>
                    </div>

                    <!-- Contoh: Tanggal otomatis di buat tagihan iuran -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Tanggal Otomatis Tagihan Iuran</label>
                        </div>
                        <div class="col-md-9">
                            <input 
                                type="number"
                                class="form-control form-control-solid"
                                name="tgl_tagihan_iuran"
                                min="1"
                                max="28"
                                placeholder="Tanggal (1 – 28)"
                                value="<?= old('tgl_tagihan_iuran', $settings['tgl_tagihan_iuran'] ?? '') ?>"
                            >

                        </div>
                    </div>

                    <!-- Contoh: Status Iuran bulanan -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Status Iuran Bulanan</label>
                        </div>
                        <div class="col-md-9">
                            <select name="status_iuran" class="form-select form-select-solid">
                                <option value="A" <?= (isset($settings['status_iuran']) && $settings['status_iuran'] === 'A') ? 'selected' : '' ?>>Aktif</option>
                                <option value="T" <?= (isset($settings['status_iuran']) && $settings['status_iuran'] === 'T') ? 'selected' : '' ?>>Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                </div>
                <!--end:::Tab pane Footer Links-->


            </div>
            <!--end:::Tab content-->

            <!-- Tombol Simpan tunggal selalu tampil -->
            <div class="row mt-10">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Pengaturan</button>
                </div>
            </div>

        </form>
        <!--end:::Form-->

    </div>
</div>

<?= $this->endSection() ?>
