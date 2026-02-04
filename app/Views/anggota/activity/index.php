<?= $this->extend('pages/layoutAnggota') ?>
<?= $this->section('styles') ?>
<style>
    .upload-box {
        border: 2px dashed #dcdcdc;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .upload-box:hover {
        border-color: #ffc700;
        background-color: #fff8dd;
    }

    .upload-box input[type="file"] {
        display: none;
    }

    .upload-box.selected {
        border-color: #50cd89;
        background-color: #e8fff3;
    }

    .upload-box.selected .text-success {
        color: #50cd89;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php
// Cek data pegawai lengkap
$isDataLengkap = $pegawai &&
    !empty($pegawai['nip']) &&
    !empty($pegawai['nama']) &&
    !empty($pegawai['nik']) &&
    !empty($pegawai['jenis_kelamin']) &&
    !empty($pegawai['tanggal_lahir']) &&
    !empty($pegawai['tempat_lahir']) &&
    !empty($pegawai['alamat']) &&
    !empty($pegawai['no_hp']) &&
    !empty($pegawai['angkatan']);

// Cek data pembayaran terakhir
$hasUploaded = $pembayaran && !empty($pembayaran['bukti_bayar']);
$pembayaranStatus = $pembayaran['status'] ?? null;

// Mode edit data pegawai
$editing = isset($_GET['edit']) && $_GET['edit'] === 'true';

// Mode edit pembayaran
$editingPembayaran = isset($_GET['editBayar']) && $_GET['editBayar'] === 'true';
?>

<!-- ===== HEADER PROFILE ===== -->
<div class="card  card-flush mb-6">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <?= img_lazy('uploads/profile/default.png', 'Profile', ['class'  => 'img-fluid rounded shadow-sm']) ?>
                    <?php if ($pegawai['status'] === 'A'): ?>
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-gray-900 fs-2 fw-bold me-1"><?= esc($pegawai['nama'] ?? 'User Baru') ?></span>
                        </div>
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <span class="text-gray-400 me-5 mb-2">NIP : <?= esc($pegawai['nip'] ?? '-') ?></span>
                            <span class="text-gray-400 me-5 mb-2">No HP : <?= esc($pegawai['no_hp'] ?? '-') ?></span>
                        </div>
                    </div>

                    <div class="d-flex my-4">
                        <span class="badge badge-light-<?= $pegawai['status'] == 'A' ? 'success' : 'warning' ?> fs-6">
                            <?= strtoupper($pegawai['status'] == 'A' ? 'Aktif' : 'Tidak Aktif') ?>
                        </span>
                    </div>
                </div>

                <!-- ===== PROGRESS ===== -->
                <?php
                $progress = 0;
                if ($isDataLengkap) $progress = 50;
                if ($hasUploaded && $pembayaranStatus === 'A') $progress = 100;
                ?>
                <div class="d-flex align-items-center w-200px flex-column mt-3">
                    <div class="d-flex justify-content-between w-100 mb-2">
                        <span class="fw-semibold fs-6 text-gray-400">Progress</span>
                        <span class="fw-bold fs-6"><?= $progress ?>%</span>
                    </div>
                    <div class="h-5px w-100 bg-light">
                        <div class="bg-success rounded h-5px" style="width: <?= $progress ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-line-tabs fs-5 fw-bold mt-5">
            <li class="nav-item"><a class="nav-link active">Activity</a></li>
        </ul>
    </div>
</div>

<!-- ===== TIMELINE & FORM ===== -->
<div class="card  card-flush">
    <div class="card-body">
        <div class="card-body bg-light-primary rounded border-primary border border-dashed p-6 mb-10">
            <div class="d-flex flex-stack flex-wrap flex-sm-nowrap">
                <div class="d-flex flex-column me-9">
                    <div class="d-flex align-items-center mb-4">
                        <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
                            <i class="ki-duotone ki-information-5 fs-2qx text-primary">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                        </span>
                        <h3 class="text-gray-900 fw-bolder mb-0">Alur Pendaftaran & Aktivasi Anggota</h3>
                    </div>

                    <div class="text-gray-700 fw-semibold fs-6 ms-1 ms-sm-12">
                        <p class="mb-4 text-gray-600">Mohon ikuti langkah-langkah di bawah ini untuk mengaktifkan keanggotaan Anda:</p>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <span class="badge badge-circle badge-light-primary fw-bold me-3 fs-4">1</span>
                                    <div>
                                        <span class="fw-bold text-gray-800">Lengkapi Data Diri</span>
                                        <div class="fs-7 text-muted">Isi formulir pada Step 1 dengan data yang valid.</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start mb-3">
                                    <span class="badge badge-circle badge-light-primary fw-bold me-3 fs-4">2</span>
                                    <div>
                                        <span class="fw-bold text-gray-800">Pembayaran Simpanan Pokok</span>
                                        <div class="fs-7 text-muted">Transfer sesuai nominal ke rekening yang tertera.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <span class="badge badge-circle badge-light-primary fw-bold me-3 fs-4">3</span>
                                    <div>
                                        <span class="fw-bold text-gray-800">Unggah Bukti Transfer</span>
                                        <div class="fs-7 text-muted">Wajib mengunggah foto bukti bayar yang jelas pada Step 2.</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start">
                                    <span class="badge badge-circle badge-light-primary fw-bold me-3 fs-4">4</span>
                                    <div>
                                        <span class="fw-bold text-gray-800">Verifikasi Admin</span>
                                        <div class="fs-7 text-muted">Akun akan aktif sepenuhnya setelah divalidasi oleh Admin.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="separator separator-dashed border-primary opacity-25 my-4"></div>

            <div class="row g-5">
                <div class="col-md-4">
                    <div class="bg-white bg-opacity-50 rounded p-4 border border-white h-100">
                        <div class="text-gray-400 fw-bold fs-7 text-uppercase mb-2">Biaya Pendaftaran</div>
                        <div class="text-gray-800 fw-bolder fs-3">Rp 250.000</div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="bg-white bg-opacity-50 rounded p-4 border border-white h-100">
                        <div class="text-gray-400 fw-bold fs-7 text-uppercase mb-2">Rekening Pembayaran (<?= setting('nama_bank') ?>)</div>
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="me-5">
                                <div class="d-flex align-items-center">
                                    <span id="norek_number" class="text-gray-800 fw-bolder fs-4 me-2"><?= setting('norek') ?></span>

                                    <button type="button"
                                        class="btn btn-icon btn-sm btn-light-primary btn-active-primary w-25px h-25px"
                                        onclick="copyToClipboard('<?= setting('norek') ?>', this)"
                                        data-bs-toggle="tooltip"
                                        title="Salin No. Rekening">
                                        <i class="ki-duotone ki-copy fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                </div>
                                <span class="text-gray-600 fw-semibold fs-6">a.n <?= setting('nama_pemilik') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="timeline">

            <!-- STEP 1: Lengkapi Data Pegawai -->
            <div class="timeline-item">
                <div class="timeline-line w-40px"></div>
                <div class="timeline-icon symbol symbol-circle symbol-40px">
                    <div class="symbol-label <?= !$isDataLengkap ? 'bg-light' : 'bg-light-success' ?>">
                        <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                </div>
                <div class="timeline-content mb-10">
                    <div class="fs-5 fw-semibold">1. Lengkapi Data Pegawai</div>

                    <?php if (!$isDataLengkap || $editing): ?>
                        <form action="<?= base_url('sw-anggota/lengkapi-data') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">NIP (Otomatis)</label>
                                    <input type="text" name="nip" class="form-control"
                                        value="<?= old('nip', $pegawai['nip'] ?? date('Ymd') . rand(1000, 9999)) ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="number"
                                        name="nik"
                                        class="form-control"
                                        value="<?= old('nik', $pegawai['nik'] ?? '') ?>"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        maxlength="16"
                                        minlength="16"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $pegawai['nama'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" <?= old('jenis_kelamin', $pegawai['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= old('jenis_kelamin', $pegawai['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="text" name="tanggal_lahir" class="form-control datepicker-indo" value="<?= old('tanggal_lahir', $pegawai['tanggal_lahir'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir', $pegawai['tempat_lahir'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2" required><?= old('alamat', $pegawai['alamat'] ?? '') ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No HP</label>
                                    <input type="number"
                                        name="no_hp"
                                        class="form-control"
                                        value="<?= old('no_hp', $pegawai['no_hp'] ?? '') ?>"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        maxlength="15"
                                        minlength="10"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Angkatan <span style="opacity: 0.6; font-size: 0.9em;">(Isi 0 untuk yang tidak memiliki angkatan)</span></label>
                                    <input type="number" name="angkatan" class="form-control" value="<?= old('angkatan', $pegawai['angkatan'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>
                                <?php if ($isDataLengkap && !$editing): ?>
                                    <a href="<?= current_url() ?>?edit=true" class="btn btn-secondary btn-sm ms-2">Edit</a>
                                <?php endif ?>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="d-flex justify-content-between">
                            <span class="badge badge-light-success mt-3">Selesai</span>
                            <a href="<?= current_url() ?>?edit=true" class="btn btn-secondary btn-sm mt-2">Edit</a>
                        </div>
                    <?php endif ?>
                </div>
            </div>

            <!-- STEP 2: Upload Bukti Pembayaran -->
            <div class="timeline-item">
                <div class="timeline-line w-40px"></div>
                <div class="timeline-icon symbol symbol-circle symbol-40px">
                    <div class="symbol-label <?= $hasUploaded && !$editingPembayaran ? 'bg-light-success' : 'bg-light' ?>">
                        <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                </div>
                <div class="timeline-content mb-10">
                    <div class="fs-5 fw-semibold">2. Upload Bukti Pembayaran</div>

                    <?php if ($isDataLengkap): ?>
                        <?php if ($hasUploaded && !$editingPembayaran): ?>
                            <div class="mb-3">
                                <span class="badge badge-light-success mt-3">Selesai</span>
                            </div>

                            <!-- Preview Gambar -->
                            <div class="mb-3">
                                <?= img_lazy('uploads/bukti-bayar/' . $pembayaran['bukti_bayar'], 'Bukti Pembayaran', ['style'  => 'max-width: 300px', 'class'  => 'img-thumbnail']) ?>
                            </div>

                            <div class="text-end">
                                <a href="<?= current_url() ?>?editBayar=true" class="btn btn-secondary btn-sm">Edit</a>
                            </div>
                        <?php else: ?>
                            <form action="<?= base_url('sw-anggota/pembayaran') ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Jumlah Bayar</label>
                                        <input type="number" name="jumlah_bayar" class="form-control" value="<?= old('jumlah_bayar', $pembayaran['jumlah_bayar'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Bayar</label>
                                        <input type="text" name="tgl_bayar" class="form-control datepicker-indo" value="<?= old('tgl_bayar', $pembayaran['tgl_bayar'] ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="upload-box w-100" id="uploadBox">
                                        <div class="mb-3">
                                            <i id="uploadIcon" class="ki-duotone ki-cloud-upload fs-2x text-warning">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>

                                        <div id="uploadText" class="fw-semibold fs-6 text-gray-700">
                                            Klik untuk upload bukti pembayaran
                                        </div>

                                        <div id="fileName" class="text-muted fs-7 mt-1">
                                            Format JPG / PNG • Maks 2MB
                                        </div>

                                        <input
                                            type="file"
                                            name="bukti_bayar"
                                            id="bukti_bayar"
                                            accept="image/*"
                                            required>
                                    </label>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-warning btn-sm">Upload</button>
                                </div>
                            </form>
                        <?php endif ?>
                    <?php else: ?>
                        <span class="badge badge-light-secondary mt-3">Lengkapi Data Pegawai terlebih dahulu</span>
                    <?php endif ?>
                </div>
            </div>

            <!-- STEP 3: Approval Admin -->
            <div class="timeline-item">
                <div class="timeline-line w-40px"></div>
                <div class="timeline-icon symbol symbol-circle symbol-40px">
                    <div class="symbol-label bg-light">
                        <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                </div>
                <div class="timeline-content">
                    <div class="fs-5 fw-semibold">3. Approval Admin</div>
                    <?php if ($pembayaranStatus === 'A'): ?>
                        <span class="badge badge-light-success mt-3">Disetujui | Pegawai Aktif</span>

                    <?php elseif ($pembayaranStatus === 'P'): ?>
                        <span class="badge badge-light-warning mt-3">Menunggu Approval</span>

                    <?php elseif ($pembayaranStatus === 'R'): ?>
                        <span class="badge badge-light-danger mt-3">Ditolak</span>

                        <?php if (!empty($pembayaran['keterangan'])): ?>
                            <div class="alert alert-danger mt-3">
                                <strong>Keterangan:</strong><br>
                                <?= esc($pembayaran['keterangan']) ?>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <span class="badge badge-light-secondary mt-3">Belum Upload Pembayaran</span>
                    <?php endif ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    document.getElementById('bukti_bayar').addEventListener('change', function() {
        const box = document.getElementById('uploadBox');
        const text = document.getElementById('uploadText');
        const fileName = document.getElementById('fileName');
        const icon = document.getElementById('uploadIcon');

        if (this.files.length > 0) {
            box.classList.add('selected');

            text.textContent = 'File siap diupload';
            fileName.textContent = '📄 ' + this.files[0].name;
            fileName.classList.remove('text-muted');
            fileName.classList.add('fw-semibold', 'text-success');

            icon.classList.remove('text-warning');
            icon.classList.add('text-success');
            icon.classList.replace('ki-cloud-upload', 'ki-check-circle');
        }
    });
</script>

<script>
    function copyToClipboard(text, btnElement) {
        // Membuat elemen temporary untuk menyalin teks
        const el = document.createElement('textarea');
        el.value = text;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);

        // Ambil konten asli ikon
        const originalHTML = btnElement.innerHTML;

        // Feedback visual: Ganti ikon ke centang
        btnElement.innerHTML = '<i class="ki-duotone ki-check fs-5 text-success"></i>';

        // Update Tooltip jika menggunakan Bootstrap
        if (window.bootstrap) {
            const tooltip = bootstrap.Tooltip.getInstance(btnElement);
            if (tooltip) {
                btnElement.setAttribute('data-bs-original-title', 'Berhasil Disalin!');
                tooltip.show();
            }
        }

        // Kembalikan tombol ke kondisi semula setelah 2 detik
        setTimeout(() => {
            btnElement.innerHTML = originalHTML;
            if (window.bootstrap) {
                const tooltip = bootstrap.Tooltip.getInstance(btnElement);
                if (tooltip) {
                    btnElement.setAttribute('data-bs-original-title', 'Salin No. Rekening');
                    tooltip.hide();
                }
            }
        }, 2000);
    }
</script>
<?= $this->endSection() ?>