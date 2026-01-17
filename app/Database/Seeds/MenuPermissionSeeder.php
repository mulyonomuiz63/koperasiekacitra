<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuPermissionSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            ['name'=>'Dashboard','slug'=>'dashboard','icon'=>'fa-home'],
            ['name'=>'Anggota','slug'=>'anggota','icon'=>'fa-users'],
            ['name'=>'Simpanan','slug'=>'simpanan','icon'=>'fa-wallet'],
            ['name'=>'Pinjaman','slug'=>'pinjaman','icon'=>'fa-money-bill'],
            ['name'=>'Laporan','slug'=>'laporan','icon'=>'fa-file'],
            ['name'=>'Pengaturan','slug'=>'pengaturan','icon'=>'fa-cog'],
        ];

        foreach ($menus as $menu) {
            $this->db->table('menus')->insert($menu);
            $menuId = $this->db->insertID();

            // default permission
            $this->db->table('permissions')->insert([
                'menu_id' => $menuId,
                'can_view' => 1,
                'can_create' => 0,
                'can_update' => 0,
                'can_delete' => 0,
            ]);
        }
    }
}
