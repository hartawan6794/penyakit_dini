<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class DiagnosisModel extends Model {
    
	protected $table = 'tbl_diagnosis';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['pendaftaran_id','pasien_id', 'penyakit_id', 'tanggal_diagnosis', 'catatan', 'id_user'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
	public function detail_diagnosis($kondisi)
	{
		$sql = "SELECT * FROM vw_diagnosis WHERE diagnosis_id = '$kondisi'";
		$query = $this->db->query($sql);
		return $query->getRow();;
	}
}