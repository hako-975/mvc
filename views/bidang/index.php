<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-center">
						<div class="col-lg header-title">
							<h3 class="m-0"><i class="fas fa-fw fa-layer-group"></i> Bidang</h3>
						</div>
						<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
							<div class="col-lg-4 header-button">
								<a href="<?= base_url('bidang/addBidang'); ?>" class="btn btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Bidang</a>
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
									<th class="align-middle">Nama Bidang</th>
									<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
										<th class="align-middle">Aksi</th>
									<?php endif ?>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($bidang as $db): ?>
									<tr>
										<td class="align-middle"><?= $i++; ?></td>
										<td class="align-middle"><?= $db['nama_bidang']; ?></td>
										<?php if ($dataUser['jabatan'] == 'Administrator'): ?>
											<td class="align-middle text-center">
												<a href="<?= base_url('bidang/jenisLaporanByBidangId/' . $db['id_bidang']); ?>" class="btn btn-sm btn-primary m-1"><i class="fas fa-fw fa-bars"></i></a>
												<a href="<?= base_url('bidang/editBidang/' . $db['id_bidang']); ?>" class="btn btn-sm btn-success m-1"><i class="fas fa-fw fa-edit"></i></a>
												<a href="<?= base_url('bidang/removeBidang/' . $db['id_bidang']); ?>" class="btn btn-sm btn-danger m-1 btn-delete" data-nama="<?= $db['nama_bidang']; ?>"><i class="fas fa-fw fa-fw fa-trash"></i></a>
											</td>
										<?php endif ?>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
