<?= $this->extend('auth/pages/layout') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10 shadow-sm border border-gray-200">

        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-10">

                <div id="alert-wrapper"></div>

                <form class="form w-100" id="form-login">
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
                            Masuk
                        </h1>

                        <div class="text-gray-500 fw-semibold fs-5 d-flex align-items-center justify-content-center">
                            Selamat Datang Dikoperasi <?= setting('app_name') ?>.
                        </div>
                    </div>

                    <div class="fv-row mb-7 position-relative">
                        <i class="ki-outline ki-sms fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                        <input type="email"
                            name="email"
                            class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                            placeholder="nama@email.com"
                            autocomplete="off"
                            required>
                    </div>

                    <div class="fv-row mb-3 position-relative" data-kt-password-meter="true">
                        <div class="position-relative">
                            <i class="ki-outline ki-lock fs-2 position-absolute top-50 translate-middle-y ms-4 text-gray-500"></i>
                            <input type="password"
                                id="password_input"
                                name="password"
                                class="form-control form-control-solid ps-12 bg-light-lighten text-dark fw-semibold"
                                placeholder="Password Anda"
                                required>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-2"
                                onclick="togglePassword()">
                                <i id="eye_icon" class="ki-outline ki-eye fs-2 text-gray-500"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex flex-stack flex-wrap gap-3 fs-7 fw-semibold mb-8">
                        <label class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input h-20px w-20px" type="checkbox" name="remember">
                            <span class="form-check-label text-gray-700">Ingat saya</span>
                        </label>

                        <a href="<?= base_url('forgot-password') ?>" class="link-primary fw-bold text-hover-underline">
                            Lupa password?
                        </a>
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit"
                            id="btn-login"
                            class="btn btn-primary fw-bold py-4 shadow-sm hover-elevate-up">
                            <span class="indicator-label">Masuk</span>
                        </button>
                    </div>

                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Belum punya akun?
                        <a href="<?= base_url('register') ?>" class="link-primary fw-bolder">
                            Buat Akun Baru
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
                                    Masuk dengan Google
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Fungsi toggle password
    function togglePassword() {
        const input = document.getElementById('password_input');
        const icon = document.getElementById('eye_icon');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('ki-eye');
            icon.classList.add('ki-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('ki-eye-slash');
            icon.classList.add('ki-eye');
        }
    }

    const formLogin = document.getElementById('form-login');
    const btnLogin = document.getElementById('btn-login');
    const alertBox = document.getElementById('alert-wrapper');

    const csrfNameEl = document.querySelector('meta[name="csrf-name"]');
    const csrfHashEl = document.querySelector('meta[name="csrf-hash"]');

    let csrfName = csrfNameEl.content;
    let csrfHash = csrfHashEl.content;

    // Fungsi untuk mendapatkan token reCAPTCHA secara asinkron
    async function getCaptchaToken() {
        const siteKey = "<?= $siteKey ?>";
        if (!siteKey) return null;

        return new Promise((resolve) => {
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {
                    action: 'login'
                }).then(function(token) {
                    resolve(token);
                });
            });
        });
    }

    formLogin.addEventListener('submit', async function(e) {
        e.preventDefault();

        // 1. Disable tombol dan tampilkan loading
        btnLogin.disabled = true;
        btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Memproses...';

        try {
            // 2. Ambil token reCAPTCHA jika status aktif
            const captchaToken = await getCaptchaToken();
            if (captchaToken) {
                document.getElementById('g-recaptcha-response').value = captchaToken;
            }

            // 3. Siapkan FormData
            const formData = new FormData(formLogin);
            formData.append(csrfName, csrfHash);

            // 4. Kirim data via Fetch
            const response = await fetch("<?= base_url('login') ?>", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            const data = await response.json();

            // 5. Update CSRF Token untuk request berikutnya
            csrfHash = data.csrfHash;
            csrfHashEl.content = data.csrfHash;

            // 6. Handling Response
            if (data.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Login',
                    text: data.message,
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
                btnLogin.disabled = false;
                btnLogin.innerHTML = 'Masuk';
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Login berhasil, selamat datang!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-4',
                        title: 'text-dark fw-bold'
                    }
                }).then(() => {
                    window.location.href = data.redirect;
                });
            }
        } catch (error) {
            console.error("Error:", error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Sistem',
                text: 'Terjadi kesalahan saat menghubungi server.'
            });
            btnLogin.disabled = false;
            btnLogin.innerHTML = 'Masuk';
        }
    });
</script>

<?= $this->include('partials/alert') ?>
<?= $this->endSection() ?>