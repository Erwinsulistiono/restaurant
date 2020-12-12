<div id="base">
  <div class="offcanvas">
  </div>
  <div id="content">
    <section>
      <div class="section-header">
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
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($data as $table_content) :
                  $no++ ?>
                <tr>
                  <td><?= $no; ?></td>
                  <td><?= $table_content['trx_table']; ?></td>
                  <td><?= $table_content['trx_cust']; ?></td>
                  <td><?= $table_content['trx_date']; ?></td>
                  <td><?= $table_content['trx_userid']; ?></td>
                  <td class="text-right">
                    <a href="#" class="btn btn-icon-toggle btn-raised" title="lihat pesanan" data-toggle="modal"
                      data-target="#modal_view_pesanan<?= $table_content['trx_id']; ?>"><i class="fa fa-eye"></i></a>
                    <a href="<?= base_url(); ?>pos/transaksi/hapus/<?= $table_content['trx_id']; ?>"
                      onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle btn-raised" title="Delete row">
                      <i class="fa fa-trash-o text-danger"></i></a>
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
<div class="modal fade" id="modal_view_pesanan<?= $table_content['trx_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
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
              <th>Status</th>
              <th class="text-right">Actions</th>
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
                  <?php $row['order_kitchen_flg'] == 'N' ? $status1 = 'Proses Masak' : $status1 = 'Sudah Proses Masak, siap diantar'; ?>
                  <?php if ($row['order_waitress_flg'] == 'Y') :
                          $status1 = '';
                          $status2 = 'Sudah diantar';
                        else :
                          $status2 = '';
                        endif; ?>
                  <td><?= $status1 ?> <?= $status2 ?></td>
                  <td class="text-right">
                    <a href="<?= base_url(); ?>pos/transaksi/hapus_order/<?= $row['order_id']; ?>"
                      onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle btn-raised" title="Delete row">
                      <i class="fa fa-trash-o text-danger"></i></a>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>