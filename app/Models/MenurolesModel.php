<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class MenurolesModel extends Model {
    
	protected $table = 'menu_roles';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['id_role', 'id_menu'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
	public function checkRoleMenu($id_menu,$id_role){
		return $this->db->table('menu_roles')->where([
				'id_menu' => $id_menu,
				'id_role' => $id_role
			])->get()->getNumRows() > 0 ? true : false;
	}

	public function tambahMenu($id_menu,$id_role){
		return $this->db->table('menu_roles')->insert([
			'id_role' => $id_role,
			'id_menu' => $id_menu,
		]);
	}
	public function hapusMenu($id_menu,$id_role){
		return $this->db->table('menu_roles')->delete([
			'id_role' => $id_role,
			'id_menu' => $id_menu,
		]);
	}
}