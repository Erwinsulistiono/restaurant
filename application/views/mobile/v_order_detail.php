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

<body class="full-content">

    <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" />
    <div id="base">

        <section class="style-default no-padding">
            <div class="card" style="min-height:100vh">
                <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                    <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left "></span> Back</button>
                    <div class="pull-right">
                        <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-refresh" aria-hidden="true"></span> Refresh</button>
                    </div>
                </div>
                <div class="container-fluid no-padding" style="min-height:90vh; padding-top:8vh">
                    <div class="card contain-xs style-transparent no-padding no-margin">
                        <div class="card-body" style="padding-top:15%;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php if ($order_pelanggan) {
                                        $order_received = "circ-xl style-primary";
                                        $icon_received = "fa fa-check";
                                    } else {
                                        $order_received = "";
                                        $icon_received = "";
                                    }
                                    ?>
                                    <?php
                                    $order_cooked = "circ-xl style-primary";
                                    $icon_cooked = "fa fa-check";
                                    foreach ($order_pelanggan as $o) {
                                        if ($o['order_kitchen_flg'] == 'N') {
                                            $order_cooked = "";
                                            $icon_cooked = "";
                                        }
                                    }
                                    ?>
                                    <?php
                                    $order_delivered = "circ-xl style-primary";
                                    $icon_delivered = "fa fa-check";
                                    foreach ($order_pelanggan as $o) {
                                        if ($o['order_waitress_flg'] == 'N') {
                                            $order_delivered = "";
                                            $icon_delivered = "";
                                        }
                                    }
                                    ?>
                                    <?php
                                    $order_finished = "circ-xl style-primary";
                                    $icon_finished = "fa fa-check";
                                    foreach ($order_pelanggan as $o) {
                                        if ($o['order_waitress_flg'] == 'N') {
                                            $order_finished = "";
                                            $icon_finished = "";
                                        }
                                    }
                                    ?>
                                    <ul class="timeline collapse-lg timeline-hairline">
                                        <li id="order-received">
                                            <div class="timeline-circ <?= $order_received ?>" style="top:20px"><i class="<?= $icon_received ?>"></i></div>
                                            <div class="timeline-entry" style="padding: 12px">
                                                <div class="card style-default-bright">
                                                    <div class="card-body">
                                                        <span class="text-large text-lg"><a class="text-primary" href="<?= base_url('assets/img/credit_card.svg') ?>">Received </a><span class="text-primary"></span>Order</span><br />
                                                        <?php if ($icon_received == "") : ?>
                                                            <img class="img-responsive pull-left width-1" src="<?= base_url('assets/img/order_received.svg') ?>" alt="" />
                                                            <span class="opacity-50">
                                                                <?php foreach ($order_pelanggan as $o) {
                                                                    echo "$o[menu_nama] - $o[order_qty]";
                                                                    echo "<br>";
                                                                }
                                                                ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li id="order-cooking">
                                            <div class="timeline-circ <?= $order_cooked ?>" style="top:20px"><i class="<?= $icon_cooked ?>"></i></div>
                                            <div class="timeline-entry">
                                                <div class="card style-default-bright">
                                                    <div class="card-body">
                                                        <span class="text-large text-lg"><a class="text-primary" href="<?= base_url('assets/img/credit_card.svg') ?>">Cooking </a><span class="text-primary"></span>Order</span><br />
                                                        <?php if ($icon_cooked == "") : ?>
                                                            <img class="img-responsive pull-left width-1" src="<?= base_url('assets/img/cooking.svg') ?>" alt="" />
                                                            <span class="opacity-50">
                                                                <?php foreach ($order_pelanggan as $o) {
                                                                    if ($o['order_kitchen_flg'] == 'N') {
                                                                        echo "$o[menu_nama] - $o[order_qty]";
                                                                        echo "<br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li id="order-done">
                                            <div class="timeline-circ <?= $order_delivered ?>" style="top:20px"><i class="<?= $icon_delivered ?>"></i></div>
                                            <div class="timeline-entry">
                                                <div class="card style-default-bright">
                                                    <div class="card-body">
                                                        <span class="text-large text-lg"><a class="text-primary" href="<?= base_url('assets/img/credit_card.svg') ?>">Delivering </a><span class="text-primary"></span>Order</span><br />
                                                        <?php if ($icon_delivered == "") : ?>
                                                            <img class="img-responsive pull-left width-1" src="<?= base_url('assets/img/preparing.svg') ?>" alt="" />
                                                            <span class="opacity-50">
                                                                <?php foreach ($order_pelanggan as $o) {
                                                                    if ($o['order_waitress_flg'] == 'N' && $o['order_kitchen_flg'] == 'Y') {
                                                                        echo "$o[menu_nama] - $o[order_qty]";
                                                                        echo "<br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li id="order-done">
                                            <div class="timeline-circ <?= $order_finished ?>" style="top:20px"><i class="<?= $icon_finished ?>"></i></div>
                                            <div class="timeline-entry">
                                                <div class="card style-default-bright">
                                                    <div class="card-body">
                                                        <span class="text-large text-lg"><a class="text-primary" href="<?= base_url('assets/img/credit_card.svg') ?>">Finish </a><span class="text-primary"></span>Order</span><br />
                                                        <!-- <php if ($icon_finished !== "") : ?> -->
                                                        <img class="img-responsive pull-left width-1" src="<?= base_url('assets/img/preparing.svg') ?>" alt="" />
                                                        <span class="opacity-50">
                                                            <?php foreach ($order_pelanggan as $o) {
                                                                if ($o['order_waitress_flg'] == 'Y' && $o['order_kitchen_flg'] == 'Y') {
                                                                    echo "$o[menu_nama] - $o[order_qty]";
                                                                    echo "<br>";
                                                                }
                                                            }
                                                            ?>
                                                        </span>
                                                        <!-- <php endif; ?> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card no-padding" style="bottom:-13px; position:absolute; width:-webkit-fill-available; width:100vw">
                        <div class="row">
                            <div class="col-xs-6 no-padding">
                                <a href="#" class="btn btn-block btn-default btn-raised">Bayar</a>
                            </div>
                            <div class="col-xs-6 no-padding">
                                <a href="#" class="btn btn-block btn-default-dark btn-raised">Add Voucher</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelector('#loading-screen').style.display = 'none';
                document.querySelector('#base').style.display = 'block';
            }, 1000)
        })
    </script>
</body>

</html>