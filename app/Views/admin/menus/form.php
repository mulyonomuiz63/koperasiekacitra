<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>
<div class="card card-flush">

    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h2 class="fw-bold">
                <?= isset($menu) ? 'Edit Menu' : 'Tambah Menu' ?>
            </h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('menus') ?>" class="btn btn-light">
                Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">

        <form method="post"
                action="<?= isset($menu)
                    ? base_url('menus/update/' . $menu['id'])
                    : base_url('menus/store') ?>">

            <?= csrf_field() ?>

            <div class="row g-5">

                <!-- Nama Menu -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold required">
                        Nama Menu
                    </label>
                    <input type="text"
                            name="name"
                            class="form-control form-control-solid"
                            placeholder="Contoh: Master User"
                            value="<?= $menu['name'] ?? '' ?>"
                            required>
                </div>

                <!-- URL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        URL
                    </label>
                    <input type="text"
                            name="url"
                            class="form-control form-control-solid"
                            placeholder="/users"
                            value="<?= $menu['url'] ?? '' ?>">
                </div>

                <!-- Icon -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Icon
                    </label>
                    <input type="text"
                            name="icon"
                            class="form-control form-control-solid"
                            placeholder="ki-solid ki-user"
                            value="<?= $menu['icon'] ?? '' ?>">
                    <div class="form-text">
                        Gunakan icon Metronic (ki-solid / ki-outline)
                    </div>
                </div>

                <!-- Parent Menu -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Parent Menu
                    </label>
                    <select name="parent_id"
                            class="form-select form-select-solid">
                        <option value="">-- Tidak Ada --</option>
                        <?php foreach ($parents as $p): ?>
                            <option value="<?= $p['id'] ?>"
                                <?= isset($menu) && $menu['parent_id'] == $p['id'] ? 'selected' : '' ?>>
                                <?= esc($p['name']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Urutan -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Urutan Menu
                    </label>
                    <input type="number"
                            name="menu_order"
                            class="form-control form-control-solid"
                            min="0"
                            value="<?= $menu['menu_order'] ?? 0 ?>">
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold d-block">
                        Status
                    </label>
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?= !isset($menu) || ($menu['is_active'] ?? 1) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold">
                            Aktif
                        </label>
                    </div>
                </div>

            </div>

            <!-- Action -->
            <div class="separator my-8"></div>

            <div class="d-flex justify-content-end gap-3">
                <a href="<?= base_url('menus') ?>" class="btn btn-light">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary btn-sm">
                    Simpan Menu
                </button>
            </div>

        </form>

    </div>
    <!--end::Card body-->

</div>
<?= $this->endSection() ?>
