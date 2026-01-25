<?= $this->extend('pages/layoutAnggota') ?>
<?= $this->section('content') ?>
<div class="card card-flush">

    <!-- HEADER -->
    <div class="card-header align-items-center gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4"></i>
                <input type="text"
                        data-kt-ecommerce-order-filter="search"
                        class="form-control form-control-solid w-250px ps-12"
                        placeholder="Cari histro transaksi">
            </div>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body d-flex flex-column p-9 pt-3 mb-9">

        <!-- TOOLBAR -->
        <div class="d-flex align-items-center mb-4">

            <label class="form-check form-check-sm form-check-custom form-check-solid me-3">
                <input class="form-check-input" type="checkbox" id="check-all">
                <span class="form-check-label">Pilih Semua</span>
            </label>
        </div>

        <!-- LIST -->
        <div id="iuran-list"></div>

        <!-- DATATABLE ENGINE -->
        <table id="kt_histori_iuran_table" class="d-none"></table>

    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {

    let table = $('#kt_histori_iuran_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        paging: true,
        searching: true,
        lengthChange: false,

        ajax: {
            url: "<?= base_url('sw-anggota/histori-iuran/datatable') ?>",
            type: "POST",
            error: function (xhr, error, thrown) {
            console.error("Backend Error Area:");
            console.log(xhr.responseText); // Ini akan menampilkan isi error dari PHP
        },
            dataSrc: function (json) {
                renderIuranList(json.data);
                return [];
            }
        },

        columns: [
            { data: 'jenis_transaksi' },
            { data: 'bulan' },
            { data: 'tahun' },
            { data: 'jumlah_bayar' },
            { data: 'status' },
            { data: 'id' }
        ]
    });

    // SEARCH
    $('[data-kt-ecommerce-order-filter="search"]').keyup(function () {
        table.search(this.value).draw();
    });

   
    // RENDER LIST
    function renderIuranList(data) {

        if (!data || data.length === 0) {
            $('#iuran-list').html(
                '<div class="text-center text-muted py-10">Data tidak ditemukan</div>'
            );
            return;
        }
        let html = '';

        data.forEach(row => {
            if(row.status === 'A') {
                var statusBadge = '<span class="badge badge-light-success">Lunas</span>';
                var btnUpload = '<a href="<?= base_url('sw-anggota/histori-iuran') ?>/'+row.id+'" class="btn btn-sm btn-success ms-4">Invoice</a>';
            } else if (row.status === 'P') {
                var statusBadge = '<span class="badge badge-light-info">Menunggu Pembayaran</span>';
                var btnUpload = '<a href="<?= base_url('sw-anggota/histori-iuran') ?>/'+row.id+'" class="btn btn-sm btn-info ms-4">Upload Bukti</a>';
            }else if (row.status === 'V') {
                var statusBadge = '<span class="badge badge-light-warning">Menunggu Verifikasi</span>';
                var btnUpload = '<a href="<?= base_url('sw-anggota/histori-iuran') ?>/'+row.id+'" class="btn btn-sm btn-warning ms-4">Invoice</a>';
            }else{
                var statusBadge = '<span class="badge badge-light-danger">Pembayaran Dibatalkan</span>';
                var btnUpload = '<a href="<?= base_url('sw-anggota/histori-iuran') ?>/'+row.id+'" class="btn btn-sm btn-danger ms-4">Invoice</a>';
            }
          
            let initial = row.nama_pegawai.charAt(0).toUpperCase();
            html += `
            <div class="d-flex align-items-center mb-5">
                <div class="me-5">
                    <div class="symbol symbol-35px symbol-circle">
                        <span class="symbol-label bg-light-primary text-primary fw-semibold">
                            ${initial}
                        </span>
                    </div>
                </div>

                <div class="fw-semibold">
                    <div class="fs-6 fw-bold">Pembayaran Iuran Bulanan ${row.bulan}-${row.tahun}</div>
                    <div class="fs-7 text-muted">
                        Tagihan • Rp ${parseInt(row.jumlah_bayar).toLocaleString('id-ID')}
                    </div>
                    <div class="fs-7 text-muted">
                        ${statusBadge}
                    </div>
                </div>

                <div class="ms-auto">
                    ${btnUpload}
                </div>

            </div>`;
        });

        $('#iuran-list').html(html);
    }


});

</script>
<?= $this->endSection() ?>
