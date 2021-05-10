<h2 align="center"><?= $pt['pt_nama']; ?></h2>
<h3 align="center">Data Menu</h3>

<table>
  <?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Data_Menu.xls");
  ?>
  <thead>
    <tr>
      <th>No</th>
      <th>Menu</th>
      <th>Harga</th>
      <th>Total Qty Order</th>
      <th>Total Revenue</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 0;
    foreach ($data as $table_content) :
      $no++ ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $table_content['order_menu']; ?></td>
        <td><?= number_format($table_content['order_harga'], 2); ?></td>
        <td><?= $table_content['order_total']; ?></td>
        <td><?= number_format($table_content['order_revenue'], 2); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>