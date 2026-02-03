<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php
	echo render_meta();
	?>
	<link rel="shortcut icon" href="<?= base_url('uploads/app-icon/' . setting('app_icon')) ?>" />
	<meta name="csrf-token-name" content="<?= csrf_token() ?>">
	<meta name="csrf-token-hash" content="<?= csrf_hash() ?>">


	<!--begin::Fonts(mandatory for all pages)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Vendor Stylesheets(used for this page only)-->
	<link href="<?= base_url('/') ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('/') ?>assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="<?= base_url('/') ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('/') ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
	<!--end::Global Stylesheets Bundle-->
	<?= $this->include('partials/css/intro') ?>
	<?= $this->renderSection('styles') ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="light-header" data-kt-app-header-fixed="true" data-kt-app-toolbar-enabled="true" data-kt-app-toolbar-fixed="true" class="app-default">
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
	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<!--begin::Header-->
			<?= $this->include('partials/headerAnggota') ?>
			<!--end::Header-->
			<!--begin::Wrapper-->
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<!--begin::Main-->
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<!--begin::Content wrapper-->
					<div class="d-flex flex-column flex-column-fluid">

						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<div id="kt_app_content_container" class="app-container container-xxl">
								<?= $this->renderSection('content') ?>
							</div>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Content wrapper-->
					<!--begin::Footer-->
					<?= $this->include('partials/footer') ?>
					<!--end::Footer-->
				</div>
				<!--end:::Main-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::App-->
	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
	<script src="<?= base_url('/') ?>assets/plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url('/') ?>assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Vendors Javascript(used for this page only)-->
	<script src="<?= base_url('/') ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<script src="<?= base_url('/') ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Vendors Javascript-->
	<!--begin::Custom Javascript(used for this page only)-->
	<script src="<?= base_url('/') ?>assets/js/widgets.bundle.js"></script>
	<script src="<?= base_url('/') ?>assets/js/custom/widgets.js"></script>
	<script src="<?= base_url('/') ?>assets/js/custom/apps/chat/chat.js"></script>
	<script src="<?= base_url('/') ?>assets/js/custom/utilities/modals/upgrade-plan.js"></script>
	<script src="<?= base_url('/') ?>assets/js/custom/utilities/modals/create-app.js"></script>
	<script src="<?= base_url('/') ?>assets/js/custom/utilities/modals/users-search.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			setTimeout(() => {
				document.querySelectorAll('.alert').forEach(alert => {
					bootstrap.Alert.getOrCreateInstance(alert).close();
				});
			}, 4000);
		});
	</script>
	<?= $this->include('partials/alert') ?>
	<?= $this->include('partials/js/notification') ?>
	<?= $this->include('partials/js/lazyimage') ?>
	<?= $this->include('partials/js/tanggal') ?>
	<?= $this->renderSection('scripts') ?>
</body>
<!--end::Body-->

</html>