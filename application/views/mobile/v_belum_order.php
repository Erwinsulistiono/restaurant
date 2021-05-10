<body class="full-content">

    <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
    <div id="base" style="display: none;">

        <section class="style-default no-padding">
            <div class="card" style="min-height:100vh">
                <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
                    <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left "></span> Back</button>
                    <div class="pull-right">
                        <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-refresh" aria-hidden="true"></span> Refresh</button>
                    </div>
                </div>
                <pre>
                    <?= $order_id; ?>
                    <?= $plg_id; ?>    
                    <?php echo 'TEST' ?>
                </pre>
                <div class="card-body no-padding text-center" style="margin: 30% 10%">
                    <img src="<?= base_url('assets/img/no_data.svg') ?>" class="img-responsive text-center" alt="" />
                    <h3>Belum ada Order ni, Order Sekarang yuk</h3>
                    <br/>
                    <a href="<?= base_url('order') ?>" class="btn btn-primary">Order</a>
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