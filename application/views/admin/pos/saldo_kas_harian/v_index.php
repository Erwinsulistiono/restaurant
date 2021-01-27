<!-- BEGIN BASE-->
<div id="base">

  <!-- BEGIN OFFCANVAS LEFT -->
  <div class="offcanvas">

  </div>
  <!--end .offcanvas-->
  <!-- END OFFCANVAS LEFT -->

  <!-- BEGIN CONTENT-->
  <div id="content">
    <br />
    <section class="section-account">
      <div class="card contain-xs style-transparent">
        <div class="card-body">
          <div class="row">
            <div class="col-xs-12">
              <br />
              <span class="text-lg text-bold text-primary">Pilih Saldo Kas Harian</span>
              <br />
              <?= $this->session->flashdata('msg'); ?>
              <form class='form floating-label' action='<?= base_url('admin/pos/saldo_kas_harian'); ?>' accept-charset='utf-8' method='post'>
                <div class="row">
                  <div class="form-group">
                    <div class=" col-md-6">
                      <label>Tanggal Awal</label>
                      <input type="date" name="tgl_awal" class="form-control" value="<?= date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Tanggal Akhir</label>
                      <input type="date" name="tgl_akhir" class="form-control" value="<?= date('Y-m-d'); ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <div class="col-md-12">
                      <label>Group by</label>
                      <select name="pengguna_kasir" class="form-control" required>
                        <option value="">&nbsp;</option>
                        <option value="all">All</option>
                        <?php foreach ($pengguna as $kasir) : ?>
                          <option value="<?= $kasir['pengguna_id'] ?>"><?= $kasir['pengguna_nama'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <div class="col-md-12">
                      <label>Outlet</label>
                      <select name="outlets" class="form-control" required>
                        <option value="">&nbsp;</option>
                        <option value="all">All</option>
                        <?php foreach ($outlet as $out) : ?>
                          <option value="<?= $out['out_id'] ?>"><?= $out['out_kode']; ?> - <?= $out['out_nama'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group">
                    <div class="col-xs-6 text-left">
                    </div>
                    <!--end .col -->
                    <div class="col-xs-6 text-right">
                      <button class="btn btn-primary btn-raised" type="submit"> Pilih</button>
                    </div>
                    <!--end .col -->
                  </div>
                </div>
                <!--end .row -->
              </form>
            </div>
            <!--end .col -->

          </div>
          <!--end .row -->
        </div>
        <!--end .card-body -->
      </div>
      <!--end .card -->
    </section>
    <!-- END LOGIN SECTION -->
    <!-- END TABLE HOVER -->

  </div>
  <!--end #content-->
  <!-- END CONTENT -->

</div>
<!--end #base-->
<!-- END BASE -->