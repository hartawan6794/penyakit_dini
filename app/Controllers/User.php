<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;

class User extends BaseController
{

	protected $userModel;
	protected $validation;

	public function __construct()
	{
		$this->userModel = new UserModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'user',
			'title'     		=> 'Tabel User'
		];

		return view('user', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->userModel->select()->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_user . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_user . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no++,
				$value->username,
				$value->nama,
				$value->email,
				$value->no_telp,
				$value->alamat,
				$value->level == 1 ? '<span class="level" style=>Admin</span>' : '<span class="level">Petugas</span>',
				$value->status == 9 ? '<span class="status inactive" style=>Inaktif</span>' : '<span class="status active">Aktif</span>',
				$value->created_at,
				$value->updated_at,

				$ops
			);
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id_user');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->userModel->where('id_user', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['username'] = $this->request->getPost('username');
		$fields['password'] = $this->request->getPost('password');
		$fields['nama'] = $this->request->getPost('nama');
		$fields['email'] = $this->request->getPost('email');
		$fields['no_telp'] = $this->request->getPost('no_telp');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['level'] = $this->request->getPost('level');
		$fields['status'] = $this->request->getPost('status');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'username' => ['label' => 'Username', 'rules' => 'required|min_length[0]|max_length[255]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[0]|max_length[255]'],
			'nama' => ['label' => 'Nama', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'email' => ['label' => 'Email', 'rules' => 'permit_empty|valid_email|min_length[0]|max_length[255]'],
			'no_telp' => ['label' => 'No telp', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'alamat' => ['label' => 'Alamat', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'level' => ['label' => 'Level', 'rules' => 'permit_empty|numeric|min_length[0]'],
			'status' => ['label' => 'Status', 'rules' => 'required|min_length[0]|max_length[&#39;9&#39;]'],
			'created_at' => ['label' => 'Dibuat', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Diubah', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->userModel->insert($fields)) {

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

		$fields['id_user'] = $this->request->getPost('id_user');
		$fields['username'] = $this->request->getPost('username');
		$fields['password'] = $this->request->getPost('password');
		$fields['nama'] = $this->request->getPost('nama');
		$fields['email'] = $this->request->getPost('email');
		$fields['no_telp'] = $this->request->getPost('no_telp');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['level'] = $this->request->getPost('level');
		$fields['status'] = $this->request->getPost('status');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'username' => ['label' => 'Username', 'rules' => 'required|min_length[0]|max_length[255]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[0]|max_length[255]'],
			'nama' => ['label' => 'Nama', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'email' => ['label' => 'Email', 'rules' => 'permit_empty|valid_email|min_length[0]|max_length[255]'],
			'no_telp' => ['label' => 'No telp', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'alamat' => ['label' => 'Alamat', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'level' => ['label' => 'Level', 'rules' => 'permit_empty|numeric|min_length[0]'],
			'status' => ['label' => 'Status', 'rules' => 'required|min_length[0]|max_length[&#39;9&#39;]'],
			'created_at' => ['label' => 'Dibuat', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Diubah', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->userModel->update($fields['id_user'], $fields)) {

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

		$id = $this->request->getPost('id_user');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->userModel->where('id_user', $id)->delete()) {

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
