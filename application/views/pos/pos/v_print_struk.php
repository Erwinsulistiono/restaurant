<!DOCTYPE html>
<html lang="en">

<head>
  <title>Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url() . 'assets/img/logo.png' ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/print/style.css' ?>" />
</head>

<?php $logo = $pt['pt_logo'] ?>

<body translate="no">
  <div id="invoice-POS">
    <center id="top">
      <img class="logo" src="<?= base_url("assets/logo/${logo}"); ?>" />
      <div class="info">
        <h2><?= $pt['pt_nama']; ?></h2>
        <h2><?= $outlet['out_nama']; ?></h2>
      </div>
    </center>
    <!-- <pre>
      <?= var_dump($order) ?>
    </pre> -->
    <div id="mid">
      <div class="info">
        <p>
          <?php if (isset($trx)) : ?>
            <?= $trx['trx_table']; ?> </br>
            <?= $trx['trx_cust']; ?> </br>
            Tanggal : <?= $trx['trx_date']; ?> </br>
            Kasir : <?= $trx['trx_userid']; ?> </br>
          <?php else : ?>
            <?= $trx_prop['trx_tipe'] . ' - ' . $trx_prop['trx_tipe_nama']; ?> </br>
            Tanggal : <?= date('Y-m-d H:i:s'); ?> </br>
            Kasir : <?= $this->session->userdata('pengguna_username'); ?> </br>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <!--End Invoice Mid-->

    <div id="bot">
      <div id="table">
        <table>
          <tr class="tabletitle">
            <td class="Hours">
              <h2>Menu</h2>
            </td>
            <td class="Hours">
              <h2>Harga</h2>
            </td>
            <td class="Hours">
              <h2>Qty</h2>
            </td>
            <td class="Rate">
              <h2>Jumlah</h2>
            </td>
          </tr>
          <?php
          $subTotal = 0;
          foreach ($order as $items) :
          ?>
            <?php if (isset($trx)) : ?>
              <tr class="service">
                <td class="tableitem">
                  <p class="itemtext"><?= $items['menu_nama']; ?>
                </td>
                <td class="tableitem">
                  <p class="itemtext"><?= number_format($items['order_harga'], 0, '', '.'); ?>
                </td>
                <td class="tableitem">
                  <p class="itemtext"><?= $items['order_qty']; ?>
                </td>
                <td class="tableitem">
                  <p class="itemtext"><?= number_format($items['order_subtotal'], 0, '', '.'); ?></p>
                </td>
              </tr>
              <?php $subTotal += $items['order_subtotal']; ?>
            <?php else : ?>
              <tr class="service">
                <td class="tableitem">
                  <p class="itemtext"><?= $items['name']; ?>
                </td>
                <td class="tableitem">
                  <p class="itemtext"><?= number_format($items['price'], 0, '', '.'); ?>
                </td>
                <td class="tableitem">
                  <p class="itemtext"><?= $items['qty']; ?>
                </td>
                <td class="tableitem">
                  <p class="itemtext"><?= number_format($items['subtotal'], 0, '', '.'); ?></p>
                </td>
              </tr>
              <?php $subTotal += $items['subtotal']; ?>
            <?php endif; ?>
          <?php endforeach; ?>

          <tr class="tabletitle">
            <td></td>
            <td></td>
            <td class="Rate">
              <h2>Sub Total</h2>
            </td>
            <td class="Rate">
              <h2><?= number_format($subTotal, 0, '', '.'); ?></h2>
            </td>
          </tr>

          <?php if (isset($trx)) : ?>
            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Discount</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format($trx['trx_discount'], 0, '', '.'); ?></h2>
              </td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Tax Ppn</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format($trx['trx_tax_ppn'], 0, '', '.'); ?></h2>
              </td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Tax Service</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format($trx['trx_tax_service'], 0, '', '.'); ?></h2>
              </td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Grand Total</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format($trx['trx_grand_total'], 0, '', '.'); ?></h2>
              </td>
            </tr>


            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Paid</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format($trx['trx_paid'], 0, '', '.'); ?></h2>
              </td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Change</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format($trx['trx_change'], 0, '', '.'); ?></h2>
              </td>
            </tr>

          <?php else : ?>
            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Discount</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format(($trx_prop['discount']), 0, '', '.'); ?></h2>
              </td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Tax Ppn</h2>
              </td>
              <td class="Rate">
                <?php $totalPph = $subTotal * ($trx_prop['totalPph'] / 100) ?>
                <h2><?= number_format($totalPph, 0, '', '.'); ?></h2>
              </td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Tax Service</h2>
              </td>
              <td class="Rate">
                <?php $totalServiceCharge = $subTotal * ($trx_prop['totalService'] / 100) ?>
                <h2><?= number_format($totalServiceCharge, 0, '', '.'); ?></h2>
              </td>
            </tr>

            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate">
                <h2>Grand Total</h2>
              </td>
              <td class="Rate">
                <h2><?= number_format(($subTotal - $trx_prop['discount'] + $totalPph + $totalServiceCharge), 0, '', '.'); ?></h2>
              </td>
            </tr>

          <?php endif; ?>

        </table>


      </div>
      <!--End Table-->

      <div id="legalcopy">
        <center>
          <p class="legal"><strong>Thank you for coming</strong>
            <p class="legal"><strong>See you!!!</strong>
        </center>
      </div>

    </div>

</body>

<script>
  window.print();
  setTimeout(function() {
    alert("OK");
    alert('sudah print')
    window.location.href = '<?= base_url() ?>pos/pos';
  }, 4000);
</script>