<div id="base">

  <div id="content">
    <section>
      <div class="section-header">
        <p><a href="<?= base_url('pos/laporan_pendapatan'); ?>" onclick="" class="popup-btn btn btn-primary btn-raised"><span class="fa fa-arrow-left"></span>
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
                  <th>Periode</th>
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
                  $is_order_canceled = TRUE;
                  $no++ ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['periode']; ?></td>
                    <td><?= number_format($table_content['trx_subtotal'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_discount'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_tax_ppn'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_tax_service'], 0, '', '.'); ?></td>
                    <td><?= number_format($table_content['trx_grand_total'], 0, '', '.'); ?></td>
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