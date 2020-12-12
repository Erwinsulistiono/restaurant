<div id="base">
  <div class="offcanvas">
  </div>
  <div id="content">
    <section>
      <div class="section-header">
        <p><a href="<?= base_url('pos/laporan'); ?>" onclick="" class="popup-btn btn btn-primary btn-raised"><span class="fa fa-arrow-left"></span>
            Kembali</a>
          <h2><span class="	fa fa-map-marker"></span> Data Transaksi</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>
      <section class="card style-default-bright" style="margin-top:0px;">
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Table</th>
                  <th>Cust</th>
                  <th>Jam Pesan</th>
                  <th>Register</th>
                  <th>Sub Total</th>
                  <th>Discount</th>
                  <th>Ppn</th>
                  <th>Service Charge</th>
                  <th>Grand Total</th>
                  <th>Inv No</th>
                  <th>Pembayaran</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($data as $table_content) :
                  $is_order_canceled = 0;
                  $no++ ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['trx_table']; ?></td>
                    <td><?= $table_content['trx_cust']; ?></td>
                    <td><?= $table_content['trx_date']; ?></td>
                    <td><?= $table_content['trx_userid']; ?></td>
                    <td><?= number_format($table_content['trx_subtotal'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_discount'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_tax_ppn'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_tax_service'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_grand_total'], 0, '', '.'); ?></td>
                    <td><?= ($table_content['trx_nomor']) ? ($table_content['trx_nomor']) : ""; ?></td>
                    <?php foreach ($payment as $pay) : ?>
                      <?php if (strtolower(str_replace(' ', '', $table_content['trx_payment'])) == strtolower(str_replace(' ', '', $pay['payment_nama']))) : ?>
                        <td><?= $pay['payment_nama']; ?></td>
                        <?php $is_order_canceled = 1; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if (!$is_order_canceled) : ?>
                      <td><?= $table_content['trx_payment'] ?></td>
                    <?php endif; ?>
                    <td class="text-right">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="lihat pesanan" data-toggle="modal" data-target="#modal_view_pesanan<?= $table_content['trx_id']; ?>"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

          </div>
        </div>
      </section>
    </section>
  </div>
</div>

<!-- Modal view pesanan -->
<?php foreach ($data as $table_content) : ?>
  <div class="modal fade" id="modal_view_pesanan<?= $table_content['trx_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">List Pesanan</h3>
        </div>
        <div class="card-body">
          <table class="table table-hover" id="datatable1">
            <thead>
              <tr>
                <th>No</th>
                <th>Pesanan</th>
                <th>Qty</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              foreach ($pesanan as $row) :
                if ($row['order_trx_reff'] == $table_content['trx_id']) :
                  $no++ ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['order_menu']; ?></td>
                    <td><?= $row['order_qty']; ?></td>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
<?php endforeach; ?>

<script type="text/javascript">
  function close_window() {
    close();
  }
</script>