<!DOCTYPE html>
<html lang="en">

<head>
  <title>Mi Resto</title>

  <!-- BEGIN META -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url() . 'assets/img/logo.png' ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/bootstrap.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/materialadmin.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/font-awesome/css/font-awesome.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/style-material.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/style.css' ?>" />
</head>
<img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" />
<div id="base">
  <section class="style-default no-padding">
    <div class="card">
      <div class="card-head style-primary" style="position:sticky; top:0; z-index:10001">
        <!-- <div class="tools pull-left">
          <form class="navbar-search" role="search">
            <div class="form-group">
              <input type="text" class="form-control" name="contactSearch" placeholder="Search Outlet">
            </div>
            <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
          </form>
        </div> -->
      </div>
      <!--end .card-head -->
      <div class="card-body" style="height:100vh">
        <div class="row">
          <div class="list-results">
            <?php foreach ($outlet as $o) : ?>
              <a class="text-lg text-medium" href="<?= base_url('order/outlet/' . $o['out_id']) ?>">
                <div class="col-xs-12 col-lg-6 hbox-xs" style="border-bottom:solid; border-width:1px; border-color:#b6b6b6">
                  <div class="hbox-column v-top">
                    <div class="clearfix">
                      <div class="col-lg-12 margin-bottom-lg">
                        <?= $o['out_nama'] ?>
                      </div>
                    </div>
                    <div class="clearfix opacity-75">
                      <div class="col-md-5 text-caption no-margin">
                        <?= $o['out_telp'] ?>
                      </div>
                      <div class="col-md-12 text-caption no-margin">
                        <?= $o['out_alamat'] ?>
                      </div>
                    </div>
                  </div>
                  <!--end .hbox-column -->
                  <div class="hbox-column width-3">
                    <img class="img-circle img-responsive pull-left" src="<?= base_url('assets/img/outlet.svg') ?>" alt="" />
                  </div>
                  <!--end .hbox-column -->
                </div>
                <!--end .hbox-xs -->
              </a>
            <?php endforeach; ?>
            <?php foreach ($outlet as $o) : ?>
              <a class="text-lg text-medium" href="<?= base_url('order/outlet/' . $o['out_id']) ?>">
                <div class="col-xs-12 col-lg-6 hbox-xs">
                  <div class="hbox-column v-top">
                    <div class="clearfix">
                      <div class="col-lg-12 margin-bottom-lg">
                        <?= $o['out_nama'] ?>
                      </div>
                    </div>
                    <div class="clearfix opacity-75">
                      <div class="col-md-5 text-caption no-margin">
                        <?= $o['out_telp'] ?>
                      </div>
                      <div class="col-md-12 text-caption no-margin">
                        <?= $o['out_alamat'] ?>
                      </div>
                    </div>
                  </div>
                  <!--end .hbox-column -->
                  <div class="hbox-column width-3">
                    <img class="img-circle img-responsive pull-left" src="<?= base_url('assets/img/outlet.svg') ?>" alt="" />
                  </div>
                  <!--end .hbox-column -->
                </div>
                <!--end .hbox-xs -->
              </a>
            <?php endforeach; ?>
          </div>
          <!--end .list-results -->
        </div>
      </div>
    </div>
  </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/AppNavSearch.js'); ?>"></script>
<script>
  $(() => {
    setTimeout(() => {
      document.querySelector('#loading-screen').style.display = 'none';
      document.querySelector('#base').style.display = 'block';
    }, 1000)
  })
</script>
</body>

</html>