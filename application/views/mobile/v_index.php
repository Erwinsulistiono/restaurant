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
            </div>
            <!--end .card-head -->
            <div class="card-body" style="height:89vh">
                <div class="col-xs-12">
                    <?= $this->session->flashdata('msg'); ?>
                    <div class="container" style="transform: translateY(10vh)">
                        <img class="img-circle img-responsive pull-left" src="<?= base_url('assets/img/outlet.svg') ?>" alt="" />
                        <button onclick="document.location='<?= base_url('mobile/order/register/' . $outlet) ?>'" class="btn btn-block btn-primary btn-raised" type="submit">Order</button>
                        <div class="row no-padding no-margin">
                            <div class="col-xs-5 no-padding no-margin">
                                <div style="border:solid; border-width:1px; border-color:#b6b6b6;margin-top:10px"></div>
                            </div>
                            <div class="col-xs-1" style="margin-left:3px;">
                                <p class="no-padding no-margin text-caption text-default-light">Or</p>
                            </div>
                            <div class="col-xs-5 no-padding no-margin">
                                <div style="border:solid; border-width:1px; border-color:#b6b6b6;margin-top:10px; transform: translatex(2vh)"></div>
                            </div>
                        </div>
                        <a href="<?= base_url('mobile/order/register/' . $outlet) ?>" class="btn btn-flat btn-block btn-primary btn-raised" type="submit" style="border:solid; border-width:1px; border-color:#08867e">View Order</a>
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