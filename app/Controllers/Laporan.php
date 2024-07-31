<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiagnosisModel;
use App\Models\PasienModel;
use App\Models\PendaftaranModel;

class Laporan extends BaseController
{
    protected $pendaftaranModel;

    function __construct(){
        $this->pendaftaranModel = new PendaftaranModel();
    }
    public function index(){
        $data = [
			'controller'    	=> 'laporan',
			'title'     		=> 'Laporan Diagnosis Pasien'
		];

		return view('laporan/laporan', $data);
    }

    public function cetak_diagnosis(){
		$db = \Config\Database::connect();
        $tgl_mulai = $this->request->getPost('tgl_mulai');
        $tgl_sampai = $this->request->getPost('tgl_sampai');
        $diagnosis = $db->table('vw_diagnosis')->where([
            'tanggal_daftar >=' => $tgl_mulai,
            'tanggal_daftar <=' => $tgl_sampai
            ])->get()->getResultObject();
        // dd($data);
        $data = [
            'diagnosis' => $diagnosis,
            'tgl_mulai' => $tgl_mulai,
            'tgl_sampai'=> $tgl_sampai
        ];
        return view('laporan/cetak', $data);
    }
}