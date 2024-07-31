<?php namespace App\Models;
use CodeIgniter\Model;
 
class MasterModel extends Model
{

    public function countData($nm_table){
        return $this->db->table($nm_table)->select("*")->countAllResults();
    }

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
