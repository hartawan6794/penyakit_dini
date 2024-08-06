<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keluhan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'keluhan' => [
                'type' => 'TEXT',
            ],
            'tanggal_keluhan' => [
                'type' => 'DATE',
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
        $this->forge->createTable('tbl_keluhan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_keluhan');
    }
}
