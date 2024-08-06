<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiagnosisModel;
use App\Models\KeluhanModel;
use App\Models\PasienModel;
use App\Models\PendaftaranModel;
use App\Models\PenyakitModel;
use App\Models\RiwayatModel;

class Riwayat extends BaseController
{

	protected $riwayatModel;
	protected $validation;

	public function __construct()
	{
		$this->riwayatModel = new RiwayatModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'riwayat',
			'title'     		=> 'Riwayat Pasien'
		];

		return view('riwayat', $data);
	}

	public function getAll()
	{
		$data['data'] = array();
	
		// Instantiate the models once outside the loop
		$pasienModel = new PasienModel();
		$keluhanModel = new KeluhanModel();
		$diagnosisModel = new DiagnosisModel();
		$pendaftaranModel = new PendaftaranModel();
		$penyakitModel = new PenyakitModel();
	
		$result = $this->riwayatModel->select()->findAll();
	
		$no = 1;
		foreach ($result as $key => $value) {
			$diagnosis = $diagnosisModel->select('penyakit_id, catatan, tanggal_diagnosis')
				->where('id', $value->diagnosis_id)
				->first();
	
			$pendaftaran = $pendaftaranModel->select('no_rekam_medis, tanggal_daftar')
				->where('id', $value->pendaftaran_id)
				->first();
	
			$pasienNama = $pasienModel->select('nama')
				->where('id', $value->pasien_id)
				->first()
				->nama;
	
			$keluhanDeskripsi = $keluhanModel->select('keluhan')
				->where('id', $value->keluhan_id)
				->first()
				->keluhan;
	
			$penyakitNama = $penyakitModel->select('nama_penyakit')
				->where('id', $diagnosis->penyakit_id)
				->first()
				->nama_penyakit;
	
			$data['data'][$key] = array(
				$no++,
				$pendaftaran->no_rekam_medis,
				$pasienNama,
				$keluhanDeskripsi,
				$diagnosis->catatan,
				$penyakitNama,
				$diagnosis->tanggal_diagnosis,
				$pendaftaran->tanggal_daftar,
			);
		}
	
		return $this->response->setJSON($data);
	}
	
	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->riwayatModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['no_rekam_medis'] = $this->request->getPost('no_rekam_medis');
		$fields['pasien_id'] = $this->request->getPost('pasien_id');
		$fields['keluhan_id'] = $this->request->getPost('keluhan_id');
		$fields['diagnosis_id'] = $this->request->getPost('diagnosis_id');
		$fields['tanggal_daftar'] = $this->request->getPost('tanggal_daftar');


		$this->validation->setRules([
			'no_rekam_medis' => ['label' => 'No rekam medis', 'rules' => 'required|min_length[0]|max_length[255]'],
			'pasien_id' => ['label' => 'Pasien id', 'rules' => 'required|numeric|min_length[0]'],
			'keluhan_id' => ['label' => 'Keluhan id', 'rules' => 'required|numeric|min_length[0]'],
			'diagnosis_id' => ['label' => 'Diagnosis id', 'rules' => 'required|numeric|min_length[0]'],
			'tanggal_daftar' => ['label' => 'Tanggal daftar', 'rules' => 'required|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->riwayatModel->insert($fields)) {

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
		$fields['no_rekam_medis'] = $this->request->getPost('no_rekam_medis');
		$fields['pasien_id'] = $this->request->getPost('pasien_id');
		$fields['keluhan_id'] = $this->request->getPost('keluhan_id');
		$fields['diagnosis_id'] = $this->request->getPost('diagnosis_id');
		$fields['tanggal_daftar'] = $this->request->getPost('tanggal_daftar');


		$this->validation->setRules([
			'no_rekam_medis' => ['label' => 'No rekam medis', 'rules' => 'required|min_length[0]|max_length[255]'],
			'pasien_id' => ['label' => 'Pasien id', 'rules' => 'required|numeric|min_length[0]'],
			'keluhan_id' => ['label' => 'Keluhan id', 'rules' => 'required|numeric|min_length[0]'],
			'diagnosis_id' => ['label' => 'Diagnosis id', 'rules' => 'required|numeric|min_length[0]'],
			'tanggal_daftar' => ['label' => 'Tanggal daftar', 'rules' => 'required|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->riwayatModel->update($fields['id'], $fields)) {

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

			if ($this->riwayatModel->where('id', $id)->delete()) {

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
