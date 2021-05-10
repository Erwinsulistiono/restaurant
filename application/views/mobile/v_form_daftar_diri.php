<body class="full-content">

    <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
    <div id="base" style="display: none; height: 100vh; overflow-y: scroll;">

        <section class="style-default no-padding">
            <div class="card" style="min-height:95vh">
                <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                    <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left "></span> Back</button>
                    <?php if (!@$pelanggan) : ?>
                        <a href="<?= base_url("member/login_member/$outlet[out_id]"); ?>" class="btn filter btn-primary pull-right" style="margin-top:3%;">Member &nbsp;<i class="fa fa-user"></i></a>
                    <?php endif; ?>
                </div>
                <div class="container-fluid no-padding" style="min-height:90vh; padding-top:9vh">
                    <div class="card contain-xs style-transparent no-padding no-margin">
                        <div class="card-body" style="padding-top:20%;">

                            <div class="row">
                                <div class="col-xs-12">
                                    <br />
                                    <span class="text-lg text-bold text-primary">Mi Resto</span>
                                    <br /><br />
                                    <?= $this->session->flashdata('msg'); ?>
                                    <?php $disabled = '' ?>
                                    <?php $out_id = $outlet['out_id']; ?>

                                    <!-- If Store Closed -->
                                    <?php if (!(date("H:i:s") > $outlet['out_opening_hours'] && date("H:i:s") < $outlet['out_closing_hours'])) : ?>
                                        <?php $disabled = 'style="display: none;"' ?>
                                        <img src="<?= base_url('assets/img/closed.svg') ?>" style="width:100vw;height:100%;position:absolute;left: 0;top: -4vh;background-color: #ffffff;z-index: 1001;" alt="" />
                                    <?php endif; ?>

                                    <form class="form" id='customer-form' action='<?= base_url("mobile/pos/display_pos/$out_id"); ?>'>
                                        <div class="form-group floating-label">
                                            <input type="hidden" class="form-control dirty" id="plg_id" name="plg_id" value="<?= @$pelanggan['plg_id'] ?>" required>
                                            <input type="hidden" class="form-control dirty" id="plg_status" name="plg_status" value="<?= isset($pelanggan['plg_id']) ? 'member' : 'pelanggan' ?>" required>
                                            <input type="text" class="form-control dirty" id="plg_nama" name="plg_nama" value="<?= @$pelanggan['plg_nama'] ?>" required>
                                            <label for="username">Nama : <sup style="color: red;">&#10038<sup></label>
                                        </div>
                                        <div class="form-group floating-label">
                                            <input type="number" class="form-control dirty" id="plg_notelp" value="<?= @$pelanggan['plg_notelp'] ?>" name="plg_notelp">
                                            <label for="plg_notelp">No Handphone : </label>
                                        </div>
                                        <div class="form-group floating-label">

                                            <?php (isset($trx_id)) ? $readonly = 'disabled' : $readonly = '' ?>
                                            <?php if (isset($trx_id)) : ?>
                                                <input type="hidden" class="form-control dirty" id="plg_notelp" name="tipe_transaksi" value="<?= $trx_id ?>" required>
                                            <?php endif; ?>
                                            <select id="selectMethodOfTable" name="tipe_transaksi" class="form-control dirty" <?= $readonly ?> required>
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($method_of_order as $row) : ?>
                                                    <?php ((isset($trx_id)) && ($row['tipe_transaksi_id'] == $trx_id) ? $selected = 'selected' : $selected = ''); ?>
                                                    <option value="<?= $row['tipe_transaksi_id']; ?>" <?= $selected ?>><?= $row['tipe_transaksi_nama']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="selectMethodOfTable">Jenis Order : <sup style="color: red;">&#10038<sup></label>

                                        </div>
                                        <div class="form-group floating-label dirty" id="selectInput">

                                            <?php if (isset($trx_id)) : ?>
                                                <?php ($trx_id) ? $readonly = 'disabled' : $readonly = '' ?>

                                                <?php if (isset($meja_id) && $trx_id == 1) : ?>
                                                    <input type="hidden" class="form-control dirty" id="plg_notelp" name="meja_pelanggan" value="<?= $meja_id ?>">
                                                    <select name="meja_pelanggan" id="plg_meja" class="form-control dirty" <?= $readonly ?>>
                                                        <option value="">&nbsp;</option>
                                                        <?php foreach ($data as $row) : ?>
                                                            <?php ($row['meja_id'] == $meja_id) ? $selectTable = 'selected' : $selectTable = '' ?>
                                                            <option value="<?= $row['meja_id'] ?>" <?= $selectTable ?>><?= $row['meja_nama'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label for="selectInput">Pilih Meja : <sup style="color: red;">&#10038<sup></label>
                                                <?php endif; ?>

                                                <?php if ($trx_id == 3) : ?>
                                                    <!-- mobil -->
                                                    <input type="text" class="form-control dirty" id="plg_platno" name="plg_platno" placeholder="eg B 1234 AA" value="" required>
                                                    <label>Nomor Plat Kendaraan : <sup style="color: red;">&#10038<sup></label>
                                                <?php endif; ?>

                                                <?php if ($trx_id == 4) : ?>
                                                    <!-- delivery -->
                                                    <input type="text" class="form-control dirty" id="plg_alamat" name="plg_alamat" value="<?= @$pelanggan['plg_nama'] ?>" required>
                                                    <label>alamat pengiriman : <sup style="color: red;">&#10038<sup></label>;
                                                <?php endif; ?>

                                            <?php endif; ?>

                                        </div>
                                        <?php if (!isset($meja_id) && isset($trx_id) != 2) : ?>
                                            <div class="form-group" id="notesPelanggan">
                                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="&#10;lokasi parkir eg: lt2 No.2B &#10;patokan alamat kirim dll"></textarea>
                                                <label for="notes">Notes</label>
                                            </div>
                                        <?php endif; ?>

                                        <br />
                                        <button class="btn btn-block btn-primary btn-raised" style="position:fixed; bottom:0; left:0" type="submit"><span class="fa fa-receipt"></span> Order</button>
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

        document.querySelector('#notesPelanggan').style.display = (dataPelanggan ? 'none' : '');
        document.querySelector('#selectMethodOfTable').addEventListener('change', (e) => {
            printLayout(e);
        })

        let printLayout = (e) => {
            let methodType = e.target.value;
            let div = '';
            let meja = JSON.parse('<?= json_encode($data); ?>');

            if (methodType == 1) {
                document.querySelector('#plg_notelp').removeAttribute('required');
                document.querySelector('#notesPelanggan').removeAttribute('required');
                let readOnly = (dataPelanggan) ? 'required disabled' : '';

                div =
                    `<select name="meja_pelanggan" id="plg_meja" class="form-control dirty" ${readOnly}>
                    <option value="">&nbsp;</option>`;

                if (dataPelanggan) {
                    meja.forEach(m => {
                        if (m.meja_id == Number(dataPelanggan.plg_meja)) {
                            div += `<option value="${m.meja_id}" selected>${m.meja_nama}</option>`;
                        }
                    })
                } else {
                    meja.forEach(m => {
                        div += (m.meja_pelanggan == 0) ? `<option value="${m.meja_id}">${m.meja_nama}</option>` : '';
                    })
                }

                div += `</select>
                <label for="selectInput">Pilih Meja : <sup style="color: red;">&#10038<sup></label>`;
            }


            if (methodType == 3) {
                document.querySelector('#plg_notelp').removeAttribute('required');
                document.querySelector('#notesPelanggan').setAttribute('required', 'required');
                if (dataPelanggan) {
                    div =
                        `<input type="text" class="form-control dirty" id="plg_platno" name="plg_platno" 
                        value="${(dataPelanggan.plg_platno) ? dataPelanggan.plg_platno : ''}" required>
                        <label >Nomor Plat Kendaraan : <sup style="color: red;">&#10038<sup></label>`;
                } else {
                    div =
                        `<input type="text" class="form-control dirty" id="plg_platno" name="plg_platno" 
                        placeholder="eg B 1234 AA" value="" required>
                        <label >Nomor Plat Kendaraan : <sup style="color: red;">&#10038<sup></label>`;
                }
            }

            if (methodType == 4) {
                document.querySelector('#plg_notelp').setAttribute('required', 'required');
                document.querySelector('#notesPelanggan').setAttribute('required', 'required');
                if (dataPelanggan) {
                    div =
                        `<input type="text" class="form-control dirty" id="plg_alamat" name="plg_alamat" 
                        value="${(dataPelanggan.plg_alamat) ? dataPelanggan.plg_alamat : ''}" required>
                        <label >alamat pengiriman : <sup style="color: red;">&#10038<sup></label>`;

                } else {
                    div =
                        `<input type="text" class="form-control dirty" id="plg_alamat" name="plg_alamat" 
                        value="<?= @$pelanggan['plg_alamat'] ?>" required>
                        <label >alamat pengiriman : <sup style="color: red;">&#10038<sup></label>`;
                }
            }

            if (methodType == 2) {
                document.querySelector('#plg_notelp').setAttribute('required', 'required');
            }

            document.querySelector('#selectInput').innerHTML = div
        }

        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.querySelector('#loading-screen').style.display = 'none';
                document.querySelector('#base').style.display = 'block';
                printLayout();
            }, 3000)
        });
    </script>

    <script>
        document.querySelector('#customer-form').addEventListener('submit', (e) => {
            e.preventDefault();

            const outlet = '<?= ($outlet['out_id']) ?>';
            const data = () => {
                let obj = {};
                const formData = new FormData(e.target);
                for (var key of formData.keys()) {
                    obj[key] = formData.get(key);
                }
                return obj;
            };
            sessionStorage.setItem('order', JSON.stringify(data()));
            sessionStorage.setItem('db', JSON.stringify(outlet));

            window.location.assign(e.target.action);
        })
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelector('#loading-screen').style.display = 'none';
                document.querySelector('#base').style.display = 'block';
                if (dataPelanggan) {
                    (dataPelanggan.plg_nama) &&
                    (document.querySelector('#plg_nama').value = dataPelanggan.plg_nama);
                    (dataPelanggan.plg_notelp) &&
                    (document.querySelector('#plg_notelp').value = dataPelanggan.plg_notelp);
                }
            }, 1000)
        })
    </script>
</body>

</html>