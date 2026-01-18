<?php

namespace App\Controllers\Admin;

use App\Models\SettingModel;
use CodeIgniter\Controller;

class SettingsController extends Controller
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $data['settings'] = $this->settingModel->getAllSettings();
        return view('admin/settings/form', $data);
    }

    public function update()
    {
        $post = $this->request->getPost();

        $data = [];

        foreach ($post as $key => $value) {
            if ($key === csrf_token()) {
                continue;
            }

            // 🔐 SMTP PASSWORD (ENCRYPT)
            if ($key === 'smtp_pass') {
                if (!empty($value)) {
                    $data[$key] = $value;
                }
                continue;
            }

            // 🔢 SMTP PORT (CAST INT)
            if ($key === 'smtp_port') {
                $data[$key] = (int) $value;
                continue;
            }

            $data[$key] = $value;
        }

        // 💾 Simpan ke DB
        foreach ($data as $key => $value) {
            $this->settingModel->saveSetting($key, $value);
        }
        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan');
    }


}
