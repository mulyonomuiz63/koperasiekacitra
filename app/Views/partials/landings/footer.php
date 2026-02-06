<div class="mb-0">
    <div class="landing-dark-bg">
        <div class="container">
            <div class="row py-10 py-lg-20">
                <div class="col-lg-3 mb-10 mb-lg-0">
                    <h4 class="fw-bold text-white mb-6">Informasi Kontak</h4>
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-telephone text-white fs-3 me-3"></i>
                            <span class="text-gray-600 fw-semibold fs-6"><?= setting('app_phone') ?></span>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-whatsapp text-white fs-3 me-3"></i>
                            <span class="text-gray-600 fw-semibold fs-6"><?= setting('app_phone') ?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope text-white fs-3 me-3"></i>
                            <a href="mailto:<?= setting('app_email') ?>" class="text-gray-600 text-hover-primary fw-semibold fs-6"><?= setting('app_email') ?></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-10 mb-lg-0">
                    <h4 class="fw-bold text-white mb-6">Link Terkait</h4>
                    <div class="d-flex flex-column fw-semibold fs-6">
                        <a href="#" class="text-gray-600 text-hover-primary mb-4">Kebijakan Privasi</a>
                        <a href="#" class="text-gray-600 text-hover-primary mb-4">Tata Cara Mendanai</a>
                        <a href="#" class="text-gray-600 text-hover-primary mb-4">Laporan Keuangan</a>
                        <a href="#" class="text-gray-600 text-hover-primary">Karir</a>
                    </div>
                </div>

                <div class="col-lg-3 mb-10 mb-lg-0">
                    <h4 class="fw-bold text-white mb-6">Head Office</h4>
                    <p class="text-gray-600 fw-semibold fs-6 mb-5">
                        <?= setting('alamat_perusahaan') ?>
                    </p>
                    <div class="rounded overflow-hidden">
                        <iframe src="<?= setting('google_maps') ?>" width="100%" height="100" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>

                <div class="col-lg-3">
                    <h4 class="fw-bold text-white mb-6">Social Media</h4>
                    <div class="d-flex flex-column">
                        <a href="<?= setting('footer_facebook') ?>" class="d-flex align-items-center mb-4">
                            <?= img_lazy('assets/media/svg/brand-logos/facebook-4.svg', '-', ['class' => 'h-20px me-3']) ?>
                            <span class="text-gray-600 text-hover-primary fw-semibold fs-6">Facebook</span>
                        </a>
                        <a href="<?= setting('footer_instagram') ?>" class="d-flex align-items-center mb-4">
                            <?= img_lazy('assets/media/svg/brand-logos/instagram-2-1.svg', '-', ['class' => 'h-20px me-3']) ?>    
                            <span class="text-gray-600 text-hover-primary fw-semibold fs-6">Instagram</span>
                        </a>
                        <a href="<?= setting('footer_youtube') ?>" class="d-flex align-items-center mb-4">
                            <?= img_lazy('assets/media/svg/brand-logos/youtube-3.svg', '-', ['class' => 'h-20px me-3']) ?>  
                            <span class="text-gray-600 text-hover-primary fw-semibold fs-6">Youtube</span>
                        </a>
                        <a href="<?= setting('footer_linkedin') ?>" class="d-flex align-items-center mb-4">
                            <?= img_lazy('assets/media/svg/brand-logos/linkedin-1.svg', '-', ['class' => 'h-20px me-3']) ?> 
                            <span class="text-gray-600 text-hover-primary fw-semibold fs-6">LinkedIn</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="landing-dark-separator"></div>
        <div class="container">
            <div class="d-flex flex-column flex-md-row flex-stack py-7 py-lg-10">
                <div class="d-flex align-items-center order-2 order-md-1">
                    <span class="mx-5 fs-6 fw-semibold text-gray-600">
                       Copyright &copy; <?= setting('tahun_berdiri') ?> <?= setting('app_name') ?>. All Rights Reserved.
                    </span>
                </div>
                <div class="d-flex align-items-center order-1 mb-5 mb-md-0">
                    <spa class="text-gray-600 fw-semibold fs-6 me-3">
                        Versi 
                    </span>
                    <?= setting('app_versi') ?>
                </div>
            </div>
        </div>
    </div>
</div>