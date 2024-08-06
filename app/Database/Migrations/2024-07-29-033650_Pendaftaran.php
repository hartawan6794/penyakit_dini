<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pendaftaran extends Migration
{
    public function up()
    {
        // Create pivot table for many-to-many relationship between tbl_diagnosis and tbl_obat
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'no_pendaftaran' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'no_rekam_medis' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'pasien_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'keluhan_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'tanggal_daftar' => [
                'type' => 'DATE',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('pasien_id', 'tbl_pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('keluhan_id', 'tbl_keluhan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pendaftaran_pasien');
    }

    public function down()
    {
        $this->forge->dropTable('pendaftaran_pasien');
    }
}
