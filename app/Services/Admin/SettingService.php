<?php

namespace App\Services\Admin;

use App\Models\SettingModel;

class SettingService
{
    protected $setting;

    public function __construct()
    {
        $this->setting = new SettingModel();
    }

    /**
     * Update semua setting dari form
     */
    public function updateSettings(array $post): void
    {
        // 1. PROSES DATA TEKS (POST)
        foreach ($post as $key => $value) {
            // Skip CSRF token agar tidak tersimpan ke database
            if ($key === csrf_token()) {
                continue;
            }

            // SMTP PASSWORD: Jika input kosong, jangan update (biarkan pakai password lama)
            if ($key === 'smtp_pass') {
                if ($value === '' || $value === null) {
                    continue;
                }
                $this->setting->saveSetting($key, $value);
                continue;
            }

            // SMTP PORT: Pastikan tersimpan sebagai integer
            if ($key === 'smtp_port') {
                $this->setting->saveSetting($key, (int) $value);
                continue;
            }

            if ($key === 'google_maps') {
                // Jika user copy paste seluruh <iframe>, kita ambil src-nya saja
                if (preg_match('/src="([^"]+)"/', $value, $match)) {
                    $value = $match[1];
                }
            }

            // Simpan setting teks umum (Site Name, Email, dll)
            $this->setting->saveSetting($key, $value);
        }

        // 2. PROSES UPLOAD GAMBAR (FILES)
        $request = \Config\Services::request();
        $files = $request->getFiles();

        // Tentukan key apa saja yang merupakan input file gambar
        $imageKeys = ['app_icon', 'logo_perusahaan'];

        foreach ($files as $key => $file) {
            // Hanya proses jika key sesuai dan file valid
            if (in_array($key, $imageKeys) && $file->isValid() && !$file->hasMoved()) {
                
                // Ambil data lama dari database untuk menghapus file fisik yang lama
                // Ini menggunakan model Anda untuk mencari berdasarkan 'key'
                $oldSetting = $this->setting->where('key', $key)->first();
                
                // Generate nama file unik (contoh: 1723456789_a1b2c3.png)
                $newName = $file->getRandomName();
                
                // Pindahkan file ke folder public/uploads/app-icon/
                $file->move(FCPATH . 'uploads/app-icon/', $newName);

                // Simpan nama file baru ke database menggunakan fungsi saveSetting di Model Anda
                $this->setting->saveSetting($key, $newName);

                // Bersihkan file lama di server agar tidak menumpuk (sampah)
                if ($oldSetting && !empty($oldSetting['value'])) {
                    $oldPath = FCPATH . 'uploads/app-icon/' . $oldSetting['value'];
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
            }
        }
    }
}
