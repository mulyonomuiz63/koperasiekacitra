<?= $this->extend('auth/pages/layout') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10 shadow-sm border border-gray-200">

        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-10">
                <div id="alert-wrapper"></div>

                <form class="form w-100" id="form-register">
                    <?= csrf_field() ?>
                    
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                    <div class="text-center mb-13">
                        <div class="mb-7 animate__animated animate__fadeInDown">
                            <a href="<?= base_url() ?>" class="d-inline-block shadow-sm rounded-circle p-2 bg-light">
                                <?= img_lazy('uploads/app-icon/' . setting('app_icon'), setting('app_name'), [
                                    'class' => 'h-75px h-lg-100px symbol bounce-on-hover'
                                ]) ?>
                            </a>
                        </div>

                        <h1 class="text-gray-900 fw-boldest mb-3 fs-2qx tracking-tight">
                            Daftar Akun
                        </h1>

                        <div class="text-gray-500 fw-semibold fs-5 d-flex align-items-center justify-content-center">
                                Bergabunglah sebagai anggota koperasi
                        </div>
                    </div>

                    <div class="fv-row mb-7 position-relative">
                        <i class="ki-outline ki-sms fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                        <input type="email"
                            id="email"
                            name="email"
                            class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                            placeholder="Alamat Email Aktif"
                            autocomplete="off">

                        <div class="invalid-feedback ms-1" id="email-error"></div>
                        <div class="valid-feedback ms-1" id="email-success"></div>
                    </div>

                    <div class="fv-row mb-7" data-kt-password-meter="true">
                        <div class="position-relative mb-3">
                            <i class="ki-outline ki-lock fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                            <input type="password"
                                id="password"
                                name="password"
                                class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                                placeholder="Buat Password"
                                required>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                data-kt-password-meter-control="visibility">
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
                        <div class="text-muted fs-8">
                            Gunakan 8+ karakter dengan kombinasi huruf & angka.
                        </div>
                    </div>

                    <div class="fv-row mb-8 position-relative">
                        <i class="ki-outline ki-shield-tick fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                        <input type="password"
                            id="password_confirm"
                            name="password_confirm"
                            class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                            placeholder="Ulangi Password"
                            required>
                        <div class="invalid-feedback">Konfirmasi password tidak cocok.</div>
                    </div>

                    <div class="fv-row mb-10">
                        <label class="form-check form-check-custom form-check-solid form-check-sm">
                            <input class="form-check-input" type="checkbox" id="toc-check" required>
                            <span class="form-check-label fw-semibold text-gray-600 fs-7 ms-2">
                                Saya menyetujui <a href="#" class="link-primary fw-bold">Syarat & Ketentuan</a> layanan.
                            </span>
                        </label>
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit"
                            id="btn-submit"
                            class="btn btn-primary fw-bold py-4 shadow-sm hover-elevate-up"
                            disabled>
                            <span class="indicator-label">Buat Akun Sekarang</span>
                        </button>
                    </div>

                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Sudah punya akun?
                        <a href="<?= base_url('login') ?>" class="link-primary fw-bolder ms-1">
                            Masuk di sini
                        </a>
                    </div>
                    <?php if(setting('client_status') == 'A'): ?>
                        <div class="separator separator-content my-14">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">Atau gunakan akun Google</span>
                        </div>
        
                        <div class="row g-3 mb-9">
                            <div class="col-md-12">
                                <a href="<?= base_url('auth/google/login') ?>" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100 py-3">
                                    <img alt="Logo Google" src="https://fonts.gstatic.com/s/i/productlogos/googleg/v6/24px.svg" class="h-15px me-3" />
                                    Daftar dengan Google
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

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
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if ($siteKey): ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= $siteKey ?>"></script>
<?php endif; ?>

<script>
    const form = document.getElementById('form-register');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirm');
    const btnSubmit = document.getElementById('btn-submit');
    const errorMsg = document.getElementById('email-error');
    const successMsg = document.getElementById('email-success');

    const csrfHashEl = document.querySelector('meta[name="csrf-hash"]');
    const csrfNameEl = document.querySelector('meta[name="csrf-name"]');
    
    let csrfName = csrfNameEl.content;
    let csrfHash = csrfHashEl.content;
    let typingTimer;

    /* ===============================
        FUNGSI RECAPTCHA TOKEN
    ================================ */
    async function getCaptchaToken() {
        const siteKey = "<?= $siteKey ?>";
        if (!siteKey) return null;

        return new Promise((resolve) => {
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'register'}).then(function(token) {
                    resolve(token);
                });
            });
        });
    }

    /* ===============================
        REALTIME CHECK EMAIL
    ================================ */
    emailInput.addEventListener('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            const email = this.value.trim();
            if (email.length < 5) {
                resetState();
                return;
            }

            fetch("<?= base_url('auth/check-email') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: csrfName + "=" + csrfHash + "&email=" + encodeURIComponent(email)
            })
            .then(res => res.json())
            .then(data => {
                csrfHash = data.csrfHash;
                csrfHashEl.content = data.csrfHash;

                if (data.status === 'used') {
                    emailInput.classList.add('is-invalid');
                    emailInput.classList.remove('is-valid');
                    errorMsg.innerHTML = "Email sudah digunakan";
                    successMsg.innerHTML = "";
                    btnSubmit.disabled = true;
                } else {
                    emailInput.classList.remove('is-invalid');
                    emailInput.classList.add('is-valid');
                    successMsg.innerHTML = "Email tersedia";
                    errorMsg.innerHTML = "";
                    // Panggil validasi password untuk cek apakah tombol boleh aktif
                    validatePassword();
                }
            });
        }, 500);
    });

    /* ===============================
        PASSWORD VALIDATION
    ================================ */
    function validatePassword() {
        const pass = passwordInput.value;
        const conf = confirmInput.value;

        if (conf.length > 0) {
            if (pass !== conf) {
                confirmInput.classList.add('is-invalid');
                confirmInput.classList.remove('is-valid');
                btnSubmit.disabled = true;
            } else {
                confirmInput.classList.remove('is-invalid');
                confirmInput.classList.add('is-valid');

                // Aktifkan tombol jika email juga valid
                if (emailInput.classList.contains('is-valid')) {
                    btnSubmit.disabled = false;
                }
            }
        }
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validatePassword);

    /* ===============================
        SUBMIT FORM AJAX + RECAPTCHA
    ================================ */
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Cek kecocokan password sekali lagi
        if (passwordInput.value !== confirmInput.value) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Password belum cocok!' });
            return;
        }

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Memproses...';

        try {
            // Ambil token reCAPTCHA v3
            const token = await getCaptchaToken();
            if (token) {
                document.getElementById('g-recaptcha-response').value = token;
            }

            const formData = new FormData(form);
            formData.append(csrfName, csrfHash);

            const response = await fetch("<?= base_url('register') ?>", {
                method: "POST",
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: formData
            });

            const data = await response.json();
            csrfHash = data.csrfHash;
            csrfHashEl.content = data.csrfHash;

            if (data.status === 'error') {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Buat Akun Sekarang';
            } else {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message })
                .then(() => {
                    window.location.href = "<?= base_url('login') ?>";
                });
            }
        } catch (err) {
            console.error(err);
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Buat Akun Sekarang';
        }
    });

    function resetState() {
        emailInput.classList.remove('is-valid', 'is-invalid');
        errorMsg.innerHTML = "";
        successMsg.innerHTML = "";
        btnSubmit.disabled = true;
    }
</script>
<?= $this->endSection() ?>