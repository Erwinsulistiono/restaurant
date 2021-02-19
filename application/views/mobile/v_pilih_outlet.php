<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <title>Mi Resto</title>

  BEGIN META
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  END META
  <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png'); ?>">
  BEGIN STYLESHEETS
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/materialadmin.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style-material.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" />
</head> -->

<img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
<div id="base" style="display: none; height: 100vh; overflow-y: auto;">
  <section class="style-default no-padding">
    <div class="card" style="min-height:100vh">
      <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
      </div>
      <!--end .card-head -->
      <div class="card-body" style="min-height:89vh; padding-top:9vh;">
        <div class="row">
          <div class="list-results">
            <?php foreach ($outlet as $o) : ?>
              <?php $closed = " - (closed)" ?>
              <?php $disabled = 'style="pointer-events: none; opacity: 0.6"' ?>
              <?php if (date("H:i:s") > $o['out_opening_hours'] && date("H:i:s") < $o['out_closing_hours']) : ?>
                <?php $out_id = $o['out_id']; ?>
                <?php $closed = "" ?>
                <?php $disabled = "" ?>
              <?php endif ?>
              <a class="text-lg text-medium" href="<?= base_url("order/outlet/$out_id"); ?>" <?= $disabled ?>>
                <div class="col-xs-12 col-lg-6 hbox-xs" style="border-bottom:solid; border-width:1px; border-color:#b6b6b6">
                  <div class="hbox-column v-top">
                    <div class="clearfix">
                      <div class="col-lg-12 margin-bottom-lg">
                        <?= $o['out_nama'] . $closed ?>
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
<script src="<?= base_url('assets/js/source/App.js'); ?>"></script>
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