<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserPermissions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
            ],
            'menu_id' => [
                'type' => 'INT',
            ],
            'can_view' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'can_create' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'can_update' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'can_delete' => [
                'type'    => 'TINYINT',
                'default' => 0,
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
        $this->forge->addUniqueKey(['user_id', 'menu_id']);
        $this->forge->createTable('user_permissions');
    }

    public function down()
    {
        $this->forge->dropTable('user_permissions');
    }
}

