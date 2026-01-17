<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSetting extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'null'       => false,
                'comment'    => 'Nama key setting, misal: app_name, app_icon'
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Nilai setting'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('settings', true);
    }

    public function down()
    {
        $this->forge->dropTable('settings', true);
    }
}
