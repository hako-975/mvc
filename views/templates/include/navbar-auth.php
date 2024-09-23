<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
  <div class="container px-lg-4 ml-lg-5 row justify-content-between">
    <div class="col-1 d-flex justify-content-center">
      <!-- Left navbar links -->
      <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item d-flex align-items-center">
          <a class="nav-link d-flex align-items-center" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>
    </div>

    <div class="col-3">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url(); ?>">
            <img src="<?= base_url('assets/img/img_properties/favicon-text.png'); ?>" class="d-inline-block align-top img-fluid img-w-40" alt="Logo">
            <h4 class="d-inline-block ml-3 mb-0">Laporan Desa</h4>
        </a>
    </div>

    <div class="col-3 col-md-5 col-lg-6 search-form">
        <!-- SEARCH FORM -->
        <form class="form-inline w-100" method="get" action="<?= base_url('auth/search'); ?>" style="height: 40px;">
            <div class="input-group input-group-sm w-100">
                <input name="search" class="bg-white border form-control form-control-navbar" type="search" placeholder="Cari" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="height: 40px; border-radius: 25px 0 0 25px; font-size: 18px; padding-left: 15px;">
                <div class="input-group-append">
                    <button class="btn btn-navbar pr-4 pl-3" type="submit" style="height: 40px; border-radius: 0 25px 25px 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col">
        <!-- Right navbar links -->
        <ul class="navbar-nav d-flex justify-content-end">
            <li class="nav-item">
                <a class="btn btn-primary text-white nav-link rounded-pill" href="<?= base_url('auth/login'); ?>"><i class="fas fa-fw fa-sign-in-alt"></i> Login</a>
            </li>
        </ul>
    </div>
  </div>
</nav>