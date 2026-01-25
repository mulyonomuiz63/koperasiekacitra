<?= $this->extend('pages/layoutLanding') ?>

<?= $this->section('content') ?>
<div class="py-10 py-lg-20">
    <div class="container">
        <div class="mb-12">
            <h1 class="text-dark fw-bold mb-2">
                <?php 
                    if ($keyword) echo 'Pencarian: "' . esc($keyword) . '"';
                    elseif ($current_tag) echo 'Tag: ' . esc(ucwords(str_replace('-', ' ', $current_tag)));
                    elseif ($current_cat) echo 'Kategori: ' . esc(ucwords(str_replace('-', ' ', $current_cat)));
                    else echo 'Berita Terbaru';
                ?>
            </h1>
            <div class="text-muted fs-6 fw-semibold">Menampilkan informasi terkini dan terpercaya</div>
            <div class="w-100px h-5px bg-success rounded mt-5"></div>
        </div>

        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-column flex-lg-row-auto w-100 w-lg-300px mb-10 mb-lg-0 me-lg-15">
                
                <div class="card card-flush shadow-sm mb-10 border-0">
                    <div class="card-body">
                        <form action="<?= base_url('blog') ?>" method="get">
                            <div class="position-relative">
                                <input type="text" name="search" class="form-control form-control-solid ps-4" 
                                       placeholder="Cari berita..." value="<?= esc($keyword ?? '') ?>" />
                                <button type="submit" class="btn btn-icon btn-success position-absolute top-50 end-0 translate-middle-y me-2 h-35px w-35px">
                                    <i class="ki-outline ki-magnifier fs-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-flush shadow-sm mb-10 border-0">
                    <div class="card-header pt-5">
                        <h3 class="card-title fw-bold text-dark">Kategori</h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-column fw-semibold gap-3">
                            <?php foreach ($categories as $cat): ?>
                                <a href="<?= base_url('blog?category=' . $cat->category_slug) ?>"
                                    class="d-flex flex-stack <?= ($current_cat == $cat->category_slug) ? 'text-success' : 'text-gray-700' ?> text-hover-success border-bottom border-bottom-dashed pb-3">
                                    <span class="d-flex align-items-center"><i class="ki-outline ki-right fs-6 me-2"></i><?= $cat->category_name ?></span>
                                    <span class="text-muted fs-7">(<?= $cat->total ?>)</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="card card-flush shadow-sm mb-10 border-0">
                    <div class="card-header pt-5">
                        <h3 class="card-title fw-bold text-dark">Postingan Populer</h3>
                    </div>
                    <div class="card-body pt-5">
                        <?php foreach ($popular_posts as $post): ?>
                            <div class="d-flex align-items-center mb-7">
                                <div class="symbol symbol-70px me-4">
                                    <div class="symbol-label" style="background-image:url('<?= base_url('uploads/news/' . $post['image']) ?>'); background-size: cover; background-position: center;"></div>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="<?= base_url('blog/read/' . $post['slug']) ?>" class="text-dark fw-bold text-hover-success fs-7 mb-1 lh-sm line-clamp-2">
                                        <?= esc($post['title']) ?>
                                    </a>
                                    <span class="text-muted fw-semibold fs-9"><?= date('d M Y', strtotime($post['created_at'])) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card card-flush shadow-sm border-0">
                    <div class="card-header pt-5">
                        <h3 class="card-title fw-bold text-dark">Tags</h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($popular_tags as $tag): ?>
                                <a href="<?= base_url('blog?tag=' . $tag->tag_slug) ?>" 
                                   class="btn btn-sm <?= ($current_tag == $tag->tag_slug) ? 'btn-success' : 'btn-light-success' ?> fw-bold">
                                    <?= $tag->tag_name ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-lg-row-fluid">
                <?php if (!empty($latest_news)): ?>
                    <div class="d-flex flex-column">
                        <?php foreach ($latest_news as $news): ?>
                            <div class="card card-flush shadow-sm mb-10 overflow-hidden border-0 card-hover-shadow">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column flex-md-row">
                                        <div class="main-img-container flex-shrink-0">
                                            <img src="<?= base_url('uploads/news/' . $news['image']) ?>"
                                                class="w-100 h-100 object-fit-cover transition-all hover-scale"
                                                alt="<?= $news['title'] ?>" />
                                        </div>

                                        <div class="p-6 p-md-8 flex-grow-1 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="badge badge-light-success fw-bold px-3 py-2 me-3 fs-9">
                                                    <?= strtoupper($news['category_name']) ?>
                                                </span>
                                                <span class="text-muted fs-8 fw-semibold">
                                                    <?= tglIndo($news['created_at']) ?>
                                                </span>
                                            </div>

                                            <a href="<?= base_url('blog/read/' . $news['slug']) ?>"
                                                class="text-dark fw-bold fs-3 text-hover-success d-block mb-4 lh-base line-clamp-2">
                                                <?= esc($news['title']) ?>
                                            </a>
                                            
                                            <div class="mt-auto d-flex flex-stack flex-wrap">
                                                <a href="<?= base_url('blog/read/' . $news['slug']) ?>"
                                                    class="btn btn-sm btn-light-success fw-bold px-4 py-2">
                                                    BACA SELENGKAPNYA
                                                </a>

                                                <div class="d-flex align-items-center mt-2 mt-sm-0">
                                                    <div class="symbol symbol-25px symbol-circle me-2">
                                                        <div class="symbol-label bg-light-success text-success fw-bold fs-9">
                                                            <?= strtoupper(substr($news['author'], 0, 1)) ?>
                                                        </div>
                                                    </div>
                                                    <span class="text-gray-700 fs-8 fw-bold">By <?= $news['author'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex flex-stack flex-wrap pt-10">
                        <div class="fs-6 fw-bold text-gray-700 mb-4 mb-md-0">
                            Menampilkan <?= count($latest_news) ?> berita
                        </div>
                        <div class="pagination-wrapper">
                            <?= $pager->links('news_group', 'metronic') ?>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="card shadow-sm mt-5 border-0">
                        <div class="card-body text-center py-20">
                            <i class="ki-outline ki-search-list fs-5x text-gray-300 mb-5"></i>
                            <h3 class="text-gray-600">Berita tidak ditemukan...</h3>
                            <a href="<?= base_url('blog') ?>" class="btn btn-success mt-5">Kembali ke Beranda</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Main List Image */
    .main-img-container {
        width: 300px; 
        height: 230px; 
        overflow: hidden;
    }

    /* Perbaikan Postingan Populer Sidebar */
    .symbol.symbol-70px .symbol-label {
        width: 70px;
        height: 70px;
        border-radius: 8px;
    }

    .hover-scale {
        transition: transform 0.4s ease-in-out;
    }
    .card:hover .hover-scale {
        transform: scale(1.08);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        word-break: break-word;
    }

    /* Responsive Mobile */
    @media (max-width: 767.98px) {
        .main-img-container {
            width: 100% !important;
            height: 200px !important;
            border-radius: 0.75rem 0.75rem 0 0;
        }
        
        .p-6 {
            padding: 1.5rem !important;
        }

        .fs-3 {
            font-size: 1.25rem !important;
        }

        /* Sidebar adjustment on mobile */
        .symbol.symbol-70px {
            width: 60px;
            height: 60px;
        }
        .symbol.symbol-70px .symbol-label {
            width: 60px;
            height: 60px;
        }
    }

    .card-hover-shadow {
        transition: all 0.3s ease;
    }
    .card-hover-shadow:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.07) !important;
        transform: translateY(-2px);
    }
</style>
<?= $this->endSection(); ?>