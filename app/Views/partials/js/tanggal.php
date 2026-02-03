<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    var KTGlobalComponents = function() {
        // Fungsi untuk inisialisasi Flatpickr
        var initDatepickers = function() {
            // Cari semua elemen dengan class .datepicker-metronic
            $(".datepicker-indo").each(function() {
                $(this).flatpickr({
                    altInput: true,
                    altFormat: "d F Y",
                    dateFormat: "Y-m-d",
                    locale: "id",
                    disableMobile: true,
                    // Menangani posisi popup agar tidak terpotong jika di dalam modal
                    nextArrow: '<i class="ki-outline ki-arrow-right"></i>',
                    prevArrow: '<i class="ki-outline ki-arrow-left"></i>',
                });
            });
        }

        return {
            init: function() {
                initDatepickers();
            }
        };
    }();

    // Jalankan saat dokumen siap
    $(document).ready(function() {
        KTGlobalComponents.init();
    });
</script>