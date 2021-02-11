<img id="loading-screen" src="<?= base_url('assets/img/loading.svg'); ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%; z-index: 1001;" />
<!-- BEGIN BASE-->
<div id="base" style="display:none;">
  <div class="offcanvas"></div>
  <div id="content">

    <section>
      <div class="section-header">
        <h2><span class="fa fa-cutlery"></span> Point of Sale</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>
      <section class="style-default no-padding no-margin">

        <div class="container-fluid no-padding">
          <div class="col-md-5 col-xs-12 col-sm-6" style="padding-left:0px; ">
            <div class="card">
              <div class="card-body" style="overflow-y:scroll; height:77vh">
                <div class="row">
                  <div class="pull-left">
                    <div class="input-group-btn btn-raised">
                      <button type="button" class="btn cust-group-btn-left cust-group-btn-right btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1">
                        Order <i class="fa fa-caret-down"></i>
                      </button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <?php foreach ($tipe_transaksi as $t) : ?>
                          <li><a href="#" data-toggle="modal" data-target="#modal_<?= $t['tipe_transaksi_id'] ?>"><?= $t['tipe_transaksi_nama']; ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                  &nbsp;
                  <a id="getTransaksiMobile" onclick="reloadMobileOrder();" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_view_cust_order">Customer &nbsp;
                    <sup id="mobile-order-notification" class="badge style-danger"></sup></a>
                  <a class="btn btn-primary btn-raised" onclick="window.open('<?= base_url('pos/pos/status_order') ?>', '_blank');" href="#">Status</a>
                </div>

                <div class="pull-right">
                  <h4><?= strtoupper($trx_prop['trx_tipe']) . ' - ' .  (isset($trx_prop['trx_tipe_nama']) ? strtoupper($trx_prop['trx_tipe_nama']) . '' : ''); ?></h4>
                </div>
                <?php if (isset($trx_prop['plg_id']) && isset($trx_prop['trx_tipe_nama'])) :
                  $plg_id = $trx_prop['plg_id'];
                  $nama_tipe_trx = $trx_prop['trx_tipe_nama'];
                endif;
                ?>
                <form role="form" id="order_form" method="post" action="<?= base_url("pos/pos/proses_kitchen/$plg_id/$nama_tipe_trx"); ?>">

                  <table class="table no-margin no-padding table-responsive">
                    <div class="caption">
                      <thead>
                        <tr>
                          <th>Menu</th>
                          <th>Harga</th>
                          <th>Qty</th>
                          <th>Jumlah</th>
                          <th class="text-right">Action</th>
                        </tr>
                      </thead>
                      <tbody id="detail_cart">
                        <?php
                        $valueSubTotal = 0;
                        foreach ($cart as $c) :
                        ?>
                          <?php $disabledDeletion = ''; ?>
                          <?php if (isset($c['options']['flg_cancel'])) : ?>
                            <?php (($c['options']['flg_cancel'] == 'N') && isset($trx['trx_payment']) ? $disabledDeletion = 'disabled' : $disabledDeletion = '') ?>
                          <?php endif; ?>
                          <tr>
                            <td><?= $c['name'] . ' - ' . $c['options']['notes']; ?></td>
                            <td><?= $c['price']; ?></td>
                            <td><?= $c['qty']; ?></td>
                            <td><?= $c['subtotal']; ?></td>
                            <td class="text-right">
                              <a href="#" class="hapus_cart btn text-danger btn-icon-toggle btn-raised" id="<?= $c['rowid']; ?>" title="hapus pesanan" <?= @$disabledDeletion ?>>
                                <i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php
                          $valueSubTotal += $c['subtotal'];
                        endforeach; ?>
                      </tbody>
                      </tfoot>
                      <tr>
                        <th style="text-align:left;" colspan="3">Sub Total</th>
                        <th style="text-align:center;" colspan="2"><input class="form-control" id="subTotal" name="subtotal" value="<?= number_format($valueSubTotal, 0, '', '.'); ?>" readonly></th>
                      </tr>
                      <div class="form-group">
                        <tr>
                          <?php (isset($discount)) ? $valueDiscount = (int)$discount : $valueDiscount = 0; ?>
                          <th style="text-align:left;" colspan="3">Discount
                            <input type="text" style="width: 55px;height: 10px;padding:10px;" id="percentageDiscount" name="discount" autocomplete="off"> %
                          </th>
                          <th style="text-align:center;">
                            <input type="text" class="form-control " id="discount" name="discount" value="<?= number_format(@$discount, 0, '', '.'); ?> " data-type="currency">
                          </th>
                          <th class="no-padding no-margin">
                            <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_add_voucher" style="border:solid; border-width:1px; border-color:#08867e">Add</a>
                          </th>
                        </tr>
                      </div>
                      <div class="form-group">
                        <tr>
                          <?php $valueServiceCharge = ($valueSubTotal * $taxservice / 100); ?>
                          <th style="text-align:left;" colspan="3">Service Charge (<?= $taxservice ?>%)
                          <th style="text-align:center;" colspan="2">
                            <input class="form-control" id="totalService" name="totalservice" value="<?= number_format($valueServiceCharge, 0, '', '.'); ?>" readonly>
                          </th>
                        </tr>
                      </div>
                      <div class="form-group">
                        <tr>
                          <?php $valuePpn = ($valueSubTotal * $taxresto / 100); ?>
                          <th style="text-align:left;" colspan="3">Pajak Resto (<?= $taxresto ?>%)
                          <th style="text-align:center;" colspan="2">
                            <input class="form-control" id="totalPph" name="totalpph" value="<?= number_format($valuePpn, 0, '', '.'); ?>" readonly>
                          </th>
                        </tr>
                      </div>
                      <div class="form-group">
                        <?php $valueGrandTotal = $valueSubTotal - ($valueDiscount) + $valueServiceCharge + $valuePpn ?>
                        <tr>
                          <th style="text-align:left;" colspan="3">Grand Total</th>
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
                  <div class="card-body no-padding">
                    <?php $trx_prop['trx_tipe_nama'] == "" ? $disabled = 'disabled' : $disabled = ''; ?>
                    <?php $trx_prop['trx_tipe_nama'] !== "" && isset($trx) ? $disabledBayar = '' : $disabledBayar = 'disabled'; ?>

                    <button type="submit" style="text-align:left;" type="submit" class="btn btn-primary btn-raised" <?= $disabled; ?>>Proses</button>
                    <a class="btn btn-primary btn-raised" href="<?= base_url("pos/pos/printBill/$plg_id"); ?>" id="printBill" <?= $disabledBayar; ?> target="_blank">Print Bill</a>

                    <div class="pull-right">
                      <div class="input-group-btn btn-raised">
                        <?php if (isset($trx[0]['order_payment_id'])) : ?>
                          <button type="button" class="btn btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1" <?= $disabledBayar; ?>>
                            <?= $trx[0]['order_payment_nama'] ?> <i class="fa fa-caret-up"></i>
                          </button>
                        <?php elseif (isset($trx['trx_payment'])) : ?>
                          <button type="button" class="btn btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1" <?= $disabledBayar; ?>>
                            <?= $trx['trx_payment'] ?> <i class="fa fa-caret-up"></i>
                          </button>
                        <?php else : ?>
                          <button type="button" class="btn btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1" <?= $disabledBayar; ?>>
                            Bayar <i class="fa fa-caret-up"></i>
                          </button>
                        <?php endif; ?>

                        <ul class="dropdown-menu pull-right" role="menu">
                          <?php if (isset($trx[0]['order_payment_id'])) : ?>
                            <?php foreach ($payment as $k) :
                              $k_id = $k['payment_id'];
                              $k_nama = $k['payment_nama'];
                            ?>
                              <?php if ($k_id == $trx[0]['order_payment_id']) : ?>
                                <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran" style="color:#0aa89e" <?= $disabledBayar; ?>><?= $k_nama; ?></a></li>
                              <?php else : ?>
                                <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran" <?= $disabledBayar; ?>><?= $k_nama; ?></a></li>
                              <?php endif; ?>
                            <?php endforeach; ?>

                          <?php elseif (isset($trx['trx_payment'])) : ?>
                            <?php foreach ($payment as $k) :
                              $k_id = $k['payment_id'];
                              $k_nama = $k['payment_nama'];
                            ?>
                              <?php if ($k_nama == $trx['trx_payment']) : ?>
                                <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran" style="color:#0aa89e" <?= $disabledBayar; ?>><?= $k_nama; ?></a></li>
                              <?php else : ?>
                                <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran" <?= $disabledBayar; ?>><?= $k_nama; ?></a></li>
                              <?php endif; ?>
                            <?php endforeach; ?>

                          <?php else : ?>
                            <?php foreach ($payment as $k) :
                              $k_id = $k['payment_id'];
                              $k_nama = $k['payment_nama'];
                            ?>
                              <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran" <?= $disabledBayar; ?>><?= $k_nama; ?></a></li>
                            <?php endforeach; ?>
                          <?php endif; ?>

                          <?php if (@$trx_prop['plg_telp'] != '') : ?>
                            <?php
                            $phone = substr($trx_prop['plg_telp'], 1);
                            ?>
                            <li><a href="https://web.whatsapp.com/send?phone=62<?= $phone; ?>" target="_blank" class="modalPembayaran" <?= $disabledBayar; ?>>Whatsapp</a></li>
                          <?php endif; ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-7 col-xs-12 col-sm-6" style="padding-right:0px;">
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
                  <?php foreach ($data as $index => $table_content) :
                    $menu_gambar = $table_content['menu_gambar'];
                  ?>
                    <div class="col-md-4 col-lg-3 col-sm-6">
                      <?php $trx_prop['trx_tipe'] == "" ? $disabled = 'disabled' : $disabled = ''; ?>
                      <div class="no-padding card thumbnail btn" style="box-shadow: 1px 1px 4px 1px rgba(0, 0, 0, 0.33)" <?= $disabled; ?>>
                        <a data-toggle="modal" data-target="#option_menu<?= $table_content['menu_id'] ?>">
                          <td>
                            <img loading="lazy" style="width:auto;height:12rem;border-radius:4px" class="width-1 img-responsive rounded" src="<?= base_url("assets/gambar/${menu_gambar}"); ?>" alt="" />
                          </td>
                          <div class="caption text-left no-padding">
                            <h5 class="text-light">&nbsp;<?= $table_content['menu_nama']; ?></h5>
                            <div>
                              <h5 class="text-light">
                                <strong>&nbsp;<?= number_format($table_content['menu_harga_baru']); ?></strong>
                              </h5>
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
                <?php foreach ($kategori_makanan as $index => $table_content) :
                  $menu_gambar = $table_content['menu_gambar'];
                ?>
                  <?php if (($table_content['kategori_id'] == $tab['kategori_id']) && $table_content['menu_nama'] != '') : ?>
                    <div class="col-md-4 col-lg-3 col-sm-6">
                      <?php $trx_prop['trx_tipe'] == "" ? $disabled = 'disabled' : $disabled = ''; ?>
                      <div class="no-padding card thumbnail btn" style="box-shadow: 1px 1px 4px 1px rgba(0, 0, 0, 0.33)" <?= $disabled; ?>>
                        <a data-toggle="modal" data-target="#option_menu<?= $table_content['menu_id'] ?>">
                          <td>
                            <img loading="lazy" style="width:auto;height:12rem;border-radius:4px" class="width-1 img-responsive rounded" src="<?= base_url("assets/gambar/${menu_gambar}"); ?>" alt="" />
                          </td>
                          <div class="caption text-left no-padding">
                            <h5 class="text-light">&nbsp;<?= $table_content['menu_nama']; ?></h5>
                            <h5 class="text-light">
                              <strong>&nbsp;<?= number_format($table_content['menu_harga_baru']); ?></strong>
                            </h5>

                          </div>
                        </a>
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

              <?php $style = "style-default"; ?>
              <?php $status = "" ?>
              <?php $prev_status = '' ?>

              <?php if ($row['meja_pelanggan']) : ?>
                <?php $style = "style-accent"; ?>
                <?php $status = " - (Kasir)"; ?>
              <?php endif; ?>

              <?php foreach ($all_order as $o) : ?>
                <?php
                if ((($row['plg_order'] == $o['order_trx_reff']) &&
                    (($o['order_kitchen_flg'] == 'N') &&
                      ($o['order_waitress_flg'] == 'N'))) &&
                  ($prev_status == '')
                ) : ?>
                  <?php $style = "style-danger"; ?>
                  <?php $status = " - (Cooking)"; ?>
                  <?php $prev_status = $status; ?>
                <?php
                elseif ((($row['plg_order'] == $o['order_trx_reff']) &&
                    (($o['order_kitchen_flg'] == 'Y') &&
                      ($o['order_waitress_flg'] == 'N'))) &&
                  ($prev_status == '')
                ) : ?>
                  <?php $style = "style-warning"; ?>
                  <?php $status = " - (preparing)"; ?>
                  <?php $prev_status = $status; ?>
                <?php
                elseif ((($row['plg_order'] == $o['order_trx_reff']) &&
                    (($o['order_kitchen_flg'] == 'Y') &&
                      ($o['order_waitress_flg'] == 'Y'))) &&
                  ($prev_status == '')
                ) : ?>
                  <?php $style = "style-success"; ?>
                  <?php $status = " - (done)"; ?>
                  <?php $prev_status = $status; ?>
                <?php endif; ?>
              <?php endforeach; ?>

              <form role="form" method="post" action="<?= base_url('pos/pos/'); ?>">
                <div class="col-md-3 col-sm-4 col-xs-6">
                  <div class="card">
                    <div class="card-head <?= $style ?>">
                      <h3 class="text-center text-light"><?= $row['meja_nama']; ?><?= $status; ?></h3>
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
                            <?php ($row['meja_pelanggan'] == $c['plg_id']) ? $p = $c['plg_nama'] : "" ?>
                            <option data-value="<?= $c['plg_id'] ?>"><?= $c['plg_nama'] ?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </datalist>

                      <?php isset($p) && ($p !== "") ? $pelangganValue = $p : $pelangganValue = ""; ?>
                      <?php isset($p) && ($p !== "") ? $readonly = 'readonly' : $readonly = ""; ?>
                      <input class="form-control" name="plg_nama" list="pelanggan-<?= $row['meja_id'] ?>" id="list-<?= $row['meja_id'] ?>" value="<?= $row['plg_nama'] ?>" <?= $readonly ?>>
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
                <form role="form" method="post" action="<?= base_url('pos/pos/'); ?>">
                  <div class="col-xs-6 col-sm-4 col-md-3">
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
        <form class="form-horizontal" action="<?= base_url('pos/pos/'); ?>" method="post">
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
                <input class="form-control" name="plg_nama" list="pelanggan-<?= $t['tipe_transaksi_nama']; ?>" id="list-<?= $t['tipe_transaksi_nama'] ?>" value="<?= $pelangganValue ?>">
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

        <?php (isset($trx['trx_id'])) ? $url_id = $trx['trx_id'] : $url_id = $last_inv_number; ?>
        <form id="form_paid" action="<?= base_url("pos/pos/check_out/$url_id"); ?>" method="post">
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">No Transaksi</label>
                  <div class="col-xs-7">
                    <input type="hidden" name="voucher_id" class="potong_voucher_id">
                    <input type="hidden" name="discount_nominal" class="discountValModal">
                    <input type="text" name="trx_nomor" value="INV<?= str_pad(($url_id), 3, "0", STR_PAD_LEFT); ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Tipe Pembayaran</label>
                  <div class="col-xs-7">
                    <input type="text" value="<?= $k_nama; ?>" class="form-control trx_payment_source_<?= $k_id ?>" readonly>
                    <input type="hidden" name="trx_payment" class="form-control trx_payment" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Meja</label>
                  <div class="col-xs-7">
                    <input type="text" name="trx_meja" value="<?= $trx_prop['trx_tipe_nama']; ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Grand Total</label>
                  <div class="col-xs-7">
                    <input type="text" class="form-control grandTotalModal" readonly>
                    <input type="hidden" name="trx_grand_total" class="form-control trx_grand_total" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Bayar</label>
                  <div class="col-xs-7">
                    <input type="text" data-type="currency" class="form-control inputPembayaran trx_paid_source_<?= $k_id ?>">
                    <input type="hidden" name="trx_paid" data-type="currency" class="form-control trx_paid">
                  </div>
                </div>
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Kembalian</label>
                  <div class="col-xs-7">
                    <input type="text" name="trx_change" class="form-control valueKembalian" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group" style="visibility:<?= $type ?>">
              <div class="row">
                <div class="col-xs-6">
                  <label for="nomorKartu" class="col-xs-4 control-label">No.HP/Kartu</label>
                  <div class="col-xs-7">
                    <!-- nomor handphone dari mobile -->
                    <?php $no_kartu = ''; ?>
                    <?php
                    if (isset($trx[0]['order_nomor_kartu'])) {
                      ($no_kartu = ($trx[0]['order_nomor_kartu']));
                    }
                    ?>
                    <?php
                    if ($no_kartu == '') {
                      (isset($trx['trx_cardno'])) ? ($no_kartu = ($trx['trx_cardno'])) : ($no_kartu = '');
                    }
                    ?>
                    <!-- nomor handphone dari inputan kasir -->
                    <?php
                    if ($no_kartu == '') {
                      (isset($trx_prop['plg_telp']) && isset($trx_prop['plg_telp']) != '') ? ($no_kartu = $trx_prop['plg_telp']) : ($no_kartu = '');
                    }
                    ?>
                    <input type="<?= $type ?>" class="form-control trx_cardno_source_<?= $k_id ?>" value=<?= $no_kartu  ?>>
                    <input type="hidden" name="trx_cardno" class="form-control trx_cardno" id="nomorKartu">
                  </div>
                </div>
                <div class="col-xs-6">
                  <label for="nomorReff" class="col-xs-4 control-label">Reff ID</label>
                  <div class="col-xs-7">
                    <?php
                    $noreff = '';
                    ?>
                    <?php if (isset($trx[0]['order_nomor_reff'])) {
                      $noreff = ($trx[0]['order_nomor_reff']);
                    }
                    ?>
                    <?php if ($noreff == '' && isset($trx['trx_payreff'])) {
                      $noreff = ($trx['trx_payreff']);
                    }
                    ?>
                    <input type="<?= $type ?>" class="form-control trx_payreff_source_<?= $k_id ?>" value=<?= $noreff  ?>>
                    <input type="hidden" name="trx_payreff" class="form-control trx_payreff" id="nomorReff">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-xs-12">
                  <label for="notes" class="col-xs-2 control-label">Notes</label>
                  <div class="col-xs-10">
                    <textarea class="form-control" id="notes" style="border-color:darkgrey"></textarea>
                    <textarea name="trx_notes" class="form-control trx_notes" style="border-color:darkgrey;display:none"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-xs-12">
                  <div class="col-xs-12 text-center">
                    <?php if ($k['payment_qrcode']) :
                      $qr_code = $k['payment_qrcode'];
                    ?>
                      <img loading="lazy" src="<?= base_url("assets/img/${qr_code}"); ?>" class="img-responsive">
                    <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class=" modal-footer">
            <div class="row">
              <div class="col-xs-8"></div>
              <div class="col-xs-2">
                <div class="input-group-btn btn-raised">
                  <button type="button" class="btn btn-primary btn-flat btn-raised" tabindex="-1" data-toggle="dropdown" tabindex="-1" <?= @$disabledBayar ?>>Split Bill</button>
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
                <a data-payment="<?= $k_id ?>" class="paidAndPrintReceipt btn btn-success btn-raised"> Proses</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<script type="text/javascript">
  /* GLOBAL VAR */
  let clearFormating = (value) => Number(value.val().replace(/[($)\s\._\-]+/g, ''));
  let assignFormatingValueToElement = (element, value) => element.val(Number(value).toLocaleString('id-ID'));
  let dividedByOneHundred = (value) => (value / 100);
  let activeTrx = JSON.parse('<?= json_encode($trx) ?>');
  let isMobile = '<?= @$trx['is_mobile'] ?>';
  let isOrderUpdated = false;


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
  $(".paidAndPrintReceipt").click(async function() {
    let id = $(this).data("payment");
    await addInputToHiddenInputField(id);
    if ((isOrderUpdated) || (isMobile)) {
      submitOrderToKitchen();
    } else {
      // submitOrderToKitchen();
      paidAndPrintReceipt();
    }
  })
  // $(".submitOrderToKitchen").click(function() {
  //   let id = $(this).data("payment");
  //   addInputToHiddenInputField(id);

  // })
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
  $('.add_cart').click(function() {
    let notes = $('#notes_pesanan' + $(this).data("itemid")).val();
    let itemsProp = {
      items_id: $(this).data("itemid"),
      items_nama: $(this).data("itemnama"),
      items_harga: $(this).data("itemharga"),
      items_notes: notes
    };
    addItemsToCart(itemsProp);
  })
</script>


<!-- SCRIPT MODAL TAMBAH PELANGAN -->
<script type="text/javascript">
  let divs = document.querySelectorAll('input[list]');
  for (let i = 0; i < divs.length; i++) {
    // divs[i].addEventListener('input', function(e) {
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
    // });
  };
</script>


<!-- VOUCHER SCRIPT -->
<script type="text/javascript">
  let checkTermsAndConditionVoucher = () => {
    $('#voucher_tandc').val('');
    $("#voucher_id").val('');
    let kodeDiskon = $('#voucher_input').val();
    $.ajax({
      url: '<?= base_url('pos/pos/voucherTermsAndCondition'); ?>',
      method: "POST",
      data: {
        kodeDiskon: kodeDiskon,
      },
      dataType: 'json',
      success: function(data) {
        console.log(data)
        let terms = data[0].voucher_tandc;
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
  let useDiscountVoucher = () => {
    let id = $("#voucher_id").val();
    $.ajax({
      url: '<?= base_url('pos/pos/voucherApplied'); ?>',
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
<script type="text/javascript">
  let addItemsToCart = (items) => {
    $.ajax({
      url: "<?= base_url('pos/pos/check_stock'); ?>",
      method: "POST",
      data: items,
      dataType: 'json',
      success: function(data) {
        if (data.type == 'error') {
          return alert(data.message)
        }
        isOrderUpdated = true;
        console.log(isOrderUpdated);
        printTableCart(data);
      },
    });
  }
  let hapusCart = (row_id) => {
    $.ajax({
      url: "<?= base_url('pos/pos/hapus_cart'); ?>",
      method: "POST",
      data: {
        row_id: row_id,
      },
      dataType: 'json',
      success: function(data) {
        isOrderUpdated = true;
        console.log(isOrderUpdated);
        printTableCart(data);
      }
    });
  }
  let reloadMobileOrder = () => {
    $.ajax({
      url: '<?= base_url('pos/pos/getTransaksiMobile/');  ?>',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        if (data['mobile_app_order'].length > 0) {
          printMobileOrder(data);
        } else {
          $("#targetMobileOrder").html('');
          $('#mobile-order-notification').html('');
        }
      },
    });
  }
</script>


<!-- CALCULATE PEMBAYARAN PELANGGAN -->
<script type="text/javascript">
  let addInputToHiddenInputField = (id) => {
    let srcPayment = $('.trx_payment_source_' + id).val();
    let srcPaid = clearFormating($('.trx_paid_source_' + id));
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

  let calculateDiscount = (percentage) => {
    assignFormatingValueToElement($("#percentageDiscount"), percentage);
    let subTotal = clearFormating($("#subTotal"));
    let discount = (dividedByOneHundred(percentage) * subTotal);
    assignFormatingValueToElement($("#discount"), discount);
    assignValToPrintBillUrl(discount);
  }

  let calculateGrandTotal = () => {
    let discount = clearFormating($("#discount"));
    let subTotal = clearFormating($("#subTotal"));
    let totalPph = clearFormating($("#totalPph"));
    let totalService = clearFormating($("#totalService"));
    let grandTotal = subTotal - discount + totalPph + totalService;
    assignFormatingValueToElement($("#grandTotal"), grandTotal);
    assignFormatingValueToElement($(".trx_grand_total"), grandTotal);
    document.querySelectorAll('.grandTotalModal').forEach(el => {
      assignFormatingValueToElement(el, grandTotal);
    })
  }

  let inputPembayaran = (valuePembayaran) => {
    let grandTotalModal = clearFormating($(".grandTotalModal"));
    let kembalian = valuePembayaran - grandTotalModal;
    assignFormatingValueToElement($(".valueKembalian"), kembalian);
  }
</script>


<!-- SCRIPT SPLIT BILL -->
<script type="text/javascript">
  let getSisaPaymentSplitBill = () => {
    let sisaPembayaranAwal = clearFormating($(".valueKembalian"));
    assignFormatingValueToElement($(".grandTotalModal"), sisaPembayaranAwal);
  }
</script>


<!-- SCRIPT PRINT PEMBAYARAN -->
<script type="text/javascript">
  let modalPembayaran = () => {
    let grandTotal = clearFormating($('#grandTotal'));
    let nominalDiscount = clearFormating($('#discount'));
    assignFormatingValueToElement($(".trx_grand_total"), grandTotal);
    assignFormatingValueToElement($(".grandTotalModal"), grandTotal);
    assignFormatingValueToElement($(".discountValModal"), grandTotal);
  }
  let assignValToPrintBillUrl = (discount) => {
    let url = "<?= base_url('pos/pos/printBill/') . $trx_prop['plg_id'] . '/'; ?>";
    let targetUrl = url + discount;
    $("#printBill").attr("href", targetUrl);
  }
  let paidAndPrintReceipt = () => {
    let formPaid = $('#form_paid');
    formPaid.submit();
  }
</script>


<!-- MODAL PROSES PEMESANAN KE DAPUR SAAT METODE PAY FIRST -->
<script type="text/javascript">
  let submitOrderToKitchen = () => {
    let data = {
      discount: clearFormating($("#discount")),
      subtotal: clearFormating($("#subTotal")),
      totalpph: clearFormating($("#totalPph")),
      totalservice: clearFormating($("#totalService")),
      grandtotal: clearFormating($("#grandTotal")),
      trx_tipe: $('#trx_tipe').val(),
      pay_first: 'true',
      isMobile: 'true',
    }
    $.ajax({
      url: '<?= base_url("pos/pos/proses_kitchen/$trx_prop[plg_id]/$trx_prop[trx_tipe_nama]"); ?>',
      method: 'POST',
      data: data,
      dataType: "json",
      success: async function(data) {
        await paidAndPrintReceipt();
      }
    });
  }
</script>

<script type="text/javascript">
  $(function() {
    reloadMobileOrder();
    setTimeout(() => {
      document.querySelector('#loading-screen').style.display = 'none';
      document.querySelector('#base').removeAttribute('style');

      /* FUNCTION UNTUK SCROL KATEGORI LEFT OR RIGHT */
      let menus = $("#menus"),
        menuWidth = menus.parent().outerWidth();
      let menupage = Math.ceil(menus[0].scrollWidth / menuWidth),
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
    }, 2000)
  })
</script>


<script type="text/javascript">
  let printTableCart = (data) => {
    let grandTotal = 0;
    let totalTaxResto = 0;
    let totalServiceCharge = 0;
    let output = '';
    let cart = Object.values(data['cart']);
    let buttonHapusDisabled;
    let isPaid = activeTrx.trx_paid;

    cart.forEach(c => {
      let isPreviousOrder = c.options.is_prev_order == 'Y';
      let isOrderNotCanceled = c.options.flg_cancel == 'N';
      buttonHapusDisabled = '';

      if (isPreviousOrder && isPaid && isOrderNotCanceled) {
        buttonHapusDisabled = 'disabled';
      }

      grandTotal += c.subtotal;
      output +=
        `<tr>
          <td> ${c.name} - ${c.options.notes} </td>
          <td> ${c.price} </td>
          <td> ${c.qty} </td>
          <td> ${c.subtotal} </td>
          <td class="text-right">
            <a href="#" class="hapus_cart text-danger btn btn-icon-toggle btn-raised"
            id="${c.rowid}" title="hapus pesanan" ${buttonHapusDisabled}>
            <i class="fa fa-trash"></i></a>
          </td>
        <tr>`;
    })
    totalTaxResto = (grandTotal * dividedByOneHundred(data['taxresto']));
    totalServiceCharge = (grandTotal * dividedByOneHundred(data['taxservice']));
    assignFormatingValueToElement($('#subTotal'), grandTotal);
    assignFormatingValueToElement($('#totalService'), totalServiceCharge);
    assignFormatingValueToElement($('#totalPph'), totalTaxResto);
    $('#detail_cart').html(output);
    calculateGrandTotal();
  }
</script>

<!-- MODAL CEK STATUS PESANAN PELANGGAN -->
<script type="text/javascript">
  let getStatusPemesananPelanggan = () => {
    $.ajax({
      type: 'GET',
      url: '<?= base_url("pos/kitchen/getDataTrx"); ?>',
      dataType: 'json',
      success: function(data) {
        let card = '';
        let table = data['table'];
        let order = data['order'];
        table.forEach(t => {
          card +=
            `<div class="col-md-3">
              <div class="card">
                <div class="card-head style-gray">
                  <h3  class="text-center text-light"> ${t.trx_table} </h3>
                </div>
                <div class="card-body">`;
          order.forEach(o => {
            if ((t.trx_id) === (o.order_trx_reff) &&
              (t.order_date) === (o.order_date)) {
              card +=
                `<div class="clearfix">
              <div class="pull-left"> ${o.order_menu} ( ${o.order_qty} )
            </div>
          </div>`;
              card += ((o.order_notes)) ? `<div class="clearfix"><div class="pull-left"> - ${o.order_notes} </div></div>` : '';
            }
          })
          card += `<br/>
          <div class="timeShow text-center"> ${t.order_date} </div><br/>
        </div>
      </div>
    </div>`;

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
  let printMobileOrder = (data) => {
    let url = '<?= base_url('pos/pos/'); ?>';
    let card = '';
    let dataHead = data['mobile_app_order_header'];
    let dataDescrip = data['mobile_app_order'];
    let plgId = '';
    let dataHeadFiltered = [];

    for (let i in dataHead) {
      if (plgId != Number(dataHead[i].order_userid)) {
        dataHeadFiltered.push(dataHead[i])
        plgId = Number(dataHead[i].order_userid);
      }
    }

    let notification = dataHeadFiltered.length;
    (notification != 0) &&
    $('#mobile-order-notification').html(notification);
    console.log(dataHeadFiltered);

    dataHeadFiltered.forEach(dH => {
      let no = 1;
      let date = new Date(dH.order_date);
      if (dH.order_trx_tipe === '1') {
        card +=
          `<form role="form" method="post" action="${url}">
            <div class="col-md-3 col-sm-4 col-xs-6">
              <div class="card">`;
        card += (dH.order_payment_id) ? (`<div class="card-head style-success">`) : (`<div class="card-head style-gray">`);
        card += `
                  <h3 class="text-center text-light">Dine In - ${dH.plg_nama} </h3>
                </div>
                <div class="card-body no-padding card-type-pricing">
                  <ul class="list-unstyled">
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Tgl :</div>
                        <div class="pull-right"> ${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()} </div>
                      </div>
                    </li>
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Nama Meja :</div>
                        <div class="pull-right"> ${dH.meja_nama} </div>
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
          card += `
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Pembayaran : </div>
                        <div class="pull-right"> ${dH.order_payment_nama} </div>
                      </div>
                    </li>`;
        }
        if (dH.order_voucher_id) {
          card += `
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Voucher : </div>
                        <div class="pull-right"> ${dH.voucher_kode} </div>
                      </div>
                    </li>`;
        }
        card += `
                  </ul>
                </div>
                <div class="card-body no-padding card-type-pricing">
                  <input type="hidden" name="meja_id" value="${dH.meja_id}">
                  <input type="hidden" name="order_mobile" value="true">
                  <input type="hidden" name="plg_id" value="${dH.order_userid}">
                  <div class="card-body text-center">
                    <button class="btn btn-primary btn-raised" type="submit">Detail</button>
                    <a href="${url}batalkan_pemesanan_mobile/${dH.order_userid}"
                      onclick="return confirm(Apakah anda yakin?)" class="btn btn-flat text-danger btn-raised">Decline</a>
                  </div>
                </div>
              </div>
            </div>
          </form>`;
      } else {
        card += `
          <form role="form" method="post" action="${url}">
            <div class="col-md-3">
              <div class="card">`;

        card += (dH.order_payment_id) ? (`<div class="card-head style-success">`) : (`<div class="card-head style-gray">`);

        card += `
                  <h3 class="text-center text-light">`;
        ((dH.plg_alamat) && (card += `Delivery - ${dH.plg_nama}`));
        ((dH.plg_platno) && (card += `Car - ${dH.plg_nama}`));
        ((!dH.plg_alamat && !dH.plg_platno) && (card += `Take Away- ${dH.plg_nama}`));

        card += `
                  </h3>
                </div>
                <div class="card-body no-padding card-type-pricing">
                  <ul class="list-unstyled">
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Tgl :</div>
                        <div class="pull-right"> ${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()} </div>
                      </div>
                    </li>`

        if (dH.plg_alamat) {
          card += `
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Alamat :</div>
                        <div class="pull-right"> ${dH.plg_alamat} </div>
                      </div>
                    </li>`
        } else if (dH.plg_platno) {
          card += `
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Plat Mobil :</div>
                        <div class="pull-right"> ${dH.order_cust_platno} </div>
                      </div>
                    </li>
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Cust Notes :</div>
                        <div class="pull-right"> ${dH.order_cust_notes} </div>
                      </div>
                    </li>`
        }

        card += `
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">No Telp :</div>
                        <div class="pull-right"> ${(dH.plg_notelp) ? dH.plg_notelp : '-'} </div>
                      </div>
                    </li>`

        if (dH.order_payment_id) {
          card += `
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Pembayaran : </div>
                        <div class="pull-right"> ${dH.order_payment_nama} </div>
                      </div>
                    </li>`;
        }
        if (dH.order_voucher_id) {
          card += `
                    <li>
                      <div class="clearfix">
                        <div class="pull-left">Voucher : </div>
                        <div class="pull-right"> ${dH.voucher_kode} </div>
                      </div>
                    </li>`;
        }
        card += `
                  </ul>
                </div>
                <div class="card-body no-padding card-type-pricing">
                  <input type="hidden" name="order_mobile" value="true">
                  <input type="hidden" name="plg_id" value="${dH.order_userid}">`;
        ((dH.data_alamat) && (card += `<input type="hidden" name="plg_alamat" value="${dH.order_alamat}">`));
        ((dH.data_platno) && (card += `<input type="hidden" name="plg_platno" value="${dH.order_platno}">`));
        card += `
                  <div class="card-body text-center">
                    <button class="btn btn-primary btn-raised" type="submit">Detail</button>
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
</script>


</div>
</div>
</body>

</html>