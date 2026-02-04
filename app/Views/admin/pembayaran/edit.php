<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="card card-flush shadow-sm">
        <div class="card-header border-0 pt-5">
            <div class="card-title flex-column">
                <h3 class="fw-bold mb-1">Approval Pembayaran</h3>
                <div class="fs-7 fw-semibold text-muted">Halaman verifikasi bukti transaksi anggota koperasi</div>
            </div>
            <div class="card-toolbar">
                <a href="<?= base_url('pembayaran') ?>" class="btn btn-light-primary btn-sm rounded-pill">
                    <i class="ki-outline ki-arrow-left fs-3"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body py-5">

            <?php if ($pembayaran['status'] === 'A'): ?>
                <div class="bg-light-success d-flex flex-column flex-sm-row p-5 mb-10 border border-success border-dashed rounded-4">
                    <i class="ki-outline ki-verify fs-2tx text-success me-4 mb-5 mb-sm-0"></i>
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <h4 class="fw-bold text-success">Pembayaran Terverifikasi</h4>
                        <span>Transaksi ini telah dinyatakan <strong>LUNAS</strong> dan masuk ke dalam sistem keuangan.</span>
                    </div>
                    <div class="d-flex align-items-center ms-sm-auto mt-5 mt-sm-0">
                        <a href="<?= base_url('pembayaran/invoice/' . $pembayaran['id']) ?>" class="btn btn-success btn-sm px-6 shadow-sm">
                            <i class="ki-outline ki-document fs-3 me-1"></i> Lihat Invoice
                        </a>
                    </div>
                </div>
            <?php elseif ($pembayaran['status'] === 'R'): ?>
                <div class="bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10 border border-danger border-dashed rounded-4">
                    <i class="ki-outline ki-cross-circle fs-2tx text-danger me-4 mb-5 mb-sm-0"></i>
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <h4 class="fw-bold text-danger">Pembayaran Ditolak</h4>
                        <span>Alasan: <strong><?= esc($pembayaran['reject_reason']) ?></strong>. Anggota perlu melakukan upload ulang.</span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row g-xl-10">
                <div class="col-lg-7">
                    <div class="bg-secondary bg-opacity-30 rounded-4 p-7 mb-7">
                        <h5 class="fw-bold text-dark mb-5">
                            <i class="ki-outline ki-profile-user fs-3 text-primary me-2"></i> Identitas Pembayar
                        </h5>
                        <div class="row mb-5">
                            <div class="col-6">
                                <label class="fs-8 fw-bold text-muted text-uppercase ls-1 d-block">Nama Lengkap</label>
                                <span class="fs-6 fw-bold text-gray-800"><?= esc($pembayaran['nama']) ?></span>
                            </div>
                            <div class="col-6">
                                <label class="fs-8 fw-bold text-muted text-uppercase ls-1 d-block">NIP / ID Anggota</label>
                                <span class="fs-6 fw-bold text-gray-800"><?= esc($pembayaran['nip']) ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="fs-8 fw-bold text-muted text-uppercase ls-1 d-block">Nomor Telepon</label>
                                <span class="fs-6 fw-bold text-gray-800"><?= esc($pembayaran['no_hp']) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light-primary bg-opacity-50 rounded-4 p-7 mb-7 border border-primary border-dotted">
                        <h5 class="fw-bold text-primary mb-5">
                            <i class="ki-outline ki-wallet fs-3 text-primary me-2"></i> Detail Transaksi
                        </h5>
                        <div class="row mb-0">
                            <div class="col-6 border-end border-primary border-opacity-25">
                                <label class="fs-8 fw-bold text-muted text-uppercase ls-1 d-block">Tanggal Bayar</label>
                                <span class="fs-5 fw-bolder text-dark"><?= date('d M Y', strtotime($pembayaran['tgl_bayar'])) ?></span>
                            </div>
                            <div class="col-6 ps-7">
                                <label class="fs-8 fw-bold text-muted text-uppercase ls-1 d-block">Total Bayar</label>
                                <span class="fs-4 fw-boldest text-success">Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>

                    <?php if ($pembayaran['status'] !== 'A'): ?>
                        <div class="card border border-gray-300 shadow-none rounded-4">
                            <div class="card-body p-6">
                                <h5 class="fw-bold text-dark mb-6">Keputusan Verifikasi</h5>
                                <form action="<?= base_url('pembayaran/update/' . $pembayaran['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="row g-5">
                                        <div class="col-md-5">
                                            <label class="required form-label fw-semibold">Status Tindakan</label>
                                            <select name="status" id="status" class="form-select form-select-solid border-gray-400" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="A" <?= $pembayaran['status'] == 'A' ? 'selected' : '' ?>>Setujui (Approve)</option>
                                                <option value="R" <?= $pembayaran['status'] == 'R' ? 'selected' : '' ?>>Tolak (Reject)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-7 <?= $pembayaran['status'] !== 'R' ? 'd-none' : '' ?>" id="rejectReasonWrapper">
                                            <label class="required form-label fw-semibold">Alasan Penolakan</label>
                                            <textarea name="reject_reason" class="form-control form-control-solid border-gray-400" rows="2" placeholder="Sebutkan kendala bukti bayar..."><?= esc($pembayaran['reject_reason'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="separator my-6"></div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary px-10">
                                            <i class="ki-outline ki-check-circle fs-3 me-1"></i> Simpan Hasil Verifikasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-5 mt-10 mt-lg-0">
                    <h5 class="fw-bold text-dark mb-5">
                        <i class="ki-outline ki-image fs-3 text-primary me-2"></i> Lampiran Bukti Transfer
                    </h5>
                    <div class="overlay overflow-hidden rounded-4 border border-gray-300 shadow-sm">
                        <div class="overlay-wrapper">
                            <?= img_lazy('uploads/bukti-bayar/' . $pembayaran['bukti_bayar'], 'Bukti Transfer', [
                                'style' => 'width: 100%; height: auto; min-height: 250px;',
                                'class' => 'img-fluid object-fit-contain bg-light'
                            ]) ?>
                        </div>
                        <div class="overlay-layer bg-dark bg-opacity-10 align-items-center justify-content-center">
                            <a href="<?= base_url('uploads/bukti-bayar/' . $pembayaran['bukti_bayar']) ?>" target="_blank" class="btn btn-sm btn-primary shadow-lg">
                                <i class="ki-outline ki-magnifier fs-4 me-1"></i> Lihat Gambar Penuh
                            </a>
                        </div>
                    </div>
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-4 mt-5">
                        <i class="ki-outline ki-information-5 fs-2tx text-warning me-4"></i>
                        <div class="d-flex flex-stack flex-grow-1">
                            <div class="fw-semibold">
                                <div class="fs-8 text-gray-700">Pastikan Nama Pengirim, Tanggal, dan Nominal pada struk sesuai dengan data yang diinput oleh anggota.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const statusSelect = document.getElementById('status');
    const rejectWrapper = document.getElementById('rejectReasonWrapper');

    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            if (this.value === 'R') {
                rejectWrapper.classList.remove('d-none');
                rejectWrapper.querySelector('textarea').setAttribute('required', 'required');
            } else {
                rejectWrapper.classList.add('d-none');
                rejectWrapper.querySelector('textarea').removeAttribute('required');
            }
        });
    }
</script>
<?= $this->endSection() ?>