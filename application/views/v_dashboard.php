<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mi Resto</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, user-scalable=no, maximum-scale=0.8, initial-scale=1.0">

    <!-- END META -->
    <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png') ?>">
    <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/materialadmin.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style-material.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>

<body class="full-content">

    <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
    <div id="base" style="display: none; height: 100vh;">

        <section class="style-default no-padding">
            <div class="card" style="min-height:100vh">
                <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                    <!-- <button onclick="window.history.back()" class="btn" style="color: #ffffff; background: #0aa89e"><span class="fa fa-chevron-left "></span> Back</button> -->
                </div>
                <!--end .card-head -->
                <div class="card-body no-padding" style="min-height:89vh; padding-top:2vh;">
                    <div class="col-xs-12 no-padding">
                        <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                        <div style="transform: translateY(6vh)">
                            <!-- <img class="img-circle img-responsive pull-left" src="<?= base_url('assets/img/outlet.svg') ?>" alt="" /> -->

                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    foreach ($galeri as $key => $value) :
                                        $galeri_gambar = $value['galeri_gambar'];
                                        $active = ($key == 0) ? 'active' : '';
                                    ?>
                                        <div class="carousel-item <?= $active ?>">
                                            <img class="d-block img-responsive pull-left" style="height: 95vh; width: 100vw;" src="<?= base_url("assets/galeries/$galeri_gambar") ?>" alt="">
                                        </div>';
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                            <button onclick="redirectPage()" class="btn btn-raised" style="margin-left: 10%; width: 80%; transform: translateY(-21vh); color: #ffffff; background: #08867e">Order</button>
                            <a onclick="redirectCheckOrder()" id="view_order" class="btn btn-flat btn-block btn-primary btn-raised" type="submit" style="background: #ffffff; color: #08867e; margin-left: 10%; width: 80%; transform: translateY(-19vh); border:solid; border-width:1px; border-color:#08867e">View Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.js'); ?>"></script>

    <script>
        dataPelanggan = (JSON.parse(sessionStorage.getItem('dataPelanggan')));
        outlet = (JSON.parse(sessionStorage.getItem('db')));
        let redirectPage = () => {
            if (!dataPelanggan) {
                return document.location = '<?= base_url("order/outlet/") ?>';
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
                document.location = '<?= base_url("mobile/pos/display_pos/") ?>' + outlet;
            } else {
                sessionStorage.removeItem('dataPelanggan');
                document.location = '<?= base_url("mobile/order/register/") ?>' + outlet;
            }
        }

        let redirectCheckOrder = () => {
            if (!dataPelanggan) {
                return document.location = '<?= base_url("mobile/order/view_order/") ?>' + outlet;
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
                document.location = '<?= base_url("mobile/order/view_order/") ?>' + outlet + '/' + dataPelanggan.hashed + '/' + dataPelanggan.plg_id;
            } else {
                sessionStorage.removeItem('dataPelanggan');
                document.location = '<?= base_url("mobile/order/view_order/") ?>' + outlet;
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