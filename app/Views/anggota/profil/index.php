<?= $this->extend('pages/layoutAnggota') ?>
<?= $this->section('content') ?>

<div class="card card-flush mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <?php if (empty($user['avatar'])): ?>
                        <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="image" style="width: 100px; height: 100px; object-fit: cover;">
                    <?php else: ?>
                        <div style="
                            width: 100px; 
                            height: 100px; 
                            background-color: #009ef7; 
                            color: #ffffff; 
                            display: flex; 
                            align-items: center; 
                            justify-content: center; 
                            font-size: 35px; 
                            font-weight: bold; 
                            border-radius: 50%;
                            text-transform: uppercase;
                        ">
                            <?php
                            $nama = get_pegawai(session()->get('user_id'))['nama_anggota'];
                            $words = explode(" ", $nama);
                            $initials = "";

                            if (count($words) >= 2) {
                                $initials = substr($words[0], 0, 1) . substr($words[1], 0, 1);
                            } else {
                                $initials = substr($nama, 0, 1);
                            }
                            echo strtoupper($initials);
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $user['nama'] ?></a>
                            <i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                <i class="ki-outline ki-profile-circle fs-4 me-1"></i><?= $user['nama_jabatan'] ?>
                            </span>
                            <span class="d-flex align-items-center text-gray-400 me-5 mb-2">
                                <i class="ki-outline ki-geolocation fs-4 me-1"></i><?= $user['alamat'] ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap flex-stack">
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                            <div class="fs-2 fw-bold">Rp <?= ringkas_uang(500000000) ?></div>
                        </div>
                        <div class="fw-semibold fs-6 text-gray-400">Saldo Iuran</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <div id="view_profil">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold m-0">Detail Profil</h3>
            </div>
            <button class="btn btn-sm btn-primary align-self-center" onclick="toggleEdit(true)">Edit Profile</button>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $user['nama'] ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Perusahaan</label>
                <div class="col-lg-8"><span class="fw-semibold text-gray-800 fs-6"><?= $user['nama_perusahaan'] ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">E-mail</label>
                <div class="col-lg-8 d-flex align-items-center">
                    <span class="fw-bold fs-6 text-gray-800 me-2"><?= $user['email'] ?></span>
                    <span class="badge badge-success">Verified</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
                <div class="col-lg-8"><span class="fw-semibold fs-6 text-gray-800"><?= $user['alamat'] ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Jenis Kelamin</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $user['jenis_kelamin'] === 'L' ? 'Laki-Laki' : 'Perempuan' ?></span></div>
            </div>
        </div>
    </div>

    <div id="form_edit" style="display: none;">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold m-0">Edit Data Profil</h3>
            </div>
            <button class="btn btn-sm btn-light align-self-center" onclick="toggleEdit(false)">Batal</button>
        </div>
        <div class="card-body p-9">
            <form action="<?= base_url('sw-anggota/profil/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama'] ?? $user['nama']) ?>" required>
                        <input type="hidden" name="pegawai_id" value="<?= $user['id'] ?>">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">NIK</label>
                        <input type="number" name="nik" class="form-control" value="<?= old('nik', $user['nik'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" data-control="select2" required>
                            <option value="L" <?= old('jenis_kelamin', $user['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= old('jenis_kelamin', $user['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir', $user['tanggal_lahir'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir', $user['tempat_lahir'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">No HP</label>
                        <input type="number" name="no_hp" class="form-control" value="<?= old('no_hp', $user['no_hp'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-dark">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required><?= old('alamat', $user['alamat'] ?? $user['alamat']) ?></textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <button type="button" class="btn btn-light" onclick="toggleEdit(false)">Batal</button>
                    <button type="submit" class="btn btn-primary px-10 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleEdit(isEdit) {
        const viewSection = document.getElementById('view_profil');
        const formSection = document.getElementById('form_edit');

        if (isEdit) {
            viewSection.style.display = 'none';
            formSection.style.display = 'block';
        } else {
            viewSection.style.display = 'block';
            formSection.style.display = 'none';
        }
    }
</script>

<?= $this->endSection() ?>