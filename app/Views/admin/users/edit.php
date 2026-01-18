<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">

    <!--begin::Card header-->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">Edit User</h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('users') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
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
        <form method="post" action="<?= base_url('users/update/'.$user['id']) ?>">
            <?= csrf_field() ?>

            <!-- USERNAME -->
            <div class="mb-5">
                <label class="form-label required">Username</label>
                <input type="text"
                    name="username"
                    class="form-control form-control-lg bg-light"
                    value="<?= esc($user['username']) ?>"
                    readonly>

                <div class="text-muted fs-7 mt-1">
                    Username tidak dapat diubah.
                </div>
            </div>


            <!-- EMAIL -->
            <div class="mb-5">
                <label class="form-label required">Email</label>
                <input type="email"
                       name="email"
                       class="form-control form-control-lg"
                       value="<?= esc($user['email']) ?>"
                       required>
            </div>

            <!-- PASSWORD (OPTIONAL) -->
            <div class="mb-5" data-kt-password-meter="true">
                <label class="form-label">
                    Password
                    <span class="text-muted">(kosongkan jika tidak diubah)</span>
                </label>

                <div class="position-relative mb-3">
                    <input type="password"
                           name="password"
                           class="form-control form-control-lg"
                           autocomplete="new-password">

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

                <div class="text-muted fs-7">
                    Minimal 5 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.
                </div>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-5">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password"
                       name="password_confirm"
                       class="form-control form-control-lg">
            </div>

            <!-- ROLE -->
            <div class="mb-5">
                <label class="form-label required">Role</label>
                <select name="role_id"
                        class="form-select form-select-lg"
                        data-control="select2"
                        data-placeholder="Pilih Role"
                        required>
                    <?php foreach($roles as $r): ?>
                        <option value="<?= $r->id ?>"
                            <?= $r->id == $user['role_id'] ? 'selected' : '' ?>>
                            <?= esc($r->name) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- STATUS -->
            <div class="mb-5">
                <label class="form-label required">Status</label>
                <select name="status"
                        class="form-select form-select-lg"
                        required>
                    <option value="active"   <?= $user['status']=='active'?'selected':'' ?>>Active</option>
                    <option value="inactive" <?= $user['status']=='inactive'?'selected':'' ?>>Inactive</option>
                    <option value="blocked"  <?= $user['status']=='blocked'?'selected':'' ?>>Blocked</option>
                </select>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-end gap-3">
                <a href="<?= base_url('users') ?>" class="btn btn-light">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-save me-1"></i> Update User
                </button>
            </div>

        </form>

    </div>
    <!--end::Card body-->

</div>

<?= $this->endSection() ?>
