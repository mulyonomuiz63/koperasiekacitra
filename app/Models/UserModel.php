<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = [
        'username','email','password','role_id','status','last_login'
    ];

    protected $returnType = 'array';

    /* ======================
     * DATATABLE SERVER SIDE
     * ====================== */

    public function getDatatable($request)
    {
        $builder = $this->db->table('users m')
            ->select('m.id, m.username, m.email, m.status, roles.name as role_name')
            ->join('roles','roles.id=m.role_id');

        /* SEARCH */
        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $builder->like('m.username', $search);
        }

        /* TOTAL FILTERED */
        $filteredBuilder = clone $builder;
        $recordsFiltered = $filteredBuilder->countAllResults(false);

       

        $builder->orderBy('m.username', 'ASC');
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
