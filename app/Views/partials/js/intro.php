<script>
    $(document).ready(function() {
        // Logika: Hanya jalankan jika user baru daftar/login pertama kali
        // Anda bisa menggunakan localStorage atau pengecekan session dari PHP
        // if (!localStorage.getItem('tour_completed')) {

        const tour = introJs();


        const steps = [{
                title: 'Selamat Datang!',
                intro: 'Mari kami tunjukkan beberapa fitur baru di aplikasi ini.',
                tooltipClass: 'first-step-custom'
            },
            {
                element: document.querySelector('[data-step="1"]'),
                intro: `
			<div class="d-flex flex-column align-items-start">
				<span class="fs-6 fw-bold text-gray-800 mb-3">Panduan Pengelolaan Akun:</span>
				<div class="d-flex align-items-center mb-2">
					<span class="badge badge-circle badge-light-primary me-2">1</span>
					<span class="text-gray-600">Lengkapi data profil sesuai KTP.</span>
				</div>
				<div class="d-flex align-items-center mb-2">
					<span class="badge badge-circle badge-light-primary me-2">2</span>
					<span class="text-gray-600">Upload dokumen pendukung di tab berkas.</span>
				</div>
				<div class="d-flex align-items-center">
					<span class="badge badge-circle badge-light-primary me-2">3</span>
					<span class="text-gray-600">Klik simpan untuk memperbarui data.</span>
				</div>
			</div>
		`
            },
            {
                element: document.querySelector('[data-step="2"]'),
                title: 'Informasi Profil',
                intro: `
			<div class="text-start">
				<p class="mb-2">Di menu ini Anda dapat mengelola hal-hal berikut:</p>
				<ol class="ps-5">
					<li class="mb-1"><b>Informasi Pribadi:</b> Mengubah foto profil dan data diri.</li>
					<li class="mb-1"><b>Keamanan:</b> Mengganti password dan verifikasi dua langkah.</li>
					<li class="mb-1"><b>Pengaturan:</b> Menyesuaikan notifikasi email.</li>
				</ol>
			</div>
		`
            }
        ];

        tour.setOptions({
            steps: steps,
            showProgress: false,
            showBullets: false,
            showStepNumbers: false,
            exitOnOverlayClick: false,
            nextLabel: 'Lanjutkan',
            prevLabel: 'Kembali',
            doneLabel: 'Selesai',
            hidePrev: true
        });

        // Perbaikan logika penomoran langkah
        tour.onchange(function(targetElement) {
            const currentStep = tour._currentStep + 1;
            const totalSteps = steps.length;

            // Cari elemen judul di dalam tooltip Intro.js
            const titleLayer = document.querySelector('.introjs-tooltip-title');
            if (titleLayer) {
                titleLayer.innerHTML = `Langkah ${currentStep} dari ${totalSteps}`;
            }
        });

        tour.start();

        // Tandai tour sudah selesai agar tidak muncul lagi di login berikutnya
        // tour.oncomplete(function() {
        // 	localStorage.setItem('tour_completed', 'true');
        // });

        // tour.onexit(function() {
        // 	localStorage.setItem('tour_completed', 'true');
        // });
        // }
    });
</script>