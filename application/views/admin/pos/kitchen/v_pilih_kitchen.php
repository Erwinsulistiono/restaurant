<div id="base">

  <div id="content">
    <br />
    <section class="section-account">
      <div class="card contain-xs style-transparent">
        <div class="card-body">
          <div class="row">
            <div class="col-xs-12">
              <br />
              <span class="text-lg text-bold text-primary">Pilih Outlet</span>
              <br />
              <form class='form floating-label' action='<?= base_url('admin/pos/kitchen'); ?>' accept-charset='utf-8' method='post'>
                <div class="form-group">
                  <h2><select name="outlet_id" class="form-control" required>
                      <option value="">&nbsp;</option>
                      <?php foreach ($outlets as $row) : ?>
                        <option value="<?= $row['out_id']; ?>"><?= $row['out_kode']; ?> - <?= $row['out_nama']; ?></option>
                      <?php endforeach; ?>
                    </select></h2>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left">
                  </div>
                  <div class="col-xs-6 text-right">
                    <button class="btn btn-primary btn-raised" type="submit">Pilih</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END LOGIN SECTION -->
    <!-- END TABLE HOVER -->

  </div>
  <!--end #content-->
  <!-- END CONTENT -->

</div>
<!--end #base-->
<!-- END BASE -->