<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('admin'); ?>" class="brand-link">
    <img src="<?= base_url('assets/img/img_properties/favicon.png'); ?>" alt="Logo" class="img-w-50">
    <span class="brand-text ml-2">Laporan Desa Kab Bogor</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <?php if (
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/admin/profile' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/admin/profile/'
          ): ?>
            <a href="<?= base_url('admin/profile'); ?>" class="nav-link active"><i class="nav-icon fas fa-fw fa-user"></i> <p><?= $dataUser['username']; ?></p></a>
          <?php else: ?>
            <a href="<?= base_url('admin/profile'); ?>" class="nav-link"><i class="nav-icon fas fa-fw fa-user"></i> <p><?= $dataUser['username']; ?></p></a>
          <?php endif ?>
        </li>
        <li class="nav-item">
          <?php if (
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/admin' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/admin/'
          ): ?>
            <a href="<?= base_url('admin'); ?>" class="nav-link active">
          <?php else: ?>
            <a href="<?= base_url('admin'); ?>" class="nav-link">
          <?php endif ?>
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        
        <?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang' || $dataUser['jabatan'] == 'Kepala Desa' || $dataUser['jabatan'] == 'Sekretaris Desa' || $dataUser['jabatan'] == 'Operator Desa'): ?>
          <?php 
            $this->db->order_by('jenis_laporan', 'asc');
            $jenis_laporan = $this->db->get('jenis_laporan')->result_array(); 
            $is_matched = false;

            foreach ($jenis_laporan as $djl) {
              $jenis_laporan_encoded = str_replace(' ', '%20', $djl['jenis_laporan']);
              if ($_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/laporan/index/' . $jenis_laporan_encoded) {
                $is_matched = true;
                break;
              }
            }
          ?>

          <?php if (
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/laporan' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/laporan/' ||
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/laporan/index' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/laporan/index/' || 
            $is_matched
          ): ?>
            <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="fas fa-align-justify nav-icon"></i>
              <p>Laporan <i class="right fas fa-angle-left"></i></p>
            </a>
          <?php else: ?>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-align-justify nav-icon"></i>
              <p>Laporan <i class="right fas fa-angle-left"></i></p>
            </a>
          <?php endif ?>
            <?php if ($dataUser['jabatan'] == 'Kepala Bidang'): ?>
              <ul class="nav nav-treeview">
                <?php 
                  $this->db->order_by('nama_bidang', 'asc');
                  $bidang = $this->db->get('bidang')->result_array(); 
                ?>
                <?php
                $current_jenis_laporan_id = urldecode($this->uri->segment(3)); 
                foreach ($bidang as $db): 
                  if ($db['id_bidang'] == $dataUser['id_bidang']):
                    // Get jenis_laporan for the current bidang
                    $this->db->order_by('jenis_laporan', 'asc');
                    $jenis_laporan = $this->db->get_where('jenis_laporan', ['jenis_laporan.id_bidang' => $db['id_bidang']])->result_array(); 

                    // Check if any jenis_laporan matches the current jenis_laporan ID
                    $is_active_bidang = false;
                    foreach ($jenis_laporan as $djl) {
                      if ($djl['jenis_laporan'] == $current_jenis_laporan_id) {
                        $is_active_bidang = true;
                        break;
                      }
                    }
                    ?>
                    <?php if ($is_active_bidang): ?>
                      <li class="nav-item ml-1 menu-open">
                        <a href="#" class="nav-link active">
                    <?php else: ?>
                      <li class="nav-item ml-1">
                        <a href="#" class="nav-link">
                    <?php endif ?>
                      <i class="fas fa-layer-group nav-icon"></i>
                      <p><?= $db['nama_bidang']; ?> <i class="right fas fa-angle-left"></i></p>
                    </a>
                      <ul class="nav nav-treeview">
                        <?php foreach ($jenis_laporan as $djl): ?>
                          <li class="nav-item ml-1">
                            <a href="<?= base_url('laporan/index/' . $djl['jenis_laporan']); ?>" class="nav-link <?= ($djl['jenis_laporan'] == $current_jenis_laporan_id) ? 'active' : ''; ?>">
                              <i class="fas fa-file-alt nav-icon"></i>
                              <p><?= $djl['jenis_laporan']; ?></p>
                            </a>
                          </li> 
                        <?php endforeach ?>
                      </ul>
                    </li> 
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            <?php elseif ($dataUser['jabatan'] == 'Operator Desa'): ?>
              <ul class="nav nav-treeview">
                <?php 
                  $this->db->order_by('nama_bidang', 'asc');
                  $bidang = $this->db->get('bidang')->result_array(); 
                  $id_bidang =  $this->db->select('bidang.id_bidang')->from('bidang')->join('jenis_laporan', 'jenis_laporan.id_bidang = bidang.id_bidang')->where('jenis_laporan.id_jenis_laporan', $dataUser['id_jenis_laporan'])->get()->row_array()['id_bidang'];
                ?>
                <?php
                $current_jenis_laporan_id = urldecode($this->uri->segment(3)); 
                foreach ($bidang as $db): 
                  if ($db['id_bidang'] == $id_bidang):
                    // Get jenis_laporan for the current bidang
                    $this->db->order_by('jenis_laporan', 'asc');
                    $jenis_laporan = $this->db->get_where('jenis_laporan', ['jenis_laporan.id_bidang' => $db['id_bidang']])->result_array(); 

                    // Check if any jenis_laporan matches the current jenis_laporan ID
                    $is_active_bidang = false;
                    foreach ($jenis_laporan as $djl) {
                      if ($djl['jenis_laporan'] == $current_jenis_laporan_id) {
                        $is_active_bidang = true;
                        break;
                      }
                    }
                    ?>
                    <?php if ($is_active_bidang): ?>
                      <li class="nav-item ml-1 menu-open">
                        <a href="#" class="nav-link active">
                    <?php else: ?>
                      <li class="nav-item ml-1">
                        <a href="#" class="nav-link">
                    <?php endif ?>
                      <i class="fas fa-layer-group nav-icon"></i>
                      <p><?= $db['nama_bidang']; ?> <i class="right fas fa-angle-left"></i></p>
                    </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item ml-1">
                          <a href="<?= base_url('laporan/index/' . $dataUser['jenis_laporan']); ?>" class="nav-link <?= ($dataUser['jenis_laporan'] == $current_jenis_laporan_id) ? 'active' : ''; ?>">
                            <i class="fas fa-file-alt nav-icon"></i>
                            <p><?= $dataUser['jenis_laporan']; ?></p>
                          </a>
                        </li> 
                      </ul>
                    </li> 
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            <?php else: ?>
              <ul class="nav nav-treeview">
                <?php 
                  $this->db->order_by('nama_bidang', 'asc');
                  $bidang = $this->db->get('bidang')->result_array(); 
                ?>
                <?php
                $current_jenis_laporan_id = urldecode($this->uri->segment(3)); 

                foreach ($bidang as $db): 
                  // Get jenis_laporan for the current bidang
                  $this->db->order_by('jenis_laporan', 'asc');
                  $jenis_laporan = $this->db->get_where('jenis_laporan', ['jenis_laporan.id_bidang' => $db['id_bidang']])->result_array(); 

                  // Check if any jenis_laporan matches the current jenis_laporan ID
                  $is_active_bidang = false;
                  foreach ($jenis_laporan as $djl) {
                      if ($djl['jenis_laporan'] == $current_jenis_laporan_id) {
                          $is_active_bidang = true;
                          break;
                      }
                  }
                  ?>
                  <?php if ($is_active_bidang): ?>
                      <li class="nav-item ml-1 menu-open">
                          <a href="#" class="nav-link active">
                  <?php else: ?>
                      <li class="nav-item ml-1">
                          <a href="#" class="nav-link">
                  <?php endif ?>
                      <i class="fas fa-layer-group nav-icon"></i>
                      <p><?= $db['nama_bidang']; ?> <i class="right fas fa-angle-left"></i></p>
                  </a>
                  <ul class="nav nav-treeview">
                      <?php foreach ($jenis_laporan as $djl): ?>
                          <li class="nav-item ml-1">
                              <a href="<?= base_url('laporan/index/' . $djl['jenis_laporan']); ?>" class="nav-link <?= ($djl['jenis_laporan'] == $current_jenis_laporan_id) ? 'active' : ''; ?>">
                                  <i class="fas fa-file-alt nav-icon"></i>
                                  <p><?= $djl['jenis_laporan']; ?></p>
                              </a>
                          </li> 
                      <?php endforeach ?>
                  </ul>
                  </li> 
                <?php endforeach ?>
              </ul>
            <?php endif ?>
          </li>
        <?php endif ?>
        
        <?php if ($dataUser['jabatan'] == 'Kepala Desa' || $dataUser['jabatan'] == 'Sekretaris Desa'): ?>
          <li class="nav-item">
            <?php if (
              $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/user' || 
              $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/user/'
            ): ?>
              <a href="<?= base_url('user'); ?>" class="nav-link active">
            <?php else: ?>
              <a href="<?= base_url('user'); ?>" class="nav-link">
            <?php endif ?>
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
              </p>
            </a>
          </li>
        <?php endif ?>

        <!-- manajemen data -->
        <?php if ($dataUser['jabatan'] == 'Administrator'): ?>
          <?php if (
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/user' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/user/'||
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/bidang' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/bidang/' ||
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/jenisLaporan' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/jenisLaporan/'||
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kecamatan' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kecamatan/' ||
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kelurahan' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kelurahan/' 
          ): ?>
            <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="fas fa-align-justify nav-icon"></i>
              <p>Manajemen Data <i class="right fas fa-angle-left"></i></p>
            </a>
          <?php else: ?>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-align-justify nav-icon"></i>
              <p>Manajemen Data <i class="right fas fa-angle-left"></i></p>
            </a>
          <?php endif ?>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-3">
                <?php if (
                  $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/user' || 
                  $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/user/'
                ): ?>
                  <a href="<?= base_url('user'); ?>" class="nav-link active">
                    <i class="fas fa-users nav-icon"></i>
                    <p>User</p>
                  </a>
                <?php else: ?>
                  <a href="<?= base_url('user'); ?>" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>User</p>
                  </a>
                <?php endif ?>
              </li>
              <li class="nav-item ml-3">
                <?php if (
                  $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/bidang' || 
                  $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/bidang/'
                ): ?>
                  <a href="<?= base_url('bidang'); ?>" class="nav-link active">
                    <i class="fas fa-layer-group nav-icon"></i>
                    <p>Bidang</p>
                  </a>
                <?php else: ?>
                  <a href="<?= base_url('bidang'); ?>" class="nav-link">
                    <i class="fas fa-layer-group nav-icon"></i>
                    <p>Bidang</p>
                  </a>
                <?php endif ?>
              </li>
              <?php if ($dataUser['jabatan'] == 'Administrator'): ?>
                <li class="nav-item ml-3">
                  <?php if (
                    $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/jenisLaporan' || 
                    $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/jenisLaporan/'
                  ): ?>
                    <a href="<?= base_url('jenisLaporan'); ?>" class="nav-link active">
                      <i class="fas fa-file-alt nav-icon"></i>
                      <p>Jenis Laporan</p>
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('jenisLaporan'); ?>" class="nav-link">
                      <i class="fas fa-file-alt nav-icon"></i>
                      <p>Jenis Laporan</p>
                    </a>
                  <?php endif ?>
                </li>
                <li class="nav-item ml-3">
                  <?php if (
                    $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kecamatan' || 
                    $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kecamatan/'
                  ): ?>
                    <a href="<?= base_url('kecamatan'); ?>" class="nav-link active">
                      <i class="fas fa-city nav-icon"></i>
                      <p>Kecamatan</p>
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('kecamatan'); ?>" class="nav-link">
                      <i class="fas fa-city nav-icon"></i>
                      <p>Kecamatan</p>
                    </a>
                  <?php endif ?>
                </li>
                <li class="nav-item ml-3">
                  <?php if (
                    $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kelurahan' || 
                    $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/kelurahan/'
                  ): ?>
                    <a href="<?= base_url('kelurahan'); ?>" class="nav-link active">
                      <i class="fas fa-building nav-icon"></i>
                      <p>Kelurahan/Desa</p>
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('kelurahan'); ?>" class="nav-link">
                      <i class="fas fa-building nav-icon"></i>
                      <p>Kelurahan/Desa</p>
                    </a>
                  <?php endif ?>
                </li>
              <?php endif ?>
            </ul>
          </li>
        <?php endif ?>
        <!-- manajemen data -->

        <div class="dropdown-divider"></div>
        <li class="nav-item">
          <?php if (
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/log' || 
            $_SERVER['REQUEST_URI'] == '/laporan_kab_bogor/log/'
          ): ?>
            <a href="<?= base_url('log'); ?>" class="nav-link active">
              <i class="fas fa-history nav-icon"></i>
              <p>Aktivitas</p>
            </a>
          <?php else: ?>
            <a href="<?= base_url('log'); ?>" class="nav-link">
              <i class="fas fa-history nav-icon"></i>
              <p>Aktivitas</p>
            </a>
          <?php endif ?>
        </li>
        <?php if ($dataUser['jabatan'] == 'Administrator'): ?>
          <li class="nav-item">
            <a href="<?= base_url('file/backup_db'); ?>" class="nav-link">
              <i class="fas fa-database nav-icon"></i>
              <p>Backup Data</p>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>