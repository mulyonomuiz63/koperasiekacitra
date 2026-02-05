<?php
$user_data = get_pegawai(session()->get('user_id'));
$nama = $user_data['nama_anggota'] ?? 'User';

// Logika mengambil inisial (2 huruf depan jika ada 2 kata)
$words = explode(" ", trim($nama));
$initials = (count($words) >= 2)
    ? substr($words[0], 0, 1) . substr($words[1], 0, 1)
    : substr($words[0], 0, 1);
?>
<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false"> <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container"> <!--begin::Sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle"> <i class="ki-outline ki-abstract-14 fs-2 fs-md-1"></i> </div>
        </div> <!--end::Sidebar mobile toggle--> <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="<?= base_url('/') ?>" class="d-lg-none">
                <?= img_lazy('uploads/app-icon/' . setting('app_icon'), setting('app_name'), ['class'  => 'h-30px']) ?>
            </a>
        </div> <!--end::Mobile logo--> <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper"> <!--begin::Menu wrapper-->
            <!--begin::Toolbar-->
            <?= $this->include('partials/toolbar') ?>
            <!--end::Toolbar-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0 d-flex align-items-stretch justify-content-end flex-lg-grow-1">
                <div class="d-flex align-items-center ms-1 ms-lg-3">
                    <div class="btn btn-icon btn-custom btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative"
                        data-kt-menu-trigger="click"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">

                        <i class="ki-outline ki-notification-on fs-1"></i>

                        <span id="main-notif-badge"
                            class="position-absolute top-0 start-100 translate-middle badge badge-circle badge-danger w-15px h-15px ms-n3 mt-3 fs-10"
                            style="display: none;">0</span>
                    </div>

                    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('<?= base_url('assets/media/misc/menu-header-bg.jpg') ?>')">
                            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                                Notifikasi <span class="fs-8 opacity-75 ms-3">Pemberitahuan Terbaru</span>
                            </h3>
                        </div>

                        <div class="tab-content">
                            <div class="scroll-y mh-325px my-5 px-8" id="notification-list">
                                <div class="text-center py-10" id="notif-loader">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="text-muted fs-7 mt-2">Mengecek pemberitahuan...</div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 text-center border-top">
                            <button type="button" id="btn-read-all" class="btn btn-color-gray-600 btn-active-color-primary">
                                Tandai Semua Telah Dibaca
                                <i class="ki-outline ki-arrow-right fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle"> <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-label fs-3 fw-bold bg-light-primary text-primary" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                            <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <?= img_lazy(get_user_avatar(session()->get('user_id')), 'Profile', ['class'  => 'img-fluid rounded shadow-sm']) ?>
                            </div>
                        </div>
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true"> <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3"> <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5 bg-light-primary text-primary">
                                    <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                                        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <?= img_lazy(get_user_avatar(session()->get('user_id')), 'Profile', ['class'  => 'img-fluid rounded shadow-sm']) ?>
                                        </div>
                                    </div>
                                </div> <!--end::Avatar--> <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5"><?= get_pegawai(session()->get('user_id'))['nama_anggota'] ?><span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"><?= get_pegawai(session()->get('user_id'))['status'] ?></span></div> <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?= session()->get('email') ?></a>
                                </div> <!--end::Username-->
                            </div>
                        </div> <!--end::Menu item--> <!--begin::Menu separator-->
                        <div class="separator my-2"></div> <!--end::Menu separator--> <!--begin::Menu item-->
                        <div class="menu-item px-5"> <a href="<?= base_url('profil') ?>" class="menu-link px-5">Profile Saya</a> </div> <!--end::Menu item--> <!--begin::Menu item-->
                        <div class="menu-item px-5"> <a href="<?= base_url('/logout') ?>" class="menu-link px-5">Keluar</a> </div> <!--end::Menu item-->
                    </div> <!--end::User account menu--> <!--end::Menu wrapper-->
                </div> <!--end::User menu--> <!--begin::Header menu toggle-->
            </div> <!--end::Navbar-->
        </div> <!--end::Header wrapper-->
    </div> <!--end::Header container-->
</div>