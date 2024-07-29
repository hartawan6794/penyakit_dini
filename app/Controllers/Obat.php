<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ObatModel;

class Obat extends BaseController
{

	protected $obatModel;
	protected $validation;

	public function __construct()
	{
		$this->obatModel = new ObatModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'obat',
			'title'     		=> 'Daftar Obat'
		];

		return view('obat', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->obatModel->select()->findAll();

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
				$value->nama_obat,
				$value->deskripsi,
				$value->dosis,

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

			$data = $this->obatModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_obat'] = $this->request->getPost('nama_obat');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['dosis'] = $this->request->getPost('dosis');
		$fields['created_at'] = date('Y-m-d H:i:s');

		$this->validation->setRules([
			'nama_obat' => ['label' => 'Nama obat', 'rules' => 'required|min_length[0]|max_length[255]'],
			'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required|min_length[0]'],
			'dosis' => ['label' => 'Dosis', 'rules' => 'required|min_length[0]|max_length[255]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->obatModel->insert($fields)) {

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
		$fields['nama_obat'] = $this->request->getPost('nama_obat');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['dosis'] = $this->request->getPost('dosis');
		$fields['updated_at'] = date('Y-m-d H:i:s');

		$this->validation->setRules([
			'nama_obat' => ['label' => 'Nama obat', 'rules' => 'required|min_length[0]|max_length[255]'],
			'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required|min_length[0]'],
			'dosis' => ['label' => 'Dosis', 'rules' => 'required|min_length[0]|max_length[255]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->obatModel->update($fields['id'], $fields)) {

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

			if ($this->obatModel->where('id', $id)->delete()) {

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
