<?= $this->extend('pages/layoutAnggota') ?>
<?= $this->section('content') ?>

<div class="card card-flush mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <div class="me-7 mb-4">
                <div class="image-input image-input-outline position-relative" data-kt-image-input="true">

                    <div class="image-input-wrapper symbol symbol-100px symbol-lg-160px" style="width: 120px; height: 120px; overflow: hidden; border-radius: 50%;">
                        <?= img_lazy(get_user_avatar(session()->get('user_id')), 'Profile', ['class'  => 'img-fluid rounded shadow-sm', 'style' => 'width: 100%; height: 100%; object-fit: cover']) ?>
                    </div>

                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow position-absolute translate-middle bottom-0 start-100 mb-6" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah Avatar">
                        <i class="ki-outline ki-pencil fs-7"></i>
                        <input type="file" name="avatar" id="avatar-input" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="avatar_remove" />
                    </label>

                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $user['nama'] ?></a>
                            <i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                <i class="ki-outline ki-profile-circle fs-4 me-1"></i><?= $user['nama_jabatan'] ?>
                            </span>
                            <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                <i class="ki-outline ki-geolocation fs-4 me-1"></i><?= $user['alamat'] ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap flex-stack">
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                            <div class="fs-2 fw-bold">Rp <?= ringkas_uang($total_saldo) ?></div>
                        </div>
                        <div class="fw-semibold fs-6 text-gray-400">Saldo Iuran</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <div id="view_profil">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold m-0">Detail Profil</h3>
            </div>
            <button class="btn btn-sm btn-primary align-self-center" onclick="toggleEdit(true)">Edit Profile</button>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $user['nama'] ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Perusahaan</label>
                <div class="col-lg-8"><span class="fw-semibold text-gray-800 fs-6"><?= $user['nama_perusahaan'] ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">E-mail</label>
                <div class="col-lg-8 d-flex align-items-center">
                    <span class="fw-bold fs-6 text-gray-800 me-2"><?= $user['email'] ?></span>
                    <span class="badge badge-success">Verified</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
                <div class="col-lg-8"><span class="fw-semibold fs-6 text-gray-800"><?= $user['alamat'] ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Jenis Kelamin</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $user['jenis_kelamin'] === 'L' ? 'Laki-Laki' : 'Perempuan' ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Angkatan</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $user['angkatan'] ?></span></div>
            </div>
        </div>
    </div>

    <div id="form_edit" style="display: none;">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold m-0">Edit Data Profil</h3>
            </div>
            <button class="btn btn-sm btn-light align-self-center" onclick="toggleEdit(false)">Batal</button>
        </div>
        <div class="card-body p-9">
            <form action="<?= base_url('sw-anggota/profil/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama'] ?? $user['nama']) ?>" required>
                        <input type="hidden" name="pegawai_id" value="<?= $user['id'] ?>">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">NIK</label>
                        <input type="number" name="nik" class="form-control" value="<?= old('nik', $user['nik'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" data-control="select2" required>
                            <option value="L" <?= old('jenis_kelamin', $user['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= old('jenis_kelamin', $user['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Tanggal Lahir</label>
                        <input type="text" name="tanggal_lahir" class="form-control datepicker-indo" value="<?= old('tanggal_lahir', $user['tanggal_lahir'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir', $user['tempat_lahir'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">No HP</label>
                        <input type="number" name="no_hp" class="form-control" value="<?= old('no_hp', $user['no_hp'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= old('alamat', $user['alamat'] ?? $user['alamat']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Angkatan <span style="opacity: 0.6; font-size: 0.9em;">(Isi 0 untuk yang tidak memiliki angkatan)</span></label>
                        <input type="number" name="angkatan" class="form-control" value="<?= old('angkatan', $user['angkatan'] ?? '0') ?>">
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <button type="button" class="btn btn-light" onclick="toggleEdit(false)">Batal</button>
                    <button type="submit" class="btn btn-primary px-10 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Keamanan & Password</h3>
        </div>
    </div>

    <div id="kt_account_signin_method" class="collapse show">
        <div class="card-body border-top p-9">
            <div id="password_display" class="d-flex flex-wrap align-items-center">
                <div id="password_summary">
                    <div class="fs-6 fw-bold mb-1">Password</div>
                    <div class="fw-semibold text-gray-600">************</div>
                </div>
                <div id="password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary fw-bold" onclick="togglePasswordEdit(true)">Ubah Password</button>
                </div>
            </div>

            <div id="password_edit" class="flex-row-fluid d-none">
                <form action="<?= base_url('sw-anggota/profil/update-password') ?>" method="post" id="kt_signin_change_password">
                    <?= csrf_field() ?>
                    <div class="row mb-1">
                        <div class="col-lg-6">
                            <div class="fv-row mb-0">
                                <label for="new_password" class="form-label fs-6 fw-bold mb-3">Password Baru</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" name="new_password" id="new_password" placeholder="Masukkan password baru" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="fv-row mb-0">
                                <label for="confirm_password" class="form-label fs-6 fw-bold mb-3">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" name="confirm_password" id="confirm_password" placeholder="Ulangi password baru" required />
                                <div id="password-error-msg" class="invalid-feedback fw-bold">
                                    Konfirmasi password tidak cocok dengan password baru.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-text mb-5 mt-2 text-muted">
                        <i class="ki-duotone ki-information fs-7 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                        Minimal 8 karakter. Pastikan password sulit ditebak untuk keamanan akun Anda.
                    </div>

                    <div class="d-flex mt-5">
                        <button type="submit" class="btn btn-primary me-2 px-6 shadow-sm">Simpan Password</button>
                        <button type="button" class="btn btn-light btn-active-light-primary px-6" onclick="togglePasswordEdit(false)">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    document.getElementById('avatar-input').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('avatar', file);
            // Tambahkan CSRF Token jika aktif di CI4 Anda
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            // Tampilkan loading sederhana (Opsional)
            Swal.fire({
                title: 'Mengunggah...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= base_url("sw-anggota/profil/upload-avatar") ?>', {
                    method: 'POST',
                    body: formData,
                    referrerPolicy: 'no-referrer' // Agar tidak mengacaukan redirect()->back()
                })
                .then(response => response.json())
                .then(res => {
                    Swal.close();
                    if (res.status === 'success') {
                        Swal.fire('Berhasil!', 'Foto profil diperbarui.', 'success').then(() => {
                            location.reload(); // Refresh halaman untuk melihat perubahan
                        });
                    } else {
                        Swal.fire('Gagal!', res.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error!', 'Terjadi kesalahan sistem.', err.message);
                });
        }
    });
</script>

<script>
    function toggleEdit(isEdit) {
        const viewSection = document.getElementById('view_profil');
        const formSection = document.getElementById('form_edit');

        if (isEdit) {
            viewSection.style.display = 'none';
            formSection.style.display = 'block';
        } else {
            viewSection.style.display = 'block';
            formSection.style.display = 'none';
        }
    }

    function togglePasswordEdit(show) {
        const display = document.getElementById('password_display');
        const editForm = document.getElementById('password_edit');

        if (show) {
            display.classList.add('d-none');
            editForm.classList.remove('d-none');
        } else {
            display.classList.remove('d-none');
            editForm.classList.add('d-none');
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('kt_signin_change_password');
        const newPass = document.getElementById('new_password');
        const confirmPass = document.getElementById('confirm_password');
        const submitBtn = form.querySelector('button[type="submit"]');

        function validatePassword() {
            const passVal = newPass.value;
            const confirmVal = confirmPass.value;
            
            // Syarat 1: Password minimal 8 karakter
            const isLongEnough = passVal.length >= 8;
            
            // Syarat 2: Password dan Konfirmasi harus cocok
            const isMatch = passVal === confirmVal;

            // Validasi Field Password Baru (Panjang Karakter)
            if (passVal.length > 0) {
                if (!isLongEnough) {
                    newPass.classList.add('is-invalid');
                } else {
                    newPass.classList.remove('is-invalid');
                    newPass.classList.add('is-valid');
                }
            } else {
                newPass.classList.remove('is-invalid', 'is-valid');
            }

            // Validasi Field Konfirmasi (Kecocokan)
            if (confirmVal.length > 0) {
                if (!isMatch) {
                    confirmPass.classList.add('is-invalid');
                    confirmPass.classList.remove('is-valid');
                } else {
                    confirmPass.classList.remove('is-invalid');
                    confirmPass.classList.add('is-valid');
                }
            } else {
                confirmPass.classList.remove('is-invalid', 'is-valid');
            }

            // Aktifkan tombol hanya jika kedua syarat terpenuhi
            submitBtn.disabled = !(isMatch && isLongEnough);
        }

        // Gunakan event 'input' agar perubahan langsung terdeteksi saat mengetik/paste
        newPass.addEventListener('input', validatePassword);
        confirmPass.addEventListener('input', validatePassword);
    });
</script>

<?= $this->endSection() ?>