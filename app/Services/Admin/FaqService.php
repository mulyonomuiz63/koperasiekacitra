<?php

namespace App\Services\Admin;

use App\Models\FaqModel;

class FaqService
{
    protected $faq;

    public function __construct()
    {
        $this->faq = new FaqModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->faq->getDatatable($request);

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
            'question'   => $row['question'],
            'answer'     => word_limiter(strip_tags($row['answer']), 20),
            'is_active'  => $row['is_active'],

            // permission
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }
}
