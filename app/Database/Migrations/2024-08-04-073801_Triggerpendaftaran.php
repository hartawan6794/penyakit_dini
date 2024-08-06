<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Triggerpendaftaran extends Migration
{
    public function up()
    {
        // Define the trigger
        $this->db->query("
            CREATE TRIGGER delete_pendaftaran
            BEFORE DELETE ON pendaftaran_pasien
            FOR EACH ROW 
            BEGIN
                DELETE FROM tbl_keluhan WHERE id = OLD.keluhan_id;
            END;
        ");

        // Define the trigger
        $this->db->query("
            CREATE TRIGGER delete_diagnosis
            BEFORE DELETE ON tbl_diagnosis
            FOR EACH ROW 
            BEGIN
                DELETE FROM diagnosis_obat WHERE diagnosis_id = OLD.id;
            END;
        ");
    }

    public function down()
    {
        // Drop the trigger if it exists
        $this->db->query("DROP TRIGGER IF EXISTS delete_pendaftaran;");
        $this->db->query("DROP TRIGGER IF EXISTS delete_diagnosis;");
    }
}
