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
                Silakan daftar untuk mengakses seluruh fitur aplikasi.
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
                    <form class="form w-100" id="form-register">

                        <?= csrf_field() ?>

                        <!-- Judul -->
                        <div class="text-center mb-11">
                            <h1 class="text-dark fw-bolder mb-3">Daftar Akun</h1>
                            <div class="text-gray-500 fw-semibold fs-6">
                                Buat akun baru sebagai anggota
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="fv-row mb-8">
                            <input type="email"
                                id="email"
                                name="email"
                                class="form-control bg-transparent"
                                placeholder="Email"
                                autocomplete="off">

                            <div class="invalid-feedback" id="email-error"></div>
                            <div class="valid-feedback" id="email-success"></div>
                        </div>


                        <!-- Password -->
                        <div class="fv-row mb-8" data-kt-password-meter="true">
                            <div class="position-relative mb-3">
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
                            <div class="text-muted">
                                Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="fv-row mb-8">
                            <input type="password"
                                   name="password_confirm"
                                   class="form-control bg-transparent"
                                   placeholder="Ulangi Password"
                                   required>
                        </div>

                        <!-- Syarat & Ketentuan -->
                        <div class="fv-row mb-8">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" required>
                                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                                    Saya menyetujui
                                    <a href="#" class="ms-1 link-primary">Syarat & Ketentuan</a>
                                </span>
                            </label>
                        </div>

                        <!-- Tombol Daftar -->
                        <div class="d-grid mb-10">
                            <button type="submit"
                                    id="btn-submit"
                                    class="btn btn-primary btn-sm w-100"
                                    disabled>
                                Daftar
                            </button>

                        </div>

                        <!-- Login -->
                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            Sudah punya akun?
                            <a href="<?= base_url('login') ?>" class="link-primary fw-semibold">
                                Masuk
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
const form        = document.getElementById('form-register');
const emailInput  = document.getElementById('email');
const btnSubmit   = document.getElementById('btn-submit');
const errorMsg    = document.getElementById('email-error');
const successMsg  = document.getElementById('email-success');

const csrfNameEl  = document.querySelector('meta[name="csrf-name"]');
const csrfHashEl  = document.querySelector('meta[name="csrf-hash"]');

let csrfName = csrfNameEl.content;
let csrfHash = csrfHashEl.content;
let typingTimer;

/* ===============================
   REALTIME CHECK EMAIL
================================ */
emailInput.addEventListener('keyup', function () {
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

            // 🔁 UPDATE CSRF TOKEN
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
                btnSubmit.disabled = false;
            }
        });
    }, 500);
});

/* ===============================
   SUBMIT FORM AJAX
================================ */
form.addEventListener('submit', function (e) {
    e.preventDefault();

    btnSubmit.disabled = true;
    btnSubmit.innerHTML = 'Memproses...';

    const formData = new FormData(form);
    formData.append(csrfName, csrfHash);

    fetch("<?= base_url('register') ?>", {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        // 🔁 UPDATE CSRF TOKEN
        csrfHash = data.csrfHash;
        csrfHashEl.content = data.csrfHash;

        if (data.status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message
            });
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Daftar';
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Registrasi berhasil, silakan cek email Anda untuk verifikasi Akun.'
            }).then(() => {
                window.location.href = "<?= base_url('login') ?>";
            });
        }


    });
});

function resetState() {
    emailInput.classList.remove('is-valid', 'is-invalid');
    errorMsg.innerHTML = "";
    successMsg.innerHTML = "";
    btnSubmit.disabled = true;
}
</script>
<?= $this->endSection() ?>
