<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\KeluhanModel;
use App\Models\PasienModel;

class Keluhan extends BaseController
{

	protected $keluhanModel;
	protected $pasienModel;
	protected $validation;

	public function __construct()
	{
		$this->keluhanModel = new KeluhanModel();
		$this->pasienModel = new PasienModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'keluhan',
			'title'     		=> 'Keluhan Pasien'
		];

		return view('keluhan', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->keluhanModel->select()->findAll();

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
				$this->pasienModel->select()->where('id', $value->pasien_id)->first()->nama,
				// $value->pasien_id,
				$value->keluhan,
				$value->tanggal_keluhan,

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

			$data = $this->keluhanModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['pasien_id'] = $this->request->getPost('pasien_id');
		$fields['keluhan'] = $this->request->getPost('keluhan');
		$fields['tanggal_keluhan'] = $this->request->getPost('tanggal_keluhan');
		$fields['created_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'pasien_id' => ['label' => 'Pasien id', 'rules' => 'required|numeric|min_length[0]'],
			'keluhan' => ['label' => 'Keluhan', 'rules' => 'required|min_length[0]'],
			'tanggal_keluhan' => ['label' => 'Tanggal keluhan', 'rules' => 'required|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->keluhanModel->insert($fields)) {

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
		$fields['pasien_id'] = $this->request->getPost('pasien_id');
		$fields['keluhan'] = $this->request->getPost('keluhan');
		$fields['tanggal_keluhan'] = $this->request->getPost('tanggal_keluhan');
		$fields['updated_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'pasien_id' => ['label' => 'Pasien id', 'rules' => 'required|numeric|min_length[0]'],
			'keluhan' => ['label' => 'Keluhan', 'rules' => 'required|min_length[0]'],
			'tanggal_keluhan' => ['label' => 'Tanggal keluhan', 'rules' => 'required|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->keluhanModel->update($fields['id'], $fields)) {

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

			if ($this->keluhanModel->where('id', $id)->delete()) {

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
