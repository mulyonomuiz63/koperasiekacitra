<?php

namespace App\Models;


class LoginAttemptModel extends BaseModel
{
    protected $table      = 'login_attempts';

    protected $allowedFields = [
        'email',
        'ip_address',
        'attempts',
        'last_attempt',
    ];

}
