<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/login', 'AuthController::login', ['filter' => 'guest']);
$routes->post('/login', 'AuthController::attemptLogin', ['filter' => 'guest']);


$routes->group('/', ['filter'=>'auth'], function($routes){
    $routes->get('logout','AuthController::logout');
    $routes->get('dashboard','Home::index');
    $routes->get('anggota', 'Admin\AnggotaController::index', ['filter'=>'permission:anggota,view']);
    $routes->post('anggota/create', 'Admin\AnggotaController::create', ['filter'=>'permission:anggota,create']);

    $routes->group('users', function ($routes) {
        $routes->get('/','Admin\UserController::index', ['filter' => 'permission:users,view']);
        $routes->post('datatable','Admin\UserController::datatable', ['filter' => 'permission:users,view']);
        $routes->get('create','Admin\UserController::create', ['filter' => 'permission:users,create']);
        $routes->post('store','Admin\UserController::store');
        $routes->get('edit/(:num)','Admin\UserController::edit/$1', ['filter' => 'permission:users,update']);
        $routes->post('update/(:num)','Admin\UserController::update/$1');
        $routes->get('delete/(:num)','Admin\UserController::delete/$1', ['filter' => 'permission:users,delete']);
        $routes->get('permission/(:num)','Admin\UserPermissionController::index/$1');
        $routes->post('permission/save','Admin\UserPermissionController::save');
    });

    
    $routes->group('roles', function ($routes) {
        $routes->get('', 'Admin\RoleController::index', ['filter' => 'permission:roles,view']);
        $routes->post('datatable', 'Admin\RoleController::datatable', ['filter' => 'permission:roles,view']);
        $routes->get('create', 'Admin\RoleController::create', ['filter' => 'permission:roles,create']);
        $routes->post('store', 'Admin\RoleController::store');
        $routes->get('edit/(:num)', 'Admin\RoleController::edit/$1', ['filter' => 'permission:roles,update']);
        $routes->post('update/(:num)', 'Admin\RoleController::update/$1');
        $routes->get('delete/(:num)', 'Admin\RoleController::delete/$1', ['filter' => 'permission:roles,delete']);
        $routes->get('permission/(:num)','Admin\RolePermissionController::index/$1');
        $routes->post('permission/save','Admin\RolePermissionController::save');
    });

    $routes->group('menus', function ($routes) {
        $routes->get('/', 'Admin\MenuController::index',['filter' => 'permission:menus,view']);
        $routes->post('datatable', 'Admin\MenuController::datatable',['filter' => 'permission:menus,view']);
        $routes->get('children/(:num)', 'Admin\MenuController::children/$1');
        $routes->get('create', 'Admin\MenuController::create',['filter' => 'permission:menus,create']);
        $routes->post('store', 'Admin\MenuController::store');
        $routes->get('edit/(:num)', 'Admin\MenuController::edit/$1',['filter' => 'permission:menus,update']);
        $routes->post('update/(:num)', 'Admin\MenuController::update/$1');
        $routes->get('delete/(:num)', 'Admin\MenuController::delete/$1',['filter' => 'permission:menus,delete']);
    });

    $routes->group('pegawai', function ($routes) {
        $routes->get('/', 'Admin\PegawaiController::index',['filter' => 'permission:pegawai,view']);
        $routes->post('datatable', 'Admin\PegawaiController::datatable',['filter' => 'permission:pegawai,view']);
        $routes->get('create', 'Admin\PegawaiController::create',['filter' => 'permission:pegawai,create']);
        $routes->post('store', 'Admin\PegawaiController::store');
        $routes->get('edit/(:num)', 'Admin\PegawaiController::edit/$1',['filter' => 'permission:pegawai,update']);
        $routes->post('update/(:num)', 'Admin\PegawaiController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PegawaiController::delete/$1',['filter' => 'permission:pegawai,delete']);
    });

    $routes->group('perusahaan', function ($routes) {
        $routes->get('/', 'Admin\PerusahaanController::index',['filter' => 'permission:perusahaan,view']);
        $routes->post('datatable', 'Admin\PerusahaanController::datatable',['filter' => 'permission:perusahaan,view']);
        $routes->get('create', 'Admin\PerusahaanController::create',['filter' => 'permission:perusahaan,create']);
        $routes->post('store', 'Admin\PerusahaanController::store');
        $routes->get('edit/(:num)', 'Admin\PerusahaanController::edit/$1',['filter' => 'permission:perusahaan,update']);
        $routes->post('update/(:num)', 'Admin\PerusahaanController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PerusahaanController::delete/$1',['filter' => 'permission:perusahaan,delete']);
    });

    $routes->group('jabatan', function ($routes) {
        $routes->get('/', 'Admin\JabatanController::index',['filter' => 'permission:jabatan,view']);
        $routes->post('datatable', 'Admin\JabatanController::datatable',['filter' => 'permission:jabatan,view']);
        $routes->get('create', 'Admin\JabatanController::create',['filter' => 'permission:jabatan,create']);
        $routes->post('store', 'Admin\JabatanController::store');
        $routes->get('edit/(:num)', 'Admin\JabatanController::edit/$1',['filter' => 'permission:jabatan,update']);
        $routes->post('update/(:num)', 'Admin\JabatanController::update/$1');
        $routes->get('delete/(:num)', 'Admin\JabatanController::delete/$1',['filter' => 'permission:jabatan,delete']);
    });

    $routes->group('galeri', function ($routes) {
        $routes->get('/', 'Admin\GaleriController::index',['filter' => 'permission:galeri,view']);
        $routes->post('datatable', 'Admin\GaleriController::datatable',['filter' => 'permission:galeri,view']);
        $routes->get('create', 'Admin\GaleriController::create',['filter' => 'permission:galeri,create']);
        $routes->post('store', 'Admin\GaleriController::store');
        $routes->get('edit/(:num)', 'Admin\GaleriController::edit/$1',['filter' => 'permission:galeri,update']);
        $routes->post('update/(:num)', 'Admin\GaleriController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GaleriController::delete/$1',['filter' => 'permission:galeri,delete']);
        $routes->post('tinymce/upload', 'Admin\TinymceController::upload');
    });

    $routes->group('faq', function ($routes) {
        $routes->get('/', 'Admin\FaqController::index',['filter' => 'permission:faq,view']);
        $routes->post('datatable', 'Admin\FaqController::datatable',['filter' => 'permission:faq,view']);
        $routes->get('create', 'Admin\FaqController::create',['filter' => 'permission:faq,create']);
        $routes->post('store', 'Admin\FaqController::store');
        $routes->get('edit/(:num)', 'Admin\FaqController::edit/$1',['filter' => 'permission:faq,update']);
        $routes->post('update/(:num)', 'Admin\FaqController::update/$1');
        $routes->get('delete/(:num)', 'Admin\FaqController::delete/$1',['filter' => 'permission:faq,delete']);
        $routes->post('toggle', 'Admin\FaqController::toggle');
    });


    $routes->group('settings', function ($routes) {
        $routes->get('/', 'Admin\SettingsController::index',['filter' => 'permission:settings,view']);
        $routes->post('update', 'Admin\SettingsController::update',['filter' => 'permission:settings,update']);
    });

    

    
});
