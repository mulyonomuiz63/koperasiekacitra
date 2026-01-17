<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 'faq';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'question',
        'answer',
        'is_active',
        'sort_order',
    ];

    protected $useTimestamps = true;

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
