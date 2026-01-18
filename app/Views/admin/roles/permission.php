<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">

    <!--begin::Card header-->
    <div class="card-header align-items-center py-5">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Setting Permission Role
            </h2>
            <span class="text-muted fs-7 ms-2">
                Atur hak akses menu untuk role
            </span>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('roles') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-6">

        <form method="post" action="<?= base_url('roles/permission/save') ?>">
            <?= csrf_field() ?>

            <input type="hidden" name="role_id" value="<?= $role_id ?>">

            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-4">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                            <th>Menu</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Create</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>

                    <tbody class="fw-semibold text-gray-700">

                        <?php foreach ($menus as $m):
                            $perm        = $rolePermissions[$m->id] ?? null;
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

                            <!-- VIEW (SELALU ADA) -->
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
                                        <!-- HIDDEN UNTUK PARENT YANG PUNYA SUBMENU -->
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

            <!--begin::Actions-->
            <div class="d-flex justify-content-end pt-6 gap-2">
                <a href="<?= base_url('roles') ?>" class="btn btn-light">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-save me-1"></i> Simpan Permission
                </button>
            </div>
            <!--end::Actions-->

        </form>

    </div>
    <!--end::Card body-->

</div>

<?= $this->endSection() ?>
