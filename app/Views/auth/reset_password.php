<?= $this->extend('auth/pages/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
        <div class="d-flex flex-center flex-column align-items-stretch w-md-400px">
            <div class="d-flex flex-center flex-column pb-10">
                
                <div class="text-center mb-11">
                    <div class="mb-7">
                        <a href="<?= base_url() ?>" class="d-inline-block shadow-sm rounded-circle p-2 bg-light">
                            <?= img_lazy('uploads/app-icon/' . setting('app_icon'), setting('app_name'), ['class' => 'h-75px h-lg-100px symbol']) ?>
                        </a>
                    </div>
                    <h1 class="text-dark fw-bolder mb-3 fs-1">Lupa Password?</h1>
                    <div class="text-muted fw-semibold fs-6">
                        Masukkan email Anda untuk menerima instruksi reset password.
                    </div>
                </div>

                <form class="form w-100" id="form-forgot">
                    <?= csrf_field() ?>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                    <div class="fv-row mb-8">
                        <input type="email" name="email" class="form-control bg-transparent" placeholder="Email terdaftar" required autocomplete="off">
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit" id="btn-forgot" class="btn btn-primary">
                            <span class="indicator-label">Kirim Link Reset</span>
                        </button>
                    </div>

                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Tiba-tiba ingat? <a href="<?= base_url('login') ?>" class="link-primary fw-bold">Kembali ke login</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const form = document.getElementById('form-forgot');
const btn  = document.getElementById('btn-forgot');

form.addEventListener('submit', function(e) {
    e.preventDefault();

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Memproses...';

    // Eksekusi reCAPTCHA v3
    grecaptcha.ready(function() {
        grecaptcha.execute('<?= setting('recaptcha_site_key') ?>', {action: 'forgot_password'}).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
            
            // Kirim data setelah token didapat
            sendData();
        });
    });
});

function sendData() {
    const fd = new FormData(form);
    
    fetch("<?= base_url('forgot-password') ?>", {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        // Perbarui CSRF jika ada di response
        if(data.csrfHash) {
            const csrfTag = document.querySelector('input[name="<?= csrf_token() ?>"]');
            if(csrfTag) csrfTag.value = data.csrfHash;
        }

        if (data.status === 'error') {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
            btn.disabled = false;
            btn.innerHTML = 'Kirim Link Reset';
        } else {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message })
                .then(() => window.location.href = "<?= base_url('login') ?>");
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = 'Kirim Link Reset';
        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
    });
}
</script>
<?= $this->endSection() ?>