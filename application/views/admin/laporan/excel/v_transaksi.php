<h2 align="center"><?= $pt['pt_nama']; ?></h2>
<h3 align="center">Data Transaksi</h3>

<table>
  <?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Data_Transaksi.xls");
  ?>
  <thead>
    <tr>
      <th>No</th>
      <th>Inv No</th>
      <th>Table</th>
      <th>Cust</th>
      <th>Jam Pesan</th>
      <th>Register</th>
      <th>Sub Total</th>
      <th>Discount</th>
      <th>Ppn</th>
      <th>Service Charge</th>
      <th>Grand Total</th>
      <th>Pembayaran</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 0;
    foreach ($data as $table_content) :
      $no++ ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $table_content['trx_nomor']; ?></td>
        <td><?= $table_content['trx_table']; ?></td>
        <td><?= $table_content['trx_cust']; ?></td>
        <td><?= $table_content['trx_date']; ?></td>
        <td><?= $table_content['trx_userid']; ?></td>
        <td><?= number_format($table_content['trx_subtotal'], 2); ?></td>
        <td><?= number_format($table_content['trx_discount'], 2); ?></td>
        <td><?= number_format($table_content['trx_tax_ppn'], 2); ?></td>
        <td><?= number_format($table_content['trx_tax_service'], 2); ?></td>
        <td><?= number_format($table_content['trx_grand_total'], 2); ?></td>
        <td><?= $table_content['trx_payment']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>