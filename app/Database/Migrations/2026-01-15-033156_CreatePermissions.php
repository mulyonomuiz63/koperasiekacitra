<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','auto_increment'=>true],
            'menu_id'=>['type'=>'INT'],
            'can_view'=>['type'=>'BOOLEAN','default'=>0],
            'can_create'=>['type'=>'BOOLEAN','default'=>0],
            'can_update'=>['type'=>'BOOLEAN','default'=>0],
            'can_delete'=>['type'=>'BOOLEAN','default'=>0],
        ]);

        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('menu_id','menus','id','CASCADE','CASCADE');
        $this->forge->createTable('permissions');
    }

    public function down()
    {
        $this->forge->dropTable('permissions');
    }
}
