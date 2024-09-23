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
			  	<h3 class="m-0"><i class="fas fa-fw fa-user"></i> Ubah Profil</h3>
			  </div>
			  <div class="card-body">
			  	<form action="<?= base_url('admin/editProfile'); ?>" method="post">
						<div class="form-group">
							<label for="nama_lengkap"><i class="fas fa-fw fa-user"></i> Nama Lengkap</label>
							<input type="text" id="nama_lengkap" class="form-control <?= (form_error('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="nama_lengkap" required value="<?= (form_error('nama_lengkap')) ? set_value('nama_lengkap') : $dataUser['nama_lengkap']; ?>">
							<div class="invalid-feedback">
	              <?= form_error('nama_lengkap'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="no_telepon"><i class="fas fa-fw fa-phone"></i> No. Telepon</label>
							<input type="number" id="no_telepon" class="form-control <?= (form_error('no_telepon')) ? 'is-invalid' : ''; ?>" name="no_telepon" required value="<?= (form_error('no_telepon')) ? set_value('no_telepon') : $dataUser['no_telepon']; ?>">
							<div class="invalid-feedback">
	              <?= form_error('no_telepon'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="email"><i class="fas fa-fw fa-envelope"></i> Email</label>
							<input type="text" id="email" class="form-control <?= (form_error('email')) ? 'is-invalid' : ''; ?>" name="email" required value="<?= (form_error('email')) ? set_value('email') : $dataUser['email']; ?>">
							<div class="invalid-feedback">
	              <?= form_error('email'); ?>
	            </div>
						</div>
						<div class="form-group text-right mt-4">
							<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Ubah Profil"><i class="fas fa-fw fa-times"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
						</div>
					</form>
			  </div>
			</div>
		</div>
	</div>
</div>