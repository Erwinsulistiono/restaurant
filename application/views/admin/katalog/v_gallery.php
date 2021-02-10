	<div id="base">

		<div class="offcanvas">
		</div>
		<div id="content">
			<section>
				<div class="section-header">
					<h2><span class="fa fa-image"></span> Data Gallery</h2>
				</div>
				<?= $this->session->flashdata('msg'); ?>
				<section class="card style-default-bright border rounded" style="margin-top:0px;">
					<p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_gallery"><span class="fa fa-plus"></span> Tambah Gallery</a></p>
					<div class="section-body">
						<div class="row">
							<table class="table table-hover" id="datatable1">
								<thead>
									<tr>
										<th>Gambar</th>
										<th>Judul</th>
										<th>Deskripsi</th>
										<th class="text-right">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									foreach ($data as $table_content) :
										$galeri_gambar = $table_content['galeri_gambar'];
										$galeri_id = $table_content['galeri_id'];
										$no++;
									?>
										<tr>
											<td><img style="width:80px;height:80px;" class="img-thumbnail width-1" src="<?= base_url("assets/galeries/${galeri_gambar}"); ?>" alt="" /></td>
											<td><?= $table_content['galeri_judul']; ?></td>
											<td><?= limit_words($table_content['galeri_deskripsi'], 10) . '...'; ?></td>
											<td class="text-right">
												<a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal" data-target="#modal_edit_gallery<?= $table_content['galeri_id']; ?>"><i class="fa fa-pencil"></i></a>
												<a href="<?= base_url("admin/katalog/hapus_gallery/${galeri_id}"); ?>" onclick="return confirm('Apakah anda yakin menghapus <?= $table_content['galeri_judul'] ?>?')" class="btn btn-icon-toggle text-danger btn-raised" title="Delete row"><i class="fa fa-trash-o"></i></a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</section>
		</div>
	</div>

	<!-- ============ MODAL ADD PELANGGAN =============== -->
	<div class="modal fade" id="modal_add_gallery" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
						<span class="fa fa-times"></span></button>
					<h3 class="modal-title" id="myModalLabel">Tambah Gallery</h3>
				</div>
				<form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/katalog/simpan_gallery'); ?>" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-sm-3 control-label">Judul <sup style="color: red;">&#10038<sup></label>
							<div class="col-sm-8">
								<input type="text" name="galeri_judul" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label for="textarea13" class="col-sm-3 control-label">Deskripsi <sup style="color: red;">&#10038<sup></label>
							<div class="col-sm-8">
								<textarea name="galeri_deskripsi" id="textarea13" class="form-control" rows="3" placeholder="" required></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Gambar <sup style="color: red;">&#10038<sup></label>
							<div class="col-sm-8">
								<input type="file" name="filefoto" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-raised btn-primary btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
						<button class="btn btn-primary btn-raised" type="submit"></span> Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- ============ MODAL EDIT GALLERY =============== -->
	<?php foreach ($data as $table_content) : ?>
		<div class="modal fade" id="modal_edit_gallery<?= $table_content['galeri_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
							<span class="fa fa-times"></span></button>
						<h3 class="modal-title" id="myModalLabel">Edit Gallery</h3>
					</div>
					<form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/katalog/simpan_gallery'); ?>" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">Judul <sup style="color: red;">&#10038<sup></label>
								<div class="col-sm-8">
									<input type="hidden" name="galeri_id" value="<?= $table_content['galeri_id']; ?>">
									<input type="text" name="galeri_judul" value="<?= $table_content['galeri_judul']; ?>" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label for="textarea13" class="col-sm-3 control-label">Deskripsi <sup style="color: red;">&#10038<sup></label>
								<div class="col-sm-8">
									<textarea name="galeri_deskripsi" id="textarea13" class="form-control" rows="3" placeholder="" required><?= $table_content['galeri_deskripsi']; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Gambar <sup style="color: red;">&#10038<sup></label>
								<div class="col-sm-8">
									<input type="file" name="filefoto" class="form-control">
									<small style="color: #8B0000;">jika tidak di isi maka akan menggunakan gambar sebelumnya</small>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-flat btn-primary btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
							<button class="btn btn-primary btn-raised" type="submit"></span> Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endforeach; ?>