<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_menu' => 'Dashboard', 'icon' => '<i class="fa-solid fa fa-desktop"></i>', 'slug' => 'home', 'content' => '<li class="nav-item"><a href="<?= base_url("home") ?>" class="nav-link <?= $seg == "home"  || $seg == ""  ? "active" : "" ?> "><i class="fa-solid fa fa-desktop"></i><p>Dashboard</p></a></li>'],
            ['nama_menu' => 'Pendaftaran', 'icon' => '<i class="fa-solid fa-hospital-user"></i>', 'slug' => 'pendaftaran', 'content' => '<li class="nav-item"><a href="<?= base_url("pendaftaran") ?>" class="nav-link <?= $seg == "pendaftaran" ? "active" : "" ?> "><i class="fa-solid fa-hospital-user"></i><p>Pendaftaran</p></a></li>'],
            ['nama_menu' => 'Penyakit', 'icon' => '<i class="fa-solid fa-square-virus"></i>', 'slug' => 'penyakit', 'content' => '<li class="nav-item"><a href="<?= base_url("penyakit") ?>" class="nav-link <?= $seg == "penyakit" ? "active" : "" ?> "><i class="fa-solid fa-square-virus"></i><p>Penyakit</p></a></li>'],
            ['nama_menu' => 'Keluhan', 'icon' => '<i class="fa-solid fa-heart-pulse"></i>', 'slug' => 'keluhan', 'content' => '<li class="nav-item"><a href="<?= base_url("keluhan") ?>" class="nav-link <?= $seg == "keluhan" ? "active" : "" ?> "> <i class="fa-solid fa-heart-pulse"></i><p> Keluhan</p></a></li>'],
            ['nama_menu' => 'Diagnosis Pasien', 'icon' => '<i class="fa-solid fa-stethoscope"></i>', 'slug' => 'diagnosis', 'content' => '<li class="nav-header"> Diagnosis</li><li class="nav-item"><a href="<?= base_url("diagnosis") ?>" class="nav-link <?= $seg == "diagnosis" ? "active" : "" ?> "><i class="fa-solid fa-stethoscope"></i><p> Diagnosis Pasien</p></a></li><li class="nav-item"><a href="<?= base_url("monitoring") ?>" class="nav-link <?= $seg == "monitoring" ? "active" : "" ?> "><i class="fa-solid fa-tv"></i><p> Monitoring Obat</p></a></li>'],
            ['nama_menu' => 'Laporan Diagnosis Pasien', 'icon' => '<i class="fa fa-print" aria-hidden="true"></i>', 'slug' => 'laporan', 'content' => '<li class="nav-header ">Laporan</li><li class="nav-item"><a href="<?= base_url("laporan") ?>" class="nav-link <?= $seg == "laporan" ? "active" : "" ?> "><i class="fa fa-print" aria-hidden="true"></i><p> Laporan Diagnosis</p></a></li>'],
            ['nama_menu' => 'Obat', 'icon' => '<i class="fa-solid fa-pills"></i>', 'slug' => 'obat', 'content' => '<li class="nav-header"> Master</li><li class="nav-item"><a href="<?= base_url("obat") ?>" class="nav-link <?= $seg == "obat" ? "active" : "" ?> "><i class="fa-solid fa-pills"></i><p> Obat</p></a></li>'],
            ['nama_menu' => 'Role', 'icon' => '<i class="fa-solid fa-list"></i>', 'slug' => 'role', 'content' => '<li class="nav-header ">Permissions</li><li class="nav-item"><a href="<?= base_url("roles") ?>" class="nav-link <?= $seg == "roles" ? "active" : "" ?>"><i class="fa-solid fa-list"></i><p>Role</p></a></li></li>'],
            ['nama_menu' => 'User', 'icon' => '<i class="nav-icon fa fa-users"></i>', 'slug' => 'user' , 'content' => '<li class="nav-header ">PENGGUNA</li><li class="nav-item <?= $seg == "user" || $seg == "pasien" ? "menu-open menu-is-open" : "" ?>"><a href="#" class="nav-link "><i class="nav-icon fa fa-users"></i><p> User<i class="end fas fa-angle-left"></i></p></a><ul class="nav nav-treeview"><li class="nav-item"><a href="<?= base_url("user") ?>" class="nav-link <?= $seg == "user" ? "active" : "" ?>"><i class="nav-icon far fa-user"></i><p>Pengguna</p></a></li><li class="nav-item"><a href="<?= base_url("pasien") ?>" class="nav-link <?= $seg == "pasien" ? "active" : "" ?>"><i class="nav-icon fa fa-users-line"></i><p> Pasien</p></a></li></ul></li>'],
        ];

        // Using Query Builder
        $this->db->table('menu')->insertBatch($data);
    }
}
