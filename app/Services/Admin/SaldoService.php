<?php

namespace App\Services\Admin;

class SaldoService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function syncAllSaldo()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $processed = 0;
        $chunkSize = 1000; // Ambil 1000 data per putaran
        $offset    = 0;

        while (true) {
            // Ambil data pegawai secara bertahap
            $pegawais = $this->db->table('pegawai')
                ->select('id, user_id')
                ->orderBy('id', 'ASC')
                ->limit($chunkSize, $offset)
                ->get()
                ->getResult();

            // Jika tidak ada data lagi, hentikan loop
            if (empty($pegawais)) {
                break;
            }

            foreach ($pegawais as $pegawai) {
                $this->syncOneUser($pegawai->id, $pegawai->user_id);
                $processed++;
            }

            // Tambahkan offset untuk mengambil 1000 data berikutnya
            $offset += $chunkSize;
            
            // Opsional: bersihkan memory cache query builder jika perlu
            $this->db->resetDataCache(); 
        }

        return $processed;
    }

    public function syncOneUser($pegawaiId, $userId)
    {
        // Hitung Saldo Pendaftaran (Status A)
        $pendaftaran = $this->db->table('pembayaran')
            ->where('pegawai_id', $pegawaiId)
            ->where('jenis_transaksi', 'pendaftaran')
            ->where('status', 'A')
            ->selectSum('jumlah_bayar')
            ->get()->getRow()->jumlah_bayar ?? 0;

        // Hitung Saldo Iuran (Status S)
        $iuran = $this->db->table('iuran_bulanan')
            ->where('pegawai_id', $pegawaiId)
            ->where('status', 'S')
            ->selectSum('jumlah_iuran')
            ->get()->getRow()->jumlah_iuran ?? 0;

        // Simpan ke Tabel Ringkasan
        return $this->db->table('saldo_ringkasan')->replace([
            'user_id'           => $userId,
            'total_pendaftaran' => $pendaftaran,
            'total_iuran'       => $iuran,
            'last_update'       => date('Y-m-d H:i:s')
        ]);
    }
}