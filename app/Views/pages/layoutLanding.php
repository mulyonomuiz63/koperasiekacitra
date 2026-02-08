<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php
	if (isset($news_detail)) {
		// Halaman Detail Berita
		echo render_meta($news_detail['title'], $news_detail['content'], base_url('uploads/news/' . $news_detail['image']), $news_detail['keyword']);
		echo render_schema_news($news_detail);
	} elseif (isset($tag_name)) {
		// Halaman Filter Tag
		$title = "Topik " . $tag_name;
		$desc  = "Kumpulan News dan blog terbaru dengan topik " . $tag_name . " di situs kami.";
		echo render_meta($title, $desc);
	} elseif (isset($category_name)) {
		// Halaman Kategori
		echo render_meta("Kategori " . $category_name, "Jelajahi berita dalam kategori " . $category_name);
	} else {
		// Home
		echo render_meta();
	}
	?>
	<link rel="shortcut icon" href="<?= base_url('uploads/app-icon/' .setting('app_icon')) ?>" />
	<!--begin::Fonts(mandatory for all pages)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="<?= base_url('/') ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('/') ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
	<?= $this->renderSection('styles') ?>

	<?php if (!empty(setting('google_site_verification'))): ?>
        <?= setting('google_site_verification') ?>
    <?php endif; ?>

    <?php if (!empty(setting('google_analytics_id'))): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= setting('google_analytics_id') ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?= setting('google_analytics_id') ?>');
        </script>
    <?php endif; ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-body position-relative app-blank">
	<!--begin::Theme mode setup on page load-->
	<script>
		var defaultThemeMode = "light";
		var themeMode;
		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
			} else {
				if (localStorage.getItem("data-bs-theme") !== null) {
					themeMode = localStorage.getItem("data-bs-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}
			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-bs-theme", themeMode);
		}
	</script>
	<!--end::Theme mode setup on page load-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Header Section-->
		<div class="mb-0" id="home">
			<div class="landing-light-bg">
				<?= $this->include('partials/landings/header') ?>
				<?= $this->renderSection('content') ?>
			</div>
			<!--end::Header Section-->
			<!--begin::Footer Section-->
			<?= $this->include('partials/landings/footer') ?>
			<!--end::Footer Section-->
			<!--begin::Scrolltop-->
			<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
				<i class="ki-duotone ki-arrow-up">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</div>
			<!--end::Scrolltop-->
		</div>
		<!--end::Root-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		<script>
			var hostUrl = "<?= base_url('/') ?>assets/";
		</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="<?= base_url('/') ?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?= base_url('/') ?>assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="<?= base_url('/') ?>assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
		<script src="<?= base_url('/') ?>assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="<?= base_url('/') ?>assets/js/custom/landing.js"></script>
		<script src="<?= base_url('/') ?>assets/js/custom/pages/pricing/general.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
		<?= $this->renderSection('script') ?>
		<script>
			// Pastikan library AOS sudah dipanggil di header/footer
			document.addEventListener('DOMContentLoaded', function() {
				AOS.init({
					once: true, // Animasi hanya berjalan sekali saat scroll ke bawah
				});
			});
		</script>

		<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
		<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
		<script>
			var typed = new Typed('#kt_typing_effect', {
				strings: [
					'Bersama, Kita Mandiri.',
					'Mari Berkarya.',
					'Terus Bertumbuh.',
					'Semakin Berdaya.'
				],
				typeSpeed: 50, // Kecepatan mengetik
				backSpeed: 30, // Kecepatan menghapus
				backDelay: 2000, // Jeda sebelum menghapus kembali
				loop: true // Berulang terus menerus
			});
		</script>
		<script>
			AOS.init({
				duration: 1000,
				easing: 'ease-in-out',
				once: false, // agar bisa fade-out saat scroll balik
				mirror: true, // animate out ketika keluar viewport
				offset: 120
			});
		</script>
		<?= $this->include('partials/alert') ?>
		<?= $this->include('partials/js/lazyimage') ?>
</body>
<!--end::Body-->

</html>