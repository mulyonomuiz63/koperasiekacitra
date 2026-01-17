<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'parent_id' => [
                'type' => 'INT',
                'null' => true
            ],
            'menu_order' => [
                'type' => 'INT',
                'default' => 0
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
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
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('menus');
    }

    public function down()
    {
        $this->forge->dropTable('menus');
    }
}
