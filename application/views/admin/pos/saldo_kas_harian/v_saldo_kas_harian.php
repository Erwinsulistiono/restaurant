<div id="base">

	<div id="content">
		<section>
			<div class="section-header">
				<h2><span class="fa fa-book"></span> Saldo Kas Harian</h2>
			</div>
			<?= $this->session->flashdata('msg'); ?>


			<!-- BEGIN TABLE HOVER -->
			<section class="card style-default-bright" style="margin-top:0px;">
				<p><a href="<?= base_url('admin/pos/pilih_saldo/'); ?>" class="btn btn-primary"><span class="fa fa-arrow-left"></span>
						Kembali</a>
					<a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_saldo"><span class="fa fa-plus"></span> Tambah Saldo</a>
					<a href="<?= base_url("admin/pos/pdf/$pengguna_kasir/$tgl_awal/$tgl_akhir/$outlets"); ?>" target="_blank" class="btn btn-default-light text-danger btn-raised"><span class="fa fa-file-pdf-o text-danger"></span>
						PDF</a>
					<a href="<?= base_url("admin/pos/excel/$pengguna_kasir/$tgl_awal/$tgl_akhir/$outlets"); ?>" class="btn btn-default-light text-success btn-raised"><span class="fa fa-file-excel-o text-success"></span>
						EXCEL</a>
				</p>
				<div class="section-body">
					<div class="row">

						<table class="table table-hover" id="datatable1">
							<thead>
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Kode Outlet</th>
									<th>Outlet</th>
									<th>Nama Kasir</th>
									<th>Saldo Awal</th>
									<th>Saldo Akhir</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 0;
								foreach ($data as $table_content) :
									$no++ ?>
									<tr>
										<td><?= $no; ?></td>
										<td><?= $table_content['kas_tgl']; ?></td>
										<td><?= $table_content['out_kode']; ?></td>
										<td><?= $table_content['out_nama']; ?></td>
										<td><?= $table_content['pengguna_nama']; ?></td>
										<td><?= number_format($table_content['kas_saldo_awal']); ?></td>
										<td><?= number_format($table_content['kas_saldo_akhir']); ?></td>
										<td class="text-right">
											<a href="#" class="btn btn-icon-toggle btn-raised" title="Input Saldo Akhir" data-toggle="modal" data-target="#modal_edit_saldo<?= $table_content['kas_id']; ?>"><i class="fa fa-pencil"></i></a>
										</td>
									</tr>
								<?php endforeach; ?>

							</tbody>
						</table>

					</div>
				</div>
				<!--end .section-body -->

			</section>
		</section>
		<!-- END TABLE HOVER -->



	</div>
	<!--end #content-->
	<!-- END CONTENT -->

</div>
<!--end #base-->
<!-- END BASE -->

<!-- ============ MODAL ADD SALDO =============== -->
<div class="modal fade" id="modal_add_saldo" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
					<span class="fa fa-times"></span></button>
				<h3 class="modal-title" id="myModalLabel">Tambah Saldo</h3>
			</div>

			<form class="form-horizontal" role="form" method="post" action="<?= base_url("admin/pos/simpan_saldo/$pengguna_kasir/$tgl_awal/$tgl_akhir/$outlets"); ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label for="textarea13" class="col-sm-3 control-label">Outlet</label>
						<div class="col-sm-8">
							<select id="select13" name="out_id" class="form-control" required>
								<option value="">&nbsp;</option>
								<?php
								foreach ($outlet as $table_content) : ?>
									<option value="<?= $table_content['out_id']; ?>"><?= $table_content['out_nama']; ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="textarea13" class="col-sm-3 control-label">Nama Kasir</label>
						<div class="col-sm-8">
							<input type="text" name="kas_nm_kasir" id="textarea13" class="form-control" required></input>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Saldo Awal</label>
						<div class="col-sm-8">
							<input type="number" name="kas_saldo_awal" class="form-control" required>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
					<button class="btn btn-primary btn-raised" type="submit">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- ============ MODAL EDIT SALDO =============== -->
<?php foreach ($data as $table_content) : ?>
	<div class="modal fade" id="modal_edit_saldo<?= $table_content['kas_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
						<span class="fa fa-times"></span></button>
					<h3 class="modal-title" id="myModalLabel">Input Saldo Akhir</h3>
				</div>
				<form class="form-horizontal" role="form" method="post" action="<?= base_url("admin/pos/simpan_saldo/${pengguna_kasir}/${tgl_awal}/${tgl_akhir}/${outlets}"); ?>" enctype="multipart/form-data">
					<div class="modal-body">

						<div class="form-group">
							<label class="col-sm-3 control-label">Outlet</label>
							<div class="col-sm-8">
								<input type="hidden" name="kas_id" value="<?= $table_content['kas_id']; ?>">
								<input type="hidden" name="out_id" value="<?= $table_content['out_id']; ?>">
								<input type="text" name="kas_nm_outlet" value="<?= $table_content['out_nama']; ?>" class="form-control" required>
							</div>
						</div>

						<div class="form-group">
							<label for="textarea13" class="col-sm-3 control-label">Nama Kasir</label>
							<div class="col-sm-8">
								<input type="hidden" name="kas_nm_kasir" value="<?= $table_content['pengguna_id']; ?>" id="textarea13" class="form-control" required readonly></input>
								<input value="<?= $table_content['pengguna_nama']; ?>" id="textarea13" class="form-control" required readonly></input>
							</div>
						</div>

						<div class="form-group">
							<label for="textarea13" class="col-sm-3 control-label">Saldo Awal</label>
							<div class="col-sm-8">
								<input type="number" name="kas_saldo_awal" value="<?= number_format($table_content['kas_saldo_awal'], 0, ',', '.'); ?>" id="textarea13" class="form-control" required></input>
							</div>
						</div>

						<div class="form-group">
							<label for="textarea13" class="col-sm-3 control-label">Saldo Akhir</label>
							<div class="col-sm-8">
								<input type="number" name="kas_saldo_akhir" value="<?= number_format($table_content['kas_saldo_akhir']); ?>" id="textarea13" class="form-control" required></input>
							</div>
						</div>


					</div>
					<div class="modal-footer">
						<button class="btn btn-primary btn-flat btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
						<button class="btn btn-primary btn-raised" type="submit">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endforeach; ?>