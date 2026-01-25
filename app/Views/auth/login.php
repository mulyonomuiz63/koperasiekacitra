<?= $this->extend('auth/pages/layout') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10 shadow-sm border border-gray-200">

        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-10">

                <div id="alert-wrapper"></div>

                <form class="form w-100" id="form-login">
                    <?= csrf_field() ?>

                    <div class="text-center mb-11">
                        <img src="">
                        <h1 class="text-dark fw-bolder mb-3 fs-1">Masuk</h1>
                        <div class="text-muted fw-semibold fs-6">
                            Selamat datang kembali, Anggota!
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
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Fungsi toggle password sederhana
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
</script>
<script>
    const formLogin = document.getElementById('form-login');
    const btnLogin = document.getElementById('btn-login');
    const alertBox = document.getElementById('alert-wrapper');

    const csrfNameEl = document.querySelector('meta[name="csrf-name"]');
    const csrfHashEl = document.querySelector('meta[name="csrf-hash"]');

    let csrfName = csrfNameEl.content;
    let csrfHash = csrfHashEl.content;

    formLogin.addEventListener('submit', function(e) {
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
                        text: 'Login berhasil, selamat datang!',
                        showConfirmButton: false, // Menghilangkan tombol OK
                        timer: 2000, // Alert akan hilang dalam 2 detik
                        timerProgressBar: true, // Menampilkan bar progres waktu
                        customClass: {
                            popup: 'rounded-4',
                            title: 'text-dark fw-bold'
                        }
                    }).then((result) => {
                        /* Logic redirect diletakkan di sini. 
                        Akan terpanggil otomatis saat timer habis (dismissal)
                        */
                        window.location.href = data.redirect;
                    });
                }
            });
    });
</script>
<?= $this->include('partials/alert') ?>
<?= $this->endSection() ?>