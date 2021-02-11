<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Password Reset</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    /**
   * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
   */
    @media screen {
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: 400;
        src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
      }

      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: 700;
        src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
      }
    }

    /**
   * Avoid browser level font resizing.
   * 1. Windows Mobile
   * 2. iOS / OSX
   */
    body,
    table,
    td,
    a {
      -ms-text-size-adjust: 100%;
      /* 1 */
      -webkit-text-size-adjust: 100%;
      /* 2 */
    }

    /**
   * Remove extra space added to tables and cells in Outlook.
   */
    /* table,
    td {
      mso-table-rspace: 0pt;
      mso-table-lspace: 0pt;
    } */

    /**
   * Better fluid images in Internet Explorer.
   */
    img {
      -ms-interpolation-mode: bicubic;
    }

    /**
   * Remove blue links for iOS devices.
   */
    a[x-apple-data-detectors] {
      font-family: inherit !important;
      font-size: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
      color: inherit !important;
      text-decoration: none !important;
    }

    /**
   * Fix centering issues in Android 4.4.
   */
    div[style*="margin: 16px 0;"] {
      margin: 0 !important;
    }

    body {
      width: 100% !important;
      height: 100% !important;
      padding: 0 !important;
      margin: 0 !important;
    }

    /**
   * Collapse table borders to avoid space between cells.
   */
    table {
      border-collapse: collapse !important;
    }

    a {
      color: #1a82e2;
    }

    img {
      height: auto;
      line-height: 100%;
      text-decoration: none;
      border: 0;
      outline: none;
    }
  </style>

</head>

<body style="background-color: #e9ecef;">

  <!-- start preheader -->
  <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
    <!-- A preheader is the short summary text that follows the subject line when an email is viewed in the inbox. -->
    Laporan Transaksi Harian
  </div>
  <!-- end preheader -->

  <!-- start body -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">

    <!-- start logo -->
    <tr>
      <td align="center" bgcolor="#e9ecef">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
              <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Laporan Transaksi Harian</h1>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <!-- end hero -->

    <!-- start copy block -->

    <tr>
      <td align="center" bgcolor="#e9ecef">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 20px 24px">
              <table border="0" cellpadding="0" cellspacing="20" width="60%" style="max-width: 680px; padding: 0px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
                <tr>
                  <td>
                    <p style="margin: 0;">Nama Kasir</p>
                  </td>
                  <td>
                    <p style="margin: 0;"> : Manager</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="margin: 0;">Outlet</p>
                  </td>
                  <td>
                    <p style="margin: 0;"> : Cabang Tanah Abang</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 20px 24px">
              <table border="1" cellpadding="20" cellspacing="20" width="100%" style="max-width: 680px; padding: 0px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 24px;">
                <thead>
                  <tr>
                    <th style="padding: 6px">No</th>
                    <th style="padding: 6px">Inv No</th>
                    <th style="padding: 6px">Sub Total</th>
                    <th style="padding: 6px">Discount</th>
                    <th style="padding: 6px">Ppn</th>
                    <th style="padding: 6px">SC</th>
                    <th style="padding: 6px">Grand Total</th>
                    <th style="padding: 6px">Paid</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $sub_total = 0;
                  $discount = 0;
                  $tax = 0;
                  $service_charge = 0;
                  ?>
                  <?php foreach ($data as $row) : ?>
                    <tr>
                      <td style="padding: 6px"><?= $no ?></td>
                      <td style="padding: 6px"><?= $row['trx_nomor'] ?></td>
                      <td style="padding: 6px"><?= number_format($row['trx_subtotal']); ?></td>
                      <td style="padding: 6px"><?= number_format($row['trx_discount']); ?></td>
                      <td style="padding: 6px"><?= number_format($row['trx_tax_ppn']); ?></td>
                      <td style="padding: 6px"><?= number_format($row['trx_tax_service']); ?></td>
                      <td style="padding: 6px"><?= number_format($row['trx_grand_total']); ?></td>
                      <td style="padding: 6px"><?= $row['trx_payment'] ?></td>
                    </tr>
                  <?php
                    $no++;
                    $sub_total += $row['trx_subtotal'];
                    $discount += $row['trx_discount'];
                    $tax += $row['trx_tax_ppn'];
                    $service_charge += $row['trx_tax_service'];
                  endforeach;
                  ?>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#ffffff" style="padding: 20px 24px">
              <table border="0" cellpadding="0" cellspacing="20" width="45%" style="max-width: 600px; padding: 0px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 24px;">
                <tr>
                  <td>
                    <p style="margin: 0;">Total : </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="margin: 0;">SubTotal</p>
                  </td>
                  <td>
                    <p style="margin: 0;">: Rp</p>
                  </td>
                  <td>
                    <p style="margin: 0; text-align:right;"><?= number_format($sub_total); ?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="margin: 0;">Discount</p>
                  </td>
                  <td>
                    <p style="margin: 0;">: Rp</p>
                  </td>
                  <td>
                    <p style="margin: 0; text-align:right;"><?= number_format($discount); ?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="margin: 0;">Ppn</p>
                  </td>
                  <td>
                    <p style="margin: 0;">: Rp</p>
                  </td>
                  <td>
                    <p style="margin: 0; text-align:right;"><?= number_format($tax); ?></p>
                  </td>
                </tr>
                <tr style="border-bottom: 1px solid #b5b5b5">
                  <td>
                    <p style="margin: 0;">% SC</p>
                  </td>
                  <td>
                    <p style="margin: 0;">: Rp</p>
                  </td>
                  <td>
                    <p style="margin: 0; text-align:right;"><?= number_format($service_charge); ?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p style="margin: 0;">Grand Total</p>
                  </td>
                  <td>
                    <p style="margin: 0;">: Rp</p>
                  </td>
                  <td>
                    <p style="margin: 0; text-align:right;"><?= number_format($sub_total - $discount + $tax + $service_charge); ?> </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- start copy -->
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
              <p style="margin: 0;">Salam Hormat,<br> Ops Manager.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <!-- end copy block -->

    <!-- start footer -->
    <tr>
      <td align="center" bgcolor="#e9ecef">
    <tr>
      <td align="center" bgcolor="#e9ecef" style="font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
        <p style="margin: 0;"> &copy; 2020 PT. Mitra Usaha Indonesia</p>
        <p style="margin: 0;">Jl. Tanah Abang II No.68A, RT.1/RW.5, Petojo Sel., Jakarta Pusat, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10160</p>
      </td>
    </tr>
  </table>
</body>

</html>