<?php

namespace App\Controllers;

use App\Libraries\CaptchaService;
use App\Models\UserModel;
use App\Libraries\EmailService;
use App\Models\PegawaiModel;
use App\Services\AuthService;
use App\Services\PasswordService;

class AuthController extends BaseController
{
    protected $userModel;
    protected $pegawaiModel;
    protected $emailService;
    protected $service;
    protected $servicePassword;
    protected $captchaService;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->emailService = new EmailService();
        $this->service = new AuthService();
        $this->servicePassword = new PasswordService();
        $this->captchaService = new CaptchaService();
    }
    public function login()
    {
        // Inisialisasi library untuk cek status dan ambil Site Key
        $data['siteKey'] = $this->captchaService->getSiteKey();

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        // 1. Guard Clause: Pastikan hanya menerima request AJAX
        if (!$this->request->isAJAX()) {
            return redirect()->to('login');
        }

        try {
            $token = $this->request->getPost('g-recaptcha-response');

            // 2. Validasi Captcha melalui Service
            if (!$this->captchaService->verify($token)) {
                return $this->response->setJSON([
                    'status'   => 'error',
                    'message'  => 'Verifikasi Captcha gagal. Silakan coba lagi.',
                    'csrfHash' => csrf_hash()
                ]);
            }

            // 3. Eksekusi Login melalui AuthService
            $result = $this->service->attemptLogin(
                trim((string) $this->request->getPost('email')),
                (string) $this->request->getPost('password'),
                (bool) $this->request->getPost('remember')
            );

            // 4. Tambahkan CSRF Hash terbaru untuk request berikutnya
            $result['csrfHash'] = csrf_hash();

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            // 5. Tangkap Error Spesifik (Database down, SMTP error, dll)
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Terjadi kendala pada sistem: ' . $e->getMessage(),
                'csrfHash' => csrf_hash()
            ]);
        } catch (\Throwable $te) {
            // 6. Tangkap Fatal Error (PHP 7+)
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Terjadi kesalahan fatal pada server.',
                'csrfHash' => csrf_hash()
            ]);
        }
    }


    public function logout()
    {
        try {
            $session = session();
            $userId  = $session->get('user_id');

            // 1. Bersihkan Cache Dashboard Spesifik User
            // Dilakukan sebelum session hancur agar userId masih bisa terbaca
            if ($userId) {
                $cache = \Config\Services::cache();
                $cache->delete('dashboard_stats_' . $userId);
            }

            // 2. Hapus Cookie Remember Me secara fisik
            if (isset($_COOKIE['remember_me'])) {
                // Pastikan parameter domain dan path sesuai saat cookie dibuat
                setcookie('remember_me', '', [
                    'expires'  => time() - 3600,
                    'path'     => '/',
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }

            // 3. Hancurkan Session
            $session->destroy();

            return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar.');
        } catch (\Throwable $e) {
            // Jika terjadi error (misal: Cache driver error), 
            // tetap paksa hancurkan session demi keamanan user
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Logout selesai dengan beberapa peringatan sistem.');
        }
    }


    public function forgotPasswordForm()
    {
        $data['siteKey'] = $this->captchaService->getSiteKey();
        return view('auth/forgot_password', $data);
    }

    public function forgotPassword()
    {
        // 1. Guard Clause: Pastikan hanya request AJAX
        if (!$this->request->isAJAX()) {
            return redirect()->to('login');
        }

        $token = $this->request->getPost('g-recaptcha-response');

        // 2. Validasi Captcha melalui Service
        if (!$this->captchaService->verify($token)) {
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Verifikasi Captcha gagal. Silakan coba lagi.',
                'csrfHash' => csrf_hash()
            ]);
        }

        try {
            $email = trim((string) $this->request->getPost('email'));

            // Validasi format email dasar sebelum dikirim ke Service
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON([
                    'status'   => 'error',
                    'message'  => 'Format email tidak valid.',
                    'csrfHash' => csrf_hash()
                ]);
            }

            // 2. Eksekusi logika lupa password via Service
            // Service ini biasanya berisi: cek email di DB, generate token, simpan token, kirim email.
            $result = $this->servicePassword->forgotPassword($email);

            // 3. Tambahkan CSRF Hash terbaru untuk keamanan request berikutnya
            $result['csrfHash'] = csrf_hash();

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            // 4. Tangkap error logika (misal: email tidak ditemukan)
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => $e->getMessage(),
                'csrfHash' => csrf_hash()
            ]);
        } catch (\Throwable $te) {
            // 5. Tangkap error sistem/fatal (misal: kegagalan koneksi SMTP email atau database)
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Gagal mengirim instruksi reset password. Silakan coba beberapa saat lagi.',
                'csrfHash' => csrf_hash()
            ]);
        }
    }



    public function resetPasswordForm($token)
    {
        try {
            // 1. Validasi token melalui Service
            // Service bertugas mengecek: apakah token ada, apakah sudah dipakai, & apakah sudah expired
            $result = $this->servicePassword->validateResetToken($token);

            // 2. Jika validasi gagal secara logika (misal: token expired)
            if ($result['status'] === 'error') {
                return redirect()->to('login')->with('error', $result['message']);
            }

            // 3. Tampilkan view jika token valid
            return view('auth/reset_password', [
                'token' => $result['token'],
                'title' => 'Reset Password Baru',
                'siteKey' => null
            ]);
        } catch (\Exception $e) {
            // Tangkap error logika yang dilempar dari service
            return redirect()->to('login')->with('error', $e->getMessage());
        } catch (\Throwable $te) {
            // Tangkap error sistem (misal: koneksi database terputus)
            return redirect()->to('login')->with('error', 'Terjadi kesalahan sistem saat memvalidasi permintaan Anda.');
        }
    }


    public function resetPasswordProcess()
    {
        // 1. Guard Clause: Pastikan request via AJAX
        if (!$this->request->isAJAX()) {
            return redirect()->to('login');
        }

        try {
            $token    = $this->request->getPost('token');
            $password = (string) $this->request->getPost('password');

            // 2. Validasi Input Dasar
            if (!$token || strlen($password) < 8) {
                return $this->response->setJSON([
                    'status'   => 'error',
                    'message'  => 'Permintaan tidak valid atau password kurang dari 8 karakter.',
                    'csrfHash' => csrf_hash()
                ]);
            }

            // 3. Eksekusi Reset Password via Service
            // Service bertugas: Verifikasi token, Hash password baru, Update tabel users, Hapus token reset.
            $result = $this->servicePassword->resetPassword($token, $password);

            // 4. Tambahkan CSRF Hash terbaru untuk response
            $result['csrfHash'] = csrf_hash();

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            // Tangkap error logika (misal: token sudah kadaluwarsa saat tombol ditekan)
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => $e->getMessage(),
                'csrfHash' => csrf_hash()
            ]);
        } catch (\Throwable $te) {
            // Tangkap error fatal/sistem
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Gagal memperbarui password. Terjadi kendala teknis pada server.',
                'csrfHash' => csrf_hash()
            ]);
        }
    }

    public function register()
    {
        // Inisialisasi library untuk cek status dan ambil Site Key
        $data['siteKey'] = $this->captchaService->getSiteKey();
        return view('auth/register', $data);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        // --- 1. TERAPKAN THROTTLER (Rate Limiting) ---
        // Membatasi maksimal 5 percobaan pendaftaran per 1 Menit per alamat IP
        $throttler = \Config\Services::throttler();
        if ($throttler->check(md5($this->request->getIPAddress()), 5, MINUTE) === false) {
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Terlalu banyak percobaan registrasi. Silakan tunggu 1 menit lagi.',
                'csrfHash'  => csrf_hash()
            ])->setStatusCode(429); // 429 = Too Many Requests
        }

        // --- 2. VALIDASI RECAPTCHA ---
        $token = $this->request->getPost('g-recaptcha-response');
        if (!$this->captchaService->verify($token)) {
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Gagal memproses aktivitas mencurigakan (Captcha Error).',
                'csrfHash'  => csrf_hash()
            ]);
        }

        try {
            $data = $this->request->getPost();

            // Panggil service pendaftaran
            $result = $this->service->register($data);

            // Tambahkan CSRF hash baru untuk dikirim balik ke view
            $result['csrfHash'] = csrf_hash();

            return $this->response->setJSON($result);
        } catch (\Throwable $e) {
            // Log pesan error teknis ke log sistem
            log_message('error', '[Register Error]: ' . $e->getMessage());

            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Terjadi kesalahan saat registrasi. Silakan coba lagi nanti.',
                'csrfHash' => csrf_hash()
            ]);
        }
    }
    public function verify($token)
    {
        try {
            $result = $this->service->verifyEmail($token);

            if ($result['status'] === 'error') {
                return redirect()->to('login')->with('error', $result['message']);
            }

            return redirect()->to('login')->with('success', $result['message']);
        } catch (\Throwable $e) {
            return redirect()->to('login')->with('error', 'Terjadi kesalahan saat verifikasi. Silakan coba lagi.');
        }
    }


    public function checkEmail()
    {
        // Pastikan hanya melayani request AJAX untuk keamanan
        if (!$this->request->isAJAX()) {
            return redirect()->to('/');
        }

        try {
            $email = strtolower(trim((string) $this->request->getPost('email')));

            // 1. Validasi format email sederhana sebelum ke Database
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON([
                    'status'   => 'invalid',
                    'message'  => 'Format email tidak valid',
                    'csrfHash' => csrf_hash()
                ]);
            }

            // 2. Cek keberadaan email di Database
            $exists = $this->userModel
                ->where('email', $email)
                ->first();

            // 3. Kembalikan respon sukses
            return $this->response->setJSON([
                'status'   => $exists ? 'used' : 'available',
                'csrfHash' => csrf_hash()
            ]);
        } catch (\Throwable $e) {
            // 4. Tangkap error (DB Down, dsb) tanpa menghentikan eksekusi script
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Gagal memvalidasi email.',
                'csrfHash' => csrf_hash()
            ]);
        }
    }
    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
