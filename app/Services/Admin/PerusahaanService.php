<?php

namespace App\Services\Admin;

use App\Models\PerusahaanModel;

class PerusahaanService
{
    protected $perusahaan;

    public function __construct()
    {
        $this->perusahaan = new PerusahaanModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->perusahaan->getDatatable($request);

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
            'nama_perusahaan'       => $row['nama_perusahaan'],
            'alamat'                => $row['alamat'],
            
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }
}
