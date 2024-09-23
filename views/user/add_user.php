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
			  	<h3 class="m-0"><i class="fas fa-fw fa-plus"></i> Tambah User</h3>
			  </div>
			  <div class="card-body">
			  	<form action="<?= base_url('user/addUser'); ?>" method="post">
					<div class="form-group">
						<label for="nama_lengkap">Nama Lengkap</label>
						<input type="text" id="nama_lengkap" class="form-control <?= (form_error('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="nama_lengkap" required value="<?= set_value('nama_lengkap'); ?>">
						<div class="invalid-feedback">
			              <?= form_error('nama_lengkap'); ?>
			            </div>
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" id="username" class="form-control <?= (form_error('username')) ? 'is-invalid' : ''; ?>" name="username" required value="<?= set_value('username'); ?>">
						<div class="invalid-feedback">
			              <?= form_error('username'); ?>
			            </div>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" id="password" class="form-control <?= (form_error('password')) ? 'is-invalid' : ''; ?>" name="password" required value="<?= set_value('password'); ?>">
						<div class="invalid-feedback">
			              <?= form_error('password'); ?>
			            </div>
					</div>
					<div class="form-group">
						<label for="password_verify">Verifikasi Password</label>
						<input type="password" id="password_verify" class="form-control <?= (form_error('password_verify')) ? 'is-invalid' : ''; ?>" name="password_verify" required value="<?= set_value('password_verify'); ?>">
						<div class="invalid-feedback">
			              <?= form_error('password_verify'); ?>
			            </div>
					</div>
					<div class="form-group">
						<label for="no_telepon">No. Telepon</label>
						<input type="number" id="no_telepon" class="form-control <?= (form_error('no_telepon')) ? 'is-invalid' : ''; ?>" name="no_telepon" required value="<?= set_value('no_telepon'); ?>">
						<div class="invalid-feedback">
              <?= form_error('no_telepon'); ?>
            </div>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" id="email" class="form-control <?= (form_error('email')) ? 'is-invalid' : ''; ?>" name="email" required value="<?= set_value('email'); ?>">
						<div class="invalid-feedback">
              <?= form_error('email'); ?>
            </div>
					</div>
					<div class="form-group">
						<label for="jabatan">Jabatan</label>
						<select id="jabatan" class="custom-select <?= (form_error('jabatan')) ? 'is-invalid' : ''; ?>" name="jabatan">
							<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
								<option value="0">--- Pilih Jabatan ---</option>
								<option value="Pimpinan">Pimpinan</option>
								<option value="Camat">Camat</option>
								<option value="Kepala Bidang">Kepala Bidang</option>
								<option value="Kepala Desa">Kepala Desa</option>
							<?php endif ?>
							<option value="Operator Desa">Operator Desa</option>
						</select>
						<div class="invalid-feedback">
              <?= form_error('jabatan'); ?>
            </div>
					</div>

					<!-- khusus -->
					<div class="form-group" id="form_bidang_group">
						<label for="form_bidang">Bidang</label>
						<select class="custom-select <?= (form_error('id_bidang')) ? 'is-invalid' : ''; ?>" id="form_bidang" name="id_bidang">
							<option value="0">--- Pilih Bidang ---</option>
							<?php foreach ($bidang as $dataBidang): ?>
								<option value="<?= $dataBidang['id_bidang']; ?>"><?= $dataBidang['nama_bidang']; ?></option>
							<?php endforeach ?>
						</select>
						<div class="invalid-feedback">
              <?= form_error('id_bidang'); ?>
            </div>
					</div>

					<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
						<div class="form-group" id="form_kecamatan_group">
							<label for="form_kecamatan">Kecamatan</label>
							<select class="custom-select <?= (form_error('id_kecamatan')) ? 'is-invalid' : ''; ?>" id="form_kecamatan" name="id_kecamatan">
								<option value="0">--- Pilih Kecamatan ---</option>
								<?php foreach ($kecamatan as $dataKecamatan): ?>
									<option value="<?= $dataKecamatan['id_kecamatan']; ?>"><?= $dataKecamatan['nama_kecamatan']; ?></option>
								<?php endforeach ?>
							</select>
							<div class="invalid-feedback">
	              <?= form_error('id_kecamatan'); ?>
	            </div>
						</div>
					<?php else: ?>
						<div class="form-group">
							<label for="id_kecamatan">Kecamatan</label>
							<select class="custom-select <?= (form_error('id_kecamatan')) ? 'is-invalid' : ''; ?>" id="id_kecamatan" name="id_kecamatan">
								<option value="<?= $dataUser['id_kecamatan']; ?>"><?= $dataUser['nama_kecamatan']; ?></option>
							</select>
							<div class="invalid-feedback">
	              <?= form_error('id_kecamatan'); ?>
	            </div>
						</div>
					<?php endif ?>
					
					<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
						<div class="form-group" id="form_kelurahan_group">
							<label for="form_kelurahan">Kelurahan</label>
							<select id="form_kelurahan" class="custom-select <?= (form_error('id_kelurahan')) ? 'is-invalid' : ''; ?>" name="id_kelurahan">
								<option value="0">--- Pilih Kecamatan ---</option>
							</select>
							<div class="invalid-feedback">
	              <?= form_error('id_kelurahan'); ?>
	            </div>
						</div>
					<?php else: ?>
						<div class="form-group">
							<label for="id_kelurahan">Kelurahan</label>
							<select id="form_kelurahan" class="custom-select <?= (form_error('id_kelurahan')) ? 'is-invalid' : ''; ?>" name="id_kelurahan">
								<option value="<?= $dataUser['id_kelurahan']; ?>"><?= $dataUser['nama_kelurahan']; ?></option>
							</select>
							<div class="invalid-feedback">
	              <?= form_error('id_kelurahan'); ?>
	            </div>
						</div>
					<?php endif ?>
					<div class="form-group" id="form_jenis_laporan_group">
						<label for="id_jenis_laporan">Pengelola Jenis Laporan</label>
						<select class="custom-select <?= (form_error('id_jenis_laporan')) ? 'is-invalid' : ''; ?>" id="id_jenis_laporan" name="id_jenis_laporan">
							<option value="0">--- Pilih Jenis Laporan ---</option>
							<?php foreach ($jenis_laporan as $djl): ?>
								<option value="<?= $djl['id_jenis_laporan']; ?>"><?= $djl['jenis_laporan']; ?></option>
							<?php endforeach ?>
						</select>
						<div class="invalid-feedback">
              <?= form_error('id_jenis_laporan'); ?>
            </div>
					</div>
					<div class="form-group">
						<label for="is_active">Aktif?</label>
						<div class="form-group form-check">
					    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
					    <label class="form-check-label" for="is_active">Aktif</label>
					  </div>
						<div class="invalid-feedback">
              <?= form_error('id_kelurahan'); ?>
            </div>
					</div>
					<div class="form-group text-right">
						<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Tambah User"><i class="fas fa-fw fa-times"></i> Batal</a>
						<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
					</div>
				</form>
			  </div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('#jabatan').on('change', function() {
    var jabatan = $(this).val();
    if (jabatan === 'Pimpinan') {
    	$('#form_bidang_group').hide();
      $('#form_kecamatan_group').hide();
      $('#form_kelurahan_group').hide();
      $('#form_jenis_laporan_group').hide();
    } else if (jabatan === 'Camat') {
    	$('#form_bidang_group').hide();
      $('#form_kecamatan_group').show();
      $('#form_kelurahan_group').hide();
      $('#form_jenis_laporan_group').hide();
    } else if (jabatan === 'Kepala Desa') {
    	$('#form_bidang_group').hide();
      $('#form_kecamatan_group').show();
      $('#form_kelurahan_group').show();
      $('#form_jenis_laporan_group').hide();
    } else if (jabatan === 'Operator Desa') {
    	$('#form_bidang_group').hide();
      $('#form_kecamatan_group').show();
      $('#form_kelurahan_group').show();
      $('#form_jenis_laporan_group').show();
    } else if (jabatan == 'Kepala Bidang') {
    	$('#form_kecamatan_group').hide();
      $('#form_kelurahan_group').hide();
      $('#form_jenis_laporan_group').hide();
    	$('#form_bidang_group').show();
    } else {
    	$('#form_bidang_group').hide();
      $('#form_kecamatan_group').hide();
      $('#form_kelurahan_group').hide();
      $('#form_jenis_laporan_group').hide();
    }
  });
  
  // Trigger change event on page load to set initial state
  $('#jabatan').trigger('change');
});
</script>