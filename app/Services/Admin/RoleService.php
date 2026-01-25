<?php

namespace App\Services\Admin;

use App\Models\RoleModel;

class RoleService
{
    protected $role;

    public function __construct()
    {
        $this->role = new RoleModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->role->getDatatable($request);

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
            'id'         => $row['id'],
            'name'       => $row['name'],
            'description' => $row['description'],
            
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }
}
