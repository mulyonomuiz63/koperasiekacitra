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

    public function saveSetting($key, $value)
    {
        $exists = $this->where('key', $key)->first();

        if ($exists) {
            return $this->where('key', $key)->set([
                'value' => $value
            ])->update();
        }

        return $this->insert([
            'key'   => $key,
            'value' => $value
        ]);
    }

    public function getByKey(string $key)
    {
        return $this->where('key', $key)->first()['value'] ?? null;
    }

    public function getSMTP()
    {
        $keys = [
            'smtp_host',
            'smtp_user',
            'smtp_pass',
            'smtp_port',
            'smtp_crypto',
            'smtp_from_email',
            'smtp_from_name',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $this->getByKey($key);
        }

        return $data;
    }

}
