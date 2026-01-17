<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $roles = $this->db->table('roles')->get()->getResult();
        $permissions = $this->db->table('permissions')->get()->getResult();

        foreach ($roles as $role) {
            foreach ($permissions as $perm) {

                // Ketua = full akses
                if ($role->name === 'Ketua') {
                    $this->db->table('permissions')
                        ->where('id',$perm->id)
                        ->update([
                            'can_create'=>1,
                            'can_update'=>1,
                            'can_delete'=>1
                        ]);
                }

                // Anggota = view only
                if ($role->name === 'Anggota') {
                    $this->db->table('permissions')
                        ->where('id',$perm->id)
                        ->update([
                            'can_create'=>0,
                            'can_update'=>0,
                            'can_delete'=>0
                        ]);
                }

                $this->db->table('role_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $perm->id
                ]);
            }
        }
    }
}
