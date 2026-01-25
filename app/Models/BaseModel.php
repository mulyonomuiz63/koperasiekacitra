<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $keyType          = 'string';

    protected $beforeInsert = ['setUUID'];

    protected function setUUID(array $data)
    {
        if (! isset($data['data']['id'])) {
            $data['data']['id'] = uuid(); // 🔥 helper dipakai di sini
        }

        return $data;
    }
}
