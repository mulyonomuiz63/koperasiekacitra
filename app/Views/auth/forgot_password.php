<?= $this->extend('auth/pages/layout') ?>
<?= $this->section('content') ?>
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
<?= $this->endSection() ?>
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
