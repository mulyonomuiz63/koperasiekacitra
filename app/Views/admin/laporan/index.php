<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Nama Pegawai">
            </div>
        </div>
        <div class="card-toolbar gap-3">
            <select id="filter_tahun" class="form-select form-select-solid w-125px">
                <?php $year = date('Y');
                for ($i = $year; $i >= $year - 3; $i--): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_input_manual">
                <i class="ki-duotone ki-plus fs-2"></i>
                Input Manual Iuran
            </button>
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
        <div class="separator separator-dashed my-5"></div>
    
            <div class="d-flex flex-stack flex-wrap gap-4">
                <div class="d-flex align-items-center flex-wrap gap-5 fs-7">
                    <div class="fw-bold text-gray-800">Keterangan:</div>
    
                    <div class="d-flex align-items-center">
                        <span class="bullet bullet-dot bg-success h-8px w-8px me-2"></span>
                        <span class="text-gray-600">Lunas / Sudah Bayar</span>
                    </div>
    
                    <div class="d-flex align-items-center">
                        <span class="bullet bullet-dot bg-danger h-8px w-8px me-2"></span>
                        <span class="text-gray-600">Belum Bayar</span>
                    </div>
    
                    <div class="d-flex align-items-center">
                        <span class="text-gray-400 fw-bold me-2">—</span>
                        <span class="text-gray-600">Belum Ada Tagihan</span>
                    </div>
                </div>
    
                <div class="text-muted fs-8">
                    * Nominal otomatis menyesuaikan iuran yang berlaku.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_input_manual" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_input_manual" action="<?= base_url('laporan/simpan-manual') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bold">Input Iuran Manual (Batch)</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Pilih Pegawai</label>
                        <select name="pegawai_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#modal_input_manual" required>
                            <option value="">Cari Nama...</option>
                            <?php foreach ($pegawai as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Tahun</label>
                            <input type="number" class="form-control form-control-solid" name="tahun" value="<?= date('Y') ?>" required />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Status Pembayaran</label>
                            <select name="status" class="form-select form-select-solid" required>
                                <option value="S">Lunas (S)</option>
                                <option value="B">Belum Lunas (B)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Dari Bulan</label>
                            <select name="bulan_mulai" class="form-select form-select-solid" required>
                                <?php
                                $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                                foreach ($bulan as $index => $nama): ?>
                                    <option value="<?= $index + 1 ?>"><?= $nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Sampai Bulan</label>
                            <select name="bulan_selesai" class="form-select form-select-solid" required>
                                <?php foreach ($bulan as $index => $nama): ?>
                                    <option value="<?= $index + 1 ?>" <?= ($index == 11) ? 'selected' : '' ?>><?= $nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Jumlah Iuran per Bulan (Rp)</label>
                        <input type="number" class="form-control form-control-solid" name="jumlah" placeholder="Contoh: 50000" required />
                        <div class="text-muted fs-7 mt-2">Sistem akan mengisi nominal ini otomatis pada rentang bulan yang dipilih.</div>
                    </div>

                    <div class="fv-row mb-7">
                        <div class="d-flex flex-stack">
                            <div class="me-5">
                                <label class="fs-6 fw-semibold">Kirim Notifikasi?</label>
                                <div class="fs-7 text-muted">Kirim notifikasi ke akun anggota jika tagihan diterbitkan</div>
                            </div>
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="kirim_notif" value="1" checked="checked" />
                                <span class="form-check-label fw-semibold text-muted">Ya</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Fungsi Render Dinamis
        const formatStatusCurrency = (data, type, row, meta) => {
            if (data === null || data === undefined) {
                return `<span class="text-muted">-</span>`;
            }

            // Mengambil nama field bulan (jan, feb, dst)
            const colName = meta.settings.aoColumns[meta.col].data;
            // Mengambil status dari field pendamping (jan_status, feb_status, dst)
            const status = row[colName + '_status'];

            if (status === 'S') {
                return `<span class="badge badge-light-success text-success fw-bold">${Number(data).toLocaleString()}</span>`;
            } else {
                return `<span class="badge badge-light-danger text-danger fw-bold">${Number(data).toLocaleString()}</span>`;
            }
        };

        let table = $('#table_laporan_iuran').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url('laporan/datatable') ?>",
                type: "POST",
                data: function(d) {
                    d.tahun = $('#filter_tahun').val();
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
                    render: formatStatusCurrency
                },
                {
                    data: 'feb',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'mar',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'apr',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'mei',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'jun',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'jul',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'agu',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'sep',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'okt',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'nov',
                    className: 'text-center',
                    render: formatStatusCurrency
                },
                {
                    data: 'des',
                    className: 'text-center',
                    render: formatStatusCurrency
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