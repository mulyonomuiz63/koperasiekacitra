<?php

namespace App\Services\Admin;

use App\Models\CategoryModel;
use App\Models\NewsModel;
use App\Models\SettingModel;
use App\Models\TagModel;

class SettingService
{
    protected $setting;
    protected $newsModel;
    protected $catModel;
    protected $tagModel;

    public function __construct()
    {
        $this->setting = new SettingModel();
        $this->newsModel = new NewsModel();
        $this->catModel = new CategoryModel();
        $this->tagModel = new TagModel();
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
        $this->sitemap();
        $this->generateRobots();
    }

    private function sitemap(): void
    {
        // 1. Ambil Data dari Database
        $data = [
            'manualPages' => [
                ['url' => base_url('blog'), 'priority' => '1.0', 'freq' => 'daily'],
                ['url' => base_url('privacy-policy'), 'priority' => '0.3', 'freq' => 'monthly'],
                ['url' => base_url('contact'), 'priority' => '0.5', 'freq' => 'yearly'],
            ],
            'news'       => $this->newsModel->orderBy('created_at', 'DESC')->findAll(),
            'categories' => $this->catModel->findAll(),
            'tags'       => $this->tagModel->findAll()
        ];

        // 2. Render view menjadi string (Bukan mengirim ke browser)
        // Kita simpan ke variabel $xmlString
        $xmlString = view('seo/sitemap', $data);

        // 3. Simpan string tersebut menjadi file fisik sitemap.xml
        write_file(FCPATH . 'sitemap.xml', $xmlString);
    }

    private function generateRobots(): void
    {
        // Ambil data sitemap URL (biasanya dari base_url)
        $sitemapUrl = base_url('sitemap.xml');

        // Susun isi robots.txt
        // User-agent: * berarti aturan ini berlaku untuk semua robot
        $content = "User-agent: *\n";
        
        // Melarang robot mengakses folder sistem atau admin
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /auth/\n";
        $content .= "Disallow: /temp/\n";
        
        // Mengizinkan akses ke folder assets/uploads agar gambar bisa muncul di Google Image
        $content .= "Allow: /uploads/\n";
        $content .= "Allow: /assets/\n";
        
        // Memberitahu lokasi sitemap
        $content .= "\nSitemap: " . $sitemapUrl;

        // Simpan sebagai file fisik robots.txt di folder public
        write_file(FCPATH . 'robots.txt', $content);
    }
}
