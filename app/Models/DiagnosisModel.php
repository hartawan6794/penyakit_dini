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
	
	public function detail_diagnosis($id_diagnosis)
	{

		$no_pendaftaran = $this->db->table('tbl_diagnosis td')
		->select('no_pendaftaran')
		->join('pendaftaran_pasien pp', 'td.pendaftaran_id = pp.id', 'left')->where(
			"td.id", $id_diagnosis
		)->get()->getFirstRow()->no_pendaftaran;

		$sql = "SELECT * FROM vw_diagnosis WHERE no_pendaftaran = '$no_pendaftaran'";
		$query = $this->db->query($sql);
		return $query->getRow();;
	}
}