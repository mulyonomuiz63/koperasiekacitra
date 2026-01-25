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
        if (! $this->request->is('post')) {
            return redirect()->back()->with('error', 'Invalid request');
        }

        $post = $this->request->getPost();

        $this->service->updateSettings($post);

        return redirect()
            ->back()
            ->with('success', 'Pengaturan berhasil disimpan');
    }


}
