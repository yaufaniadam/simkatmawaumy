<div class="row">
	<div class="col-md-12">


		<div class="accordion" id="accordionExample">

			<?php
			// print_r($jenis_pengajuan);
			if ($all) { ?>
				<div class="accordion" id="accordionExample">
					<div class="card">
						<div class="card-header" id="headingOne">
							<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									Rekognisi
								</button>
							</h2>
						</div>

						<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="list-group">
								<?php foreach ($rekognisi as $rekognisi) { ?>
									<a href="<?= base_url('mahasiswa/pengajuan/index/' . $rekognisi['Jenis_Pengajuan_Id']); ?>" class="list-group-item list-group-item-action"><?= $rekognisi['Jenis_Pengajuan']; ?></a>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header" id="headingTwo">
							<h2 class="mb-0">
								<a href="<?= base_url('mahasiswa/pengajuan/index/13') ?>" class="btn btn-link btn-block text-left">
									Kelompok Wirausaha
								</a>
							</h2>
						</div>
					</div>
					<div class="card">
						<div class="card-header" id="headingTwo">
							<h2 class="mb-0">
								<a href="<?= base_url('mahasiswa/pengajuan/index/14') ?>" class="btn btn-link btn-block text-left">
									Pengabdian Masyarakat
								</a>
							</h2>
						</div>
					</div>
					<div class="card">
						<div class="card-header" id="headingTwo">
							<h2 class="mb-0">
								<a href="<?= base_url('mahasiswa/pengajuan/index/15') ?>" class="btn btn-link btn-block text-left">
									Student Exchange
								</a>
							</h2>
						</div>
					</div>
					<div class="card">
						<div class="card-header" id="headingTwo">
							<h2 class="mb-0">
								<a href="<?= base_url('mahasiswa/pengajuan/index/16') ?>" class="btn btn-link btn-block text-left">
									Prestasi Mandiri
								</a>
							</h2>
						</div>
					</div>
				</div>

				<?php } else {
				foreach ($jenis_pengajuan as $kategori) { ?>

					<div class="card">
						<div class="card-header" id="heading-<?= $kategori['Jenis_Pengajuan_Id']; ?>">
							<h2 class="h6 mb-0">
								<a href="#" data-toggle="collapse" data-target="#collapse-<?= $kategori['Jenis_Pengajuan_Id']; ?>" aria-expanded="true" aria-controls="collapse-<?= $kategori['Jenis_Pengajuan_Id']; ?>">
									<?= $kategori['Jenis_Pengajuan']; ?>
								</a>
							</h2>
						</div>

						<div id="collapse-<?= $kategori['Jenis_Pengajuan_Id']; ?>" class="collapse" aria-labelledby="heading-<?= $kategori['Jenis_Pengajuan_Id']; ?>" data-parent="#accordionExample">
							<div class="card-body">
								<?= $kategori['deskripsi']; ?>
								<a class="btn btn-md" href="<?= base_url('mahasiswa/pengajuan/baru/' . $kategori['Jenis_Pengajuan_Id']); ?>">Ajukan Surat</a>
							</div>
						</div>
					</div>

			<?php
				}
			}
			?>
		</div>

	</div>
</div>
