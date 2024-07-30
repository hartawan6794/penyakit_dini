<?php namespace App\Models;
use CodeIgniter\Model;
 
class MasterModel extends Model
{

    public function countData($nm_table){
        return $this->db->table($nm_table)->select("*")->countAllResults();
    }
}
