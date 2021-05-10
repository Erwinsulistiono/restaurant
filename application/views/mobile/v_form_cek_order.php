<body class="full-content">

    <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
    <div id="base" style="display: none; height: 100vh; overflow-y: scroll;">

        <section class="style-default no-padding">
            <div class="card" style="min-height:100vh">
                <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                    <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left "></span> Back</button>
                </div>
                <div class="container-fluid no-padding" style="min-height:80vh; padding-top:9vh">
                    <div class="card contain-xs style-transparent no-padding no-margin">
                        <div class="card-body" style="padding-top:20%;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <br />
                                    <span class="text-lg text-bold text-primary">Masukan Data Order : </span>
                                    <br /><br />
                                    <?= $this->session->flashdata('msg'); ?>
                                    <form class="form" id='customer-form' action='<?= base_url("mobile/order/order_detail/${outlet}"); ?>' method="post">
                                        <div class="form-group floating-label">
                                            <select id="selectMethodOfTable" name="tipe_transaksi" class="form-control dirty">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($method_of_order as $row) : ?>
                                                    <option value="<?= $row['tipe_transaksi_id']; ?>"><?= $row['tipe_transaksi_nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="selectMethodOfTable">Jenis Order : <sup style="color: red;">&#10038<sup></label>
                                        </div>
                                        <div class="form-group floating-label dirty" id="selectInput"></div>
                                        <div class="form-group floating-label dirty" id="plg_notelp"></div>
                                        <br />
                                        <div class="section-action">
                                            <button class="btn btn-block btn-primary btn-raised" type="submit"><span class="fa fa-receipt"></span> Cek Order</button>
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
                    div +=
                        `<option value="${m.meja_id}">${m.meja_nama}</option>`;
                })
                div +=
                    `</select>
                    <label for="selectInput">Pilih Meja : <sup style="color: red;">&#10038<sup></label>`;
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_nama" name="plg_nama">
                    <label for="plg_nama">Nama : <sup style="color: red;">&#10038<sup></label>`;
            }

            if (methodType == 2) {
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_notelp" name="plg_notelp">
                    <label for="plg_notelp">No Telp : <sup style="color: red;">&#10038<sup></label>`;
            }

            if (methodType == 3) {
                div +=
                    `<input type="text" class="form-control dirty" id="plg_platno" name="plg_platno" required>
                    <label >Nomor Plat Kendaraan : <sup style="color: red;">&#10038<sup></label>`;
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_notelp" name="plg_notelp">
                    <label for="plg_notelp">No Telp : <sup style="color: red;">&#10038<sup></label>`;
            }

            if (methodType == 4) {
                divTelp +=
                    `<input type="text" class="form-control dirty" id="plg_notelp" name="plg_notelp">
                    <label for="plg_notelp">No Telp : <sup style="color: red;">&#10038<sup></label>`;
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