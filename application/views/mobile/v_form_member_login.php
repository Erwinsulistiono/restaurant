<body class="full-content">

    <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
    <div id="base" style="display: none; height: 100vh; overflow-y: scroll;">

        <section class="style-default no-padding">
            <div class="card no-margin" style="min-height:100vh">
                <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                </div>
                <div class="container-fluid no-padding" style="min-height:90vh; padding-top:9vh">
                    <div class="card contain-xs style-transparent no-padding no-margin">
                        <div class="card-body" style="padding-top:20%;">
                            <!-- <h1><?= @$meja_id ?></h1> -->

                            <div class="row">
                                <div class="col-xs-12">
                                    <br />
                                    <span class="text-lg text-bold text-primary">F1 Restaurant</span>
                                    <br /><br /><br />
                                    <?= $this->session->flashdata('msg'); ?>

                                    <form class="form" id="customer-form" role="form" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group floating-label" style="margin-bottom: 10px">
                                            <div class="row no-padding" style="margin-top: 10px">
                                                <div class="col-xs-2 col-sm-2 col-md-2 text-center">
                                                    <h5 class="card-body no-margin small-padding text-default-light" style="border: solid; border-width: thin; border-radius: 8px">+62</h5>
                                                </div>
                                                <div class="col-xs-9 col-sm-9 col-md-9 no-padding no-margin">
                                                    <input type="text" class="form-control dirty" id="plg_notelp" name="plg_notelp" placeholder="81287392684" required>
                                                </div>
                                            </div>
                                            <label for="plg_notelp">Nomor Telp : <sup style="color: red;">&#10038<sup><br /></label>
                                        </div>
                                        <div class="form-group floating-label" style="margin-bottom: 10px">
                                            <div class="row no-padding" style="margin-top: 10px">
                                                <div class="col-xs-2 col-sm-2 col-md-2 text-center">
                                                    <h4 class="card-body no-margin small-padding text-default-light" style="border: solid; border-width: thin; border-radius: 8px">@</h4>
                                                </div>
                                                <div class="col-xs-9 col-sm-9 col-md-9 no-padding no-margin">
                                                    <input type="text" class="form-control dirty" id="plg_socmed" name="plg_socmed" placeholder="john_doe" required>
                                                </div>
                                            </div>
                                            <label for="plg_socmed">Social Media : <sup style="color: red;">&#10038<sup><br /></label>
                                        </div>

                                        <div class="col-xs-12">
                                            <div class="container" style="transform: translateY(10vh)">
                                                <a href="#" class="btn btn-block btn-primary btn-raised" id="daftar">Daftar</a>
                                                <div class="row no-padding no-margin">
                                                    <div class="col-xs-5 col-sm-5 col-md-5 no-padding no-margin">
                                                        <div style="border:solid; border-width:1px; border-color:#b6b6b6;margin-top:10px"></div>
                                                    </div>
                                                    <div class="col-xs-1 col-sm-1 col-md-1 " style="margin-left:3px;">
                                                        <p class="no-padding no-margin text-caption text-default-light">Or</p>
                                                    </div>
                                                    <div class="col-xs-5 col-sm-5 col-md-5 no-padding no-margin">
                                                        <div style="border:solid; border-width:1px; border-color:#b6b6b6;margin-top:10px; transform: translatex(2vh)"></div>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-flat btn-block btn-primary btn-raised" id="login" style="border:solid; border-width:1px; border-color:#08867e">Login Member</a>
                                            </div>
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

    <script>
        let target = document.querySelector('#customer-form');
        let btnDaftar = document.querySelector('#daftar');
        let btnLogin = document.querySelector('#login');

        btnDaftar.addEventListener('click', () => {
            target.action = "<?= base_url("member/"); ?>";
            target.submit();
        })

        btnLogin.addEventListener('click', () => {
            target.action = "<?= base_url("member/auth/$out_id"); ?>";
            target.submit();
        })
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