<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- SEARCH FORM -->
  <form class="w-100 form-inline ml-3" method="get" action="<?= base_url('laporan/search'); ?>">
    <div class="w-100 input-group input-group-sm">
      <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" value="<?php echo isset($search) ? $search : ''; ?>">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="far fa-bell"></i>
        <span class="badge badge-danger navbar-badge">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      </div>
    </li>
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="<?= base_url('admin/profile'); ?>" class="dropdown-item">
          <i class="far fa-fw fa-user"></i> Profil
        </a>
        <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item">
          <i class="fas fa-fw fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->


<script>
$(document).ready(function(){
  function loadUnreadMessages() {
    $.ajax({
      url: '<?= base_url("laporan/getLaporanBelumDivalidasi"); ?>',
      method: 'GET',
      dataType: 'json',
      success: function(data) {
          let dropdownMenu = $('.dropdown-menu-lg.dropdown-menu-right');
          let badge = $('.navbar-badge');
          dropdownMenu.empty(); // Kosongkan dropdown menu
          
          if (data.length > 0) {
              data.forEach(function(laporan) {
                  let item = `
                      <a href="<?= base_url('laporan/detailLaporan/'); ?>${laporan.id_laporan}" class="dropdown-item">
                          <div class="media">
                              <div class="media-body">
                                  <h3 class="dropdown-item-title">
                                      ${laporan.jenis_laporan}
                                  </h3>
                                  <p class="text-sm">${laporan.judul_laporan}</p>
                                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ${laporan.tgl_laporan}</p>
                              </div>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                  `;
                  dropdownMenu.append(item);
              });
              dropdownMenu.append(`<a href="<?= base_url('laporan'); ?>" class="dropdown-item dropdown-footer">Lihat Semua Laporan</a>`);
              $('.navbar-badge').text(data.length);
              badge.text(data.length).show(); 
          } else {
              dropdownMenu.append('<p class="text-center p-3">Tidak ada laporan baru</p>');
              $('.navbar-badge').text('0');
              dropdownMenu.append(`<div class="dropdown-divider"></div> <a href="<?= base_url('laporan'); ?>" class="dropdown-item dropdown-footer">Lihat Semua Laporan</a>`);
              $('.navbar-badge').text(data.length);
              badge.hide();
          }
      }
    });
  }

  loadUnreadMessages(); 

  setInterval(loadUnreadMessages, 5000);
});
</script>