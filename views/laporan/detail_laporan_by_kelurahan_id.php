<?php
    $start_date = '1970-01-01';
    $end_date = date('Y-m-d'); 

    $max_jumlah_laporan_belum_divalidasi = 1;
    $jumlah_laporan_belum_divalidasi = 0;
    $max_jumlah_laporan_tidak_valid = 1;
    $jumlah_laporan_tidak_valid = 0;
    $max_jumlah_laporan_valid = 1;
    $jumlah_laporan_valid = 0;

    // Calculate counts for different types of reports
    foreach ($laporan as $datlap) {
        if ($datlap['jumlah_laporan_belum_divalidasi'] > $max_jumlah_laporan_belum_divalidasi) {
            $max_jumlah_laporan_belum_divalidasi = $datlap['jumlah_laporan_belum_divalidasi'];
        }
        if ($datlap['jumlah_laporan_tidak_valid'] > $max_jumlah_laporan_tidak_valid) {
            $max_jumlah_laporan_tidak_valid = $datlap['jumlah_laporan_tidak_valid'];
        }
        if ($datlap['jumlah_laporan_valid'] > $max_jumlah_laporan_valid) {
            $max_jumlah_laporan_valid = $datlap['jumlah_laporan_valid'];
        }
        // Accumulate counts for each type of report
        $jumlah_laporan_belum_divalidasi += $datlap['jumlah_laporan_belum_divalidasi'];
        $jumlah_laporan_tidak_valid += $datlap['jumlah_laporan_tidak_valid'];
        $jumlah_laporan_valid += $datlap['jumlah_laporan_valid'];
    } 

    // Calculate total number of reports
    $jumlah_laporan = $jumlah_laporan_belum_divalidasi + $jumlah_laporan_tidak_valid + $jumlah_laporan_valid;
    
 ?>
<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-center">
						<div class="col-lg header-title">
							<h3 class="m-0"><i class="fas fa-fw fa-building"></i> Detail Laporan Kelurahan/Desa - <?= $kelurahan['nama_kelurahan']; ?></h3>
						</div>
						<div class="col-lg-4 header-button">
							<a href="javascript:history.back()" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<h3>Total Laporan: <?= $jumlah_laporan; ?></h3>
					<hr>

					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead class="thead-dark">
								<h4>Status Laporan: Belum Divalidasi</h4>
								<tr>
									<th class="align-middle">Jenis Laporan</th>
									<th class="jml-laporan align-middle">Jumlah Laporan</th>
								</tr>
							</thead>
							<tbody>
								
								<?php foreach ($jenis_laporan as $djl): ?>
									<tr>
										<?php 
											$this->db->select('kelurahan.*, laporan.*');
											$this->db->select('COUNT(laporan.id_laporan) as jumlah_jenis_laporan');
											$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Belum Divalidasi" THEN 1 ELSE 0 END) AS jumlah_laporan_belum_divalidasi');
											$this->db->join('kelurahan', 'kelurahan.id_kelurahan = laporan.id_kelurahan', 'left');
											$this->db->group_by('laporan.id_kelurahan');
											$result = $this->db->get_where('laporan', [
											    'laporan.id_jenis_laporan' => $djl['id_jenis_laporan'],
											    'laporan.id_kelurahan' => $kelurahan['id_kelurahan']
											])->row_array();
										?>
										<td class="align-middle"><?= $djl['jenis_laporan']; ?></td>
										<td class="align-middle">
											<?php if ($result !== null && isset($result['jumlah_laporan_belum_divalidasi']) && $result['jumlah_laporan_belum_divalidasi'] != 0): ?>
												<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $kelurahan['id_kecamatan'] . "&id_kelurahan=".$kelurahan['id_kelurahan']."&id_jenis_laporan=".$djl['id_jenis_laporan']."&status_laporan=Belum Divalidasi"); ?>">
													<div class="progress">
													  <div class="progress-bar bg-secondary" role="progressbar" style="width: <?= ($result['jumlah_laporan_belum_divalidasi'] / $max_jumlah_laporan_belum_divalidasi) * 100; ?>%;" aria-valuenow="<?= $result['jumlah_laporan_belum_divalidasi']; ?>"><h6 class="p-0 m-0"><?= $result['jumlah_laporan_belum_divalidasi']; ?></h6>
													  </div>
													</div>
												</a>
											<?php else: ?>
												0
											<?php endif ?>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
							<tfoot style="border-top: 2px solid black;">
								<tr>
									<th class="align-middle">Total Laporan Belum Divalidasi</th>
									<th class="align-middle">
										<?php if ($jumlah_laporan_belum_divalidasi != 0): ?>
											<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $kelurahan['id_kecamatan'] . "&id_kelurahan=".$kelurahan['id_kelurahan']."&id_jenis_laporan=Semua&status_laporan=Belum Divalidasi"); ?>">
												<div class="progress">
												  <div class="progress-bar bg-secondary" role="progressbar" style="width: <?= ($jumlah_laporan_belum_divalidasi / $max_jumlah_laporan_belum_divalidasi) * 100; ?>%;" aria-valuenow="<?= $jumlah_laporan_belum_divalidasi; ?>"><h6 class="p-0 m-0"><?= $jumlah_laporan_belum_divalidasi; ?></h6>
												  </div>
												</div>
											</a>
										<?php else: ?>
											0
										<?php endif ?>
									</th>
								</tr>
							</tfoot>
						</table>
					</div>

					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead class="thead-dark">
								<h4>Status Laporan: Tidak Valid</h4>
								<tr>
									<th class="align-middle">Jenis Laporan</th>
									<th class="jml-laporan align-middle">Jumlah Laporan</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($jenis_laporan as $djl): ?>
									<tr>
										<?php 
											$this->db->select('kelurahan.*, laporan.*');
											$this->db->select('COUNT(laporan.id_laporan) as jumlah_jenis_laporan');
											$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Tidak Valid" THEN 1 ELSE 0 END) AS jumlah_laporan_tidak_valid');
											$this->db->join('kelurahan', 'kelurahan.id_kelurahan = laporan.id_kelurahan', 'left');
											$this->db->group_by('laporan.id_kelurahan');
											$result = $this->db->get_where('laporan', [
											    'laporan.id_jenis_laporan' => $djl['id_jenis_laporan'],
											    'laporan.id_kelurahan' => $kelurahan['id_kelurahan']
											])->row_array();
										?>
										<td class="align-middle"><?= $djl['jenis_laporan']; ?></td>
										<td class="align-middle">
											<?php if ($result !== null && isset($result['jumlah_laporan_tidak_valid']) && $result['jumlah_laporan_tidak_valid'] != 0): ?>
												<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $kelurahan['id_kecamatan'] . "&id_kelurahan=".$kelurahan['id_kelurahan']."&id_jenis_laporan=".$djl['id_jenis_laporan']."&status_laporan=Tidak Valid"); ?>">
													<div class="progress">
													  <div class="progress-bar bg-danger" role="progressbar" style="width: <?= ($result['jumlah_laporan_tidak_valid'] / $max_jumlah_laporan_tidak_valid) * 100; ?>%;" aria-valuenow="<?= $result['jumlah_laporan_tidak_valid']; ?>"><h6 class="p-0 m-0"><?= $result['jumlah_laporan_tidak_valid']; ?></h6>
													  </div>
													</div>
												</a>
											<?php else: ?>
												0
											<?php endif ?>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
							<tfoot style="border-top: 2px solid black;">
								<tr>
									<th class="align-middle">Total Laporan Tidak Valid</th>
									<th class="align-middle">
										<?php if ($jumlah_laporan_tidak_valid != 0): ?>
											<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $kelurahan['id_kecamatan'] . "&id_kelurahan=".$kelurahan['id_kelurahan']."&id_jenis_laporan=Semua&status_laporan=Tidak Valid"); ?>">
												<div class="progress">
												  <div class="progress-bar bg-danger" role="progressbar" style="width: <?= ($jumlah_laporan_tidak_valid / $max_jumlah_laporan_tidak_valid) * 100; ?>%;" aria-valuenow="<?= $jumlah_laporan_tidak_valid; ?>"><h6 class="p-0 m-0"><?= $jumlah_laporan_tidak_valid; ?></h6>
												  </div>
												</div>
											</a>
										<?php else: ?>
											0
										<?php endif ?>
									</th>
								</tr>
							</tfoot>
						</table>
					</div>

					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead class="thead-dark">
								<h4>Status Laporan: Valid</h4>
								<tr>
									<th class="align-middle">Jenis Laporan</th>
									<th class="jml-laporan align-middle">Jumlah Laporan</th>
								</tr>
							</thead>
							<tbody>
								
								<?php foreach ($jenis_laporan as $djl): ?>
									<tr>
										<?php 
											$this->db->select('kelurahan.*, laporan.*');
											$this->db->select('COUNT(laporan.id_laporan) as jumlah_jenis_laporan');
											$this->db->select('SUM(CASE WHEN laporan.status_laporan = "Valid" THEN 1 ELSE 0 END) AS jumlah_laporan_valid');
											$this->db->join('kelurahan', 'kelurahan.id_kelurahan = laporan.id_kelurahan', 'left');
											$this->db->group_by('laporan.id_kelurahan');
											$result = $this->db->get_where('laporan', [
											    'laporan.id_jenis_laporan' => $djl['id_jenis_laporan'],
											    'laporan.id_kelurahan' => $kelurahan['id_kelurahan']
											])->row_array();
										?>
										<td class="align-middle"><?= $djl['jenis_laporan']; ?></td>
										<td class="align-middle">
											<?php if ($result !== null && isset($result['jumlah_laporan_valid']) && $result['jumlah_laporan_valid'] != 0): ?>
												<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $kelurahan['id_kecamatan'] . "&id_kelurahan=".$kelurahan['id_kelurahan']."&id_jenis_laporan=".$djl['id_jenis_laporan']."&status_laporan=Valid"); ?>">
													<div class="progress">
													  <div class="progress-bar bg-success" role="progressbar" style="width: <?= ($result['jumlah_laporan_valid'] / $max_jumlah_laporan_valid) * 100; ?>%;" aria-valuenow="<?= $result['jumlah_laporan_valid']; ?>"><h6 class="p-0 m-0"><?= $result['jumlah_laporan_valid']; ?></h6>
													  </div>
													</div>
												</a>
											<?php else: ?>
												0
											<?php endif ?>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
							<tfoot style="border-top: 2px solid black;">
								<tr>
									<th class="align-middle">Total Laporan Valid</th>
									<th class="align-middle">
										<?php if ($jumlah_laporan_valid != 0): ?>
											<a href="<?= base_url("laporan/index?dari_tanggal=$start_date&sampai_tanggal=$end_date&id_kecamatan=" . $kelurahan['id_kecamatan'] . "&id_kelurahan=".$kelurahan['id_kelurahan']."&id_jenis_laporan=Semua&status_laporan=Valid"); ?>">
												<div class="progress">
												  <div class="progress-bar bg-success" role="progressbar" style="width: <?= ($jumlah_laporan_valid / $max_jumlah_laporan_valid) * 100; ?>%;" aria-valuenow="<?= $jumlah_laporan_valid; ?>"><h6 class="p-0 m-0"><?= $jumlah_laporan_valid; ?></h6>
												  </div>
												</div>
											</a>
										<?php else: ?>
											0
										<?php endif ?>
									</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
