<?php

namespace App\Models;


class PegawaiModel extends BaseModel
{
    protected $table      = 'pegawai';

    protected $allowedFields = [
        'user_id',
        'nip',
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'no_hp',
        'perusahaan_id',
        'jabatan_id',
        'tanggal_masuk',
        'status',
        'status_iuran',
        'avatar',
        'angkatan',
    ];

    /* =========================
     * JOIN UNTUK LIST
     * ========================= */
    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table)
            ->select('
                pegawai.id,
                pegawai.nama as namaPegawai,
                jabatan.nama_jabatan,
                pegawai.status_iuran,
                pegawai.status,
            ')
            ->join('users', 'users.id = pegawai.user_id')
            ->join('perusahaan', 'perusahaan.id = pegawai.perusahaan_id')
            ->join('jabatan', 'jabatan.id = pegawai.jabatan_id')
            ->orderBy('pegawai.status','asc');

        // Search
       if ($request['search']['value']) {
            $builder->groupStart()
                ->like('pegawai.nama', $request['search']['value'])
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
