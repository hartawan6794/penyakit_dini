      <!-- Main Sidebar Container -->
      <!--<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">-->
      <?php helper('settings');

      use App\Models\MenuModel;
      use App\Models\MenurolesModel;

      $seg = segment()->getUri()->getSegment(1);
      $menu = new MenuModel();
      $roleid = new MenurolesModel();
      $roleid = $roleid->select('id_menu as id')->where('id_role', session()->get('id_role'))->asArray()->findAll();
      $roleid = array_map(function ($item) {
        return $item['id'];
      }, $roleid);
      // var_dump($roleid);
      // die;
      $menu = $menu->select('content')->whereIn('id', $roleid)->findAll();
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
              <?php foreach ($menu as $data) :
                // Decode HTML entities and evaluate the content
                $content = htmlspecialchars_decode($data->content);
                eval('?>' . $content);
              endforeach; ?>
            </ul>


          </nav>
        </div>
        <!-- /.sidebar -->
      </aside>