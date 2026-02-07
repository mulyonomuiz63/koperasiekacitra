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
            ->join('pegawai', 'pegawai.id = a.pegawai_id')
            ->where('pegawai.status_iuran', 'A')
            ->where('pegawai.user_id', session()->get('user_id'));

        // 1. Hitung recordsTotal (Total data user ini tanpa filter status)
        $recordsTotal = $builder->countAllResults(false);

        // 2. Terapkan Filter Status jika ada
        if (!empty($request['status'])) {
            if($request['status'] == 'B'){
                $builder->where('a.status !=', 'S');
            }else{
                $builder->where('a.status', $request['status']);
            }
        }

        // Tambahkan filter search bawaan datatable jika anda butuh:
        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $builder->groupStart()
                ->like('pegawai.nama', $search)
                ->orLike('a.tahun', $search)
                ->groupEnd();
        }

        // 3. Hitung recordsFiltered (Total data setelah difilter status/search)
        $recordsFiltered = $builder->countAllResults(false);

        // 4. Baru ambil datanya dengan Select, Order, dan Limit
        $builder->select('a.id, a.status, a.bulan, a.tahun, a.jumlah_iuran, a.tgl_tagihan, a.pegawai_id, pegawai.nama as nama_pegawai')
            ->orderBy('tgl_tagihan', 'desc')
            ->limit($request['length'], $request['start']);

        return [
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $builder->get()->getResultArray(),
        ];
    }
}
