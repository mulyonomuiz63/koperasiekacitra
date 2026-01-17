<?php
$alerts = [
    'success' => 'success',
    'error'   => 'danger',
    'warning' => 'warning',
    'info'    => 'info',
];
?>

<?php foreach ($alerts as $key => $type): ?>
    <?php if (session()->getFlashdata($key)): ?>
        <div class="alert alert-<?= $type ?> d-flex align-items-center alert-dismissible fade show">
            <i class="ki-duotone ki-<?= $key == 'success' ? 'check-circle' : ($key == 'error' ? 'cross-circle' : 'information-5') ?> fs-2hx me-4">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>

            <div class="d-flex flex-column">
                <h4 class="mb-1 text-dark">
                    <?= ucfirst($key) ?>
                </h4>
                <span><?= session()->getFlashdata($key) ?></span>
            </div>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>
<?php endforeach ?>
