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

		if (session()->get('level') == 1)
			$result = $this->userModel->select()->findAll();
		else
			$result = $this->userModel->select()->where('username !=', 'admin')->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= session()->get('level') == 2 ? ($value->status == 10 ? '<a class="dropdown-item text-warning" onClick="active(' . $value->id_user . ', 9)"><i class="fa-solid fa-times"></i>   ' .  lang("Inactive")  . '</a>' : '<a class="dropdown-item text-success" onClick="active(' . $value->id_user . ', 10)"><i class="fa-solid fa-check"></i>   ' .  lang("Aktive")  . '</a>') : '';
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
				$value->level == 1 ? '<span class="level" style=>Admin</span>'  : ($value->level == 2 ? '<span class="level" style=>Kepala Puskesmas</span>' : '<span class="level">Petugas</span>'),
				$value->status == 9 ? '<span class="status inactive" style=>Inaktif</span>' : '<span class="status active">Aktif</span>',
				$value->created_at,
				// $value->updated_at,

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
		$fields['password'] = password_hash('puskes1234', PASSWORD_DEFAULT);
		$fields['nama'] = $this->request->getPost('nama');
		$fields['email'] = $this->request->getPost('email');
		$fields['no_telp'] = $this->request->getPost('no_telp');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['level'] = $this->request->getPost('level');
		$img_user = $this->request->getFile('img_user');
		$fields['status'] = '10';
		$fields['created_at'] = date('Y-m-d H:i:s');

		// var_dump($this->request->getFile('img_user'));die;

		$this->validation->setRules([
			'username' => [
				'label' => 'Username',
				'rules' => 'required|min_length[3]|max_length[255]|is_unique[tbl_user.username]',
				'errors' => [
					'is_unique' => 'Username sudah ada. Masukan username lain.',
				],
			],
			'password' => [
				'label' => 'Password',
				'rules' => 'required|min_length[6]|max_length[255]',
			],
			'nama' => [
				'label' => 'Nama',
				'rules' => 'permit_empty|min_length[0]|max_length[255]',
			],
			'email' => [
				'label' => 'Email',
				'rules' => 'permit_empty|valid_email|min_length[0]|max_length[255]|is_unique[tbl_user.email]',
				'errors' => [
					'is_unique' => 'Email sudah ada. Masukan email lain.',
				],
			],
			'no_telp' => [
				'label' => 'No telp',
				'rules' => 'permit_empty|min_length[0]|max_length[255]',
			],
			'alamat' => [
				'label' => 'Alamat',
				'rules' => 'permit_empty|min_length[0]|max_length[255]',
			],
			'level' => [
				'label' => 'Level',
				'rules' => 'permit_empty|numeric|min_length[0]',
			],
			'img_user' => [
				'label' => 'Img User',
				'rules' => 'uploaded[img_user]|is_image[img_user]|mime_in[img_user,image/jpg,image/jpeg,image/png]|max_size[img_user,2048]',
				'errors' => [
					'max_size' => 'Ukuran file harus maksimal 2Mb',
					'mime_in' => 'Harap masukkan file berupa gambar (jpg, jpeg, png)',
					'is_image' => 'Harap masukkan file berupa gambar'
				]
			],
		]);

		if ($this->validation->run($fields) == FALSE) {
			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); // Show Error in Input Form
		} else {
			if ($img_user->getName() != '') {

				$fileName = 'profile-' . $img_user->getRandomName();
				$fields['img_user'] = $fileName;
				$img_user->move(WRITEPATH . '../public/img/user', $fileName);
			}
			if ($this->userModel->insert($fields)) {
				$response['success'] = true;
				$response['messages'] = "Berhasil menambahkan data";
			} else {
				$response['success'] = false;
				$response['messages'] = "Gagal menambahkan data";
			}
		}

		return $this->response->setJSON($response);
	}
	public function edit($id_user)
	{
		$response = array();

		$fields['username'] = $this->request->getPost('username');
		$fields['nama'] = $this->request->getPost('nama');
		$fields['email'] = $this->request->getPost('email');
		$fields['no_telp'] = $this->request->getPost('no_telp');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['level'] = $this->request->getPost('level');
		$fields['updated_at'] = date('Y-m-d H:i:s');

		$user = $this->userModel->find($id_user);

		$rules = [
			'username' => [
				'label' => 'Username',
				'rules' => 'required|min_length[3]|max_length[255]|is_unique[tbl_user.username,id_user,{id_user}]',
				'errors' => [
					'is_unique' => 'Username sudah ada. Masukan username lain.',
				],
			],
			'nama' => [
				'label' => 'Nama',
				'rules' => 'permit_empty|min_length[0]|max_length[255]',
			],
			'email' => [
				'label' => 'Email',
				'rules' => 'permit_empty|valid_email|min_length[0]|max_length[255]|is_unique[tbl_user.email,id_user,{id_user}]',
				'errors' => [
					'is_unique' => 'Email sudah ada. Masukan email lain.',
				],
			],
			'no_telp' => [
				'label' => 'No telp',
				'rules' => 'permit_empty|min_length[0]|max_length[255]',
			],
			'alamat' => [
				'label' => 'Alamat',
				'rules' => 'permit_empty|min_length[0]|max_length[255]',
			],
			'level' => [
				'label' => 'Level',
				'rules' => 'permit_empty|numeric|min_length[0]',
			],
		];

		$this->validation->setRules($rules);

		if ($this->validation->run($fields) == FALSE) {
			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); // Show Error in Input Form
		} else {
			if ($this->userModel->update($id_user, $fields)) {
				$response['success'] = true;
				$response['messages'] = "Berhasil memperbarui data";
			} else {
				$response['success'] = false;
				$response['messages'] = "Gagal memperbarui data";
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

	public function active()
	{

		// var_dump($this->request->getPost());die;
		$id = $this->request->getPost('id_user');
		$field['status'] = $this->request->getPost('type');

		if ($this->userModel->update($id, $field)) {
			$response['success'] = true;
			$response['messages'] = lang("Berhasil mengubah status");
		} else {

			$response['success'] = false;
			$response['messages'] = lang("Gagal megubah status");
		}


		return $this->response->setJSON($response);
	}
}
