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
			  	<h3 class="m-0"><i class="fas fa-fw fa-plus"></i> Tambah Jenis Laporan</h3>
			  </div>
			  <div class="card-body">
			  	<form action="<?= base_url('jenisLaporan/addJenisLaporan'); ?>" method="post">
			  		<div class="form-group">
							<label for="id_kecamatan">Nama Bidang</label>
				  		<?php if ($this->uri->segment('3') != null): ?>
								<?php 
									$id_bidang = $this->uri->segment('3');
									$get_bidang = $this->db->get_where('bidang', ['id_bidang' => $id_bidang])->row_array();
								 ?>
								 <?php if ($get_bidang != null): ?>
									<input type="hidden" name="id_bidang" class="form-control" value="<?= $get_bidang['id_bidang']; ?>">
									<input type="text" class="form-control" disabled value="<?= $get_bidang['nama_bidang']; ?>">
								<?php else: ?>
									<select id="id_bidang" class="custom-select <?= (form_error('id_bidang')) ? 'is-invalid' : ''; ?>" name="id_bidang">
										<option value="0">--- Pilih Bidang ---</option>
										<?php foreach ($bidang as $db): ?>
											<option value="<?= $db['id_bidang']; ?>"><?= ucwords(strtolower($db['nama_bidang'])); ?></option>
										<?php endforeach ?>
									</select>
									<div class="invalid-feedback">
			              <?= form_error('id_bidang'); ?>
			            </div> 	
								<?php endif ?>
							<?php else: ?>
								<select id="id_bidang" class="custom-select <?= (form_error('id_bidang')) ? 'is-invalid' : ''; ?>" name="id_bidang">
									<option value="0">--- Pilih Bidang ---</option>
									<?php foreach ($bidang as $db): ?>
										<option value="<?= $db['id_bidang']; ?>"><?= ucwords(strtolower($db['nama_bidang'])); ?></option>
									<?php endforeach ?>
								</select>
								<div class="invalid-feedback">
		              <?= form_error('id_bidang'); ?>
		            </div> 	
							<?php endif ?>
						</div>
						<div class="form-group">
							<label for="jenis_laporan">Jenis Laporan</label>
							<input type="text" id="jenis_laporan" class="form-control <?= (form_error('jenis_laporan')) ? 'is-invalid' : ''; ?>" name="jenis_laporan" required value="<?= set_value('jenis_laporan'); ?>">
							<div class="invalid-feedback">
	              <?= form_error('jenis_laporan'); ?>
	            </div>
						</div>
						<div class="form-group text-right">
							<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Tambah Jenis Laporan"><i class="fas fa-fw fa-times"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
						</div>
					</form>
			  </div>
			</div>
		</div>
	</div>
</div>
