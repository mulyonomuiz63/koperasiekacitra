<?php
namespace App\Models;


class PembayaranModel extends BaseModel
{
    protected $table = 'pembayaran';
    
    protected $allowedFields = [
        'invoice_no',
        'invoice_at',
        'pegawai_id',
        'jenis_transaksi',
        'bulan',
        'tahun',
        'jumlah_bayar',
        'bukti_bayar',
        'tgl_bayar',
        'nama_pengirim',
        'status',
        'keterangan',
        'catatan_verifikasi',
        'validated_at'
    ];

    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table)
        ->select('pembayaran.id, pembayaran.status, pembayaran.keterangan, pegawai.nama as nama_pegawai')
        ->join('pegawai', 'pegawai.id = pembayaran.pegawai_id')
        ->where('pembayaran.jenis_transaksi', 'pendaftaran');

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('pegawai.nama', $request['search']['value'])
                ->orLike('pembayaran.status', $request['search']['value'])
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

    public function getDatatablePembayaranBulanan($request)
    {
        $builder = $this->db->table($this->table)
        ->select('pembayaran.id, pembayaran.status, pembayaran.keterangan, pembayaran.jenis_transaksi, pembayaran.bulan, pembayaran.tahun, pembayaran.jumlah_bayar, pegawai.nama as nama_pegawai')
        ->join('pegawai', 'pegawai.id = pembayaran.pegawai_id')
        ->where('jenis_transaksi', 'bulanan');

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('pegawai.nama', $request['search']['value'])
                ->orLike('pembayaran.status', $request['search']['value'])
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $builder->orderBy('pembayaran.created_at', 'ASC');
        $builder->orderBy('pembayaran.tahun', 'DESC');
        $builder->orderBy('pembayaran.bulan', 'DESC');

        $builder->limit($request['length'], $request['start']);

        return [
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $builder->get()->getResultArray(),
        ];
    }

    public function getDatatableAnggota($request)
    {
        $builder = $this->db->table($this->table)
        ->select('pembayaran.id, pembayaran.status, pembayaran.keterangan, pembayaran.jenis_transaksi, pembayaran.bulan, pembayaran.tahun, pembayaran.jumlah_bayar, pegawai.nama as nama_pegawai')
        ->join('pegawai', 'pegawai.id = pembayaran.pegawai_id')
        ->where('pegawai.user_id', session()->get('user_id'));

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('pegawai.nama', $request['search']['value'])
                ->orLike('pembayaran.status', $request['search']['value'])
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $builder->orderBy('pembayaran.created_at', 'DESC');

        $builder->limit($request['length'], $request['start']);

        return [
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $builder->get()->getResultArray(),
        ];
    }

    public function getPembayaranWithPegawai($id)
    {
        return $this->db->table($this->table)
            ->select('pembayaran.*, pegawai.nama as nama_pegawai')
            ->join('pegawai', 'pegawai.id=pembayaran.pegawai_id')
            ->where('pembayaran.id', $id)
            ->get()
            ->getRowArray();
    }
}
