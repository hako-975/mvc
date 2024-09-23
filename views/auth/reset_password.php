<main class="flex-shrink-0 mt-5 pb-5">
	<div class="container">
		<div class="row justify-content-center pt-4">
			<div class="col-lg-4 border p-4 rounded bg-white">
				<h3>Reset Password</h3>
				<form action="<?= base_url('auth/changePassword'); ?>" method="post">
					<div class="form-group">
						<label for="new_password"><i class="fas fa-fw fa-lock"></i> Password Baru</label>
						<input type="password" id="new_password" class="form-control <?= (form_error('new_password')) ? 'is-invalid' : ''; ?>" name="new_password" required value="<?= set_value('new_password'); ?>">
						<div class="invalid-feedback">
			              <?= form_error('new_password'); ?>
			            </div>
					</div>
					<div class="form-group">
						<label for="verify_new_password"><i class="fas fa-fw fa-lock"></i> Verifikasi Password Baru</label>
						<input type="password" id="verify_new_password" class="form-control <?= (form_error('verify_new_password')) ? 'is-invalid' : ''; ?>" name="verify_new_password" required value="<?= set_value('verify_new_password'); ?>">
						<div class="invalid-feedback">
			              <?= form_error('verify_new_password'); ?>
			            </div>
					</div>
					<div class="form-group row">
						<div class="col my-auto">
							<a class="btn btn-danger" href="<?= base_url('auth/login'); ?>"><i class="fas fa-fw fa-times"></i> Batal</a>
						</div>
						<div class="col my-auto text-right">
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-lock"></i> Reset Password</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>

