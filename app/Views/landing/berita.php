<?= $this->section('styles') ?>
<style>
    /* slider base styles */
    .tns-ovh {
        padding: 15px 0 !important;
    }

    .object-fit-cover {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .card-flush {
        transition: transform 0.3s ease, shadow 0.3s ease;
        border: none !important;
    }

    .card-flush:hover {
        transform: translateY(-7px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        #berita .card-img-custom {
            height: 100px !important; /* Tinggi gambar pendek agar 3 item tidak terlalu panjang */
        }
        
        .news-card-mobile .card-body {
            padding: 0.75rem !important;
        }

        /* Line clamping height adjustment for mobile */
        .title-clamp {
            height: 2.4em !important;
            min-height: 2.4em !important;
            font-size: 0.75rem !important; /* Font judul kecil untuk mobile */
        }
    }

    /* Desktop line clamping */
    .title-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 2.8em;
        min-height: 2.8em;
    }
</style>
<?= $this->endSection() ?>

<div class="py-10 py-lg-20" id="berita" style="background-color: #ffffff;">
    <div class="container">
        <div class="d-flex flex-stack mb-10">
            <div class="d-flex flex-column" data-aos="fade-right">
                <h2 class="text-dark fw-bold fs-2 fs-lg-2qx mb-2">Blog & News</h2>
                <div class="d-flex align-items-center">
                    <span class="w-40px w-lg-70px h-4px bg-success rounded-pill me-2"></span>
                    <span class="w-15px w-lg-20px h-4px bg-warning rounded-pill"></span>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-icon btn-sm btn-light-success btn-circle border-0" id="kt_news_slider_prev">
                    <i class="ki-outline ki-left fs-3"></i>
                </button>
                <button class="btn btn-icon btn-sm btn-light-success btn-circle border-0" id="kt_news_slider_next">
                    <i class="ki-outline ki-right fs-3"></i>
                </button>
            </div>
        </div>

        <div class="tns-default position-relative" data-aos="fade-up">
            <div
                data-tns="true"
                data-tns-loop="true"
                data-tns-speed="800"
                data-tns-autoplay="true"
                data-tns-nav="false"
                data-tns-items="1"
                data-tns-prev-button="#kt_news_slider_prev"
                data-tns-next-button="#kt_news_slider_next"
                data-tns-responsive='{
                    "0": { "items": 2, "gutter": 10 }, 
                    "768": { "items": 4, "gutter": 15 },
                    "1200": { "items": 5, "gutter": 20 }
                }'>

                <?php foreach ($latest_news as $news): ?>
                    <div class="px-2">
                        <div class="card card-flush shadow-sm h-100 rounded-4 overflow-hidden news-card-mobile">
                            <div class="overlay overflow-hidden position-relative">
                                <?= img_lazy('uploads/news/' . $news['image'], $news['title'], ['class' => 'w-100 h-200px object-fit-cover card-img-custom']) ?>
                            </div>

                            <div class="card-body p-4 p-md-6 d-flex flex-column h-100">
                                <div class="mb-2">
                                    <span class="text-success fw-bold fs-10 fs-md-8 text-uppercase tracking-widest">
                                        <?= $news['category_name'] ?>
                                    </span>
                                </div>

                                <a href="<?= base_url('blog/read/' . $news['slug']) ?>" 
                                   class="text-gray-900 fw-bolder text-hover-success fs-7 fs-md-4 lh-base mb-4 d-block title-clamp">
                                    <?= $news['title'] ?>
                                </a>

                                <div class="d-flex align-items-center mt-auto pt-2">
                                    <div class="symbol symbol-30px symbol-md-40px symbol-circle me-3 flex-shrink-0">
                                        <div class="symbol-label fw-bold bg-light-success text-success fs-7">
                                            <?= strtoupper(substr($news['author'], 0, 1)) ?>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column min-w-0">
                                        <span class="text-gray-900 fw-bold fs-9 fs-md-7 text-truncate mb-1">
                                            <?= $news['author'] ?>
                                        </span>
                                        
                                        <div class="d-flex align-items-center text-nowrap gap-2">
                                            <div class="d-flex align-items-center text-gray-500">
                                                <i class="ki-outline ki-calendar fs-10 fs-md-6 me-1"></i>
                                                <span class="fs-10 fs-md-8"><?= date('d M y', strtotime($news['created_at'])) ?></span>
                                            </div>

                                            <div class="d-flex align-items-center text-gray-500">
                                                <i class="ki-outline ki-eye fs-10 fs-md-6 me-1"></i>
                                                <span class="fs-10 fs-md-8"><?= number_format($news['views'] ?? 0, 0, ',', '.') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>