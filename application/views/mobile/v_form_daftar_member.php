<body class="full-content">

    <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
    <div id="base" style="display: none; height: 100vh; overflow-y: scroll;">

        <section class="style-default no-padding">
            <div class="card" style="min-height:100vh">
                <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                </div>
                <div class="container-fluid no-padding" style="min-height:90vh; padding-top:9vh">
                    <div class="card contain-xs style-transparent no-padding no-margin">
                        <div class="card-body" style="padding-top:20%;">
                            <!-- <h1><?= @$meja_id ?></h1> -->
                            <!-- <h1><?php var_dump(@$pelanggan) ?></h1> -->

                            <div class="row">
                                <div class="col-xs-12">
                                    <br />
                                    <span class="text-lg text-bold text-primary">F1 Restaurant</span>
                                    <br /><br />
                                    <?= $this->session->flashdata('msg'); ?>
                                    <form class="form" id="customer-form" role="form" method="post" action="<?= base_url("member/daftar_member"); ?>" enctype="multipart/form-data">
                                        <div class="form-group floating-label">
                                            <input type="text" class="form-control dirty" id="plg_nama" name="plg_nama" required>
                                            <label for="plg_nama">Nama : <sup style="color: red;">&#10038<sup></label>
                                        </div>
                                        <div class="form-group floating-label">
                                            <input type="number" class="form-control dirty" id="plg_notelp" name="plg_notelp" value="<?= $plg_notelp ? '0' . @$plg_notelp : '' ?>">
                                            <label for="plg_notelp">No Telp : <sup style="color: red;">&#10038<sup></label>
                                        </div>
                                        <div class="form-group floating-label">
                                            <input type="text" class="form-control dirty" id="plg_socmed" name="plg_socmed" value="<?= @$plg_socmed ?>">
                                            <label for="plg_socmed">Social Media : <sup style="color: red;">&#10038<sup></label>
                                        </div>
                                        <div class="form-group floating-label">
                                            <input type="text" class="form-control dirty" id="plg_email" name="plg_email">
                                            <label for="plg_email">E-Mail : </label>
                                        </div>
                                        <div class="form-group floating-label">
                                            <textarea name="plg_alamat" id="plg_alamat" class="form-control" rows="3" placeholder="&#10;lokasi parkir eg: lt2 No.2B &#10;patokan alamat kirim dll"></textarea>
                                            <label for="plg_alamat">Alamat : </label>
                                        </div>

                                        <br />
                                        <button class="btn btn-block btn-primary btn-raised" style="position:fixed; bottom:0; left:0" type="submit">Daftar Member</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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