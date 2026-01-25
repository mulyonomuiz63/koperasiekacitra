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
                    <i class="ki-duotone ki-left fs-3"></i>
                </button>
                <button class="btn btn-icon btn-sm btn-light-success btn-circle border-0" id="kt_news_slider_next">
                    <i class="ki-duotone ki-right fs-3"></i>
                </button>
            </div>
        </div>

        <div class="tns-default position-relative" data-aos="fade-up">
            <div
                data-tns="true"
                data-tns-loop="false"
                data-tns-speed="1000"
                data-tns-autoplay="false"
                data-tns-autoplay-timeout="5000"
                data-tns-nav="false"
                data-tns-items="1"
                data-tns-prev-button="#kt_news_slider_prev"
                data-tns-next-button="#kt_news_slider_next"
                data-tns-responsive='{"768": {"items": 2}, "1200": {"items": 4}}'>

                <?php foreach ($latest_news as $news): ?>
                    <div class="px-5"> <div class="card card-flush shadow-sm h-100 rounded-4 overflow-hidden">
                            <div class="overlay overflow-hidden">
                                <div class="overlay-wrapper">
                                    <img src="<?= base_url('uploads/news/' . $news['image']) ?>"
                                         alt="<?= $news['title'] ?>"
                                         class="w-100 h-200px object-fit-cover">
                                </div>
                                <div class="position-absolute top-0 start-0 m-4">
                                    <span class="badge badge-success fw-bold px-3 py-2 text-uppercase fs-9 shadow-sm">
                                        <?= $news['category_name'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-6 d-flex flex-column">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="symbol symbol-30px symbol-circle me-3">
                                        <div class="symbol-label fw-bold bg-light-success text-success fs-3">
                                            <?= strtoupper(substr($news['author'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-wrap flex-grow-1">
                                        <span class="text-gray-800 fw-bold fs-9 me-3"><?= $news['author'] ?></span>
                                        <div class="d-flex align-items-center text-gray-500 fs-8">
                                            <i class="ki-outline ki-calendar fs-3 me-1"></i>
                                            <?= date('d M Y', strtotime($news['created_at'])) ?>
                                        </div>
                                    </div>
                                </div>

                                <a href="<?= base_url('blog/read/' . $news['slug']) ?>"
                                   class="text-gray-900 fw-bolder text-hover-success fs-5 lh-base"
                                   style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">
                                    <?= $news['title'] ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>