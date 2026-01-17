<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
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
