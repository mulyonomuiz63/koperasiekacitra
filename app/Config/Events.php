<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HotReloader\HotReloader;
use CodeIgniter\Security\Exceptions\SecurityException;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();
        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }

    set_exception_handler(function ($exception) {
        // Jika error disebabkan oleh CSRF (SecurityException)
        if ($exception instanceof SecurityException) {
            // Beri pesan agar user tahu kenapa dia dilempar balik
            session()->setFlashdata('error', 'Sesi keamanan berakhir, silakan coba lagi.');
            
            // Redirect kembali ke halaman sebelumnya
            // Ini otomatis me-refresh token CSRF di form
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? base_url()));
            exit;
        }

        if ($exception instanceof PageNotFoundException) {
            session()->setFlashdata('error', 'Halaman tidak valid atau telah dihapus.');
            header('Location: ' . base_url('/'));
            exit;
        }

        // Jika error lain, biarkan CI4 menanganinya secara normal
        (new \CodeIgniter\Debug\Exceptions(config('Exceptions')))->exceptionHandler($exception);
    });
    
});
