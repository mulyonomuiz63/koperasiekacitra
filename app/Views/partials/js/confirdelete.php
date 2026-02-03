<script>
    let deleteModal;
    let lastFocusedButton = null;

    $(document).on('click', '.btn-delete', function() {

        lastFocusedButton = this;

        $('#deleteModalTitle').html($(this).data('title'));
        $('#deleteModalMessage').html($(this).data('message'));
        $('#btn-confirm-delete').attr('href', $(this).data('url'));

        const modalEl = document.getElementById('kt_modal_confirm_delete');

        deleteModal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: true,
            focus: false // ⬅️ PENTING
        });

        deleteModal.show();
    });

    // ⬅️ KEMBALIKAN FOCUS SEBELUM MODAL HILANG
    document.getElementById('kt_modal_confirm_delete')
        .addEventListener('hide.bs.modal', function() {
            if (lastFocusedButton) {
                lastFocusedButton.focus();
            }
        });
</script>