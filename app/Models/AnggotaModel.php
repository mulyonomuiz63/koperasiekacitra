<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $allowedFields = [
        'user_id','no_anggota','nama_lengkap','nik',
        'alamat','no_hp','tanggal_gabung','status'
    ];
}
