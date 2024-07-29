<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_obat' => 'Paracetamol',
                'deskripsi' => 'Obat untuk menurunkan demam dan mengurangi rasa sakit.',
                'dosis' => '500 mg, 3 kali sehari',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'deskripsi' => 'Antibiotik untuk mengobati berbagai infeksi bakteri.',
                'dosis' => '250 mg, 3 kali sehari',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'deskripsi' => 'Obat untuk mengurangi rasa sakit, peradangan, dan demam.',
                'dosis' => '200 mg, 3 kali sehari',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('tbl_obat')->insertBatch($data);
    }
}
