<?php

namespace App\Models;


class GaleriModel extends BaseModel
{
    protected $table      = 'galeri';
    
    protected $allowedFields = ['title', 'description', 'filename', 'jenis_galeri', 'created_at', 'updated_at'];

    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table);

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('title', $request['search']['value'])
                ->orLike('description', $request['search']['value'])
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
