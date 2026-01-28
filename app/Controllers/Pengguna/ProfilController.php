<?php

namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\Pengguna\ProfileService;

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

            // Panggil service untuk mengambil data gabungan
            $data = $this->service->getProfilLengkap($userId);

            if (!$data['user']) {
                return redirect()->to('/dashboard')->with('error', 'Data profil tidak ditemukan.');
            }

            return $this->view('anggota/profil/index', $data);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function saveData()
    {
        try {
            $this->service->savePegawaiData($this->request->getPost('pegawai_id'), $this->request->getPost());
            return redirect()->to('/sw-anggota/profil')->with('success', 'Data pegawai berhasil diubah.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pegawai.');
        }
    }
}
