<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuRole extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true,
                'constraint' => 11
            ],
            'id_role' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_menu' => [
                'type' => 'TINYINT',
                'unsigned' => true,
                'constraint' => 2
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_role', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_menu', 'menu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_roles');
    }

    public function down()
    {
        $this->forge->dropTable('menu_roles');
    }
}
