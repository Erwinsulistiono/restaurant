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
              <span class="text-lg text-bold text-primary">Input Saldo Akhir</span>
              <br />
              <form class='form floating-label' action='<?= base_url(); ?>pos/settings/simpan_close_kasir'
                accept-charset='utf-8' method='post'>
                <div class="col-xs-12 form-group">
                  <?php $cek_saldo ? $disabled = '' : $disabled = 'disabled'; ?>
                  <?php $cek_saldo ? $kas_amount = $cek_saldo['kas_saldo_awal'] : $kas_amount = ''; ?>
                  <?php $cek_saldo ? $kas_id = $cek_saldo['kas_id'] : $kas_id = ''; ?>
                  <input type="hidden" name="kas_id" class="form-control" value="<?= $kas_id; ?>">
                  <input type="text" name="kas_saldo_akhir" data-type="currency" id="saldoInput" class="form-control"
                    onkeyup="testvalidasi()" <?= $disabled ?> required>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left">
                  </div>
                  <div class="col-xs-6 text-right">
                    <button class="btn btn-primary btn-flat btn-raised" id="lapSaldo" <?= $disabled ?>> Detail</button>
                    <button class="btn btn-primary btn-raised" id="validasiAlert" type="submit" <?= $disabled ?>>
                      Simpan</button>
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

<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<script type='text/javascript'>
$('#lapSaldo').click(function(e) {
  e.preventDefault();
  var win = window.open("<?= base_url('pos/laporan/filter'); ?>", '_blank');
  (win) ? win.focus() : alert('Please allow popups for this website');
});


let testvalidasi = () => {
  var kas = Number('<?= $kas_amount; ?>');
  var kasInput = Number($('#saldoInput').val().replace(/[($)\s\._\-]+/g, ''));
  var totSaldoHarian = Number('<?= $tot_saldo; ?>');
};


$('#validasiAlert').click(function() {
  var kas = Number('<?= $kas_amount; ?>');
  var kasInput = Number($('#saldoInput').val().replace(/[($)\s\._\-]+/g, ''));
  var totSaldoHarian = Number('<?= $tot_saldo; ?>');
  if ((kas + totSaldoHarian) > kasInput) {
    alert('Inputan saldo kurang dari total cash in + saldo pemasukan!')
  } else if ((kas + totSaldoHarian) < kasInput) {
    alert('Inputan saldo lebih dari total cash in + saldo pemasukan!')
  } else {
    alert('Data Berhasil Tersimpan');
  };
});
</script>