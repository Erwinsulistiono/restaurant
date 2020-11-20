<!-- BEGIN BASE-->
<div id="base">
  <div class="offcanvas">
  </div>
  <div id="content">
    <br />
    <section class="section-account">
      <div class="card contain-xs style-transparent">
        <div class="card-body">
          <div class="row">
            <div class="col-xs-12">
              <br />
              <span class="text-lg text-bold text-primary">Pilih Tanggal</span>
              <br />
              <form class='form floating-label' action='<?= base_url('pos/laporan/filter') ?>' accept-charset='utf-8'
                method='post'>
                <div class=" col-md-5">
                  <label>Tanggal Awal</label>
                  <input type="date" name="tgl_awal" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="col-md-5">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="tgl_akhir" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="row">
                  <div class="col-xs-2 text-left">
                  </div>
                  <div class="col-xs-2 text-right">
                    <button class="btn btn-primary btn-raised" type="submit"><span class="fa fa-calendar"></span>
                      Pilih</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>