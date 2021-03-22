<div class="row">

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-6 col-md-6 mb-4">


		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Informasi Terbaru</h6>
			</div>
			<div class="card-body">
				<div class="timeline timeline-xs">
					<!-- Timeline Item 1-->
					<div class="timeline-item">
						<div class="timeline-item-marker">
							<div class="timeline-item-marker-text">24 Mar</div>
							<div class="timeline-item-marker-indicator bg-success"></div>
						</div>
						<div class="timeline-item-content">
							New order placed!
							<a class="font-weight-bold text-dark" href="#!">Order #2912</a>
							has been successfully placed.
						</div>
					</div>
					<!-- Timeline Item 2-->
					<div class="timeline-item">
						<div class="timeline-item-marker">
							<div class="timeline-item-marker-text">23 Mar</div>
							<div class="timeline-item-marker-indicator bg-info"></div>
						</div>
						<div class="timeline-item-content">
							Your
							<a class="font-weight-bold text-dark" href="#!">weekly report</a>
							has been generated and is ready to view.
						</div>
					</div>
					<!-- Timeline Item 3-->
					<div class="timeline-item">
						<div class="timeline-item-marker">
							<div class="timeline-item-marker-text">2 hrs</div>
							<div class="timeline-item-marker-indicator bg-ungu"></div>
						</div>
						<div class="timeline-item-content">
							New user
							<a class="font-weight-bold text-dark" href="#!">Valerie Luna</a>
							has registered
						</div>
					</div>
					<!-- Timeline Item 4-->
					<div class="timeline-item">
						<div class="timeline-item-marker">
							<div class="timeline-item-marker-text">1 day</div>
							<div class="timeline-item-marker-indicator bg-warning"></div>
						</div>
						<div class="timeline-item-content">Server activity monitor alert</div>
					</div>
					<!-- Timeline Item 5-->
					<div class="timeline-item">
						<div class="timeline-item-marker">
							<div class="timeline-item-marker-text">1 day</div>
							<div class="timeline-item-marker-indicator bg-danger"></div>
						</div>
						<div class="timeline-item-content">
							New order placed!
							<a class="font-weight-bold text-dark" href="#!">Order #2911</a>
							has been successfully placed.
						</div>
					</div>
					<!-- Timeline Item 6-->
					<div class="timeline-item">
						<div class="timeline-item-marker">
							<div class="timeline-item-marker-text">1 day</div>
							<div class="timeline-item-marker-indicator bg-perak"></div>
						</div>
						<div class="timeline-item-content">
							Details for
							<a class="font-weight-bold text-dark" href="#!">Marketing and Planning Meeting</a>
							have been updated.
						</div>
					</div>
					<!-- Timeline Item 7-->
					<div class="timeline-item">
						<div class="timeline-item-marker">
							<div class="timeline-item-marker-text">2 days</div>
							<div class="timeline-item-marker-indicator bg-ijomuda"></div>
						</div>
						<div class="timeline-item-content">
							New order placed!
							<a class="font-weight-bold text-dark" href="#!">Order #2910</a>
							has been successfully placed.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-6 col-md-6 mb-4">
		<div class="row">
			<div class="col-xl-6 col-md-6 mb-4">
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
									Pengajuan Saya <a href="<?= base_url('mahasiswa/pengajuan/pengajuan_saya/'); ?>" title="Lihat Semua Pengajuan"><i class="fas fa-external-link-alt"></i></a></div>
								<div><span class="h3 mb-0 font-weight-bold text-gray-800">3</span> </div>

							</div>
							<div class="col-auto">
								<i class="fas fa-envelope-open fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-md-6 mb-4">
				<div class="card border-left-warning shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
									Prestasi Saya <a href="<?= base_url('mahasiswa/pengajuan/prestasi_saya/'); ?>" title="Lihat Semua Prestasi Saya"><i class="fas fa-external-link-alt"></i></a></div>
								<div class="h3 mb-0 font-weight-bold text-gray-800">13</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-medal fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>



		</div>

		<div class="card shadow mb-4">
			<div class="card-body">
				<a class="nav-link">
					<div class="row">
						<div class="col-2">
							<?= ($this->session->userdata('role') == 3) ? profPic($this->session->userdata('studentid'), 70) : ''; ?>
						</div>
						<div class="col-10">
							<h5><?= $this->session->userdata('fullname'); ?></h5>

							<span class="badge badge-primary"><?= $this->session->userdata('studentid'); ?></span>
							<br>
							<span class="badge badge-warning"><?= $this->session->userdata('id_prodi'); ?></span>
						</div>
					</div>
				</a>
			</div>
		</div>

	</div>
</div>