<?php

namespace App\Models;

use CodeIgniter\Model;

class ResetPasswordModel extends Model
{
    protected $table      = 'password_resets';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'token',
        'expired_at'
    ];

    protected $useTimestamps = false;
}
