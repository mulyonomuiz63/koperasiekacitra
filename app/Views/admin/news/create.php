<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('news/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Tambah Berita Baru</h3>
        </div>
        <div class="card-body">
            <div class="mb-10">
                <label class="required form-label">Judul Berita</label>
                <input type="text" name="title" class="form-control form-control-solid" placeholder="Masukkan judul berita" required />
            </div>

            <div class="row mb-10">
                <div class="col-md-6">
                    <label class="required form-label">Kategori</label>
                    <select name="category_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kategori" required>
                        <option></option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="required form-label">Penulis</label>
                    <input type="text" name="author" class="form-control form-control-solid" value="Admin" required />
                </div>
            </div>

            <div class="mb-10">
                <label class="form-label">Tag Berita</label>
                <select name="tags[]" id="kt_select_tags" class="form-select form-select-solid" data-placeholder="Pilih atau ketik tag baru..." data-allow-clear="true" multiple="multiple">
                    <?php foreach($tags as $tag): ?>
                        <option value="<?= $tag['id'] ?>"><?= $tag['tag_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="text-muted fs-7 mt-2">Tips: Jika tag tidak ada, ketik lalu tekan <b>Enter</b> untuk menambahkannya.</div>
            </div>

            <div class="mb-10">
                <label class="required form-label">Gambar Utama (Rasio Paten 300x200)</label>
                <input type="file" name="image" class="form-control form-control-solid" accept="image/*" required />
                <div class="text-muted fs-7 mt-2">Format yang diizinkan: *.png, *.jpg, *.jpeg</div>
            </div>

            <div class="mb-10">
                <label class="required form-label">Isi Berita</label>
                <textarea class="form-control" id="content_editor" name="content" placeholder="Masukkan berita disini..."></textarea>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-light me-3">Batal</button>
            <button type="submit" class="btn btn-success">Simpan Berita</button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/tinymce/tinymce.min.js') ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Inisialisasi Select2 untuk Tags
    // Kita hancurkan dulu inisialisasi bawaan metronic jika ada
    if ($('#kt_select_tags').hasClass("select2-hidden-accessible")) {
        $('#kt_select_tags').select2("destroy");
    }

    $('#kt_select_tags').select2({
        tags: true, // Mengaktifkan fitur tambah tag baru
        tokenSeparators: [','], 
        placeholder: "Pilih atau ketik tag baru...",
        allowClear: true,
        width: '100%',
        createTag: function (params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            return {
                id: term,
                text: term,
                newTag: true
            }
        }
    });
    tinymce.init({
        selector: '#content_editor',
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

