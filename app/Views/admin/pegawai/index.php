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
                <a href="<?= base_url('/') ?>pegawai/create" class="btn btn-primary btn-sm">+ Tambah Pegawai</a>
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
                <table class="table table-row-dashed table-row-gray-300 align-middle fs-6 gy-4" id="kt_tables_roles">
                    <thead>
                        <tr class="text-start text-muted fw-bold text-uppercase fs-7">
                            <th>Pegawai</th>
                            <th>Nama Jabatan</th>
                            <th>Status Anggota</th>
                            <th>Status Iuran</th>
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

    let table = $('#kt_tables_roles').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "<?= base_url('pegawai/datatable') ?>",
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
                data: 'namaPegawai',
            },
            {
                data: 'jabatan',
                className: 'text-center'
            },
            {
                data: null, // Pastikan nama field di database benar 'statu_iuran'
                className: 'text-center',
                render: function(data, type, row) {
                    let status = null;
                    // Cek data (sesuaikan dengan nilai di database Anda, misal 1/0 atau 'Aktif'/'Tidak Aktif')
                    if (row.status == 'A') {
                        status = `<span class="badge badge-light-success fw-bold px-4 py-3">Aktif</span>`;
                    } else if(row.status == 'T') {
                        status = `<span class="badge badge-light-warning fw-bold px-4 py-3">Tidak Aktif</span>`;
                    }else{
                        status = `<span class="badge badge-light-danger fw-bold px-4 py-3">Keluar</span>`;
                    }
                    
                    return status;
                }
            },
            {
                data: null, // Pastikan nama field di database benar 'statu_iuran'
                className: 'text-center',
                render: function(data, type, row) {
                    // Cek data (sesuaikan dengan nilai di database Anda, misal 1/0 atau 'Aktif'/'Tidak Aktif')
                    if (row.status_iuran == 'A') {
                        status = `<span class="badge badge-light-success fw-bold px-4 py-3">Aktif</span>`;
                    } else {
                        status = `<span class="badge badge-light-danger fw-bold px-4 py-3">Tidak Aktif</span>`;
                    }
                    
                    return status;
                }
            },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                render: function (data, type, row) {

                    let btnEdit = '';
                    let btnDelete = '';
                    
                    if (row.can_edit) {
                        if(row.status === 'T'){
                            btnEdit = `
                                <a href="<?= base_url('pegawai/pendaftaran') ?>/${row.id}"
                                class="btn btn-sm btn-light-warning me-1"
                                data-bs-toggle="tooltip"
                                title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>`;
                        }else{
                            btnEdit = `
                                <a href="<?= base_url('pegawai/edit') ?>/${row.id}"
                                class="btn btn-sm btn-light-warning me-1"
                                data-bs-toggle="tooltip"
                                title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>`;
                        }
                    }

                    if (row.can_delete) {
                        btnDelete = `
                            <a href="javascript:void(0)"
                            class="btn btn-sm btn-light-danger btn-delete"
                            data-url="<?= base_url('pegawai/delete') ?>/${row.id}"
                            data-title="Hapus Menu"
                            data-message="Yakin ingin menghapus menu <b>${row.namaPegawai}</b>?">
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
