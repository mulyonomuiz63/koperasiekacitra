<?php

namespace App\Libraries;

use Config\Database;

class IuranService
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function generateBulanan(): int
    {
        $this->db->transBegin();

        try {

            $bulan = (int) date('m');
            $tahun = (int) date('Y');

            // =========================
            // Cegah double generate
            // =========================
            $alreadyGenerated = $this->db->table('iuran_generate_log')
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->where('status', 'SUCCESS')
                ->countAllResults();

            if ($alreadyGenerated > 0) {
                $this->db->transRollback();
                return 0;
            }

            // =========================
            // Ambil setting
            // =========================

            if (setting('status_iuran') !== 'A') {
                $this->db->transRollback();
                return 0;
            }

            // =========================
            // Cek tanggal
            // =========================
            $today      = (int) date('d');
            $tglTagihan = (int) setting('tgl_tagihan_iuran');

            if ($today < $tglTagihan) {
                $this->db->transRollback();
                return 0;
            }

            $nominal = (float) setting('nominal_iuran');

            // =========================
            // Generate iuran
            // =========================
            // 1. Ambil data pegawai yang belum punya tagihan bulan ini
            // Gunakan query select saja untuk menghemat memori
            $pegawai = $this->db->query("
                SELECT p.id, p.user_id FROM pegawai p 
                WHERE p.status = 'A' AND p.status_iuran = 'A'
                AND NOT EXISTS (
                    SELECT 1 FROM iuran_bulanan i 
                    WHERE i.pegawai_id = p.id AND i.bulan = ? AND i.tahun = ?
                )
            ", [$bulan, $tahun])->getResultArray();

            $totalData = count($pegawai);

            if ($totalData > 0) {
                $batch = [];
                $chunkSize = 1000;

                foreach ($pegawai as $index => $p) {
                    $newIdIuran = uuid(); // Generate ID iuran di sini agar bisa dipakai untuk link

                    $batch[] = [
                        'id'            => $newIdIuran,
                        'pegawai_id'    => $p['id'],
                        'bulan'         => $bulan,
                        'tahun'         => $tahun,
                        'jumlah_iuran'  => $nominal,
                        'tgl_tagihan'   => date('Y-m-d'),
                        'status'        => 'B'
                    ];

                    // Karena Link Notif berbeda-beda per orang, kita kirim notif per orang
                    // Tapi agar tidak berat, kita kirim hanya jika user_id ada
                    if (!empty($p['user_id'])) {
                        send_notification_anggota($p['user_id'], [
                            'title'   => 'Tagihan Iuran Bulanan ' . bulanIndo($bulan),
                            'message' => "Tagihan bulan " . bulanIndo($bulan) . " sudah terbit. Silahkan bayar.",
                            'link'    => 'sw-anggota/iuran',
                        ]);
                    }

                    // Insert Batch tetap berjalan per 1000 data agar insert ke tabel iuran cepat
                    if (count($batch) == $chunkSize || ($index + 1) == $totalData) {
                        $this->db->table('iuran_bulanan')->insertBatch($batch);
                        $batch = [];
                    }
                }
            }
            $total = $totalData;

            // =========================
            // Log sukses
            // =========================
            $this->db->table('iuran_generate_log')->insert([
                'id'              => uuid(),
                'bulan'           => $bulan,
                'tahun'           => $tahun,
                'total_pegawai'   => $total,
                'nominal'         => $nominal,
                'status'          => 'SUCCESS',
                'dijalankan_pada' => date('Y-m-d H:i:s'),
            ]);

            $this->db->transCommit();
            return $total;
        } catch (\Throwable $e) {

            $this->db->transRollback();

            $this->db->table('iuran_generate_log')->insert([
                'id'              => uuid(),
                'bulan'           => date('m'),
                'tahun'           => date('Y'),
                'total_pegawai'   => 0,
                'nominal'         => 0,
                'status'          => 'FAILED',
                'keterangan'      => $e->getMessage(),
                'dijalankan_pada' => date('Y-m-d H:i:s'),
            ]);

            return 0;
        }
    }

    public function generateBulananNoLog(): int
    {
        $this->db->transBegin();

        try {

            $bulan = (int) date('m');
            $tahun = (int) date('Y');
            // =========================
            // Ambil setting
            // =========================

            if (setting('status_iuran') !== 'A') {
                $this->db->transRollback();
                return 0;
            }

            // =========================
            // Cek tanggal
            // =========================
            $today      = (int) date('d');
            $tglTagihan = (int) setting('tgl_tagihan_iuran');

            if ($today < $tglTagihan) {
                $this->db->transRollback();
                return 0;
            }

            $nominal = (float) setting('nominal_iuran');

            // =========================
            // Generate iuran
            // =========================
            // 1. Ambil data pegawai yang belum punya tagihan bulan ini
            // Gunakan query select saja untuk menghemat memori
            $pegawai = $this->db->query("
                SELECT p.id, p.user_id FROM pegawai p 
                WHERE p.status = 'A' AND p.status_iuran = 'A'
                AND NOT EXISTS (
                    SELECT 1 FROM iuran_bulanan i 
                    WHERE i.pegawai_id = p.id AND i.bulan = ? AND i.tahun = ?
                )
            ", [$bulan, $tahun])->getResultArray();

            $totalData = count($pegawai);

            if ($totalData > 0) {
                $batch = [];
                $chunkSize = 1000;

                foreach ($pegawai as $index => $p) {
                    $newIdIuran = uuid(); // Generate ID iuran di sini agar bisa dipakai untuk link

                    $batch[] = [
                        'id'            => $newIdIuran,
                        'pegawai_id'    => $p['id'],
                        'bulan'         => $bulan,
                        'tahun'         => $tahun,
                        'jumlah_iuran'  => $nominal,
                        'tgl_tagihan'   => date('Y-m-d'),
                        'status'        => 'B'
                    ];

                    // Karena Link Notif berbeda-beda per orang, kita kirim notif per orang
                    // Tapi agar tidak berat, kita kirim hanya jika user_id ada
                    if (!empty($p['user_id'])) {
                        send_notification_anggota($p['user_id'], [
                            'title'   => 'Tagihan Iuran Bulanan ' . bulanIndo($bulan),
                            'message' => "Tagihan bulan " . bulanIndo($bulan) . " sudah terbit. Silahkan bayar.",
                            'link'    => 'sw-anggota/iuran',
                        ]);
                    }

                    // Insert Batch tetap berjalan per 1000 data agar insert ke tabel iuran cepat
                    if (count($batch) == $chunkSize || ($index + 1) == $totalData) {
                        $this->db->table('iuran_bulanan')->insertBatch($batch);
                        $batch = [];
                    }
                }
            }
            $total = $totalData;
            $this->db->transCommit();
            return $total;
        } catch (\Throwable $e) {

            $this->db->transRollback();
            return 0;
        }
    }
}
