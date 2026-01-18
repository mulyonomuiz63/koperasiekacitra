<?= $this->extend('pages/layout') ?>
<?= $this->section('content') ?>

<form method="post" action="<?= base_url('faq/update/'.$faq['id']) ?>">
<?= csrf_field() ?>

<div class="card">
     <div class="card-header align-items-center">
        <div class="card-title">
            <h2 class="fw-bold mb-0">
                Edit FAQ
            </h2>
        </div>
        <div class="card-toolbar">
            <a href="<?= base_url('faq') ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label>Pertanyaan</label>
            <input type="text" name="question"
                   class="form-control"
                   value="<?= esc($faq['question']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Jawaban</label>
            <textarea name="answer"
                      class="form-control"
                      rows="5"><?= esc($faq['answer']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Urutan</label>
            <input type="number" name="sort_order"
                   class="form-control"
                   value="<?= $faq['sort_order'] ?>">
        </div>
    </div>

    <div class="card-footer text-end">
        <button class="btn btn-primary btn-sm">Update</button>
    </div>
</div>
</form>

<?= $this->endSection() ?>
