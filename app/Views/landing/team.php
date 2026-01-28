<!--begin::Team Section-->
<div class="py-10 py-lg-20" id="struktur-organisasi" data-aos="fade-up">
    <div class="container">
        <div class="text-center mb-12">
            <h3 class="fs-2hx text-dark mb-5" id="team">Tim Hebat Kami</h3>
            <div class="d-flex justify-content-center mb-5">
                <span class="w-70px h-4px bg-success rounded-pill me-2"></span>
                <span class="w-20px h-4px bg-warning rounded-pill"></span>
            </div>
            <div class="fs-5 text-muted fw-bold mx-auto mw-lg-600px">
                Sinergi para profesional yang berdedikasi tinggi untuk menghadirkan solusi inovatif dan layanan terbaik bagi pertumbuhan bisnis Anda.
            </div>
        </div>
        <div class="tns-default position-relative">
            <div
                data-tns="true"
                data-tns-loop="false"
                data-tns-speed="1000"
                data-tns-autoplay="false"
                data-tns-autoplay-timeout="5000"
                data-tns-nav="false"
                data-tns-items="1"
                data-tns-prev-button="#kt_team_slider_prev"
                data-tns-next-button="#kt_team_slider_next"
                data-tns-responsive='{"768": {"items": 2}, "1200": {"items": 4}}'>
                <?php foreach ($pegawai as $rows): ?>
                    <div class="px-5">
                        <div class="card card-flush shadow-sm h-100 rounded-4 hover-elevate-up">
                            <div class="card-body text-center pt-10 pb-7">
                                <div class="symbol symbol-125px symbol-circle mb-5 shadow-sm border border-4 border-white">
                                    <?= img_lazy('assets/media/avatars/300-1.jpg', '-', ['class' => 'w-100']) ?>
                                </div>
                                <div class="mb-5">
                                    <a href="#" class="text-dark fw-bold text-hover-success fs-3"><?= $rows['nama_lengkap'] ?></a>
                                    <div class="text-success fw-bold fs-7 text-uppercase ls-1 mt-1"><?= $rows['nama_jabatan'] ?></div>
                                </div>
                                <div class="d-flex flex-center">
                                    <a href="#" class="btn btn-icon btn-light-success btn-sm btn-circle me-2"><i class="fab fa-linkedin-in fs-4"></i></a>
                                    <a href="#" class="btn btn-icon btn-light-success btn-sm btn-circle"><i class="fas fa-envelope fs-4"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="d-flex flex-center mt-10">
                <button class="btn btn-icon btn-sm btn-light-success btn-circle border-0 me-3" id="kt_team_slider_prev">
                    <i class="ki-duotone ki-left fs-2"></i>
                </button>
                <button class="btn btn-icon btn-sm btn-light-success btn-circle border-0" id="kt_team_slider_next">
                    <i class="ki-duotone ki-right fs-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>