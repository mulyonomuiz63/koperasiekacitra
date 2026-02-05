<?php

use App\Models\PegawaiModel;

/**
 * Mendapatkan URL Avatar terbaru berdasarkan User ID
 */
function get_user_avatar($userId = null)
{
    // Jika ID kosong, langsung arahkan ke default
    if (!$userId) return ('uploads/avatars/default.jpg');

    // Gunakan static agar jika dipanggil 10x di 1 halaman, query ke DB cuma 1x
    static $userCache = [];

    if (!isset($userCache[$userId])) {
        $model = new PegawaiModel();
        $userCache[$userId] = $model->where('user_id', $userId)->first();
    }

    $user = $userCache[$userId];
    $path = 'uploads/avatars/';

    // Jika file ada di database dan fisik filenya ada di server
    if ($user && !empty($user['avatar']) && file_exists(FCPATH . $path . $user['avatar'])) {
        // Tambahkan timestamp (?v=...) agar browser tidak menyimpan cache foto lama
        return ($path . $user['avatar']);
    }

    // Default jika tidak ada foto
    return ($path . 'default.jpg');
}