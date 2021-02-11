<!DOCTYPE html>
<html lang="en">

<head>
  <title>Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png'); ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/print_laporan/style.css'); ?>" />
</head>

<body translate="no">
  <div id="invoice-POS">

    <div id="mid">
      <div class="info">
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
              <h2>Menu</h2>
            </td>
            <td class="Hours">
              <h2>Harga</h2>
            </td>
            <td class="Hours">
              <h2>Total Qty Order</h2>
            </td>
            <td class="Hours">
              <h2>Total Revenue</h2>
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
                <p class="itemtext"><?= $item['order_menu']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['order_harga'], 2); ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['order_total']; ?></p>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['order_revenue'], 2); ?>
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