<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-center">
						<div class="col-lg header-title">
							<h3 class="m-0"><i class="fas fa-fw fa-file-alt"></i> Detail Laporan: <?= $laporan['judul_laporan']; ?></h3>
						</div>
						<div class="col-lg-4 header-button">
							<a href="javascript:history.back()" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<p><strong>Jenis Laporan:</strong> <br> <?= $laporan['jenis_laporan']; ?></p>
					<p><strong>Judul Laporan:</strong> <br> <?= $laporan['judul_laporan']; ?></p>
					<p><strong>Uraian Laporan:</strong> <br> <?= $laporan['uraian_laporan']; ?></p>
					<p><strong>Tanggal Laporan:</strong> <br> <?= date('d-M-Y \P\u\k\u\l: H:i', strtotime($laporan['tgl_laporan'])); ?></p>
					<p><strong>Tahun Kegiatan:</strong> <br> <?= $laporan['tahun_kegiatan']; ?></p>
					<p><strong>Nama Kecamatan:</strong> <br> <?= $laporan['nama_kecamatan']; ?></p>
					<p><strong>Nama Kelurahan/Desa:</strong> <br> <?= $laporan['nama_kelurahan']; ?></p>
					<p><strong>File Laporan:</strong> 
					<?php 
						$file_laporan = $this->db->get_where('file_laporan', ['id_laporan' => $laporan['id_laporan']])->result_array();
					?>
					<?php if ($file_laporan != null): ?>
						<ul>
							<?php foreach ($file_laporan as $dfl): ?>
								<li><a class="text-dark" download href="<?= base_url('file/downloadOriginal/'. $dfl['file_laporan']); ?>"><?= $dfl['file_laporan']; ?></a> - <a download href="<?= base_url('file/downloadOriginal/'. $dfl['file_laporan']); ?>">Download File Asli</a></li>	
							<?php endforeach ?>
						</ul>
						<!-- <?php if ($dataUser['jabatan'] == 'Administrator'): ?>
							<a class="btn btn-primary" href="<?= base_url('laporan/download_all_files/' . $laporan['id_laporan']); ?>"><i class="fas fa-fw fa-download"></i> Unduh Semua File</a>
						<?php endif ?> -->
					<?php else: ?>
						<br>-
					<?php endif ?>
					</p>
					
					<p><strong>Laporan dibuat oleh:</strong> <br> <?= $laporan['username']; ?></p>
					<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Kepala Desa' || $dataUser['jabatan'] == 'Operator Desa'): ?>
						<?php if ($dataUser['jabatan'] == 'Administrator' || $laporan['status_laporan'] == 'Belum Divalidasi'): ?>
							<hr>
							<a href="<?= base_url('laporan/editLaporan/' . $laporan['id_laporan']); ?>" class="btn btn-sm btn-success m-1"><i class="fas fa-fw fa-edit"></i></a>
							<a href="<?= base_url('laporan/removeLaporan/' . $laporan['id_laporan']); ?>" class="btn btn-sm btn-danger m-1 btn-delete" data-nama="<?= $laporan['judul_laporan']; ?>"><i class="fas fa-fw fa-fw fa-trash"></i></a>
						<?php endif ?>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-between">
						<div class="col-lg-8 my-auto">
							<h5 class="my-auto"><i class="fas fa-fw fa-scroll"></i> Status Laporan</h5>
						</div>
						<!-- Validasi -->
						<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang'): ?>
							<div class="col-lg text-right">
								<a href="<?= base_url('laporan/editLaporan/' . $laporan['id_laporan']); ?>"></a>
								<button type="button" class="btn btn-sm btn-success m-1" data-toggle="modal" data-target="#editStatusModal">
								  <i class="fas fa-fw fa-edit"></i>
								</button>
							</div>
						<?php endif ?>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<strong>Status Laporan:</strong><br>
						<?php if ($laporan['status_laporan'] == 'Belum Divalidasi'): ?>
							<button <?= ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang') ? 'data-toggle="modal" data-target="#editStatusModal"' : ''; ?> class="mt-2 btn btn-secondary"><i class="fas fa-fw fa-exclamation-circle"></i> <?= $laporan['status_laporan']; ?></button>
						<?php elseif ($laporan['status_laporan'] == 'Valid'): ?>
							<button <?= ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang') ? 'data-toggle="modal" data-target="#editStatusModal"' : ''; ?> class="mt-2 btn btn-success"><i class="fas fa-fw fa-check-circle"></i> <?= $laporan['status_laporan']; ?></button>
						<?php else: ?>
							<button <?= ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang') ? 'data-toggle="modal" data-target="#editStatusModal"' : ''; ?> class="mt-2 btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> <?= $laporan['status_laporan']; ?></button>
						<?php endif ?>
					</div>
					<div class="form-group">
						<strong>Transparansi Laporan:</strong><br>
						<?php if ($laporan['status_laporan'] == 'Valid'): ?>
							<?php if ($laporan['transparansi_laporan'] == 'Tertutup'): ?>
								<button <?= (($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang') && $laporan['status_laporan'] == 'Valid') ? 'data-toggle="modal" data-target="#editTransparansiModal"' : ''; ?> class="mt-2 btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> <?= $laporan['transparansi_laporan']; ?></button>
							<?php elseif ($laporan['transparansi_laporan'] == 'Terbuka'): ?>
								<button <?= (($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang') && $laporan['status_laporan'] == 'Valid') ? 'data-toggle="modal" data-target="#editTransparansiModal"' : ''; ?> class="mt-2 btn btn-success"><i class="fas fa-fw fa-check-circle"></i> <?= $laporan['transparansi_laporan']; ?></button>
							<?php else: ?>
								<button <?= (($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang') && $laporan['status_laporan'] == 'Valid') ? 'data-toggle="modal" data-target="#editTransparansiModal"' : ''; ?> class="mt-2 btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tertutup</button>
							<?php endif ?>
						<?php else: ?>
							<button type="button" id="transparansiButton" class="mt-2 btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tertutup</button>
						<?php endif ?>
						<?php 
							$id_laporan = $laporan['id_laporan'];
							$this->db->order_by('id_transparansi_laporan', 'desc');
							$transparansi_laporan = $this->db->get_where('transparansi_laporan', ['id_laporan' => $id_laporan])->row_array();
						?>
					</div>
					<div class="form-group">
            <p><strong>Tanggal Transparansi Laporan:</strong> <br> 
            	<?php if ($transparansi_laporan !== null): ?>
	            	<?= date('d/m/Y, H:i', strtotime($transparansi_laporan['tgl_transparansi_laporan'])); ?>
	            <?php else: ?>
	            	-
            	<?php endif ?>
            </p>
					</div>
					<?php if (isset($validasi_laporan)): ?>
						<div class="accordion" id="accordionValidasiLaporan">
							<?php foreach ($validasi_laporan as $index => $dvl): ?>
						    <div class="card">
					        <div class="card-header" id="heading<?= $index ?>">
				            <h2 class="mb-0">
			                <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $index ?>" aria-expanded="true" aria-controls="collapse<?= $index ?>">
		                    <strong>Revisi <?= $index + 1 ?></strong>
			                </button>
				            </h2>
					        </div>

					        <div id="collapse<?= $index ?>" class="collapse <?= $index === count($validasi_laporan) - 1 ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-parent="#accordionValidasiLaporan">
				            <div class="card-body">
		                	<p><strong>Catatan Validasi:</strong> <br> <?= ($dvl['catatan_validasi']) ? $dvl['catatan_validasi'] : '-'; ?></p>
			                <p><strong>Tanggal Validasi Laporan:</strong> <br> <?= date('d/m/Y, H:i', strtotime($dvl['tgl_validasi_laporan'])); ?></p>
			                <p><strong>Divalidasi oleh:</strong> <br> <?= $dvl['username']; ?></p>
				            </div>
					        </div>
						    </div>
							<?php endforeach ?>

						</div>
						<?php if ($dataUser['jabatan'] == 'Kepala Desa' || $dataUser['jabatan'] == 'Operator Desa'): ?>
							<?php if ($laporan['status_laporan'] != 'Valid'): ?>
								<a class="btn btn-success" href="<?= base_url('laporan/editLaporan/' . $laporan['id_laporan'] . '/revisi'); ?>"><i class="fas fa-fw fa-edit"></i> Revisi</a>
							<?php endif ?>
						<?php endif ?>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	<?php if ($file_laporan != null): ?>
	    <div class="row mb-2">
	        <?php foreach($file_laporan as $index => $file): ?>
            <div class="col-lg-12 p-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="my-auto"><i class="fas fa-fw fa-search"></i> Preview File - <?= $file['file_laporan']; ?></h3>
                    </div>
                    <div class="card-body">
                        <div id="pdf-preview-<?= $index; ?>" class="overflow-hidden text-center py-2 col-preview w-100" style="height: 1250px;"></div>
                    </div>
                </div>
            </div>
            <script>
              var fileURL_<?= $index; ?> = "<?= site_url('serve/' . $file['file_laporan']); ?>";
              var fileType_<?= $index; ?> = "<?= pathinfo($file['file_laporan'], PATHINFO_EXTENSION); ?>";
              var fileDiv_<?= $index; ?> = document.getElementById('pdf-preview-<?= $index; ?>');

              // Convert file URL to blob
              fetch(fileURL_<?= $index; ?>)
                  .then(response => response.blob())
                  .then(blob => {
                      // Create a new File object
                      var file = new File([blob], "<?= $file['file_laporan']; ?>", { type: blob.type });
                      // Create a new object for each file
                      var fileObj = document.createElement('object');
                      fileObj.className = 'file-preview';
                      fileObj.data = fileURL_<?= $index; ?>; // Set data to a URL representing the file content
                      fileObj.style = "width:100%;min-height:100%";

                      // Append the file div to the pdf-preview container
                      fileDiv_<?= $index; ?>.appendChild(fileObj);

                  })
                  .catch(error => console.error('Error loading file:', error));
            </script>
	        <?php endforeach; ?>
	    </div>
	<?php endif ?>

</div>

<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Camat' || $dataUser['jabatan'] == 'Kepala Bidang'): ?>
<!-- Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('laporan/validasiLaporan/' . $laporan['id_laporan']); ?>" method="post">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="editStatusModalLabel"><i class="fas fa-fw fa-edit"></i> Ubah Status Laporan</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
					<div class="form-group">
						<label for="catatan_validasi">Catatan Validasi (Opsional)</label>
						<textarea id="catatan_validasi" class="form-control <?= (form_error('catatan_validasi')) ? 'is-invalid' : ''; ?>" name="catatan_validasi"><?= (form_error('catatan_validasi')) ? set_value('catatan_validasi') : (isset($last_validasi_laporan['catatan_validasi']) ? $last_validasi_laporan['catatan_validasi'] : ''); ?></textarea>
						<div class="invalid-feedback">
              <?= form_error('catatan_validasi'); ?>
            </div>
					</div>
					<div class="form-group">
		        <label>Status Laporan:</label><br>
		        <?php if (isset($last_validasi_laporan['catatan_validasi'])): ?>
					    <?php if ($laporan['status_laporan'] == "Valid"): ?>
				        <input type="radio" id="valid" name="status_laporan" value="Valid" checked required>
				        <label for="valid" class="btn btn-success"><i class="fas fa-fw fa-check-circle"></i> Valid</label><br>
				        <input type="radio" id="tidak_valid" name="status_laporan" value="Tidak Valid" required>
				        <label for="tidak_valid" class="btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tidak Valid</label><br>
					    <?php elseif ($laporan['status_laporan'] == "Tidak Valid"): ?>
				        <input type="radio" id="valid" name="status_laporan" value="Valid" required>
				        <label for="valid" class="btn btn-success"><i class="fas fa-fw fa-check-circle"></i> Valid</label><br>
				        <input type="radio" id="tidak_valid" name="status_laporan" value="Tidak Valid" checked required>
				        <label for="tidak_valid" class="btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tidak Valid</label><br>
					    <?php else: ?>
					    	<input type="radio" id="valid" name="status_laporan" value="Valid" required>
				        <label for="valid" class="btn btn-success"><i class="fas fa-fw fa-check-circle"></i> Valid</label><br>
				        <input type="radio" id="tidak_valid" name="status_laporan" value="Tidak Valid" required>
				        <label for="tidak_valid" class="btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tidak Valid</label><br>
					    <?php endif ?>
						<?php else: ?>
					    <input type="radio" id="valid" name="status_laporan" value="Valid" required>
					    <label for="valid" class="btn btn-success"><i class="fas fa-fw fa-check-circle"></i> Valid</label><br>
					    <input type="radio" id="tidak_valid" name="status_laporan" value="Tidak Valid" required>
					    <label for="tidak_valid" class="btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tidak Valid</label><br>
						<?php endif ?>
			    </div>
		    </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
					<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
	      </div>
	    </div>
		</form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editTransparansiModal" tabindex="-1" aria-labelledby="editTransparansiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('laporan/transparansiLaporan/' . $laporan['id_laporan']); ?>" method="post">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="editTransparansiModalLabel"><i class="fas fa-fw fa-edit"></i> Ubah Transparansi Laporan</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
					<div class="form-group">
		        <label>Transparansi Laporan:</label><br>
		        <?php if ($laporan['transparansi_laporan'] == "Terbuka"): ?>
			        <input type="radio" id="terbuka" name="transparansi_laporan" value="Terbuka" checked required>
			        <label for="terbuka" class="btn btn-success"><i class="fas fa-fw fa-check-circle"></i> Terbuka</label><br>
			        <input type="radio" id="tertutup" name="transparansi_laporan" value="Tertutup" required>
			        <label for="tertutup" class="btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tertutup</label><br>
				    <?php else: ?>
			        <input type="radio" id="terbuka" name="transparansi_laporan" value="Terbuka" required>
			        <label for="terbuka" class="btn btn-success"><i class="fas fa-fw fa-check-circle"></i> Terbuka</label><br>
			        <input type="radio" id="tertutup" name="transparansi_laporan" value="Tertutup" checked required>
			        <label for="tertutup" class="btn btn-danger"><i class="fas fa-fw fa-times-circle"></i> Tertutup</label><br>
				    <?php endif ?>
			    </div>
		    </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
					<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
	      </div>
	    </div>
		</form>
  </div>
</div>
<?php endif ?>
<script>
$(document).ready(function() {
	$('#transparansiButton').on('click', function() {
		Swal.fire({
		  icon: "error",
		  title: "Transparansi Laporan tidak dapat diubah!",
		  text: "Status Laporan harus Valid terlebih dahulu!"
		});
	});
});

</script>