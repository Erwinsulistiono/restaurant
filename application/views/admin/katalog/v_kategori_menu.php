<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-list"></span> Data Kategori</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_kategori"><span class="fa fa-plus"></span> Tambah Kategori</a></p>
        <div class="section-body">
          <div class="row">
            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kategori</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($data as $table_content) :
                  $kategori_id = $table_content['kategori_id'];
                  $no++;
                ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['kategori_nama']; ?></td>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal" data-target="#modal_edit_kategori<?= $table_content['kategori_id']; ?>"><i class="fa fa-pencil"></i></a>
                      <a href="<?= base_url("admin/katalog/hapus_kategori_menu/${kategori_id}"); ?>" onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle text-danger btn-raised" title="Delete row"><i class="fa fa-trash-o"></i></a>
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
<div class="modal fade" id="modal_add_kategori" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Kategori</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/katalog/simpan_kategori_menu'); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Kategori</label>
            <div class="col-sm-8">
              <input type="text" name="kategori_nama" class="form-control" required>
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

<!-- ============ MODAL EDIT PENGGUNA =============== -->
<?php foreach ($data as $table_content) : ?>
  <div class="modal fade" id="modal_edit_kategori<?= $table_content['kategori_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Edit Kategori</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/katalog/simpan_kategori_menu'); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Kategori</label>
              <div class="col-sm-8">
                <input type="hidden" name="kategori_id" value="<?= $table_content['kategori_id']; ?>">
                <input type="text" name="kategori_nama" value="<?= $table_content['kategori_nama']; ?>" class="form-control" required>
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