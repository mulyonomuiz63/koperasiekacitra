<?php

$routes->group('sw-anggota', ['filter'=>['auth','role:ANGGOTA,ADMIN', 'anggotaRedirect']], function($routes){ //untuk anggota
    $routes->get('/','Pengguna\HomeController::index');

    $routes->get('activity', 'Pengguna\ActivityController::index');
    $routes->get('lengkapi-data', 'Pengguna\ActivityController::index');
    $routes->post('lengkapi-data', 'Pengguna\ActivityController::saveData');
    $routes->post('pembayaran', 'Pengguna\ActivityController::uploadPembayaran');

    $routes->group('profil', function ($routes) {
        $routes->get('/', 'Pengguna\ProfilController::index');
        $routes->post('update', 'Pengguna\ProfilController::saveData');
        $routes->post('update-password', 'Pengguna\ProfilController::updatePassword');
        $routes->post('upload-avatar', 'Pengguna\ProfilController::uploadAvatar');
    });

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