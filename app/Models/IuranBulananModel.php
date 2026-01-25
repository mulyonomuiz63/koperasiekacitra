<?php

namespace App\Models;


class IuranBulananModel extends BaseModel
{
    protected $table      = 'iuran_bulanan';
    
    protected $allowedFields = [
        'pegawai_id',
        'bulan',
        'tahun',
        'jumlah_iuran',
        'tgl_tagihan',
        'status',
    ];

    /* =========================
     * JOIN UNTUK LIST
     * ========================= */
    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table . ' as a')
        ->select('a.id, a.status, a.bulan, a.tahun, a.jumlah_iuran, a.tgl_tagihan, a.pegawai_id, pegawai.nama as nama_pegawai')
        ->join('pegawai', 'pegawai.id = a.pegawai_id')
        ->where('pegawai.status_iuran', 'A')
        ->where('pegawai.user_id', session()->get('user_id'));

   
        $total = $builder->countAllResults(false);

        $builder->limit($request['length'], $request['start']);

        return [
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $builder->get()->getResultArray(),
        ];
    }
}
