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
        <h2><span class=" fa fa-map-marker"></span> Kitchen</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>


      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_kitchen"><span
              class="fa fa-plus"></span> Kitchen</a></p>
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kitchen</th>
                  <th>Tanggal Buat</th>
                  <th>Tanggal Update</th>
                  <th>User</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 0;
                foreach ($data as $table_content) :
                  $no++;
                  ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['kitchen_nama']; ?></td>
                    <td><?= $table_content['kitchen_createdat']; ?></td>
                    <td><?= $table_content['kitchen_updatedat']; ?></td>
                    <td><?= $table_content['kitchen_updatedby']; ?></td>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal"
                        data-target="#modal_edit_kitchen<?= $table_content['kitchen_id']; ?>"><i class="fa fa-pencil"></i></a>
                      <a href="<?= base_url(); ?>admin/pos/hapus_kitchen/<?= $dataBase . '/' . $table_content['kitchen_id']; ?>"
                        onclick="return confirm('Apakah anda yakin menghapus : <?= $table_content['kitchen_nama']; ?>?')" class="btn btn-icon-toggle btn-raised" title="Delete row">
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

<div class="modal fade" id="modal_add_kitchen" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Kitchen</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/pos/simpan_kitchen/') . $dataBase ?>"
        enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label  class="col-sm-3 control-label">Nama Kitchen</label>
            <div class="col-sm-8">
              <input name="kitchen_nama" class="form-control" required>
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
<div class="modal fade" id="modal_edit_kitchen<?= $table_content['kitchen_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Edit Kitchen</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/pos/simpan_kitchen/') . $dataBase ; ?>"
        enctype="multipart/form-data">
        <input type="hidden" name="kitchen_id" value="<?= $table_content['kitchen_id']; ?>">
        <div class="modal-body">
          <div class="form-group">
            <label  class="col-sm-3 control-label">Nama Kitchen</label>
            <div class="col-sm-8">
              <input name="kitchen_nama" value="<?= $table_content['kitchen_nama']; ?>" class="form-control" 
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