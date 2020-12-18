<div class="row">
	<div class="col-12">
		<div class="col-12">
			<h3>Selamat Datang</h3>
			<div class="card mt-3">
				<div class="card-body">
					<a class="nav-link">
						<div class="row">
							<div class="col-1">
								<?= ($this->session->userdata('role') == 3) ? profPic($this->session->userdata('studentid'), 70) : ''; ?>
							</div>
							<div class="col-11">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('fullname'); ?></span>
								<br>
								<span class="badge badge-primary"><?= $this->session->userdata('studentid'); ?></span>
								<br>
								<span class="badge badge-warning"><?= $this->session->userdata('id_prodi'); ?></span>
								<br>
								<span class="badge badge-success"><?= $this->session->userdata('fakultas'); ?></span>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
