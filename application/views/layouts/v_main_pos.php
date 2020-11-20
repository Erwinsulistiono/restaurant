<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- END META -->
    <link rel="shorcut icon" href="<?= base_url() . 'assets/img/logo.png' ?>">
    <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/style-material.css' ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/bootstrap.css' ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/materialadmin.css' ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/font-awesome/css/font-awesome.css' ?>" />
</head>

<body class="menubar-hoverable header-fixed menubar-pin">
    <!-- BEGIN HEADER-->
    <header id="header">

        <div class="headerbar">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="headerbar-left">
                <ul class="header-nav header-nav-options">
                    <li class="header-nav-brand">
                        <div class="brand-holder">
                            <a href="<?= base_url('pos/dashboard') ?>">
                                <span class="text-lg text-bold text-primary nav-link">MI RESTO</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <a class="btn btn-icon-toggle menubar-toggle" id="menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="headerbar-right">
                <ul class="header-nav header-nav-profile">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                            <img src="<?= base_url() . 'assets/images/' . $this->session->userdata('pengguna_photo'); ?>" alt="" />
                            <span class="profile-info">
                                <?= $this->session->userdata('user_nama'); ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu animation-dock">
                            <li><a href="<?= base_url() . 'login/logout' ?>"><i class="fa fa-fw fa-power-off text-danger"></i>
                                    Logout</a></li>
                            <li><a href="<?= base_url() . 'admin/profile' ?>"><i class="fa fa-pencil"></i> My Profile</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>


    <div id="menubar" class="menubar-inverse animate">
        <div class="menubar-scroll-panel">
            <ul id="main-menu" class="gui-controls">
                <?php if ($sidebar['pos'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a href="<?= base_url() . 'pos/saldo' ?>" class="nav-link">
                            <div class="gui-icon"><i class="fa fa-desktop"></i></div>
                            <span class="title">POS</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($sidebar['inventory'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a href="<?= base_url() . 'pos/inventory' ?>" class="nav-link">
                            <div class="gui-icon"><i class="fa fa-cubes"></i></div>
                            <span class="title">Inventory</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($sidebar['transaction'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a href="<?= base_url() . 'pos/transaksi' ?>" class="nav-link">
                            <div class="gui-icon"><i class="fa fa-book"></i></div>
                            <span class="title">Transaction</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($sidebar['kitchen'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a href="<?= base_url() . 'pos/kitchen' ?>" class="nav-link">
                            <div class="gui-icon"><i class="fa fa-cutlery"></i></div>
                            <span class="title">Kitchen</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($sidebar['waitress'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a href="<?= base_url() . 'pos/waitress' ?>" class="nav-link" data-toggle="menubar">
                            <div class="gui-icon"><i class="fa fa-user"></i></div>
                            <span class="title">Waitress</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($sidebar['laporan'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a href="<?= base_url() . 'pos/laporan' ?>" class="nav-link" data-toggle="menubar">
                            <div class="gui-icon"><i class="fa fa-file"></i></div>
                            <span class="title">Laporan</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($sidebar['settings'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a>
                            <div class="gui-icon"><i class="fa fa-cog"></i></div>
                            <span class="title">Settings</span>
                        </a>
                        <ul>
                            <li><a href="<?= base_url(); ?>pos/settings/close_kasir" class="nav-link" data-toggle="menubar">
                                    <span class="title">Closing Kasir</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($sidebar['user'] == 'Y') : ?>
                    <li class="gui-folder">
                        <a href="<?= base_url() . 'pos/pengguna' ?>" class="nav-link" data-toggle="menubar">
                            <div class="gui-icon"><i class="fa fa-user"></i></div>
                            <span class="title">User</span>
                        </a>
                    </li>
                <?php endif; ?>


                <li class="gui-folder">
                    <a href="<?= base_url() . 'pos/about' ?>" class="nav-link" data-toggle="menubar">
                        <div class="gui-icon"><i class="fa fa-info-circle"></i></div>
                        <span class="title">Info</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>


    <div id="base">
        <?php $this->load->view($landing_page) ?>
    </div>

    <!-- BEGIN JAVASCRIPT -->
    <script src="<?= base_url() . 'assets/js/jquery-3.4.1.min.js' ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/source/App.js'); ?>"></script>
    <script src="<?= base_url('assets/js/source/AppNavigation.js'); ?>"></script>
    <script src="<?= base_url('assets/js/source/AppOffcanvas.js'); ?>"></script>
    <script src="<?= base_url('assets/js/source/AppCard.js'); ?>"></script>
    <script src="<?= base_url('assets/js/source/AppForm.js'); ?>"></script>
    <script src="<?= base_url('assets/js/source/AppNavSearch.js'); ?>"></script>
    <script src="<?= base_url('assets/js/source/AppVendor.js') ?>"></script>

    <script>
        $('.nav-link').click(function(e) {
            e.preventDefault();
            console.log('navigation clicked')
            console.log(e.target.parentElement)
            $('li.active').removeClass('active')
            $(this).closest('li.gui-folder').addClass('active')
            var url = $(this).attr('href')
            fetch_page(url)
        })

        const fetch_page = async (url, method = null, data = null) => {

            console.log('navigation clicked')
            const response = await fetch(url, {
                method: method,
                body: data,
            })
            const result = await response.json()
            $('#base').html(result)
            $('.menubar-hoverable').hasClass('menubar-visible') &&
                document.querySelector('#menubar-toggle').click()
        }
    </script>

    <script>
        let getdate = () => {
            let today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            s = (s < 10) ? `0${s}` : s;
            m = (m < 10) ? `0${m}` : m;

            $("#timer").text(`${h} : ${m} : ${s}`);
            setTimeout(function() {
                getdate()
            }, 1000);
        }
    </script>

    <script type="text/javascript">
        if (window.opener) {
            $('#menubar').remove();
            $('#header').remove();
            $('#base').addClass('no-padding');
            $('#content').addClass('no-padding');
            $('.popup-btn').attr("onClick", "close_window();return false;");
        }
    </script>

    <script type="text/javascript">
        (function($, undefined) {
            "use strict";

            $(function() {
                var $form = $(".form");
                $(document).on("keyup", "input[data-type='currency']", function(event) {

                    var selection = window.getSelection().toString();
                    if (selection !== '') {
                        return;
                    }
                    if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                        return;
                    }
                    var $this = $(this);
                    var input = $this.val();
                    var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt(input, 10) : 0;

                    $this.val(function() {
                        return (input === 0) ? "" : input.toLocaleString("id-ID");
                    });
                });

                $form.on("submit", function(event) {

                    var $this = $(this);
                    var arr = $this.serializeArray();

                    for (var i = 0; i < arr.length; i++) {
                        arr[i].value = arr[i].value.replace(/[($)\s\._\-]+/g, '');
                    };
                });

            });
        })(jQuery);
    </script>

</body>

</html>