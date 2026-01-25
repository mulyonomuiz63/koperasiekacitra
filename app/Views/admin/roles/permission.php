<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<?php
function renderMenuRows(array $menus, array $permissions, int $level = 0)
{
    foreach ($menus as $menu) {

        $perm = $permissions[$menu['id']] ?? null;
        $hasChild = !empty($menu['children']);
        $isParent = $level === 0;
        $disableCrud = $hasChild;

        $padding = 24 * $level;
?>

        <tr class="<?= $isParent ? 'bg-light' : '' ?>">
            <td style="padding-left: <?= $padding ?>px">
                <div class="d-flex align-items-center">
                    <?php if ($isParent): ?>
                        <i class="bi bi-folder-fill text-primary me-2"></i>
                        <span class="fw-bold"><?= esc($menu['name']) ?></span>
                    <?php else: ?>
                        <i class="bi bi-arrow-return-right text-muted me-2"></i>
                        <?= esc($menu['name']) ?>
                    <?php endif; ?>
                </div>
            </td>

            <!-- VIEW -->
            <td class="text-center">
                <input type="checkbox"
                    class="form-check-input"
                    name="permissions[<?= $menu['id'] ?>][view]"
                    value="1"
                    <?= $perm && $perm['can_view'] ? 'checked' : '' ?>
                    >
            </td>

            <!-- CRUD -->
            <?php foreach (['create', 'update', 'delete'] as $act): ?>
                <td class="text-center">
                    <input type="checkbox"
                        class="form-check-input"
                        name="permissions[<?= $menu['id'] ?>][<?= $act ?>]"
                        value="1"
                        <?= $perm && $perm['can_' . $act] ? 'checked' : '' ?>
                        <?= $disableCrud ? 'disabled' : '' ?>>
                </td>
            <?php endforeach; ?>
        </tr>

<?php
        if ($hasChild) {
            renderMenuRows($menu['children'], $permissions, $level + 1);
        }
    }
}
?>

<div class="card card-flush">

    <div class="card-header align-items-center py-5">
        <div class="card-title">
            <h2 class="fw-bold mb-0">Setting Permission Role</h2>
            <span class="text-muted fs-7 ms-2">Atur hak akses menu</span>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('roles') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body pt-6">
        <form method="post" action="<?= base_url('roles/permission/save') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="role_id" value="<?= esc($role_id) ?>">

            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-4">
                    <thead>
                        <tr class="text-gray-500 fw-bold fs-7 text-uppercase">
                            <th>Menu</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Create</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>

                    <tbody class="fw-semibold text-gray-700">
                        <?php renderMenuRows($menus, $rolePermissions); ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end pt-6 gap-2">
                <a href="<?= base_url('roles') ?>" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-save me-1"></i> Simpan Permission
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>