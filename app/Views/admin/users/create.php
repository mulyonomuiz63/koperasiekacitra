<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">

    <!-- HEADER -->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">Tambah User</h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('users') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body pt-6">

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('users/store') ?>" autocomplete="off">
            <?= csrf_field() ?>

            <!-- USERNAME -->
            <div class="mb-5">
                <label class="form-label required">Username</label>
                <input type="text"
                       name="username"
                       value="<?= old('username') ?>"
                       class="form-control"
                       placeholder="contoh: admin01"
                       required>
            </div>

            <!-- EMAIL -->
            <div class="mb-5">
                <label class="form-label required">Email</label>
                <input type="email"
                       name="email"
                       value="<?= old('email') ?>"
                       class="form-control"
                       placeholder="email@domain.com"
                       required>
            </div>

            <!-- ROLE -->
            <div class="mb-5">
                <label class="form-label required">Role</label>
                <select name="role_id" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r->id ?>" <?= old('role_id') == $r->id ? 'selected' : '' ?>>
                            <?= esc($r->name) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- PASSWORD -->
            <div class="mb-5" data-kt-password-meter="true">
                <label class="form-label required">Password</label>

                <div class="position-relative mb-3">
                    <input type="password"
                        name="password"
                        class="form-control form-control-lg"
                        autocomplete="new-password" />

                    <!-- Toggle -->
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                        data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>

                <!-- Strength meter -->
                <div class="d-flex align-items-center mb-3"
                    data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>

                <!-- Hint -->
                <div class="text-muted">
                    Password minimal 5 karakter, mengandung:
                    <ul class="ps-5 mb-0">
                        <li>Huruf kecil</li>
                        <li>Huruf besar</li>
                        <li>Angka</li>
                        <li>Karakter khusus</li>
                    </ul>
                </div>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-5">
                <label class="form-label required">Konfirmasi Password</label>
                <input type="password"
                    name="password_confirm"
                    class="form-control form-control-lg"
                    required>
            </div>


            <!-- ACTION -->
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary me-2">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="<?= base_url('users') ?>" class="btn btn-light">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection() ?>
