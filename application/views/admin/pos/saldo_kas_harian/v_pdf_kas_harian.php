<!DOCTYPE html>
<html lang="en">

<head>
  <title>Mi Resto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png'); ?>">
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
              <h2>Tanggal</h2>
            </td>
            <td class="Hours">
              <h2>Kode Outlet</h2>
            </td>
            <td class="Hours">
              <h2>Outlet</h2>
            </td>
            <td class="Hours">
              <h2>Nama Kasir</h2>
            </td>
            <td class="Hours">
              <h2>Saldo Awal</h2>
            </td>
            <td class="Hours">
              <h2>Saldo Akhir</h2>
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
                <p class="itemtext"><?= $item['kas_tgl']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['out_kode']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['out_nama']; ?></p>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= $item['pengguna_nama']; ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['kas_saldo_awal']); ?>
              </td>
              <td class="tableitem">
                <p class="itemtext"><?= number_format($item['kas_saldo_akhir']); ?>
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