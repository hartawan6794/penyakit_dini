<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'TINYINT',
                'auto_increment' => true,
                'unsigned' => true,
                'constraint' => 2
            ],
            'nama_menu' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'slug'  => [
                'type'=> 'VARCHAR',
                'constraint' => '255'
            ],
            'content' => [
                'type' => 'TEXT',
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('menu');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}
