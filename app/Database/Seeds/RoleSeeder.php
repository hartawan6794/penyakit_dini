<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data =
            [
                [
                    'name' => 'Admin',
                    'description' => 'Pengguna ini berperan untuk menambahkan user'
                ],
                [
                    'name' => 'Kepala Puskesmas',
                    'description' => 'Pengguna ini berperan untuk memiliki hak akses penuh pada aplikasi'
                ],
                [
                    'name' => 'Petugas',
                    'description' => 'Pengguna ini berperan untuk pendaftaran pasien dan pemberian dosis obat'
                ],
            ];
            
        // Using Query Builder
        $this->db->table('roles')->insertBatch($data);
    }
}
