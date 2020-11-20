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
              <span class="text-lg text-bold text-primary">Pilih Outlet</span>
              <br />
              <form class='form floating-label' action='<?= base_url('admin/restaurant/meja/'); ?>' accept-charset='utf-8'
                method='post'>
                <div class="form-group">
                  <h2><select id="selectDb" name="selectDb" class="form-control">
                      <option value="">&nbsp;</option>
                      <?php foreach ($outlet as $row) : ?>
                      <option value="<?= $row['out_id']; ?>"><?= $row['out_nama']; ?></option>
                      <?php endforeach; ?>
                    </select></h2>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left">
                  </div>
                  <!--end .col -->
                  <div class="col-xs-6 text-right">
                    <button class="btn btn-primary btn-raised" type="submit">Pilih</button>
                  </div>
                  <!--end .col -->
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