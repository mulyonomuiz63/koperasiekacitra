<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Edit Galeri
            </h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('galeri') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('galeri/update/'.$galeri['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-5">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="title" value="<?= esc($galeri['title']) ?>" required>
            </div>
            <div class="mb-5">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description_editor" name="description"
                        placeholder="Masukkan deskripsi"><?= esc($galeri['description']) ?></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label required">Tempat Penampilan</label>
                <select name="jenis_galeri"
                        class="form-select form-select-solid"
                        required>
                    <option value="atas"   <?= $galeri['jenis_galeri']=='atas'?'selected':'' ?>>Atas</option>
                    <option value="bawah" <?= $galeri['jenis_galeri']=='bawah'?'selected':'' ?>>Bawah</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="form-label">Gambar</label>
                <input type="file" class="form-control" name="filename">
                <?php if(!empty($galeri['filename'])): ?>
                    <?= img_lazy('uploads/galeri/thumbs/' . $galeri['filename'], $galeri['title'], ['width'  => 150, 'height' => 100, 'style'  => 'width:150px; height:100px; object-fit:cover;','class'  => 'img-thumbnail']) ?>
                <?php endif; ?>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-sm">Update Galeri</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/tinymce/tinymce.min.js') ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: '#description_editor',
        height: 350,
        menubar: false,

        // 🔥 WAJIB
        license_key: 'gpl',

        branding: false,
        promotion: false,

        plugins: [
            'lists', 'link', 'image', 'table', 'code', 'wordcount'
        ],

        toolbar: `
            undo redo |
            bold italic underline |
            alignleft aligncenter alignright alignjustify |
            bullist numlist |
            link image table |
            removeformat code
        `,

        // 🔥 UPLOAD IMAGE HANDLER
        images_upload_url: "<?= base_url('galeri/tinymce/upload') ?>",
        images_upload_credentials: true,

        automatic_uploads: true,
        image_title: true,
        file_picker_types: 'image'
    });
});
</script>
<?= $this->endSection() ?>

