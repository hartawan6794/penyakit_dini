<?php

namespace App\Controllers;

use App\Models\KeluhanModel;
use App\Models\MasterModel;
use App\Models\PasienModel;
use App\Models\PendaftaranModel;

class Home extends BaseController
{

    protected $pendaftaranModel;
    protected $pasienModel;
    protected $keluhanModel;

    public function __construct()
    {

        $this->pendaftaranModel = new PendaftaranModel();
        $this->pasienModel = new PasienModel();
        $this->keluhanModel = new KeluhanModel();
    }
    public function index()
    {
        $data = [
            'controller'        => 'home',
            'title'             => 'Dashboard',
        ];

        return view('dashboard', $data);
    }

    public function getAll()
    {
        $response = $data['data'] = array();

        $tanggal = date('Y-m-d');
        $result = $this->pendaftaranModel->select('pendaftaran_pasien.*, d.tanggal_diagnosis')->join('tbl_diagnosis d', 'd.pasien_id = pendaftaran_pasien.pasien_id', 'left')->where('tanggal_daftar', $tanggal)->findAll();
        // var_dump( $result );die;
        $no = 1;
        foreach ($result as $key => $value) {


            $pasien = $this->pasienModel->where('id', $value->pasien_id)->first();
            $keluhan = $this->keluhanModel->where('id', $value->keluhan_id)->first();

            $namaPasien = htmlspecialchars($pasien->nama);
            $umurPasien = htmlspecialchars($pasien->umur) . ' Tahun';
            $keluhanPasien = htmlspecialchars($keluhan->keluhan);
            $tanggalDaftar = htmlspecialchars($value->tanggal_daftar);

            if ($value->tanggal_diagnosis == null) {
                $statusDiagnosis = '<span class="badge bg-danger">Belum diagnosis</span>';
            } else {
                $statusDiagnosis = '<span class="badge bg-success">Sudah diagnosis</span>';
            }

            $data['data'][$key] = array(
                $no++,
                $namaPasien,
                $umurPasien,
                $keluhanPasien,
                $tanggalDaftar,
                $statusDiagnosis,
                // $value->nama_petugas,
            );
        }

        return $this->response->setJSON($data);
    }

    public function getPendaftaranData()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT DATE(tanggal_daftar) as tanggal, COUNT(*) as count FROM pendaftaran_pasien WHERE MONTH(tanggal_daftar) = MONTH(CURRENT_DATE()) AND YEAR(tanggal_daftar) = YEAR(CURRENT_DATE()) GROUP BY DATE(tanggal_daftar)");
        $result = $query->getResultArray();
        return $this->response->setJSON($result);
    }

    public function getDiagnosisData()
    {
        $tanggal = date('Y-m-d');
        $result = $this->pendaftaranModel
            ->select('pendaftaran_pasien.*, d.tanggal_diagnosis')
            ->join('tbl_diagnosis d', 'd.pasien_id = pendaftaran_pasien.pasien_id', 'left')
            ->where('tanggal_daftar', $tanggal)
            ->findAll();

        $diagnosed = 0;
        $notDiagnosed = 0;

        foreach ($result as $row) {
            if (is_null($row->tanggal_diagnosis)) {
                $notDiagnosed++;
            } else {
                $diagnosed++;
            }
        }

        return $this->response->setJSON([
            'diagnosed' => $diagnosed,
            'notDiagnosed' => $notDiagnosed
        ]);
    }
}
