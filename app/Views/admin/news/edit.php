<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('news/update/' . $news['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Edit Berita: <?= $news['title'] ?></h3>
        </div>
        <div class="card-body">
            <div class="mb-10">
                <label class="required form-label">Judul Berita</label>
                <input type="text" name="title" class="form-control form-control-solid" value="<?= $news['title'] ?>" required />
            </div>

            <div class="mb-10">
                <label class="form-label">Keyword (Opsional)</label>
                <input type="text" name="keyword" class="form-control form-control-solid" value="<?= $news['keyword'] ?>" placeholder="contoh: brita, koperasi" />
            </div>

            <div class="row mb-10">
                <div class="col-md-6">
                    <label class="required form-label">Kategori</label>
                    <select name="category_id" class="form-select form-select-solid" data-control="select2" required>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $news['category_id']) ? 'selected' : '' ?>>
                                <?= $cat['category_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="required form-label">Penulis</label>
                    <input type="text" name="author" class="form-control form-control-solid" value="<?= $news['author'] ?>" required />
                </div>
            </div>

            <div class="mb-10">
                <label class="form-label">Tag Berita</label>
                <select name="tags[]" id="kt_select_tags" class="form-select form-select-solid" multiple="multiple">
                    <?php 
                    // Ambil daftar ID tag yang sudah terpilih untuk berita ini
                    $selected_tag_ids = array_column($current_tags, 'tag_id');
                    foreach($tags as $tag): 
                    ?>
                        <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $selected_tag_ids) ? 'selected' : '' ?>>
                            <?= $tag['tag_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-10">
                <label class="form-label d-block">Gambar Saat Ini</label>
                <?= img_lazy('uploads/news/' . $news['image'], '-', ['class'  => 'rounded mb-3 w-150px border']) ?>
                <br>
                <label class="form-label">Ganti Gambar (Kosongkan jika tidak ingin mengubah)</label>
                <input type="file" name="image" class="form-control form-control-solid" accept="image/*" />
            </div>

            <div class="mb-10">
                <label class="required form-label">Isi Berita</label>
                <textarea class="form-control" id="content_editor" name="content"><?= $news['content'] ?></textarea>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <a href="<?= base_url('news') ?>" class="btn btn-light me-3">Batal</a>
            <button type="submit" class="btn btn-primary">Update Berita</button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/tinymce/tinymce.min.js') ?>"></script>
<script>
$(document).ready(function() {
    // Re-inisialisasi Select2 dengan Tags: true
    if ($('#kt_select_tags').hasClass("select2-hidden-accessible")) {
        $('#kt_select_tags').select2("destroy");
    }
    $('#kt_select_tags').select2({
        tags: true,
        tokenSeparators: [','],
        width: '100%'
    });

    tinymce.init({
        selector: '#content_editor',
        height: 350,
        license_key: 'gpl',
        plugins: ['lists', 'link', 'image', 'table', 'code', 'wordcount'],
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image code',
        setup: function (editor) {
            editor.on('change', function () { editor.save(); });
        }
    });
});
</script>
<?= $this->endSection() ?>