<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Ahmad Syahputra',
                'tanggal_lahir' => '2010-05-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Merpati No. 12, Jakarta',
                'nama_orang_tua' => 'Bapak Syahputra',
                'no_telepon' => '081234567890',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama' => 'Siti Aisyah',
                'tanggal_lahir' => '2012-08-23',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jalan Kenanga No. 5, Bandung',
                'nama_orang_tua' => 'Ibu Aisyah',
                'no_telepon' => '081298765432',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama' => 'Budi Santoso',
                'tanggal_lahir' => '2009-11-03',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Melati No. 7, Surabaya',
                'nama_orang_tua' => 'Bapak Santoso',
                'no_telepon' => '081356789012',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('tbl_pasien')->insertBatch($data);
        $this->updateUmur();
    }

    private function updateUmur()
    {
        $this->db->table('tbl_pasien')
                 ->set('umur', 'TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())', false)
                 ->update();
    }
}
