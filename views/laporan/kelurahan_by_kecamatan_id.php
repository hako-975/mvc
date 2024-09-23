<?php
	$start_date = '1970-01-01';
	$end_date = date('Y-m-d'); 
?>

<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-center">
						<div class="col-lg header-title">
							<h3 class="m-0"><i class="fas fa-fw fa-city"></i> Laporan Kecamatan - <?= $kecamatan['nama_kecamatan']; ?></h3>
						</div>
						<div class="col-lg-4 header-button">
							<a href="javascript:history.back()" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="table_id">
							<thead class="thead-dark">
								<tr>
									<th class="align-middle">No.</th>
									<th class="align-middle">Nama Kelurahan/Desa</th>
									<th class="align-middle">Belum Divalidasi</th>
									<th class="align-middle">Tidak Valid</th>
									<th class="align-middle">Valid</th>
									<th class="align-middle">Jumlah Laporan</th>
									<th class="align-middle">Detail Laporan</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$max_jumlah_laporan = 1;

									$max_jumlah_laporan_belum_divalidasi = 1;

									foreach ($laporan as $datlap) {
									    if ($datlap['jumlah_laporan_belum_divalidasi'] > $max_jumlah_laporan_belum_divalidasi) {
									        $max_jumlah_laporan_belum_divalidasi = $datlap['jumlah_laporan_belum_divalidasi'];
									    }
									} 

									$max_jumlah_laporan_valid = 1;

									foreach ($laporan as $datlap) {
									    if ($datlap['jumlah_laporan_valid'] > $max_jumlah_laporan_valid) {
									        $max_jumlah_laporan_valid = $datlap['jumlah_laporan_valid'];
									    }
									} 

									$max_jumlah_laporan_tidak_valid = 1;

									foreach ($laporan as $datlap) {
									    if ($datlap['jumlah_laporan_tidak_valid'] > $max_jumlah_laporan_tidak_valid) {
									        $max_jumlah_laporan_tidak_valid = $datlap['jumlah_laporan_tidak_valid'];
									    }
									} 

									$max_jumlah_laporan = 1;

									foreach ($laporan as $datlap) {
									    if ($datlap['jumlah_laporan'] > $max_jumlah_laporan) {
									        $max_jumlah_laporan = $datlap['jumlah_laporan'];
									    }
									}
								?>
								<?php $i = 1; ?>
								<?php foreach ($laporan as $dl): ?>
									<tr>
										<td class="align-middle"><?= $i++; ?></td>
										<td class="align-middle"><?= $dl['nama_kelurahan']; ?></td>
										<td class="align-middle">
											<?php if ($dl['jumlah_laporan_belum_divalidasi'] != 0): ?>
												<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=".$dl['id_kelurahan']."&id_jenis_laporan=Semua&status_laporan=Belum Divalidasi"); ?>">
													<div class="progress">
													  <div class="progress-bar bg-secondary" role="progressbar" style="width: <?= ($dl['jumlah_laporan_belum_divalidasi'] / $max_jumlah_laporan_belum_divalidasi) * 100; ?>%;" aria-valuenow="<?= $dl['jumlah_laporan_belum_divalidasi']; ?>"><h6 class="p-0 m-0"><?= $dl['jumlah_laporan_belum_divalidasi']; ?></h6></div>
													</div>
												</a>
											<?php else: ?>
												0
											<?php endif ?>
										</td>
										<td class="align-middle">
											<?php if ($dl['jumlah_laporan_tidak_valid'] != 0): ?>
												<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=".$dl['id_kelurahan']."&id_jenis_laporan=Semua&status_laporan=Tidak Valid"); ?>">
													<div class="progress">
												  		<div class="progress-bar bg-danger" role="progressbar" style="width: <?= ($dl['jumlah_laporan_tidak_valid'] / $max_jumlah_laporan_tidak_valid) * 100; ?>%;" aria-valuenow="<?= $dl['jumlah_laporan_tidak_valid']; ?>"><h6 class="p-0 m-0"><?= $dl['jumlah_laporan_tidak_valid']; ?></h6></div>
													</div>
												</a>
											<?php else: ?>
												0
											<?php endif ?>
										</td>
										<td class="align-middle">
											<?php if ($dl['jumlah_laporan_valid'] != 0): ?>
												<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=".$dl['id_kelurahan']."&id_jenis_laporan=Semua&status_laporan=Valid"); ?>">
													<div class="progress">
												  		<div class="progress-bar bg-success" role="progressbar" style="width: <?= ($dl['jumlah_laporan_valid'] / $max_jumlah_laporan_valid) * 100; ?>%;" aria-valuenow="<?= $dl['jumlah_laporan_valid']; ?>"><h6 class="p-0 m-0"><?= $dl['jumlah_laporan_valid']; ?></h6></div>
													</div>
												</a>
											<?php else: ?>
												0
											<?php endif ?>
										</td>
										
										<td class="align-middle">
											<?php if ($dl['jumlah_laporan'] != 0): ?>
												<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=".$dl['id_kelurahan']."&id_jenis_laporan=Semua&status_laporan=Semua"); ?>">
													<div class="progress">
												  		<div class="progress-bar" role="progressbar" style="width: <?= ($dl['jumlah_laporan'] / $max_jumlah_laporan) * 100; ?>%;" aria-valuenow="<?= $dl['jumlah_laporan']; ?>"><h6 class="p-0 m-0"><?= $dl['jumlah_laporan']; ?></h6></div>
													</div>
												</a>
											<?php else: ?>
												0
											<?php endif ?>
										</td>
										<td class="align-middle text-center">
											<a href="<?= base_url('laporan/detailLaporanByKelurahanId/' . $dl['id_kelurahan']); ?>" class="btn btn-sm btn-primary m-1"><i class="fas fa-fw fa-bars"></i></a>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
