<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-header">
        <div class="card-title">
            <h2 class="fw-bold">Pendaftaran Anggota Koperasi</h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('pegawai') ?>" class="btn btn-light">Kembali</a>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-5 mb-10">
            <div class="col-md-4">
                <div class="bg-light-primary rounded p-4 border border-primary border-dashed h-100">
                    <div class="text-gray-400 fw-bold fs-7 text-uppercase mb-2">Biaya Pendaftaran</div>
                    <div class="text-gray-800 fw-bolder fs-3">Rp 250.000</div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="bg-light-info rounded p-4 border border-info border-dashed h-100">
                    <div class="text-gray-400 fw-bold fs-7 text-uppercase mb-2">Rekening Pembayaran (<?= setting('nama_bank') ?>)</div>
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="me-5">
                            <div class="d-flex align-items-center">
                                <span id="norek_number" class="text-gray-800 fw-bolder fs-4 me-2"><?= setting('norek') ?></span>
                                <button type="button" class="btn btn-icon btn-sm btn-light-primary" onclick="copyToClipboard('<?= setting('norek') ?>')">
                                    <i class="ki-outline ki-copy fs-5"></i>
                                </button>
                            </div>
                            <span class="text-gray-600 fw-semibold fs-6">a.n <?= setting('nama_pemilik') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-10" />

        <form action="<?= base_url('pegawai/update-pendaftaran/'. $pegawai['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row mb-8">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" class="form-control form-control-solid" value="250000" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal Bayar</label>
                    <input type="text" name="tgl_bayar" class="form-control datepicker-indo" value="" required>
                </div>
            </div>

            <div class="mb-8">
                <label class="form-label fw-bold">Bukti Transfer <span class="text-muted fw-normal fs-7">(Opsional)</span></label>
                <div class="upload-box p-10 border-2 border-dashed rounded text-center" 
                     style="cursor: pointer; background: #f9f9f9; border-color: #e4e6ef;" 
                     onclick="document.getElementById('bukti_bayar').click()">
                    
                    <i class="ki-outline ki-cloud-upload fs-3x text-primary mb-3"></i>
                    <div class="fw-bold fs-4 text-gray-700">Klik untuk upload bukti pembayaran</div>
                    <div class="text-muted">Format JPG, PNG, atau PDF (Maks 2MB)</div>
                    
                    <input type="file" name="bukti_bayar" id="bukti_bayar" class="d-none" accept="image/*,application/pdf" onchange="displayFileName(this)">
                    
                    <div id="file-chosen" class="mt-3 text-primary fw-bold"></div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ki-outline ki-send fs-2"></i> Proses Pendaftaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Fungsi menampilkan nama file setelah dipilih
function displayFileName(input) {
    const feedback = document.getElementById('file-chosen');
    if (input.files.length > 0) {
        feedback.innerHTML = `<i class="ki-outline ki-document text-primary"></i> ${input.files[0].name}`;
    } else {
        feedback.textContent = "";
    }
}

// Fungsi salin nomor rekening
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Nomor rekening berhasil disalin!');
    });
}
</script>

<?= $this->endSection() ?>