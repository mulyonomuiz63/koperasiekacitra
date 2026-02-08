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

        // 1. Hitung recordsTotal
        $recordsTotal = $builder->countAllResults(false);

        // 2. Terapkan Filter Status
        $statusFilter = $request['status'] ?? '';
        if (!empty($statusFilter)) {
            if ($statusFilter == 'B') {
                $builder->where('a.status !=', 'S');
            } else {
                $builder->where('a.status', $statusFilter);
            }
        }

        // Filter Search
        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $builder->groupStart()
                ->like('pegawai.nama', $search)
                ->orLike('a.tahun', $search)
                ->groupEnd();
        }

        // 3. Hitung recordsFiltered
        $recordsFiltered = $builder->countAllResults(false);

        // 4. Ambil data dengan OrderBy Kondisional
        $builder->select('a.id, a.status, a.bulan, a.tahun, a.jumlah_iuran, a.tgl_tagihan, a.pegawai_id, pegawai.nama as nama_pegawai');

        if ($statusFilter === 'S') {
            // Jika Lunas: Terbaru di atas (DESC) agar 2027 terlihat duluan
            $builder->orderBy('a.tahun', 'DESC')
                ->orderBy('a.bulan', 'DESC');
        } else {
            // Jika Selain Lunas: Terlama di atas (ASC) agar hutang lama dibayar duluan
            $builder->orderBy('a.tahun', 'ASC')
                ->orderBy('a.bulan', 'ASC');
        }

        // Tambahan created_at sebagai tie-breaker
        $builder->orderBy('a.created_at', 'DESC');

        $builder->limit($request['length'], $request['start']);

        return [
            'draw'            => intval($request['draw'] ?? 0), // Tambahkan draw agar DataTable sinkron
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $builder->get()->getResultArray(),
        ];
    }
}
