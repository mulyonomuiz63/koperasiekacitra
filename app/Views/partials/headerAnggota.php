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

    // Logika mengambil inisial (2 huruf depan jika ada 2 kata)
    $words = explode(" ", trim($nama));
    $initials = (count($words) >= 2)
        ? substr($words[0], 0, 1) . substr($words[1], 0, 1)
        : substr($words[0], 0, 1);
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
                        <span class="menu-link">
                            <span class="menu-title">Dashboards</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-450px" style="">
                            <!--begin:Dashboards menu-->
                            <div class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible" data-kt-menu-dismiss="true">
                                <!--begin:Row-->
                                <div class="row">
                                    <!--begin:Col-->
                                    <div class="col-lg-12 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6">
                                        <!--begin:Row-->
                                        <div class="row">
                                            <!--begin:Col-->
                                            <?php render_menu_header($menus); ?>
                                            <!--end:Col-->
                                        </div>
                                        <!--end:Row-->
                                        <div class="separator separator-dashed my-5"></div>
                                        <!--begin:Landing-->
                                        <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-3 bg-white bg-opacity-40 p-4 rounded-3 border border-dashed border-gray-300">
                                            <div class="d-flex align-items-center me-3">
                                                <div class="symbol symbol-40px me-4">
                                                    <div class="symbol-label bg-light-info">
                                                        <i class="ki-outline ki-notification-status fs-2 text-info"></i>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <span class="fs-6 fw-bold text-gray-800 lh-1 mb-1">Blog & News</span>
                                                    <span class="fs-8 fw-semibold text-muted text-uppercase ls-1">Informasi Terbaru</span>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <a href="<?= base_url('blog') ?>" class="btn btn-sm btn-primary fw-bold px-5 shadow-sm">
                                                    Kunjungi
                                                </a>
                                            </div>
                                        </div>
                                        <!--end:Landing-->
                                    </div>
                                    <!--end:Col-->
                                </div>
                                <!--end:Row-->
                            </div>
                            <!--end:Dashboards menu-->
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
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle"> <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"> 
                        <div class="symbol symbol-50px me-5">
                            <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                                <?= strtoupper($initials) ?>
                            </div>
                        </div> 
                    </div> <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true"> <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <div class="symbol-label fs-3 fw-bold bg-light-primary text-primary">
                                        <?= strtoupper($initials) ?>
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
<div class="d-lg-none fixed-bottom bg-white border-top shadow-lg p-2"
    style="border-radius: 20px 20px 0 0; z-index: 1000; height: 75px;">

    <div class="d-flex justify-content-around align-items-center h-100">
        <a href="<?= base_url('sw-anggota/histori-iuran') ?>" class="d-flex flex-column align-items-center text-gray-700 text-hover-primary">
            <i class="ki-outline ki-time fs-1 mb-1"></i>
            <span class="fs-8 fw-bold">Histori</span>
        </a>

        <div class="position-relative" style="margin-top: -50px;">
            <a href="<?= base_url('sw-anggota') ?>"
                class="btn btn-icon btn-primary btn-circle w-65px h-65px shadow-lg border border-4 border-white">
                <i class="ki-outline ki-home fs-2x"></i>
            </a>
        </div>

        <a href="<?= base_url('sw-anggota/profil') ?>" class="d-flex flex-column align-items-center text-gray-700 text-hover-primary">
            <i class="ki-outline ki-user fs-1 mb-1"></i>
            <span class="fs-8 fw-bold">Akun</span>
        </a>
    </div>
</div>