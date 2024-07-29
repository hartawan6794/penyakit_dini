<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pasien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'nama_orang_tua' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'umur' => [
                'type' => 'INT',
                'constraint' => 2, // maksimal 99 tahun
            ],
            'no_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
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
        $this->forge->createTable('tbl_pasien');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pasien');
    }
}
