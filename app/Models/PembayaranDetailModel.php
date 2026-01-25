<?php
namespace App\Models;


class PembayaranDetailModel extends BaseModel
{
    protected $table = 'pembayaran_detail';
    
    protected $allowedFields = [
        'pembayaran_id',
        'iuran_id',
        'jumlah_bayar',
    ];

    public function getDetailByPembayaran($pembayaranId)
    {
        return $this->db->table($this->table . ' as pd')
            ->join('iuran_bulanan i', 'i.id = pd.iuran_id')
            ->where('pd.pembayaran_id', $pembayaranId)
            ->get()
            ->getResultArray();
    }
}
