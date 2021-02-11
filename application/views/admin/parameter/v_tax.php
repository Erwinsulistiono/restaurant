<!-- BEGIN BASE-->
<div id="base">

  <!-- BEGIN OFFCANVAS LEFT -->
  <div class="offcanvas"></div>
  <!-- END OFFCANVAS LEFT -->

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class=" fa fa-map-marker"></span> Tax</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_tax"><span class="fa fa-plus"></span> Tax</a></p>
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Tax</th>
                  <th>Persentase</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 0;
                foreach ($data as $table_content) :
                  $tax_id = $table_content['tax_id'];
                  $no++;
                ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['tax_nm']; ?></td>
                    <td><?= $table_content['tax_persen']; ?>%</td>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal" data-target="#modal_edit_tax<?= $tax_id; ?>"><i class="fa fa-pencil"></i></a>
                      <a href="<?= base_url("admin/parameter/hapus_tax/$tax_id"); ?>" onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle btn-raised" title="Delete row">
                        <i class="fa fa-trash-o text-danger"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </section>
    <!-- END TABLE HOVER -->
  </div>
  <!-- END CONTENT -->
</div>
<!-- END BASE -->

<!-- ============ MODAL ADD TAX =============== -->

<div class="modal fade" id="modal_add_tax" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Tax</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/parameter/simpan_tax'); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Pajak</label>
            <div class="col-sm-8">
              <input name="tax_nm" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Persentase</label>
            <div class="col-sm-8">
              <input name="tax_persen" type="number" class="form-control" required>
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


<!-- ============ MODAL EDIT TAX =============== -->
<?php foreach ($data as $table_content) : ?>
  <div class="modal fade" id="modal_edit_tax<?= $table_content['tax_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Edit Tax</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/parameter/simpan_tax'); ?>" enctype="multipart/form-data">
          <input type="hidden" name="tax_id" value="<?= $table_content['tax_id']; ?>">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pajak</label>
              <div class="col-sm-8">
                <input name="tax_nm" value="<?= $table_content['tax_nm']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Persentase</label>
              <div class="col-sm-8">
                <input name="tax_persen" type="number" value="<?= $table_content['tax_persen']; ?>" class="form-control" required>
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