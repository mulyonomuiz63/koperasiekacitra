<?php

namespace App\Services\Admin;

class HomeService
{
    protected $db;
    protected $cache;

    public function __construct()
    {
        $this->db    = \Config\Database::connect();
        $this->cache = \Config\Services::cache();
    }

    public function getDashboardStats(string $userId): array
    {
        // 2. Jika Cache Kosong, Jalankan Query
        $builder = $this->db->table('pembayaran');
        
        $bulanSekarang = date('m');
        $tahunSekarang = date('Y');

        // Saldo Pendaftaran
        $saldoPendaftaran = $this->getSum($builder, ['status' => 'A', 'jenis_transaksi' => 'pendaftaran']);

        // Saldo Bulanan
        $saldoBulanan = $this->getSum($builder, ['status' => 'A', 'jenis_transaksi' => 'bulanan']);

        // Trx Bulan Ini
        $trxBulanIni = $builder->where('status', 'A')
                               ->where('MONTH(tgl_bayar)', $bulanSekarang)
                               ->where('YEAR(tgl_bayar)', $tahunSekarang)
                               ->selectSum('jumlah_bayar')->get()->getRow()->jumlah_bayar ?? 0;

        // Trx Tahun Ini
        $trxTahunIni = $builder->where('status', 'A')
                               ->where('YEAR(tgl_bayar)', $tahunSekarang)
                               ->selectSum('jumlah_bayar')->get()->getRow()->jumlah_bayar ?? 0;

        $stats = [
            'total_pegawai'     => $this->db->table('pegawai')->where('status', 'A')->countAllResults(),
            'total_berita'      => $this->db->table('news')->where('status', 'publish')->countAllResults(),
            'total_galeri'      => $this->db->table('galeri')->countAllResults(),
            'trx_bulan_ini'     => $trxBulanIni,
            'trx_tahun_ini'     => $trxTahunIni,
            'saldo_pendaftaran' => $saldoPendaftaran,
            'saldo_bulanan'     => $saldoBulanan,
            'total_saldo'       => $saldoPendaftaran + $saldoBulanan,
        ];
        return $stats;
    }

    /**
     * Helper fungsi untuk sum agar kode lebih bersih
     */
    private function getSum($builder, $where)
    {
        return $builder->where($where)
                       ->selectSum('jumlah_bayar')
                       ->get()->getRow()->jumlah_bayar ?? 0;
    }
}