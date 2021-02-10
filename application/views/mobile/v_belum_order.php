<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mi Resto</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- END META -->
    <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png'); ?>">
    <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/materialadmin.css'); ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.css'); ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style-material.css'); ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" />
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
                <div class="card-body no-padding text-center" style="margin: 30% 10%">
                    <img src="<?= base_url('assets/img/PC_Kasir.svg') ?>" class="img-responsive text-center" alt="" />
                    <h3>Proses Penerimaan Kasir</h3>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        document.querySelector('#loading-screen').style.display = 'none';
        document.querySelector('#base').style.display = 'block';
    </script>
</body>

</html>