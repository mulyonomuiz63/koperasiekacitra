<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('pegawai/store') ?>" method="post">
<?= csrf_field() ?>

<div class="card card-flush">
    <div class="card-header">
        <div class="card-title">
            <h2 class="fw-bold">Tambah Pegawai</h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('pegawai') ?>" class="btn btn-light">Kembali</a>
        </div>
    </div>

    <div class="card-body">

        <div class="row g-5">

            <!-- USER -->
            <div class="col-md-6">
                <label class="required form-label">User</label>
                <select name="user_id" class="form-select form-select-solid" required>
                    <option value="">-- Pilih User --</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>">
                            <?= $u['username'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- NIP -->
            <div class="col-md-6">
                <label class="form-label">NIP</label>
                <input type="number" name="nip" class="form-control form-control-solid">
            </div>

            <!-- NAMA -->
            <div class="col-md-6">
                <label class="required form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control form-control-solid" required>
            </div>

            <!-- JENIS KELAMIN -->
            <div class="col-md-6">
                <label class="required form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select form-select-solid" required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <!-- TANGGAL LAHIR -->
            <div class="col-md-6">
                <label class="required form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control form-control-solid" required>
            </div>

            <!-- NO HP -->
            <div class="col-md-6">
                <label class="required form-label">No HP</label>
                <input type="number" name="no_hp" class="form-control form-control-solid" required>
            </div>

            <!-- PERUSAHAAN -->
            <div class="col-md-6">
                <label class="required form-label">Perusahaan</label>
                <select name="perusahaan_id" class="form-select form-select-solid" required>
                    <option value="">-- Pilih Perusahaan --</option>
                    <?php foreach ($perusahaan as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nama_perusahaan'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- JABATAN -->
            <div class="col-md-6">
                <label class="required form-label">Jabatan</label>
                <select name="jabatan_id" class="form-select form-select-solid" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php foreach ($jabatan as $j): ?>
                        <option value="<?= $j['id'] ?>"><?= $j['nama_jabatan'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- TANGGAL MASUK -->
            <div class="col-md-6">
                <label class="required form-label">Tanggal  Daftar Anggota</label>
                <input type="date" name="tanggal_masuk" class="form-control form-control-solid" required>
            </div>

            <!-- STATUS -->
            <div class="col-md-6">
                <label class="required form-label">Status</label>
                <select name="status" class="form-select form-select-solid" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                    <option value="resign">Resign</option>
                </select>
            </div>

            <!-- ALAMAT -->
            <div class="col-12">
                <label class="required form-label">Alamat</label>
                <textarea name="alamat" class="form-control form-control-solid" rows="3" required></textarea>
            </div>

        </div>
    </div>

    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-sm">
            Simpan
        </button>
    </div>
</div>

</form>

<?= $this->endSection() ?>
