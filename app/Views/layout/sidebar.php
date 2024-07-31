      <!-- Main Sidebar Container -->
      <!--<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">-->
      <?php helper('settings');
      $seg = segment()->getUri()->getSegment(1) ?>
      <aside class="main-sidebar sidebar-bg-dark  sidebar-color-primary shadow">
        <div class="brand-container">
          <a href="javascript:;" class="brand-link">
            <img src="<?= session()->get('img_user') ? base_url('/img/user/' . session()->get('img_user')) : base_url('/asset/img/user.png') ?>" alt="Presensi" class="brand-image opacity-80 shadow">
            <span class="brand-text fw-light">Presensi</span>
          </a>
          <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fas fa-angle-double-left"></i></a>
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
          <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <li class="nav-header ">Menu Aplikasi</li>
              <li class="nav-item">
                <a href="<?= base_url('home') ?>" class="nav-link <?= $seg == 'home'  || $seg == ''  ? 'active' : '' ?> ">
                  <i class="fa-solid fa fa-desktop"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('pendaftaran') ?>" class="nav-link <?= $seg == 'pendaftaran' ? 'active' : '' ?> ">
                  <i class="fa-solid fa-hospital-user"></i>
                  <p>
                    Pendaftaran
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('penyakit') ?>" class="nav-link <?= $seg == 'penyakit' ? 'active' : '' ?> ">
                  <i class="fa-solid fa-square-virus"></i>
                  <p>
                    Penyakit
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('keluhan') ?>" class="nav-link <?= $seg == 'keluhan' ? 'active' : '' ?> ">
                  <i class="fa-solid fa-heart-pulse"></i>
                  <p>
                    Keluhan
                  </p>
                </a>
              </li>

              <li class="nav-header ">Diagnosis</li>
              <li class="nav-item">
                <a href="<?= base_url('diagnosis') ?>" class="nav-link <?= $seg == 'diagnosis' ? 'active' : '' ?> ">
                  <i class="fa-solid fa-stethoscope"></i>
                  <p>
                    Diagnosis Pasien
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('monitoring') ?>" class="nav-link <?= $seg == 'monitoring' ? 'active' : '' ?> ">
                  <!-- <i class="fa-solid fa-stethoscope"></i> -->
                  <i class="fa-solid fa-tv"></i>
                  <p>
                    Monitoring Obat
                  </p>
                </a>
              </li>

              <li class="nav-header ">Laporan</li>
              <li class="nav-item">
                <a href="<?= base_url('laporan') ?>" class="nav-link <?= $seg == 'laporan' ? 'active' : '' ?> ">
                  <i class="fa fa-print" aria-hidden="true"></i>
                  <p>
                    Laporan Diagnosis Pasien
                  </p>
                </a>
              </li>

              <li class="nav-header ">Master</li>
              <li class="nav-item">
                <a href="<?= base_url('obat') ?>" class="nav-link <?= $seg == 'obat' ? 'active' : '' ?> ">
                  <i class="fa-solid fa-pills"></i>
                  <p>
                    Obat
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('roles') ?>" class="nav-link <?= $seg == 'roles' ? 'active' : '' ?>">
                  <i class="fa-solid fa-list"></i>
                  <p>Role</p>
                </a>
              </li>
              </li>

              <li class="nav-header ">PENGGUNA</li>
              <li class="nav-item <?= $seg == 'user' || $seg == 'pasien' ? 'menu-open menu-is-open' : '' ?>">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fa fa-users"></i>
                  <p>
                    User
                    <i class="end fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('user') ?>" class="nav-link <?= $seg == 'user' ? 'active' : '' ?>">
                      <i class="nav-icon far fa-user"></i>
                      <p>Pengguna</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('pasien') ?>" class="nav-link <?= $seg == 'pasien' ? 'active' : '' ?>">
                      <i class="nav-icon fa fa-users-line"></i>
                      <p>Pasien</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>


          </nav>
        </div>
        <!-- /.sidebar -->
      </aside>