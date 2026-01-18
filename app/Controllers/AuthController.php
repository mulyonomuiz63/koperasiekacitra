<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\EmailService;

class AuthController extends BaseController
{
    protected $userModel;
    protected $emailService;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->emailService = new EmailService();
    }
    public function login()
    {

        return view('auth/login');
    }

    public function attemptLogin()
    {
        // ⛔ Tolak jika bukan AJAX
        if (!$this->request->isAJAX()) {
            return redirect()->to('login');
        }

        $email    = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');
        $ip       = $this->request->getIPAddress();

        $attemptModel = new \App\Models\LoginAttemptModel();

        // 🔍 Ambil data attempt
        $attempt = $attemptModel
            ->where('email', $email)
            ->where('ip_address', $ip)
            ->first();

        // ⛔ Cek limit percobaan
        if ($attempt && $attempt['attempts'] >= 5) {
            $last = strtotime($attempt['last_attempt']);
            if (time() - $last < 10) {
                return $this->response->setJSON([
                    'status'   => 'error',
                    'message'  => 'Terlalu banyak percobaan login. Coba lagi 2 menit.',
                    'csrfHash' => csrf_hash()
                ]);
            } else {
                // Reset jika sudah lewat 2 menit
                $attemptModel->delete($attempt['id']);
                $attempt = null;
            }
        }

        // 🔐 Validasi input
        if (!$email || !$password) {
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Email dan password wajib diisi.',
                'csrfHash' => csrf_hash()
            ]);
        }

        // 🔍 Cari user
        $user = $this->userModel->where('email', $email)->first();

        // ❌ Email tidak ditemukan → tetap hitung attempt
        if (!$user) {
            $this->saveAttempt($attemptModel, $attempt, $email, $ip);

            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Email atau password salah.',
                'csrfHash' => csrf_hash()
            ]);
        }

        // ❌ Password salah
        if (!password_verify($password, $user['password'])) {
            $this->saveAttempt($attemptModel, $attempt, $email, $ip);

            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Email atau password salah.',
                'csrfHash' => csrf_hash()
            ]);
        }

        // 🚫 Akun belum aktif
        if ($user['status'] !== 'active') {
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Akun belum diverifikasi. Silakan cek email Anda.',
                'csrfHash' => csrf_hash()
            ]);
        }

        // ✅ LOGIN BERHASIL → HAPUS ATTEMPT
        $attemptModel
            ->where('email', $email)
            ->where('ip_address', $ip)
            ->delete();

        // 🔒 Remember me
        if ($this->request->getPost('remember')) {
            $token = bin2hex(random_bytes(32));

            $this->userModel->update($user['id'], [
                'remember_token' => hash('sha256', $token)
            ]);

            setcookie(
                'remember_me',
                $token,
                time() + (60 * 60 * 24 * 30),
                '/',
                '',
                true,
                true
            );
        }

        // ✅ Set session
        session()->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'email'     => $user['email'],
            'username'  => $user['username'],
            'role_id'   => $user['role_id'],
        ]);

        if ($user['role_id'] == 4) {
                $redirect = base_url('sw-anggota'); // anggota
        }else{
                $redirect = base_url('dashboard'); // admin dan lainnya
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'redirect' => $redirect,
            'csrfHash' => csrf_hash()
        ]);
    }
    private function saveAttempt($model, $attempt, $email, $ip)
    {
        if ($attempt) {
            $model->update($attempt['id'], [
                'attempts' => $attempt['attempts'] + 1,
                'last_attempt' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $model->insert([
                'email' => $email,
                'ip_address' => $ip,
                'attempts' => 1,
                'last_attempt' => date('Y-m-d H:i:s'),
            ]);
        }
    }


    public function logout()
    {
        $session = session();

        // 🔒 Hapus cookie remember me jika ada
        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/'); // expire cookie
        }

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

        $email = trim($this->request->getPost('email'));

        if (!$email) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email wajib diisi.',
                'csrfHash' => csrf_hash()
            ]);
        }

        $user = $this->userModel->where('email', $email)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email tidak ditemukan.',
                'csrfHash' => csrf_hash()
            ]);
        }

        $token = bin2hex(random_bytes(32));

        $resetModel = new \App\Models\ResetPasswordModel();

        // hapus token lama user ini
        $resetModel->where('user_id', $user['id'])->delete();

        // simpan token (HASH)
        $resetModel->insert([
            'user_id'    => $user['id'],
            'token'      => hash('sha256', $token),
            'expired_at' => date('Y-m-d H:i:s', time() + 3600) // 1 jam
        ]);

        $link = base_url("reset-password/$token");

        // kirim email (sesuaikan service email kamu)
        $link = base_url("reset-password/$token");

        $html = view('emails/reset_password', [
            'link' => $link,
            'name' => $user['username']
        ]);

        $this->emailService->send(
            $user['email'],
            'Reset Password',
            $html
        );

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Link reset password berhasil dikirim.',
            'csrfHash' => csrf_hash()
        ]);
    }


    public function resetPasswordForm($token)
    {
        $resetModel = new \App\Models\ResetPasswordModel();

        $reset = $resetModel
            ->where('token', hash('sha256', $token))
            ->first();

        if (!$reset) {
            return redirect()->to('login')->with('error', 'Token tidak valid.');
        }

        if (strtotime($reset['expired_at']) < time()) {
            $resetModel->delete($reset['id']);
            return redirect()->to('login')->with('error', 'Token sudah kadaluarsa.');
        }

        return view('auth/reset_password', [
            'token' => $token
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
                'status' => 'error',
                'message' => 'Password minimal 8 karakter.',
                'csrfHash' => csrf_hash()
            ]);
        }

        $resetModel = new \App\Models\ResetPasswordModel();

        $reset = $resetModel
            ->where('token', hash('sha256', $token))
            ->first();

        if (!$reset) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Token tidak valid.',
                'csrfHash' => csrf_hash()
            ]);
        }

        if (strtotime($reset['expired_at']) < time()) {
            $resetModel->delete($reset['id']);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Token sudah kadaluarsa.',
                'csrfHash' => csrf_hash()
            ]);
        }

        // update password
        $this->userModel->update($reset['user_id'], [
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        // hapus token
        $resetModel->delete($reset['id']);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password berhasil direset. Silakan login.',
            'csrfHash' => csrf_hash()
        ]);
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

        $rules = [
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => implode('<br>', $this->validator->getErrors()),
                'csrfHash' => csrf_hash()
            ]);
        }

        $email = $this->request->getPost('email');

        $token = bin2hex(random_bytes(32));

        $this->userModel->insert([
            'username'           => explode('@', $email)[0],
            'email'              => $email,
            'password'           => password_hash(
                                        $this->request->getPost('password'),
                                        PASSWORD_BCRYPT
                                ),
            'role_id'            => 4, // anggota
            'status'             => 'inactive',
            'verification_token' => $token
        ]);

        // Kirim email verifikasi
        // $this->_sendVerificationEmail($email, $token);

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Registrasi berhasil, silakan cek email untuk verifikasi.',
            'csrfHash' => csrf_hash()
        ]);
    }


    public function verify($token)
    {
        $user = $this->userModel
            ->where('verification_token', $token)
            ->first();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Token tidak valid.');
        }

        $this->userModel->update($user['id'], [
            'status'             => 'active',
            'verification_token' => null,
            'email_verified_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('login')->with('success', 'Email berhasil diverifikasi.');
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
