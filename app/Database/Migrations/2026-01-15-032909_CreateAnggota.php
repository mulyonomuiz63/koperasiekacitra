<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnggota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','auto_increment'=>true],
            'user_id'=>['type'=>'INT','null'=>true],
            'no_anggota'=>['type'=>'VARCHAR','constraint'=>30],
            'nama_lengkap'=>['type'=>'VARCHAR','constraint'=>100],
            'nik'=>['type'=>'VARCHAR','constraint'=>20,'null'=>true],
            'alamat'=>['type'=>'TEXT','null'=>true],
            'no_hp'=>['type'=>'VARCHAR','constraint'=>20,'null'=>true],
            'tanggal_gabung'=>['type'=>'DATE','null'=>true],
            'status'=>['type'=>'ENUM','constraint'=>['aktif','nonaktif'],'default'=>'aktif'],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->createTable('anggota');
    }

    public function down()
    {
        $this->forge->dropTable('anggota');
    }
}
