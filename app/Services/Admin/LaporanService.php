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

        // 1. Mulai Transaksi Manual
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
                    // Pastikan update mengembalikan true/false
                    if ($this->iuranBulanan->update($currentIuranId, $dataIuran) === false) {
                        throw new \Exception('Gagal update iuran bulan ' . $i);
                    }
                } else {
                    $currentIuranId = $this->iuranBulanan->insert($dataIuran);
                    if (!$currentIuranId) {
                        throw new \Exception('Gagal insert iuran bulan ' . $i . ': ' . json_encode($this->iuranBulanan->errors()));
                    }
                }

                // Tampung ID untuk proses pembayaran di luar loop
                if ($status === 'S') {
                    $iuranIds[] = $currentIuranId;
                }
            }

            // 2. PROSES PEMBAYARAN DI LUAR LOOP (Hanya sekali saja)
            if ($status === 'S' && !empty($iuranIds)) {
                $totalBayar = count($iuranIds) * $jumlah;
                $rangeBulan = ($bulan_mulai == $bulan_selesai) ? (string)$bulan_mulai : "{$bulan_mulai}-{$bulan_selesai}";
                $tgl_sesuai_input = "{$tahun}-" . str_pad($bulan_mulai, 2, '0', STR_PAD_LEFT) . "-01 08:00:00";

                $dataPembayaran = [
                    'pegawai_id'      => $pegawai_id,
                    'jenis_transaksi' => 'bulanan',
                    'bulan'           => $rangeBulan,
                    'tahun'           => $tahun,
                    'jumlah_bayar'    => $totalBayar,
                    'tgl_bayar'       => $tgl_sesuai_input,
                    'status'          => 'A',
                    'invoice_no'      => generateBigInvoiceNumber(),
                    'invoice_at'      => $tgl_sesuai_input,
                    'validated_at'    => $tgl_sesuai_input,
                ];

                $pembayaranUuid = $this->pembayaranModel->insert($dataPembayaran);

                if (!$pembayaranUuid) {
                    throw new \Exception('Gagal insert pembayaran: ' . json_encode($this->pembayaranModel->errors()));
                }

                // 3. Insert detail untuk semua iuran yang diproses
                foreach ($iuranIds as $idIuran) {
                    $detailInsert = $this->detailModel->insert([
                        'pembayaran_id' => $pembayaranUuid,
                        'iuran_id'      => $idIuran,
                        'jumlah_bayar'  => $jumlah,
                    ]);

                    if (!$detailInsert) {
                        throw new \Exception('Gagal insert detail pembayaran untuk iuran ID: ' . $idIuran);
                    }
                }
            }

            // 4. Final Check: Jika tidak ada exception, Commit!
            $this->db->transCommit();
            return true;
        } catch (\Exception $e) {
            // Jika ada satu saja yang gagal di atas, semuanya dibatalkan
            $this->db->transRollback();
            return false;
        }
    }

    
}
