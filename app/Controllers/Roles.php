<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\MenuModel;
use App\Models\RolesModel;

class Roles extends BaseController
{

	protected $rolesModel;
	protected $validation;

	public function __construct()
	{
		$this->rolesModel = new RolesModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$model = new MenuModel();
		$result = $model->select()->findAll();

		$data = [
			'controller'    	=> 'roles',
			'title'     		=> 'roles',
			'menus'				=> $result
		];

		return view('roles', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->rolesModel->select()->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-success" onClick="set(' . $value->id . ')"><i class="fa-solid fa-file-signature"></i>   ' .  lang("Set Menu")  . '</a>';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no++,
				$value->name,
				$value->description,

				$ops
			);
		}

		return $this->response->setJSON($data);
	}

	public function getMenu(){
		$response = $data['data'] = array();

		$model = new MenuModel();
		$result = $model->select()->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			// $ops = '<div class="btn-group">';
			// $ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			// $ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			// $ops .= '<div class="dropdown-menu">';
			// $ops .= '<a class="dropdown-item text-success" onClick="set(' . $value->id . ')"><i class="fa-solid fa-file-signature"></i>   ' .  lang("Set Menu")  . '</a>';
			// $ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			// $ops .= '<div class="dropdown-divider"></div>';
			// $ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			// $ops .= '</div></div>';

			$data['data'][$key] = array(
				$no++,
				$value->nama_menu,
				'checkbox',

				// $ops
			);
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->rolesModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['name'] = $this->request->getPost('name');
		$fields['description'] = $this->request->getPost('description');


		$this->validation->setRules([
			'name' => ['label' => 'Name', 'rules' => 'required|min_length[0]|max_length[255]'],
			'description' => ['label' => 'Description', 'rules' => 'permit_empty|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->rolesModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menambahkan data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menambahkan data");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['name'] = $this->request->getPost('name');
		$fields['description'] = $this->request->getPost('description');


		$this->validation->setRules([
			'name' => ['label' => 'Name', 'rules' => 'required|min_length[0]|max_length[255]'],
			'description' => ['label' => 'Description', 'rules' => 'permit_empty|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->rolesModel->update($fields['id'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil perbarui data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal Perbarui data");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->rolesModel->where('id', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menghapus data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menghapus data");
			}
		}

		return $this->response->setJSON($response);
	}
}
