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
        <div class="card" style="min-height:100vh">
            <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left "></span> Back</button>
            </div>
            <!--end .card-head -->
            <div class="card-body" style="min-height:89vh; padding-top:9vh">
                <div class="col-xs-12">
                    <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                    <div class="container" style="transform: translateY(10vh)">
                        <img class="img-circle img-responsive pull-left" src="<?= base_url('assets/img/outlet.svg') ?>" alt="" />
                        <button onclick="redirectPage()" class="btn btn-block btn-primary btn-raised">Order</button>
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
                        <a onclick="redirectCheckOrder()" href="<?= base_url('mobile/order/view_order/' . $outlet) ?>" id="view_order" class="btn btn-flat btn-block btn-primary btn-raised" type="submit" style="border:solid; border-width:1px; border-color:#08867e">View Order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- <script src="?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<script src="?= base_url('assets/js/source/App.js'); ?>"></script>
<script src="?= base_url('assets/js/source/AppNavSearch.js'); ?>"></script> -->
<!-- <script src="<= base_url('assets/js/md5.min.js') ?>"></script> -->
<script>
    dataPelanggan = (JSON.parse(sessionStorage.getItem('dataPelanggan')));
    let redirectPage = () => {
        if (!dataPelanggan) {
            return document.location = '<?= base_url('mobile/order/register/' . $outlet) ?>';
        }
        redirectPageIfUserSessionValid();
    }

    const redirectPageIfUserSessionValid = async () => {
        const response = await fetch('<?= base_url('mobile/order/is_user_session_valid') ?>', {
            method: 'POST',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataPelanggan),
        })
        const isValid = await response.json();
        if (isValid) {
            document.location = '<?= base_url('mobile/pos/display_pos/' . $outlet) ?>';
        } else {
            sessionStorage.removeItem('dataPelanggan');
            document.location = '<?= base_url('mobile/order/register/' . $outlet) ?>';
        }
    }

    let redirectCheckOrder = () => {
        if (!dataPelanggan) {
            return document.location = '<?= base_url('mobile/order/view_order/' . $outlet) ?>';
        }
        redirectCheckOrderIfUserSessionValid();
    }

    const redirectCheckOrderIfUserSessionValid = async () => {
        const response = await fetch('<?= base_url('mobile/order/is_user_session_valid') ?>', {
            method: 'POST',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataPelanggan),
        })
        const isValid = await response.json();
        if (isValid) {
            document.location = '<?= base_url('mobile/order/view_order/' . $outlet . '/') ?>' + dataPelanggan.hashed + '/' + dataPelanggan.plg_id;
        } else {
            sessionStorage.removeItem('dataPelanggan');
            document.location = '<?= base_url('mobile/order/view_order/' . $outlet) ?>';
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelector('#loading-screen').style.display = 'none';
            document.querySelector('#base').style.display = 'block';
        }, 1000)
        setTimeout(() => {
            document.querySelector('.msg').style.display = 'none'
        }, 6000)
    })
</script>
</body>

</html>