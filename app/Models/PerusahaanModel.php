<?php

namespace App\Models;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $table      = 'perusahaan';
    protected $primaryKey = 'id';

    protected $useTimestamps = true;

    protected $allowedFields = [
        'nama_perusahaan',
        'alamat',
        'telepon',
        'email',
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
                ->like('perusahaan.nama_perusahaan', $request['search']['value'])
                ->orLike('perusahaan.alamat', $request['search']['value'])
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
