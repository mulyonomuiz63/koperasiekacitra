<?= $this->section('styles') ?>
<style>
    /* Background Section */
    .product-section-bg {
        background: linear-gradient(180deg, #f4f9f7 0%, #ffffff 100%);
    }

    /* Modern Card Design */
    .product-card-modern {
        background: #d8eadf;
        /* Warna hijau lembut seperti Gambar 6 */
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 25px !important;
        cursor: pointer;
    }

    /* Efek Hover: Berubah Putih Bersih & Melayang */
    .product-card-modern:hover {
        background: #ffffff;
        transform: translateY(-15px);
        box-shadow: 0 25px 50px rgba(80, 205, 137, 0.15) !important;
    }

    /* Animasi Ikon melayang perlahan */
    .icon-float {
        transition: transform 0.5s ease;
    }

    .product-card-modern:hover .icon-float {
        transform: scale(1.1) rotate(5deg);
    }

    /* Judul Berubah Warna saat di hover */
    .card-title-hover {
        transition: color 0.3s ease;
    }

    .product-card-modern:hover .card-title-hover {
        color: #50cd89 !important;
    }

    /* Tombol Friendly */
    .btn-modern-link {
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-modern-link span {
        position: relative;
    }

    .btn-modern-link:hover .transition-icon {
        transform: translateX(8px);
    }

    /* Ornamen Pojok (Seperti Gambar 6) */
    .product-ornament-modern {
        position: absolute;
        bottom: -15px;
        right: -15px;
        width: 80px;
        height: 80px;
        background: rgba(116, 177, 75, 0.2);
        /* Hijau transparan */
        border-radius: 50%;
        transition: all 0.5s ease;
        z-index: 0;
    }

    .product-card-modern:hover .product-ornament-modern {
        background: rgba(80, 205, 137, 0.6);
        transform: scale(1.5);
    }

    /* Baris Teks yang Rapi */
    .line-height-xl {
        line-height: 1.7;
    }
</style>
<?= $this->endSection() ?>
<div class="py-20 product-section-bg" id="produk-layanan" data-aos="fade-up">
    <div class="container">
        <div class="text-center mb-18" data-aos="fade-down" data-aos-duration="1000">
            <span class="badge badge-light-success fs-7 fw-bold px-4 py-3 mb-5 shadow-sm">Produk Koperasi Eka Citra</span>
            <p class="text-gray-700 fs-4 fw-semibold mx-auto mw-600px lh-base">
                Koperasi eka citra sekarang memiliki 3 macam produk yang sedang berjalan.
            </p>
        </div>

        <div class="row g-10 justify-content-center">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card card-flush h-100 product-card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-9 position-relative z-index-1 d-flex flex-column">
                        <div class="d-flex align-items-center mb-6">
                            <div class="symbol symbol-60px me-5 icon-float">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-coffee fs-2tx text-success"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                            </div>
                            <h3 class="fw-bolder text-dark m-0 fs-2 card-title-hover">Edu Technopark Café</h3>
                        </div>
                        <p class="text-gray-600 fw-medium fs-6 mb-8 flex-grow-1">
                            Bukan sekadar kafe biasa. Kami menghadirkan perpaduan harmoni antara teknologi, kenyamanan bekerja, dan sajian kuliner berkualitas di jantung edukasi.
                        </p>
                        <a href="#" class="btn-modern-link fw-bold text-success d-flex align-items-center mt-auto">
                            <span>Selengkapnya</span>
                            <i class="ki-duotone ki-arrow-right fs-2 ms-3 transition-icon"></i>
                        </a>
                    </div>
                    <div class="product-ornament-modern"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card card-flush h-100 product-card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-9 position-relative z-index-1 d-flex flex-column">
                        <div class="d-flex align-items-center mb-6">
                            <div class="symbol symbol-60px me-5 icon-float">
                                <div class="symbol-label bg-light-success">
                                    <i class="ki-duotone ki-coffee fs-2tx text-success"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                            </div>
                            <h3 class="fw-bolder text-dark m-0 fs-2 card-title-hover">Oddventure Café UNJ</h3>
                        </div>
                        <p class="text-gray-600 fw-medium fs-6 mb-8 flex-grow-1">
                            Destinasi kuliner favorit di lingkungan UNJ yang menawarkan suasana santai untuk berdiskusi, berkarya, dan menikmati waktu berkualitas bersama komunitas.
                        </p>
                        <a href="#" class="btn-modern-link fw-bold text-success d-flex align-items-center mt-auto">
                            <span>Selengkapnya</span>
                            <i class="ki-duotone ki-arrow-right fs-2 ms-3 transition-icon"></i>
                        </a>
                    </div>
                    <div class="product-ornament-modern"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card card-flush h-100 product-card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-9 position-relative z-index-1 d-flex flex-column">
                        <div class="d-flex align-items-center mb-6">
                            <div class="symbol symbol-60px me-5 icon-float">
                                <div class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-screen fs-2tx text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                </div>
                            </div>
                            <h3 class="fw-bolder text-dark m-0 fs-2 card-title-hover">Sistem Informasi Pengadaan</h3>
                        </div>
                        <p class="text-gray-600 fw-medium fs-6 mb-8 flex-grow-1">
                            Solusi digital terintegrasi untuk mengelola proses pengadaan di sekolah secara transparan, akuntabel, dan efisien demi kemajuan dunia pendidikan.
                        </p>
                        <a href="#" class="btn-modern-link fw-bold text-success d-flex align-items-center mt-auto">
                            <span>Selengkapnya</span>
                            <i class="ki-duotone ki-arrow-right fs-2 ms-3 transition-icon"></i>
                        </a>
                    </div>
                    <div class="product-ornament-modern"></div>
                </div>
            </div>
        </div>
    </div>
</div>