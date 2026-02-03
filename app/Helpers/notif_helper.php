<?php

/**
 * Fungsi untuk mengirim notifikasi ke user tertentu atau berdasarkan role
 */
if (!function_exists('send_notification')) {
    function send_notification($target, $data = [])
    {
        $db = \Config\Database::connect();

        // Data dasar notifikasi
        $insertData = [
            'id'         => uuid(),
            'title'      => $data['title'] ?? 'Pemberitahuan Baru',
            'message'    => $data['message'] ?? '',
            'link'       => $data['link'] ?? '#',
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // LOGIKA 1: Jika target adalah Role (String)
        if (is_string($target)) {
            $users = $db->table('users')
                ->select('users.id')
                ->join('roles', 'roles.id = users.role_id')
                ->where('roles.name', $target)
                ->get()->getResultArray();

            if (!empty($users)) {
                $batchData = [];
                foreach ($users as $u) {
                    $temp = $insertData;
                    $temp['user_id'] = $u['id'];
                    $batchData[] = $temp;
                }
                return $db->table('notifications')->insertBatch($batchData);
            }
        }
        return false;
    }
}

if (!function_exists('send_notification_anggota')) {
    /**
     * Helper untuk mengirim notifikasi
     * @param string|array $target ID User atau Array ID User
     * @param array $data ['title', 'message', 'link']
     */
    function send_notification_anggota($target, $data = [])
    {
        if (empty($target)) return false; // Tambahkan proteksi jika target kosong

        $db = \Config\Database::connect();

        $baseData = [
            'title'      => $data['title'] ?? 'Pemberitahuan Baru',
            'message'    => $data['message'] ?? '',
            'link'       => $data['link'] ?? '#',
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (is_array($target)) {
            $batchData = [];
            foreach ($target as $userId) {
                $batchData[] = array_merge($baseData, [
                    'id'      => uuid(),
                    'user_id' => $userId
                ]);
            }
            // Menggunakan insertBatch untuk performa tinggi (hanya 1 query ke database)
            return $db->table('notifications')->insertBatch($batchData);
        }

        // Target Tunggal
        $insertData = array_merge($baseData, [
            'id'      => uuid(),
            'user_id' => $target
        ]);

        return $db->table('notifications')->insert($insertData);
    }
}

if (!function_exists('time_ago')) {
    function time_ago($datetime)
    {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 1) return 'Baru saja';

        $intervals = [
            31536000 => 'tahun',
            2592000  => 'bulan',
            604800   => 'minggu',
            86400    => 'hari',
            3600     => 'jam',
            60       => 'menit',
            1        => 'detik'
        ];

        foreach ($intervals as $secs => $str) {
            $d = $diff / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str . ' yang lalu';
            }
        }
    }
}
