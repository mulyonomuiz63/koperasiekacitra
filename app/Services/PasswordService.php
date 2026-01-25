<?php

namespace App\Services;

use App\Libraries\EmailService;
use App\Models\UserModel;
use App\Models\ResetPasswordModel;

class PasswordService
{
    protected UserModel $userModel;
    protected ResetPasswordModel $resetModel;
    protected EmailService $emailService;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->resetModel  = new ResetPasswordModel();
        $this->emailService = new EmailService(); // Pastikan sudah ada service email
    }

    /**
     * Proses forgot password
     *
     * @param string $email
     * @return array
     */
    public function forgotPassword(string $email): array
    {
        $email = trim($email);

        if (!$email) {
            return $this->error('Email wajib diisi.');
        }

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return $this->error('Email tidak ditemukan.');
        }

        // 🔑 Generate token acak
        $token = bin2hex(random_bytes(32));

        // hapus token lama user ini
        $this->resetModel->where('user_id', $user['id'])->delete();

        // simpan token (HASH)
        $this->resetModel->insert([
            'user_id'    => $user['id'],
            'token'      => hash('sha256', $token),
            'expired_at' => date('Y-m-d H:i:s', time() + 3600) // 1 jam
        ]);

        $link = base_url("reset-password/$token");

        // 🔔 Kirim email
        $html = view('emails/reset_password', [
            'link' => $link,
            'name' => $user['username']
        ]);

        $this->emailService->send(
            $user['email'],
            'Reset Password',
            $html
        );

        return [
            'status'  => 'success',
            'message' => 'Link reset password berhasil dikirim.'
        ];
    }

    public function validateResetToken(string $token)
    {
        $hashedToken = hash('sha256', $token);

        $reset = $this->resetModel
            ->where('token', $hashedToken)
            ->first();

        if (!$reset) {
            return [
                'status'  => 'error',
                'message' => 'Token tidak valid.'
            ];
        }

        if (strtotime($reset['expired_at']) < time()) {
            $this->resetModel->delete($reset['id']);
            return [
                'status'  => 'error',
                'message' => 'Token sudah kadaluarsa.'
            ];
        }

        // Jika valid, kembalikan data user dan reset
        $user = $this->userModel->find($reset['user_id']);

        return [
            'status' => 'success',
            'user'   => $user,
            'reset'  => $reset,
            'token'  => $token
        ];
    }

    public function resetPassword(string $token, string $newPassword)
    {
        $hashedToken = hash('sha256', $token);

        $reset = $this->resetModel
            ->where('token', $hashedToken)
            ->first();

        if (!$reset) {
            return [
                'status'  => 'error',
                'message' => 'Token tidak valid.'
            ];
        }

        if (strtotime($reset['expired_at']) < time()) {
            $this->resetModel->delete($reset['id']);
            return [
                'status'  => 'error',
                'message' => 'Token sudah kadaluarsa.'
            ];
        }

        // Update password
        $this->userModel->update($reset['user_id'], [
            'password' => password_hash($newPassword, PASSWORD_BCRYPT)
        ]);

        // Hapus token
        $this->resetModel->delete($reset['id']);

        return [
            'status'  => 'success',
            'message' => 'Password berhasil direset. Silakan login.'
        ];
    }

    /**
     * Helper error
     */
    protected function error(string $message): array
    {
        return [
            'status'  => 'error',
            'message' => $message
        ];
    }
}
