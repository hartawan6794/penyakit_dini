<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PenyakitModel;

class Penyakit extends BaseController
{

	protected $penyakitModel;
	protected $validation;

	public function __construct()
	{
		$this->penyakitModel = new PenyakitModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'penyakit',
			'title'     		=> 'Daftar Penyakit'
		];

		return view('penyakit', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->penyakitModel->select()->findAll();

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
				$value->nama_penyakit,
				$value->deskripsi,
				$value->gejala,
				$value->pengobatan,

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

			$data = $this->penyakitModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_penyakit'] = $this->request->getPost('nama_penyakit');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['gejala'] = $this->request->getPost('gejala');
		$fields['pengobatan'] = $this->request->getPost('pengobatan');
		$fields['created_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'nama_penyakit' => ['label' => 'Nama penyakit', 'rules' => 'required|min_length[0]|max_length[255]'],
			'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required|min_length[0]'],
			'gejala' => ['label' => 'Gejala', 'rules' => 'required|min_length[0]'],
			'pengobatan' => ['label' => 'Pengobatan', 'rules' => 'required|min_length[0]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->penyakitModel->insert($fields)) {

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
		$fields['nama_penyakit'] = $this->request->getPost('nama_penyakit');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['gejala'] = $this->request->getPost('gejala');
		$fields['pengobatan'] = $this->request->getPost('pengobatan');
		$fields['updated_at'] = date('Y-m-d H:i:s');


		$this->validation->setRules([
			'nama_penyakit' => ['label' => 'Nama penyakit', 'rules' => 'required|min_length[0]|max_length[255]'],
			'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required|min_length[0]'],
			'gejala' => ['label' => 'Gejala', 'rules' => 'required|min_length[0]'],
			'pengobatan' => ['label' => 'Pengobatan', 'rules' => 'required|min_length[0]'],
			'created_at' => ['label' => 'Created at', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Updated at', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->penyakitModel->update($fields['id'], $fields)) {

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

			if ($this->penyakitModel->where('id', $id)->delete()) {

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
