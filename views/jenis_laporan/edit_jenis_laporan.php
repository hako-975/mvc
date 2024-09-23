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
					<h3 class="m-0"><i class="fas fa-fw fa-edit"></i> Ubah Jenis Laporan</h3>
				</div>
			  	<div class="card-body">
					<form action="<?= base_url('jenisLaporan/editJenisLaporan/' . $jenis_laporan['id_jenis_laporan']); ?>" method="post">
						<div class="form-group">
							<label for="id_bidang">Nama Bidang</label>
							<select id="id_bidang" class="custom-select <?= (form_error('id_bidang')) ? 'is-invalid' : ''; ?>" name="id_bidang">
								<option value="<?= $jenis_laporan['id_bidang']; ?>"><?= $jenis_laporan['nama_bidang']; ?></option>
								<?php foreach ($bidang as $dk): ?>
									<?php if ($dk['id_bidang'] != $jenis_laporan['id_bidang']): ?>
										<option value="<?= $dk['id_bidang']; ?>"><?= ucwords(strtolower($dk['nama_bidang'])); ?></option>
									<?php endif ?>
								<?php endforeach ?>
							</select>
							<div class="invalid-feedback">
	              <?= form_error('id_bidang'); ?>
	            </div>
						</div>
						<div class="form-group">
							<label for="jenis_laporan">Nama Jenis Laporan</label>
							<input type="text" id="jenis_laporan" class="form-control <?= (form_error('jenis_laporan')) ? 'is-invalid' : ''; ?>" name="jenis_laporan" required value="<?= (form_error('jenis_laporan')) ? set_value('jenis_laporan') : $jenis_laporan['jenis_laporan']; ?>">
							<div class="invalid-feedback">
	              <?= form_error('jenis_laporan'); ?>
	            </div>
						</div>
						<div class="form-group text-right">
							<a href="javascript:history.back()" class="btn btn-danger btn-cancel" data-nama="Ubah Jenis Laporan"><i class="fas fa-fw fa-times"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
