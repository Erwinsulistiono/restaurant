<!DOCTYPE html>
<html lang="en">

<head>
  <title>Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url() . 'assets/img/logo.png' ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/print_laporan/style.css' ?>" />
</head>

<body translate="no">
  <div id="invoice-POS">
    <div id="mid">
      <div class="info">
        <p>
          <!--  -->
        </p>
      </div>
    </div>
    <!--End Invoice Mid-->

    <div id="bot">
      <div id="table">
        <table>
          <tr class="tabletitle">
            <td class="Hours">
              <h2>No</h2>
            </td>
            <td class="Hours">
              <h2>Invoice</h2>
            </td>
            <td class="Hours">
              <h2>Table</h2>
            </td>
            <td class="Hours">
              <h2>Menu</h2>
            </td>
            <td class="Hours">
              <h2>Total Qty Order</h2>
            </td>
            <td class="Hours">
              <h2>Harga</h2>
            </td>
            <td class="Hours">
              <h2>Sub Total</h2>
            </td>
            <td class="Hours">
              <h2>Noted</h2>
            </td>
            <td class="Hours">
              <h2>Tanggal</h2>
            </td>
            <td class="Hours">
              <h2>ID User</h2>
            </td>
            <td class="Hours">
              <h2>Cust</h2>
            </td>
            <td class="Hours">
              <h2>Outlet</h2>
            </td>
          </tr>
          <?php $no= 0; foreach($data as $item) :
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
              <p class="itemtext"><?= $item['order_menu']; ?></p>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['order_qty']; ?>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['order_harga']; ?>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['order_subtotal']; ?>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['order_notes']; ?>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['order_date']; ?>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['order_userid']; ?>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['trx_cust']; ?>
            </td>
            <td class="tableitem">
              <p class="itemtext"><?= $item['out_nama']; ?>
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