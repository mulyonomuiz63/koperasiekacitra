<?php
namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $allowedFields = [
        'pegawai_id','bukti_bayar','tgl_bayar','status'
    ];
}
