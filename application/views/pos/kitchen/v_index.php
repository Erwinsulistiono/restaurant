<div id="base" style="margin:0px;">
  <div id="content">
    <section>
      <div class="section-header  ">
        <h2><span class="fa fa-cutlery"></span>&nbsp; Kitchen </h2>
      </div>
      <section class="style-default no-padding no-margin">
        <div class="container-fluid no-padding no-margin">

          <div class="row">
            <?php foreach ($kitchen as $k) : ?>
              <?php $random = rand(0, 3); ?>
              <?php ($random == 0) && ($color = "alert-info"); ?>
              <?php ($random == 1) && ($color = "alert-warning"); ?>
              <?php ($random == 2) && ($color = "alert-danger"); ?>
              <?php ($random == 3) && ($color = "alert-success"); ?>
              <!-- BEGIN ALERT - REVENUE -->
              <a href="<?= base_url('pos/kitchen/view_kitchen/') . $k['kitchen_id'] ?>">
                <div class="col-md-3 col-sm-6">
                  <div class="card">
                    <div class="card-body no-padding">
                      <div class="alert alert-callout <?= $color ?> no-margin">
                        <h1 class="pull-right text-success"><i class="fa fa-cutlery"></i></h1>
                        <strong class="text-xl"><?= $k["kitchen_nama"] ?></strong><br />
                        <span class="opacity-50"></span>
                        <div class="stick-bottom-left-right">
                          <div class="height-2 sparkline-revenue" data-line-color="#bdc1c1"></div>
                        </div>
                      </div>
                    </div>
                    <!--end .card-body -->
                  </div>
                  <!--end .card -->
                </div>
              </a>
              <!--end .col -->
              <!-- END ALERT - REVENUE -->
            <?php endforeach; ?>
            <!-- BEGIN ALERT - VISITS -->


          </div>
        </div>
      </section>
    </section>