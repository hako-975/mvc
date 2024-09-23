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
					<h3 class="m-0"><i class="fas fa-fw fa-edit"></i> Ubah Kecamatan</h3>
				</div>
			  	<div class="card-body">
					<form action="<?= base_url('kecamatan/editKecamatan/' . $kecamatan['id_kecamatan']); ?>" method="post">
						<div class="form-group">
							<label for="nama_kecamatan">Nama Kecamatan</label>
							<input type="text" id="nama_kecamatan" class="form-control <?= (form_error('nama_kecamatan')) ? 'is-invalid' : ''; ?>" name="nama_kecamatan" required value="<?= (form_error('nama_kecamatan')) ? set_value('nama_kecamatan') : $kecamatan['nama_kecamatan']; ?>">
							<div class="invalid-feedback">
				              <?= form_error('nama_kecamatan'); ?>
				            </div>
						</div>
						<div class="form-group text-right">
							<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Ubah Kecamatan"><i class="fas fa-fw fa-times"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
