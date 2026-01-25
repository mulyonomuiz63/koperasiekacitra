<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">

    <!--begin::Card header-->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Tambah Role
            </h2>
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

        <form method="post" action="<?= base_url('roles/store') ?>" class="form">
            <?= csrf_field() ?>

            <!-- NAMA ROLE -->
            <div class="mb-5">
                <label class="required form-label">Nama Role</label>
                <input type="text"
                       name="name"
                       class="form-control form-control-solid"
                       placeholder="Contoh: Bendahara"
                       value="<?= old('name') ?>"
                       required>
                <div class="form-text">
                    Nama role akan digunakan untuk pengaturan hak akses
                </div>
            </div>

            <div class="mb-5">
                <label class="required form-label">Role Key</label>
                <select name="role_key" class="form-select form-select-solid" data-allow-clear="true">
                        <option value="ADMIN">ADMIN</option>
                        <option value="ANGGOTA">ANGGOTA</option>
                </select>
                <div class="form-text">
                    Nama key akan digunakan untuk mengarahkan url akan di redirek role mana
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="mb-8">
                <label class="form-label">Deskripsi</label>
                <textarea name="description"
                          class="form-control form-control-solid"
                          rows="3"
                          placeholder="Deskripsi singkat role"><?= old('description') ?></textarea>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-end gap-3">
                <a href="<?= base_url('roles') ?>" class="btn btn-light">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-check2-circle me-1"></i> Simpan
                </button>
            </div>

        </form>

    </div>
    <!--end::Card body-->

</div>

<?= $this->endSection() ?>
