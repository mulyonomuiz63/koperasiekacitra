<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('pegawai/update/' . $pegawai['id']) ?>" method="post">
<?= csrf_field() ?>

<div class="card card-flush">
    <div class="card-header">
        <div class="card-title">
            <h2 class="fw-bold">Edit Pegawai</h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('pegawai') ?>" class="btn btn-light">Kembali</a>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-5">

            <!-- USER (LOCKED) -->
            <div class="col-md-6">
                <label class="form-label">User</label>
                <input type="text"
                       class="form-control form-control-solid"
                       value="<?= esc($pegawai['username']) ?>"
                       readonly>
                <input type="hidden" name="user_id" value="<?= $pegawai['user_id'] ?>">
            </div>

            <!-- NIP -->
            <div class="col-md-6">
                <label class="form-label">NIP</label>
                <input type="number" name="nip"
                       class="form-control form-control-solid"
                       value="<?= esc($pegawai['nip']) ?>">
            </div>

            <!-- NAMA -->
            <div class="col-md-6">
                <label class="required form-label">Nama Lengkap</label>
                <input type="text" name="nama"
                       class="form-control form-control-solid"
                       value="<?= esc($pegawai['nama']) ?>" required>
            </div>

            <!-- JENIS KELAMIN -->
            <div class="col-md-6">
                <label class="required form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                        class="form-select form-select-solid" required>
                    <option value="L" <?= $pegawai['jenis_kelamin']=='L'?'selected':'' ?>>Laki-laki</option>
                    <option value="P" <?= $pegawai['jenis_kelamin']=='P'?'selected':'' ?>>Perempuan</option>
                </select>
            </div>

            <!-- TANGGAL LAHIR -->
            <div class="col-md-6">
                <label class="required form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir"
                       class="form-control form-control-solid"
                       value="<?= esc($pegawai['tanggal_lahir']) ?>" required>
            </div>

            <!-- NO HP -->
            <div class="col-md-6">
                <label class="required form-label">No HP</label>
                <input type="number" name="no_hp"
                       class="form-control form-control-solid"
                       value="<?= esc($pegawai['no_hp']) ?>" required>
            </div>

            <!-- PERUSAHAAN -->
            <div class="col-md-6">
                <label class="required form-label">Perusahaan</label>
                <select name="perusahaan_id"
                        class="form-select form-select-solid" required>
                    <?php foreach ($perusahaan as $p): ?>
                        <option value="<?= $p['id'] ?>"
                            <?= $pegawai['perusahaan_id']==$p['id']?'selected':'' ?>>
                            <?= $p['nama_perusahaan'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- JABATAN -->
            <div class="col-md-6">
                <label class="required form-label">Jabatan</label>
                <select name="jabatan_id"
                        class="form-select form-select-solid" required>
                    <?php foreach ($jabatan as $j): ?>
                        <option value="<?= $j['id'] ?>"
                            <?= $pegawai['jabatan_id']==$j['id']?'selected':'' ?>>
                            <?= $j['nama_jabatan'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- TANGGAL MASUK -->
            <div class="col-md-6">
                <label class="required form-label">Tanggal Daftar Anggota</label>
                <input type="date" name="tanggal_masuk"
                       class="form-control form-control-solid"
                       value="<?= esc($pegawai['tanggal_masuk']) ?>" required>
            </div>

            <!-- STATUS -->
            <div class="col-md-6">
                <label class="required form-label">Status</label>
                <select name="status"
                        class="form-select form-select-solid" required>
                    <option value="A" <?= $pegawai['status']=='A'?'selected':'' ?>>Aktif</option>
                    <option value="T" <?= $pegawai['status']=='T'?'selected':'' ?>>Nonaktif</option>
                    <option value="R" <?= $pegawai['status']=='R'?'selected':'' ?>>Resign</option>
                </select>
            </div>

             <!-- STATUS IURAN -->
            <div class="col-md-6">
                <label class="form-label required">Status Iuran</label>
                <select name="status_iuran"
                        class="form-select form-select-solid"
                        required>
                    <option value="A"   <?= $pegawai['status_iuran']=='A'?'selected':'' ?>>Aktif</option>
                    <option value="T" <?= $pegawai['status_iuran']=='T'?'selected':'' ?>>Tidak Aktif</option>
                </select>
            </div>

            <!-- ALAMAT -->
            <div class="col-md-6">
                <label class="required form-label">Alamat</label>
                <textarea name="alamat"
                          class="form-control form-control-solid"
                          rows="3" required><?= esc($pegawai['alamat']) ?></textarea>
            </div>

        </div>
    </div>

    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-sm">
            Update
        </button>
    </div>
</div>

</form>

<?= $this->endSection() ?>
