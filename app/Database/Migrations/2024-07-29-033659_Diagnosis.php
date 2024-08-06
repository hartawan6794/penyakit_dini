<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Diagnosis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'pendaftaran_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'pasien_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'penyakit_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'tanggal_diagnosis' => [
                'type' => 'DATE',
            ],
            'catatan' => [
                'type' => 'TEXT',
            ],
            'id_user' => [
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
        $this->forge->addForeignKey('pasien_id', 'tbl_pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('penyakit_id', 'tbl_penyakit', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pendaftaran_id', 'pendaftaran_pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_diagnosis');

        // Create pivot table for many-to-many relationship between tbl_diagnosis and tbl_obat
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'diagnosis_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'obat_id' => [
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
        $this->forge->addForeignKey('diagnosis_id', 'tbl_diagnosis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('obat_id', 'tbl_obat', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('diagnosis_obat');
    }

    public function down()
    {
        $this->forge->dropTable('diagnosis_obat');
        $this->forge->dropTable('tbl_diagnosis');
    }
}
