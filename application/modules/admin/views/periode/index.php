<div class="row">
	<div class="col-12">

		<div class="card card-success card-outline">
			<div class="card-header">
				<a class="nav-s text-danger" href="<?= base_url("admin/periode/index/1"); ?>">
					<i class="fas fa-fw fa-exclamation-circle"></i>
					Sudah Diterbitkan
				</a>
				</a>&nbsp;
				<a class=" nav-lilk" href="<?= base_url("admin/periode/index/0"); ?>">
					<i class="fas fa-fw fa-envelope"></i>
					Belum Diterbitkan
				</a>
			</div>
			<div class="card-body">
				<table id="pengajuan-desc" class="table table-bordered tb-pengajuans">
					<thead>
						<tr>
							<th style="width:50%">Periode</th>
							<th style="width:20%">Status</th>
							<th>Tanggal Terbit</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($daftar_periode as $periode) { ?>
							<tr>
								<td><a href="<?= base_url('admin/periode/bulan/' . $periode['id_periode']); ?>"><?= $periode['nama_periode']; ?></a></td>
								<td><?= $periode['status'] == 0 ? 'Belum Diterbitkan' : 'Sudah Diterbitkan'; ?></td>
								<td><?= $periode['tanggal'] == '' ? '-' : $periode['tanggal']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div><!-- /.card-body -->
		</div><!-- /.card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->


<div class="modal fade" id="confirm-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Perhatian</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutuo">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Yakin ingin menghapus data ini?&hellip;</p>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a class="btn btn-danger btn-ok">Hapus</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- DataTables -->
<script src="<?= base_url() ?>/public/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
	$(document).ready(function() {
		$('#pengajuan-desc').DataTable({});
	});
</script>
