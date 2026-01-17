<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasswordResets extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','auto_increment'=>true],
            'user_id'=>['type'=>'INT'],
            'token'=>['type'=>'VARCHAR','constraint'=>255],
            'expired_at'=>['type'=>'DATETIME'],
        ]);

        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->createTable('password_resets');
    }

    public function down()
    {
        $this->forge->dropTable('password_resets');
    }
}
