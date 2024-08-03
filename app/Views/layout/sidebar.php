      <!-- Main Sidebar Container -->
      <!--<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">-->
      <?php helper('settings');

      use App\Models\MenuModel;
      use App\Models\MenurolesModel;

      // Ambil segmen URL saat ini
      $seg = segment()->getUri()->getSegment(1);

      // Ambil role ID dari sesi
      $roleModel = new MenurolesModel();
      $menuId = $roleModel->select('id_menu')
        ->where('id_role', session()->get('id_role'))
        ->asArray()
        ->findColumn('id_menu');

      // Ambil menu berdasarkan role ID
      $menuModel = new MenuModel();
      $menus = $menuModel->select('content')
        ->whereIn('id', $menuId)
        ->findAll();
      // var_dump($menu);die;
      ?>
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
              <?php
              $menuItems = [];
              foreach ($menus as $data) {
                // Decode HTML entities and tambahkan ke array
                $content = htmlspecialchars_decode($data->content);
                $menuItems[] = $content;
              }
              // Hapus duplikasi
              $menuItems = array_unique($menuItems);
              // Echo menu items
              foreach ($menuItems as $content) {
                eval('?>' . $content);
              }
              ?>
            </ul>


          </nav>
        </div>
        <!-- /.sidebar -->
      </aside>