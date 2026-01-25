<?php

namespace App\Controllers;

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
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->emailService = new EmailService();
        $this->service = new AuthService();
        $this->servicePassword = new PasswordService();
    }
    public function login()
    {

        return view('auth/login');
    }

    public function attemptLogin()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('login');
        }

        $result = $this->service->attemptLogin(
            trim($this->request->getPost('email')),
            $this->request->getPost('password'),
            (bool) $this->request->getPost('remember')
        );

        $result['csrfHash'] = csrf_hash();

        return $this->response->setJSON($result);
    }

    
    public function logout()
    {
        $session = session();

        // 🔒 Hapus cookie remember me jika ada
        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/'); // expire cookie
        }

        // untuk menghapus cache
        $userId = session()->get('user_id');
        $cache = \Config\Services::cache();
        $cache->delete('dashboard_stats_' . $userId);
        // ✅ Hapus semua session
        $session->destroy();

        // 🔄 Redirect ke halaman login
        return redirect()->to('/login');
    }


    public function forgotPasswordForm()
    {
        return view('auth/forgot_password');
    }
    
    public function forgotPassword()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('login');
        }

        $email = $this->request->getPost('email');

        $result = $this->servicePassword->forgotPassword($email);
        $result['csrfHash'] = csrf_hash();

        return $this->response->setJSON($result);
    }



    public function resetPasswordForm($token)
    {
        $result = $this->servicePassword->validateResetToken($token);

        if ($result['status'] === 'error') {
            return redirect()->to('login')->with('error', $result['message']);
        }

        return view('auth/reset_password', [
            'token' => $result['token']
        ]);
    }


    public function resetPasswordProcess()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('login');
        }

        $token    = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        if (!$token || strlen($password) < 8) {
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Password minimal 8 karakter.',
                'csrfHash' => csrf_hash()
            ]);
        }

        $result = $this->servicePassword->resetPassword($token, $password);

        $result['csrfHash'] = csrf_hash();

        return $this->response->setJSON($result);
    }

    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        try {
            $data = $this->request->getPost();

            $result = $this->service->register($data);

            // Tambahkan CSRF hash
            $result['csrfHash'] = csrf_hash();

            return $this->response->setJSON($result);

        } catch (\Throwable $e) {
            // Jika ada error tak terduga
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.',
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
        $email = strtolower(trim($this->request->getPost('email')));

        $exists = $this->userModel
            ->where('email', $email)
            ->first();

        return $this->response->setJSON([
            'status'   => $exists ? 'used' : 'available',
            'csrfHash' => csrf_hash()
        ]);
    }
    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
