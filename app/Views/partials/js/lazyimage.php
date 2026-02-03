<script>
    (function() {
        const initLazy = (img) => {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        target.src = target.dataset.src;
                        target.removeAttribute("data-src");
                        target.classList.remove("lazy");
                        obs.unobserve(target);
                    }
                });
            });
            observer.observe(img);
        };

        // Fungsi cari gambar lazy
        const findAndObserve = () => {
            document.querySelectorAll("img.lazy").forEach(img => {
                // Pastikan tidak diobservasi dua kali
                if (!img.dataset.observed) {
                    img.dataset.observed = "true";
                    initLazy(img);
                }
            });
        };

        // 1. Jalankan saat DOM Ready
        document.addEventListener("DOMContentLoaded", findAndObserve);

        // 2. Gunakan MutationObserver untuk mendeteksi elemen baru (Universal)
        // Ini otomatis menangani DataTables, Modal, AJAX, dll.
        const mutationObs = new MutationObserver(() => {
            findAndObserve();
        });

        mutationObs.observe(document.body, {
            childList: true,
            subtree: true
        });
    })();
    const namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    // Fungsi simple untuk menggantikan bulanIndo PHP
    const bulanIndoJS = (angka) => namaBulan[parseInt(angka)] || '-';
</script>