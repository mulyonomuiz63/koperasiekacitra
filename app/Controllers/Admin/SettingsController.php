<?php

namespace App\Controllers\Admin;

use App\Models\SettingModel;
use App\Services\Admin\SettingService;
use CodeIgniter\Controller;

class SettingsController extends Controller
{
    protected $settingModel;
    protected $service;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        $this->service = new SettingService();
    }

    public function index()
    {
        $data['settings'] = $this->settingModel->getAllSettings();
        return view('admin/settings/form', $data);
    }

    public function update()
    {
        // 1. Pastikan request adalah POST
        if (! $this->request->is('post')) {
            return redirect()->to('settings')->with('error', 'Metode request tidak diizinkan.');
        }

        try {
            $post = $this->request->getPost();

            // 2. Proses update melalui service
            $this->service->updateSettings($post);

            // 3. Jika berhasil
            return redirect()
                ->to('settings')
                ->with('success', 'Pengaturan berhasil disimpan');
        } catch (\Exception $e) {
            // 4. Tangkap error dan log jika perlu
            return redirect()
                ->to('settings')
                ->withInput() // Mengembalikan input agar user tidak mengetik ulang
                ->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }
}
