<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-center">
						<div class="col-lg header-title">
							<?php if (isset($nama_jenis_laporan)): ?>
								<h3 class="m-0"><i class="fas fa-fw fa-file-alt"></i> 
								<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Kepala Desa' || $dataUser['jabatan'] == 'Operator Desa'): ?>
									Laporan 
								<?php endif ?>
									<?= $nama_jenis_laporan; ?></h3>
							<?php elseif (isset($_GET['dari_tanggal'])): ?>
								<h3 class="m-0"><i class="fas fa-fw fa-copy"></i> Laporan Filter</h3>
							<?php else: ?>
								<h3 class="m-0"><i class="fas fa-fw fa-copy"></i> Semua Laporan</h3>
							<?php endif ?>
						</div>
						<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Kepala Desa' || $dataUser['jabatan'] == 'Operator Desa'): ?>
							<div class="col-lg-4 header-button">
								<?php if (isset($nama_jenis_laporan)): ?>
									<a href="<?= base_url('laporan/addLaporan/' . $nama_jenis_laporan); ?>" class="btn btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Laporan <?= $nama_jenis_laporan; ?></a>
								<?php else: ?>
									<a href="<?= base_url('laporan/addLaporan'); ?>" class="btn btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Laporan</a>
								<?php endif ?>
							</div>
						<?php endif ?>
					</div>
				</div>	
				<div class="card-body">
					<form method="get" action="<?= base_url('laporan/index'); ?>">
						<div class="row">
			              	<div class="col-lg-2">
				                <div class="form-group">
				                	<label for="dari_tanggal" class="form-label">Dari Tanggal</label>
					                <input type="date" class="form-control" name="dari_tanggal" id="dari_tanggal" value="<?= isset($_GET['dari_tanggal']) ? $_GET['dari_tanggal'] : date('Y-m-01'); ?>" required>
				                </div>
				            </div>
			              	<div class="col-lg-2">
				                <div class="form-group">
				                	<label for="sampai_tanggal" class="form-label">Sampai Tanggal</label>
				                	<input type="date" class="form-control" name="sampai_tanggal" id="sampai_tanggal" value="<?= isset($_GET['sampai_tanggal']) ? $_GET['sampai_tanggal'] : date('Y-m-d'); ?>" required>
				              	</div>
			              	</div>
							<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan' || $dataUser['jabatan'] == 'Kepala Bidang'): ?>
				              	<div class="col-lg-2">
				                	<div class="form-group">
										<label for="form_kecamatan">Kecamatan</label>
										<select name="id_kecamatan" class="custom-select <?= (form_error('id_kecamatan')) ? 'is-invalid' : ''; ?>" id="form_kecamatan">
										    <?php 
										    if (isset($_GET['id_kecamatan'])) {
										        $getKecamatanById = $this->db->get_where('kecamatan', ['id_kecamatan' => $_GET['id_kecamatan']])->row_array();
										    } else {
										        $getKecamatanById = null;
										    }
										    ?>
										    <?php if ($getKecamatanById != null): ?>
										        <option value="<?= $getKecamatanById['id_kecamatan']; ?>"><?= $getKecamatanById['nama_kecamatan']; ?></option>
										    <?php else: ?>
										        <option value="0">Pilih Kecamatan</option>
										    <?php endif ?>
										    <?php foreach ($kecamatan as $dataKecamatan): ?>
										        <?php if ($getKecamatanById == null || $dataKecamatan['id_kecamatan'] != $getKecamatanById['id_kecamatan']): ?>
										            <option value="<?= $dataKecamatan['id_kecamatan']; ?>"><?= $dataKecamatan['nama_kecamatan']; ?></option>
										        <?php endif ?>
										    <?php endforeach ?>
										</select>
									</div>
								</div>
				              	<div class="col-lg-2">
									<div class="form-group">
										<label for="form_kelurahan">Kelurahan</label>
										<select id="form_kelurahan" class="custom-select <?= (form_error('id_kelurahan')) ? 'is-invalid' : ''; ?>" name="id_kelurahan">
										    <?php 
										    if (isset($_GET['id_kecamatan'])) {
										        $getKelurahanByIdKecamatan = $this->db->get_where('kelurahan', ['id_kecamatan' => $_GET['id_kecamatan']])->result_array();
										    } else {
										        $getKelurahanByIdKecamatan = null;
										    }
										    if (isset($_GET['id_kelurahan'])) {
										        $getNamaKelurahanByIdKelurahan = $this->db->get_where('kelurahan', ['id_kelurahan' => $_GET['id_kelurahan']])->row_array();
										    } else {
										        $getNamaKelurahanByIdKelurahan = null;
										    }
										    ?>
										    <?php if ($getNamaKelurahanByIdKelurahan != null): ?>
										        <option value="<?= $_GET['id_kelurahan']; ?>"><?= $getNamaKelurahanByIdKelurahan['nama_kelurahan']; ?></option>
										        <option value="0">Pilih Kelurahan</option>
										        <?php foreach ($getKelurahanByIdKecamatan as $dataKelurahan): ?>
										            <?php if ($dataKelurahan['id_kelurahan'] != $_GET['id_kelurahan']): ?>
										                <option value="<?= $dataKelurahan['id_kelurahan']; ?>"><?= $dataKelurahan['nama_kelurahan']; ?></option>
										            <?php endif ?>
										        <?php endforeach ?>
										    <?php else: ?>
										        <option value="0">Pilih Kelurahan</option>
										        <?php if ($getKelurahanByIdKecamatan != null): ?>
										            <?php foreach ($getKelurahanByIdKecamatan as $dataKelurahan): ?>
										                <option value="<?= $dataKelurahan['id_kelurahan']; ?>"><?= $dataKelurahan['nama_kelurahan']; ?></option>
										            <?php endforeach ?>
										        <?php endif ?>
										    <?php endif ?>
										</select>
									</div>
				              	</div>
				            <?php elseif ($dataUser['jabatan'] == 'Camat'): ?>
				              	<div class="col-lg-2">
									<div class="form-group">
										<label for="form_kelurahan">Kelurahan</label>
										<select id="form_kelurahan" class="custom-select <?= (form_error('id_kelurahan')) ? 'is-invalid' : ''; ?>" name="id_kelurahan">
										    <?php 
										    if (isset($dataUser['id_kecamatan'])) {
										    	$this->db->order_by('nama_kelurahan', 'asc');
										        $getKelurahanByIdKecamatan = $this->db->get_where('kelurahan', ['id_kecamatan' => $dataUser['id_kecamatan']])->result_array();
										    } else {
										        $getKelurahanByIdKecamatan = null;
										    }
										    if (isset($_GET['id_kelurahan'])) {
										        $getNamaKelurahanByIdKelurahan = $this->db->get_where('kelurahan', ['id_kelurahan' => $_GET['id_kelurahan']])->row_array();
										    } else {
										        $getNamaKelurahanByIdKelurahan = null;
										    }
										    ?>
										    <?php if ($getNamaKelurahanByIdKelurahan != null): ?>
										        <option value="<?= $_GET['id_kelurahan']; ?>"><?= $getNamaKelurahanByIdKelurahan['nama_kelurahan']; ?></option>
										        <option value="0">Pilih Kelurahan</option>
										        <?php foreach ($getKelurahanByIdKecamatan as $dataKelurahan): ?>
										            <?php if ($dataKelurahan['id_kelurahan'] != $_GET['id_kelurahan']): ?>
										                <option value="<?= $dataKelurahan['id_kelurahan']; ?>"><?= $dataKelurahan['nama_kelurahan']; ?></option>
										            <?php endif ?>
										        <?php endforeach ?>
										    <?php else: ?>
										        <option value="0">Pilih Kelurahan</option>
										        <?php if ($getKelurahanByIdKecamatan != null): ?>
										            <?php foreach ($getKelurahanByIdKecamatan as $dataKelurahan): ?>
										                <option value="<?= $dataKelurahan['id_kelurahan']; ?>"><?= $dataKelurahan['nama_kelurahan']; ?></option>
										            <?php endforeach ?>
										        <?php endif ?>
										    <?php endif ?>
										</select>
									</div>
				              	</div>
				            <?php endif ?>
							<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Pimpinan' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Desa'): ?>
				              	<div class="col-lg-2">
									<div class="form-group">
										<label for="id_jenis_laporan">Jenis Laporan</label>
										<select id="id_jenis_laporan" class="custom-select <?= (form_error('id_jenis_laporan')) ? 'is-invalid' : ''; ?>" name="id_jenis_laporan">
											<?php if (isset($_GET['id_jenis_laporan'])): ?>
												<?php if ($_GET['id_jenis_laporan'] != 0): ?>
													<?php 
														$getJenisLaporanById = $this->db->get_where('jenis_laporan', ['id_jenis_laporan' => $_GET['id_jenis_laporan']])->row_array();
													?>
													<option value="<?= $_GET['id_jenis_laporan']; ?>"><?= $getJenisLaporanById['jenis_laporan']; ?></option>
												<?php endif ?>
											<?php endif ?>
											<option value="0">Semua</option>
											<?php foreach ($jenis_laporan as $djl): ?>
												<?php if ($djl['id_jenis_laporan'] != $_GET['id_jenis_laporan']): ?>
										        	<option value="<?= $djl['id_jenis_laporan']; ?>"><?= $djl['jenis_laporan']; ?></option>
											    <?php endif ?>
											<?php endforeach ?>
										</select>
									</div>
				              	</div>
				            <?php elseif ($dataUser['jabatan'] == 'Kepala Bidang'): ?>
				              	<div class="col-lg-2">
									<div class="form-group">
										<label for="id_jenis_laporan">Jenis Laporan</label>
										<select id="id_jenis_laporan" class="custom-select <?= (form_error('id_jenis_laporan')) ? 'is-invalid' : ''; ?>" name="id_jenis_laporan">
											<?php if (isset($_GET['id_jenis_laporan'])): ?>
												<?php if ($_GET['id_jenis_laporan'] != 0): ?>
													<?php 
														$getJenisLaporanById = $this->db->get_where('jenis_laporan', ['id_jenis_laporan' => $_GET['id_jenis_laporan']])->row_array();
													?>
													<option value="<?= $_GET['id_jenis_laporan']; ?>"><?= $getJenisLaporanById['jenis_laporan']; ?></option>
												<?php endif ?>
											<?php endif ?>
											<option value="0">Semua</option>
											<?php foreach ($jenis_laporan_kabid as $djl): ?>
												<?php if ($djl['id_jenis_laporan'] != $_GET['id_jenis_laporan']): ?>
										        	<option value="<?= $djl['id_jenis_laporan']; ?>"><?= $djl['jenis_laporan']; ?></option>
											    <?php endif ?>
											<?php endforeach ?>
										</select>
									</div>
				              	</div>
			              	<?php else: ?>
			              		<div class="col-lg-2">
									<div class="form-group">
										<label for="id_jenis_laporan_disabled">Jenis Laporan</label>
										<select id="id_jenis_laporan_disabled" class="custom-select <?= (form_error('id_jenis_laporan_disabled')) ? 'is-invalid' : ''; ?>" name="id_jenis_laporan_disabled" disabled>
											<option value="<?= $dataUser['id_jenis_laporan']; ?>"><?= $dataUser['jenis_laporan']; ?></option>
										</select>
										<input type="hidden" name="id_jenis_laporan" value="<?= $dataUser['id_jenis_laporan']; ?>">
									</div>
				              	</div>
				            <?php endif ?>
			              	<div class="col-lg-2">
								<div class="form-group">
									<label for="status_laporan">Status Laporan</label>
									<select id="status_laporan" class="custom-select <?= (form_error('status_laporan')) ? 'is-invalid' : ''; ?>" name="status_laporan">
										<?php if (isset($_GET['status_laporan'])): ?>
											<?php if ($_GET['status_laporan'] == "Semua"): ?>
												<option value="Semua">Semua</option>
												<option value="Belum Divalidasi">Belum Divalidasi</option>
												<option value="Valid">Valid</option>
												<option value="Tidak Valid">Tidak Valid</option>
											<?php elseif ($_GET['status_laporan'] == "Valid"): ?>	
												<option value="Valid">Valid</option>
												<option value="Semua">Semua</option>
												<option value="Belum Divalidasi">Belum Divalidasi</option>
												<option value="Tidak Valid">Tidak Valid</option>
											<?php elseif ($_GET['status_laporan'] == "Tidak Valid"): ?>
												<option value="Tidak Valid">Tidak Valid</option>	
												<option value="Semua">Semua</option>
												<option value="Belum Divalidasi">Belum Divalidasi</option>
												<option value="Valid">Valid</option>
											<?php elseif ($_GET['status_laporan'] == "Belum Divalidasi"): ?>
												<option value="Belum Divalidasi">Belum Divalidasi</option>
												<option value="Semua">Semua</option>
												<option value="Valid">Valid</option>
												<option value="Tidak Valid">Tidak Valid</option>	
											<?php endif ?>
										<?php else: ?>
											<option value="Semua">Semua</option>
											<option value="Belum Divalidasi">Belum Divalidasi</option>
											<option value="Valid">Valid</option>
											<option value="Tidak Valid">Tidak Valid</option>
										<?php endif ?>
									</select>
								</div>
			              	</div>
						</div>
		              	<div class="row">
			                <div class="col">
			                  	<button type="submit" name="btnFilter" class="btn btn-primary"><i class="fas fa-fw fa-filter"></i> Filter</button>
			                  	<?php if(isset($_GET['dari_tanggal'])): ?>
			                   		<a target="_blank" href="<?= base_url('laporan/print?dari_tanggal=' . $_GET['dari_tanggal'] . '&sampai_tanggal=' . $_GET['sampai_tanggal'] . '&id_jenis_laporan=' . $_GET['id_jenis_laporan'] . '&status_laporan=' . $_GET['status_laporan']); ?>" name="btnPrint" class="btn btn-success"><i class="fas fa-fw fa-print"></i> Print Filter</a>
			                   		<a href="<?= base_url('laporan/index'); ?>" name="btnPrint" class="btn btn-danger"><i class="fas fa-fw fa-times"></i> Reset</a>
			                   	<?php else: ?>
			                   		<a target="_blank" href="<?= base_url('laporan/print'); ?>" name="btnPrint" class="btn btn-success"><i class="fas fa-fw fa-print"></i> Print</a>
			                  	<?php endif; ?>
				              	<hr>

				              	<?php
					              	$jml_laporan = 0;
									$jml_laporan_valid = 0;
									$jml_laporan_tidak_valid = 0;
									$jml_laporan_belum_divalidasi = 0; 

				              		foreach ($laporan as $dlap) {
										if ($dlap['status_laporan'] == 'Valid') {
											$jml_laporan_valid++;
										} elseif ($dlap['status_laporan'] == 'Tidak Valid') {
											$jml_laporan_tidak_valid++;
										} elseif ($dlap['status_laporan'] == 'Belum Divalidasi') {
											$jml_laporan_belum_divalidasi++; 
										}

										$jml_laporan++;
				              		}
				              	?>
								<span class="p-2 rounded bg-primary border">Total Laporan: <?= $jml_laporan; ?></span>
								<span class="p-2 rounded bg-success"><i class="fas fa-fw fa-check-circle"></i> Valid: <?= $jml_laporan_valid; ?></span>
								<span class="p-2 rounded bg-danger"><i class="fas fa-fw fa-times-circle"></i> Tidak Valid: <?= $jml_laporan_tidak_valid; ?></span>
								<span class="p-2 rounded bg-secondary"><i class="fas fa-fw fa-exclamation-circle"></i> Belum Divalidasi: <?= $jml_laporan_belum_divalidasi; ?></span>
			                </div>
		              	</div>
		            </form>
					<hr>
					
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="table_id">
							<thead class="thead-dark">
								<tr>
									<th class="align-middle">Status Laporan</th>
									<th class="align-middle">Judul Laporan</th>
									<th class="align-middle">Tanggal Laporan</th>
									<th class="align-middle">Kecamatan</th>
									<th class="align-middle">Kelurahan/Desa</th>
									<th class="align-middle">Bidang</th>
									<?php if (!isset($nama_jenis_laporan)): ?>
										<th class="align-middle">Jenis Laporan</th>
									<?php endif ?>
									<th class="align-middle">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($laporan as $dl): ?>
									<tr>
										<td class="align-middle">
										<?php if ($dl['status_laporan'] == 'Belum Divalidasi'): ?>
											<a href="<?= base_url('laporan/detailLaporan/' . $dl['id_laporan']); ?>" class="btn btn-secondary"><i class="fas fa-fw fa-exclamation-circle"></i> <?= $dl['status_laporan']; ?></a>
										<?php elseif ($dl['status_laporan'] == 'Valid'): ?>
											<a href="<?= base_url('laporan/detailLaporan/' . $dl['id_laporan']); ?>" class="btn btn-success"><i class="fas fa-fw fa-check-circle"></i> <?= $dl['status_laporan']; ?></a>
										<?php else: ?>
											<a href="<?= base_url('laporan/detailLaporan/' . $dl['id_laporan']); ?>" class="btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> <?= $dl['status_laporan']; ?></a>
										<?php endif ?>
										</td>
										<td class="align-middle"><?= $dl['judul_laporan']; ?></td>
										<td class="align-middle"><?= date('d/M/Y, H:i', strtotime($dl['tgl_laporan'])); ?></td>
										<td class="align-middle"><?= $dl['nama_kecamatan']; ?></td>
										<td class="align-middle"><?= $dl['nama_kelurahan']; ?></td>
											<td class="align-middle"><?= $dl['nama_bidang']; ?></td>
										<?php if (!isset($nama_jenis_laporan)): ?>
											<td class="align-middle"><?= $dl['jenis_laporan']; ?></td>
										<?php endif ?>
										<td class="align-middle text-center">
											<a href="<?= base_url('laporan/detailLaporan/' . $dl['id_laporan']); ?>" class="btn btn-sm btn-info m-1"><i class="fas fa-fw fa-bars"></i></a>
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
