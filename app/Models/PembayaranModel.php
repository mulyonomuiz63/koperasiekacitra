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

    protected $afterInsert = ['updateSummary'];

    protected function updateSummary(array $data)
    {
        // Hanya jika statusnya 'A' (Approved/Sukses)
        if ($data['data']['status'] === 'A') {
            $pembayaran = $data['data'];
            $db = \Config\Database::connect();
            
            // Ambil user_id dari tabel pegawai (karena di pembayaran hanya ada pegawai_id)
            $pegawai = $db->table('pegawai')->select('user_id')->where('id', $pembayaran['pegawai_id'])->get()->getRow();

            if ($pegawai) {
                $summaryTable = $db->table('saldo_ringkasan');
                
                // Cek apakah baris summary sudah ada
                $exist = $summaryTable->where('user_id', $pegawai->user_id)->countAllResults();

                if ($exist) {
                    // Jika sudah ada, tinggal tambah saldonya (Increment)
                    if ($pembayaran['jenis_transaksi'] === 'pendaftaran') {
                        $summaryTable->where('user_id', $pegawai->user_id)->increment('total_pendaftaran', $pembayaran['jumlah_bayar']);
                    } else {
                        $summaryTable->where('user_id', $pegawai->user_id)->increment('total_iuran', $pembayaran['jumlah_bayar']);
                    }
                } else {
                    // Jika belum ada, buat baris baru
                    $summaryTable->insert([
                        'user_id' => $pegawai->user_id,
                        'total_pendaftaran' => ($pembayaran['jenis_transaksi'] === 'pendaftaran' ? $pembayaran['jumlah_bayar'] : 0),
                        'total_iuran' => ($pembayaran['jenis_transaksi'] === 'bulanan' ? $pembayaran['jumlah_bayar'] : 0),
                    ]);
                }
            }
        }
    }

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
