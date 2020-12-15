<!DOCTYPE html>
<html lang="en">

<head>
  <title>Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png');  ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/print_laporan/style.css'); ?>" />
</head>

<body translate="no">
  <div id="invoice-POS">

    <div id="bot">
      <div id="table">
        <table>
          <tr class="tabletitle">
            <td class="Hours">
              <h2>No</h2>
            </td>
            <td class="Hours">
              <h2>Inv No</h2>
            </td>
            <td class="Hours">
              <h2>Table</h2>
            </td>
            <td class="Hours">
              <h2>Cust</h2>
            </td>
            <td class="Hours">
              <h2>Jam Pesan</h2>
            </td>
            <td class="Hours">
              <h2>Register</h2>
            </td>
            <td class="Hours">
              <h2>Sub Total</h2>
            </td>
            <td class="Hours">
              <h2>Discount</h2>
            </td>
            <td class="Hours">
              <h2>Ppn</h2>
            </td>
            <td class="Hours">
              <h2>Service Charge</h2>
            </td>
            <td class="Hours">
              <h2>Grand Total</h2>
            </td>
            <td class="Hours">
              <h2>Pembayaran</h2>
            </td>
          </tr>
          <?php $no = 0;
          foreach ($data as $item) :
            $no++ ?>
            <tr class="service">
              <td class="tableitem">
                <p class="itemtext"><?= $no; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['trx_nomor']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['trx_table']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['trx_cust']; ?></p>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['trx_date']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['trx_userid']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['trx_subtotal'], 2); ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['trx_discount'], 2); ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['trx_tax_ppn'], 2); ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['trx_tax_service'], 2); ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['trx_grand_total'], 2); ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['trx_payment']; ?>
              </td>
            </tr>

          <?php endforeach; ?>

        </table>


      </div>
      <!--End Table-->

    </div>

</body>

<script>
  window.print();
</script>