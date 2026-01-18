<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">

    <!-- HEADER -->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Permission User (Override)
            </h2>
            <span class="text-muted fs-7">
                Permission di sini akan menimpa permission role
            </span>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('users') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body pt-6">

        <form method="post" action="<?= base_url('users/permission/save') ?>">
            <?= csrf_field() ?>

            <input type="hidden" name="user_id" value="<?= $user_id ?>">

            <div class="table-responsive">
                <table class="table table-row-bordered table-row-gray-200 align-middle gs-7">

                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-200px">Menu</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Create</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>

                    <tbody class="fw-semibold text-gray-700">

                    <?php foreach ($menus as $m):
                        $perm        = $userPermissions[$m->id] ?? null;
                        $isParent    = empty($m->parent_id);
                        $hasSubmenu  = $m->has_child ?? false;
                        $disableCrud = $isParent && $hasSubmenu;
                    ?>

                        <tr class="<?= $isParent ? 'bg-light' : '' ?>">

                            <!-- MENU NAME -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if ($isParent): ?>
                                        <i class="bi bi-folder-fill text-primary me-2"></i>
                                        <span class="fw-bold"><?= esc($m->name) ?></span>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-return-right text-muted me-2"></i>
                                        <?= esc($m->name) ?>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- VIEW -->
                            <td class="text-center">
                                <div class="form-check form-check-custom form-check-solid justify-content-center">
                                    <input
                                        class="form-check-input h-20px w-20px"
                                        type="checkbox"
                                        name="permissions[<?= $m->id ?>][view]"
                                        value="1"
                                        <?= $perm && $perm['can_view'] ? 'checked' : '' ?>
                                    >
                                </div>
                            </td>

                            <!-- CREATE / UPDATE / DELETE -->
                            <?php foreach (['create','update','delete'] as $act): ?>
                                <td class="text-center">
                                    <?php if ($disableCrud): ?>
                                        <span class="text-muted fs-7">—</span>
                                    <?php else: ?>
                                        <div class="form-check form-check-custom form-check-solid justify-content-center">
                                            <input
                                                class="form-check-input h-20px w-20px"
                                                type="checkbox"
                                                name="permissions[<?= $m->id ?>][<?= $act ?>]"
                                                value="1"
                                                <?= $perm && $perm['can_'.$act] ? 'checked' : '' ?>
                                            >
                                        </div>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-end mt-6">
                <button class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-save me-1"></i> Simpan Permission
                </button>
                <a href="<?= base_url('users') ?>" class="btn btn-light">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection() ?>
