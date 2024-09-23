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
					<?php if (isset($nama_jenis_laporan)): ?>
				  	<h3 class="m-0"><i class="fas fa-fw fa-plus"></i> Tambah Laporan <?= $nama_jenis_laporan; ?></h3>
					<?php else: ?>
				  	<h3 class="m-0"><i class="fas fa-fw fa-plus"></i> Tambah Laporan</h3>
					<?php endif ?>
			  </div>
			  <div class="card-body">
			  	<form action="<?= base_url('laporan/addLaporan'); ?>" method="post" enctype="multipart/form-data">
			  		<div class="form-group">
							<label for="judul_laporan">Judul Laporan</label>
							<textarea id="judul_laporan" class="form-control <?= (form_error('judul_laporan')) ? 'is-invalid' : ''; ?>" name="judul_laporan" required><?= set_value('judul_laporan'); ?></textarea>
							<div class="invalid-feedback">
	              <?= form_error('judul_laporan'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="uraian_laporan">Uraian Laporan</label>
							<textarea id="uraian_laporan" class="form-control <?= (form_error('uraian_laporan')) ? 'is-invalid' : ''; ?>" name="uraian_laporan" required><?= set_value('uraian_laporan'); ?></textarea>
							<div class="invalid-feedback">
	              <?= form_error('uraian_laporan'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="tgl_laporan">Tanggal Laporan</label>
							<input type="datetime-local" id="tgl_laporan" class="form-control <?= (form_error('tgl_laporan')) ? 'is-invalid' : ''; ?>" name="tgl_laporan" required value="<?= (set_value('tgl_laporan')) ? set_value('tgl_laporan') : date('Y-m-d\TH:i'); ?>">
							<div class="invalid-feedback">
	              <?= form_error('tgl_laporan'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="tahun_kegiatan">Tahun Kegiatan</label>
							<input type="number" id="tahun_kegiatan" class="form-control <?= (form_error('tahun_kegiatan')) ? 'is-invalid' : ''; ?>" name="tahun_kegiatan" required value="<?= (set_value('tahun_kegiatan')) ? set_value('tahun_kegiatan') : date('Y'); ?>">
							<div class="invalid-feedback">
	              <?= form_error('tahun_kegiatan'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="file_laporan">File Laporan</label>
							<div class="file-drop-area">
							  <span class="choose-file-button">Pilih File</span>
							  <span class="file-message">drag and drop files here</span>
							  <input class="file-input-drop" id="file_laporan" type="file" required name="file_laporan[]" multiple>
							</div>
							<span>Maksimal ukuran per file 15 MB</span>
						</div>
						<?php if ($dataUser['jabatan'] != 'Operator Desa'): ?>
							<div class="form-group">
								<label for="id_jenis_laporan">Jenis Laporan</label>
								<select id="id_jenis_laporan" class="custom-select <?= (form_error('id_jenis_laporan')) ? 'is-invalid' : ''; ?>" name="id_jenis_laporan">
									<?php if (isset($nama_jenis_laporan)): ?>
										<option value="<?= $id_jenis_laporan; ?>"><?= ucwords($nama_jenis_laporan); ?></option>
									<?php else: ?>
										<option value="0">--- Pilih Jenis Laporan ---</option>
									<?php endif ?>
									<?php foreach ($jenis_laporan as $djl): ?>
										<?php 
								    	if ($djl['id_jenis_laporan'] != $id_jenis_laporan): 
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
							<input type="hidden" name="id_jenis_laporan" value="<?= $id_jenis_laporan; ?>">
						<?php endif ?>
						<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
							<div class="form-group">
								<label for="form_kecamatan">Kecamatan</label>
								<select class="custom-select <?= (form_error('id_kecamatan')) ? 'is-invalid' : ''; ?>" id="form_kecamatan" required>
									<option value="0">--- Pilih Kecamatan ---</option>
									<?php foreach ($kecamatan as $dataKecamatan): ?>
										<option value="<?= $dataKecamatan['id_kecamatan']; ?>"><?= $dataKecamatan['nama_kecamatan']; ?></option>
									<?php endforeach ?>
								</select>
								<div class="invalid-feedback">
		              <?= form_error('id_kecamatan'); ?>
		            </div>
							</div>
							<div class="form-group">
								<label for="form_kelurahan">Kelurahan</label>
								<select id="form_kelurahan" class="custom-select <?= (form_error('id_kelurahan')) ? 'is-invalid' : ''; ?>" name="id_kelurahan" required>
									<option value="0">--- Pilih Kecamatan ---</option>
								</select>
								<div class="invalid-feedback">
		              <?= form_error('id_kelurahan'); ?>
		            </div>
							</div>
						<?php else: ?>
							<input type="hidden" name="id_kelurahan" value="<?= $dataUser['id_kelurahan']; ?>">
						<?php endif ?>
						<div class="form-group mt-5 text-right">
							<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Tambah Laporan"><i class="fas fa-fw fa-times"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
						</div>
					</form>
			  </div>
			</div>
		</div>
		<div class="col-lg-6 d-none" id="previewDiv">
			<div class="card">
				<div class="card-header">
					<h3 class="m-0"><i class="fas fa-fw fa-search"></i> Preview Laporan</h3>
				</div>
				<div class="card-body">
					<div id="pdf-preview" class="text-center py-2 col-preview w-100" style="height: 1250px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

