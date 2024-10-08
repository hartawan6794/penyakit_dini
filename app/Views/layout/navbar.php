<?php helper('settings');

use App\Models\RolesModel;

// Ambil role ID dari sesi
$roleModel = new RolesModel();
?>
<!--  <nav class="main-header navbar navbar-expand navbar-dark"> !-->
<nav class="main-header navbar navbar-expand navbar-dark">
  <div class="container-fluid">
    <!-- Start navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-secondary" data-lte-toggle="sidebar-full" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-md-block">
        <a href="<?= base_url() ?>" class="nav-link text-secondary">Home</a>
      </li>
    </ul>

    <!-- End navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img src="<?= session()->get('img_user') ? base_url('/img/user/'.session()->get('img_user')) : base_url('/asset/img/user.png') ?>" class="user-image img-circle shadow" alt="User Image">
          <span class="d-none d-md-inline"><?= session()->get('username')?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!-- User image -->
          <li class="user-header bg-dark">
            <img src="<?= session()->get('img_user') ? base_url('/img/user/'.session()->get('img_user')) : base_url('/asset/img/user.png') ?>" class="img-circle shadow" alt="User Image">

            <p>
              <?= session()->get('nama') ?>
              <small><?= $roleModel->find(session()->get('id_role'))->name ?></small>
            </p>
          </li>
          <!-- Menu Body
          <li class="user-body">
             /.row 
          </li> -->
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="<?= base_url('user/profile')?>" class="btn btn-default btn-flat">Profile</a>
            <a href="<?= base_url('auth/logout')?>" class="btn btn-default btn-flat float-end sign-out">Keluar</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>