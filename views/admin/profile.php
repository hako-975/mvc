<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">
					<h3 class="m-0"><i class="fas fa-fw fa-user"></i> Profil - <?= $dataUser['username']; ?></h3>
				</div>
				<div class="card-body">
					<table>
						<tr>
							<th>Username</th>
							<td style="width: 1rem; text-align: center;"> : </td>
							<td><?= $dataUser['username']; ?></td>
						</tr>
						<tr>
							<th>Nama Lengkap</th>
							<td style="width: 1rem; text-align: center;"> : </td>
							<td><?= $dataUser['nama_lengkap']; ?></td>
						</tr>
						<tr>
							<th>No. Telepon</th>
							<td style="width: 1rem; text-align: center;"> : </td>
							<td><?= $dataUser['no_telepon']; ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td style="width: 1rem; text-align: center;"> : </td>
							<td><?= $dataUser['email']; ?></td>
						</tr>
						<tr>
							<th>Jabatan</th>
							<td style="width: 1rem; text-align: center;"> : </td>
							<td><?= ucwords($dataUser['jabatan']); ?></td>
						</tr>
						<?php if (isset($dataUser['nama_kecamatan'])): ?>
							<tr>
								<th>Kecamatan</th>
								<td style="width: 1rem; text-align: center;"> : </td>
								<td><?= ucwords($dataUser['nama_kecamatan']); ?></td>
							</tr>
						<?php endif ?>
						<?php if (isset($dataUser['nama_kelurahan'])): ?>
							<tr>
								<th>Kelurahan</th>
								<td style="width: 1rem; text-align: center;"> : </td>
								<td><?= ucwords($dataUser['nama_kelurahan']); ?></td>
							</tr>
						<?php endif ?>
						<?php if (isset($dataUser['jenis_laporan'])): ?>
							<tr>
								<th>Pengelola Laporan</th>
								<td style="width: 1rem; text-align: center;"> : </td>
								<td><?= $dataUser['jenis_laporan']; ?></td>
							</tr>
						<?php endif ?>
					</table>
					<div class="row mt-4">
						<div class="col-5">
							<a href="<?= base_url('admin/changePassword'); ?>" class="btn btn-danger"><i class="fas fa-fw fa-lock"></i> Ganti Password</a>
						</div>
						<div class="col">
							<a href="<?= base_url('admin/editProfile'); ?>" class="btn btn-success"><i class="fas fa-fw fa-user-edit"></i> Ubah Profil</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>