<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>
<!--begin::Products-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header align-items-center gap-2 gap-md-5">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Order">
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <!--begin::Add product-->
            <?php if (can($menuId, 'create')): ?>
                <a href="<?= base_url('/') ?>roles/create" class="btn btn-primary">+ Tambah Role</a>
            <?php endif ?>
            <!--end::Add product-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <div id="kt_ecommerce_sales_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="table-responsive">


<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $i => $u): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= $u['username'] ?></td>
            <td><?= $u['email'] ?></td>
            <td><?= $u['role_name'] ?></td>
            <td>
                <span class="badge bg-success"><?= $u['status'] ?></span>
            </td>
            <td>
                <?php if (can($menuId, 'update')): ?>
                    <a href="<?= base_url('/') ?>users/edit/<?= $u['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <?php endif ?>
                <a href="<?= base_url('/') ?>users/permission/<?= $u['id'] ?>" class="btn btn-info btn-sm">Permission</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
</div>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<?= $this->endSection() ?>