<?php

namespace App\Services\Admin;

use App\Models\IuranBulananModel;
use App\Models\JabatanModel;
use Config\Database;

class LaporanService
{
    protected $jabatan;
    protected $iuranBulanan;
    protected $db;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->iuranBulanan = new IuranBulananModel();
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

        $this->db->transStart();

        for ($i = $bulan_mulai; $i <= $bulan_selesai; $i++) {
            // Membuat format tanggal: YYYY-MM-01 (contoh: 2025-03-01)
            // str_pad digunakan agar bulan 1-9 menjadi 01-09
            $bulanPad = str_pad($i, 2, '0', STR_PAD_LEFT);
            $tgl_tagihan = "{$tahun}-{$bulanPad}-01";

            $exist = $this->db->table('iuran_bulanan')
                ->where([
                    'pegawai_id' => $pegawai_id,
                    'bulan'      => $i,
                    'tahun'      => $tahun
                ])->get()->getRow();

            $data = [
                'pegawai_id'   => $pegawai_id,
                'bulan'        => $i,
                'tahun'        => $tahun,
                'jumlah_iuran' => $jumlah,
                'status'       => $status,
                'tgl_tagihan'  => $tgl_tagihan // Tanggal sesuai bulan yang di-loop
            ];

            if ($exist) {
                $this->db->table('iuran_bulanan')
                    ->where('id', $exist->id)
                    ->update($data);
            } else {
                $this->iuranBulanan->insert($data);
            }
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }
}
