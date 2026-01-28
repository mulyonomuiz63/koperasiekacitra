<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>
<!--begin::Products-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header align-items-center gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Galeri">
            </div>
        </div>
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <?php if (can($menuId, 'create')): ?>
                <a href="<?= base_url('galeri/create') ?>" class="btn btn-primary btn-sm">+ Tambah Galeri</a>
            <?php endif; ?>
        </div>
    </div>
    <!--end::Card header-->

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle fs-6 gy-4" id="kt_galeri_table">
                <thead>
                    <tr class="text-start text-muted fw-bold text-uppercase fs-7">
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-700"></tbody>
            </table>
        </div>
    </div>
</div>
<!--end::Products-->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {

    let table = $('#kt_galeri_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "<?= base_url('galeri/datatable') ?>",
            type: "POST",
        },
        columns: [
            { data: 'title' },
            { data: 'filename' }, // Sudah berisi <img> dari controller
            {
                data: null,
                className: 'text-end',
                orderable: false,
                render: function (data, type, row) {
                    let btnDelete = `
                        <a href="javascript:void(0)"
                        class="btn btn-sm btn-light-danger btn-delete"
                        data-url="<?= base_url('galeri/delete') ?>/${row.id}"
                        data-title="Hapus Gambar"
                        data-message="Yakin ingin menghapus gambar <b>${row.title}</b>?">
                            <i class="bi bi-trash"></i>
                        </a>`;

                    let btnEdit = `
                        <a href="<?= base_url('galeri/edit') ?>/${row.id}"
                        class="btn btn-sm btn-light-warning me-1"
                        data-bs-toggle="tooltip"
                        title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>`;

                    return `<div class="d-flex justify-content-end">${btnEdit} ${btnDelete}</div>`;
                }
            }
        ]
    });

    // Search Metronic
    $('[data-kt-ecommerce-order-filter="search"]').keyup(function () {
        table.search(this.value).draw();
    });

    // Delete confirmation
    $(document).on('click', '.btn-delete', function () {
        let url = $(this).data('url');
        if (confirm('Yakin ingin menghapus gambar ini?')) {
            window.location.href = url;
        }
    });

});
</script>
<?= $this->endSection() ?>
