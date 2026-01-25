<?php

namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index(): string
    {
        $cache = \Config\Services::cache();
    
        $userId = session()->get('user_id');
        $cacheKey = 'dashboard_stats_' . $userId;
        // Coba ambil data dari cache dulu
        if (!$stats = $cache->get($cacheKey)) {
            $db = \Config\Database::connect();
            $builder = $db->table('iuran_bulanan')
            ->join('pegawai','pegawai.id=iuran_bulanan.pegawai_id');

            // 2. Total Saldo Bulanan / Iuran (Status A)
            $total_saldo = $builder->where('iuran_bulanan.status', 'S')
                                    ->where('pegawai.id',session()->get('user_id'))
                                    ->selectSum('jumlah_iuran')
                                    ->get()->getRow()->jumlah_iuran ?? 0;

      
            
            $stats = [
                'total_pegawai' => $db->table('pegawai')->where('status','A')->countAllResults(),
                'total_berita'  => $db->table('news')->where('status', 'publish')->countAllResults(),
                'total_galeri'  => $db->table('galeri')->countAllResults(),

                // Data Saldo
                'total_saldo'     => $total_saldo,
            ];
            
            // Simpan di cache selama 10 menit (300 detik)
            $cache->save($cacheKey, $stats, 300);
        }

        return view('anggota/dashboard', $stats);
    }
}
