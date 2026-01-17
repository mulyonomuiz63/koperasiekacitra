<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            // RELASI 1 PEGAWAI = 1 USER
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unique'     => true,
            ],

            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'unique'     => true,
            ],

            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'],
            ],

            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'perusahaan_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],

            'jabatan_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],

            'tanggal_masuk' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'nonaktif', 'resign'],
                'default'    => 'aktif',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'perusahaan_id',
            'perusahaan',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'jabatan_id',
            'jabatan',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->forge->createTable('pegawai', true);
    }

    public function down()
    {
        $this->forge->dropTable('pegawai', true);
    }
}
