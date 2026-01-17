<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table      = 'jabatan';
    protected $primaryKey = 'id';

    protected $useTimestamps = true;

    protected $allowedFields = [
        'nama_jabatan',
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
