<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name'=>'Ketua'],
            ['name'=>'Bendahara'],
            ['name'=>'Sekretaris'],
            ['name'=>'Anggota'],
        ];
        $this->db->table('roles')->insertBatch($data);
    }
}
