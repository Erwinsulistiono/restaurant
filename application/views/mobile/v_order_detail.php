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
                                    <!-- BEGIN FIXED TIMELINE -->
                                    <ul class="timeline collapse-lg timeline-hairline">
                                        <li id="order-received">
                                            <div class="timeline-circ circ-xl style-primary" style="top:40px"><i class="fa fa-check"></i></div>
                                            <div class="timeline-entry" style="padding: 12px">
                                                <div class="card style-default-bright">
                                                    <div class="card-body">
                                                        <img class="img-responsive pull-left width-1" src="<?= base_url('assets/img/order_received.svg') ?>" alt="" />
                                                        <span class="text-medium"><a class="text-primary" href="<?= base_url('assets/img/credit_card.svg') ?>">Received </a><span class="text-primary"></span>Order</span><br />
                                                        <span class="opacity-50">
                                                            Saturday, Oktober 18, 2014 - 17:00:00
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php if (!@$order_pelanggan) {
                                            $active_class = "circ-xl style-primary";
                                            $icon = "fa fa-check";
                                        } else {
                                            $active_class = "";
                                            $icon = "";
                                        }
                                        ?>
                                        <li id="order-payment">
                                            <div class="timeline-circ"></div>
                                            <div class="timeline-entry" style="padding: 9px">
                                                <div class="card style-default-bright">
                                                    <div class="card-body no-padding">
                                                        <img class="img-responsive pull-left width-1" src="<?= base_url('assets/img/credit_card.svg') ?>" alt="" />
                                                        <span class="text-medium"><span class="text-primary"> Payment </span>Proses</span><br />
                                                        <span class="opacity-50">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li id="order-cooking">
                                            <div class="timeline-circ"></div>
                                            <div class="timeline-entry" style="padding: 9px">
                                                <div class="card">
                                                    <div class="card-body no-padding">
                                                        <img class="img-circle img-responsive pull-left width-1" src="<?= base_url('assets/img/cooking.svg') ?>" alt="" />
                                                        <span class="text-medium"><span class="text-primary">Cooking </span>Order</span><br />
                                                        <span class="opacity-50">
                                                        </span>
                                                    </div>
                                                    <div class="card-body no-padding">
                                                        <?php if (@$order_pelanggan) {
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!--end .card -->
                                            </div>
                                            <!--end .timeline-entry -->
                                        </li>
                                        <li class="timeline-inverted" id="order-done">
                                            <div class="timeline-circ"></div>
                                            <div class="timeline-entry" style="padding: 9px">
                                                <div class="card">
                                                    <div class="card-body no-padding">
                                                        <img class="img-circle img-responsive pull-left width-1" src="<?= base_url('assets/img/preparing.svg') ?>" alt="" />
                                                        <span class="text-medium"><span class="text-primary">Done </span>Order</span><br />
                                                        <span class="opacity-50">
                                                        </span>
                                                    </div>
                                                    <!--end .card-body -->
                                                    <div class="card-body no-padding">
                                                        <?php if (@$order_pelanggan) {
                                                        }
                                                        ?>
                                                    </div>
                                                    <!--end .card-body -->
                                                </div>
                                                <!--end .card -->
                                            </div>
                                            <!--end .timeline-entry -->
                                        </li>
                                    </ul>
                                    <!-- END FIXED TIMELINE -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        console.log('order detail');


        //     // document.querySelector('#selectMethodOfTable').addEventListener('change', (e) => {
        //     //     let methodType = e.target.value;
        //     //     let div = ''
        //     //     let divTelp = ''
        //     //     // let meja = JSON.parse('<= json_encode($data); ?>');

        //     //     if (methodType == 1) {
        //     //         div +=
        //     //             `<select name="meja_pelanggan" id="plg_meja" class="form-control dirty">
        //     //             <option value="">&nbsp;</option>`;
        //     //         meja.forEach(m => {
        //     //             div += (m.meja_pelanggan == 0) ? `<option value="${m.meja_id}">${m.meja_nama}</option>` : '';
        //     //         })
        //     //         div += `</select>
        //     //         <label for="selectInput">Pilih Meja : *</label>`;
        //     //     }

        //     //     if (methodType == 2) {
        //     //         divTelp +=
        //     //             `<input type="number" class="form-control dirty" id="plg_notelp" name="plg_notelp">
        //     //             <label for="plg_notelp">No Telp : *</label>`;
        //     //     }

        //     //     if (methodType == 3) {
        //     //         div +=
        //     //             `<input type="text" class="form-control dirty" id="plg_platno" name="plg_platno" required>
        //     //             <label >Nomor Plat Kendaraan : *</label>`;
        //     //     }

        //     //     if (methodType == 4) {
        //     //         div +=
        //     //             `<input type="text" class="form-control dirty" id="plg_alamat" name="plg_alamat" required>
        //     //             <label >alamat pengiriman : *</label>`;
        //     //     }

        //     //     document.querySelector('#selectInput').innerHTML = div
        //     //     document.querySelector('#plg_notelp').innerHTML = divTelp
        //     // })

        //     document.addEventListener("DOMContentLoaded", function() {
        //         setTimeout(() => {
        //             document.querySelector('#loading-screen').style.display = 'none';
        //             document.querySelector('#base').style.display = 'block';
        //         }, 3000)
        //     });
        // 
    </script>

    <script>
        //     document.querySelector('#customer-form').addEventListener('submit', (e) => {
        //         e.preventDefault();
        //         const outlet = '<= ($outlet) ?>';
        //         const data = () => {
        //             let obj = {};
        //             const formData = new FormData(e.target);
        //             for (var key of formData.keys()) {
        //                 obj[key] = formData.get(key);
        //             }
        //             return obj;
        //         };
        //         sessionStorage.setItem('order', JSON.stringify(data()));
        //         sessionStorage.setItem('db', JSON.stringify(outlet));
        //         window.location.assign(e.target.action);
        //     })
        // 
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelector('#loading-screen').style.display = 'none';
                document.querySelector('#base').style.display = 'block';
            }, 1000)
        })
    </script>
</body>

</html>