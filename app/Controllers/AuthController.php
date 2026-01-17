<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $model = new UserModel();

        $user = $model->where('email', $this->request->getPost('email'))
                      ->first();

        if (!$user || !password_verify(
            $this->request->getPost('password'),
            $user['password']
        )) {
            return redirect()->back()->with('error','Email / Password salah');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()->with('error','Akun tidak aktif');
        }

        session()->set([
            'user_id' => $user['id'],
            'role_id' => $user['role_id'],
            'isLoggedIn' => true
        ]);

        $model->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function requestReset($userId)
    {
        $token = bin2hex(random_bytes(32));

        $db = db_connect();
        $db->table('password_resets')->insert([
            'user_id' => $userId,
            'token' => $token,
            'expired_at' => date('Y-m-d H:i:s', strtotime('+30 minutes'))
        ]);

        // kirim email token (opsional)
    }

}
