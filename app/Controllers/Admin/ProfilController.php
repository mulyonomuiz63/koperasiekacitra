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
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            // Menangkap error sistem yang tidak terduga (Database crash, dll)
            // Log error asli untuk internal, tapi tampilkan pesan umum ke user
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses data.');
        }
    }
}
