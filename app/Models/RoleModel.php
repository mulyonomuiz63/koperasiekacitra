<?php

namespace App\Models;


class RoleModel extends BaseModel
{
    protected $table      = 'roles';
    

    protected $allowedFields = [
        'name',
        'role_key',
        'description'
    ];

    protected $returnType = 'array';

    /* ======================
     * DATATABLE SERVER SIDE
     * ====================== */

    public function getDatatable($request)
    {
        $builder = $this->db->table('roles m');

        /* SEARCH */
        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $builder->like('m.name', $search);
        }

        /* TOTAL FILTERED */
        $filteredBuilder = clone $builder;
        $recordsFiltered = $filteredBuilder->countAllResults(false);

       

        $builder->orderBy('m.name', 'ASC');

        if ($request['length'] != -1) {
            $builder->limit($request['length'], $request['start']);
        }

        return [
            'data'            => $builder->get()->getResultArray(),
            'recordsTotal'    => $this->countAllResults(),
            'recordsFiltered' => $recordsFiltered
        ];
    }
}
