<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run()
    {
        
        // Memanggil seeder setelah membuat tabel
        $seeder = \Config\Database::seeder();
        $seeder->call('RoleSeeder');
        $seeder->call('UserSeeder');
        $seeder->call('PenyakitSeeder');
        $seeder->call('PasienSeeder');
        $seeder->call('ObatSeeder');
        $seeder->call('MenuSeeder');
        $seeder->call('RolesMenuSeeder');
    }
}
