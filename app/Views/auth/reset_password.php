<?= $this->extend('auth/pages/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10 shadow-sm border border-gray-200">

        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

                <form class="form w-100" id="form-reset">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= esc($token) ?>">

                    <div class="text-center mb-11">
                        <h1 class="text-dark fw-bolder mb-3 fs-1">Reset Password</h1>
                        <div class="text-gray-500 fw-semibold fs-6">
                            Gunakan kombinasi password yang kuat
                        </div>
                    </div>

                    <div class="fv-row mb-8" data-kt-password-meter="true">
                        <div class="position-relative mb-3">
                            <i class="ki-outline ki-lock fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                                   placeholder="Password Baru"
                                   autocomplete="off"
                                   required>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                  data-kt-password-meter-control="visibility">
                                <i class="ki-outline ki-eye-slash fs-2 text-gray-500"></i>
                                <i class="ki-outline ki-eye fs-2 text-gray-500 d-none"></i>
                            </span>
                        </div>

                        <div class="d-flex align-items-center mb-2" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>
                        <div class="text-muted fs-8" id="password-hint">
                            Minimal 8 karakter dengan kombinasi huruf dan angka.
                        </div>
                    </div>

                    <div class="fv-row mb-8 position-relative">
                        <i class="ki-outline ki-shield-tick fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                        <input type="password"
                               id="password_confirm"
                               name="password_confirm"
                               class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                               placeholder="Ulangi Password Baru"
                               required>
                        <div class="invalid-feedback ms-1" id="confirm-error">Konfirmasi password tidak cocok.</div>
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit"
                                id="btn-reset"
                                class="btn btn-primary fw-bold py-4 shadow-sm hover-elevate-up"
                                disabled>
                            <span class="indicator-label">Simpan Password</span>
                        </button>
                    </div>

                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Batal reset? 
                        <a href="<?= base_url('login') ?>" class="link-primary fw-bolder ms-1">Kembali ke Login</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<style>
    .hover-elevate-up:hover {
        transform: translateY(-2px);
        transition: 0.3s ease;
    }
    /* Mengubah warna hint jika valid */
    .text-success-custom { color: #17c653 !important; }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const formReset      = document.getElementById('form-reset');
const btnReset       = document.getElementById('btn-reset');
const passwordInput  = document.getElementById('password');
const confirmInput   = document.getElementById('password_confirm');
const passwordHint   = document.getElementById('password-hint');

const csrfNameEl = document.querySelector('meta[name="csrf-name"]');
const csrfHashEl = document.querySelector('meta[name="csrf-hash"]');

let csrfName = csrfNameEl.content;
let csrfHash = csrfHashEl.content;


function isPasswordStrong(password) {
    // Cek minimal 8 karakter, harus ada huruf (A-Z) DAN angka (0-9)
    const hasLength = password.length >= 8;
    const hasLetter = /[A-Za-z]/.test(password);
    const hasNumber = /\d/.test(password);
    
    return hasLength && hasLetter && hasNumber;
}

function validateForm() {
    const pass = passwordInput.value;
    const conf = confirmInput.value;
    
    const isStrong = isPasswordStrong(pass);
    const isMatch  = (pass === conf && conf.length > 0);

    // Update UI Hint Password
    if (pass.length > 0) {
        if (isStrong) {
            passwordHint.classList.add('text-success-custom');
            passwordHint.innerHTML = '<i class="ki-outline ki-check-circle fs-7 text-success"></i> Keamanan password terpenuhi.';
        } else {
            passwordHint.classList.remove('text-success-custom');
            passwordHint.innerHTML = 'Minimal 8 karakter dengan kombinasi huruf dan angka.';
        }
    }

    // Update UI Konfirmasi
    if (conf.length > 0) {
        if (!isMatch) {
            confirmInput.classList.add('is-invalid');
            confirmInput.classList.remove('is-valid');
        } else {
            confirmInput.classList.remove('is-invalid');
            confirmInput.classList.add('is-valid');
        }
    }

    // DEBUG: Hapus tanda komentar di bawah ini jika ingin cek di console browser
    // console.log("Kuat:", isStrong, "Cocok:", isMatch);

    // AKTIFKAN TOMBOL
    if (isStrong && isMatch) {
        btnReset.disabled = false;
    } else {
        btnReset.disabled = true;
    }
}

passwordInput.addEventListener('input', validateForm);
confirmInput.addEventListener('input', validateForm);

formReset.addEventListener('submit', function(e){
    e.preventDefault();

    btnReset.disabled = true;
    btnReset.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Menyimpan...';

    const formData = new FormData(formReset);
    formData.append(csrfName, csrfHash);

    fetch("<?= base_url('reset-password') ?>", {
        method: "POST",
        headers: { "X-Requested-With": "XMLHttpRequest" },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        csrfHash = data.csrfHash;
        csrfHashEl.content = data.csrfHash;

        if (data.status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message,
                customClass: { confirmButton: 'btn btn-danger' }
            });
            btnReset.disabled = false;
            btnReset.innerHTML = 'Simpan Password';
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Password telah diperbarui.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => window.location.href = "<?= base_url('login') ?>");
        }
    })
    .catch(err => {
        Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
        btnReset.disabled = false;
        btnReset.innerHTML = 'Simpan Password';
    });
});
</script>
<?= $this->endSection() ?>