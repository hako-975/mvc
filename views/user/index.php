<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-center">
						<div class="col-lg header-title">
							<h3 class="m-0"><i class="fas fa-fw fa-user"></i> User</h3>
						</div>
						<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Kepala Desa'): ?>
							<div class="col-lg-4 header-button">
								<a href="<?= base_url('user/addUser'); ?>" class="btn btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah User</a>
							</div>
						<?php endif ?>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="table_id">
							<thead class="thead-dark">
								<tr>
									<th class="align-middle">No.</th>
									<th class="align-middle">Username</th>
									<th class="align-middle">Nama Lengkap</th>
									<th class="align-middle">Jabatan</th>
									<th class="align-middle">Kecamatan</th>
									<th class="align-middle">Kelurahan</th>
									<th class="align-middle">Pengelola Laporan</th>
									<th class="align-middle">Aktif</th>
									<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Kepala Desa'): ?>
										<th class="align-middle">Aksi</th>
									<?php endif ?>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($user as $du): ?>
									<tr>
										<td class="align-middle"><?= $i++; ?></td>
										<td class="align-middle"><?= $du['username']; ?></td>
										<td class="align-middle"><?= $du['nama_lengkap']; ?></td>
										<td class="align-middle"><?= $du['jabatan']; ?></td>
										<td class="align-middle"><?= ($du['nama_kecamatan'] !== null) ? $du['nama_kecamatan'] : "-"; ?></td>
										<td class="align-middle"><?= ($du['nama_kelurahan'] !== null) ? $du['nama_kelurahan'] : "-"; ?></td>
										<td class="align-middle"><?= ($du['jenis_laporan'] !== null) ? $du['jenis_laporan'] : "-"; ?></td>
										<td class="align-middle"><?= ($du['is_active'] == '1') ? 'Aktif' : "Nonaktif"; ?></td>
										<?php if ($dataUser['jabatan'] == 'Administrator' || $dataUser['jabatan'] == 'Kepala Desa'): ?>
											<?php if ($du['jabatan'] != 'Administrator'): ?>
												<td class="align-middle text-center">
													<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailUserModal<?= $du['id_user']; ?>" class="btn btn-sm btn-success m-1"><i class="fas fa-fw fa-bars"></i></button>
													<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
														<a href="<?= base_url('user/editUser/' . $du['id_user']); ?>" class="btn btn-sm btn-success m-1"><i class="fas fa-fw fa-edit"></i></a>
														<a href="<?= base_url('user/removeUser/' . $du['id_user']); ?>" class="btn btn-sm btn-danger m-1 btn-delete" data-nama="<?= $du['username']; ?>"><i class="fas fa-fw fa-fw fa-trash"></i></a>
													<?php else: ?>
														<?php if ($du['jabatan'] != 'Kepala Desa'): ?>
															<a href="<?= base_url('user/editUser/' . $du['id_user']); ?>" class="btn btn-sm btn-success m-1"><i class="fas fa-fw fa-edit"></i></a>
														<?php endif ?>
													<?php endif ?>
												</td>
											<?php else: ?>
												<td class="align-middle">-</td>
											<?php endif ?>
										<?php endif ?>
									</tr>
									<!-- Modal -->
									<div class="modal fade" id="detailUserModal<?= $du['id_user']; ?>" tabindex="-1" aria-labelledby="detailUserModal<?= $du['id_user']; ?>Label" aria-hidden="true">
									  <div class="modal-dialog">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="detailUserModal<?= $du['id_user']; ?>Label">Detail User - <?= $du['username']; ?></h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="modal-body">
									      	<ul class="list-group">
											    <li class="list-group-item">
											        <strong>Username</strong>
											        <span> : </span>
											        <span><?= $du['username']; ?></span>
											    </li>
											    <li class="list-group-item">
											        <strong>Nama Lengkap</strong>
											        <span> : </span>
											        <span><?= $du['nama_lengkap']; ?></span>
											    </li>
											    <li class="list-group-item">
											        <strong>No. Telepon</strong>
											        <span> : </span>
											        <span><?= $du['no_telepon']; ?></span>
											    </li>
											    <li class="list-group-item">
											        <strong>Email</strong>
											        <span> : </span>
											        <span><?= $du['email']; ?></span>
											    </li>
											    <li class="list-group-item">
											        <strong>Jabatan</strong>
											        <span> : </span>
											        <span><?= ucwords($du['jabatan']); ?></span>
											    </li>
											    <?php if (isset($du['nama_kecamatan'])): ?>
											        <li class="list-group-item">
											            <strong>Kecamatan</strong>
											            <span> : </span>
											            <span><?= ucwords($du['nama_kecamatan']); ?></span>
											        </li>
											    <?php endif ?>
											    <?php if (isset($du['nama_kelurahan'])): ?>
											        <li class="list-group-item">
											            <strong>Kelurahan</strong>
											            <span> : </span>
											            <span><?= ucwords($du['nama_kelurahan']); ?></span>
											        </li>
											    <?php endif ?>
											    <?php if (isset($du['jenis_laporan'])): ?>
											        <li class="list-group-item">
											            <strong>Pengelola Laporan</strong>
											            <span> : </span>
											            <span><?= $du['jenis_laporan']; ?></span>
											        </li>
											    <?php endif ?>
											</ul>

									      </div>
									    </div>
									  </div>
									</div>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>