<?php

use App\Models\SettingModel;

if (!function_exists('setting')) {
    /**
     * Ambil setting aplikasi berdasarkan key
     *
     * @param string $key Nama key setting
     * @param mixed $default Nilai default jika key tidak ditemukan
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        static $settings = null;

        // load settings hanya sekali untuk efisiensi
        if ($settings === null) {
            $model = new SettingModel();
            $settings = $model->getAllSettings();
        }

        return $settings[$key] ?? $default;
    }
}
