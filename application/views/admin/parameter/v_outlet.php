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
        <h2><span class="	fa fa-map-marker"></span> Data Outlet</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_outlet"><span class="fa fa-plus"></span> Tambah Outlet</a></p>
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Outlet</th>
                  <th>Nama Outlet</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                  <th>Email</th>
                  <th>Jam Buka</th>
                  <th>Jam Tutup</th>
                  <th>PIC</th>
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
                    <td><?= $table_content['out_kode']; ?></td>
                    <td><?= $table_content['out_nama']; ?></td>
                    <td><?= $table_content['out_alamat']; ?></td>
                    <td><?= $table_content['out_telp']; ?></td>
                    <td><?= $table_content['out_email']; ?></td>
                    <td><?= date_format(date_create($table_content['out_opening_hours']), 'H:i'); ?></td>
                    <td><?= date_format(date_create($table_content['out_closing_hours']), 'H:i'); ?></td>
                    <td><?= $table_content['out_nm_pic']; ?></td>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal" data-target="#modal_edit_outlet<?= $table_content['out_id']; ?>"><i class="fa fa-pencil"></i></a>
                      <a href="<?= base_url('admin/parameter/hapus_outlet/') . $table_content['out_id']; ?>" onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle text-danger btn-raised" title="Delete row"><i class="fa fa-trash-o"></i></a>
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
<div class="modal fade" id="modal_add_outlet" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Outlet</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/parameter/simpan_outlet'); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Kode Outlet</label>
            <div class="col-sm-8">
              <input name="out_kode" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Outlet</label>
            <div class="col-sm-8">
              <input name="out_nama" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-8">
              <input name="out_alamat" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Telepon</label>
            <div class="col-sm-8">
              <input name="out_telp" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Email</label>
            <div class="col-sm-8">
              <input name="out_email" class="form-control" required>
              <?= form_error('out_email', "<small class='text-danger pl-3'>", '</small>'); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Jam Buka</label>
            <div class="col-sm-8">
              <input type="text" name="out_opening_hours" id="timePicker" class="form-control time-picker" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Jam Tutup</label>
            <div class="col-sm-8">
              <input type="text" name="out_closing_hours" id="timePicker" class="form-control time-picker" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Person in Charge</label>
            <div class="col-sm-8">
              <input name="out_nm_pic" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Struk Notes</label>
            <div class="col-sm-8">
              <input name="out_notes" class="form-control" required>
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
<?php
foreach ($data as $table_content) :
?>
  <div class="modal fade" id="modal_edit_outlet<?= $table_content['out_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Edit Outlet</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/parameter/simpan_outlet'); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Kode Outlet</label>
              <div class="col-sm-8">
                <input type="hidden" name="out_id" value="<?= $table_content['out_id']; ?>">
                <input name="out_kode" value="<?= $table_content['out_kode']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Outlet</label>
              <div class="col-sm-8">
                <input name="out_nama" value="<?= $table_content['out_nama']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Alamat</label>
              <div class="col-sm-8">
                <input name="out_alamat" value="<?= $table_content['out_alamat']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Telp</label>
              <div class="col-sm-8">
                <input name="out_telp" value="<?= $table_content['out_telp']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">E-Mail</label>
              <div class="col-sm-8">
                <input name="out_email" value="<?= $table_content['out_email']; ?>" class="form-control" required>
                <?= form_error('out_email', "<small class='text-danger pl-3'>", '</small>'); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Jam Buka</label>
              <div class="col-sm-8">
                <input type="text" name="out_opening_hours" value="<?= date_format(date_create($table_content['out_opening_hours']), 'H:i'); ?>" class="form-control time-picker" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Jam Tutup</label>
              <div class="col-sm-8">
                <input type="text" name="out_closing_hours" value="<?= date_format(date_create($table_content['out_closing_hours']), 'H:i'); ?>" class="form-control time-picker" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">PIC</label>
              <div class="col-sm-8">
                <input name="out_nm_pic" value="<?= $table_content['out_nm_pic']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Struk Notes</label>
              <div class="col-sm-8">
                <input name="out_notes" value="<?= $table_content['notes_receipt']; ?>" class="form-control" required>
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
<?php endforeach; ?>