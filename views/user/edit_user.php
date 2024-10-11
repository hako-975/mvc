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
					<h3 class="m-0"><i class="fas fa-fw fa-edit"></i> Ubah User</h3>
				</div>
			  	<div class="card-body">
					<form action="<?= base_url('user/editUser/' . $user['id_user']); ?>" method="post">
						<div class="form-group">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" id="nama_lengkap" class="form-control <?= (form_error('nama_lengkap')) ? 'is-invalid' : ''; ?>" name="nama_lengkap" required value="<?= (form_error('nama_lengkap')) ? set_value('nama_lengkap') : $user['nama_lengkap']; ?>">
							<div class="invalid-feedback">
				              <?= form_error('nama_lengkap'); ?>
				            </div>
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" id="username" class="form-control <?= (form_error('username')) ? 'is-invalid' : ''; ?>" name="username" required value="<?= (form_error('username')) ? set_value('username') : $user['username']; ?>">
							<div class="invalid-feedback">
				              <?= form_error('username'); ?>
				            </div>
						</div>
						<div class="form-group">
							<label for="no_telepon">No. Telepon</label>
							<input type="number" id="no_telepon" class="form-control <?= (form_error('no_telepon')) ? 'is-invalid' : ''; ?>" name="no_telepon" required value="<?= (form_error('no_telepon')) ? set_value('no_telepon') : $user['no_telepon']; ?>">
							<div class="invalid-feedback">
	              <?= form_error('no_telepon'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" id="email" class="form-control <?= (form_error('email')) ? 'is-invalid' : ''; ?>" name="email" required value="<?= (form_error('email')) ? set_value('email') : $user['email']; ?>">
							<div class="invalid-feedback">
	              <?= form_error('email'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="jabatan">Jabatan</label>
							<select id="jabatan" class="custom-select <?= (form_error('jabatan')) ? 'is-invalid' : ''; ?>" name="jabatan">
							<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
								<option value="<?= $user['jabatan']; ?>"><?= $user['jabatan']; ?></option>
								<?php if ($user['jabatan'] != 'Pimpinan') : ?>
					        <option value="Pimpinan">Pimpinan</option>
						    <?php endif; ?>
						    <?php if ($user['jabatan'] != 'Camat') : ?>
					        <option value="Camat">Camat</option>
						    <?php endif; ?>
						    <?php if ($user['jabatan'] != 'Kepala Bidang') : ?>
					        <option value="Kepala Bidang">Kepala Bidang</option>
						    <?php endif; ?>
						    <?php if ($user['jabatan'] != 'Kepala Desa') : ?>
					        <option value="Kepala Desa">Kepala Desa</option>
						    <?php endif; ?>
						    <?php if ($user['jabatan'] != 'Sekretaris Desa') : ?>
					        <option value="Sekretaris Desa">Sekretaris Desa</option>
						    <?php endif; ?>
						    <?php if ($user['jabatan'] != 'Operator Desa') : ?>
					        <option value="Operator Desa">Operator Desa</option>
						    <?php endif; ?>
						  <?php else: ?>
				        <option value="Operator Desa">Operator Desa</option>
							<?php endif ?>
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
								<select class="custom-select" id="form_kecamatan" name="id_kecamatan">
									<?php 
										$getKecamatanByIdFromKelurahan = $this->db->get_where('kecamatan', ['id_kecamatan' => $user['id_kecamatan']])->row_array();
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
						<?php else: ?>
							<div class="form-group">
								<label for="form_kecamatan">Kecamatan</label>
								<select class="custom-select" id="form_kecamatan" name="id_kecamatan">
									<option value="<?= $dataUser['id_kecamatan']; ?>"><?= $dataUser['nama_kecamatan']; ?></option>
								</select>
							</div>
						<?php endif ?>
						<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
							<div class="form-group" id="form_kelurahan_group">
								<label for="form_kelurahan">Kelurahan</label>
								<select id="form_kelurahan" class="custom-select" name="id_kelurahan">
									<?php 
										$getKelurahanByIdKecamatan = $this->db->get_where('kelurahan', ['id_kecamatan' => $user['id_kecamatan']])->result_array();
									?>
									<?php if ($user['id_kelurahan'] != null): ?>
										<option value="<?= $user['id_kelurahan']; ?>"><?= $user['nama_kelurahan']; ?></option>
										<?php foreach ($getKelurahanByIdKecamatan as $dataKelurahan): ?>
											<?php if ($dataKelurahan['id_kelurahan'] != $user['id_kelurahan']): ?>
												<option value="<?= $dataKelurahan['id_kelurahan']; ?>"><?= $dataKelurahan['nama_kelurahan']; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									<?php else: ?>
										<option value="0">--- Pilih Kecamatan ---</option>
									<?php endif ?>
								</select>
							</div>
						<?php else: ?>
							<div class="form-group">
								<label for="id_kelurahan">Kelurahan</label>
								<select id="id_kelurahan" class="custom-select" name="id_kelurahan">
									<option value="<?= $dataUser['id_kelurahan']; ?>"><?= $dataUser['nama_kelurahan']; ?></option>
								</select>
							</div>
						<?php endif ?>
						<div class="form-group" id="form_jenis_laporan_group">
							<label for="id_jenis_laporan">Pengelola Jenis Laporan</label>
							<select class="custom-select" id="id_jenis_laporan" name="id_jenis_laporan">
								<?php 
									$getJenisLaporanById = $this->db->get_where('jenis_laporan', ['id_jenis_laporan' => $user['id_jenis_laporan']])->row_array();
								?>
								<?php if ($getJenisLaporanById != null): ?>
									<option value="<?= $getJenisLaporanById['id_jenis_laporan']; ?>"><?= $getJenisLaporanById['jenis_laporan']; ?></option>
								<?php else: ?>
									<option value="0">--- Pilih Jenis Laporan ---</option>
								<?php endif ?>
								<?php foreach ($jenis_laporan as $djl): ?>
									<?php if ($djl['id_jenis_laporan'] != $getJenisLaporanById['id_jenis_laporan']): ?>
										<option value="<?= $djl['id_jenis_laporan']; ?>"><?= $djl['jenis_laporan']; ?></option>
									<?php endif ?>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group">
							<label for="is_active">Aktif?</label>
							<div class="form-group form-check">
						    <input type="checkbox" class="form-check-input" id="is_active" <?= ($user['is_active'] == '1') ? 'checked' : ''; ?> name="is_active">
						    <label class="form-check-label" for="is_active">Aktif</label>
						  </div>
							<div class="invalid-feedback">
	              <?= form_error('id_kelurahan'); ?>
	            </div>
						</div>
						<div class="form-group text-right">
							<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Ubah User"><i class="fas fa-fw fa-times"></i> Batal</a>
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
    } else if (jabatan === 'Sekretaris Desa') {
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