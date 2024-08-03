<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{

	protected $table = 'pendaftaran_pasien';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['no_pendaftaran', 'no_rekam_medis', 'pasien_id', 'keluhan_id', 'tanggal_daftar', 'deskripsi', 'id_user', 'created_at', 'updated_at'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;


	public function no_pendaftaran()
	{

		$sql = "SELECT MAX(MID(no_pendaftaran,9,4)) AS no_pendaftaran FROM pendaftaran_pasien WHERE MID(no_pendaftaran,3,6) = DATE_FORMAT(CURDATE(),'%d%m%y')";
		$query = $this->db->query($sql);
		if ($query->getNumRows() > 0) {
			$row = $query->getRow();
			$n = ((int) $row->no_pendaftaran) + 1;
			$no = sprintf("%'.04d", $n);
		} else {
			$no = "0001";
		}
		$no_pendaftaran = "P-" . date('dmy') . $no;
		return $no_pendaftaran;
	}
}
