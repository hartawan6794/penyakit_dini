      <!-- Main Sidebar Container -->
      <!--<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">-->
      <?php helper('settings');
      $seg = segment()->getUri()->getSegment(1) ?>
      <aside class="main-sidebar sidebar-bg-dark  sidebar-color-primary shadow">
        <div class="brand-container">
          <a href="javascript:;" class="brand-link">
            <img src="<?= session()->get('img_user') ? base_url('/img/user/' . session()->get('img_user')) : base_url('/asset/img/user.jpg') ?>" alt="Presensi" class="brand-image opacity-80 shadow">
            <span class="brand-text fw-light">Presensi</span>
          </a>
          <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fas fa-angle-double-left"></i></a>
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
          <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="<?= base_url('home') ?>" class="nav-link <?= $seg == 'home' || $seg == '' ? 'active' : '' ?> ">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>

              <li class="nav-header ">PENGGUNA</li>
              <li class="nav-item <?= $seg == 'user' || $seg == 'pasien' ? 'menu-open menu-is-open' : '' ?>">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>
                    User
                    <i class="end fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('user') ?>" class="nav-link <?= $seg == 'user' ? 'active' : '' ?>">
                      <i class="nav-icon far fa-circle"></i>
                      <p>Petugas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('pasien') ?>" class="nav-link <?= $seg == 'pasien' ? 'active' : '' ?>">
                      <i class="nav-icon far fa-circle"></i>
                      <p>Biodat Pasien</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>


          </nav>
        </div>
        <!-- /.sidebar -->
      </aside>