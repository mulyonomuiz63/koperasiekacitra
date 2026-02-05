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

// Route Google Authentication
$routes->group('auth', function($routes) {
    $routes->group('google', function($routes) {
        // Ini yang dipanggil di tombol "Masuk dengan Google"
        $routes->get('login', 'AuthController::googleLogin'); 
        
        // Ini adalah Redirect URI yang didaftarkan di Google Console
        $routes->get('callback', 'AuthController::googleCallback'); 
    });
});

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

// Test generate iuran bulanan
$routes->get('test-generate-iuran', 'TestIuranController::generate');
$routes->get('test-iuran', 'TestIuranController::generateNoLog');


if (file_exists(APPPATH . 'Config/RoutesAdmin.php')) {
    require APPPATH . 'Config/RoutesAdmin.php';
}

if (file_exists(APPPATH . 'Config/RoutesAnggota.php')) {
    require APPPATH . 'Config/RoutesAnggota.php';
}