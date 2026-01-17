<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>
<!--begin::FAQ-->
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
                <input type="text"
                       data-kt-ecommerce-order-filter="search"
                       class="form-control form-control-solid w-250px ps-12"
                       placeholder="Cari FAQ">
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->

        <!--begin::Card toolbar-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <?php if (can($menuId, 'create')): ?>
                <a href="<?= base_url('faq/create') ?>" class="btn btn-primary">
                    + Tambah FAQ
                </a>
            <?php endif ?>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-300 align-middle fs-6 gy-4"
                   id="kt_faq_table">
                <thead>
                    <tr class="text-start text-muted fw-bold text-uppercase fs-7">
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-700"></tbody>
            </table>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::FAQ-->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {

    let table = $('#kt_faq_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
            url: "<?= base_url('faq/datatable') ?>",
            type: "POST",
            data: function (d) {
                return d;
            },
            dataSrc: function (json) {
                return json.data;
            }
        },
        columns: [
            {
                data: 'question',
                render: function (data) {
                    return `<span class="fw-bold">${data}</span>`;
                }
            },
            {
                data: 'answer',
                render: function (data) {
                    return `<span class="text-gray-700">${data}</span>`;
                }
            },
            {
                data: 'is_active',
                render: function (data, type, row) {
                    let checked = data == 1 ? 'checked' : '';
                    return `
                        <div class="form-check form-switch">
                            <input class="form-check-input faq-toggle"
                                   type="checkbox"
                                   data-id="${row.id}"
                                   ${checked}>
                        </div>`;
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
                        btnEdit = `
                            <a href="<?= base_url('faq/edit') ?>/${row.id}"
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
                               data-url="<?= base_url('faq/delete') ?>/${row.id}"
                               data-title="Hapus FAQ"
                               data-message="Yakin ingin menghapus FAQ ini?">
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

    // Toggle aktif / nonaktif
    $(document).on('change', '.faq-toggle', function () {
        $.post("<?= base_url('faq/toggle') ?>", {
            id: $(this).data('id'),
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        });
    });

});
</script>
<?= $this->endSection() ?>
