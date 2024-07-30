<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\MonitoringModel;
use App\Models\PasienModel;

class Monitoring extends BaseController
{

	protected $monitoringModel;
	protected $pasienModel;
	protected $validation;

	public function __construct()
	{
		$this->monitoringModel = new MonitoringModel();
		$this->pasienModel = new PasienModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'monitoring',
			'title'     		=> 'Monitorng Obat'
		];

		return view('monitoring', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->monitoringModel->select()
			->join('tbl_diagnosis dg', 'dg.id = diagnosis_obat.diagnosis_id')
			->join('tbl_obat to', 'to.id = diagnosis_obat.obat_id')
			->findAll();
		$no = 1;
		foreach ($result as $key => $value) {

			$data['data'][$key] = array(
				$no++,
				$this->pasienModel->where('id', $value->pasien_id)->first()->nama,
				$value->nama_obat,
				$value->dosis,
				$value->deskripsi,
				$value->tanggal_diagnosis
			);
		}

		return $this->response->setJSON($data);
	}
}
