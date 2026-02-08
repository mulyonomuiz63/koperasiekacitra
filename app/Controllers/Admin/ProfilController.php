<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\Admin\ProfileService;

class ProfilController extends BaseController
{
    protected $user;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->service = new ProfileService();
        $this->menuId = $this->setMenu('profil');
    }

    public function index()
    {
        try {
            $userId = session()->get('user_id');

            // Panggil service untuk mendapatkan paket data profil
            $data = $this->service->getProfilData($userId);

            return $this->view('admin/profil/index', $data);
        } catch (\Throwable $e) {
            // Jika data pegawai belum diinput oleh admin
            return redirect()->to('/dashboard')->with('error', $e->getMessage());
        }
    }

    public function uploadAvatar()
    {
        // Panggil Service
        try {
            $userId = session()->get('user_id');
            $file = $this->request->getFile('avatar');

            // Pastikan ada file yang diunggah sebelum diproses service
            if (!$file || $file->getError() == 4) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Silakan pilih file terlebih dahulu.'
                ]);
            }

            // Eksekusi Service
            $result = $this->service->updateAvatar($userId, $file);

            // Berikan response JSON berdasarkan hasil service
            if ($result['status']) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => $result['message']
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message']
            ]);
        } catch (\Exception $e) {
            // Menangkap error tak terduga (database, file system, dll)
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        } catch (\Throwable $t) {
            // Menangkap error level rendah (PHP 7+)
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Kritis: ' . $t->getMessage()
            ]);
        }
    }

    public function saveData()
    {
        try {
            // Ambil ID dari post
            $userId = $this->request->getPost('pegawai_id'); // Pastikan input name sesuai dengan di Service
            $postData = $this->request->getPost();

            // Jalankan service
            $this->service->savePegawaiData($userId, $postData);

            return redirect()->to('profil')->with('success', 'Data pegawai berhasil diubah.');
        } catch (\RuntimeException $e) {
            // Menangkap error validasi yang kita "throw" dari Service (Bahasa Indonesia)
            return redirect()->to('profil')->withInput()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            // Menangkap error sistem yang tidak terduga (Database crash, dll)
            // Log error asli untuk internal, tapi tampilkan pesan umum ke user
            return redirect()->to('profil')->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses data.');
        }
    }

    public function updatePassword()
    {
        try {
            $userId = session()->get('user_id');
            $postData = $this->request->getPost();

            // 1. Tambahkan Validasi Manual di Controller
            // Agar tidak berat ke database jika inputnya saja sudah salah
            if ($postData['new_password'] !== $postData['confirm_password']) {
                return redirect()->to('profil')->with('error', 'Konfirmasi password tidak cocok.');
            }

            if (strlen($postData['new_password']) < 8) {
                return redirect()->to('profil')->with('error', 'Password minimal harus 8 karakter.');
            }

            // 2. Jalankan service
            $this->service->updatePassword($userId, $postData);

            // Ubah pesan sukses agar lebih relevan
            return redirect()->to('profil')->with('success', 'Password berhasil diperbarui.');
        } catch (\RuntimeException $e) {
            return redirect()->to('profil')->withInput()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            // Gunakan pesan yang lebih ramah pengguna untuk error sistem
            return redirect()->to('profil')->withInput()->with('error', 'Terjadi kesalahan sistem saat mengubah password.');
        }
    }
}
