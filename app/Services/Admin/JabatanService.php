<?php

namespace App\Services\Admin;

use App\Models\JabatanModel;

class JabatanService
{
    protected $jabatan;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
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
}
