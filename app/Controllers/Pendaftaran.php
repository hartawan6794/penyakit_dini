<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KeluhanModel;
use App\Models\PasienModel;
use App\Models\PendaftaranModel;
use App\Models\RiwayatModel;

class Pendaftaran extends BaseController
{

	protected $pendaftaranModel;
	protected $pasienModel;
	protected $keluhanModel;
	protected $validation;

	public function __construct()
	{
		$this->pendaftaranModel = new PendaftaranModel();
		$this->pasienModel = new PasienModel();
		$this->keluhanModel = new KeluhanModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'pendaftaran',
			'title'     		=> 'Pendaftaran Pasien'
		];

		return view('pendaftaran/pendaftaran', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->pendaftaranModel->select('pendaftaran_pasien.*, u.nama as nama_petugas')->join('tbl_user u', 'u.id_user = pendaftaran_pasien.id_user', 'left')->findAll();

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
				$value->no_pendaftaran,
				$value->no_rekam_medis,
				$this->pasienModel->where('id', $value->pasien_id)->first()->nama,
				$this->keluhanModel->where('id', $value->keluhan_id)->first()->keluhan,
				$value->tanggal_daftar,
				$value->deskripsi,
				$value->nama_petugas,
				$ops
			);
		}

		return $this->response->setJSON($data);
	}

	public function getPasien()
	{
		$response = $data['data'] = array();

		// var_dump(date('Y-m-d'));die;
		$result = $this->pasienModel->select('tbl_pasien.*, tp.no_rekam_medis, trp.id as riwayat_id')
			->join('pendaftaran_pasien tp', 'tp.pasien_id = tbl_pasien.id AND tp.tanggal_daftar = CURDATE()', 'left')
			->join('tbl_riwayat_pasien trp' , 'trp.pendaftaran_id = tp.id','left')
			->where('tp.id IS NULL')
			->findAll();


		// var_dump($result);die;
		$no = 1;
		foreach ($result as $key => $value) {
		$cekRm = $this->pendaftaranModel->where('pasien_id', $value->id)->orderBy('tanggal_daftar','desc')->first();
		// var_dump($cekRm);
			$ops = '<button class="btn btn-block btn-info" id="pilih_pasien"
			data-id="' . $value->id . '"
			data-nama="' . $value->nama . '"
			data-alamat ="' . $value->alamat . '"
			data-jns-kelamin = "' . $value->jenis_kelamin . '"
			data-tgl-lahir = "' . $value->tanggal_lahir . '"
			data-nama-orang-tua = "' . $value->nama_orang_tua . '"
			data-umur = "' . $value->umur . '"
			data-no-telp = "' . $value->no_telepon . '"';
			$ops .= isset($cekRm) ? 'data-rm = "'.$cekRm->no_rekam_medis.'"' : '';
			$ops .= isset($cekRm) ? 'data-terakhir-daftar = "'.$cekRm->tanggal_daftar.'"' : '';
			$ops .='<i class="fas fa-check"> Select</i>';

			$data['data'][$key] = array(
				$no,
				$value->nama,
				$value->nama_orang_tua,
				$value->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
				$value->umur . ' Tahun',
				$ops,
			);

			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function create()
	{

		$data = [
			'controller'    	=> 'pendaftaran',
			'title'     		=> 'Pendaftaran Pasien',
		];

		return view('pendaftaran/form', $data);
	}


	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');
		$riwayat = new RiwayatModel();

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->pendaftaranModel->where('id', $id)->first();

			$checkInputRm = $riwayat->join('pendaftaran_pasien pp', 'pp.id = tbl_riwayat_pasien.pendaftaran_id')->first();
			if ($checkInputRm)
				$data->rm = $checkInputRm->no_rekam_medis;
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
			// 'id_pasien' => 'required|is_natural_no_zero',
			// 'id_keluhan' => 'required|is_natural_no_zero',
			'alamat' => 'required|string',
			'jenis_kelamin' => 'required|in_list[L,P]',
			'keluhan' => 'required|string',
			'nama' => 'required|string|max_length[255]',
			'nama_orang_tua' => 'required|string|max_length[255]',
			'no_telepon' => 'required|string|max_length[15]',
			'tanggal_keluhan' => 'required|valid_date',
			'tanggal_lahir' => 'required|valid_date',
			'umur' => 'required|integer',
			'no_rekam_medis' => 'required|integer'
		];

		// Get all POST data
		$fields = $this->request->getPost();

		// Validate the data
		if (!$this->validate($rules)) {
			// If validation fails
			$response = [
				'success' => false,
				'messages' => $validation->getErrors() // Show Error in Input Form
			];
			return $this->response->setJSON($response);
		}

		// Start Transaction
		$db->transStart();

		try {
			$fieldsPendaftaran = [
				'id' => $this->request->getPost('id'),
				'no_pendaftaran' => $this->pendaftaranModel->no_pendaftaran(),
				'tanggal_daftar' => date('Y-m-d H:i:s'),
				'deskripsi' => $fields['deskripsi'],
				'no_rekam_medis' => $fields['no_rekam_medis'],
				'id_user' => session()->get('user_id'),
			];

			if (!empty($fields['id_pasien'])) {
				$fieldsPendaftaran['pasien_id'] = $fields['id_pasien'];
			} else {
				$fieldsPasien = [
					'nama' => $fields['nama'],
					'tanggal_lahir' => $fields['tanggal_lahir'],
					'jenis_kelamin' => $fields['jenis_kelamin'],
					'alamat' => $fields['alamat'],
					'nama_orang_tua' => $fields['nama_orang_tua'],
					'umur' => $fields['umur'],
					'no_telepon' => $fields['no_telepon'],
					'created_at' => date('Y-m-d H:i:s')
				];
				// Save Pasien
				$this->pasienModel->insert($fieldsPasien);

				// Get the inserted pasien_id
				$fieldsPendaftaran['pasien_id'] = $this->pasienModel->getInsertID();
			}

			// Save Keluhan
			$fieldsKeluhan = [
				'keluhan' => $fields['keluhan'],
				'tanggal_keluhan' => $fields['tanggal_keluhan'],
			];

			if (!$this->keluhanModel->insert($fieldsKeluhan))
				$db->transRollback();

			// Get the inserted pendaftaran_id
			$fieldsPendaftaran['keluhan_id'] = $this->keluhanModel->getInsertID();

			// Save Pendaftaran
			if (!$this->pendaftaranModel->insert($fieldsPendaftaran))
				$db->transRollback();
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

	public function edit()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		// $fields['pasien_id'] = $this->request->getPost('pasien_id');
		$fields['no_rekam_medis'] = $this->request->getPost('no_rekam_medis');
		$fields['tanggal_daftar'] = $this->request->getPost('tanggal_daftar');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');


		$this->validation->setRules([
			'tanggal_daftar' => ['label' => 'Tanggal daftar', 'rules' => 'required|valid_date|min_length[0]'],
			'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->pendaftaranModel->update($fields['id'], $fields)) {

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

			if ($this->pendaftaranModel->where('id', $id)->delete()) {

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
