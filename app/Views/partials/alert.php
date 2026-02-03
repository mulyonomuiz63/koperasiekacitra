<?php
$alerts = [
    'success' => 'success',
    'error'   => 'danger',
    'warning' => 'warning',
    'info'    => 'info',
];
?>
<script>
    $(document).ready(function() {
        // Mapping keys from CodeIgniter Flashdata to SweetAlert2 Icons
        const alerts = {
            'success': 'success',
            'error': 'error',
            'warning': 'warning',
            'info': 'info'
        };

        <?php foreach (['success', 'error', 'warning', 'info'] as $key): ?>
            <?php if (session()->getFlashdata($key)): ?>
                Swal.fire({
                    icon: alerts['<?= $key ?>'],
                    title: '<?= ucfirst($key) ?>',
                    text: '<?= session()->getFlashdata($key) ?>',
                    showConfirmButton: false,
                    timer: 2000, // Menghilang otomatis dalam 3 detik
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-4',
                        title: 'text-dark fw-bold'
                    }
                });
            <?php endif; ?>
        <?php endforeach; ?>
    });
</script>