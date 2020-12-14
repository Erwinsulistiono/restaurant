<!-- BEGIN BASE-->
<div id="base">
  <div class="offcanvas">
  </div>
  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="	fa fa-map-marker"></span> Data Payment</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_payment"><span
              class="fa fa-plus"></span> Tambah Tipe Pembayaran</a></p>
        <div class="section-body">
          <div class="row">
            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>QR Code</th>
                  <th>Nama</th>
                  <th>No Rek/No Telp</th>
                  <th>Nama Bank</th>
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
                  <td>
                    <?php if ($table_content['payment_qrcode']) : ?>
                    <img style="width: 80px;height: 80px;" class="img-thumbnail width-1"
                      src="<?= base_url() . 'assets/img/' . $table_content['payment_qrcode']; ?>">
                    <?php endif ?>
                  </td>
                  <td><?= $table_content['payment_nama']; ?></td>
                  <td><?= $table_content['payment_norek']; ?></td>
                  <td><?= $table_content['payment_bank']; ?></td>
                  <td class="text-right">
                    <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal"
                      data-target="#modal_edit_payment<?= $table_content['payment_id']; ?>"><i
                        class="fa fa-pencil"></i></a>
                    <a href="<?= base_url('admin/pos/hapus_payment/') . $table_content['payment_id']; ?>"
                      onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle text-danger btn-raised"
                      title="Delete row"><i class="fa fa-trash-o"></i></a>
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
<!--end #base-->
<!-- END BASE -->

<!-- ============ MODAL ADD PAYMENT =============== -->
<div class="modal fade" id="modal_add_payment" tabindex="-1" role="dialog" aria-labelledby="largeModal"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Pembayaran</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/pos/simpan_payment'); ?>"
        enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label  class="col-sm-3 control-label">QR Code</label>
            <div class="col-sm-8">
              <input type="file" name="payment_qrcode" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Nama Payment</label>
            <div class="col-sm-8">
              <input name="payment_nama" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">No Rekening / No. HP</label>
            <div class="col-sm-8">
              <input name="payment_norek" class="form-control"  required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Bank</label>
            <div class="col-sm-8">
              <input name="payment_bank" class="form-control"  required>
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

<!-- ============ MODAL EDIT OUTLET =============== -->
<?php
foreach ($data as $table_content) :
?>
<div class="modal fade" id="modal_edit_payment<?= $table_content['payment_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Edit Payment</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/pos/simpan_payment'); ?>"
        enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label  class="col-sm-3 control-label">QR Code</label>
            <div class="col-sm-8">
              <input type="hidden" name="payment_id" value="<?= $table_content['payment_id']; ?>">
              <input type="hidden" name="old_payment_qrcode" value="<?= $table_content['payment_qrcode']; ?>"
                class="form-control" >
              <input type="file" name="payment_qrcode" class="form-control" >
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Nama Payment</label>
            <div class="col-sm-8">
              <input name="payment_nama" value="<?= $table_content['payment_nama']; ?>" class="form-control"
                 required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">No Rekening / No. HP</label>
            <div class="col-sm-8">
              <input name="payment_norek" value="<?= $table_content['payment_norek']; ?>" class="form-control"
                 required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-sm-3 control-label">Bank</label>
            <div class="col-sm-8">
              <input name="payment_bank" value="<?= $table_content['payment_bank']; ?>" class="form-control"
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