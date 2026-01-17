<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','auto_increment'=>true],
            'username' => ['type'=>'VARCHAR','constraint'=>50],
            'email' => ['type'=>'VARCHAR','constraint'=>100],
            'password' => ['type'=>'VARCHAR','constraint'=>255],
            'role_id' => ['type'=>'INT'],
            'status' => ['type'=>'ENUM','constraint'=>['active','inactive','blocked'],'default'=>'active'],
            'last_login' => ['type'=>'DATETIME','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id','roles','id','CASCADE','CASCADE');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
