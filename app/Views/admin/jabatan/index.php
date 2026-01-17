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
                <a href="<?= base_url('/') ?>jabatan/create" class="btn btn-primary">+ Tambah Jabatan</a>
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
                <table class="table table-row-dashed table-row-gray-300 align-middle fs-6 gy-4" id="kt_jabatan_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold text-uppercase fs-7">
                            <th>Nama Jabatan</th>
                            <th>Keterangan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="fw-semibold text-gray-700"></tbody>
                </table>
            </div>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Products-->
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {

    let table = $('#kt_jabatan_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "<?= base_url('jabatan/datatable') ?>",
            type: "POST",
            data: function (d) {
                return d; // ⬅️ WAJIB
            },
            dataSrc: function (json) {
                return json.data;
            },
        },
        columns: [
            {
                data: 'nama_jabatan',
                render: function (data, type, row) {

                    let toggle = row.has_child
                        ? `<span class="menu-toggle me-2 cursor-pointer"
                                data-id="${row.id}">
                                <i class="bi bi-chevron-right"></i>
                        </span>`
                        : `<span class="me-4"></span>`;

                    return `
                        <div class="d-flex align-items-center fw-bold">
                            ${toggle}
                            ${data}
                        </div>`;
                }
            },
            { data: 'keterangan' },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                render: function (data, type, row) {

                    let btnEdit = '';
                    let btnDelete = '';

                    if (row.can_edit) {
                        btnEdit = `
                            <a href="<?= base_url('jabatan/edit') ?>/${row.id}"
                            class="btn btn-sm btn-light-warning me-1"
                            data-bs-toggle="tooltip"
                            title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>`;
                    }

                    if (row.can_delete) {
                        btnDelete = `
                            <a href="javascript:void(0)"
                            class="btn btn-sm btn-light-danger btn-delete"
                            data-url="<?= base_url('jabatan/delete') ?>/${row.id}"
                            data-title="Hapus Jabatan"
                            data-message="Yakin ingin menghapus jabatan <b>${row.nama_jabatan}</b>?">
                                <i class="bi bi-trash"></i>
                            </a>`;
                    }

                    return `
                        <div class="d-flex justify-content-end">
                            ${btnEdit}
                            ${btnDelete}
                        </div>`;
                }
            }


        ]
    });
    // Search Metronic
    $('[data-kt-ecommerce-order-filter="search"]').keyup(function () {
        table.search(this.value).draw();
    });

});

</script>
<?= $this->endSection() ?>
