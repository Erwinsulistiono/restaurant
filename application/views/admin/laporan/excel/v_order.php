<h2 align="center"><?= $pt['pt_nama']; ?></h2>
<h3 align="center">Data Order</h3>

<table>
  <?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Data_Order.xls");
  ?>
  <thead>
    <tr>
      <th>No</th>
      <th>Invoice</th>
      <th>Table</th>
      <th>Menu</th>
      <th>Total Qty Order</th>
      <th>Harga</th>
      <th>Sub Total</th>
      <th>Noted</th>
      <th>Tanggal</th>
      <th>ID User</th>
      <th>Cust</th>
      <th>Outlet</th>
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
        <td><?= $table_content['order_menu']; ?></td>
        <td><?= $table_content['order_qty']; ?></td>
        <td><?= number_format($table_content['order_harga'], 2); ?></td>
        <td><?= number_format($table_content['order_subtotal'], 2); ?></td>
        <td><?= $table_content['order_notes']; ?></td>
        <td><?= $table_content['order_date']; ?></td>
        <td><?= $table_content['order_userid']; ?></td>
        <td><?= $table_content['trx_cust']; ?></td>
        <td><?= $table_content['out_nama']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>