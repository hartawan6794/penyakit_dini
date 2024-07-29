<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenyakitSeeder extends Seeder
{
    public function run()
    {
        
        $data = [
            [
                'nama_penyakit' => 'Influenza',
                'deskripsi' => 'Penyakit menular yang disebabkan oleh virus influenza.',
                'gejala' => 'Demam, batuk, sakit tenggorokan, nyeri otot, sakit kepala, dan lelah.',
                'pengobatan' => 'Istirahat, minum banyak cairan, obat pereda nyeri.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_penyakit' => 'Cacar Air',
                'deskripsi' => 'Penyakit menular yang disebabkan oleh virus varicella-zoster.',
                'gejala' => 'Ruam kulit, lepuhan gatal, demam.',
                'pengobatan' => 'Istirahat, menjaga kebersihan, obat pereda gatal.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_penyakit' => 'Asma',
                'deskripsi' => 'Kondisi kronis yang mempengaruhi saluran pernapasan.',
                'gejala' => 'Sesak napas, batuk, mengi.',
                'pengobatan' => 'Inhaler bronkodilator, kontrol lingkungan.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('tbl_penyakit')->insertBatch($data);
    }
}
