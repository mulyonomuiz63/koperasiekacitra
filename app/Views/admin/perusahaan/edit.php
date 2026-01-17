<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('perusahaan/update/' . $perusahaan['id']) ?>" method="post">
<?= csrf_field() ?>

<div class="card card-flush">

    <!--begin::Card header-->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Edit Perusahaan
            </h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('perusahaan') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-6">

        <div class="row g-5">

            <!-- NAMA PERUSAHAAN -->
            <div class="col-md-6">
                <label class="required form-label">Nama Perusahaan</label>
                <input type="text"
                       name="nama_perusahaan"
                       class="form-control form-control-solid"
                       value="<?= old('nama_perusahaan', $perusahaan['nama_perusahaan']) ?>"
                       required>
            </div>

            <!-- TELEPON -->
            <div class="col-md-6">
                <label class="required form-label">Telepon</label>
                <input type="text"
                       name="telepon"
                       class="form-control form-control-solid"
                       value="<?= old('telepon', $perusahaan['telepon']) ?>"
                       required>
            </div>

            <!-- EMAIL -->
            <div class="col-md-6">
                <label class="required form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control form-control-solid"
                       value="<?= old('email', $perusahaan['email']) ?>"
                       required>
            </div>

            <!-- ALAMAT -->
            <div class="col-12">
                <label class="required form-label">Alamat</label>
                <textarea name="alamat"
                          class="form-control form-control-solid"
                          rows="3"
                          required><?= old('alamat', $perusahaan['alamat']) ?></textarea>
            </div>

        </div>
    </div>
    <!--end::Card body-->

    <!--begin::Card footer-->
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            Update
        </button>
    </div>
    <!--end::Card footer-->

</div>

</form>

<?= $this->endSection() ?>
