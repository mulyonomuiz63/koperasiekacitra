<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaq extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'question' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],

            'answer' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => '1=aktif, 0=nonaktif',
            ],

            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'comment'    => 'Urutan tampil FAQ',
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
        $this->forge->createTable('faq', true);
    }

    public function down()
    {
        $this->forge->dropTable('faq', true);
    }
}
