<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblRiwayatPasien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true,
                'constraint' => 11
            ],
            'pendaftaran_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'pasien_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'keluhan_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'diagnosis_id' => [
                'type' => 'INT',
                'unsigned' => true,
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
        $this->forge->addForeignKey('pendaftaran_id', 'pendaftaran_pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pasien_id', 'tbl_pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('keluhan_id', 'tbl_keluhan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('diagnosis_id', 'tbl_diagnosis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_riwayat_pasien');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_riwayat_pasien');
    }
}
