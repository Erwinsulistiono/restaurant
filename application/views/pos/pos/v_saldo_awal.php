<div id="base">
    <div class="offcanvas">
    </div>
    <div id="content">
        <br />
        <section class="section-account">
            <div class="card contain-xs style-transparent">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <br />
                            <span class="text-lg text-bold text-primary">Input Saldo Awal</span>
                            <br />

                            <form class='form floating-label' action='<?= base_url('pos/saldo/simpan_saldo_outlet'); ?>' accept-charset='utf-8' method='post'>
                                <div class="form-group">
                                    <div class="col-xs-8">
                                        <input type="text" data-type="currency" name="kas_saldo_awal" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 text-left">
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <button class="btn btn-primary btn-raised" type="submit"> Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>