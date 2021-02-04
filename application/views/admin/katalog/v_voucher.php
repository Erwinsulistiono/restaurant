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
          <h2><span class="	fa fa-map-marker"></span> Data voucher</h2>
        </div>
        <?= $this->session->flashdata('msg'); ?>

        <!-- BEGIN TABLE HOVER -->
        <section class="card style-default-bright" style="margin-top:0px;">
          <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_voucher"><span class="fa fa-plus"></span> Tambah voucher</a></p>
          <div class="section-body">
            <div class="row">
              <table class="table table-hover" id="datatable1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Nominal Discount</th>
                    <th>% Discount</th>
                    <th>Periode</th>
                    <th>limit</th>
                    <th>T&C</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($data as $table_content) :
                    $voucher_id = $table_content['voucher_id'];
                    $no++ ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $table_content['voucher_kode']; ?></td>
                      <td><?= $table_content['voucher_nama']; ?></td>
                      <td><?= number_format($table_content['voucher_nominal']); ?></td>
                      <td><?= $table_content['voucher_discount'] . '%'; ?></td>
                      <td><?= $table_content['voucher_periode_awal'] . ' - ' . $table_content['voucher_periode_akhir']; ?>
                      </td>
                      <td><?= number_format($table_content['voucher_limit']); ?></td>
                      <td><?= $table_content['voucher_tandc']; ?></td>
                      <td class="text-right">
                        <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal" data-target="#modal_edit_voucher<?= $table_content['voucher_id']; ?>"><i class="fa fa-pencil"></i></a>
                        <a href="<?= base_url("admin/katalog/hapus_voucher/${voucher_id}"); ?>" onclick="return confirm('Apakah anda yakin menghapus voucher <?= $table_content['voucher_nama'] ?>?')" class="btn btn-icon-toggle text-danger btn-raised" title="Delete row"><i class="fa fa-trash-o"></i></a>
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

  <!-- ============ MODAL ADD VOUCHER =============== -->
  <div class="modal fade" id="modal_add_voucher" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Tambah voucher</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/katalog/simpan_voucher'); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Kode voucher <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input name="voucher_kode" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama voucher <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input name="voucher_nama" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Diskon <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="number" name="voucher_diskon" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label for="select13" class="col-sm-3 control-label">Jenis Diskon <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <select id="select13" name="jenis_diskon" class="form-control" required>
                  <option value="">&nbsp;</option>
                  <option value="discount">Persentase Pembelian</option>
                  <option value="nominal">Pemotongan Nominal</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="demo-date" class="col-sm-3 control-label">Periode <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <div class="input-group input-daterange">
                  <input type="date" name="voucher_periode_awal" class="datepicker input-group date form-control" id="demo-date-range" required>
                  <span class="input-group-addon">to</span>
                  <input type="date" name="voucher_periode_akhir" class="datepicker input-group date form-control" id="demo-date-range" required>
                  <span class="input-group-addon"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Limit voucher <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="number" name="voucher_limit" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Syarat T&C <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input name="voucher_syarat" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-flat btn-raised btn-primary" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button class="btn btn-primary btn-raised" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ============ MODAL EDIT VOUCHER =============== -->
  <?php foreach ($data as $table_content) : ?>
    <div class="modal fade" id="modal_edit_voucher<?= $table_content['voucher_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
              <span class="fa fa-times"></span></button>
            <h3 class="modal-title" id="myModalLabel">Edit voucher</h3>
          </div>
          <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/katalog/simpan_voucher'); ?>" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label class="col-sm-3 control-label">Kode voucher <sup style="color: red;">&#10038<sup></label>
                <div class="col-sm-8">
                  <input type="hidden" name="voucher_id" value="<?= $table_content['voucher_id']; ?>">
                  <input name="voucher_kode" value="<?= $table_content['voucher_kode']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Nama voucher <sup style="color: red;">&#10038<sup></label>
                <div class="col-sm-8">
                  <input name="voucher_nama" value="<?= $table_content['voucher_nama']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Diskon <sup style="color: red;">&#10038<sup></label>
                <div class="col-sm-8">
                  <?php if ($table_content['voucher_nominal'] !== '0') : ?>
                    <input name="voucher_diskon" type="number" value="<?= $table_content['voucher_nominal']; ?>" class="form-control" required>
                  <?php else : ?>
                    <input name="voucher_diskon" type="number" value="<?= $table_content['voucher_discount']; ?>" class="form-control" required>
                  <?php endif; ?>
                </div>
              </div>
              <div class="form-group">
                <label for="select13" class="col-sm-3 control-label">Jenis Diskon <sup style="color: red;">&#10038<sup></label>
                <div class="col-sm-8">
                  <select id="select13" name="jenis_diskon" class="form-control" required>
                    <option value="">&nbsp;</option>
                    <?php if ($table_content['voucher_nominal'] !== '0') : ?>
                      <option value="nominal" selected>Pemotongan Nominal</option>
                      <option value="discount">Presentase Pembelian</option>
                    <?php else : ?>
                      <option value="nominal">Pemotongan Nominal</option>
                      <option value="discount" selected>Presentase Pembelian</option>
                    <?php endif; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="demo-date" class="col-sm-3 control-label">Periode <sup style="color: red;">&#10038<sup></label>
                <div class="col-sm-8">
                  <div class="input-group input-daterange">
                    <input type="date" name="voucher_periode_awal" value="<?= $table_content['voucher_periode_awal']; ?>" class="datepicker date form-control" id="demo-date-range">
                    <span class="input-group-addon">to</span>
                    <input type="date" name="voucher_periode_akhir" value="<?= $table_content['voucher_periode_akhir']; ?>" class="datepicker date form-control" id="demo-date-range">
                    <span class="input-group-addon"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Limit voucher <sup style="color: red;">&#10038<sup></label>
                <div class="col-sm-8">
                  <input name="voucher_limit" type="number" value="<?= $table_content['voucher_limit']; ?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Syarat T&C <sup style="color: red;">&#10038<sup></label>
                <div class="col-sm-8">
                  <input name="voucher_syarat" value="<?= $table_content['voucher_syarat']; ?>" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-flat btn-raised btn-primary" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>