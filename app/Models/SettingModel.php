<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['key', 'value', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    // Ambil semua settings dalam bentuk key => value
    public function getAllSettings()
    {
        $data = $this->findAll();
        $result = [];
        foreach ($data as $row) {
            $result[$row['key']] = $row['value'];
        }
        return $result;
    }

    // Update atau insert setting
    public function sets($key, $value)
    {
        $existing = $this->where('key', $key)->first();
        if($existing){
            $this->update($existing['id'], ['value' => $value]);
        } else {
            $this->insert(['key' => $key, 'value' => $value]);
        }
    }
}
