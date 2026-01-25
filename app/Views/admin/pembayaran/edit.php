<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('pembayaran/update/' . $pembayaran['id']) ?>" method="post">
<?= csrf_field() ?>

<div class="card card-flush">

    <!-- HEADER -->
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">Approval Pembayaran</h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('pembayaran') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body pt-6">

        <!-- DATA PEGAWAI -->
        <h5 class="mb-4">Data Pegawai</h5>
        <div class="row g-5 mb-7">

            <div class="col-md-6">
                <label class="form-label">Nama Pegawai</label>
                <input type="text"
                       class="form-control form-control-solid"
                       value="<?= esc($pembayaran['nama']) ?>"
                       readonly>
            </div>

            <div class="col-md-3">
                <label class="form-label">NIP</label>
                <input type="text"
                       class="form-control form-control-solid"
                       value="<?= esc($pembayaran['nip']) ?>"
                       readonly>
            </div>

            <div class="col-md-3">
                <label class="form-label">No HP</label>
                <input type="text"
                       class="form-control form-control-solid"
                       value="<?= esc($pembayaran['no_hp']) ?>"
                       readonly>
            </div>

        </div>

        <!-- DATA PEMBAYARAN -->
        <h5 class="mb-4">Data Pembayaran</h5>
        <div class="row g-5 mb-7">

            <div class="col-md-4">
                <label class="form-label">Tanggal Bayar</label>
                <input type="text"
                       class="form-control form-control-solid"
                       value="<?= date('d-m-Y', strtotime($pembayaran['tgl_bayar'])) ?>"
                       readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label">Nominal</label>
                <input type="text"
                       class="form-control form-control-solid"
                       value="<?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>"
                       readonly>
            </div>

        </div>

        <!-- BUKTI TRANSFER -->
        <h5 class="mb-4">Bukti Transfer</h5>

        <div class="mb-7">
            <a href="<?= base_url('uploads/bukti/' . $pembayaran['bukti_bayar']) ?>"
               target="_blank">
                <img src="<?= base_url('uploads/bukti-bayar/' . $pembayaran['bukti_bayar']) ?>"
                     class="img-fluid rounded border"
                     style="max-height: 400px;">
            </a>
        </div>

        <!-- APPROVAL -->
        <!-- KEPUTUSAN ADMIN -->
        <h5 class="mb-4">Keputusan Admin</h5>

        <div class="row g-5">

            <div class="col-md-4">
                <label class="required form-label">Status Approval</label>
                <select name="status"
                        id="status"
                        class="form-select form-select-solid"
                        required>
                    <option value="">-- Pilih Status --</option>
                    <option value="A">Approved</option>
                    <option value="R">Rejected</option>
                </select>
            </div>

            <!-- ALASAN REJECT -->
            <div class="col-md-8 d-none" id="rejectReasonWrapper">
                <label class="required form-label">Alasan Penolakan</label>
                <textarea name="reject_reason"
                        class="form-control form-control-solid"
                        rows="4"
                        placeholder="Contoh: Bukti transfer buram / nominal tidak sesuai"></textarea>
            </div>

        </div>


    </div>

    <!-- FOOTER -->
    <div class="card-footer d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="bi bi-check-circle me-1"></i> Simpan Keputusan
        </button>
    </div>

</div>
</form>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    document.getElementById('status').addEventListener('change', function() {
        const rejectReasonWrapper = document.getElementById('rejectReasonWrapper');
        if (this.value === 'R') {
            rejectReasonWrapper.classList.remove('d-none');
        } else {
            rejectReasonWrapper.classList.add('d-none');
        }
    });
</script>
<?= $this->endSection() ?>
