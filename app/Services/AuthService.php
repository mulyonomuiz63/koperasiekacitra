<?php

namespace App\Services;

use App\Libraries\EmailService;
use App\Models\UserModel;
use App\Models\LoginAttemptModel;
use App\Models\PegawaiModel;
use App\Models\RoleModel;
use Config\Auth;
use Config\Database;

class AuthService
{
    protected UserModel $userModel;
    protected PegawaiModel $pegawaiModel;
    protected LoginAttemptModel $attemptModel;
    protected Auth $config;
    protected $db;
    protected $roleModel;
    protected $emailService;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->userModel    = new UserModel();
        $this->pegawaiModel    = new PegawaiModel();
        $this->attemptModel = new LoginAttemptModel();
        $this->config       = new Auth();
        $this->roleModel = new RoleModel();
        $this->emailService = new EmailService();
    }

    public function attemptLogin(
        string $email,
        string $password,
        bool $remember = false,
        ?string $ip = null
    ): array {
        $ip = $ip ?? request()->getIPAddress();

        // 🔍 Ambil attempt
        $attempt = $this->getAttempt($email, $ip);

        // ⛔ Lockout
        if ($this->isLocked($attempt)) {
            return $this->error(
                'Terlalu banyak percobaan login. Silakan coba beberapa menit lagi.'
            );
        }

        // 🔐 Validasi input
        if (!$email || !$password) {
            return $this->error('Email dan password wajib diisi.');
        }

        // 🔍 Cari user
        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            $this->saveAttempt($attempt, $email, $ip);
            return $this->error('Email atau password salah.');
        }

        // 🚫 Status user
        if ($user['status'] !== 'active') {
            return $this->error('Akun belum diverifikasi.');
        }

        // Setelah verifikasi password benar
        $userId = $user['id']; 
        $cache = \Config\Services::cache();
        $cache->delete('dashboard_stats_' . $userId);

        // ✅ LOGIN BERHASIL
        $this->clearAttempt($email, $ip);
        $this->setSession($user);
        $this->rememberMe($user, $remember);

        return [
            'status'   => 'success',
            'redirect' => $this->redirectByRole($user['role_id'])
        ];
    }

    /* =======================================================
     * INTERNAL METHODS
     * =======================================================
     */

    protected function getAttempt(string $email, string $ip): ?array
    {
        return $this->attemptModel
            ->where('email', $email)
            ->where('ip_address', $ip)
            ->first();
    }

    protected function isLocked(?array $attempt): bool
    {
        if (!$attempt || $attempt['attempts'] < $this->config->maxAttempts) {
            return false;
        }

        $last = strtotime($attempt['last_attempt']);
        return (time() - $last) < ($this->config->lockoutMinute * 60);
    }

    protected function saveAttempt(?array $attempt, string $email, string $ip): void
    {
        $data = [
            'email'        => $email,
            'ip_address'   => $ip,
            'attempts'     => ($attempt['attempts'] ?? 0) + 1,
            'last_attempt' => date('Y-m-d H:i:s'),
        ];

        $attempt
            ? $this->attemptModel->update($attempt['id'], $data)
            : $this->attemptModel->insert($data);
    }

    protected function clearAttempt(string $email, string $ip): void
    {
        $this->attemptModel
            ->where('email', $email)
            ->where('ip_address', $ip)
            ->delete();
    }

    protected function setSession(array $user): void
    {
        $role = $this->roleModel->where('id', $user['role_id'])->first();
        session()->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'email'     => $user['email'],
            'username'  => $user['username'],
            'role_id'   => $user['role_id'],
            'role_key'  => $role['role_key'],
        ]);
    }

    protected function rememberMe(array $user, bool $remember): void
    {
        if (!$remember) {
            return;
        }

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

    protected function redirectByRole($roleId)
    {
        // Ambil data role berdasarkan role_id yang disimpan di session
        $cekRole = $this->roleModel->where('id', $roleId)->first();

        // Pastikan role ditemukan untuk menghindari error "trying to access array offset on null"
        if ($cekRole) {
            $roleKey = $cekRole['role_key'];

            if ($roleKey == 'ADMIN') {
                return base_url('/dashboard');
            } elseif ($roleKey == 'ANGGOTA') { // Ubah dari ADMIN ke ANGGOTA
                return base_url('/sw-anggota');
            } else {
                // Jika role tidak dikenali sistem
                return base_url('/logout');
            }
        }
    }

    protected function error(string $message): array
    {
        return [
            'status'  => 'error',
            'message' => $message
        ];
    }

    /**
     * Registrasi user anggota
     */
    public function register(array $postData): array
    {
        $this->db->transBegin();

        try {
            $email = trim($postData['email']);
            $password = $postData['password'];
            $token = bin2hex(random_bytes(32));

            // --- CARI UUID SECARA DINAMIS ---
            // Cari ID Role Anggota berdasarkan role_key
            $role = $this->roleModel->where('role_key', 'ANGGOTA')->first();
            
            // Cari ID Jabatan Anggota (asumsi tabel jabatan juga punya kolom code/key)
            // Jika tidak ada kolom code, gunakan nama, tapi lebih aman tambahkan kolom code.
            $jabatan = $this->db->table('jabatan')->where('jabatan_key', 'ANGGOTA')->get()->getRowArray();
            
            // Cari ID Perusahaan default (misal berdasarkan kode perusahaan)
            $perusahaan = $this->db->table('perusahaan')->where('perusahaan_key', 'default')->get()->getRowArray();

            // Validasi jika data master tidak ditemukan
            if (!$role || !$jabatan || !$perusahaan) {
                throw new \Exception('Data master (Role/Jabatan/Perusahaan) belum dikonfigurasi.');
            }

            // Insert user
            $userId = $this->userModel->insert([
                'username'           => explode('@', $email)[0],
                'email'              => $email,
                'password'           => password_hash($password, PASSWORD_BCRYPT),
                'role_id'            => $role['id'], // anggota
                'status'             => 'inactive',
                'verification_token' => $token
            ]);

            // Insert pegawai otomatis
            $this->pegawaiModel->insert([
                'user_id'       => $userId,
                'perusahaan_id' => $perusahaan['id'], // Menggunakan UUID hasil query
                'jabatan_id'    => $jabatan['id'],    // Menggunakan UUID hasil query
                'status'        => 'T'
            ]);

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan data.');
            }

            $this->db->transCommit();

            // ==========================================
            // PROSES KIRIM EMAIL (Setelah Commit)
            // ==========================================
            
            $subject = "Verifikasi Akun " . setting('app_name');
            $data['link']    = base_url("verify-email/" . $token);

            $message = view('emails/verify_email', $data);

            $sendEmail = $this->emailService->send($email, $subject, $message);

            return [
                'status'  => 'success',
                'message' => $sendEmail 
                            ? 'Registrasi berhasil, silakan cek email untuk verifikasi.' 
                            : 'Registrasi berhasil, namun gagal mengirim email verifikasi. Silakan hubungi admin.',
                'token'   => $token,
            ];

        } catch (\Throwable $e) {
            $this->db->transRollback();

            return [
                'status' => 'error',
                'message'=> 'Terjadi kesalahan saat registrasi.'
            ];
        }
    }

    /**
     * Verifikasi email user
     */
    public function verifyEmail(string $token): array
    {
        $user = $this->userModel
            ->where('verification_token', $token)
            ->first();

        if (!$user) {
            return [
                'status'  => 'error',
                'message' => 'Token tidak valid.'
            ];
        }

        $this->userModel->update($user['id'], [
            'status'             => 'active',
            'verification_token' => null,
            'email_verified_at'  => date('Y-m-d H:i:s')
        ]);

        return [
            'status'  => 'success',
            'message' => 'Email berhasil diverifikasi.'
        ];
    }
}
