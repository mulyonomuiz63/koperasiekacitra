<?php

namespace App\Services\Pengguna;

class HomeService
{
    protected $db;
    protected $cache;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->cache = \Config\Services::cache();
    }

    /**
     * Mendapatkan statistik dashboard dengan optimasi cache
     */
    public function getAggregatedStats(string $userId): array
    {
        $cacheKey = 'dashboard_stats_' . $userId;

        // 1. Coba ambil dari Cache
        if (!$stats = $this->cache->get($cacheKey)) {
            $stats = [
                'total_pegawai' => $this->db->table('pegawai')->where('status', 'A')->countAllResults(),
                'total_berita'  => $this->db->table('news')->where('status', 'publish')->countAllResults(),
                'total_galeri'  => $this->db->table('galeri')->countAllResults(),
            ];

            // Simpan ke cache selama 5 menit
            $this->cache->save($cacheKey, $stats, 300);
        }

        // 2. Data Real-time (Saldo biasanya tidak di-cache agar user langsung melihat update)
        $stats['total_saldo'] = $this->db->table('iuran_bulanan')
            ->join('pegawai', 'pegawai.id = iuran_bulanan.pegawai_id')
            ->where('iuran_bulanan.status', 'S')
            ->where('pegawai.user_id', $userId)
            ->selectSum('iuran_bulanan.jumlah_iuran')
            ->get()->getRow()->jumlah_iuran ?? 0;

        return $stats;
    }
}