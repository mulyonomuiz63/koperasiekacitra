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

        // 1. 🛡️ SANITASI & NORMALISASI EMAIL
        // Menghapus spasi di awal/akhir dan karakter ilegal dalam email
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $email = strtolower($email); // Normalisasi ke huruf kecil

        // 🔍 Ambil attempt (Rate Limiting tetap yang utama)
        $attempt = $this->getAttempt($email, $ip);

        // ⛔ Lockout
        if ($this->isLocked($attempt)) {
            return $this->error('Terlalu banyak percobaan login. Silakan coba beberapa menit lagi.');
        }

        // 2. 🔐 VALIDASI FORMAT EMAIL (Mencegah Karakter Aneh Lolos)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Jangan beri tahu "format salah", cukup "Login Gagal" agar tidak memberi info ke penyerang
            return $this->error('Email atau password salah.');
        }

        // Validasi input dasar
        if (empty($email) || empty($password)) {
            return $this->error('Email dan password wajib diisi.');
        }

        // 3. 🛡️ CEK PANJANG INPUT (Mencegah ReDoS atau DoS via Long String)
        if (strlen($email) > 100 || strlen($password) > 255) {
            return $this->error('Input melebihi batas yang diizinkan.');
        }

        // 🔍 Cari user menggunakan Query Builder (Otomatis aman dari SQL Injection)
        $user = $this->userModel->where('email', $email)->first();

        // 4. 🛡️ TIMING ATTACK PROTECTION (Opsional tapi bagus)
        // Menggunakan password_verify sudah cukup aman dari timing attack
        if (!$user || !password_verify($password, $user['password'])) {
            $this->saveAttempt($attempt, $email, $ip);
            return $this->error('Email atau password salah.');
        }

        // 🚫 Status user
        if ($user['status'] !== 'active') {
            return $this->error('Akun Anda belum aktif atau belum diverifikasi.');
        }

        // Caching logic
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

            // 1. --- VALIDASI FORMAT EMAIL ---
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Format email tidak valid.');
            }

            // 2. --- VALIDASI DOMAIN EMAIL ---
            if (!$this->is_valid_domain($email)) {
                throw new \Exception('Domain email tidak valid atau tidak didukung.');
            }

            // 3. --- CEK APAKAH EMAIL SUDAH TERDAFTAR ---
            $existingUser = $this->userModel->where('email', $email)->first();
            if ($existingUser) {
                throw new \Exception('Email sudah digunakan, silakan gunakan email lain.');
            }

            $token = bin2hex(random_bytes(32));

            // --- CARI UUID SECARA DINAMIS ---
            $role = $this->roleModel->where('role_key', 'ANGGOTA')->first();
            $jabatan = $this->db->table('jabatan')->where('jabatan_key', 'ANGGOTA')->get()->getRowArray();
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
                'role_id'            => $role['id'],
                'status'             => 'inactive',
                'verification_token' => $token
            ]);

            // Insert pegawai otomatis
            $this->pegawaiModel->insert([
                'user_id'       => $userId,
                'perusahaan_id' => $perusahaan['id'],
                'jabatan_id'    => $jabatan['id'],
                'status'        => 'T'
            ]);

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan data.');
            }

            $this->db->transCommit();

            // PROSES KIRIM EMAIL
            $subject = "Verifikasi Akun " . setting('app_name');
            $data['link'] = base_url("verify-email/" . $token);
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
                // Menampilkan pesan error asli dari throw agar user tahu apa yang salah (email duplikat/domain salah)
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Fungsi untuk validasi apakah domain email memiliki record DNS (MX) yang valid
     */
    private function is_valid_domain($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        if (!$domain) return false;

        // Cek record MX (Mail Exchange) dari domain tersebut
        return checkdnsrr($domain, "MX");
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
