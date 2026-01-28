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
            $this->service->savePegawaiData($this->request->getPost('pegawai_id'), $this->request->getPost());
            return redirect()->to('profil')->with('success', 'Data pegawai berhasil diubah.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pegawai.');
        }
    }
}
