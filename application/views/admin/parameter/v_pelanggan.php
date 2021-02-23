<div id="base">

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-users"></span> Pelanggan </h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary  btn-raised" data-toggle="modal" data-target="#modal_add_pelanggan"><span class="fa fa-list-ul">&nbsp;</span> Member Request</a></p>
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Telp</th>
                  <th>Plat Nomor</th>
                  <th>Alamat</th>
                  <th>Jam & Tgl Kedatangan</th>
                  <th>Status</th>
                  <th>Socmed</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($pelanggan as $table_content) :
                  $plg_id = $table_content['plg_id'];
                  $no++;
                ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['plg_nama']; ?></td>
                    <td><?= $table_content['plg_notelp'] ? $table_content['plg_notelp'] : ' -- '; ?></td>
                    <td><?= $table_content['plg_platno'] ? $table_content['plg_platno'] : ' -- '; ?></td>
                    <td><?= $table_content['plg_alamat'] ? $table_content['plg_alamat'] : ' -- '; ?></td>
                    <td>
                      <?php if ($table_content['plg_register']) {
                        $date = date_create(substr($table_content['plg_register'], 0, 10));
                        echo date_format($date, "d/m/Y");
                        echo ' - ';
                        echo substr($table_content['plg_register'], 11);
                      } else {
                        echo ' -- ';
                      }
                      ?>
                    </td>
                    <td><?= $table_content['plg_status'] ? $table_content['plg_status'] : ' -- '; ?></td>
                    <td><?= $table_content['plg_socmed'] ? $table_content['plg_socmed'] : ' -- '; ?></td>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Lihat Detail" data-toggle="modal" data-target="#modal_edit_pelanggan<?= $plg_id; ?>"><i class="fa fa-pencil"></i></a>
                      <a href="<?= base_url("admin/parameter/hapus_pelanggan/$plg_id"); ?>" onclick="return confirm('Apakah anda yakin menghapus <?= $table_content['plg_nama']; ?>?')" class="btn btn-icon-toggle btn-raised" title="Delete row">
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


<!-- ============ MODAL TAMBAH PELANGGAN =============== -->
<div class="modal fade" id="modal_add_pelanggan" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-close"></span></button>
        <h3 class="modal-title" id="myModalLabel">Member Request</h3>
      </div>

      <div class="card no-margin">
        <div class="card-body">
          <div class="section-body">
            <div class="row">

              <table class="table table-hover" id="datatable1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Telp</th>
                    <th>Plat Nomor</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Socmed</th>
                    <th>Jam & Tgl Daftar</th>
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($request_member as $table_content) :
                    $plg_id = $table_content['plg_id'];
                    $i++;
                  ?>
                    <tr>
                      <form name="form" method="post" action="<?= base_url("admin/parameter/approve_member/"); ?>">
                        <td><?= $i; ?>
                          <input type="hidden" name="plg_id" value="<?= $plg_id; ?>">
                        </td>
                        <td><?= $table_content['plg_nama']; ?>
                          <input type="hidden" name="plg_nama" value="<?= $table_content['plg_nama']; ?>">
                        </td>
                        <td><?= $table_content['plg_notelp'] ? $table_content['plg_notelp'] : ' -- '; ?>
                          <input type="hidden" name="plg_notelp" value="<?= $table_content['plg_notelp']; ?>">
                        </td>
                        <td><?= $table_content['plg_platno'] ? $table_content['plg_platno'] : ' -- '; ?>
                          <input type="hidden" name="plg_platno" value="<?= $table_content['plg_platno']; ?>">
                        </td>
                        <td><?= $table_content['plg_alamat'] ? $table_content['plg_alamat'] : ' -- '; ?>
                          <input type="hidden" name="plg_alamat" value="<?= $table_content['plg_alamat']; ?>">
                        </td>
                        <td><?= $table_content['plg_status'] ? $table_content['plg_status'] : ' -- '; ?>
                          <input type="hidden" name="plg_status" value="<?= $table_content['plg_status']; ?>">
                        </td>
                        <td><?= $table_content['plg_socmed'] ? $table_content['plg_socmed'] : ' -- '; ?>
                          <input type="hidden" name="plg_socmed" value="<?= $table_content['plg_socmed']; ?>">
                        </td>
                        <td><?= $table_content['plg_register'] ? $table_content['plg_register'] : ' -- '; ?>
                          <input type="hidden" name="plg_register" value="<?= $table_content['plg_register']; ?>">
                        </td>
                        <td class="text-right">
                          <button type="submit" class="btn btn-icon btn-primary btn-flat"><i class="fa fa-check" aria-hidden="true"></i></button>
                          <a href="<?= base_url("admin/parameter/delete_request_member/$plg_id") ?>" class="btn btn-icon btn-danger btn-flat"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                      </form>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
    </div>
  </div>
</div>



<!-- ============ MODAL EDIT PELANGGAN =============== -->
<?php
foreach ($pelanggan as $table_content) :
?>
  <div class="modal fade" id="modal_edit_pelanggan<?= $table_content['plg_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Detail Pelanggan</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/parameter/simpan_pelanggan'); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="hidden" name="plg_id" value="<?= $table_content['plg_id']; ?>">
                <input name="plg_nama" class="form-control" value="<?= $table_content['plg_nama'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Kontak / No Telp <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="text" name="plg_notelp" class="form-control" value="<?= $table_content['plg_notelp'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Platno <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="text" name="plg_platno" class="form-control" value="<?= $table_content['plg_platno'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Alamat <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="text" name="plg_alamat" class="form-control" value="<?= $table_content['plg_alamat'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="select13" class="col-sm-3 control-label">Status <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <select id="select13" name="plg_status" class="form-control" required>

                  <option value="">&nbsp;</option>
                  <?php $status_member = "" ?>
                  <?php $status_pelanggan = "" ?>
                  <?php if ($table_content['plg_status'] == 'member') : ?>
                    <?php $status_member = "selected" ?>
                  <?php endif; ?>
                  <?php if ($table_content['plg_status'] == 'pelanggan') : ?>
                    <?php $status_pelanggan = "selected" ?>
                  <?php endif; ?>

                  <option value="member" <?= $status_member ?>>Member</option>
                  <option value="pelanggan" <?= $status_pelanggan ?>>Pelanggan</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Social Media <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="text" name="plg_socmed" class="form-control" value="<?= @$table_content['plg_socmed'] ?>" required>
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