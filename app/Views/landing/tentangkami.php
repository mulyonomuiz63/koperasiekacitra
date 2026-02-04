<?= $this->section('styles') ?>

<style>
    .animated-card {
        background: linear-gradient(to left, #f1faff 50%, #ffffff 50%);
        background-size: 200% 100%;
        background-position: right bottom;
        transition: all 0.5s ease-out;
        cursor: pointer;
        border: 1px solid #f1faff;
    }

    /* Saat kursor diarahkan: warna berubah dari kanan ke kiri */
    .animated-card:hover {
        background-position: left bottom;
        transform: translateX(10px);
        /* Sedikit geser agar interaktif */
        border-color: #009ef7;
    }

    /* Penyesuaian teks saat hover agar tetap kontras */
    .animated-card h4,
    .animated-card p {
        transition: color 0.4s ease;
    }

    /* Jika ingin teks berubah warna saat di hover (opsional) */
    /* .animated-card:hover h4 { color: #009ef7 !important; } */

    .text-justify {
        text-align: justify;
    }
</style>
<?= $this->endSection() ?>
<div class="py-20" id="tentang-kami" data-aos="fade-up">
    <div class="container">
        <div class="row gy-10" data-aos="fade-up" data-aos-duration="1000">

            <div class="col-lg-6 px-7 px-lg-2" data-aos="fade-right" data-aos-duration="1200">
                <span class="badge badge-light-success fs-7 fw-bold px-4 py-3 mb-5 shadow-sm text-uppercase ls-1">Tentang Kami</span>
                <h2 class="text-dark fw-bolder fs-2qx mb-7">Mengenal Koperasi Eka Citra</h2>

                <div class="fs-5 text-gray-700 fw-medium mb-10 text-justify" style="line-height: 1.9">
                    <p class="mb-6">
                        <span class="fs-1 fw-bolder text-success float-start me-2 lh-1">D</span>engan rahmat Tuhan Yang Maha Esa dan atas segala karunia-Nya, pada hari <strong>Sabtu, 3 Mei 2025</strong>, bertempat di Universitas Negeri Jakarta, resmi didirikan suatu badan usaha berbadan hukum berbentuk Koperasi.
                    </p>

                    <p class="mb-6">
                        Momentum ini bertepatan dengan Peringatan Hari Ulang Tahun <strong>Keluarga Mahasiswa Pencinta Alam Eka Citra UNJ yang ke-44 tahun</strong>. Para anggota luar biasa mendirikan wadah ini dengan penuh kesadaran dan cita-cita luhur terhadap kemajuan organisasi, almamater, hingga bangsa.
                    </p>

                    <p class="mb-0 border-start border-success border-4 ps-6 p-2 bg-light-success rounded-end">
                        Koperasi ini merupakan <span class="text-dark fw-bold">badan usaha otonom</span> di bawah naungan <strong>Yayasan Eka Citra Indonesia (YAKANESIA)</strong>, sebagai wadah pemberdayaan ekonomi, profesionalisme, dan kemandirian seluruh anggota.
                    </p>
                </div>

                <div class="d-flex flex-stack">
                    <a href="<?= base_url('register') ?>" class="btn btn-success btn-hover-rise er-3 px-9 py-4 shadow-sm">
                        <i class="ki-duotone ki-rocket fs-2 me-2"></i>
                        <span class="fw-bold">Mulai Bergabung</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 px-7 px-lg-2">
                <div class="d-flex flex-column gap-5" data-aos="fade-left" data-aos-duration="1200">

                    <div class="animated-card d-flex align-items-center p-6 rounded-4 shadow-sm border border-gray-100">
                        <div class="symbol symbol-50px symbol-circle me-5">
                            <div class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-eye fs-2tx text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="text-dark fw-bolder mb-1 fs-5">VISI</h4>
                            <p class="text-gray-600 fs-7 mb-0 lh-base">
                                Menjadi koperasi unggul dan profesional yang mandiri, inovatif, serta memberikan manfaat nyata bagi anggota, almamater, dan bangsa.
                            </p>
                        </div>
                    </div>
                    <div class="animated-card d-flex align-items-start p-6 rounded-4 shadow-sm border border-gray-100">
                        <div class="symbol symbol-50px symbol-circle me-5 mt-1">
                            <div class="symbol-label bg-light-success">
                                <i class="ki-duotone ki-compass fs-2tx text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="text-dark fw-bolder mb-2 fs-5">MISI</h4>
                            <ul class="text-gray-600 fs-7 mb-0 ps-4 lh-lg">
                                <li>Mengembangkan ekosistem bisnis yang produktif & berkelanjutan.</li>
                                <li>Pemberdayaan anggota melalui pelatihan & literasi keuangan.</li>
                                <li>Membangun jejaring kemitraan industri & instansi pemerintah.</li>
                                <li>Motor penggerak ekonomi kreatif & kewirausahaan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>