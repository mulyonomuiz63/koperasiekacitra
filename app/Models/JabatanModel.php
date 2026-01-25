<?php

namespace App\Models;


class JabatanModel extends BaseModel
{
    protected $table      = 'jabatan';
    
    protected $allowedFields = [
        'nama_jabatan',
        'jabatan_key',
        'keterangan',
    ];

    /* =========================
     * JOIN UNTUK LIST
     * ========================= */
    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table);

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('jabatan.nama_jabatan', $request['search']['value'])
                ->orLike('jabatan.keterangan', $request['search']['value'])
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
