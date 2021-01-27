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
        <h2><span class="fa fa-user"></span> Data Pengguna</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>


      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_pengguna"><span class="fa fa-plus"></span> Tambah Pengguna</a></p>
        <div class="section-body">
          <div class="row">
            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>Photo</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Jabatan</th>
                  <th>Dashboard</th>
                  <th>Email</th>
                  <th>Kontak</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $table_content) :
                  $pengguna_photo = $table_content['pengguna_photo'];
                  $pengguna_id = $table_content['pengguna_id'];
                ?>
                  <tr>
                    <td><img style="width:40px;height:40px;" class="img-circle width-1" src="<?= base_url("assets/images/${pengguna_photo}"); ?>" alt="" /></td>
                    <td><?= $table_content['pengguna_nama']; ?></td>
                    <?= ($table_content['pengguna_jenkel'] == 'P') ? '<td>Perempuan</td>' : '<td>Laki - laki</td>'; ?>
                    <td>
                      <?php foreach ($level as $lev) :
                        if ($table_content['pengguna_level'] == $lev['level_id']) :
                          echo $lev['level_desc'];
                        endif;
                      endforeach;
                      ?>

                      <?php foreach ($level_pos as $lev) :
                        if ($table_content['pengguna_level'] == $lev['level_id']) :
                          echo $lev['level_desc'];
                        endif;
                      endforeach;
                      ?>
                    </td>
                    <?php if ($table_content['pengguna_dashboard'] == 1) : ?>
                      <td>Admin Dashboard</td>
                    <?php else : ?>
                      <td>POS</td>
                    <?php endif; ?>
                    <td><?= $table_content['pengguna_email']; ?></td>
                    <th><?= $table_content['pengguna_nohp']; ?></th>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal" data-target="#modal_edit_pengguna<?= $table_content['pengguna_id']; ?>"><i class="fa fa-pencil"></i></a>
                      <a href="<?= base_url("admin/pengguna/reset_password/${pengguna_id}"); ?>" class="btn btn-icon-toggle btn-raised" title="Reset Password"><i class="fa fa-refresh"></i></a>
                      <a href="<?= base_url("admin/pengguna/hapus_pengguna/${pengguna_id}"); ?>" onclick="return confirm('Apakah anda yakin menghapus data <?= $table_content['pengguna_nama']; ?>?')" class="btn btn-icon-toggle text-danger btn-raised" title="Delete row"><i class="fa fa-trash-o"></i></a>
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

<!-- ============ MODAL ADD PENGGUNA =============== -->
<div class="modal fade" id="modal_add_pengguna" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Pengguna</h3>
      </div>
      <form class="form-horizontal" role="form" method="post" action="<?= base_url("admin/pengguna/simpan_pengguna/${outlet_id}"); ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <input type="text" name="pengguna_nama" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Jenis Kelamin <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <select name="pengguna_jenkel" class="form-control" required>
                <option value="">&nbsp;</option>
                <option value="L">Laki-Laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Username <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <input type="text" name="pengguna_username" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Jabatan <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <select name="pengguna_level" class="form-control" required>
                <option value="">&nbsp;</option>
                <?php
                foreach ($level as $table_content) : ?>
                  <option value="<?= $table_content['level_id']; ?>"> <?= $table_content['level_desc']; ?></option>
                <?php endforeach;

                foreach ($level_pos as $table_content) : ?>
                  <option value="<?= $table_content['level_id']; ?>"> <?= $table_content['level_desc']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Dashboard <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <select name="pengguna_dashboard" class="form-control pengguna_dashboard" required>
                <option value="">&nbsp;</option>
                <option value="1">Admin Dashboard</option>
                <option value="2">POS</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Password <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <input type="password" name="pengguna_password" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Ulangi Password <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <input type="password" name="pengguna_password_confirmation" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Email <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <input type="email" name="pengguna_email" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Kontak Person <sup style="color: red;">&#10038<sup></label>
            <div class="col-sm-8">
              <input type="text" name="pengguna_nohp" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Photo</label>
            <div class="col-sm-8">
              <input type="file" name="filefoto" class="form-control">
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
  <div class="modal fade" id="modal_edit_pengguna<?= $table_content['pengguna_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Edit Pengguna</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url() . 'admin/pengguna/simpan_pengguna/' . $outlet_id ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="hidden" name="pengguna_id" value="<?= $table_content['pengguna_id']; ?>">
                <input type="text" name="pengguna_nama" value="<?= $table_content['pengguna_nama']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Jenis Kelamin <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <select name="pengguna_jenkel" class="form-control" required>
                  <option value="">&nbsp;</option>
                  <?php if ($table_content['pengguna_jenkel'] == 'L') : ?>
                    <option value="L" selected>Laki-Laki</option>
                    <option value="P">Perempuan</option>
                  <?php else : ?>
                    <option value="L">Laki-Laki</option>
                    <option value="P" selected>Perempuan</option>
                  <?php endif; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Username <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="text" name="pengguna_username" value="<?= $table_content['pengguna_username']; ?>" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Jabatan <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <select name="pengguna_level" class="form-control" required>
                  <option value="">&nbsp;</option>
                  <?php
                  foreach ($level as $table_content_level) :
                    $k_id = $table_content_level['level_id'];
                    $k_nama = $table_content_level['level_desc'];
                    if ($table_content['pengguna_level'] == $k_id)
                      echo "<option value='$k_id' selected>$k_nama</option>";
                    else
                      echo "<option value='$k_id'>$k_nama</option>";
                  endforeach;
                  foreach ($level_pos as $table_content_level) :
                    $k_id = $table_content_level['level_id'];
                    $k_nama = $table_content_level['level_desc'];
                    if ($table_content['pengguna_level'] == $k_id)
                      echo "<option value='$k_id' selected>$k_nama</option>";
                    else
                      echo "<option value='$k_id'>$k_nama</option>";
                  endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Dashboard <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <select name="pengguna_dashboard" class="form-control pengguna_dashboard" required>
                  <option value="">&nbsp;</option>
                  <?php if ($table_content['pengguna_dashboard'] == 1) : ?>
                    <?php $outlet_display = "none" ?>
                    <option value="1" selected>Dashboard Admin</option>
                    <option value="2">POS</option>
                  <?php else : ?>
                    <?php $outlet_display = "block" ?>
                    <option value="1">Dashboard Admin</option>
                    <option value="2" selected>POS</option>
                  <?php endif; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Password <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="password" name="pengguna_password" class="form-control">
                <small style="color: #8B0000;">jika tidak di isi maka akan pakai password sebelumnya</small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Ulangi Password <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="password" name="pengguna_password_confirmation" class="form-control">
                <small style="color: #8B0000;">jika tidak di isi maka akan pakai password sebelumnya</small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Email <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="email" name="pengguna_email" class="form-control" value="<?= $table_content['pengguna_email']; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Kontak Person <sup style="color: red;">&#10038<sup></label>
              <div class="col-sm-8">
                <input type="text" name="pengguna_nohp" class="form-control" value="<?= $table_content['pengguna_nohp']; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Photo</label>
              <div class="col-sm-8">
                <input type="file" name="filefoto" class="form-control" value="<?= $table_content['pengguna_photo']; ?>">
                <small style="color: #8B0000;">jika tidak di isi maka akan pakai photo sebelumnya</small>
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