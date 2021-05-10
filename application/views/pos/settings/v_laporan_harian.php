<!DOCTYPE html>
<html lang="en">

<head>
  <title>Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png');  ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/print_laporan/style.css'); ?>" />
</head>

<body translate="no">

  <div id="invoice-POS">
    <div id="bot">
      <div id="table">
        <div class="row" style="padding: 0 20px;">
          <div class="col-xs-3" style="margin: 0 10px; height: 2px; vertical-align: baseline;">
            Item Sales
          </div>
          <div class="col-xs-3" style="margin: 0 10px; height: 2px; vertical-align: baseline;">
            Total Sales
          </div>
          <div class="col-xs-5" style="margin: 0 10px; vertical-align: baseline;">
            Sales Collection
          </div>
        </div>
        <div class="row" style="padding: 0 20px;">
          <div class="col-xs-3" style="border-style: solid; margin: 10px; height: 590px">
            <?php
            $sub_total = 0;
            foreach ($penjualan_per_menu as $row) : ?>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left"><?= $row["order_menu"] ?></div>
                <div class="pull-right">Rp. <?= number_format($row["order_subtotal"]) ?></div>
              </div>
            <?php
              $sub_total += $row["order_subtotal"];
            endforeach ?>
            <div class="row" style="margin: 0 6px;"><strong>...</strong></div>
            <div class="row" style="margin: 0 6px;"><strong>...</strong></div>
            <div class="row" style="margin: 0 6px;"><strong>...</strong></div>
            <div class="row" style="margin: 0 6px; border-bottom-style: solid;"></div>
            <div class="row" style="padding: 0 20px;">
              <div class="pull-left">Total</div>
              <div class="pull-right">Rp. <?= number_format($sub_total) ?></div>
            </div>
          </div>

          <div class="col-xs-3" style="border-style: solid; margin: 10px; height: 590px">
            <div class="row" style="padding: 10px 20px;">
              <div class="pull-left">Item Sales</div>
              <div class="pull-right">Rp. <?= @number_format($sub_total) ?></div>
            </div>
            <div class="row" style="margin: 5px 6px; border-bottom-style: solid;"></div>
            <div class="row" style="padding: 5px 20px;">
              <div class="pull-left">Discount</div>
              <div class="pull-right"><?= @number_format($summary[0]["trx_discount"]) ?></div>
            </div>
            <div class="row" style="padding: 5px 20px;">
              <div class="pull-left">Ppn (<?= $taxresto ?>%)</div>
              <div class="pull-right"><?= @number_format($sub_total * $taxresto / 100) ?></div>
              <?php $ppn = $sub_total * $taxresto / 100; ?>
            </div>
            <div class="row" style="padding: 5px 20px;">
              <div class="pull-left">Service Charge (<?= $taxservice ?>%)</div>
              <div class="pull-right"><?= @number_format($sub_total * $taxservice / 100) ?></div>
              <?php $service = $sub_total * $taxservice / 100; ?>
            </div>
            <div class="row" style="margin: 5px 6px; border-bottom-style: solid;"></div>
            <div class="row" style="padding: 5px 20px;">
              <div class="pull-left">Grand Total</div>
              <div class="pull-right">Rp. <?= @number_format($sub_total - $summary[0]["trx_discount"] + $ppn + $service) ?></div>
            </div>
          </div>

          <div class="col-xs-5" style="margin: 10px">
            <div class="row" style="padding:5px; border-style: solid; margin: 0 0 20px 0; height: 210px">
              <?php
              $sub_total_online_payment = 0;
              $sub_total_cash = 0;
              foreach ($payment_method as $row) :
                foreach ($trx as $t) :
                  if (strtoupper($row['payment_nama']) == strtoupper($t['trx_payment'])) :
                    if (strtoupper($row['payment_nama']) != strtoupper('cash')) : ?>
                      <div class="row" style="padding: 0 20px;">
                        <div class="pull-left"><?= strtoupper($row['payment_nama']) ?></div>
                        <div class="pull-right">Rp. <?= number_format($t['sum_grand_total']) ?></div>
                      </div>
              <?php
                      $sub_total_online_payment += $t['sum_grand_total'];
                    else :
                      $sub_total_cash += $t['sum_grand_total'];
                    endif;
                  endif;
                endforeach;
              endforeach; ?>
              <div class="row" style="margin: 0 6px; border-bottom-style: solid;"></div>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Total</div>
                <div class="pull-right">Rp. <?= number_format($sub_total_online_payment) ?></div>
              </div>
            </div>

            <div class="row" style="padding:5px; margin: 20px 0 0 0; height: 100px; border-style: solid;">
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Online & Card</div>
                <div class="pull-right">Rp. <?= number_format($sub_total_online_payment) ?></div>
              </div>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Cash</div>
                <div class="pull-right">Rp. <?= number_format($sub_total_cash) ?></div>
              </div>
              <div class="row" style="margin: 0 6px; border-bottom-style: solid;"></div>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Total</div>
                <div class="pull-right">Rp. <?= number_format($sub_total_online_payment + $sub_total_cash) ?></div>
              </div>
            </div>

            <div class="row" style="padding:5px; margin: 20px 0 0 0; height: 240px; border-style: solid;">
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Total Menu Terjual</div>
                <div class="pull-right"><?= $total_order ?></div>
              </div>
              <?php
              $count_trx = 0;
              $dine_in = 0;
              $take_away = 0;
              $mobil = 0;
              $delivery = 0;
              foreach ($total_trx as $trx) {
                $count_trx++;
                ($trx['trx_tipe'] == 1) && $dine_in++;
                ($trx['trx_tipe'] == 2) && $take_away++;
                ($trx['trx_tipe'] == 3) && $mobil++;
                ($trx['trx_tipe'] == 4) && $delivery++;
              } ?>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Total Transaksi</div>
                <div class="pull-right"><?= $count_trx ?></div>
              </div>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Dine In</div>
                <div class="pull-right"><?= $dine_in ?></div>
              </div>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Take Away</div>
                <div class="pull-right"><?= $take_away ?></div>
              </div>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Delivery</div>
                <div class="pull-right"><?= $delivery ?></div>
              </div>
              <div class="row" style="padding: 0 20px;">
                <div class="pull-left">Mobil</div>
                <div class="pull-right"><?= $mobil ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<script src="<?= base_url('assets/js/jsPdf/jspdf.min.js') ?>"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let pdf = new jsPDF('l', 'pt', 'letter');
    let today = new Date();

    let date = (today.getDate() < 10) ? `0${today.getDate()}` : today.getDate();
    let month = (today.getMonth() < 10) ? `0${today.getMonth() + 1}` : today.getMonth() + 1;
    let year = today.getFullYear();
    let hour = (today.getUTCHours() < 3) ? `0${today.getUTCHours() + 7}` : today.getUTCHours() + 7;
    let minutes = (today.getUTCMinutes() < 10) ? `0${today.getUTCMinutes()}` : today.getUTCMinutes();
    let seconds = (today.getUTCSeconds() < 10) ? `0${today.getUTCSeconds()}` : today.getUTCSeconds();

    pdf.addHTML(document.querySelector('#invoice-POS'), function() {
      pdf.save(`LAP_HARIAN_${date}${month}${year}.pdf`);
    });
  });
</script>

<!-- <script>
  window.print();
</script> -->