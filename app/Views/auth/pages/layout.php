<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="csrf-name" content="<?= csrf_token() ?>">
	<meta name="csrf-hash" content="<?= csrf_hash() ?>">
	<?php
	echo render_meta();
	?>
	<link rel="shortcut icon" href="<?= base_url('uploads/app-icon/' . setting('app_icon')) ?>" />
	<!--begin::Fonts(mandatory for all pages)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="<?= base_url('/') ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('/') ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<style>
		/* Animasi mengapung untuk ilustrasi */
		.anim-up-down {
			animation: upDown 4s ease-in-out infinite;
		}

		@keyframes upDown {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-20px);
			}
		}

		.hover-elevate-up:hover {
			transform: translateY(-2px);
			transition: 0.3s ease;
		}
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
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
		<?= $this->include('partials/landings/header') ?>
		<!--begin::Authentication - Sign-up -->
		<div class="d-flex flex-column flex-lg-row flex-column-fluid">
			<div class="d-flex flex-lg-row-fluid">
				<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
					<?= img_lazy('assets/media/auth/agency.png', '-', ['class' => 'theme-light-show mx-auto mw-100 w-150px w-lg-350px mb-10 mb-lg-20 anim-up-down']) ?>
					<?= img_lazy('assets/media/auth/agency-dark.png', '-', ['class' => 'theme-dark-show mx-auto mw-100 w-150px w-lg-350px mb-10 mb-lg-20 anim-up-down']) ?>

					<h1 class="text-gray-800 fs-2qx fw-bolder text-center mb-7 px-10">
						Cepat, Efisien, dan <span class="text-primary">Produktif</span>
					</h1>

					<div class="text-gray-500 fs-base text-center fw-semibold px-10">
						Kelola koperasi Anda dengan sistem yang terintegrasi <br class="d-none d-lg-block"> dan mudah digunakan.
					</div>
				</div>
			</div>
			<?= $this->renderSection('content') ?>
		</div>
		<!--end::Authentication - Sign-up-->
		<?= $this->include('partials/landings/footer') ?>
	</div>
	<!--end::Root-->
	<!--begin::Javascript-->
	<script>
		var hostUrl = "<?= base_url('/') ?>assets/";
	</script>
	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="<?= base_url('/') ?>assets/plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url('/') ?>assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--end::Javascript-->
	<?php if ($siteKey): ?>
		<script src="https://www.google.com/recaptcha/api.js?render=<?= $siteKey ?>"></script>
	<?php endif; ?>
	<?= $this->renderSection('scripts') ?>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			let lazyImages = document.querySelectorAll("img.lazy");

			if ("IntersectionObserver" in window) {
				// ✅ Browser support IntersectionObserver
				let observer = new IntersectionObserver((entries, obs) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							let img = entry.target;
							img.src = img.dataset.src;
							img.removeAttribute("data-src");
							img.classList.remove("lazy");
							obs.unobserve(img);
						}
					});
				});

				lazyImages.forEach(img => observer.observe(img));

			} else {
				// ⚠️ Fallback kalau browser tidak support
				lazyImages.forEach(img => {
					img.src = img.dataset.src;
					img.removeAttribute("data-src");
					img.setAttribute("loading", "lazy");
					img.classList.remove("lazy");
				});
			}
		});
	</script>
</body>
<!--end::Body-->

</html>