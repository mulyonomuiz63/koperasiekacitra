<?php

namespace App\Models;

class EmailLogModel extends BaseModel
{
    protected $table = 'email_logs';
    
    protected $allowedFields = [
        'recipient',
        'subject',
        'status',
        'error_message'
    ];
}
