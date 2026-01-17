<!-- BEGIN: Global Delete Modal -->
<div class="modal fade" id="kt_modal_confirm_delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title" id="deleteModalTitle">Konfirmasi Hapus</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex align-items-center">
                    <i class="ki-duotone ki-warning fs-2hx text-warning me-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span id="deleteModalMessage">
                        Yakin ingin menghapus data ini?
                    </span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" tabindex="-1" aria-hidden="true">
                    Batal
                </button>
                <a href="#" id="btn-confirm-delete" class="btn btn-danger">
                    Ya, Hapus
                </a>
            </div>

        </div>
    </div>
</div>
<!-- END: Global Delete Modal -->
