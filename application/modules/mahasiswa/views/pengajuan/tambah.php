<!-- CSS & JS -->

<?php call_styles(); ?>

<h1 class="h3 mb-4 text-gray-900"><?php /*echo $surat['kategori_surat'];*/ ?> </h1>

<div class="row">
	<div class="col-md-8 mb-4">

		<div class="card shadow">
			<a href="#collKeterangan" class="d-block card-header pt-3 pb-2 bg-abumuda <?= ($pengajuan->status_id == 10) ? "collapsed" : "" ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collKeterangan">
				<p class="h6 font-weight-bold text-white">Keterangan</p>
			</a>
			<div class="collapse<?= ($pengajuan->status_id == 10) ? "" : " show" ?>" id="collKeterangan">
				<div class="card-body">

					<?php echo form_open(base_url('mahasiswa/pengajuan/tambah/' . $pengajuan->pengajuan_id), '') ?>

					<input type="hidden" name="id_surat" value="<?= $pengajuan->pengajuan_id ?>">
					<input type="hidden" name="id_notif" value="<?php /*echo $surat['id_notif'];*/ ?>">

					<?php
					foreach ($pengajuan_fields as $pengajuan_field) { ?>

						<div class="form-group row">
							<label class="col-md-5" for="dokumen[<?= $pengajuan_field['field_id']; ?>]">
								<?= $pengajuan_field['field'] ?>
								<small id="emailHelp" class="form-text text-muted">
									<?= $pengajuan_field['deskripsi'] ?>
								</small>
							</label>

							<div class="col-md-7">
								<?php generate_form_field($pengajuan_field['field_id'], $pengajuan_id, $pengajuan_status, 'mahasiswa/pengajuan'); ?>
							</div>
						</div>

					<?php  }  ?>

					<?php if ($pengajuan->status_id == 4) { ?>
						<input type="hidden" name="status" value="4">
						<input class="btn btn-lg btn-<?= $pengajuan->badge; ?> btn-block" type="submit" name="submit" value="<?= ($pengajuan->status_id == '4') ? " Kirim Revisi Data" : "Ajukan Surat " . $pengajuan->Jenis_Pengajuan; ?>" />

					<?php } elseif ($pengajuan->status_id == 1) { ?>
						<input type="hidden" name="status" value="<?= ($pengajuan->status_id == 1) ? '1' : '2' ?>">
						<input class="btn btn-lg btn-<?= $pengajuan->badge; ?> btn-block" type="submit" name="submit" value="<?= ($pengajuan->status_id == 1) ? 'Ajukan Prestasi' : 'Simpan perubahan' ?> " />
					<?php } ?>

					<?php echo form_close();  ?>
				</div>
			</div>

		</div>
		<?php if ($pengajuan->status_id == 10) {  ?>
			<div class="card shadow mt-3">
				<a href="#collterbit" class="d-block card-header pt-3 pb-2 bg-success" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collterbit">
					<p class="h6 font-weight-bold text-white">Blangko</p>
				</a>
				<div class="collapse show" id="collterbit">
					<div class="card-body pb-3">
						Blangko
						<a href="<?php /*echo base_url("mahasiswa/surat/tampil_surat/" . $surat['id']); */ ?>" class="btn btn-success"> <i class="fas fa-file-pdf"></i> PDF</a>
					</div>
				</div>
			</div>
		<?php  } ?>

	</div>
	<div class="col-md-4">

		<div class="card shadow">
			<a href="#collStatus" class="d-block card-header pt-3 pb-2 bg-<?= $pengajuan->badge ?>" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collStatus">
				<p class="h5 text-center font-weight-bold text-white"> <?= $pengajuan->status ?> </p>
			</a>
			<div class="collapse show" id="collStatus">
				<div class="card-body pl-2">
					<ul class="timeline">
						<?php foreach ($timeline as $tl) { ?>
							<li>
								<span class="badge badge-<?= $tl['badge']; ?>"><?= $tl['status']; ?></span>
								<span class="badge badge-secondary"><?= $tl['date']; ?></span>
								<span class="badge badge-perak"><?= $tl['time']; ?></span>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>

		<!-- <?php if ($pengajuan->status_id == 7) { ?>
			<div class="card shadow mt-3">
				<a href="#collterbit" class="d-block card-header pt-3 pb-2 bg-success" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collterbit">
					<p class="h6 font-weight-bold text-white">Blangko Pencairan Dana</p>
				</a>
				<div class="collapse show" id="collterbit">
					<div class="card-body pb-3">
						<p>Selamat, pengajuan Anda telah diverifikasi. Download Blangko di bawah ini. </p>

						<a href="<?= base_url("mahasiswa/pengajuan/tampil_pengajuan/" . $pengajuan->pengajuan_id); ?>" class="btn btn-success btn-block"> <i class="fas fa-file-pdf"></i> Download blangko</a>
					</div>
				</div>
			</div>
		<?php } ?> -->


	</div>
	<!-- /.col -->
</div>

<?php call_scripts(); ?>