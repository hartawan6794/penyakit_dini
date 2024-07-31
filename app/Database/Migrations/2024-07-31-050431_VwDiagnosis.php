<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VwDiagnosis extends Migration
{
    public function up()
    {
        $this->db->query("
        CREATE OR REPLACE VIEW vw_diagnosis as 
select td.id as diagnosis_id, no_pendaftaran, p.nama,umur,tk.keluhan,tp.nama_penyakit, tp.gejala, tp.pengobatan,tp.deskripsi from tbl_diagnosis td inner join pendaftaran_pasien pp on pp.pasien_id = td.pasien_id
inner join tbl_keluhan tk on tk.id = pp.keluhan_id and tk.pasien_id = pp.pasien_id
INNER join tbl_pasien p on p.id = pp.pasien_id
inner join tbl_penyakit tp on tp.id = td.penyakit_id;
               ");
    }

    public function down()
    {

        $this->db->query("DROP VIEW IF EXISTS vw_diagnosis");
    }
}
