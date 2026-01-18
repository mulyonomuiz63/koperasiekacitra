<?= $this->extend('auth/pages/layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!-- Aside -->
    <div class="d-flex flex-lg-row-fluid">
        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
            <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                 src="<?= base_url('assets/media/auth/agency.png') ?>" alt="">
            <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                 src="<?= base_url('assets/media/auth/agency-dark.png') ?>" alt="">

            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
                Reset Password
            </h1>

            <div class="text-gray-600 fs-base text-center fw-semibold">
                Masukkan email untuk menerima link reset password
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">

            <div class="d-flex flex-center flex-column align-items-stretch w-md-400px">
                <div class="d-flex flex-center flex-column pb-15 pb-lg-20">

                    <form class="form w-100" id="form-forgot">
                        <?= csrf_field() ?>

                        <div class="fv-row mb-8">
                            <input type="email"
                                   name="email"
                                   class="form-control bg-transparent"
                                   placeholder="Email terdaftar"
                                   required>
                        </div>

                        <div class="d-grid mb-10">
                            <button type="submit" id="btn-forgot" class="btn btn-primary btn-sm">
                                Kirim Link Reset
                            </button>
                        </div>

                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            <a href="<?= base_url('login') ?>" class="link-primary">
                                Kembali ke login
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->section('scripts') ?>
<script>
const form = document.getElementById('form-forgot');
const btn  = document.getElementById('btn-forgot');

const csrfName = document.querySelector('meta[name="csrf-name"]').content;
let csrfHash   = document.querySelector('meta[name="csrf-hash"]').content;

form.addEventListener('submit', function(e){
    e.preventDefault();

    btn.disabled = true;
    btn.innerHTML = 'Memproses...';

    const fd = new FormData(form);
    fd.append(csrfName, csrfHash);

    fetch("<?= base_url('forgot-password') ?>", {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        csrfHash = data.csrfHash;

        if (data.status === 'error') {
            Swal.fire('Gagal', data.message, 'error');
            btn.disabled = false;
            btn.innerHTML = 'Kirim Link Reset';
        } else {
            Swal.fire('Berhasil', data.message, 'success')
                .then(() => window.location.href = "<?= base_url('login') ?>");
        }
    });
});
</script>
<?= $this->endSection() ?>
