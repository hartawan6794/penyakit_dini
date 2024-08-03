<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class PasienModel extends Model {
    
	protected $table = 'tbl_pasien';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'nama_orang_tua','umur', 'no_telepon', 'created_at', 'updated_at'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    

    // Menghitung usia
    public function setUmur()
    {
        $this->db->table($this->table)
                 ->set('umur', 'TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())', false)
                 ->update();
    }
	
}