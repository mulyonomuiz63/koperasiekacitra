<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Ambil role ID
        $roles = $this->db->table('roles')->get()->getResultArray();
        $roleMap = [];

        foreach ($roles as $role) {
            $roleMap[strtolower($role['name'])] = $role['id'];
        }

        // ==============================
        // USERS
        // ==============================
        $users = [
            [
                'username'   => 'ketua',
                'email'      => 'ketua@koperasi.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role_id'    => $roleMap['ketua'],
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username'   => 'bendahara',
                'email'      => 'bendahara@koperasi.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role_id'    => $roleMap['bendahara'],
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username'   => 'sekretaris',
                'email'      => 'sekretaris@koperasi.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role_id'    => $roleMap['sekretaris'],
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username'   => 'anggota',
                'email'      => 'anggota@koperasi.id',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role_id'    => $roleMap['anggota'],
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('users')->insertBatch($users);

        // ==============================
        // ANGGOTA (DATA PRIBADI)
        // ==============================
        $insertedUsers = $this->db->table('users')->get()->getResult();

        foreach ($insertedUsers as $user) {
            $this->db->table('anggota')->insert([
                'user_id'        => $user->id,
                'no_anggota'     => 'AGT-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'nama_lengkap'   => ucfirst($user->username),
                'alamat'         => 'Alamat belum diisi',
                'no_hp'          => '08xxxxxxxxxx',
                'tanggal_gabung' => date('Y-m-d'),
                'status'         => 'aktif',
                'created_at'     => date('Y-m-d H:i:s')
            ]);
        }
    }
}
