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
        <h2><span class="	fa fa-map-marker"></span> Data Supplier</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_supplier"><span
              class="fa fa-plus"></span> Tambah Supplier</a></p>
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Supplier</th>
                  <th>Nama Supplier</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                  <th>PIC</th>
                  <th>Email</th>
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
                  <td><?= $table_content['supplier_kode']; ?></td>
                  <td><?= $table_content['supplier_nama']; ?></td>
                  <td><?= $table_content['supplier_alamat']; ?></td>
                  <td><?= $table_content['supplier_telp']; ?></td>
                  <td><?= $table_content['supplier_pic']; ?></td>
                  <td><?= $table_content['supplier_email']; ?></td>
                  <td class="text-right">
                    <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal"
                      data-target="#modal_edit_supplier<?= $table_content['supplier_id']; ?>"><i
                        class="fa fa-pencil"></i></a>
                    <a href="<?= base_url('admin/parameter/hapus_supplier/') . $table_content['supplier_id']; ?>"
                      onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle text-danger btn-raised"
                      title="Delete row"><i class="fa fa-trash-o"></i></a>
                    <a href="#" class="btn btn-icon-toggle btn-raised" title="Delete row" data-toggle="modal"
                      data-target="#modal_hapus_supplier<?= $table_content['supplier_id']; ?>"><i
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
<div class="modal fade" id="modal_add_supplier" tabindex="-1" role="dialog" aria-labelledby="largeModal"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Supplier</h3>
      </div>
      <form class="form-horizontal" role="form" method="post"
        action="<?= base_url('admin/parameter/simpan_supplier'); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label  class="col-sm-3 control-label">Kode Supplier</label>
            <div class="col-sm-8">
              <input name="supplier_kode" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Nama Supplier</label>
            <div class="col-sm-8">
              <input name="supplier_nama" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-8">
              <input name="supplier_alamat" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Telepon</label>
            <div class="col-sm-8">
              <input name="supplier_telp" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Email</label>
            <div class="col-sm-8">
              <input name="supplier_email" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">PIC</label>
            <div class="col-sm-8">
              <input type="" name="supplier_pic" class="form-control"  required>
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
<?php
foreach ($data as $table_content) :
?>
<div class="modal fade" id="modal_edit_supplier<?= $table_content['supplier_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Edit Supplier</h3>
      </div>
      <form class="form-horizontal" role="form" method="post"
        action="<?= base_url('admin/parameter/simpan_supplier'); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label  class="col-sm-3 control-label">Kode Supplier</label>
            <div class="col-sm-8">
              <input type="hidden" name="supplier_id" value="<?= $table_content['supplier_id']; ?>">
              <input name="supplier_kode" value="<?= $table_content['supplier_kode']; ?>" class="form-control"
                 required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Nama Supplier</label>
            <div class="col-sm-8">
              <input name="supplier_nama" value="<?= $table_content['supplier_nama']; ?>" class="form-control"
                 required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-8">
              <input name="supplier_alamat" value="<?= $table_content['supplier_alamat']; ?>" class="form-control"
                 required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Telp</label>
            <div class="col-sm-8">
              <input name="supplier_telp" value="<?= $table_content['supplier_telp']; ?>" class="form-control"
                 required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">E-Mail</label>
            <div class="col-sm-8">
              <input name="supplier_email" value="<?= $table_content['supplier_email']; ?>" class="form-control"
                 required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">PIC</label>
            <div class="col-sm-8">
              <input name="supplier_pic" value="<?= $table_content['supplier_pic']; ?>" class="form-control"
                 required>
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

<!-- ============ MODAL HAPUS SUPPLIER =============== -->
<?php
foreach ($data as $table_content) :
?>
<div class="modal fade" id="modal_hapus_supplier<?= $table_content['supplier_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Hapus Pengguna</h3>
      </div>
      <form class="form-horizontal" role="form" method="post"
        action="<?= base_url('admin/parameter/hapus_supplier'); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label  class="col-sm-2 control-label"></label>
            <div class="col-sm-8">
              <input type="hidden" name="supplier_id" value="<?= $table_content['supplier_id']; ?>">
              <input type="hidden" name="supplier_nama" value="<?= $table_content['supplier_nama']; ?>">
              <h4 class="text-light no-margin">Apakah Anda yakin mau menghapus data supplier
                <b><?= $table_content['supplier_nama']; ?></b>
                ?</h4>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
          <button class="btn btn-danger" type="submit"><span class="fa fa-trash"></span> Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>