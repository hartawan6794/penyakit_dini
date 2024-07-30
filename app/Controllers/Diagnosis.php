<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\DiagnosisModel;
use App\Models\DiagnosisObatModel;
use App\Models\KeluhanModel;
use App\Models\ObatModel;
use App\Models\PasienModel;
use App\Models\PendaftaranModel;
use App\Models\PenyakitModel;

class Diagnosis extends BaseController
{

	protected $diagnosisModel;
	protected $diagnosisObat;
	protected $pendaftaranModel;
	protected $pasienModel;
	protected $keluhanModel;
	protected $penyakitModel;
	protected $obatModel;
	protected $validation;

	public function __construct()
	{
		$this->diagnosisModel = new DiagnosisModel();
		$this->pendaftaranModel = new PendaftaranModel();
		$this->pasienModel = new PasienModel();
		$this->keluhanModel = new KeluhanModel();
		$this->penyakitModel = new PenyakitModel();
		$this->obatModel = new ObatModel();
		$this->diagnosisObat = new DiagnosisObatModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'diagnosis',
			'title'     		=> 'Diagnosis Pasien'
		];

		return view('diagnosis/diagnosis', $data);
	}

	public function create()
	{

		$pendaftaran = $this->pendaftaranModel->where('tanggal_daftar', date('Y-m-d'))->findAll();
		$pasienData = array_map(function ($item) {
			return [
				'pasien_id' => $item->pasien_id,
				'nama_pasien' => $this->pasienModel->where('id', $item->pasien_id)->first()->nama,
			];
		}, $pendaftaran);


		$data = [
			'controller'    	=> 'diagnosis',
			'title'     		=> 'Form Diagnosis Pasien',
			'pasien'			=> $pasienData,
			'penyakit'			=> $this->penyakitModel->findAll(),
			'obat'				=> $this->obatModel->findAll(),
		];

		// dd($data);
		return view('diagnosis/form', $data);
	}

	public function getKeluhan()
	{
		$pasien_id = $this->request->getPost('pasien_id');
		return $this->response->setJson(['keluhan' => $this->keluhanModel->where('pasien_id', $pasien_id)->first()->keluhan]);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->diagnosisModel->select()->findAll();

		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a href="/diagnosis/edit/' . $value->id . '" class="dropdown-item text-info"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no++,
				$this->pasienModel->where('id', $value->pasien_id)->first()->nama,
				$this->penyakitModel->where('id', $value->penyakit_id)->first()->nama_penyakit,
				// $value->penyakit_id,
				$value->tanggal_diagnosis,
				$value->catatan,
				$value->id_user,

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

			$data = $this->diagnosisModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$db = \Config\Database::connect();
		$validation = \Config\Services::validation();

		// Set rules for validation
		$rules = [
			'id_diagnosis' => 'permit_empty|is_natural',
			'pasien_data' => 'required|is_natural_no_zero',
			'keluhan' => 'required|string',
			'penyakit_data' => 'required|is_natural_no_zero',
			'tanggal_diagnosis' => 'required|valid_date',
			'catatan' => 'permit_empty|string',
			'pilih_obat' => 'required|is_array',
			'pilih_obat.*' => 'is_natural_no_zero', // Each item in the array should be a non-zero natural number
			'nama_obat' => 'required|string',
			'dosis' => 'required|string'
		];

		// Get all POST data
		$fields = $this->request->getPost();

		// Validate the data
		if (!$this->validate($rules)) {
			// If validation fails
			$response = [
				'success' => false,
				'messages' => $validation->getErrors() // Show errors in input form
			];
			return $this->response->setJSON($response);
		}

		$obat = $this->request->getPost('pilih_obat');

		// Start Transaction
		$db->transStart();

		try {

			$fieldsDiagnosis = [
				'id' => $this->request->getPost('id_diagnosis'),
				'pasien_id' => $this->request->getPost('pasien_data'),
				'penyakit_id' => $this->request->getPost('penyakit_data'),
				'tanggal_diagnosis' => $this->request->getPost('tanggal_diagnosis'),
				'catatan' => $this->request->getPost('catatan'),
				'created_at' => date('Y-m-d'),
				'id_user' => session()->get('user_id')
			];

			$this->diagnosisModel->insert($fieldsDiagnosis);

			$obatData = array_map(function ($item) {
				return [
					// 'id'	=> '',
					'obat_id' => $item,
					'diagnosis_id' => $this->diagnosisModel->getInsertID(),
					'created_at' => date('Y-m-d H:i:s')
				];
			}, $obat);

			// var_dump($obatData);die;
			// Save Pendaftaran
			$this->diagnosisObat->insertBatch($obatData);
			// Commit Transaction
			$db->transCommit();

			$response = [
				'success' => true,
				'messages' => 'Berhasil menyimpan data'
			];
		} catch (\Exception $e) {
			// Rollback Transaction if any error occurs
			$db->transRollback();
			$response = [
				'success' => false,
				'messages' => 'Data gagal disimpan: ' . $e->getMessage()
			];
		}

		return $this->response->setJSON($response);
	}
	public function edit($id_diagnosis)
	{
		$data = [
			'controller'    	=> 'diagnosis',
			'title'     		=> 'Form Diagnosis Pasien',
		];
		$data['diagnosis'] = $this->diagnosisModel->find($id_diagnosis);

		$pendaftaran = $this->pendaftaranModel->where('tanggal_daftar', date('Y-m-d'))->findAll();
		$pasienData = array_map(function ($item) {
			return [
				'id' => $item->pasien_id,
				'nama' => $this->pasienModel->where('id', $item->pasien_id)->first()->nama,
			];
		}, $pendaftaran);

		// Fetch other data needed for form options
		$data['pasien'] = $pasienData;
		$data['penyakit'] = $this->penyakitModel->findAll();
		$data['obat'] = $this->obatModel->findAll();

		// Get the related diagnosis_obat data
		$data['diagnosisObat'] = $this->diagnosisObat->where('diagnosis_id', $id_diagnosis)->findAll();
		$data['selectedObatIds'] = array_column($data['diagnosisObat'], 'obat_id');


		// dd($data);
		return view('diagnosis/edit', $data);
	}

	public function update()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['pasien_id'] = $this->request->getPost('pasien_id');
		$fields['penyakit_id'] = $this->request->getPost('penyakit_id');
		$fields['tanggal_diagnosis'] = $this->request->getPost('tanggal_diagnosis');
		$fields['catatan'] = $this->request->getPost('catatan');
		$fields['id_user'] = $this->request->getPost('id_user');


		$this->validation->setRules([
			'pasien_id' => ['label' => 'Pasien id', 'rules' => 'required|numeric|min_length[0]'],
			'penyakit_id' => ['label' => 'Penyakit id', 'rules' => 'required|numeric|min_length[0]'],
			'tanggal_diagnosis' => ['label' => 'Tanggal diagnosis', 'rules' => 'required|valid_date|min_length[0]'],
			'catatan' => ['label' => 'Catatan', 'rules' => 'required|min_length[0]'],
			'id_user' => ['label' => 'Id user', 'rules' => 'required|numeric|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->diagnosisModel->update($fields['id'], $fields)) {

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

			if ($this->diagnosisModel->where('id', $id)->delete()) {

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
