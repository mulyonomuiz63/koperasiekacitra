<?php

namespace App\Models;


class PerusahaanModel extends BaseModel
{
    protected $table      = 'perusahaan';
    

    protected $allowedFields = [
        'nama_perusahaan',
        'alamat',
        'telepon',
        'email',
        'perusahaan_key'
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
