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
			  	<h3 class="m-0"><i class="fas fa-fw fa-plus"></i> Tambah Kelurahan</h3>
			  </div>
			  <div class="card-body">
			  	<form action="<?= base_url('kelurahan/addKelurahan'); ?>" method="post">
					<div class="form-group">
						<label for="id_kecamatan">Nama Kecamatan</label>
						<?php if ($this->uri->segment('3') != null): ?>
							<?php 
								$id_kecamatan = $this->uri->segment('3');
								$get_kecamatan = $this->db->get_where('kecamatan', ['id_kecamatan' => $id_kecamatan])->row_array();
							 ?>
							 <?php if ($get_kecamatan != null): ?>
								<input type="hidden" name="id_kecamatan" class="form-control" value="<?= $get_kecamatan['id_kecamatan']; ?>">
								<input type="text" class="form-control" disabled value="<?= $get_kecamatan['nama_kecamatan']; ?>">
							<?php else: ?>
								<select id="id_kecamatan" class="custom-select <?= (form_error('id_kecamatan')) ? 'is-invalid' : ''; ?>" name="id_kecamatan">
									<option value="0">--- Pilih Kecamatan ---</option>
									<?php foreach ($kecamatan as $dk): ?>
										<option value="<?= $dk['id_kecamatan']; ?>"><?= ucwords(strtolower($dk['nama_kecamatan'])); ?></option>
									<?php endforeach ?>
								</select>
								<div class="invalid-feedback">
		              <?= form_error('id_kecamatan'); ?>
		            </div> 	
							<?php endif ?>
						<?php else: ?>
							<select id="id_kecamatan" class="custom-select <?= (form_error('id_kecamatan')) ? 'is-invalid' : ''; ?>" name="id_kecamatan">
								<option value="0">--- Pilih Kecamatan ---</option>
								<?php foreach ($kecamatan as $dk): ?>
									<option value="<?= $dk['id_kecamatan']; ?>"><?= ucwords(strtolower($dk['nama_kecamatan'])); ?></option>
								<?php endforeach ?>
							</select>
							<div class="invalid-feedback">
	              <?= form_error('id_kecamatan'); ?>
	            </div> 	
						<?php endif ?>
					</div>
					<div class="form-group">
						<label for="nama_kelurahan">Nama Kelurahan</label>
						<input type="text" id="nama_kelurahan" class="form-control <?= (form_error('nama_kelurahan')) ? 'is-invalid' : ''; ?>" name="nama_kelurahan" required value="<?= set_value('nama_kelurahan'); ?>">
						<div class="invalid-feedback">
              <?= form_error('nama_kelurahan'); ?>
            </div>
					</div>
					<div class="form-group text-right">
						<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Tambah Kelurahan/Desa"><i class="fas fa-fw fa-times"></i> Batal</a>
						<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
					</div>
				</form>
			  </div>
			</div>
		</div>
	</div>
</div>
