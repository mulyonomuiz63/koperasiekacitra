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
        $builder = $this->db->table($this->table)
            ->select('
                pegawai.*,
                users.username,
                perusahaan.nama AS perusahaan,
                jabatan.nama AS jabatan
            ')
            ->join('users', 'users.id = pegawai.user_id')
            ->join('perusahaan', 'perusahaan.id = pegawai.perusahaan_id')
            ->join('jabatan', 'jabatan.id = pegawai.jabatan_id');

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('pegawai.nama', $request['search']['value'])
                ->orLike('pegawai.nip', $request['search']['value'])
                ->orLike('users.username', $request['search']['value'])
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
