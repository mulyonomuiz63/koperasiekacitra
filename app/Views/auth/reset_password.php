<?= $this->extend('auth/pages/layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10 shadow-sm border border-gray-200">
        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-10">

                <form class="form w-100" id="form-reset">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= esc($token) ?>">

                    <div class="text-center mb-11">
                        <div class="mb-7 animate__animated animate__fadeInDown">
                            <span class="d-inline-block shadow-sm rounded-circle p-4 bg-light">
                                <i class="ki-outline ki-key fs-3x text-primary bounce-on-hover"></i>
                            </span>
                        </div>
                        <h1 class="text-gray-900 fw-boldest mb-3 fs-2qx tracking-tight">Atur Ulang Password</h1>
                        <div class="text-gray-500 fw-semibold fs-6"> Masukkan password baru yang kuat </div>
                    </div>

                    <div class="fv-row mb-7" data-kt-password-meter="true">
                        <div class="position-relative mb-3">
                            <i class="ki-outline ki-lock fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                            <input type="password"
                                id="password"
                                name="password"
                                class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                                placeholder="Password Baru"
                                required>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                <i class="ki-outline ki-eye-slash fs-2 text-gray-500"></i>
                                <i class="ki-outline ki-eye fs-2 text-gray-500 d-none"></i>
                            </span>
                        </div>
                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>
                        <div class="text-muted fs-8"> Gunakan 8+ karakter dengan kombinasi huruf & angka. </div>
                    </div>

                    <div class="fv-row mb-10 position-relative">
                        <i class="ki-outline ki-shield-tick fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                        <input type="password"
                            id="password_confirm"
                            name="password_confirm"
                            class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                            placeholder="Konfirmasi Password"
                            required>
                        <div class="invalid-feedback ms-1">Password tidak cocok!</div>
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit" id="btn-reset" class="btn btn-primary fw-bold py-4 shadow-sm hover-elevate-up">
                            <span class="indicator-label">Simpan Password Baru</span>
                        </button>
                    </div>

                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Batal reset? <a href="<?= base_url('login') ?>" class="link-primary fw-bolder ms-1">Kembali ke Login</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<style>
    .form-control-solid:focus {
        background-color: #f1f1f4 !important;
        border-color: #009ef7 !important;
    }

    .hover-elevate-up:hover {
        transform: translateY(-2px);
        transition: 0.3s ease;
    }

    .bounce-on-hover:hover {
        animation: bounce 0.5s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const formReset = document.getElementById('form-reset');
    const btnReset = document.getElementById('btn-reset');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirm');

    const csrfNameEl = document.querySelector('meta[name="csrf-name"]');
    const csrfHashEl = document.querySelector('meta[name="csrf-hash"]');
    let csrfName = csrfNameEl.content;
    let csrfHash = csrfHashEl.content;

    // Real-time validasi kecocokan password
    function validatePassword() {
        if (confirmInput.value.length > 0) {
            if (passwordInput.value !== confirmInput.value) {
                confirmInput.classList.add('is-invalid');
                btnReset.disabled = true;
            } else {
                confirmInput.classList.remove('is-invalid');
                confirmInput.classList.add('is-valid');
                btnReset.disabled = false;
            }
        }
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validatePassword);

    formReset.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validasi Akhir
        if (passwordInput.value !== confirmInput.value) {
            Swal.fire('Gagal', 'Konfirmasi password tidak cocok!', 'error');
            return;
        }

        btnReset.disabled = true;
        btnReset.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Menyimpan...';

        const formData = new FormData(formReset);
        formData.append(csrfName, csrfHash);

        fetch("<?= base_url('reset-password') ?>", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // Update CSRF
                csrfHash = data.csrfHash;
                if (csrfHashEl) csrfHashEl.content = data.csrfHash;

                if (data.status === 'error') {
                    Swal.fire('Gagal', data.message, 'error');
                    btnReset.disabled = false;
                    btnReset.innerHTML = 'Simpan Password Baru';
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        confirmButtonText: 'Login Sekarang'
                    }).then(() => {
                        window.location.href = "<?= base_url('login') ?>";
                    });
                }
            })
            .catch(err => {
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                btnReset.disabled = false;
                btnReset.innerHTML = 'Simpan Password Baru';
            });
    });
</script>
<?= $this->endSection() ?>