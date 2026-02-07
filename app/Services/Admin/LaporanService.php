<?php

namespace App\Services\Admin;

use App\Models\IuranBulananModel;
use App\Models\JabatanModel;
use App\Models\PembayaranDetailModel;
use App\Models\PembayaranModel;
use Config\Database;

class LaporanService
{
    protected $jabatan;
    protected $iuranBulanan;
    protected $pembayaranModel;
    protected $detailModel;
    protected $db;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->iuranBulanan = new IuranBulananModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->detailModel = new PembayaranDetailModel();
        $this->db = Database::connect();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->jabatan->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {
            $data[] = $this->mapRow($row, $menuId);
        }

        return [
            'draw'            => (int) $request['draw'],
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ];
    }

    protected function mapRow(array $row, string $menuId): array
    {
        return [
            'id'                    => $row['id'],
            'nama_jabatan'          => $row['nama_jabatan'],
            'keterangan'            => $row['keterangan'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function simpanManual($post)
    {
        $pegawai_id    = $post['pegawai_id'];
        $tahun         = $post['tahun'];
        $bulan_mulai   = (int)$post['bulan_mulai'];
        $bulan_selesai = (int)$post['bulan_selesai'];
        $status        = $post['status'];
        $jumlah        = $post['jumlah'];

        $kirimNotif    = isset($post['kirim_notif']) && $post['kirim_notif'] == '1';

        // 1. Ambil data pegawai untuk mendapatkan user_id
        $pegawai = $this->db->table('pegawai')->where('id', $pegawai_id)->get()->getRow();

        if (!$pegawai) {
            return false; // Pegawai tidak ditemukan
        }

        $this->db->transBegin();

        try {
            $iuranIds = [];

            for ($i = $bulan_mulai; $i <= $bulan_selesai; $i++) {
                $bulanPad = str_pad($i, 2, '0', STR_PAD_LEFT);
                $tgl_tagihan = "{$tahun}-{$bulanPad}-01";

                $exist = $this->db->table('iuran_bulanan')
                    ->where([
                        'pegawai_id' => $pegawai_id,
                        'bulan'      => $i,
                        'tahun'      => $tahun
                    ])->get()->getRow();

                $dataIuran = [
                    'pegawai_id'   => $pegawai_id,
                    'bulan'        => $i,
                    'tahun'        => $tahun,
                    'jumlah_iuran' => $jumlah,
                    'status'       => $status,
                    'tgl_tagihan'  => $tgl_tagihan
                ];

                if ($exist) {
                    $currentIuranId = $exist->id;
                    if ($this->iuranBulanan->update($currentIuranId, $dataIuran) === false) {
                        throw new \Exception('Gagal update iuran bulan ' . $i);
                    }
                } else {
                    $currentIuranId = $this->iuranBulanan->insert($dataIuran);
                    if (!$currentIuranId) {
                        throw new \Exception('Gagal insert iuran bulan ' . $i);
                    }
                }

                // PROSES NOTIFIKASI ATAU TAMPUNG ID
                if ($status === 'S') {
                    $iuranIds[] = $currentIuranId;
                    if ($kirimNotif) {
                        send_notification_anggota($pegawai->user_id, [
                            'title'   => "Iuran " . bulanIndo($i) . " $tahun Terverifikasi",
                            'message' => "Pembayaran iuran bulan " . bulanIndo($i) . " telah dikonfirmasi oleh Admin. Terima kasih.",
                            'link'    => 'sw-anggota/iuran',
                        ]);
                    }
                } else {
                    // Gunakan user_id dari hasil query pegawai di atas
                    // variabel $i digunakan untuk nama bulan (karena loop menggunakan $i)
                    if ($kirimNotif) {
                        send_notification_anggota($pegawai->user_id, [
                            'title'   => 'Tagihan Iuran Bulanan ' . bulanIndo($i),
                            'message' => "Tagihan bulan " . bulanIndo($i) . " sudah terbit. Silahkan bayar.",
                            'link'    => 'sw-anggota/iuran',
                        ]);
                    }
                }
            }

            // 2. PROSES PEMBAYARAN DI LUAR LOOP (Hanya jika status 'S')
            if ($status === 'S' && !empty($iuranIds)) {
                $totalBayar = count($iuranIds) * $jumlah;
                $rangeBulan = ($bulan_mulai == $bulan_selesai) ? (string)$bulan_mulai : "{$bulan_mulai}-{$bulan_selesai}";
                $tgl_sesuai_input = "{$tahun}-" . str_pad($bulan_mulai, 2, '0', STR_PAD_LEFT) . "-01 08:00:00";

                $dataPembayaran = [
                    'invoice_no'      => generateBigInvoiceNumber(),
                    'invoice_at'      => date('Y-m-d H:i:s'),
                    'pegawai_id'      => $pegawai_id,
                    'jenis_transaksi' => 'bulanan',
                    'bulan'           => $rangeBulan,
                    'tahun'           => $tahun,
                    'jumlah_bayar'    => $totalBayar,
                    'tgl_bayar'       => $tgl_sesuai_input,
                    'status'          => 'A',
                    'validated_at'    => date('Y-m-d H:i:s'),
                ];

                $pembayaranUuid = $this->pembayaranModel->insert($dataPembayaran);

                if (!$pembayaranUuid) {
                    throw new \Exception('Gagal insert pembayaran');
                }

                foreach ($iuranIds as $idIuran) {
                    $this->detailModel->insert([
                        'pembayaran_id' => $pembayaranUuid,
                        'iuran_id'      => $idIuran,
                        'jumlah_bayar'  => $jumlah,
                    ]);
                }
            }

            $this->db->transCommit();
            return true;
        } catch (\Exception $e) {
            $this->db->transRollback();
            return false;
        }
    }
}
