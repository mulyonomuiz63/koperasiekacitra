<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('category/update/' . $category['id']) ?>" method="post">
<?= csrf_field() ?>

<div class="card card-flush">

    <!--begin::Card header-->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Edit Category
            </h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('category') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-6">

        <div class="row g-5">

            <!-- NAMA CATEGORY -->
            <div class="col-md-6">
                <label class="required form-label">Category</label>
                <input type="text"
                       name="category_name"
                       class="form-control form-control-solid"
                       value="<?= old('category_name', $category['category_name']) ?>"
                       required>
            </div>
        </div>
    </div>
    <!--end::Card body-->

    <!--begin::Card footer-->
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-sm">
            Update
        </button>
    </div>
    <!--end::Card footer-->

</div>

</form>

<?= $this->endSection() ?>
