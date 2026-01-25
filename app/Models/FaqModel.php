<?php

namespace App\Models;

class FaqModel extends BaseModel
{
    protected $table            = 'faq';
    
    protected $allowedFields = [
        'question',
        'answer',
        'is_active',
        'sort_order',
    ];


    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table);

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('faq.question', $request['search']['value'])
                ->orLike('faq.answer', $request['search']['value'])
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);

        $builder->limit($request['length'], $request['start']);

        return [
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $builder->get()->getResultArray(),
        ];
    }
}
