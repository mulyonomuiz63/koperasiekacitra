<?php

namespace App\Services\Admin;

use App\Models\MenuModel;

class MenuService
{
    protected $menu;

    public function __construct()
    {
        $this->menu = new MenuModel();
    }

    public function datatable(array $request): array
    {
        $result = $this->menu->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {
            $data[] = [
                'id'         => $row['id'],
                'name'       => $row['name'],
                'url'        => $row['url'],
                'menu_order' => $row['menu_order'],
                'is_active'  => $row['is_active'],
                'parent_id'  => $row['parent_id'],
                'has_child'  => $row['has_child'],
            ];
        }

        return [
            'draw'            => intval($request['draw']),
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ];
    }

    /**
     * Ambil children menu
     */
    public function getChildren(string $parentId): array
    {
        return $this->menu
            ->where('parent_id', $parentId)
            ->orderBy('menu_order', 'ASC')
            ->findAll();
    }
}
