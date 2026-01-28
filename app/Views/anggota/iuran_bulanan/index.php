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
                        placeholder="Cari Pegawai / Iuran">
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

            <div class="ms-auto fw-semibold">
                Total:
                <span id="total-iuran" class="text-primary fw-bold">
                    Rp 0
                </span>
            </div>

            <button id="btn-bayar-terpilih"
                    class="btn btn-sm btn-success ms-4"
                    disabled>
                <i class="bi bi-cash-coin me-1"></i>
            </button>

        </div>

        <!-- LIST -->
        <div id="iuran-list"></div>

        <!-- DATATABLE ENGINE -->
        <table id="kt_iuran_bulanan_table" class="d-none"></table>

    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {

    let table = $('#kt_iuran_bulanan_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        paging: true,
        searching: true,
        lengthChange: false,

        ajax: {
            url: "<?= base_url('sw-anggota/iuran/datatable') ?>",
            type: "POST",
            dataSrc: function (json) {
                renderIuranList(json.data);
                return [];
            }
        },

        columns: [
            { data: 'pegawai_id' },
            { data: 'nama_pegawai' },
            { data: 'bulan_tahun' },
            { data: 'jumlah_iuran' },
            { data: 'status' },
            { data: 'id' }
        ]
    });

    // SEARCH
    $('[data-kt-ecommerce-order-filter="search"]').keyup(function () {
        table.search(this.value).draw();
    });

    // CHECK ALL
    $(document).on('change', '#check-all', function () {
        $('.checkbox-iuran:not(:disabled)').prop('checked', this.checked);
        hitungTotal();
        toggleButton();
    });

    // CHECKBOX LOGIC (ANTI LONCAT BULAN)
    $(document).on('change', '.checkbox-iuran', function () {

        let pegawaiId = $(this).data('pegawai');

        // Ambil semua checkbox pegawai yg sama & belum lunas
        let list = $('.checkbox-iuran').filter(function () {
            return !this.disabled && $(this).data('pegawai') === pegawaiId;
        }).toArray();

        // 🔥 SORT BERDASARKAN TAHUN + BULAN
        list.sort((a, b) => {
            let pa = $(a).data('tahun') * 100 + $(a).data('bulan');
            let pb = $(b).data('tahun') * 100 + $(b).data('bulan');
            return pa - pb;
        });

        let index = list.indexOf(this);

        // ============================
        // JIKA CHECK → TARIK KE BELAKANG
        // ============================
        if (this.checked) {
            for (let i = 0; i < index; i++) {
                list[i].checked = true;
            }
        }

        // ============================
        // JIKA UNCHECK → LEPAS KE DEPAN
        // ============================
        if (!this.checked) {
            for (let i = index + 1; i < list.length; i++) {
                list[i].checked = false;
            }
        }

        hitungTotal();
        toggleButton();
    });




    function hitungTotal() {
        let total = 0;
        $('.checkbox-iuran:checked').each(function () {
            total += parseFloat($(this).data('nominal'));
        });
        $('#total-iuran').text('Rp ' + total.toLocaleString('id-ID'));
    }

    function toggleButton() {
        $('#btn-bayar-terpilih')
            .prop('disabled', $('.checkbox-iuran:checked').length === 0);
    }

    // RENDER LIST
    function renderIuranList(data) {

        if (!data || data.length === 0) {
            $('#iuran-list').html(
                '<div class="text-center text-muted py-10">Data tidak ditemukan</div>'
            );
            return;
        }

        // ✅ SORT BERDASARKAN PEGAWAI + PERIODE
        data.sort((a, b) => {

            if (a.pegawai_id !== b.pegawai_id) {
                return a.pegawai_id - b.pegawai_id;
            }

            let pa = (a.tahun * 100) + a.bulan;
            let pb = (b.tahun * 100) + b.bulan;

            return pa - pb;
        });

        let html = '';

        data.forEach(row => {
            if(row.status === 'S') {
                var statusBadge = '<span class="badge badge-light-success">Lunas</span>';
            } else if (row.status === 'B') {
                var statusBadge = '<span class="badge badge-light-secondary">Belum Bayar</span>';
            }else if (row.status === 'P') {
                var statusBadge = '<span class="badge badge-light-warning">Menunggu Pembayaran</span>';
            }else{
                var statusBadge = '<span class="badge badge-light-info">Menunggu verifikasi admin</span>';
            }
          
            let initial = row.nama_pegawai.charAt(0).toUpperCase();

            html += `
            <div class="d-flex align-items-center mb-5">
                ${(row.status == 'B') || (row.status == 'P') ? `
                <div class="me-4">
                    <input class="form-check-input checkbox-iuran"
                        type="checkbox"
                        data-id="${row.id}"
                        data-pegawai="${row.pegawai_id}"
                        data-bulan="${row.bulan}"
                        data-tahun="${row.tahun}"
                        data-nominal="${row.jumlah_iuran}">
                </div>
                ` : `
                <div class="me-4 form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input checkbox-iuran" disabled  type="checkbox">           
                </div>`}

                <div class="me-5">
                    <div class="symbol symbol-35px symbol-circle">
                        <span class="symbol-label bg-light-primary text-primary fw-semibold">
                            ${initial}
                        </span>
                    </div>
                </div>

                <div class="fw-semibold">
                    <div class="fs-6 fw-bold">${row.nama_pegawai}</div>
                    <div class="fs-7 text-muted">
                        ${row.bulan_tahun} • Rp ${parseInt(row.jumlah_iuran).toLocaleString('id-ID')}
                    </div>
                </div>

                <div class="ms-auto">
                    ${statusBadge}
                </div>

            </div>`;
        });

        $('#iuran-list').html(html);
    }


});

$('#btn-bayar-terpilih').on('click', function () {

    let ids = [];
    let total = 0;
    let pegawaiId = null;

    $('.checkbox-iuran:checked').each(function () {
        ids.push($(this).data('id'));
        total += parseFloat($(this).data('nominal'));
        pegawaiId = $(this).data('pegawai');
        bulan = $(this).data('bulan');
        tahun = $(this).data('tahun');
    });

    if (ids.length === 0) return;

    // CSRF
    let csrfName = $('meta[name="csrf-token-name"]').attr('content');
    let csrfHash = $('meta[name="csrf-token-hash"]').attr('content');

    let postData = {
        pegawai_id: pegawaiId,
        iuran_ids: ids,
        total_bayar: total,
        bulan: bulan,
        tahun: tahun,
    };

    postData[csrfName] = csrfHash;

    $.ajax({
        url: "<?= base_url('sw-anggota/iuran/bayar-proses') ?>",
        type: "POST",
        data: postData,
        dataType: "json",
        success: function (res) {

            // 🔁 update token baru
            if (res.csrfHash) {
                $('meta[name="csrf-token-hash"]').attr('content', res.csrfHash);
            }

            if (res.status === 'success') {
                window.location.href = res.redirect;
            } else {
                alert(res.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('Gagal memproses pembayaran');
        }
    });

});


</script>
<?= $this->endSection() ?>
