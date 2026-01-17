<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
    protected $table      = 'login_attempts';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email',
        'ip_address',
        'attempts',
        'last_attempt',
    ];

    protected $useTimestamps = false;
}
