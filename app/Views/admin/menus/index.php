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
                    <a href="<?= base_url('/') ?>menus/create" class="btn btn-primary">+ Tambah Menu</a>
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
                    <table class="table table-row-dashed table-row-gray-300 align-middle fs-6 gy-4" id="kt_ecommerce_sales_table">
                        <thead>
                            <tr class="text-start text-muted fw-bold text-uppercase fs-7">
                                <th>Nama Menu</th>
                                <th>URL</th>
                                <th class="text-center">Order</th>
                                <th class="text-center">Status</th>
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

    let table = $('#kt_ecommerce_sales_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "<?= base_url('menus/datatable') ?>",
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
                data: 'name',
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
            { data: 'url' },
            {
                data: 'menu_order',
                className: 'text-center'
            },
            {
                data: 'is_active',
                className: 'text-center',
                render: d => d == 1
                    ? '<span class="badge badge-light-success">Aktif</span>'
                    : '<span class="badge badge-light-danger">Nonaktif</span>'
            },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                render: function (data, type, row) {

                    let btnEdit = '';
                    let btnDelete = '';

                    if (row.can_edit) {
                        btnEdit = `
                            <a href="<?= base_url('menus/edit') ?>/${row.id}"
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
                            data-url="<?= base_url('menus/delete') ?>/${row.id}"
                            data-title="Hapus Menu"
                            data-message="Yakin ingin menghapus menu <b>${row.name}</b>?">
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

    $('#kt_ecommerce_sales_table tbody').on('click', '.menu-toggle', function () {

        let btn = $(this);
        let parentId = btn.data('id');
        let tr = btn.closest('tr');

        // Toggle close
        if (tr.next().hasClass('submenu-row')) {
            tr.nextUntil(':not(.submenu-row)').remove();
            btn.find('i').removeClass('rotate-90');
            return;
        }

        $.get("<?= base_url('menus/children') ?>/" + parentId, function (res) {

            let rows = '';
            res.data.forEach(m => {
                let btnEdit = '';
                let btnDelete = '';

                if (m.can_edit) {
                    btnEdit = `
                        <a href="<?= base_url('menus/edit') ?>/${m.id}"
                        class="btn btn-sm btn-light-warning me-1">
                        <i class="bi bi-pencil"></i>
                        </a>`;
                }

                if (m.can_delete) {
                    btnDelete = `
                        <a href="javascript:void(0)"
                        class="btn btn-sm btn-light-danger btn-delete"
                        data-url="<?= base_url('menus/delete') ?>/${m.id}"
                        data-title="Hapus Submenu"
                        data-message="Yakin ingin menghapus submenu <b>${m.name}</b>?">
                            <i class="bi bi-trash"></i>
                        </a>`;
                }


                rows += `
                    <tr class="submenu-row">
                        <td class="ps-10">
                            <i class="bi bi-arrow-return-right me-2 text-muted"></i>
                            ${m.name}
                        </td>
                        <td>${m.url ?? ''}</td>
                        <td class="text-center">${m.menu_order}</td>
                        <td class="text-center">
                            ${m.is_active == 1
                                ? '<span class="badge badge-light-success">Aktif</span>'
                                : '<span class="badge badge-light-danger">Nonaktif</span>'}
                        </td>
                        <td class="text-end">
                            ${btnEdit}
                            ${btnDelete}
                        </td>
                    </tr>`;
            });


            tr.after(rows);
            btn.find('i').addClass('rotate-90');
        });
    });




    // Search Metronic
    $('[data-kt-ecommerce-order-filter="search"]').keyup(function () {
        table.search(this.value).draw();
    });

});

</script>
<?= $this->endSection() ?>
