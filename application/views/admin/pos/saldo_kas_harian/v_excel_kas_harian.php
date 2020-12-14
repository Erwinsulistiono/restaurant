<h3 align="center">Saldo Kas Harian</h3>

<table>
<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Saldo_Kas_Harian.xls");
?>
	<thead>
	  <tr>
	    <th>No</th>
	    <th>Tanggal</th>
	    <th>Kode Outlet</th>
	    <th>Outlet</th>
	    <th>Nama Kasir</th>
	    <th>Saldo Awal</th>
	    <th>Saldo Akhir</th>
	  </tr>
	</thead>
	<tbody>
	<?php $no = 0;
	foreach ($data as $table_content) :
	$no++ ?>
		<tr>
	    <td><?= $no; ?></td>
	    <td><?= $table_content['kas_tgl']; ?></td>
	    <td><?= $table_content['out_kode']; ?></td>
	    <td><?= $table_content['out_nama']; ?></td>
	    <td><?= $table_content['pengguna_nama']; ?></td>
	    <td><?= number_format($table_content['kas_saldo_awal']); ?></td>
	    <td><?= number_format($table_content['kas_saldo_akhir']); ?></td>
	    </tr>
	    <?php endforeach; ?>
	</tbody>
</table>

	         