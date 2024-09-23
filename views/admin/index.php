<?php
	$start_date = '1970-01-01';
	$end_date = date('Y-m-d'); 
?>

<div class="container p-3">
	<div class="row mb-2">
		<div class="col">
			<div class="card">
				<div class="card-header">
					<h3 class="m-0"><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard <?= $dataUser['jabatan']; ?> <?= ($dataUser['jabatan'] == 'Camat') ? ' - ' . $dataUser['nama_kecamatan'] : '' ?> <?= ($dataUser['jabatan'] == 'Kepala Desa' || $dataUser['jabatan'] == 'Operator Desa') ? ' - ' . $dataUser['nama_kelurahan'] : '' ?></h3>
				</div>
				<div class="card-body">
					<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Desa'): ?>
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <?php 
						  $active = true; 
						  foreach ($bidang as $index => $dbid): ?>
						    <li class="nav-item" role="presentation">
						      	<button class="nav-link <?php if($active) { echo 'active'; $active = false; } ?>" id="tab-<?= $index ?>" data-toggle="tab" data-target="#tab-content-<?= $index ?>" type="button" role="tab" aria-controls="tab-content-<?= $index ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
						        	<h6 class="mb-0 text-black"><?= $dbid['nama_bidang']; ?></h6>
						      	</button>
						    </li>
						  <?php endforeach ?>
						</ul>
						<div class="tab-content" id="myTabContent">
						  <?php 
						  $active = true;
						  foreach ($bidang as $index => $dbid): ?>
						    <div class="tab-pane fade p-3 <?php if($active) { echo 'show active'; $active = false; } ?>" id="tab-content-<?= $index ?>" role="tabpanel" aria-labelledby="tab-<?= $index ?>">
						      	<div class="row">
						      		<?php
						      			$this->db->order_by('jenis_laporan', 'asc');
										$this->db->join('bidang', 'jenis_laporan.id_bidang=bidang.id_bidang');
										$jenis_laporan = $this->db->get_where('jenis_laporan', ['jenis_laporan.id_bidang' => $dbid['id_bidang']])->result_array();	 
						      		?>
									<?php $i = 1; ?>
									<?php foreach ($jenis_laporan as $djl): ?>
										<?php 
											if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan') {
												$jml_laporan = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan']])->num_rows();
												$jml_laporan_valid = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'status_laporan' => 'Valid'])->num_rows();
												$jml_laporan_tidak_valid = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'status_laporan' => 'Tidak Valid'])->num_rows();
												$jml_laporan_belum_divalidasi = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'status_laporan' => 'Belum Divalidasi'])->num_rows();
												$jml_laporan = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan']])->num_rows();
											} elseif ($dataUser['jabatan'] == 'Camat') {
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan']])->num_rows();
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan_valid = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan'], 'status_laporan' => 'Valid'])->num_rows();
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan_tidak_valid = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan'], 'status_laporan' => 'Tidak Valid'])->num_rows();
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan_belum_divalidasi = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan'], 'status_laporan' => 'Belum Divalidasi'])->num_rows();
											} elseif ($dataUser['jabatan'] == 'Kepala Desa') {
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan']])->num_rows();
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan_valid = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan'], 'status_laporan' => 'Valid'])->num_rows();
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan_tidak_valid = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan'], 'status_laporan' => 'Tidak Valid'])->num_rows();
												$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
												$this->db->join('kecamatan', 'kelurahan.id_kecamatan = kecamatan.id_kecamatan', 'left');
												$jml_laporan_belum_divalidasi = $this->db->get_where('laporan', ['id_jenis_laporan' => $djl['id_jenis_laporan'], 'kelurahan.id_kecamatan' => $dataUser['id_kecamatan'], 'status_laporan' => 'Belum Divalidasi'])->num_rows();
											}
										?>
										<div class="col-lg-3 col-6">
											<div class="small-box bg-info">
												<div class="inner">
													<h5 class="p-1 rounded mb-0 pb-0"><?= $djl['jenis_laporan']; ?></h5><hr class="bg-white mt-1">
													<h5 class="p-1 rounded bg-primary border">Total: <?= $jml_laporan; ?></h5>
													<h6 class="p-1 rounded bg-success">Valid: <?= $jml_laporan_valid; ?></h6>
													<h6 class="p-1 rounded bg-danger">Tidak Valid: <?= $jml_laporan_tidak_valid; ?></h6>
													<h6 class="p-1 rounded bg-secondary">Belum Divalidasi: <?= $jml_laporan_belum_divalidasi; ?></h6>
												</div>
												<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan'): ?>
													<select name="id_kecamatan" id="id_kecamatan<?= $i; ?>" class="custom-select">
														<option value="0">--- Pilih Kecamatan ---</option>
														<?php foreach ($kecamatan as $dk): ?>
															<option value="<?= $dk['id_kecamatan']; ?>"><?= $dk['nama_kecamatan']; ?></option>
														<?php endforeach ?>
													</select>
												<?php elseif ($dataUser['jabatan'] == 'Camat'): ?>
													<select name="id_kelurahan" id="id_kelurahan<?= $i; ?>" class="custom-select">
														<option value="0">--- Pilih Kelurahan ---</option>
														<?php foreach ($kelurahan as $dk): ?>
															<option value="<?= $dk['id_kelurahan']; ?>"><?= $dk['nama_kelurahan']; ?></option>
														<?php endforeach ?>
													</select>
												<?php endif ?>
												<a href="<?= base_url('laporan/index/' . $djl['jenis_laporan']); ?>" id="link<?= $i++; ?>" class="small-box-footer" data-id="<?= $djl['id_jenis_laporan']; ?>">Detail <i class="fas fa-arrow-circle-right"></i></a>
											</div>
										</div>
									<?php endforeach ?>
								</div>
						    </div>
						  <?php endforeach ?>
						</div>
					<?php endif ?>
					<?php if ($dataUser['jabatan'] == 'Kepala Bidang'): ?>
						<div class="row">
							<?php 
								$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan = jenis_laporan.id_jenis_laporan', 'left');
								$jml_laporan_belum_divalidasi = $this->db->get_where('laporan', ['jenis_laporan.id_bidang' => $dataUser['id_bidang'], 'status_laporan' => 'Belum Divalidasi'])->num_rows();
							?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-secondary">
									<div class="inner">
										<h3><?= $jml_laporan_belum_divalidasi; ?></h3>
										<span>Belum Divalidasi</span>
										<div><?= $dataUser['jenis_laporan']; ?></div>
									</div>
									<div class="icon">
										<i class="fas fa-fw fa-file-alt"></i>
									</div>
									<!-- <a href="<?= base_url('laporan/index/' . $dataUser['jenis_laporan']); ?>" class="small-box-footer" data-id="<?= $dataUser['id_jenis_laporan']; ?>">Detail <i class="fas fa-arrow-circle-right"></i></a> -->
								</div>
							</div>

							<?php 
								$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan = jenis_laporan.id_jenis_laporan', 'left');
								$jml_laporan_tidak_valid = $this->db->get_where('laporan', ['jenis_laporan.id_bidang' => $dataUser['id_bidang'], 'status_laporan' => 'Tidak Valid'])->num_rows();
							?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<h3><?= $jml_laporan_tidak_valid; ?></h3>
										<span>Tidak Valid</span>
										<div><?= $dataUser['jenis_laporan']; ?></div>
									</div>
									<div class="icon">
										<i class="fas fa-fw fa-file-alt"></i>
									</div>
									<!-- <a href="<?= base_url('laporan/index/' . $dataUser['jenis_laporan']); ?>" class="small-box-footer" data-id="<?= $dataUser['id_jenis_laporan']; ?>">Detail <i class="fas fa-arrow-circle-right"></i></a> -->
								</div>
							</div>

							<?php 
								$this->db->join('jenis_laporan', 'laporan.id_jenis_laporan = jenis_laporan.id_jenis_laporan', 'left');
								$jml_laporan_valid = $this->db->get_where('laporan', ['jenis_laporan.id_bidang' => $dataUser['id_bidang'], 'status_laporan' => 'Valid'])->num_rows();
							?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?= $jml_laporan_valid; ?></h3>
										<span>Valid</span>
										<div><?= $dataUser['jenis_laporan']; ?></div>
									</div>
									<div class="icon">
										<i class="fas fa-fw fa-file-alt"></i>
									</div>
									<!-- <a href="<?= base_url('laporan/index/' . $dataUser['jenis_laporan']); ?>" class="small-box-footer" data-id="<?= $dataUser['id_jenis_laporan']; ?>">Detail <i class="fas fa-arrow-circle-right"></i></a> -->
								</div>
							</div>
						</div>
					<?php endif ?>
					<?php if ($dataUser['jabatan'] == 'Operator Desa'): ?>
						<div class="row">
							<?php 
								$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
								$jml_laporan_belum_divalidasi = $this->db->get_where('laporan', ['laporan.id_user' => $dataUser['id_user'], 'id_jenis_laporan' => $dataUser['id_jenis_laporan'], 'kelurahan.id_kelurahan' => $dataUser['id_kelurahan'], 'status_laporan' => 'Belum Divalidasi'])->num_rows();
							?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-secondary">
									<div class="inner">
										<h3><?= $jml_laporan_belum_divalidasi; ?></h3>
										<span>Belum Divalidasi</span>
										<div><?= $dataUser['jenis_laporan']; ?></div>
									</div>
									<div class="icon">
										<i class="fas fa-fw fa-file-alt"></i>
									</div>
									<a href="<?= base_url('laporan/index?dari_tanggal='.date('Y-m-01').'&sampai_tanggal='.date('Y-m-d').'&id_jenis_laporan=' . $dataUser['id_jenis_laporan'] . '&status_laporan=Belum+Divalidasi'); ?>" class="small-box-footer" data-id="<?= $dataUser['id_jenis_laporan']; ?>">Detail <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<?php 
								$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
								$jml_laporan_tidak_valid = $this->db->get_where('laporan', ['laporan.id_user' => $dataUser['id_user'], 'id_jenis_laporan' => $dataUser['id_jenis_laporan'], 'kelurahan.id_kelurahan' => $dataUser['id_kelurahan'], 'status_laporan' => 'Tidak Valid'])->num_rows();
							?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<h3><?= $jml_laporan_tidak_valid; ?></h3>
										<span>Tidak Valid</span>
										<div><?= $dataUser['jenis_laporan']; ?></div>
									</div>
									<div class="icon">
										<i class="fas fa-fw fa-file-alt"></i>
									</div>
									<a href="<?= base_url('laporan/index?dari_tanggal='.date('Y-m-01').'&sampai_tanggal='.date('Y-m-d').'&id_jenis_laporan=' . $dataUser['id_jenis_laporan'] . '&status_laporan=Tidak+Valid'); ?>" class="small-box-footer" data-id="<?= $dataUser['id_jenis_laporan']; ?>">Detail <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>

							<?php 
								$this->db->join('kelurahan', 'laporan.id_kelurahan = kelurahan.id_kelurahan', 'left');
								$jml_laporan_valid = $this->db->get_where('laporan', ['laporan.id_user' => $dataUser['id_user'], 'id_jenis_laporan' => $dataUser['id_jenis_laporan'], 'kelurahan.id_kelurahan' => $dataUser['id_kelurahan'], 'status_laporan' => 'Valid'])->num_rows();
							?>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3><?= $jml_laporan_valid; ?></h3>
										<span>Valid</span>
										<div><?= $dataUser['jenis_laporan']; ?></div>
									</div>
									<div class="icon">
										<i class="fas fa-fw fa-file-alt"></i>
									</div>
									<a href="<?= base_url('laporan/index?dari_tanggal='.date('Y-m-01').'&sampai_tanggal='.date('Y-m-d').'&id_jenis_laporan=' . $dataUser['id_jenis_laporan'] . '&status_laporan=Valid'); ?>" class="small-box-footer" data-id="<?= $dataUser['id_jenis_laporan']; ?>">Detail <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan' || $dataUser['jabatan'] == 'Camat'): ?>
		<div class="row mb-2">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<h3 class="m-0"><i class="fas fa-fw fa-chart-bar"></i> Laporan</h3>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_id">
								<thead class="thead-dark">
									<tr>
										<th class="align-middle">No.</th>
										<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan'): ?>
											<th class="align-middle">Kecamatan</th>
										<?php elseif ($dataUser['jabatan'] == 'Camat'): ?>
											<th class="align-middle">Kelurahan</th>
										<?php endif ?>
										<th class="align-middle">Belum Divalidasi</th>
										<th class="align-middle">Tidak Valid</th>
										<th class="align-middle">Valid</th>
										<th class="align-middle">Jumlah Laporan</th>
										<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan'): ?>
											<th class="align-middle">Kelurahan/Desa</th>
										<?php endif ?>
										<?php if ($dataUser['jabatan'] == 'Camat'): ?>
											<th class="align-middle">Detail Laporan</th>
										<?php endif ?>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									<?php 

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
									<?php foreach ($laporan as $dl): ?>
										<tr>
											<td class="align-middle"><?= $i++; ?>.</td>
											<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan'): ?>
												<td class="align-middle"><?= $dl['nama_kecamatan']; ?></td>
											<?php elseif ($dataUser['jabatan'] == 'Camat'): ?>
												<td class="align-middle"><?= $dl['nama_kelurahan']; ?></td>
											<?php endif ?>
											<td class="align-middle">
												<?php if ($dl['jumlah_laporan_belum_divalidasi'] != 0): ?>
													<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=0&id_jenis_laporan=Semua&status_laporan=Belum Divalidasi"); ?>">
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
													<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=0&id_jenis_laporan=Semua&status_laporan=Tidak Valid"); ?>">
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
													<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=0&id_jenis_laporan=Semua&status_laporan=Valid"); ?>">
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
													<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $dl['id_kecamatan'] . "&id_kelurahan=0&id_jenis_laporan=Semua&status_laporan=Semua"); ?>">
														<div class="progress">
														  <div class="progress-bar" role="progressbar" style="width: <?= ($dl['jumlah_laporan'] / $max_jumlah_laporan) * 100; ?>%;" aria-valuenow="<?= $dl['jumlah_laporan']; ?>"><h6 class="p-0 m-0"><?= $dl['jumlah_laporan']; ?></h6></div>
														</div>
													</a>
												<?php else: ?>
													0
												<?php endif ?>
											</td>
											<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan'): ?>
												<td class="align-middle text-center">
													<a href="<?= base_url('laporan/kelurahanByKecamatanId/' . $dl['id_kecamatan']); ?>" class="btn btn-sm btn-primary m-1"><i class="fas fa-fw fa-bars"></i></a>
												</td>
											<?php endif ?>
											<?php if ($dataUser['jabatan'] == 'Camat'): ?>
												<td class="align-middle text-center">
													<a href="<?= base_url('laporan/detailLaporanByKelurahanId/' . $dl['id_kelurahan']); ?>" class="btn btn-sm btn-primary m-1"><i class="fas fa-fw fa-bars"></i></a>
												</td>
											<?php endif ?>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>
</div>


<script>
$(document).ready(function() {
    <?php foreach ($jenis_laporan as $index => $djl): ?>
        $('#id_kecamatan<?= $index + 1 ?>').change(function() {
            var selectedValue = $(this).val();
            var url = '<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan="); ?>' + selectedValue + '&id_kelurahan=0&id_jenis_laporan=<?= $djl['id_jenis_laporan']; ?>&status_laporan=Semua';
            $('#link<?= $index + 1 ?>').attr('href', url);
        });

        $('#id_kelurahan<?= $index + 1 ?>').change(function() {
            var selectedValue = $(this).val();
            var url = '<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=0&id_kelurahan="); ?>' + selectedValue + '&id_jenis_laporan=<?= $djl['id_jenis_laporan']; ?>&status_laporan=Semua';
            $('#link<?= $index + 1 ?>').attr('href', url);
        });
    <?php endforeach ?>
});
</script>

