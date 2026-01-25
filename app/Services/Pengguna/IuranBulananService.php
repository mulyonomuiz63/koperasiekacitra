<?php

namespace App\Services\Pengguna;

use App\Models\IuranBulananModel;

class IuranBulananService
{
    protected $iuranBulanan;

    public function __construct()
    {
        $this->iuranBulanan = new IuranBulananModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->iuranBulanan->getDatatable($request);

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
            'pegawai_id'            => $row['pegawai_id'],
            'nama_pegawai'          => $row['nama_pegawai'],
            'tgl_tagihan'          => $row['tgl_tagihan'],
            'bulan_tahun'           => $row['bulan'].' - '.$row['tahun'],
            'bulan'                 => $row['bulan'],
            'tahun'                 => $row['tahun'],
            'jumlah_iuran'          => $row['jumlah_iuran'],
            'status'                => $row['status'],
            
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
        ];
    }
}
