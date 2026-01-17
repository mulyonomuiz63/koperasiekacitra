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
        $request = $this->request;

        $inputs = [
            'app_name'         => $request->getPost('app_name'),
            'app_email'        => $request->getPost('app_email'),
            'app_phone'        => $request->getPost('app_phone'),
            'theme_color'      => $request->getPost('theme_color'),
            'footer_name'      => $request->getPost('footer_name'),
            'footer_address'   => $request->getPost('footer_address'),
            'footer_email'     => $request->getPost('footer_email'),
            'footer_phone'     => $request->getPost('footer_phone'),
            'footer_facebook'  => $request->getPost('footer_facebook'),
            'footer_twitter'   => $request->getPost('footer_twitter'),
            'footer_instagram' => $request->getPost('footer_instagram'),
        ];

        // Upload icon
        $icon = $request->getFile('app_icon');
        if ($icon && $icon->isValid() && !$icon->hasMoved()) {

            $oldIcon = $this->settingModel->get('app_icon');

            if ($oldIcon && file_exists(FCPATH.'uploads/app-icon/'.$oldIcon)) {
                unlink(FCPATH.'uploads/app-icon/'.$oldIcon);
            }

            if (!is_dir(FCPATH.'uploads/app-icon')) {
                mkdir(FCPATH.'uploads/app-icon', 0777, true);
            }

            $iconName = $icon->getRandomName();
            $icon->move(FCPATH.'uploads/app-icon', $iconName);
            $inputs['app_icon'] = $iconName;
        }

        // UPSERT semua setting (INI KUNCINYA)
        foreach ($inputs as $key => $value) {
            $this->settingModel->saveSetting($key, $value ?? '');
        }

        return redirect()->to(base_url('settings'))
            ->with('success', 'Pengaturan berhasil disimpan.');
    }


}
