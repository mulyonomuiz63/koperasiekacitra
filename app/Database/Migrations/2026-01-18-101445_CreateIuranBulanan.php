<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIuranBulanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pegawai_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'bulan' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
            ],
            'tahun' => [
                'type'       => 'SMALLINT',
                'constraint' => 4,
            ],
            'jumlah_iuran' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 250000,
            ],
            'tgl_lunas' => [
                'type' => 'DATE',
            ],
            'pembayaran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['lunas'],
                'default'    => 'lunas',
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
        $this->forge->addUniqueKey(['pegawai_id', 'bulan', 'tahun']);

        $this->forge->addForeignKey('pegawai_id', 'pegawai', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pembayaran_id', 'pembayaran', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('iuran_bulanan');
    }

    public function down()
    {
        $this->forge->dropTable('iuran_bulanan');
    }
}
