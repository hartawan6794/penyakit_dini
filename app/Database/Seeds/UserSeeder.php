<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_user' => 1,
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'nama' => 'Admin',
            'email' => 'admin@example.com',
            'no_telp' => '1234567890',
            'alamat' => 'Jl. Contoh No. 1',
            'id_role' => 1,
            'status' => '10' // 10: Aktif
        ];

        // Using Query Builder
        $this->db->table('tbl_user')->insert($data);
    }
}
