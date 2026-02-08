<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>
<!--begin::Products-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card card-flush">

        <!-- HEADER -->
        <div class="card-header border-0 pt-6">
            <div class="card-title w-100 w-md-auto">
                <div class="d-flex align-items-center position-relative my-1 w-100">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    <input type="text"
                        data-kt-ecommerce-order-filter="search"
                        class="form-control form-control-solid ps-12 w-100 w-lg-250px"
                        placeholder="Cari transaksi..." />
                </div>
            </div>

            <div class="card-toolbar w-100 w-md-auto">
                <div class="d-flex justify-content-between justify-content-md-end align-items-center gap-2 w-100">

                    <div class="flex-grow-1 flex-md-grow-0 w-100 w-md-200px">
                        <select class="form-select form-select-solid" id="filter-status" data-control="select2" data-hide-search="true">
                            <option value="">Semua Status</option>
                            <option value="V" selected>Menunggu Verifikasi</option>
                            <option value="A">Terverifikasi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="card-body d-flex flex-column p-9 pt-3 mb-9">
            <!-- LIST -->
            <div id="iuran-list"></div>
            <!-- DATATABLE ENGINE -->
            <table id="kt_iuran_bulanan_table" class="d-none"></table>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <div id="kt_ecommerce_sales_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle fs-6 gy-4" id="kt_pembayaran_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold text-uppercase fs-7">
                            <th>Nama Pegawai</th>
                            <th>Status</th>
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
    $(document).ready(function() {

        let table = $('#kt_pembayaran_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: "<?= base_url('pembayaran/datatable') ?>",
                type: "POST",
                data: function(d) {
                    // Kirim parameter status ke Controller
                    d.status = $('#filter-status').val();
                },
                dataSrc: function(json) {
                    return json.data;
                },
            },
            columns: [{
                    data: 'nama_pegawai',
                    render: function(data, type, row) {
                        return `
                        <div class="d-flex align-items-center fw-bold">
                            ${data}
                        </div>`;
                    }
                },
                {
                    data: 'status',
                    render: function(data, type, row) {

                        let badge = '';

                        switch (data) {
                            case 'A':
                                badge = `<span class="badge badge-light-success">Approved</span>`;
                                break;

                            case 'P':
                                badge = `<span class="badge badge-light-warning">Pending</span>`;
                                break;

                            case 'R':
                                badge = `<span class="badge badge-light-danger">Reject</span>`;
                                break;

                            default:
                                badge = `<span class="badge badge-light-secondary">-</span>`;
                        }

                        return badge;
                    }
                },
                {
                    data: null,
                    className: 'text-end',
                    orderable: false,
                    render: function(data, type, row) {

                        let btnEdit = '';
                        let btnDelete = '';

                        if (row.can_edit) {
                            btnEdit = `
                            <a href="<?= base_url('pembayaran/edit') ?>/${row.id}"
                            class="btn btn-sm btn-light-warning me-1"
                            data-bs-toggle="tooltip"
                            title="Approve Pembayaran">
                                <i class="bi bi-check-circle"></i>
                            </a>`;
                        }
                        return `
                        <div class="d-flex justify-content-end">
                            ${btnEdit}
                        </div>`;
                    }
                }


            ]
        });
        // Search Metronic
        $('[data-kt-ecommerce-order-filter="search"]').keyup(function() {
            table.search(this.value).draw();
        });

        $('#filter-status').on('change', function() {
            table.draw(); // Gambar ulang tabel dengan filter baru
        });

    });
</script>
<?= $this->endSection() ?>