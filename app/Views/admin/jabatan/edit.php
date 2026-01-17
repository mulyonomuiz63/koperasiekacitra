<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('jabatan/update/' . $jabatan['id']) ?>" method="post">
<?= csrf_field() ?>

<div class="card card-flush">

    <!--begin::Card header-->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Edit Jabatan
            </h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('jabatan') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-6">

        <div class="row g-5">

            <!-- NAMA JABATAN -->
            <div class="col-md-6">
                <label class="required form-label">Nama Jabatan</label>
                <input type="text"
                       name="nama_jabatan"
                       class="form-control form-control-solid"
                       value="<?= old('nama_jabatan', $jabatan['nama_jabatan']) ?>"
                       required>
            </div>

            <!-- KETERANGAN -->
            <div class="col-12">
                <label class="required form-label">Keterangan</label>
                <textarea name="keterangan"
                          class="form-control form-control-solid"
                          rows="3"
                          required><?= old('keterangan', $jabatan['keterangan']) ?></textarea>
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
