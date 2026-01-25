<?php

namespace App\Controllers\Admin;

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
            $builder = $db->table('pembayaran');

            // 1. Total Saldo Pendaftaran (Status A)
            $saldo_pendaftaran = $builder->where('status', 'A')
                                        ->where('jenis_transaksi', 'pendaftaran')
                                        ->selectSum('jumlah_bayar') // Ganti 'jumlah_bayar' sesuai nama kolom uang Anda
                                        ->get()->getRow()->jumlah_bayar ?? 0;

            // 2. Total Saldo Bulanan / Iuran (Status A)
            $saldo_bulanan = $builder->where('status', 'A')
                                    ->where('jenis_transaksi', 'bulanan')
                                    ->selectSum('jumlah_bayar')
                                    ->get()->getRow()->jumlah_bayar ?? 0;

            // 3. Akumulasi Total
            $total_saldo = $saldo_pendaftaran + $saldo_bulanan;

            // Mendapatkan bulan dan tahun saat ini
            $bulan_sekarang = date('m');
            $tahun_sekarang = date('Y');

            // 1. Transaksi Bulan Ini (Status P, Semua Jenis Transaksi)
            $trx_bulan_ini = $builder->where('status', 'A')
                                    ->where('MONTH(tgl_bayar)', $bulan_sekarang)
                                    ->where('YEAR(tgl_bayar)', $tahun_sekarang)
                                    ->selectSum('jumlah_bayar')
                                    ->get()->getRow()->jumlah_bayar ?? 0;

            // 2. Transaksi Tahun Ini (Status P, Semua Jenis Transaksi)
            $trx_tahun_ini = $builder->where('status', 'A')
                                    ->where('YEAR(tgl_bayar)', $tahun_sekarang)
                                    ->selectSum('jumlah_bayar')
                                    ->get()->getRow()->jumlah_bayar ?? 0;
            
            $stats = [
                'total_pegawai' => $db->table('pegawai')->where('status','A')->countAllResults(),
                'total_berita'  => $db->table('news')->where('status', 'publish')->countAllResults(),
                'total_galeri'  => $db->table('galeri')->countAllResults(),

                'trx_bulan_ini' => $trx_bulan_ini,
                'trx_tahun_ini' => $trx_tahun_ini,
                // Data Saldo
                'saldo_pendaftaran' => $saldo_pendaftaran,
                'saldo_bulanan'     => $saldo_bulanan,
                'total_saldo'       => $total_saldo,
            ];
            
            // Simpan di cache selama 10 menit (300 detik)
            $cache->save($cacheKey, $stats, 300);
        }

        return view('admin/dashboard', $stats);
    }
}
