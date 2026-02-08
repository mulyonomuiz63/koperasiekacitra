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

                <div class="col-md-6">
                    <label class="required form-label">User</label>
                    <select name="user_id" class="form-select form-select-solid" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u['id'] ?>" <?= old('user_id') == $u['id'] ? 'selected' : '' ?>>
                                <?= $u['username'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control form-control-solid"
                        value="<?= old('nip') ?? (date('Ymd') . rand(1000, 9999)) ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">NIK</label>
                    <input type="text"
                        name="nik"
                        class="form-control form-control-solid"
                        value="<?= old('nik') ?>"
                        minlength="16"
                        maxlength="16"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                        placeholder="Masukkan 16 digit NIK"
                        required>
                    <div class="text-muted fs-7">NIK harus tepat 16 digit angka.</div>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control form-control-solid" value="<?= old('nama') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select form-select-solid" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Tanggal Lahir</label>
                    <input type="text" name="tanggal_lahir" class="form-control form-control-solid datepicker-indo" value="<?= old('tanggal_lahir') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">No HP</label>
                    <input type="text"
                        name="no_hp"
                        class="form-control form-control-solid"
                        value="<?= old('no_hp') ?>"
                        minlength="10"
                        maxlength="15"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                        placeholder="Contoh: 081234567890"
                        required>
                    <div class="text-muted fs-7">Minimal 10 digit, maksimal 15 digit.</div>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Perusahaan</label>
                    <select name="perusahaan_id" class="form-select form-select-solid" required>
                        <option value="">-- Pilih Perusahaan --</option>
                        <?php foreach ($perusahaan as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= old('perusahaan_id') == $p['id'] ? 'selected' : '' ?>><?= $p['nama_perusahaan'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Jabatan</label>
                    <select name="jabatan_id" class="form-select form-select-solid" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan as $j): ?>
                            <option value="<?= $j['id'] ?>" <?= old('jabatan_id') == $j['id'] ? 'selected' : '' ?>><?= $j['nama_jabatan'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Tanggal Daftar Anggota</label>
                    <input type="text" name="tanggal_masuk" class="form-control form-control-solid datepicker-indo" value="<?= old('tanggal_masuk') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Status</label>
                    <select name="status" class="form-select form-select-solid" required>
                        <option value="A" <?= old('status') == 'A' ? 'selected' : '' ?>>Aktif</option>
                        <option value="T" <?= old('status') == 'T' ? 'selected' : '' ?>>Nonaktif</option>
                        <option value="R" <?= old('status') == 'R' ? 'selected' : '' ?>>Resign</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label required">Status Iuran</label>
                    <select name="status_iuran" class="form-select form-select-solid" required>
                        <option value="A" <?= old('status_iuran') == 'A' ? 'selected' : '' ?>>Aktif</option>
                        <option value="T" <?= old('status_iuran') == 'T' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="required form-label">Angkatan <span style="opacity: 0.6; font-size: 0.9em;">(Isi 0 untuk yang tidak memiliki angkatan)</span></label>
                    <input type="number" name="angkatan" class="form-control form-control-solid" value="<?= old('angkatan', '0') ?>" required>
                </div>

                <div class="col-md-12"> <label class="required form-label">Alamat</label>
                    <textarea name="alamat" class="form-control form-control-solid" rows="3" required><?php echo old('alamat'); ?></textarea>
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