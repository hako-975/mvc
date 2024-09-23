<main class="flex-shrink-0">
	<div class="container">
		<div class="row justify-content-center pt-4">
			<div class="col-lg-12 border py-4 rounded bg-white px-0">
				<?php if (isset($_GET['search'])): ?>
					<h3 class="px-4">Pencarian: <?= $_GET['search']; ?></h3><hr>
				<?php endif ?>
				<?php if (isset($nama_bidang)): ?>
					<h3 class="px-4">Bidang: <?= $nama_bidang; ?></h3><hr>
				<?php elseif (isset($nama_jenis_laporan)): ?>
					<h3 class="px-4">Jenis Laporan: <?= $nama_jenis_laporan; ?></h3><hr>
				<?php elseif (isset($nama_kecamatan)): ?>
					<h3 class="px-4">Kecamatan: <?= $nama_kecamatan; ?></h3><hr>
				<?php endif ?>
				<a class="navbar-brand px-4 d-flex align-items-center" href="<?= base_url(); ?>">
		            <img src="<?= base_url('assets/img/img_properties/favicon-text.png'); ?>" class="d-inline-block align-top img-fluid img-w-40" alt="Logo">
		            <h4 class="text-wrap text-break d-inline-block ml-3 mb-0">Laporan Desa Kabupaten Bogor</h4>
		        </a>
		        <nav class="app-header navbar navbar-expand bg-primary navbar-dark mt-3">
			        <ul class="navbar-nav d-md-inline-block d-block">
	                    <?php foreach ($bidang as $db): ?>
	                    	<li class="nav-item d-md-inline-block d-block"> 
		                    	<a href="<?= base_url('auth/bidang/' . $db['id_bidang']); ?>" class="nav-link text-white"><?= $db['nama_bidang']; ?></a> 
		                    </li>
	                    <?php endforeach ?>
	                </ul>
	            </nav>
				<div class="row px-4 mt-3">
					<?php if ($laporan_terbuka): ?>
						<?php foreach ($laporan_terbuka as $dlt): ?>
							<div class="col-12 card mb-3">
						      	<div class="card-body">
							        <a class="text-dark" href="<?= base_url('auth/detailLaporan/' . $dlt['id_laporan']); ?>"><h4 class="my-0 py-0"><?= $dlt['judul_laporan']; ?></h4></a>
							        <p class="card-text my-0"><small class="text-muted">Tanggal Publikasi: <?= date('d-m-Y, H:i \W\I\B', strtotime($dlt['tgl_transparansi_laporan'])); ?></small></p>
							        <p class="card-text mb-2"><small class="text-muted">Kecamatan: <?= $dlt['nama_kecamatan']; ?>, Kelurahan/Desa: <?= $dlt['nama_kelurahan']; ?>, Jenis Laporan: <?= $dlt['jenis_laporan']; ?></small></p>
							        <p class="card-text">
									    <?php 
										    $uraian_laporan = $dlt['uraian_laporan'];
										    if (strlen($uraian_laporan) > 400) {
										        $trimmed_text = substr($uraian_laporan, 0, 400) . '...';
										        echo $trimmed_text;
										    } else {
										        echo $uraian_laporan;
										    }
									    ?>
									    <a href="<?= base_url('auth/detailLaporan/' . $dlt['id_laporan']); ?>">Selengkapnya</a>
									</p>

							        <p class="card-text my-0"><small class="text-muted">Dibuat Oleh: <?= $dlt['username']; ?></small></p>
						      	</div>
							</div>
						<?php endforeach ?>
					<?php else: ?>
						<div class="col text-center my-5 py-5">
					        <h5 class="text-center">Tidak ada data.</h5>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</main>
