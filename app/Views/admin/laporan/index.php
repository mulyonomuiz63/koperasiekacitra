<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-header align-items-center gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Nama Pegawai">
            </div>
        </div>
        <div class="card-toolbar gap-3">
            <select id="filter_tahun" class="form-select form-select-solid w-150px">
                <?php $year = date('Y');
                for ($i = $year; $i >= $year - 3; $i--): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-dashed table-bordered align-middle fs-7 gy-4" id="table_laporan_iuran">
                <thead>
                    <tr class="text-start text-muted fw-bold text-uppercase gs-0">
                        <th class="min-w-150px">Nama Pegawai</th>
                        <th class="text-center">Jan</th>
                        <th class="text-center">Feb</th>
                        <th class="text-center">Mar</th>
                        <th class="text-center">Apr</th>
                        <th class="text-center">Mei</th>
                        <th class="text-center">Jun</th>
                        <th class="text-center">Jul</th>
                        <th class="text-center">Agu</th>
                        <th class="text-center">Sep</th>
                        <th class="text-center">Okt</th>
                        <th class="text-center">Nov</th>
                        <th class="text-center">Des</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-700"></tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Fungsi format rupiah untuk cell
        const formatCurrency = (data) => {
            return data > 0 ? `<span class="badge badge-light-success text-success">${Number(data).toLocaleString()}</span>` : `<span class="text-muted">-</span>`;
        };

        let table = $('#table_laporan_iuran').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: {
                url: "<?= base_url('laporan/datatable') ?>",
                type: "POST",
                data: function(d) {
                    d.tahun = $('#filter_tahun').val(); // Kirim filter tahun ke server
                    return d;
                },
            },
            columns: [{
                    data: 'nama',
                    className: 'fw-bold text-gray-800'
                },
                {
                    data: 'jan',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'feb',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'mar',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'apr',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'mei',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'jun',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'jul',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'agu',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'sep',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'okt',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'nov',
                    className: 'text-center',
                    render: formatCurrency
                },
                {
                    data: 'des',
                    className: 'text-center',
                    render: formatCurrency
                },
            ]
        });

        // Search
        $('[data-kt-ecommerce-order-filter="search"]').keyup(function() {
            table.search(this.value).draw();
        });

        // Filter Tahun
        $('#filter_tahun').change(function() {
            table.draw();
        });
    });
</script>
<?= $this->endSection() ?>