<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VwDiagnosis extends Migration
{
    public function up()
    {
        $this->db->query("
        CREATE OR REPLACE VIEW vw_diagnosis as 
SELECT r.id, pen.no_pendaftaran, pen.no_rekam_medis, pen.tanggal_daftar, p.nama, concat(p.umur ,' Tahun') umur, k.keluhan,
tp.nama_penyakit, tp.gejala, tp.pengobatan, tp.deskripsi, d.catatan from tbl_riwayat_pasien r 
inner JOIN pendaftaran_pasien pen ON r.pendaftaran_id = pen.id
inner JOIN tbl_pasien p ON r.pasien_id = p.id
INNER JOIN tbl_keluhan k ON k.id = r.keluhan_id
INNER JOIN tbl_diagnosis d ON d.id = r.diagnosis_id
LEFT JOIN tbl_penyakit tp ON tp.id = d.penyakit_id ;
               ");
    }

    public function down()
    {

        $this->db->query("DROP VIEW IF EXISTS vw_diagnosis");
    }
}
