<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailLogModel extends Model
{
    protected $table = 'email_logs';
    protected $allowedFields = [
        'recipient',
        'subject',
        'status',
        'error_message'
    ];
}
