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
        <h2><span class=" fa fa-map-marker"></span> Meja</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>


      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_meja"><span class="fa fa-plus"></span> Meja</a></p>
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Meja</th>
                  <th>Lokasi</th>
                  <th>Lantai</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 0;
                foreach ($data as $table_content) :
                  $meja_id = $table_content['meja_id'];
                  $no++;
                ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['meja_nama']; ?></td>
                    <td><?= $table_content['area_nama']; ?></td>
                    <td><?= $table_content['area_level']; ?></td>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal" data-target="#modal_edit_meja<?= $table_content['meja_id']; ?>"><i class="fa fa-pencil"></i></a>
                      <a href="<?= base_url("admin/restaurant/hapus_meja/${outlet_id}/$meja_id"); ?>" onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle btn-raised" title="Delete row">
                        <i class="fa fa-trash-o text-danger"></i></a>
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

<!-- ============ MODAL ADD MEJA =============== -->

<div class="modal fade" id="modal_add_meja" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Meja</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url("admin/restaurant/simpan_meja/${outlet_id}"); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Meja <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <input name="meja_nama" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Lantai - Area <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <select id="select13" name="meja_lokasi" class="form-control" required>
                <option value="">&nbsp;</option>
                <?php
                foreach ($area as $table_content) : ?>
                  <option value="<?= $table_content['area_id']; ?>">
                    <?= $table_content['area_level'] . ' - ' . $table_content['area_nama']; ?> </option>
                <?php endforeach; ?>
              </select>
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


<!-- ============ MODAL EDIT MEJA =============== -->
<?php foreach ($data as $table_content) : ?>
  <div class="modal fade" id="modal_edit_meja<?= $table_content['meja_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Edit Meja</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url("admin/restaurant/simpan_meja/$outlet_id"); ?>" enctype="multipart/form-data">
          <input type="hidden" name="meja_id" value="<?= $table_content['meja_id']; ?>">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Meja <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input name="meja_nama" value="<?= $table_content['meja_nama']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Lantai - Area <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <select id="select13" name="meja_lokasi" class="form-control" required>
                  <?php
                  foreach ($area as $row) :
                    $m_id = $table_content['meja_lokasi'];
                    $a_id = $row['area_id'];
                    $a_nama = $row['area_nama'];
                    $a_level = $row['area_level'];
                    ($m_id == $a_id) ? $select = "selected" : $select = "";
                  ?>
                    <option value="<?= $a_id ?>" <?= $select ?>> <?= "${a_level} - ${a_nama}" ?></option>
                  <?php endforeach; ?>
                </select>
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