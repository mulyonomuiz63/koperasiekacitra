<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//landing page
$routes->get('/', 'LandingPage\LandingPageController::index');
$routes->group('blog', function ($routes) {
    // Halaman utama list berita & kategori (Akses: domain.com/blog)
    $routes->get('/', 'LandingPage\LandingPageController::categoryTag');
   // Halaman detail
    $routes->get('read/(:any)', 'LandingPage\LandingPageController::detail/$1');
});

$routes->get('/login', 'AuthController::login', ['filter' => 'guest']);
$routes->post('/login', 'AuthController::attemptLogin', ['filter' => 'guest']);

$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::store');
$routes->post('auth/check-email', 'AuthController::checkEmail');
$routes->get('verify-email/(:any)', 'AuthController::verify/$1');

// forgot password
$routes->get('forgot-password', 'AuthController::forgotPasswordForm');
$routes->post('forgot-password', 'AuthController::forgotPassword');

// reset password
$routes->get('reset-password/(:segment)', 'AuthController::resetPasswordForm/$1');
$routes->post('reset-password', 'AuthController::resetPasswordProcess');


$routes->get('unauthorized', 'AuthController::unauthorized');
$routes->get('logout','AuthController::logout');

//untuk notifikasi
$routes->group('notif', function($routes) {
    $routes->get('get-data', 'NotificationController::getNotifications');
    $routes->post('mark-read', 'NotificationController::markAsRead');
    $routes->post('mark-all-read', 'NotificationController::markAllRead');
});


$routes->group('/', ['filter'=>['auth','role:ADMIN']], function($routes){ //untuk admin, ketua, bendahara, sekretaris
    $routes->get('dashboard','Admin\HomeController::index');

    $routes->group('users', function ($routes) {
        $routes->get('/','Admin\UserController::index', ['filter' => 'permission:users,view']);
        $routes->post('datatable','Admin\UserController::datatable', ['filter' => 'permission:users,view']);
        $routes->get('create','Admin\UserController::create', ['filter' => 'permission:users,create']);
        $routes->post('store','Admin\UserController::store');
        $routes->get('edit/(:segment)','Admin\UserController::edit/$1', ['filter' => 'permission:users,update']);
        $routes->post('update/(:segment)','Admin\UserController::update/$1');
        $routes->get('delete/(:segment)','Admin\UserController::delete/$1', ['filter' => 'permission:users,delete']);
        $routes->get('permission/(:segment)','Admin\UserPermissionController::index/$1');
        $routes->post('permission/save','Admin\UserPermissionController::save');
    });

    
    $routes->group('roles', function ($routes) {
        $routes->get('', 'Admin\RoleController::index', ['filter' => 'permission:roles,view']);
        $routes->post('datatable', 'Admin\RoleController::datatable', ['filter' => 'permission:roles,view']);
        $routes->get('create', 'Admin\RoleController::create', ['filter' => 'permission:roles,create']);
        $routes->post('store', 'Admin\RoleController::store');
        $routes->get('edit/(:segment)', 'Admin\RoleController::edit/$1', ['filter' => 'permission:roles,update']);
        $routes->post('update/(:segment)', 'Admin\RoleController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\RoleController::delete/$1', ['filter' => 'permission:roles,delete']);
        $routes->get('permission/(:segment)','Admin\RolePermissionController::index/$1');
        $routes->post('permission/save','Admin\RolePermissionController::save');
    });

    $routes->group('menus', function ($routes) {
        $routes->get('/', 'Admin\MenuController::index',['filter' => 'permission:menus,view']);
        $routes->post('datatable', 'Admin\MenuController::datatable',['filter' => 'permission:menus,view']);
        $routes->get('children/(:segment)', 'Admin\MenuController::children/$1');
        $routes->get('create', 'Admin\MenuController::create',['filter' => 'permission:menus,create']);
        $routes->post('store', 'Admin\MenuController::store');
        $routes->get('edit/(:segment)', 'Admin\MenuController::edit/$1',['filter' => 'permission:menus,update']);
        $routes->post('update/(:segment)', 'Admin\MenuController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\MenuController::delete/$1',['filter' => 'permission:menus,delete']);
    });

    $routes->group('pegawai', function ($routes) {
        $routes->get('/', 'Admin\PegawaiController::index',['filter' => 'permission:pegawai,view']);
        $routes->post('datatable', 'Admin\PegawaiController::datatable',['filter' => 'permission:pegawai,view']);
        $routes->get('create', 'Admin\PegawaiController::create',['filter' => 'permission:pegawai,create']);
        $routes->post('store', 'Admin\PegawaiController::store');
        $routes->get('edit/(:segment)', 'Admin\PegawaiController::edit/$1',['filter' => 'permission:pegawai,update']);
        $routes->post('update/(:segment)', 'Admin\PegawaiController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\PegawaiController::delete/$1',['filter' => 'permission:pegawai,delete']);
    });

    $routes->group('perusahaan', function ($routes) {
        $routes->get('/', 'Admin\PerusahaanController::index',['filter' => 'permission:perusahaan,view']);
        $routes->post('datatable', 'Admin\PerusahaanController::datatable',['filter' => 'permission:perusahaan,view']);
        $routes->get('create', 'Admin\PerusahaanController::create',['filter' => 'permission:perusahaan,create']);
        $routes->post('store', 'Admin\PerusahaanController::store');
        $routes->get('edit/(:segment)', 'Admin\PerusahaanController::edit/$1',['filter' => 'permission:perusahaan,update']);
        $routes->post('update/(:segment)', 'Admin\PerusahaanController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\PerusahaanController::delete/$1',['filter' => 'permission:perusahaan,delete']);
    });

    $routes->group('jabatan', function ($routes) {
        $routes->get('/', 'Admin\JabatanController::index',['filter' => 'permission:jabatan,view']);
        $routes->post('datatable', 'Admin\JabatanController::datatable',['filter' => 'permission:jabatan,view']);
        $routes->get('create', 'Admin\JabatanController::create',['filter' => 'permission:jabatan,create']);
        $routes->post('store', 'Admin\JabatanController::store');
        $routes->get('edit/(:segment)', 'Admin\JabatanController::edit/$1',['filter' => 'permission:jabatan,update']);
        $routes->post('update/(:segment)', 'Admin\JabatanController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\JabatanController::delete/$1',['filter' => 'permission:jabatan,delete']);
    });

    $routes->group('galeri', function ($routes) {
        $routes->get('/', 'Admin\GaleriController::index',['filter' => 'permission:galeri,view']);
        $routes->post('datatable', 'Admin\GaleriController::datatable',['filter' => 'permission:galeri,view']);
        $routes->get('create', 'Admin\GaleriController::create',['filter' => 'permission:galeri,create']);
        $routes->post('store', 'Admin\GaleriController::store');
        $routes->get('edit/(:segment)', 'Admin\GaleriController::edit/$1',['filter' => 'permission:galeri,update']);
        $routes->post('update/(:segment)', 'Admin\GaleriController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\GaleriController::delete/$1',['filter' => 'permission:galeri,delete']);
        $routes->post('tinymce/upload', 'Admin\TinymceController::upload');
    });

    $routes->group('slider', function ($routes) {
        $routes->get('/', 'Admin\SliderController::index',['filter' => 'permission:slider,view']);
        $routes->post('datatable', 'Admin\SliderController::datatable',['filter' => 'permission:slider,view']);
        $routes->get('create', 'Admin\SliderController::create',['filter' => 'permission:slider,create']);
        $routes->post('store', 'Admin\SliderController::store');
        $routes->get('edit/(:segment)', 'Admin\SliderController::edit/$1',['filter' => 'permission:slider,update']);
        $routes->post('update/(:segment)', 'Admin\SliderController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\SliderController::delete/$1',['filter' => 'permission:slider,delete']);
        $routes->post('tinymce/upload', 'Admin\TinymceController::uploadSlider');
    });

    $routes->group('faq', function ($routes) {
        $routes->get('/', 'Admin\FaqController::index',['filter' => 'permission:faq,view']);
        $routes->post('datatable', 'Admin\FaqController::datatable',['filter' => 'permission:faq,view']);
        $routes->get('create', 'Admin\FaqController::create',['filter' => 'permission:faq,create']);
        $routes->post('store', 'Admin\FaqController::store');
        $routes->get('edit/(:segment)', 'Admin\FaqController::edit/$1',['filter' => 'permission:faq,update']);
        $routes->post('update/(:segment)', 'Admin\FaqController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\FaqController::delete/$1',['filter' => 'permission:faq,delete']);
        $routes->post('toggle', 'Admin\FaqController::toggle');
    });

    $routes->group('pembayaran', function ($routes) {
        $routes->get('/', 'Admin\PembayaranController::index',['filter' => 'permission:pembayaran,view']);
        $routes->post('datatable', 'Admin\PembayaranController::datatable',['filter' => 'permission:pembayaran,view']);
        $routes->get('edit/(:segment)', 'Admin\PembayaranController::edit/$1',['filter' => 'permission:pembayaran,update']);
        $routes->post('update/(:segment)', 'Admin\PembayaranController::update/$1');
    });


    $routes->group('iuran-bulanan', function ($routes) {
        $routes->get('/', 'Admin\IuranBulananController::index',['filter' => 'permission:iuran-bulanan,view']);
        $routes->post('datatable', 'Admin\IuranBulananController::datatable',['filter' => 'permission:iuran-bulanan,view']);
        $routes->get('(:segment)', 'Admin\IuranBulananController::detail/$1');
        $routes->post('verifikasi', 'Admin\IuranBulananController::verifikasi');
        $routes->get('download/(:segment)', 'Admin\IuranBulananController::download/$1');

    });

    $routes->group('laporan', function ($routes) {
        $routes->get('/', 'Admin\LaporanController::index',['filter' => 'permission:laporan,view']);
        $routes->post('datatable', 'Admin\LaporanController::datatable',['filter' => 'permission:laporan,view']);
    });



    $routes->group('news', function ($routes) {
        $routes->get('/', 'Admin\NewsController::index',['filter' => 'permission:faq,view']);
        $routes->post('datatable', 'Admin\NewsController::datatable',['filter' => 'permission:faq,view']);
        $routes->get('create', 'Admin\NewsController::create',['filter' => 'permission:faq,create']);
        $routes->post('store', 'Admin\NewsController::store');
        $routes->get('edit/(:segment)', 'Admin\NewsController::edit/$1',['filter' => 'permission:faq,update']);
        $routes->post('update/(:segment)', 'Admin\NewsController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\NewsController::delete/$1',['filter' => 'permission:faq,delete']);
    });

    $routes->group('category', function ($routes) {
        $routes->get('/', 'Admin\CategoryController::index',['filter' => 'permission:faq,view']);
        $routes->post('datatable', 'Admin\CategoryController::datatable',['filter' => 'permission:faq,view']);
        $routes->get('create', 'Admin\CategoryController::create',['filter' => 'permission:faq,create']);
        $routes->post('store', 'Admin\CategoryController::store');
        $routes->get('edit/(:segment)', 'Admin\CategoryController::edit/$1',['filter' => 'permission:faq,update']);
        $routes->post('update/(:segment)', 'Admin\CategoryController::update/$1');
        $routes->get('delete/(:segment)', 'Admin\CategoryController::delete/$1',['filter' => 'permission:faq,delete']);
    });

    $routes->group('profil', function ($routes) {
        $routes->get('/', 'Admin\ProfilController::index');
        $routes->post('update', 'Admin\ProfilController::saveData');
    });

    $routes->group('settings', function ($routes) {
        $routes->get('/', 'Admin\SettingsController::index',['filter' => 'permission:settings,view']);
        $routes->post('update', 'Admin\SettingsController::update',['filter' => 'permission:settings,update']);
    });    
});


$routes->group('sw-anggota', ['filter'=>['auth','role:ANGGOTA,ADMIN', 'anggotaRedirect']], function($routes){ //untuk anggota
    $routes->get('/','Pengguna\HomeController::index');

    $routes->get('activity', 'Pengguna\ActivityController::index');
    $routes->get('lengkapi-data', 'Pengguna\ActivityController::index');
    $routes->post('lengkapi-data', 'Pengguna\ActivityController::saveData');
    $routes->post('pembayaran', 'Pengguna\ActivityController::uploadPembayaran');

    $routes->get('profil', 'Pengguna\ProfilController::index');
    $routes->post('profil/update', 'Pengguna\ProfilController::saveData');
    $routes->get('iuran', 'Pengguna\IuranBulananController::index');
    $routes->post('iuran/datatable', 'Pengguna\IuranBulananController::datatable');

    $routes->post('iuran/bayar-proses', 'Pengguna\PembayaranController::proses');
    $routes->post('pembayaran/upload-bukti', 'Pengguna\PembayaranController::uploadBukti');
    
    $routes->group('histori-iuran', function ($routes) {
        $routes->get('/', 'Pengguna\HistoriController::index');
        $routes->get('(:segment)', 'Pengguna\HistoriController::histori/$1');
        $routes->post('datatable', 'Pengguna\HistoriController::datatable');
        $routes->get('download/(:segment)', 'Pengguna\HistoriController::download/$1');

    });
});


// Test generate iuran bulanan
$routes->get('test-generate-iuran', 'TestIuranController::generate');
$routes->get('test-iuran', 'TestIuranController::generateNoLog');