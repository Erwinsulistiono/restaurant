<h2 align="center"><?= $pt['pt_nama']; ?></h2>
<h3 align="center">Data Pelanggan</h3>

<table>
  <?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Data_Pelanggan.xls");
  ?>
  <thead>
    <tr>
      <th>No</th>
      <th>Cust</th>
      <th>Join Date</th>
      <th>Last Order</th>
      <th>Sub Total</th>
      <th>Discount</th>
      <th>Ppn</th>
      <th>Service Charge</th>
      <th>Grand Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 0;
    foreach ($data as $table_content) :
      $no++ ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $table_content['trx_cust']; ?></td>
        <td><?= $table_content['join_date']; ?></td>
        <td><?= $table_content['last_order']; ?></td>
        <td><?= number_format($table_content['trx_subtotal'], 2); ?></td>
        <td><?= number_format($table_content['trx_discount'], 2); ?></td>
        <td><?= number_format($table_content['trx_tax_ppn'], 2); ?></td>
        <td><?= number_format($table_content['trx_tax_service'], 2); ?></td>
        <td><?= number_format($table_content['trx_grand_total'], 2); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>