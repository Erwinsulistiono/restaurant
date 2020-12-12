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
                </div>
                <div class="container-fluid no-padding" style="min-height:90vh; padding-top:9vh">
                    <div class="card contain-xs style-transparent no-padding no-margin">
                        <div class="card-body" style="padding-top:20%;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <br />
                                    <span class="text-lg text-bold text-primary">Masukan data order : </span>
                                    <br /><br />
                                    <?= $this->session->flashdata('msg'); ?>
                                    <form class="form" id='customer-form' action='<?= base_url('mobile/order/order_detail/') . $outlet ?>' method="post">
                                        <div class="form-group floating-label">
                                            <select id="selectMethodOfTable" name="tipe_transaksi" class="form-control dirty">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($method_of_order as $row) : ?>
                                                    <option value="<?= $row['tipe_transaksi_id']; ?>"><?= $row['tipe_transaksi_nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="selectMethodOfTable">Jenis Order : *</label>
                                        </div>
                                        <div class="form-group floating-label dirty" id="selectInput"></div>
                                        <div class="form-group floating-label dirty" id="plg_notelp"></div>
                                        <br />
                                        <div class="section-action">
                                            <button class="btn btn-block btn-primary btn-raised" type="submit"><span class="fa fa-receipt"></span> Order</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        let dataPelanggan = JSON.parse(sessionStorage.getItem('dataPelanggan'));
        console.log('cek order');
        console.log('<?= $authPelanggan ?>');
        console.log('<?= $dataPost ?>');

        document.querySelector('#selectMethodOfTable').addEventListener('change', (e) => {
            let methodType = e.target.value;
            let div = ''
            let divTelp = ''
            let meja = JSON.parse('<?= json_encode($data); ?>');

            if (methodType == 1) {
                div +=
                    `<select name="meja_pelanggan" id="plg_meja" class="form-control dirty">
                    <option value="">&nbsp;</option>`;
                meja.forEach(m => {
                    div += (m.meja_pelanggan == 0) ? `<option value="${m.meja_id}">${m.meja_nama}</option>` : '';
                })
                div += `</select>
                <label for="selectInput">Pilih Meja : *</label>`;
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_nama" name="plg_nama">
                    <label for="plg_nama">Nama : *</label>`;
            }

            if (methodType == 2) {
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_notelp" name="plg_notelp">
                    <label for="plg_notelp">No Telp : *</label>`;
            }

            if (methodType == 3) {
                div +=
                    `<input type="text" class="form-control dirty" id="plg_platno" name="plg_platno" required>
                    <label >Nomor Plat Kendaraan : *</label>`;
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_notelp" name="plg_notelp">
                    <label for="plg_notelp">No Telp : *</label>`;
            }

            if (methodType == 4) {
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_notelp" name="plg_notelp">
                    <label for="plg_notelp">No Telp : *</label>`;
            }

            document.querySelector('#selectInput').innerHTML = div
            document.querySelector('#plg_notelp').innerHTML = divTelp
        })

        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.querySelector('#loading-screen').style.display = 'none';
                document.querySelector('#base').style.display = 'block';
            }, 3000)
        });
    </script>
</body>

</html>