<main class="flex-shrink-0 mt-4">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<div class="row justify-content-center">
					<div class="col-lg header-title">
						<h3 class="m-0"><i class="fas fa-fw fa-file-alt"></i> Detail Laporan: <?= $laporan['judul_laporan']; ?></h3>
					</div>
					<div class="col-lg-4 header-button">
						<a href="<?= base_url('auth'); ?>" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<p><strong>Jenis Laporan:</strong> <br> <?= $laporan['jenis_laporan']; ?></p>
				<p><strong>Judul Laporan:</strong> <br> <?= $laporan['judul_laporan']; ?></p>
				<p><strong>Uraian Laporan:</strong> <br> <?= $laporan['uraian_laporan']; ?></p>
				<p><strong>Tanggal Laporan:</strong> <br> <?= date('d-M-Y \P\u\k\u\l: H:i', strtotime($laporan['tgl_laporan'])); ?></p>
				<p><strong>Tahun Kegiatan:</strong> <br> <?= $laporan['tahun_kegiatan']; ?></p>
				<p><strong>Nama Kecamatan:</strong> <br> <?= $laporan['nama_kecamatan']; ?></p>
				<p><strong>Nama Kelurahan/Desa:</strong> <br> <?= $laporan['nama_kelurahan']; ?></p>
				<p><strong>File Laporan:</strong> 
				<?php 
					$file_laporan = $this->db->get_where('file_laporan', ['id_laporan' => $laporan['id_laporan']])->result_array();
				?>
				<?php if ($file_laporan != null): ?>
					<ul>
						<?php foreach ($file_laporan as $dfl): ?>
							<li><a download href="<?= base_url('file/download/'. $dfl['file_laporan']); ?>"><?= $dfl['file_laporan']; ?></a></li>	
						<?php endforeach ?>
					</ul>
					<!-- <a class="btn btn-primary" href="<?= base_url('laporan/download_all_files/' . $laporan['id_laporan']); ?>"><i class="fas fa-fw fa-download"></i> Unduh Semua File</a> -->
				<?php else: ?>
					<br>-
				<?php endif ?>
				</p>
				
				<p><strong>Laporan dibuat oleh:</strong> <br> <?= $laporan['username']; ?></p>
				<?php if ($file_laporan != null): ?>
				    <div class="row mb-2">
				        <?php foreach($file_laporan as $index => $file): ?>
			            <div class="col-lg-12 p-3">
			            	<hr>
	                        <h3 class="my-auto"><i class="fas fa-fw fa-search"></i> Preview File - <?= $file['file_laporan']; ?></h3>
			            	<hr>
	                        <div id="pdf-preview-<?= $index; ?>" class="overflow-hidden text-center py-2 col-preview w-100" style="height: 2500px;"></div>
			            </div>
			            <script>
			              var fileURL_<?= $index; ?> = "<?= site_url('serve/' . $file['file_laporan']); ?>";
			              var fileType_<?= $index; ?> = "<?= pathinfo($file['file_laporan'], PATHINFO_EXTENSION); ?>";
			              var fileDiv_<?= $index; ?> = document.getElementById('pdf-preview-<?= $index; ?>');

			              // Convert file URL to blob
			              fetch(fileURL_<?= $index; ?>)
			                  .then(response => response.blob())
			                  .then(blob => {
			                      // Create a new File object
			                      var file = new File([blob], "<?= $file['file_laporan']; ?>", { type: blob.type });
			                      // Create a new object for each file
			                      var fileObj = document.createElement('object');
			                      fileObj.className = 'file-preview';
			                      fileObj.data = fileURL_<?= $index; ?>; // Set data to a URL representing the file content
			                      fileObj.style = "width:100%;min-height:100%";

			                      // Append the file div to the pdf-preview container
			                      fileDiv_<?= $index; ?>.appendChild(fileObj);

			                  })
			                  .catch(error => console.error('Error loading file:', error));
			            </script>
				        <?php endforeach; ?>
				    </div>
				<?php endif ?>
			</div>
		</div>
	</div>
</main>
