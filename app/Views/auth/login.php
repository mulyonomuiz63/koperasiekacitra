<?= $this->extend('auth/pages/layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid">
        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
            <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                 src="<?= base_url('assets/media/auth/agency.png') ?>" alt="">
            <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                 src="<?= base_url('assets/media/auth/agency-dark.png') ?>" alt="">

            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
                Cepat, Efisien, dan Produktif
            </h1>

            <div class="text-gray-600 fs-base text-center fw-semibold">
                Silakan login untuk melanjutkan ke aplikasi.
            </div>
        </div>
    </div>

    <!--begin::Body-->
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">

            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

                    <div id="alert-wrapper"></div>

                    <!--begin::Form-->
                    <form class="form w-100" id="form-login">
                        <?= csrf_field() ?>

                        <!-- Judul -->
                        <div class="text-center mb-11">
                            <h1 class="text-dark fw-bolder mb-3">Masuk</h1>
                            <div class="text-gray-500 fw-semibold fs-6">
                                Login sebagai anggota
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="fv-row mb-8">
                            <input type="email"
                                   name="email"
                                   class="form-control bg-transparent"
                                   placeholder="Email"
                                   autocomplete="off"
                                   required>
                        </div>

                        <!-- Password -->
                        <div class="fv-row mb-8">
                            <div class="position-relative">
                                <input type="password"
                                       name="password"
                                       class="form-control bg-transparent"
                                       placeholder="Password"
                                       required>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                      data-kt-password-meter-control="visibility">
                                    <i class="ki-duotone ki-eye-slash fs-2"></i>
                                    <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Lupa Password -->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div class="fv-row">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember">
                                    <span class="form-check-label">Ingat saya</span>
                                </label>
                            </div>

                            <a href="<?= base_url('forgot-password') ?>" class="link-primary">
                                Lupa password?
                            </a>
                        </div>

                        <!-- Tombol Login -->
                        <div class="d-grid mb-10">
                            <button type="submit"
                                    id="btn-login"
                                    class="btn btn-primary w-100">
                                Masuk
                            </button>
                        </div>

                        <!-- Register -->
                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            Belum punya akun?
                            <a href="<?= base_url('register') ?>" class="link-primary fw-semibold">
                                Daftar
                            </a>
                        </div>

                    </form>
                    <!--end::Form-->

                </div>
            </div>

        </div>
    </div>
    <!--end::Body-->
</div>

<?= $this->endSection() ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->section('scripts') ?>
<script>
const formLogin  = document.getElementById('form-login');
const btnLogin   = document.getElementById('btn-login');
const alertBox   = document.getElementById('alert-wrapper');

const csrfNameEl = document.querySelector('meta[name="csrf-name"]');
const csrfHashEl = document.querySelector('meta[name="csrf-hash"]');

let csrfName = csrfNameEl.content;
let csrfHash = csrfHashEl.content;

formLogin.addEventListener('submit', function(e){
    e.preventDefault();

    btnLogin.disabled = true;
    btnLogin.innerHTML = 'Memproses...';

    const formData = new FormData(formLogin);
    formData.append(csrfName, csrfHash);

    fetch("<?= base_url('login') ?>", {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        // update csrf
        csrfHash = data.csrfHash;
        csrfHashEl.content = data.csrfHash;

        if (data.status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Login',
                text: data.message
            });
            btnLogin.disabled = false;
            btnLogin.innerHTML = 'Masuk';
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Login berhasil, selamat datang!'
            }).then(() => {
                window.location.href = data.redirect;
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
