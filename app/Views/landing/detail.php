<?= $this->extend('pages/layoutLanding') ?>
<?= $this->section('content') ?>

<div class="py-10 py-lg-20">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row">

            <div class="flex-column flex-lg-row-auto w-100 w-lg-300px mb-10 mb-lg-0 me-lg-15">

                <div class="card card-flush shadow-sm mb-10">
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

                <div class="card card-flush shadow-sm mb-10">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Kategori</span>
                            <span class="w-40px h-3px bg-success rounded mt-1"></span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="d-flex flex-column gap-4">
                            <?php foreach ($categories as $cat): ?>
                                <a href="<?= base_url('blog?category=' . $cat->category_slug) ?>" class="d-flex flex-stack text-gray-700 text-hover-success fw-semibold">
                                    <span><?= $cat->category_name ?></span>
                                    <span class="badge badge-light-success">(<?= $cat->total ?>)</span>
                                </a>
                                <div class="separator separator-dashed"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="card card-flush shadow-sm mb-10">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Postingan Populer</span>
                            <span class="w-40px h-3px bg-success rounded mt-1"></span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <?php foreach ($popular_posts as $post): ?>
                            <div class="d-flex align-items-center mb-7">
                                <div class="symbol symbol-60px symbol-2by3 me-4">
                                    <img src="<?= base_url('uploads/news/' . $post['image']) ?>" class="object-fit-cover" alt="<?= $post['title'] ?>" />
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="<?= base_url('blog/read/' . $post['slug']) ?>" class="text-dark fw-bold text-hover-success fs-6 mb-1">
                                        <?= character_limiter($post['title'], 40) ?>
                                    </a>
                                    <span class="text-muted fw-semibold fs-8"><?= date('d M Y', strtotime($post['created_at'])) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card card-flush shadow-sm">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Tag Terpopuler</span>
                            <span class="w-40px h-3px bg-success rounded mt-1"></span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($popular_tags as $tag): ?>
                                <a href="<?= base_url('blog?tag=' . $tag->tag_slug) ?>" class="btn btn-sm btn-light-success fw-bold">
                                    <?= $tag->tag_name ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-lg-row-fluid">
                <div class="mb-10">
                    <div class="mb-8 rounded overflow-hidden">
                        <img src="<?= base_url('uploads/news/' . $news['image']) ?>" class="w-100 object-fit-cover h-lg-450px" alt="<?= $news['title'] ?>" />
                    </div>

                    <div class="d-flex align-items-center flex-wrap mb-5 text-muted fw-semibold fs-7 text-uppercase">
                        <div class="d-flex align-items-center me-5">
                            <i class="ki-duotone ki-user fs-4 me-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                            BY <span class="ms-1"><?= strtoupper($news['author']) ?></span>
                        </div>
                        <div class="d-flex align-items-center me-5">
                            <i class="ki-duotone ki-calendar fs-4 me-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                            <?= tglIndo($news['created_at']) ?>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-eye fs-4 me-1 text-success">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                            <?= number_format($news['views'], 0, ',', '.') ?>
                        </div>
                    </div>

                    <h1 class="text-dark fw-bold mb-8 fs-2qx"><?= $news['title'] ?></h1>

                    <div class="fs-5 fw-normal text-gray-800 lh-lg text-justify content-rich-text">
                        <?= $news['content'] ?>
                    </div>
                    <div class="separator separator-dashed border-gray-300 my-10"></div>

                    <div class="d-flex flex-column mb-10">
                        <h4 class="text-dark fw-bold mb-5">Tag Terkait:</h4>
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!empty($news_tags)): ?>
                                <?php foreach ($news_tags as $tag): ?>
                                    <a href="<?= base_url('blog?tag=' . $tag->tag_slug) ?>"
                                        class="btn btn-sm btn-light-success fw-bold px-4 py-2 text-uppercase fs-8">
                                        <i class="ki-outline ki-tag fs-6 me-1"></i>
                                        <?= $tag->tag_name ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted fs-7 italic">Tidak ada tag terkait.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>