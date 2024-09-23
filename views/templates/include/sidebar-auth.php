<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-1">
  <!-- Brand Logo -->
  <a href="<?= base_url('admin'); ?>" class="brand-link text-center">
    <img src="<?= base_url('assets/img/img_properties/favicon.png'); ?>" alt="Logo" class="img-w-50">
    <h5 class="brand-text my-2">Laporan <br> Desa Kabupaten Bogor</h5>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <?php 
      $num = 0;
      foreach ($jenis_laporan as $data) 
      {
        $num++;
      }

      foreach ($kecamatan as $data) 
      {
        $num++;
      }
     ?>
    <nav class="mt-2" style="padding-bottom: <?= ($num * 2) + 15; ?>px;">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item search-button">
          <form class="form-inline w-100" method="get" action="<?= base_url('auth/search'); ?>" style="height: 40px;">
            <div class="input-group input-group-sm w-100">
                <input name="search" class="bg-white border form-control form-control-navbar" type="search" placeholder="Cari" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="height: 40px; border-radius: 25px 0 0 25px; font-size: 18px; padding-left: 15px;">
                <div class="input-group-append">
                    <button class="btn btn-navbar pr-4 pl-3" type="submit" style="background-color: #F2F4F6; height: 40px; border-radius: 0 25px 25px 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
          </form>
        </li>
        <li class="nav-header my-0 py-1">Laporan</li>
        <?php foreach ($jenis_laporan as $djl): ?>
          <li class="nav-item ml-1">
            <a href="<?= base_url('auth/jenisLaporan/' . $djl['jenis_laporan']); ?>" class="nav-link">
              <i class="fas fa-file-alt nav-icon"></i>
              <p><?= $djl['jenis_laporan']; ?></p>
            </a>
          </li> 
        <?php endforeach ?>
        <li class="nav-header my-0 py-1">Kecamatan</li>
        <?php foreach ($kecamatan as $dk): ?>
          <li class="nav-item ml-1">
            <a href="<?= base_url('auth/kecamatan/' . $dk['nama_kecamatan']); ?>" class="nav-link">
              <i class="fas fa-city nav-icon"></i>
              <p><?= $dk['nama_kecamatan']; ?></p>
            </a>
          </li> 
        <?php endforeach ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>