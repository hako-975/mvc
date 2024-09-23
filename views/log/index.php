<div class="container p-3">
	<div class="row mb-2">
		<div class="col-lg">
            <div class="card">
            	<div class="card-header">
        			<div class="row justify-content-center align-items-center">
						<div class="col-lg header-title">
							<h3 class="m-0"><i class="fas fa-fw fa-history"></i> Aktivitas</h3>
						</div>
					</div>
            	</div>	
	            <div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="table_id">
							<thead class="thead-dark">
								<tr>
									<th>No.</th>
									<th>Tanggal Log</th>
									<th>Isi Log</th>
									<th>Username</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								<?php foreach ($log as $dl): ?>
									<tr>
										<td><?= $i++; ?></td>
										<td><?= $dl['isi_log']; ?></td>
										<td><?= $dl['tgl_log']; ?></td>
										<td><?= $dl['username']; ?></td>
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