<div class="offcanvas">

</div>

<div id="content">
  <section>
    <div class="section-header">
      <h2><span class="fa fa-cutlery"></span> Point of Sale</h2>
    </div>
    <?= $this->session->flashdata('msg'); ?>
    <div class="msg"></div>
    <section class="style-default no-padding no-margin">
      <div class="container-fluid no-padding">
        <div class="col-lg-5 col-md-5 col-xs-12 col-sm-6 no-padding">
          <div class="card">
            <form role="form" id="order_form" method="post" action="<?= base_url() . 'pos/pos/proses_kitchen/' .  $trx_prop['plg_id'] . '/' . $trx_prop['trx_tipe_nama']; ?>">
              <div class="row card-body no-margin" style="position:sticky; top:0px; padding:10px 27px; z-index:1001">
                <div class="pull-left">
                  <div class="input-group-btn btn-raised">
                    <button type="button" class="btn cust-group-btn-left btn-primary btn-raised" tabindex="-1">Order</button>
                    <button type="button" class="btn cust-group-btn-right btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1">
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <?php foreach ($tipe_transaksi as $t) : ?>
                        <li><a href="#" data-toggle="modal" data-target="#modal_<?= $t['tipe_transaksi_id'] ?>"><?= $t['tipe_transaksi_nama']; ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
                &nbsp;
                <a id="getTransaksiMobile" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_view_cust_order">Customer &nbsp;
                  <sup id="mobile-order-notification" class="badge style-danger"></sup></a>
                <button id="getStatusPemesananPelanggan" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_status_order">Status</button>
              </div>
              <div class="card-body" style="overflow-y:scroll; height:60vh; padding:10px 27px;">
                <div class="pull-right">
                  <h4><?= strtoupper($trx_prop['trx_tipe']) . ' - ' .  strtoupper($trx_prop['trx_tipe_nama']) . ''; ?></h4>
                </div>
                <table class="table no-margin no-padding table-responsive table-condensed">
                  <div class="caption">
                    <thead>
                      <tr>
                        <th style="width:10rem">Menu</th>
                        <th>Harga</th>
                        <th></th>
                        <th class="text-center">Qty</th>
                        <th></th>
                        <th>Jumlah</th>
                        <th class="text-right">Action</th>
                      </tr>
                    </thead>
                    <tbody id="show_cart" style="min-height:100vh">
                      <?php
                      $valueSubTotal = 0;
                      foreach ($cart as $c) :
                      ?>
                        <tr>
                          <td><?= $c['name'] . ' - ' . $c['options']['notes']; ?></td>
                          <td></td>
                          <td><?= $c['price']; ?></td>
                          <td></td>
                          <td class="text-center"><?= $c['qty']; ?></td>
                          <td><?= $c['subtotal']; ?></td>
                          <td class="text-right">
                            <a href="#" class="hapus_cart btn text-danger btn-icon-toggle btn-raised" id="<?= $c['rowid']; ?>" title="hapus pesanan">
                              <i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                      <?php
                        $valueSubTotal += $c['subtotal'];
                      endforeach; ?>
                    </tbody>
                    </tfoot>
                    <tr>
                      <th style="text-align:left;" colspan="5">Sub Total</th>
                      <th style="text-align:center;" colspan="2"><input class="form-control" id="subTotal" name="subtotal" value="<?= number_format($valueSubTotal, 0, '', '.'); ?>" readonly>
                      </th>
                    </tr>
                    <div class="form-group">
                      <tr>
                        <?php (isset($valueDiscount)) ? $valueDiscount = $valueDiscount : $valueDiscount = 0; ?>
                        <th style="text-align:left;" colspan="5">Discount
                          <input type="text" style="width: 4rem;height: 1rem;padding:1rem;" id="percentageDiscount" name="discount" autocomplete="off"> %</th>
                        <th style="text-align:center;" colspan="2">
                          <input type="text" class="form-control " id="discount" name="discount" value="<?= number_format($valueDiscount, 0, '', '.'); ?> " data-type="currency">
                        </th>
                      </tr>
                    </div>
                    <div class="form-group">
                      <tr>
                        <?php $valueServiceCharge = ($valueSubTotal * $taxservice / 100); ?>
                        <th style="text-align:left;" colspan="5">Service Charge (<?= $taxservice ?>%)
                        <th style="text-align:center;" colspan="2">
                          <input class="form-control" id="totalService" name="totalservice" value="<?= number_format($valueServiceCharge, 0, '', '.'); ?>" readonly>
                        </th>
                      </tr>
                    </div>
                    <div class="form-group">
                      <tr>
                        <?php $valuePpn = ($valueSubTotal * $taxresto / 100); ?>
                        <th style="text-align:left;" colspan="5">Pajak Resto (<?= $taxresto ?>%)
                        <th style="text-align:center;" colspan="2">
                          <input class="form-control" id="totalPph" name="totalpph" value="<?= number_format($valuePpn, 0, '', '.'); ?>" readonly>
                        </th>
                      </tr>
                    </div>
                    <div class="form-group">
                      <?php $valueGrandTotal = $valueSubTotal - ($valueDiscount) + $valueServiceCharge + $valuePpn ?>
                      <tr>
                        <th style="text-align:left;" colspan="5">Grand Total</th>
                        <th style="text-align:center;" colspan="2">
                          <input class="form-control" id="grandTotal" name="grandtotal" value="<?= number_format($valueGrandTotal, 0, '', '.'); ?>" readonly>
                        </th>
                      </tr>
                    </div>
                    <div class="form-group">
                      <input type="hidden" id="trx_tipe" name="trx_tipe" value="<?= $trx_prop['trx_tipe_id'] ?>">
                    </div>
                    </tfoot>
                  </div>
                </table>
              </div>
              <div class="card card-body no-margin" style="border-radius: 10px;padding: 10px;">
                <?php $trx_prop['trx_tipe_nama'] == "" ? $disabled = 'disabled' : $disabled = ''; ?>
                <?php $trx_prop['trx_tipe_nama'] !== "" && isset($trx) ? $disabledBayar = '' : $disabledBayar = 'disabled'; ?>

                <button type="submit" style="text-align:left;" type="submit" class="btn btn-primary btn-raised" <?= $disabled; ?>>Proses</button>

                <a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_voucher" <?= $disabled; ?>>Voucher</a>

                <div class="pull-right">
                  <div class="input-group-btn btn-raised dropup">
                    <button type="button" class="btn btn-primary btn-flat btn-raised" tabindex="-1" <?= $disabledBayar ?>>Bayar</button>
                    <button type="button" class="btn btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1" <?= $disabledBayar; ?>>
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="<?php echo base_url('pos/pos/printBill/') . $trx_prop['plg_id']; ?>" id="printBill" <?= $disabledBayar; ?> target="_blank">Print</a></li>
                      <?php
                      foreach ($payment as $k) :
                        $k_id = $k['payment_id'];
                        $k_nama = $k['payment_nama'];
                      ?>
                        <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran" <?= $disabledBayar; ?>><?= $k_nama; ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-xs-12 col-sm-6" style="padding-right:0px;">
          <div class="card">
            <div class="tab-slider">
              <div class="wrap">
                <ul class="nav nav-tabs" id="menus" role="tablist" id="example-tabs" data-tabs>
                  <li role="presentation" class="active"><a href="#panel-all" aria-controls="home" role="tab" data-toggle="tab">Semua</a></li>
                  <?php foreach ($kategori as $index => $tab) : ?>
                    <li role="presentation"><a href="#panel-<?= $index; ?>" role="tab" data-toggle="tab"><?= $tab['kategori_nama']; ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <button id="goPrev" class="btn btn-default btn-icon"><i class="fa fa-chevron-left "></i></button>
              <button id="goNext" class="btn btn-default btn-icon"><i class="fa fa-chevron-right "></i></button>
            </div>
            <div class="tabs-content" data-tabs-content="example-tabs" style="overflow-y:scroll; height:70vh">
              <div role="tabpanel" class="tab-pane active" id="panel-all">
                </br>
                <?php foreach ($data as $index => $table_content) : ?>
                  <div class="col-lg-3 col-md-3 col-lg-4 col-sm-6">
                    <div class="no-padding card thumbnail btn">
                      <a data-toggle="modal" data-target="#option_menu<?= $table_content['menu_id'] ?>">
                        <td>
                          <img style="width:auto;height:12rem;border-radius:4px" class="width-1 img-responsive rounded" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" />
                        </td>
                        <div class="caption text-left no-padding">
                          <h5 class="text-light"><strong>&nbsp;<?= $table_content['menu_nama']; ?></strong></h5>
                          <div>
                            <h5 class="text-light">
                              <strong>&nbsp;<?= number_format($table_content['menu_harga_baru']); ?></strong></h5>
                      </a>
                    </div>
                  </div>
              </div>
            </div>
          <?php endforeach; ?>
          </div>
          <?php foreach ($kategori as $index => $tab) : ?>
            <div role="tabpanel" class="tab-pane" id="panel-<?= $index; ?>">
              </br>
              <?php foreach ($kategori_makanan as $index => $table_content) : ?>
                <?php if (($table_content['kategori_id'] == $tab['kategori_id'])) : ?>
                  <div class="col-lg-3 col-md-3 col-lg-4 col-sm-6">
                    <div class="table-responsive">
                      <div class="no-padding card thumbnail btn">
                        <a data-toggle="modal" data-target="#option_menu<?= $table_content['menu_id'] ?>">
                          <td>
                            <img style="width:auto;height:12rem;border-radius:4px" class="width-1 img-responsive rounded" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" />
                          </td>
                          <div class="caption text-left no-padding">
                            <h5 class="text-light"> <strong>&nbsp;<?= $table_content['menu_nama']; ?></strong></h5>
                            <h5 class="text-light">
                              <strong>&nbsp;<?= number_format($table_content['menu_harga_baru']); ?></strong></h5>

                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </section>
</div>


<!-- MODAL TAMBAH NOTES PESANAN -->
<?php foreach ($data as $index => $table_content) : ?>
  <div class="modal fade" id="option_menu<?= $table_content['menu_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
        </div>
        <form class="form-horizontal" action="#" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Add Notes (Optional)</label>
              <div class="col-sm-8">
                <textarea type="text" class="form-control" id="notes_pesanan<?= $table_content['menu_id']; ?>"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="add_cart btn btn-primary btn-raised" data-dismiss="modal" aria-hidden="true" data-itemid="<?= $table_content['menu_id']; ?>" data-itemnama="<?= $table_content['menu_nama']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>">Add Pesanan</a>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<!-- MODAL KATEGORI TRANSAKSI PESANAN -->
<?php foreach ($tipe_transaksi as $t) : ?>
  <div class="modal fade" id="modal_<?= $t['tipe_transaksi_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
        </div>
        <div class="table-responsive">

          <?php if ($t['tipe_transaksi_id'] == 1) : ?>
            <?php foreach ($alltable as $row) : ?>
              <form role="form" method="post" action="<?= base_url() . 'pos/pos/' ?>">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-head style-gray">
                      <h3 class="text-center text-light"><?= $row['meja_nama']; ?></h3>
                    </div>
                    <div class="card-body no-padding card-type-pricing">
                      <ul class="list-unstyled">
                        <li>
                          <div class="clearfix">
                            <div class="pull-left">Area :</div>
                            <div class="pull-right"><?= $row['area_nama']; ?> </div>
                          </div>
                        </li>
                        <li>
                          <div class="clearfix">
                            <div class="pull-left">Lantai :</div>
                            <div class="pull-right"><?= $row['area_level']; ?> </div>
                          </div>
                        </li>
                        <li>
                          <div class="clearfix">
                            <div class="pull-left">Kapasitas :</div>
                            <div class="pull-right"><?= $row['meja_cptcy']; ?> </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body no-padding card-type-pricing">
                      <input type="hidden" name="meja_id" value="<?= $row['meja_id']; ?>">

                      <!-- loop untuk dropdown pilih pelanggan -->
                      <datalist id="pelanggan-<?= $row['meja_id'] ?>">
                        <?php foreach ($customer as $c) : ?>
                          <?php if ($c['plg_login_flg'] == 'Y') : ?>
                            <?php (($row['meja_pelanggan'] == $c['plg_id']) && ($c['plg_order'] != 0)) ? $p = $c['plg_nama'] : "" ?>
                            <option data-value="<?= $c['plg_id'] ?>"><?= $c['plg_nama'] ?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </datalist>

                      <?php isset($p) && ($p !== "") ? $pelangganValue = $p : $pelangganValue = "" ?>
                      <input class="form-control" list="pelanggan-<?= $row['meja_id'] ?>" id="list-<?= $row['meja_id'] ?>" value="<?= $pelangganValue ?>">
                      <input type="hidden" name="plg_id" id="list-<?= $row['meja_id'] ?>-hidden" value="<?= $row['meja_pelanggan']; ?>">
                      <?php $p = ""; ?>
                      <div class="card-body text-center">
                        <button class="btn btn-primary btn-raised" type="submit">Pilih</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            <?php endforeach; ?>

          <?php else : ?>
            <?php $queue = 0; ?>
            <?php foreach ($all_trx as $row) : ?>
              <?php if ($row['trx_tipe'] == $t['tipe_transaksi_id']) : ?>
                <?php $queue += 1; ?>
                <form role="form" method="post" action="<?= base_url() . 'pos/pos/' ?>">
                  <div class="col-md-3">
                    <div class="card style-gray">
                      <div class="card-head">
                        <h3 class="text-center text-light"><?= $t['tipe_transaksi_nama'] . ' - ' . $queue ?></h3>
                      </div>
                      <div class="card-body no-padding card-type-pricing">
                        <ul class="list-unstyled">
                          <li>
                            <div class="clearfix">
                              <div class="pull-left">Nama :</div>
                              <div class="pull-right"><?= $row['trx_table']; ?> </div>
                            </div>
                          </li>
                          <li>
                            <div class="clearfix">
                              <div class="pull-left">No. Order :</div>
                              <div class="pull-right">Order-<?= $row['trx_id']; ?> </div>
                            </div>
                          </li>
                          <li>
                            <div class="clearfix">
                              <div class="pull-left">Status :</div>
                              <?php $prev_status = ''; ?>
                              <?php foreach ($all_order as $o) :
                                if ((($row['trx_id'] == $o['order_trx_reff']) && (($o['order_kitchen_flg'] == 'Y') &&
                                  ($o['order_waitress_flg'] == 'Y'))) && ($prev_status == '')) :
                                  $status = 'done';
                                elseif ((($row['trx_id'] == $o['order_trx_reff']) && (($o['order_kitchen_flg'] == 'Y') &&
                                  ($o['order_waitress_flg'] == 'N'))) && ($prev_status == '')) :
                                  $status = 'preparing';
                                  $prev_status = $status;
                                else :
                                  $status = 'cooking';
                                  $prev_status = $status;
                                endif;
                              endforeach;
                              ?>
                              <div class="pull-right"><?= $status; ?> </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body no-padding card-type-pricing">
                        <?php foreach ($customer as $c) : ?>
                          <?php if ($row['trx_id'] == $c['plg_order']) : ?>
                            <input type="hidden" name="plg_id" value="<?= $c['plg_id'] ?>">
                            <?php (($c['plg_alamat']) && print('<input type="hidden" name="plg_alamat" value="' . $c['plg_alamat'] . '">')) ?>
                            <?php (($c['plg_platno']) && print('<input type="hidden" name="plg_platno" value="' . $c['plg_platno'] . '">')) ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="card-body text-center">
                          <button class="btn btn-primary btn-raised" type="submit">Pilih</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>

        </div>
        <div class="modal-footer">
          <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
          <?php if ($t['tipe_transaksi_id'] != 1) : ?>
            <a href="#" class="btn btn-primary btn-raised" data-dismiss="modal" aria-hidden="true" data-toggle="modal" data-target="#tambah_<?= $t['tipe_transaksi_id']; ?>"><span class="fa fa-plus"></span>
              <?= $t['tipe_transaksi_nama']; ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<!-- MODAL PESANAN VIA MOBILE WEB APP-->
<div class="modal fade" id="modal_view_cust_order" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
      </div>
      <div id="targetMobileOrder" class="table-responsive">
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH TRANSAKSI TAKE AWAY/DELIVERY-->
<?php foreach ($tipe_transaksi as $t) : ?>
  <div class="modal fade" id="tambah_<?= $t['tipe_transaksi_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
        </div>
        <form class="form-horizontal" action="<?= base_url() . 'pos/pos/' ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pelanggan</label>
              <div class="col-sm-8">
                <!-- loop untuk dropdown pilih pelanggan -->
                <datalist id="pelanggan-<?= $t['tipe_transaksi_nama'] ?>">
                  <?php foreach ($customer as $c) : ?>
                    <?php if ($c['plg_login_flg'] == 'Y') : ?>
                      <?php (($row['meja_pelanggan'] == $c['plg_id']) && ($c['plg_order'] != 0)) ? $p = $c['plg_nama'] : "" ?>
                      <option data-value="<?= $c['plg_id'] ?>"><?= $c['plg_nama'] ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </datalist>

                <?php isset($p) && ($p !== "") ? $pelangganValue = $p : $pelangganValue = "" ?>
                <input class="form-control" list="pelanggan-<?= $t['tipe_transaksi_nama']; ?>" id="list-<?= $t['tipe_transaksi_nama'] ?>" value="<?= $pelangganValue ?>">
                <input type="hidden" name="plg_id" id="list-<?= $t['tipe_transaksi_nama'] ?>-hidden" value="">
                <?php $p = ""; ?>
              </div>
            </div>
            <?php if ($t['tipe_transaksi_id'] == 3) : ?>
              <div class="form-group">
                <label class="col-sm-3 control-label">Plat no</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="plg_platno" required>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($t['tipe_transaksi_id'] == 4) : ?>
              <div class="form-group">
                <label class="col-sm-3 control-label">Alamat </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="plg_alamat" required>
                </div>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label class="col-sm-3 control-label">No. Telp </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="plg_notelp" value="">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger btn-flat btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button type="submit" class="btn btn-primary btn-raised" aria-hidden="true">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- MODAL STATUS ORDER KITCHEN/WAITRESS/DONE -->
<div class="modal fade" id="modal_status_order" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="padding-bottom:0">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <div class="tab-slider">
          <div class="wrap">
            <ul class="nav nav-tabs" id="menus" role="tablist" id="example-tabs" data-tabs style="white-space: nowrap;">
              <li role="presentation" class="active"><a href="#status_kitchen" aria-controls="home" role="tab" data-toggle="tab">Kitchen</a></li>
              <li role="presentation"><a href="#status_waitress" aria-controls="home" role="tab" data-toggle="tab">Waitress</a></li>
              <li role="presentation"><a href="#status_done" aria-controls="home" role="tab" data-toggle="tab">Done</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-body" style="overflow-y:scroll; height:40rem">
        <div class="tabs-content" data-tabs-content="example-tabs">
          <div role="tabpanel" class="tab-pane active" id="status_kitchen">
          </div>
          <div role="tabpanel" class="tab-pane" id="status_waitress">
          </div>
          <div role="tabpanel" class="tab-pane" id="status_done">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL ADD VOUCHER DISCOUNT -->
<div class="modal fade" id="modal_add_voucher" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
      </div>
      <form class="form-horizontal" action="#" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Input Nomor Voucher</label>
            <div class="col-sm-8">
              <input type="hidden" name="id" id="voucher_id" class="voucher_discount form-control">
              <input type="text" name="title" id="voucher_input" class="voucher_discount form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Terms and Condition</label>
            <div class="col-sm-8">
              <textarea type="text" class="form-control" id="voucher_tandc"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a id="check_tandc" class="btn btn-primary btn-flat btn-raised">Check</a>
          <a href="#" id="buttonSubmitVoucher" class="add_voucher btn btn-primary btn-raised" data-dismiss="modal" aria-hidden="true">Gunakan</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL PEMBAYARAN -->
<?php
foreach ($payment as $k) :
  $k_id = $k['payment_id'];
  $k_nama = $k['payment_nama'];
  $k_rek = $k['payment_norek'];
  if (empty($k_rek)) :
    $type = 'hidden';
    $readonly = '';
    $grandTotalModal = '';
    $value = '';
  else :
    $type = 'text';
    $readonly = 'readonly';
    $value = '0';
    $grandTotalModal = 'grandTotalModal';
  endif;
?>
  <div class="modal fade" id="modal_bayar<?= $k_id ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Pembayaran</h3>
        </div>

        <?php ($trx) ? $url_id = $trx['trx_id'] : $url_id = $last_inv_number; ?>
        <form id="form_paid" action="<?= base_url('pos/pos/check_out/') . $url_id; ?>" method="post" target="_blank">
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label class="col-sm-4 control-label">No Transaksi</label>
                  <div class="col-sm-7">
                    <input type="hidden" name="voucher_id" class="potong_voucher_id">
                    <input type="hidden" name="discount_nominal" class="discountValModal">
                    <input type="text" name="trx_nomor" value="INV<?= str_pad(($url_id), 3, "0", STR_PAD_LEFT); ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="col-sm-4 control-label">Tipe Pembayaran</label>
                  <div class="col-sm-7">
                    <input type="text" value="<?= $k_nama; ?>" class="form-control trx_payment_source_<?= $k_id ?>" readonly>
                    <input type="hidden" name="trx_payment" class="form-control trx_payment" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label class="col-sm-4 control-label">Meja</label>
                  <div class="col-sm-7">
                    <input type="text" name="trx_meja" value="<?= $trx_prop['trx_tipe_nama']; ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="col-sm-4 control-label">Grand Total</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control grandTotalModal" readonly>
                    <input type="hidden" name="trx_grand_total" class="form-control trx_grand_total" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label class="col-sm-4 control-label">Bayar</label>
                  <div class="col-sm-7">
                    <input type="text" data-type="currency" class="form-control inputPembayaran trx_paid_source_<?= $k_id ?>">
                    <input type="hidden" name="trx_paid" data-type="currency" class="form-control trx_paid">
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="col-sm-4 control-label">Kembalian</label>
                  <div class="col-sm-7">
                    <input type="text" name="trx_change" class="form-control valueKembalian" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group" style="visibility:<?= $type ?>">
              <div class="row">
                <div class="col-md-6">
                  <label for="nomorKartu" class="col-sm-4 control-label">No.HP/Kartu</label>
                  <div class="col-sm-7">
                    <input type="<?= $type ?>" class="form-control trx_cardno_source_<?= $k_id ?>">
                    <input type="hidden" name="trx_cardno" class="form-control trx_cardno" id="nomorKartu">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="nomorReff" class="col-sm-4 control-label">Reff ID</label>
                  <div class="col-sm-7">
                    <input type="<?= $type ?>" class="form-control trx_payreff_source_<?= $k_id ?>">
                    <input type="hidden" name="trx_payreff" class="form-control trx_payreff" id="nomorReff">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label for="notes" class="col-sm-2 control-label">Notes</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="notes" style="border-color:darkgrey"></textarea>
                    <textarea name="trx_notes" class="form-control trx_notes" style="border-color:darkgrey;display:none"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-sm-12 text-center">
                    <?php if ($k['payment_qrcode']) : ?>
                      <img src="<?= base_url() . 'assets/img/' . $k['payment_qrcode']; ?>">
                    <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-sm-8"></div>
              <div class="col-sm-2">
                <div class="input-group-btn btn-raised">
                  <button type="button" class="btn btn-primary btn-flat btn-raised" tabindex="-1" data-toggle="dropdown" tabindex="-1" <?= $disabledBayar ?>>Split Bill</button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <?php
                    foreach ($payment as $split) :
                      $split_k_id = $split['payment_id'];
                      $split_k_nama = $split['payment_nama'];
                    ?>
                      <li><a href="#" class="splitBill" data-toggle="modal" data-target="#modal_bayar<?= $split_k_id ?>" data-dismiss="modal" data-payment="<?= $k_id ?>" aria-hidden="true" <?= $disabledBayar; ?>><?= $split_k_nama; ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
              <div class="col-sm-2">
                <?php (!$trx) && print('<a data-payment="' . $k_id . '" class="submitOrderToKitchen btn btn-success btn-raised"> Proses</a>'); ?>
                <?php ($trx) && print('<a data-payment="' . $k_id . '" class="paidAndPrintReceipt btn btn-success btn-raised"><span class="fa fa-print"></span> Print</a>') ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<script type="text/javascript" src="<?= base_url() . 'assets/js/jquery-3.4.1.min.js' ?>"></script>
<script type="text/javascript">
  /* GLOBAL VAR */
  var clearFormating = (value) => Number(value.val().replace(/[($)\s\._\-]+/g, ''))
  var assignFormatingValueToElement = (element, value) => element.val(Number(value).toLocaleString('id-ID'))
  var dividedByOneHundred = (value) => (value / 100)
  var data = JSON.parse('<?= json_encode($data) ?>')
  var ingredient = JSON.parse('<?= json_encode($ingredient) ?>')
  var taxResto = parseInt('<?= $taxresto ?>')
  var inventory = JSON.parse('<?= json_encode($inventory) ?>')
  var taxService = parseInt('<?= $taxservice ?>')

  /* CART API */
  // ************************************************
  // Shopping Cart API
  // ************************************************

  var shoppingCart = (function() {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];

    // Constructor
    function Item(name, price, count, notes, recipe) {
      this.name = name;
      this.price = price;
      this.count = count;
      this.notes = notes;
      this.recipe = recipe;
    }

    // Save cart
    function saveCart() {
      sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    // Load cart
    function loadCart() {
      cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
    }
    if (sessionStorage.getItem("shoppingCart") != null) {
      loadCart();
    }


    // =============================
    // Public methods and propeties
    // =============================
    var obj = {};

    // Add to cart
    obj.addItemToCart = function(name, price, count, notes, recipe) {
      for (var item in cart) {
        if (cart[item].name === name &&
          String(cart[item].notes) === String(notes)) {
          cart[item].count++;
          cart[item].recipe = recipe;
          for (const [key, value] of Object.entries(cart[item].recipe)) {
            value[1] *= cart[item].count;
          }
          saveCart();
          return;
        }
      }
      var item = new Item(name, price, count, notes, recipe);
      cart.push(item);
      saveCart();
    }

    // Remove item from cart
    obj.removeItemFromCart = function(name, notes, recipe) {
      for (var item in cart) {
        if (cart[item].name === name &&
          String(cart[item].notes) === String(notes)) {
          cart[item].count--;
          cart[item].recipe = recipe;
          for (const [key, value] of Object.entries(cart[item].recipe)) {
            value[1] *= cart[item].count;
          }
          if (cart[item].count === 0) {
            cart.splice(item, 1);
          }
          break;
        }
      }
      saveCart();
    }

    // Remove all items from cart
    obj.removeItemFromCartAll = function(name, notes) {
      for (var item in cart) {
        if (cart[item].name === name &&
          String(cart[item].notes) === String(notes)) {
          cart.splice(item, 1);
          break;
        }
      }
      saveCart();
    }

    // Clear cart
    obj.clearCart = function() {
      cart = [];
      saveCart();
    }

    // Total cart
    obj.totalCart = function() {
      var totalCart = 0;
      for (var item in cart) {
        totalCart += cart[item].price * cart[item].count;
      }
      return Number(totalCart.toFixed(2));
    }

    // List cart
    obj.listCart = function() {
      var cartCopy = [];
      for (i in cart) {
        item = cart[i];
        itemCopy = {};
        for (p in item) {
          itemCopy[p] = item[p];

        }
        itemCopy.total = Number(item.price * item.count).toFixed(2);
        cartCopy.push(itemCopy)
      }
      return cartCopy;
    }

    return obj;
  })();


  // *****************************************
  // Triggers / Events
  // ***************************************** 
  // Add item
  $('.add_cart').click(function(event) {
    event.preventDefault();
    var id = $(this).data('itemid')
    var name = $(this).data('itemnama');
    var price = Number($(this).data('itemharga'));
    var notes = $('#notes_pesanan' + $(this).data("itemid")).val();

    var recipe = {
      ...ingredient
      .filter(ing => ing.ing_menu_id == id)
      .reduce((nm, currnm) => {
        nm[currnm.ing_inv_id] = (currnm.ing_qty * currnm.satuan_val);
        return nm
      }, {})
    }

    if (isEmptyObj(recipe)) {
      var msg = `<div class="alert alert-warning animate">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      Belum Buat Stock</div>`
      $('.msg').html(msg);
      setTimeout(() => {
        $('.msg').html('');
      }, 3000)
      return true;
    }
    if (isStockZero(recipe)) {
      var nullRecipe = isStockZero(recipe)
      var msg = `<div class="alert alert-warning animate">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      Stock Bahan `
      nullRecipe.forEach(r => msg += `<strong>${r.stock_nama}, </strong>`)
      msg += ` Habis</div>`

      $('.msg').html(msg);
      setTimeout(() => {
        $('.msg').html('');
      }, 3000)
      return true;
    }
    shoppingCart.addItemToCart(name, price, 1, notes, recipe)
    displayCart()
  });

  var isEmptyObj = Obj => {
    return ((Object.keys(Obj).length == 0) ? true : false)
  }

  var isStockZero = Obj => {
    let nullInventory =
      inventory.filter(inv => (Object.keys(Obj)
        .includes(inv.stock_id)) && parseInt(inv.stock_qty) === 0)

    return ((nullInventory.length > 0) ? nullInventory : false)
  }

  function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    var subTotal = 0;
    for (var i in cartArray) {
      subTotal += Number(cartArray[i].total)
      output +=
        `<tr>
        <td> ${cartArray[i].name} - ${cartArray[i].notes} </td>
        <td> ${Number(cartArray[i].price)} </td>
        <td class="text-right"><a class="btn-icon-toggle plus-item pull-right"
        data-notes="${cartArray[i].notes}" data-name="${cartArray[i].name}"><span class="fa fa-plus"</span></a> </td>
        <td class="text-center">${cartArray[i].count}</td>
        <td class="text-left"><a class="btn-icon-toggle minus-item pull-left"
        data-notes="${cartArray[i].notes}" data-name="${cartArray[i].name}">
        <span class="fa fa-minus"></span></a></td>
        <td> ${Number(cartArray[i].total)} </td>
        <td class="text-right">
        <a href="#" class="text-danger btn btn-icon-toggle btn-raised delete-item"
        id="c.rowid" title="hapus pesanan" data-notes="${cartArray[i].notes}" data-name="${cartArray[i].name}">
        <i class="fa fa-trash"></i></a>
        </td>
        <tr>`;
    }

    totalTaxResto = (subTotal * dividedByOneHundred(taxResto));
    totalServiceCharge = (subTotal * dividedByOneHundred(taxService));
    assignFormatingValueToElement($('#subTotal'), subTotal);
    assignFormatingValueToElement($('#totalService'), totalServiceCharge);
    assignFormatingValueToElement($('#totalPph'), totalTaxResto);
    $('#show_cart').html(output);
  }

  // Delete item button
  $('#show_cart').on("click", ".delete-item", function(event) {
    var name = $(this).data('name')
    var notes = $(this).data('notes')
    shoppingCart.removeItemFromCartAll(name, notes);
    displayCart();
  })

  // -1
  $('#show_cart').on("click", ".minus-item", function(event) {
    var name = $(this).data('name')
    var notes = $(this).data('notes')
    var recipe = {
      ...ingredient
      .filter(ing => ing.menu_nama == name)
      .reduce((nm, currnm) => {
        nm[currnm.ing_inv_id] = (currnm.ing_qty * currnm.satuan_val);
        return nm
      }, {})
    }
    shoppingCart.removeItemFromCart(name, notes, recipe);
    displayCart();
  })
  // +1
  $('#show_cart').on("click", ".plus-item", function(event) {
    var name = $(this).data('name')
    var notes = $(this).data('notes')
    var recipe = {
      ...ingredient
      .filter(ing => ing.menu_nama == name)
      .reduce((nm, currnm) => {
        nm[currnm.ing_inv_id] = (currnm.ing_qty * currnm.satuan_val);
        return nm
      }, {})
    }
    shoppingCart.addItemToCart(name, '', '', notes, recipe);
    displayCart();
  })
  displayCart();



  /* EVENT LISTENER */
  $('#check_tandc').click(function() {
    $('#buttonSubmitVoucher').prop('disabled', true);
    checkTermsAndConditionVoucher();
  })
  $(".add_voucher").click(function() {
    useDiscountVoucher();
  })
  $("#percentageDiscount").keyup(function() {
    calculateDiscount($(this).val());
    calculateGrandTotal();
  })
  $("#discount").keyup(function() {
    $('#percentageDiscount').val(0);
    assignValToPrintBillUrl(clearFormating($(this)));
    calculateGrandTotal();
  })
  $(document).on('click', '.hapus_cart', function() {
    let row_id = $(this).attr("id");
    hapusCart(row_id);
  })
  $(".paidAndPrintReceipt").click(function() {
    let id = $(this).data("payment");
    addInputToHiddenInputField(id);
    paidAndPrintReceipt();
  })
  $(".submitOrderToKitchen").click(function() {
    let id = $(this).data("payment");
    addInputToHiddenInputField(id);
    submitOrderToKitchen();
  })
  $(".splitBill").click(function() {
    let id = $(this).data("payment");
    addInputToHiddenInputField(id);
    getSisaPaymentSplitBill();
  })
  $('.inputPembayaran').keyup(function() {
    inputPembayaran(clearFormating($(this)));
  })
  $('#getStatusPemesananPelanggan').click(function() {
    getStatusPemesananPelanggan()
  })
  $('.modalPembayaran').click(function() {
    modalPembayaran();
  })
</script>


<!-- SCRIPT MODAL TAMBAH PELANGAN -->
<script type="text/javascript">
  var divs = document.querySelectorAll('input[list]');
  for (let i = 0; i < divs.length; i++) {
    divs[i].addEventListener('input', function(e) {
      let input = e.target,
        list = input.getAttribute('list'),
        options = document.querySelectorAll('#' + list + ' option'),
        hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
        label = input.value;
      hiddenInput.value = label;

      for (let i = 0; i < options.length; i++) {
        let option = options[i];

        if (option.innerText === label) {
          hiddenInput.value = option.getAttribute('data-value');
          break;
        }
      }
    });
  };
</script>


<!-- VOUCHER SCRIPT -->
<script type="text/javascript">
  var checkTermsAndConditionVoucher = () => {
    $('#voucher_tandc').val('');
    $("#voucher_id").val('');
    let kodeDiskon = $('#voucher_input').val();
    $.ajax({
      url: '<?= base_url(); ?>pos/pos/voucherTermsAndCondition',
      method: "POST",
      data: {
        kodeDiskon: kodeDiskon,
      },
      dataType: 'json',
      success: function(data) {
        let terms = data[0].voucher_syarat;
        let id = data[0].voucher_id;
        $('#voucher_tandc').val(terms);
        $("#voucher_id").val(id);
        $('#buttonSubmitVoucher').prop('disabled', false);
      },
      error: function(data) {
        $('#buttonSubmitVoucher').prop('disabled', true);
      }
    });
  }
  var useDiscountVoucher = () => {
    var id = $("#voucher_id").val();
    $.ajax({
      url: '<?= base_url(); ?>pos/pos/voucherApplied',
      method: "POST",
      data: {
        id: id,
      },
      dataType: 'json',
      success: function(data) {
        let isPercentage = data.voucher_discount;
        assignFormatingValueToElement($("#percentageDiscount"), data.voucher_discount);
        assignFormatingValueToElement($("#discount"), data.voucher_nominal);
        (isPercentage > 0) && calculateDiscount(data.voucher_discount); //Hitung nominal dari persentase diskon
        $(".potong_voucher_id").val(data.voucher_id);
        calculateGrandTotal();
      }
    });
  }
</script>


<!-- CRUD CART SCRIPT -->
<!-- <script type="text/javascript">
  var addItemsToCart = (items) => {
    $.ajax({
      url: "?= base_url(); ?>pos/pos/check_stock",
      method: "POST",
      data: items,
      dataType: 'json',
      success: function(data) {
        (data.type == 'error') ? alert(data.message): printTableCart(data);
      },
      error: function() {
        console.log('error')
      }
    });
  }
  var hapusCart = (row_id) => {
    $.ajax({
      url: "?= base_url(); ?>pos/pos/hapus_cart",
      method: "POST",
      data: {
        row_id: row_id,
      },
      dataType: 'json',
      success: function(data) {
        printTableCart(data);
      }
    });
  }
</script> -->


<!-- CALCULATE PEMBAYARAN PELANGGAN -->
<script type="text/javascript">
  var addInputToHiddenInputField = (id) => {
    let srcPayment = $('.trx_payment_source_' + id).val();
    var srcPaid = clearFormating($('.trx_paid_source_' + id));
    let srcCardno = $('.trx_cardno_source_' + id).val();
    let srcPayreff = $('.trx_payreff_source_' + id).val();
    let destPayment = $('.trx_payment').val();
    let destPaid = clearFormating($('.trx_paid')) + srcPaid;
    let destCardno = $('.trx_cardno').val();
    let destPayreff = $('.trx_payreff').val();
    let paymentTypeInput = destPayment ? destPayment + ',' + srcPayment : srcPayment;
    let cardnoInput = destCardno ? destCardno + ',' + srcCardno : srcCardno;
    let payreffInput = destPayreff ? destPayreff + ',' + srcPayreff : srcPayreff;
    $('.trx_payment').val(paymentTypeInput);
    assignFormatingValueToElement($('.trx_paid'), destPaid);
    $('.trx_cardno').val(cardnoInput);
    $('.trx_payreff').val(payreffInput);
  }

  var calculateDiscount = (percentage) => {
    assignFormatingValueToElement($("#percentageDiscount"), percentage);
    let subTotal = clearFormating($("#subTotal"));
    let discount = (dividedByOneHundred(percentage) * subTotal);
    assignFormatingValueToElement($("#discount"), discount);
    assignValToPrintBillUrl(discount);
  }

  var calculateGrandTotal = () => {
    let discount = clearFormating($("#discount"));
    let subTotal = clearFormating($("#subTotal"));
    let totalPph = clearFormating($("#totalPph"));
    let totalService = clearFormating($("#totalService"));
    let grandTotal = subTotal - discount + totalPph + totalService;
    assignFormatingValueToElement($("#grandTotal"), grandTotal);
    assignFormatingValueToElement($(".trx_grand_total"), grandTotal);
    assignFormatingValueToElement($(".grandTotalModal"), grandTotal);
  }

  var inputPembayaran = (valuePembayaran) => {
    let grandTotalModal = clearFormating($(".grandTotalModal"));
    let kembalian = valuePembayaran - grandTotalModal;
    assignFormatingValueToElement($(".valueKembalian"), kembalian);
  }
</script>


<!-- SCRIPT SPLIT BILL -->
<script type="text/javascript">
  var getSisaPaymentSplitBill = () => {
    let sisaPembayaranAwal = clearFormating($(".valueKembalian"));
    assignFormatingValueToElement($(".grandTotalModal"), sisaPembayaranAwal);
  }
</script>


<!-- SCRIPT PRINT PEMBAYARAN -->
<script type="text/javascript">
  var modalPembayaran = () => {
    let grandTotal = clearFormating($('#grandTotal'));
    let nominalDiscount = clearFormating($('#discount'));
    assignFormatingValueToElement($(".trx_grand_total"), grandTotal);
    assignFormatingValueToElement($(".grandTotalModal"), grandTotal);
    assignFormatingValueToElement($(".discountValModal"), grandTotal);
  }
  var assignValToPrintBillUrl = (discount) => {
    let url = "<?php echo base_url('pos/pos/printBill/') . $trx_prop['plg_id'] . '/'; ?>";
    let targetUrl = url + discount;
    $("#printBill").attr("href", targetUrl);
  }
  var paidAndPrintReceipt = () => {
    let formPaid = $('#form_paid');
    formPaid.submit(function(e) {
      fetch_page('<?= base_url('pos/pos') ?>')
    });
    formPaid.submit();
  }
</script>


<!-- MODAL PROSES PEMESANAN KE DAPUR SAAT METODE PAY FIRST -->
<script type="text/javascript">
  var submitOrderToKitchen = () => {
    let data = {
      discount: clearFormating($("#discount")),
      subtotal: clearFormating($("#subTotal")),
      totalpph: clearFormating($("#totalPph")),
      totalservice: clearFormating($("#totalService")),
      grandtotal: clearFormating($("#grandTotal")),
      trx_tipe: $('#trx_tipe').val(),
      pay_first: 'Y'
    }
    $.ajax({
      url: '<?php echo base_url() . "pos/pos/proses_kitchen/" . $trx_prop['plg_id'] . '/' . $trx_prop['trx_tipe_nama'];  ?>',
      method: 'POST',
      data: data,
      dataType: "json",
      success: function() {
        paidAndPrintReceipt();
      },
    });
  }
</script>


<!-- FUNCTION UNTUK SCROL KATEGORI LEFT OR RIGHT -->
<script type="text/javascript">
  var menus = $("#menus"),
    menuWidth = menus.parent().outerWidth();
  var menupage = Math.ceil(menus[0].scrollWidth / menuWidth),
    currPage = 1;
  if (menupage > 1) {
    $('#goPrev').click(function() {
      $('.wrap').animate({
        scrollLeft: '-=100'
      }, 200);
    });

    $('#goNext').click(function() {
      $('.wrap').animate({
        scrollLeft: '+=100'
      }, 200);
    });
    $(window).on("resize", function() {
      menuWidth = menus.parent().outerWidth();
      menupage = Math.ceil(menus[0].scrollWidth / menuWidth);
      currPage = Math.ceil(-parseInt(menus.css("left")) / menuWidth) + 1;
    });
  }
</script>

<script type="text/javascript">
  $(function() {

    const reloadMobileOrder = () => {
      $.ajax({
        url: '<?php echo base_url() . "pos/pos/getTransaksiMobile/";  ?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          let notification = data['mobile_app_order_head'].length;
          (notification != 0) &&
          $('#mobile-order-notification').html(notification);
          printMobileOrder(data);
        },
      });
    }
    reloadMobileOrder();
  })
</script>


<script type="text/javascript">
  // var printTableCart = (data) => {
  //   let grandTotal = 0;
  //   let totalTaxResto = 0;
  //   let totalServiceCharge = 0;
  //   let output = '';
  //   let cart = Object.values(data['cart']);

  //   cart.forEach(c => {
  //     grandTotal += c.subtotal;
  //     output += `<tr>
  //       <td> ${c.name} - ${c.options.notes} </td>
  //       <td> ${c.price} </td>
  //       <td> ${c.qty} </td>
  //       <td> ${c.subtotal} </td>
  //       <td class="text-right">
  //       <a href="#" class="hapus_cart text-danger btn btn-icon-toggle btn-raised"
  //       id="${c.rowid}" title="hapus pesanan">
  //       <i class="fa fa-trash"></i></a>
  //       </td>
  //       <tr>`;
  //   })
  //   totalTaxResto = (grandTotal * dividedByOneHundred(data['taxresto']));
  //   totalServiceCharge = (grandTotal * dividedByOneHundred(data['taxservice']));
  //   assignFormatingValueToElement($('#subTotal'), grandTotal);
  //   assignFormatingValueToElement($('#totalService'), totalServiceCharge);
  //   assignFormatingValueToElement($('#totalPph'), totalTaxResto);
  //   $('#show_cart').html(output);
  //   calculateGrandTotal();
  // }
</script>

<!-- MODAL CEK STATUS PESANAN PELANGGAN -->
<script type="text/javascript">
  var getStatusPemesananPelanggan = () => {
    $.ajax({
      type: 'GET',
      url: '<?php echo base_url() . "pos/kitchen/getDataTrx" ?>',
      dataType: 'json',
      success: function(data) {
        let card = '';
        let table = data['table'];
        let order = data['order'];
        table.forEach(t => {
          card += `<div class="col-md-3">
            <div class="card">
            <div class="card-head style-gray">
            <h3  class="text-center text-light"> ${t.trx_table} </h3></div>
            <div class="card-body">`;
          order.forEach(o => {
            if ((t.trx_id) === (o.order_trx_reff) &&
              (t.order_date) === (o.order_date)) {
              card += `<div class="clearfix">
                <div class="pull-left"> ${o.order_menu} ( ${o.order_qty} )</div></div>`;
              card += ((o.order_notes)) ? `<div class="clearfix"><div class="pull-left"> - ${o.order_notes} </div></div>` : '';
            }
          })
          card += `<br/><div class="timeShow text-center"> ${t.order_date} </div><br/>
            </div></div></div>`;

          (t.order_kitchen_flg == 'N') && $('#status_kitchen').html(card);
          ((t.order_kitchen_flg == 'Y') && (t.order_waitress_flg == 'N')) &&
          $('#status_waitress').html(card);
          ((t.order_kitchen_flg == 'Y') && (t.order_waitress_flg == 'Y')) &&
          $('#status_done').html(card);
        })
      }
    });
  }
</script>


<!-- MODAL TRANSAKSI MASUK DARI MOBILE -->
<script type="text/javascript">
  var printMobileOrder = (data) => {
    let url = '<?php echo base_url(); ?>pos/pos/';
    let card = '';
    let dataHead = data['mobile_app_order_head'];
    let dataDescrip = data['mobile_app_order'];
    dataHead.forEach(dH => {
      let no = 1;
      if (dH.order_trx_tipe === '1') {
        card += `<form role="form" method="post" class="" action="${url}">
          <div class="col-md-3">
          <div class="card">`;
        (dH.order_payment_id) && (card += `<div class="card-head style-success">`);
        (!dH.order_payment_id) && (card += `<div class="card-head style-gray">`);
        card += `<h3 class="text-center text-light">Dine In - ${dH.meja_nama} </h3>
          </div>
          <div class="card-body no-padding card-type-pricing">
          <ul class="list-unstyled">
          <li>
          <div class="clearfix">
          <div class="pull-left">Nama :</div>
          <div class="pull-right"> ${dH.order_username} </div>
          </div>
          </li>
          <li>
          <div class="clearfix">
          <div class="pull-left">Area :</div>
          <div class="pull-right"> ${dH.area_nama} </div>
          </div>
          </li>
          <li>
          <div class="clearfix">
          <div class="pull-left">Lantai :</div>
          <div class="pull-right"> ${dH.area_level} </div>
          </div>
          </li>`;
        if (dH.order_payment_id) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">Pembayaran : </div>
            <div class="pull-right"> ${dH.order_payment_nama} </div>
            </div>
            </li>`;
        }
        if (dH.order_nomor_kartu) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">No Kartu : </div>
            <div class="pull-right"> ${dH.order_nomor_kartu} </div>
            </div>
            </li>`;
        }
        if (dH.order_nomor_reff) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">No Reff : </div>
            <div class="pull-right"> ${dH.order_nomor_reff} </div>
            </div>
            </li>`;
        }
        if (dH.order_voucher_id) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">Voucher : </div>
            <div class="pull-right"> ${dH.voucher_kode} </div>
            </div>
            </li>`;
        }
        card += `</ul>
          </div>
          <div class="card-body no-padding card-type-pricing">
          <input type="hidden" name="meja_id" value="${dH.meja_id}">
          <input type="hidden" name="plg_id" value="${dH.order_userid}">
          <div class="card-body text-center">
          <button class="btn btn-primary btn-raised" type="submit">Proses</button>
          <a href="${url}batalkan_pemesanan_mobile/${dH.order_table}"
          onclick="return confirm(Apakah anda yakin?)" class="btn btn-flat text-danger btn-raised">Decline</a>
          </div>
          </div>
          </div>
          </div>
          </form>`;
      } else {
        card += `<form role="form" method="post" action="${url}">
          <div class="col-md-3">
          <div class="card">`;
        (dH.order_payment_id) && (card += `<div class="card-head style-success">`);
        (!dH.order_payment_id) && (card += `<div class="card-head style-gray">`);
        card += `<h3 class="text-center text-light">`;
        ((dH.order_alamat) && (card += `Delivery - ${dH.order_username}`));
        ((dH.order_platno) && (card += `Car - ${dH.order_table}`));
        ((!dH.order_alamat && !dH.order_platno) && (card += `Take Away- ${dH.order_username}`));
        card += `</h3>
          </div>
          <div class="card-body no-padding card-type-pricing">
          <ul class="list-unstyled">
          <li>
          <div class="clearfix">
          <div class="pull-left">Nama :</div>
          <div class="pull-right"> ${dH.order_username} </div>
          </div>
          </li>`;
        if (dH.order_payment_id) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">Pembayaran : </div>
            <div class="pull-right"> ${dH.order_payment_nama} </div>
            </div>
            </li>`;
        }
        if (dH.order_nomor_kartu) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">No Kartu : </div>
            <div class="pull-right"> ${dH.order_nomor_kartu} </div>
            </div>
            </li>`;
        }
        if (dH.order_nomor_reff) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">No Reff : </div>
            <div class="pull-right"> ${dH.order_nomor_reff} </div>
            </div>
            </li>`;
        }
        if (dH.order_voucher_id) {
          card += `<li>
            <div class="clearfix">
            <div class="pull-left">Voucher : </div>
            <div class="pull-right"> ${dH.voucher_kode} </div>
            </div>
            </li>`;
        }
        card += `</ul>
          </div>
          <div class="card-body no-padding card-type-pricing">
          <input type="hidden" name="plg_id" value="${dH.order_userid}">`;
        ((dH.data_alamat) && (card += `<input type="hidden" name="plg_alamat" value="${dH.order_alamat}">`));
        ((dH.data_platno) && (card += `<input type="hidden" name="plg_platno" value="${dH.order_platno}">`));
        card += `<div class="card-body text-center">
          <button class="btn btn-primary btn-raised" type="submit">Proses</button>
          <a href="${url}batalkan_pemesanan_mobile/${dH.order_userid}"
          onclick="return confirm(Apakah anda yakin?)" class="btn btn-flat btn-raised text-danger">Decline</a>
          </div>
          </div>
          </div>
          </div>
          </form>`;
      }
    })
    $("#targetMobileOrder").html(card);
  }

  var form = document.querySelectorAll('form')
  Array.from(form).forEach(form => {
    form.addEventListener('submit', function(el) {
      el.preventDefault()
      var form = $(this)
      var url = el.target.action
      var data = new FormData(form[0])

      fetch_page(url, el.target.method, data)
    })
  })
</script>
</div>
</div>
</body>

</html>