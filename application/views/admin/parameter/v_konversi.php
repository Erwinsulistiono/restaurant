<!-- BEGIN BASE-->
<div id="base">

  <!-- BEGIN OFFCANVAS LEFT -->
  <div class="offcanvas">

  </div>
  <!--end .offcanvas-->
  <!-- END OFFCANVAS LEFT -->

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="	fa fa-map-marker"></span> Tabel Konversi Satuan</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_konversi"><span
              class="fa fa-plus"></span> Tambah Satuan</a></p>
        <div class="section-body">
          <div class="row">
            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Satuan Kode</th>
                  <th>Satuan Refferensi</th>
                  <th>Val / Satuan Refferensi</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($data as $table_content) :
                  $no++ ?>
                <tr>
                  <td><?= $no; ?></td>
                  <td><?= $table_content['satuan_kode']; ?></td>
                  <td><?= $table_content['satuan_reff']; ?></td>
                  <td><?= $table_content['satuan_val']; ?></td>
                  <td class="text-right">
                    <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal"
                      data-target="#modal_edit_konversi<?= $table_content['satuan_id']; ?>"><i
                        class="fa fa-pencil"></i></a>
                    <a href="<?= base_url('admin/konversi/hapus_konversi/') . $table_content['satuan_id'] ?>"
                      class="btn btn-icon-toggle btn-raised" title="Delete row"><i onclick="return confirm('Apakah anda yakin?')"
                        class="fa fa-trash-o text-danger"></i></a>
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

<!-- ============ MODAL ADD OUTLET =============== -->
<div class="modal fade" id="modal_add_konversi" tabindex="-1" role="dialog" aria-labelledby="largeModal"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Outlet</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/konversi/simpan_konversi'); ?>"
        enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Satuan Kode</label>
            <div class="col-sm-8">
              <input name="satuan_kode" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Satuan Referensi</label>
            <div class="col-sm-8">
              <select name="satuan_reff" class="form-control">
                <option value="">&nbsp;</option>
                <?php
                $satuan = "";
                foreach ($data as $row) :
                  if ($satuan !== $row['satuan_reff']) :
                ?>
                  <option value="<?= $row['satuan_reff']; ?>"><?= $row['satuan_reff']; ?></option>
                <?php
                    $satuan = $row['satuan_reff'];
                  endif;
                endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Konversi Value / Satuan Reff</label>
            <div class="col-sm-8">
              <input type="number" name="satuan_val" class="form-control" required>
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

<!-- ============ MODAL EDIT OUTLET =============== -->
<?php foreach ($data as $table_content) : ?>
<div class="modal fade" id="modal_edit_konversi<?= $table_content['satuan_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Edit Outlet</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/konversi/simpan_konversi'); ?>"
        enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Satuan Kode</label>
            <div class="col-sm-8">
              <input type="hidden" name="satuan_id" class="form-control" value="<?= $table_content['satuan_id'] ?>" required>
              <input name="satuan_kode" class="form-control" value="<?= $table_content['satuan_kode'] ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Satuan Referensi</label>
            <div class="col-sm-8">
              <select name="satuan_reff" class="form-control">
                <option value="<?= $table_content['satuan_reff'] ?>"><?= $table_content['satuan_reff'] ?></option>
                <?php
                  $satuan = "";
                  foreach ($data as $row) :
                    if ($satuan !== $row['satuan_reff']) :
                  ?>
                <option value="<?= $row['satuan_reff']; ?>"><?= $row['satuan_reff']; ?></option>
                <?php
                      $satuan = $row['satuan_reff'];
                    endif;
                  endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Konversi Value / Satuan Reff</label>
            <div class="col-sm-8">
              <input type="number" name="satuan_val" class="form-control"
                value="<?= floatval($table_content['satuan_val']); ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
          <button class="btn btn-primary btn-primary" type="submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>