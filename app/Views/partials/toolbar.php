<?php
$breadcrumbs = getMenuBreadcrumb(uri_string());

// Ambil MENU UTAMA (bukan action)
$pageTitle = 'Dashboard';
foreach ($breadcrumbs as $bc) {
    if (!preg_match('/^(list|tambah|edit)/i', $bc['name'])) {
        $pageTitle = $bc['name'];
    }
}
?>

<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container"
        class="app-container container-fluid d-flex flex-stack">

        <div class="page-title d-flex flex-column justify-content-center me-3">

            <!-- TITLE -->
            <h1 class="page-heading text-dark fw-bold fs-3 my-0">
                <?= esc($pageTitle) ?>
            </h1>

            <!-- BREADCRUMB -->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                <!-- HOME -->
                <li class="breadcrumb-item text-muted">
                    <a href="<?= base_url('/dashboard') ?>" class="text-muted text-hover-primary">
                        Home
                    </a>
                </li>

                <?php foreach ($breadcrumbs as $i => $bc): ?>
                    <!-- ICON > -->
                    <li class="breadcrumb-item">
                        <span class="svg-icon svg-icon-5 svg-icon-gray-400 mx-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9 18L15 12L9 6"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </li>

                    <!-- ITEM -->
                    <li class="breadcrumb-item <?= $i === array_key_last($breadcrumbs) ? 'text-dark fw-bold' : 'text-muted' ?>">
                        <?php if (!empty($bc['url']) && $i !== array_key_last($breadcrumbs)): ?>
                            <a href="<?= base_url($bc['url']) ?>" class="text-muted text-hover-primary">
                                <?= esc($bc['name']) ?>
                            </a>
                        <?php else: ?>
                            <?= esc($bc['name']) ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>
