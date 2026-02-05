<?php

use App\Models\MenuModel;

$menuModel = new MenuModel();
$menus = $menuModel->getMenuByUser(
    session()->get('user_id'),
    session()->get('role_id')
);
?>

<?php
$user_data = get_pegawai(session()->get('user_id'));
$nama = $user_data['nama_anggota'] ?? 'User';

?>
<div id="kt_app_header" class="app-header mb-2" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false"> <!--begin::Header container-->
    <div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <!--begin::Toolbar-->
        <?= $this->include('partials/toolbar') ?>
        <!--end::Toolbar-->
        <!--begin::Logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
            <a href="<?= base_url('sw-anggota') ?>">
                <?= img_lazy('uploads/app-icon/' . setting('app_icon'), '-', ['class' => 'h-20px h-lg-30px app-sidebar-logo-default theme-light-show']) ?>
                <?= img_lazy('uploads/app-icon/' . setting('app_icon'), '-', ['class' => 'h-20px h-lg-30px app-sidebar-logo-default theme-dark-show']) ?>
            </a>
        </div>
        <!--end::Logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                        <!--begin:Menu link-->
                        <span class="menu-item">
                            <a class="menu-link" href="<?= session()->get('role_key') == 'ADMIN' ? base_url('dashboard') : base_url('sw-anggota') ?>">
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </span>
                    </div>
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-title">Pages</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px" style="">
                            <?php render_menu_classic($menus, null); ?>
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::User menu-->
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
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle"> <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <div class="symbol symbol-50px me-5">
                            <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                                <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                    <?= img_lazy(get_user_avatar(session()->get('user_id')), 'Profile', ['class'  => 'img-fluid rounded shadow-sm']) ?>
                                </div>
                            </div>
                        </div>
                    </div> <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true"> <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                                        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <?= img_lazy(get_user_avatar(session()->get('user_id')), 'Profile', ['class'  => 'img-fluid rounded shadow-sm']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        <?= $nama ?>
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">
                                            <?= $user_data['status'] ?>
                                        </span>
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                        <?= session()->get('email') ?>
                                    </a>
                                </div>
                            </div>
                        </div> <!--end::Menu item--> <!--begin::Menu separator-->
                        <div class="separator my-2"></div> <!--end::Menu separator--> <!--begin::Menu item-->
                        <div class="menu-item px-5"> <a href="<?= base_url('sw-anggota/profil') ?>" class="menu-link px-5">Profil Saya</a> </div> <!--end::Menu item--> <!--begin::Menu item-->
                        <div class="menu-item px-5"> <a href="<?= base_url('/logout') ?>" class="menu-link px-5">Keluar</a> </div> <!--end::Menu item-->
                    </div> <!--end::User account menu--> <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-element-4 fs-1"></i>
                    </div>
                </div>
                <!--end::Header menu toggle-->
                <!--begin::Aside toggle-->
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
</div>

<!-- tampilan untuk mobail -->
<div class="d-lg-none fixed-bottom bg-white border-top shadow-sm p-2"
    style="border-radius: 20px 20px 0 0; z-index: 1000; height: 75px;">

    <div class="d-flex justify-content-around align-items-center h-100">

        <a href="<?= base_url('sw-anggota') ?>"
            class="d-flex flex-column align-items-center <?= (current_url() == base_url('sw-anggota')) ? 'text-primary' : 'text-gray-700' ?> text-hover-primary">
            <i class="ki-outline ki-home fs-1 mb-1"></i>
            <span class="fs-8 fw-bold">Beranda</span>
        </a>

        <a href="<?= base_url('sw-anggota/iuran') ?>"
            class="d-flex flex-column align-items-center <?= (current_url() == base_url('sw-anggota/iuran')) ? 'text-primary' : 'text-gray-700' ?> text-hover-primary">
            <i class="ki-outline ki-wallet fs-1 mb-1"></i>
            <span class="fs-8 fw-bold">Iuran</span>
        </a>

        <a href="<?= base_url('sw-anggota/histori-iuran') ?>"
            class="d-flex flex-column align-items-center <?= (current_url() == base_url('sw-anggota/histori-iuran')) ? 'text-primary' : 'text-gray-700' ?> text-hover-primary">
            <i class="ki-outline ki-time fs-1 mb-1"></i>
            <span class="fs-8 fw-bold">Histori</span>
        </a>

        <a href="<?= base_url('sw-anggota/profil') ?>"
            class="d-flex flex-column align-items-center <?= (current_url() == base_url('sw-anggota/profil')) ? 'text-primary' : 'text-gray-700' ?> text-hover-primary">
            <i class="ki-outline ki-user fs-1 mb-1"></i>
            <span class="fs-8 fw-bold">Akun</span>
        </a>

    </div>
</div>