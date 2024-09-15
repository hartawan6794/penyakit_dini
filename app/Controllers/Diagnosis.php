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
use App\Models\RiwayatModel;
use App\Models\UserModel;

class Diagnosis extends BaseController
{

	protected $diagnosisModel;
	protected $diagnosisObat;
	protected $pendaftaranModel;
	protected $pasienModel;
	protected $keluhanModel;
	protected $penyakitModel;
	protected $riwayatModel;
	protected $obatModel;
	protected $userModel;
	protected $validation;
	protected $db;

	public function __construct()
	{
		$this->diagnosisModel = new DiagnosisModel();
		$this->pendaftaranModel = new PendaftaranModel();
		$this->pasienModel = new PasienModel();
		$this->keluhanModel = new KeluhanModel();
		$this->penyakitModel = new PenyakitModel();
		$this->obatModel = new ObatModel();
		$this->userModel = new UserModel();
		$this->riwayatModel = new RiwayatModel();
		$this->diagnosisObat = new DiagnosisObatModel();
		$this->db = \Config\Database::connect();
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

		// Ambil semua pendaftaran pasien untuk hari ini
		$pendaftaran = $this->pendaftaranModel->select('p.id pasien_id,pendaftaran_pasien.id, p.nama, pendaftaran_pasien.no_pendaftaran')
			->join('tbl_pasien p', 'p.id = pendaftaran_pasien.pasien_id')
			->join('tbl_diagnosis dg', 'dg.pasien_id = p.id and dg.pendaftaran_id = pendaftaran_pasien.id', 'left')
			// ->where('tanggal_daftar', date('Y-m-d'))
			->where('dg.id IS NULL')
			->findAll();

		// dd(count($pasienIds));

		$filteredPasienData = [];

		if (count($pendaftaran) > 0) {
			$filteredPasienData = array_map(function ($item) {
				return [
					'pasien_id' => $item->id . '-' . $item->pasien_id,
					'nama_pasien' => $item->no_pendaftaran . ' - ' . $item->nama,
				];
			}, $pendaftaran);
		}
		// dd($filteredPasienData);


		$data = [
			'controller'    	=> 'diagnosis',
			'title'     		=> 'Form Diagnosis Pasien',
			'pasien'			=> $filteredPasienData,
			'penyakit'			=> $this->penyakitModel->findAll(),
			'obat'				=> $this->obatModel->findAll(),
		];

		return view('diagnosis/form', $data);
	}
	public function getKeluhan()
	{
		$pendaftaran_id = $this->request->getPost('pendaftaran_id');
		return $this->response->setJson(['keluhan' => $this->pendaftaranModel->join('tbl_keluhan tk','tk.id = pendaftaran_pasien.keluhan_id')->where('pendaftaran_pasien.id', $pendaftaran_id)->first()->keluhan]);
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
			$ops .= '<a  class="dropdown-item text-success" onClick="detail(' . $value->id . ')"><i class="fa-solid fa-eye" ></i>   ' .  lang("Detail")  . '</a>';
			$ops .= '<a href="/diagnosis/edit/' . $value->id . '" class="dropdown-item text-info"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no++,
				$this->pasienModel->where('id', $value->pasien_id)->first()->nama,
				$this->penyakitModel->where('id', $value->penyakit_id)->first()->nama_penyakit,
				$this->pendaftaranModel->where('id', $value->pendaftaran_id)->first()->tanggal_daftar,
				$value->tanggal_diagnosis,
				$value->catatan,
				$this->userModel->where('id_user', $value->id_user)->first()->nama,
				// $value->id_user,

				$ops
			);
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		// var_dump($id);die;

		if ($this->validation->check($id, 'required|numeric')) {
			$data = $this->diagnosisModel->detail_diagnosis($id);
			// var_dump($data);die;

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();
		// Set rules untuk validation
		$rules = [
			'id_diagnosis' => 'permit_empty|is_natural',
			'pasien_data' => 'required',
			'keluhan' => 'required|string',
			'penyakit_data' => 'required|is_natural_no_zero',
			'tanggal_diagnosis' => 'required|valid_date',
			'catatan' => 'permit_empty|string',
			'pilih_obat' => 'required|is_array',
			'pilih_obat.*' => 'is_natural_no_zero', // mengatur pilih obat agar tidak kosong
			'nama_obat' => 'required|string',
			'dosis' => 'required|string'
		];

		// mengambil semua request
		$fields = $this->request->getPost();
		// Validate data
		if (!$this->validate($rules)) {
			// jika validation gagal
			$response = [
				'success' => false,
				'messages' => $this->validation->getErrors() // Muncul error di form input
			];
			return $this->response->setJSON($response);
		}

		$obat = $this->request->getPost('pilih_obat');
		$this->db->transStart();

		try {
			// Extract ID from the field
			$id = explode('-', $fields['pasien_data']);
			// ID pendaftaran $id[0], ID pasien $id[1]
			$fieldsDiagnosis = [
				'id' => $this->request->getPost('id_diagnosis'),
				'pendaftaran_id' => $id[0],
				'pasien_id' => $id[1],
				'penyakit_id' => $this->request->getPost('penyakit_data'),
				'tanggal_diagnosis' => $this->request->getPost('tanggal_diagnosis'),
				'catatan' => $this->request->getPost('catatan'),
				'created_at' => date('Y-m-d'),
				'id_user' => session()->get('user_id')
			];

			// var_dump($fieldsDiagnosis);die;
		
			// Insert diagnosis data
			if (!$this->diagnosisModel->insert($fieldsDiagnosis)) {
				throw new \Exception('Failed to insert diagnosis data');
			}
		
			// Get the last inserted ID
			$diagnosisID = $this->diagnosisModel->getInsertID();
		
			// Prepare data for diagnosis_obat
			$obatData = array_map(function ($item) use ($diagnosisID) {
				return [
					'obat_id' => $item,
					'diagnosis_id' => $diagnosisID,
					'created_at' => date('Y-m-d H:i:s')
				];
			}, $obat);
		
			// Insert obat data
			if (!$this->diagnosisObat->insertBatch($obatData)) {
				throw new \Exception('Failed to insert diagnosis_obat data');
			}
		
			// Prepare data for riwayat
			$fieldsRiwayat = [
				'pendaftaran_id' => $id[0],
				'pasien_id' => $id[1],
				'keluhan_id' => $this->pendaftaranModel->where('id', $id[0])->first()->keluhan_id,
				'diagnosis_id' => $diagnosisID,
				'created_at' => date('Y-m-d H:i:s')
			];
		
			// Insert riwayat data
			if (!$this->riwayatModel->insert($fieldsRiwayat)) {
				throw new \Exception('Failed to insert riwayat data');
			}
		
			// Commit transaction
			$this->db->transCommit();
		
			// Prepare success response
			$response = [
				'success' => true,
				'messages' => 'Berhasil menyimpan data'
			];
		} catch (\Exception $e) {
			// Rollback transaction
			$this->db->transRollback();
		
			// Prepare error response
			$response = [
				'success' => false,
				'messages' => 'Data gagal disimpan: ' . $e->getMessage()
			];
		}
		
		// Return response as JSON
		return $this->response->setJSON($response);
		
	}
	public function edit($id_diagnosis)
	{

		//menyiapkan data yang di perlukan
		$data = [
			'controller'    	=> 'diagnosis',
			'title'     		=> 'Form Ubah Diagnosis Pasien',
		];
		$data['diagnosis'] = $this->diagnosisModel->find($id_diagnosis);
		// var_dump($data);die;

		$pendaftaran = $this->pendaftaranModel->where('id', $data['diagnosis']->pendaftaran_id)->findAll();
		$pasienData = array_map(function ($item) {
			return [
				'id' => $item->id .'-'.$item->pasien_id,
				'nama' => $this->pasienModel->where('id', $item->pasien_id)->first()->nama,
			];
		}, $pendaftaran);


		$data['pasien'] = $pasienData;
		$data['penyakit'] = $this->penyakitModel->findAll();
		$data['obat'] = $this->obatModel->findAll();

		$data['diagnosisObat'] = $this->diagnosisObat->where('diagnosis_id', $id_diagnosis)->findAll();
		$data['selectedObatIds'] = array_column($data['diagnosisObat'], 'obat_id');

		// var_dump($data['pasien']);die;

		// dd($data);
		return view('diagnosis/edit', $data);
	}
	public function update()
	{

		$response = array();
		$rules = [
			'id_diagnosis' => 'permit_empty|is_natural',
			// 'pasien_data' => 'required|is_natural_no_zero',
			'keluhan' => 'required|string',
			'penyakit_data' => 'required|is_natural_no_zero',
			'tanggal_diagnosis' => 'required|valid_date',
			'catatan' => 'permit_empty|string',
			'pilih_obat' => 'required|is_array',
			'pilih_obat.*' => 'is_natural_no_zero',
			'nama_obat' => 'required|string',
			'dosis' => 'required|string'
		];

		$fields = $this->request->getPost();

		if (!$this->validate($rules)) {
			$response = [
				'success' => false,
				'messages' => $this->validation->getErrors()
			];
			return $this->response->setJSON($response);
		}

		$obat = $this->request->getPost('pilih_obat');
		$this->db->transStart();

		try {

			$fieldsDiagnosis = [
				'id' => $this->request->getPost('id_diagnosis'),
				// 'pasien_id' => $this->request->getPost('pasien_data'),
				'penyakit_id' => $this->request->getPost('penyakit_data'),
				'tanggal_diagnosis' => $this->request->getPost('tanggal_diagnosis'),
				'catatan' => $this->request->getPost('catatan'),
				'updated_at' => date('Y-m-d'),
				// 'id_user' => session()->get('user_id')
			];

			$this->diagnosisModel->update($fieldsDiagnosis['id'], $fieldsDiagnosis);

			$findCreated_at = $this->diagnosisObat->select('created_at')->where(['diagnosis_id' => $fieldsDiagnosis['id']])->first();
			$created_at = isset($findCreated_at->created_at) ? $findCreated_at->created_at : date('Y-m-d H:i:s');
			$this->db->table('diagnosis_obat')->delete(['diagnosis_id' => $fieldsDiagnosis['id']]);

			$obatData = array_map(function ($item) use ($fieldsDiagnosis, $created_at) {
				return [
					// 'id'	=> '',
					'obat_id' => $item,
					'diagnosis_id' => $fieldsDiagnosis['id'],
					'created_at' => $created_at,
					'updated_at' => date('Y-m-d H:i:s')
				];
			}, $obat);

			// Save Pendaftaran
			$this->diagnosisObat->insertBatch($obatData);

			$this->db->transCommit();

			$response = [
				'success' => true,
				'messages' => 'Berhasil ubah data'
			];
		} catch (\Exception $e) {
			$this->db->transRollback();
			$response = [
				'success' => false,
				'messages' => 'Gagal ubah data: ' . $e->getMessage()
			];
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

	public function obat($id = null)
	{
		$response = array();

		$detail = $this->diagnosisObat->select('to.*')->join('tbl_obat to', 'to.id = diagnosis_obat.obat_id')->where('diagnosis_obat.diagnosis_id', $id)->findAll();
		return $this->response->setJSON($detail);
	}
}
