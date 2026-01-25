<?php

namespace App\Models;


class ResetPasswordModel extends BaseModel
{
    protected $table      = 'password_resets';
    

    protected $allowedFields = [
        'user_id',
        'token',
        'expired_at'
    ];

    protected $useTimestamps = false;
}
