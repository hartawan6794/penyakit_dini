<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['9', '10'],
                'default' => '10',
                'comment' => '9: Inaktif, 10: Aktif',
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
        $this->forge->addKey('id_user', TRUE);
        $this->forge->createTable('tbl_user');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_user');
    }
}
