<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-body">

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!--begin:::Tabs-->
        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-5 active" data-bs-toggle="tab" href="#tab_general" role="tab">
                    <i class="ki-duotone ki-home fs-2 me-2"></i>General
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#tab_footer_info" role="tab">
                    <i class="ki-duotone ki-notepad fs-2 me-2"></i>Footer Info
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#tab_footer_links" role="tab">
                    <i class="ki-duotone ki-link fs-2 me-2"></i>Footer Links
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
                            <label class="fs-6 fw-semibold form-label mt-3">Icon Aplikasi</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" class="form-control form-control-solid" name="app_icon">
                            <?php if(!empty($settings['app_icon'])): ?>
                                <img src="<?= base_url('uploads/app-icon/' . $settings['app_icon']) ?>" alt="App Icon" class="mt-2" style="width:50px;height:50px;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Email Aplikasi -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Email Aplikasi</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control form-control-solid" name="app_email" value="<?= old('app_email', $settings['app_email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Telepon</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="app_phone" value="<?= old('app_phone', $settings['app_phone'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Warna Tema -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Warna Tema</label>
                        </div>
                        <div class="col-md-9">
                            <input type="color" class="form-control form-control-color" name="theme_color" value="<?= old('theme_color', $settings['theme_color'] ?? '#3699FF') ?>">
                        </div>
                    </div>

                </div>
                <!--end:::Tab pane General-->

                <!--begin:::Tab pane Footer Info-->
                <div class="tab-pane fade" id="tab_footer_info" role="tabpanel">

                    <!-- Footer Name -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Footer Name</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_name" value="<?= old('footer_name', $settings['footer_name'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Footer Address -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Alamat Footer</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control form-control-solid" name="footer_address"><?= old('footer_address', $settings['footer_address'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- Footer Email -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Email Footer</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control form-control-solid" name="footer_email" value="<?= old('footer_email', $settings['footer_email'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Footer Phone -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Telepon Footer</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_phone" value="<?= old('footer_phone', $settings['footer_phone'] ?? '') ?>">
                        </div>
                    </div>

                </div>
                <!--end:::Tab pane Footer Info-->

                <!--begin:::Tab pane Footer Links-->
                <div class="tab-pane fade" id="tab_footer_links" role="tabpanel">

                    <!-- Contoh: Facebook -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Facebook</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_facebook" value="<?= old('footer_facebook', $settings['footer_facebook'] ?? '') ?>" placeholder="https://facebook.com/">
                        </div>
                    </div>

                    <!-- Contoh: Twitter -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Twitter</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_twitter" value="<?= old('footer_twitter', $settings['footer_twitter'] ?? '') ?>" placeholder="https://twitter.com/">
                        </div>
                    </div>

                    <!-- Contoh: Instagram -->
                    <div class="row mb-7">
                        <div class="col-md-3 text-md-end">
                            <label class="fs-6 fw-semibold form-label mt-3">Instagram</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-solid" name="footer_instagram" value="<?= old('footer_instagram', $settings['footer_instagram'] ?? '') ?>" placeholder="https://instagram.com/">
                        </div>
                    </div>

                </div>
                <!--end:::Tab pane Footer Links-->

            </div>
            <!--end:::Tab content-->

            <!-- Tombol Simpan tunggal selalu tampil -->
            <div class="row mt-10">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </div>
            </div>

        </form>
        <!--end:::Form-->

    </div>
</div>

<?= $this->endSection() ?>
