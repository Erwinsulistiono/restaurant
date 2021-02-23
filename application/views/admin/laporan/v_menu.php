<!-- BEGIN BASE-->
<div id="base">

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-file"></span> Laporan</h2>
      </div>
      <p>
        <a href="<?= base_url('admin/laporan/'); ?>" class="btn btn-primary btn-raised"><span class="fa fa-arrow-left"></span>
          Kembali</a>
        <a href="<?= base_url("admin/laporan/pdf/${tgl_awal}/${tgl_akhir}/${outlet}/${group}"); ?>" target="_blank" class="btn btn-default-light text-danger btn-raised"><span class="fa fa-file-pdf-o text-danger"></span>
          PDF</a>
        <a href="<?= base_url("admin/laporan/excel/${tgl_awal}/${tgl_akhir}/${outlet}/${group}"); ?>" class="btn btn-default-light text-success btn-raised"><span class="fa fa-file-excel-o text-success"></span>
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

          </div>
        </div>
        <!--end .section-body -->

      </section>
    </section>
    <!-- END TABLE HOVER -->

  </div>
  <!--end #content-->
  <!-- END CONTENT -->

</div>
<!--end #base-->
<!-- END BASE -->

<!-- Modal view pesanan -->
<?php foreach ($data as $table_content) : ?>
  <div class="modal fade" id="modal_view_pesanan<?= $table_content['trx_cust']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
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
                <th>Harga</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              foreach ($rinci as $row) :
                if ($row['trx_cust'] == $table_content['trx_cust']) :
                  $no++; ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['order_menu']; ?></td>
                    <td><?= $row['order_qty']; ?></td>
                    <td><?= number_format($row['order_harga'], 2); ?></td>
                    <td><?= number_format($row['order_subtotal'], 2); ?></td>
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