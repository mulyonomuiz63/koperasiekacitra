<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<div class="card card-flush">
    <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Edit Slider
            </h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('slider') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('slider/update/'.$slider['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-5">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="title" value="<?= esc($slider['title']) ?>" required>
            </div>
            <div class="mb-5">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description_editor" name="description"
                        placeholder="Masukkan deskripsi"><?= esc($slider['description']) ?></textarea>
            </div>

            <input type="hidden" class="form-control" name="jenis_slider" value="<?= esc($slider['jenis_slider']) ?>">

            <div class="mb-5">
                <label class="form-label">Gambar</label>
                <input type="file" class="form-control" name="filename">
                <?php if(!empty($slider['filename'])): ?>
                    <?= img_lazy('uploads/slider/thumbs/' . $slider['filename'], '-', ['width'  => 150, 'height' => 100, 'style' => 'width:150px;height:100px;object-fit:cover;']) ?>
                <?php endif; ?>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
        images_upload_url: "<?= base_url('slider/tinymce/upload') ?>",
        images_upload_credentials: true,

        automatic_uploads: true,
        image_title: true,
        file_picker_types: 'image'
    });
});
</script>
<?= $this->endSection() ?>

