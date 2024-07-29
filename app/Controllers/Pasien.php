<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PasienModel;

class Pasien extends BaseController
{

	protected $pasienModel;
	protected $validation;

	public function __construct()
	{
		$this->pasienModel = new PasienModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'pasien',
			'title'     		=> 'Daftar Pasien'
		];

		return view('pasien', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->pasienModel->select()->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no++,
				$value->nama,
				$value->umur,
				$value->tanggal_lahir,
				$value->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
				$value->alamat,
				$value->nama_orang_tua,
				$value->no_telepon,

				$ops
			);
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->pasienModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama'] = $this->request->getPost('nama');
		$fields['tanggal_lahir'] = $this->request->getPost('tanggal_lahir');
		$fields['jenis_kelamin'] = $this->request->getPost('jenis_kelamin');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['nama_orang_tua'] = $this->request->getPost('nama_orang_tua');
		$fields['no_telepon'] = $this->request->getPost('no_telepon');
		$fields['created_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'nama' => ['label' => 'Nama', 'rules' => 'required|min_length[0]|max_length[255]'],
			'tanggal_lahir' => ['label' => 'Tanggal lahir', 'rules' => 'required|valid_date|min_length[0]'],
			'jenis_kelamin' => ['label' => 'Jenis kelamin', 'rules' => 'required'],
			'alamat' => ['label' => 'Alamat', 'rules' => 'required|min_length[0]'],
			'nama_orang_tua' => ['label' => 'Nama orang tua', 'rules' => 'required|min_length[0]|max_length[255]'],
			'no_telepon' => ['label' => 'No telepon', 'rules' => 'required|min_length[0]|max_length[15]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->pasienModel->insert($fields)) {

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
		$fields['nama'] = $this->request->getPost('nama');
		$fields['tanggal_lahir'] = $this->request->getPost('tanggal_lahir');
		$fields['jenis_kelamin'] = $this->request->getPost('jenis_kelamin');
		$fields['alamat'] = $this->request->getPost('alamat');
		$fields['nama_orang_tua'] = $this->request->getPost('nama_orang_tua');
		$fields['no_telepon'] = $this->request->getPost('no_telepon');
		$fields['updated_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'nama' => ['label' => 'Nama', 'rules' => 'required|min_length[0]|max_length[255]'],
			'tanggal_lahir' => ['label' => 'Tanggal lahir', 'rules' => 'required|valid_date|min_length[0]'],
			'jenis_kelamin' => ['label' => 'Jenis kelamin', 'rules' => 'required'],
			'alamat' => ['label' => 'Alamat', 'rules' => 'required|min_length[0]'],
			'nama_orang_tua' => ['label' => 'Nama orang tua', 'rules' => 'required|min_length[0]|max_length[255]'],
			'no_telepon' => ['label' => 'No telepon', 'rules' => 'required|min_length[0]|max_length[15]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->pasienModel->update($fields['id'], $fields)) {

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

			if ($this->pasienModel->where('id', $id)->delete()) {

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
