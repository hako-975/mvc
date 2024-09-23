<main class="flex-shrink-0 mt-5 pb-5">
	<div class="container">
		<div class="row justify-content-center pt-4">
			<div class="col-lg-4 border p-4 rounded bg-white">
				<h3>Lupa Password</h3>
				<form action="<?= base_url('auth/lupaPassword'); ?>" method="post">
					<div class="form-group">
						<label for="email"><i class="fas fa-fw fa-envelope"></i> Email</label>
						<input type="email" autocomplete="off" id="email" class="form-control" name="email" required>
					</div>
					<div class="form-group row">
						<div class="col my-auto">
							<a class="btn btn-danger" href="<?= base_url('auth/login'); ?>"><i class="fas fa-fw fa-times"></i> Batal</a>
						</div>
						<div class="col my-auto text-right">
							<button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-lock"></i> Lupa Password</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>
