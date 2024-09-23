<?php if (validation_errors()): ?>
  <div class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false" style="z-index: 999999; position: fixed; right: 1.5rem; bottom: 3.5rem">
    <div class="toast-header">
      <strong class="mr-auto">Gagal!</strong>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      <?= validation_errors(); ?>
    </div>
  </div>
<?php endif ?>

<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg-6">
			<div class="card">
			  <div class="card-header">
			  	<h3 class="m-0"><i class="fas fa-fw fa-edit"></i> <?= isset($revisi) ? 'Revisi': 'Ubah'; ?> Laporan </h3>
			  </div>
			  <div class="card-body">
			  	<form action="<?= base_url('laporan/editLaporan/' . $laporan['id_laporan']); ?>" method="post" enctype="multipart/form-data">
			  		<?php if (isset($revisi)): ?>
				  		<input type="hidden" name="revisi" value="<?= $revisi; ?>">
			  		<?php endif ?>
			  		<div class="form-group">
							<label for="judul_laporan">Judul Laporan</label>
							<textarea id="judul_laporan" class="form-control <?= (form_error('judul_laporan')) ? 'is-invalid' : ''; ?>" name="judul_laporan" required><?= (form_error('judul_laporan')) ? set_value('judul_laporan') : $laporan['judul_laporan']; ?></textarea>
							<div class="invalid-feedback">
	              <?= form_error('judul_laporan'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="uraian_laporan">Uraian Laporan</label>
							<textarea id="uraian_laporan" class="form-control <?= (form_error('uraian_laporan')) ? 'is-invalid' : ''; ?>" name="uraian_laporan" required><?= (form_error('uraian_laporan')) ? set_value('uraian_laporan') : $laporan['uraian_laporan']; ?></textarea>
							<div class="invalid-feedback">
	              <?= form_error('uraian_laporan'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="tgl_laporan">Tanggal Laporan</label>
							<input type="datetime-local" id="tgl_laporan" class="form-control <?= (form_error('tgl_laporan')) ? 'is-invalid' : ''; ?>" name="tgl_laporan" required value="<?= (form_error('tgl_laporan')) ? set_value('tgl_laporan') : $laporan['tgl_laporan']; ?>">
							<div class="invalid-feedback">
	              <?= form_error('tgl_laporan'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="tahun_kegiatan">Tahun Kegiatan</label>
							<input type="number" min="1" max="9999" id="tahun_kegiatan" class="form-control <?= (form_error('tahun_kegiatan')) ? 'is-invalid' : ''; ?>" name="tahun_kegiatan" required value="<?= (form_error('tahun_kegiatan')) ? set_value('tahun_kegiatan') : $laporan['tahun_kegiatan']; ?>">
							<div class="invalid-feedback">
				              <?= form_error('tahun_kegiatan'); ?>
				            </div>
						</div>
						<div class="form-group">
							<label for="file_laporan">File Laporan</label>
							<div class="file-drop-area">
							  	<span class="choose-file-button">Pilih File</span>
							  	<?php 
								  	$file_laporan = $this->db->get_where('file_laporan', ['id_laporan' => $laporan['id_laporan']])->result_array();
							  	?>
							    <span class="file-message">
								  <?php foreach ($file_laporan as $dfl): ?>
								    <div class="file-message">
						        	• <?= $dfl['file_laporan']; ?>
								    </div>
									<?php endforeach ?>
							    </span>

						  		<input class="file-input-drop" id="file_laporan" type="file" name="file_laporan[]" multiple>
							</div>
							<span>Maksimal ukuran per file 15 MB</span>
						</div>
						<?php if ($dataUser['jabatan'] != 'Operator Desa'): ?>
							<div class="form-group">
								<label for="id_jenis_laporan">Jenis Laporan</label>
								<select id="id_jenis_laporan" class="custom-select <?= (form_error('id_jenis_laporan')) ? 'is-invalid' : ''; ?>" name="id_jenis_laporan">
									<option value="<?= $laporan['id_jenis_laporan']; ?>"><?= $laporan['jenis_laporan']; ?></option>
									<?php foreach ($jenis_laporan as $djl): ?>
										<?php 
								    	if ($djl['id_jenis_laporan'] != $laporan['id_jenis_laporan']): 
								    ?>
							        <option value="<?= $djl['id_jenis_laporan']; ?>"><?= $djl['jenis_laporan']; ?></option>
								    <?php endif ?>
									<?php endforeach ?>
								</select>
								<div class="invalid-feedback">
		              <?= form_error('id_jenis_laporan'); ?>
		            </div> 	
							</div>
						<?php else: ?>
							<input type="hidden" name="id_jenis_laporan" value="<?= $laporan['id_jenis_laporan']; ?>">
						<?php endif ?>
						<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
							<div class="form-group">
								<label for="form_kecamatan">Kecamatan</label>
								<select class="custom-select" id="form_kecamatan">
									<?php 
										$getKecamatanByIdFromKelurahan = $this->db->get_where('kecamatan', ['id_kecamatan' => $laporan['id_kecamatan']])->row_array();
									?>
									<?php if ($getKecamatanByIdFromKelurahan != null): ?>
										<option value="<?= $getKecamatanByIdFromKelurahan['id_kecamatan']; ?>"><?= $getKecamatanByIdFromKelurahan['nama_kecamatan']; ?></option>
									<?php else: ?>
										<option value="0">--- Pilih Kecamatan ---</option>
									<?php endif ?>
									<?php foreach ($kecamatan as $dataKecamatan): ?>
										<?php if ($dataKecamatan['id_kecamatan'] != $getKecamatanByIdFromKelurahan['id_kecamatan']): ?>
											<option value="<?= $dataKecamatan['id_kecamatan']; ?>"><?= $dataKecamatan['nama_kecamatan']; ?></option>
										<?php endif ?>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="form_kelurahan">Kelurahan</label>
								<select id="form_kelurahan" class="custom-select" name="id_kelurahan">
									<?php 
										$getKelurahanByIdKecamatan = $this->db->get_where('kelurahan', ['id_kecamatan' => $laporan['id_kecamatan']])->result_array();
									?>
									<?php if ($laporan['id_kelurahan'] != null): ?>
										<option value="<?= $laporan['id_kelurahan']; ?>"><?= $laporan['nama_kelurahan']; ?></option>
										<?php foreach ($getKelurahanByIdKecamatan as $dataKelurahan): ?>
											<?php if ($dataKelurahan['id_kelurahan'] != $laporan['id_kelurahan']): ?>
												<option value="<?= $dataKelurahan['id_kelurahan']; ?>"><?= $dataKelurahan['nama_kelurahan']; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									<?php else: ?>
										<option value="0">--- Pilih Kecamatan ---</option>
									<?php endif ?>
								</select>
							</div>
						<?php else: ?>
							<input type="hidden" name="id_kelurahan" value="<?= $dataUser['id_kelurahan']; ?>">
						<?php endif ?>
						<div class="form-group mt-5 text-right">
							<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Ubah Laporan"><i class="fas fa-fw fa-times"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
						</div>
					</form>
			  </div>
			</div>
		</div>
		<div class="col-lg-6" id="previewDiv">
			<div class="card">
				<div class="card-header">
					<h3 class="m-0"><i class="fas fa-fw fa-search"></i> Preview Laporan</h3>
				</div>
				<div class="card-body">
					<div id="pdf-preview" class="text-center py-2 col-preview w-100"></div>
				</div>
			</div>
		</div>
	</div>
</div>



<script>
var previewDiv = $('#previewDiv');
var pdfPreview = document.getElementById('pdf-preview');

// Clear the existing content of pdf-preview container
pdfPreview.innerHTML = '';

<?php foreach($file_laporan as $dfl): ?>
	var fileURL = "<?= site_url('serve/' . $dfl['file_laporan']); ?>";    
    
    // Create a new object for each file
    var fileObj = document.createElement('object');
    fileObj.className = 'file-preview';
    fileObj.data = fileURL; // Set data to a URL representing the file content
    fileObj.style = "width:100%;height:700px";

    // Append the file name below the preview
    var fileNameDiv = document.createElement('div');
    fileNameDiv.textContent = 'Nama File: ' + "<?php echo $dfl['file_laporan']; ?>";
    pdfPreview.appendChild(fileNameDiv);

    // Append the file div to the pdf-preview container
    pdfPreview.appendChild(fileObj);

<?php endforeach ?>


</script>