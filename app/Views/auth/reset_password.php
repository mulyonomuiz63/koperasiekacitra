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

```
        <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
            Password Baru
        </h1>

        <div class="text-gray-600 fs-base text-center fw-semibold">
            Silakan masukkan password baru Anda.
        </div>
    </div>
</div>

<!--begin::Body-->
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
    <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">

        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

                <form class="form w-100" id="form-reset">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= esc($token) ?>">

                    <div class="text-center mb-11">
                        <h1 class="text-dark fw-bolder mb-3">Reset Password</h1>
                        <div class="text-gray-500 fw-semibold fs-6">
                            Gunakan password yang kuat
                        </div>
                    </div>

                    <div class="fv-row mb-8">
                        <input type="password"
                               name="password"
                               class="form-control bg-transparent"
                               placeholder="Password Baru"
                               required>
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit"
                                id="btn-reset"
                                class="btn btn-primary btn-sm w-100">
                            Simpan Password
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
```

</div>

<?= $this->endSection() ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->section('scripts') ?>

<script>
const formReset = document.getElementById('form-reset');
const btnReset  = document.getElementById('btn-reset');

const csrfNameEl = document.querySelector('meta[name="csrf-name"]');
const csrfHashEl = document.querySelector('meta[name="csrf-hash"]');

let csrfName = csrfNameEl.content;
let csrfHash = csrfHashEl.content;

formReset.addEventListener('submit', function(e){
    e.preventDefault();

    btnReset.disabled = true;
    btnReset.innerHTML = 'Menyimpan...';

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
        csrfHash = data.csrfHash;
        csrfHashEl.content = data.csrfHash;

        if (data.status === 'error') {
            Swal.fire('Gagal', data.message, 'error');
            btnReset.disabled = false;
            btnReset.innerHTML = 'Simpan Password';
        } else {
            Swal.fire('Berhasil', data.message, 'success')
            .then(() => window.location.href = "<?= base_url('login') ?>");
        }
    });
});
</script>

<?= $this->endSection() ?>
