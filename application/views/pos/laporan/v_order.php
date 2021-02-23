<div id="base">

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-file"></span> Laporan</h2>
      </div>
      <p>
        <a href="<?= base_url('pos/laporan/'); ?>" class="btn btn-primary btn-raised"><span class="fa fa-arrow-left"></span>
          Kembali</a>
        <a href="<?= base_url("pos/laporan/pdf/${tgl_awal}/${tgl_akhir}/${tipe_trx}/${group}"); ?>" target="_blank" class="btn btn-default-light text-danger"><span class="fa fa-file-pdf-o text-danger btn-raised"></span>
          PDF</a>
        <a href="<?= base_url("pos/laporan/excel/${tgl_awal}/${tgl_akhir}/${tipe_trx}/${group}"); ?>" class="btn btn-default-light text-success"><span class="fa fa-file-excel-o text-success btn-raised"></span>
          EXCEL</a>
      </p>
      <?= $this->session->flashdata('msg'); ?>

      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
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
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

          </div>
        </div>
      </section>
    </section>
    <!-- END TABLE HOVER -->

  </div>
  <!-- END CONTENT -->

</div>
<!-- END BASE -->