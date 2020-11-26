<div class="offcanvas">

</div>

<div id="content">
  <section>
    <div class="section-header">
      <h2><span class="fa fa-cutlery"></span> Point of Sale</h2>
    </div>
    <?= $this->session->flashdata('msg'); ?>
    <div class="msg"></div>
    <?php (isset($input_buffer)) && (print_r($input_buffer)) ?>
    <section class="style-default no-padding no-margin">
      <div class="container-fluid no-padding">
        <div class="col-lg-5 col-md-5 col-xs-12 col-sm-6 no-padding">
          <div class="card">
            <!-- <form role="form" id="order_form" method="post" action="?= base_url() . 'pos/pos/proses_kitchen/' ?>"> -->
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
                <h4 id="trx-info"> - </h4>
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

                  </tbody>
                  </tfoot>
                  <tr>
                    <th style="text-align:left;" colspan="5">Sub Total</th>
                    <th style="text-align:center;" colspan="2"><input class="form-control" id="subTotal" name="subtotal" value="0" readonly>
                    </th>
                  </tr>
                  <div class="form-group">
                    <tr>
                      <th style="text-align:left;" colspan="5">Discount
                        <input type="text" style="width: 4rem;height: 1rem;padding:1rem;" id="percentageDiscount" name="discount" autocomplete="off"> %</th>
                      <th style="text-align:center;" colspan="2">
                        <input type="text" class="form-control " id="discount" name="discount" value="" data-type="currency">
                      </th>
                    </tr>
                  </div>
                  <div class="form-group">
                    <tr>
                      <th style="text-align:left;" colspan="5">Service Charge (<?= $taxservice ?>%)
                      <th style="text-align:center;" colspan="2">
                        <input class="form-control" id="totalService" name="totalservice" value="" readonly>
                      </th>
                    </tr>
                  </div>
                  <div class="form-group">
                    <tr>
                      <th style="text-align:left;" colspan="5">Pajak Resto (<?= $taxresto ?>%)
                      <th style="text-align:center;" colspan="2">
                        <input class="form-control" id="totalPph" name="totalpph" value="" readonly>
                      </th>
                    </tr>
                  </div>
                  <div class="form-group">
                    <tr>
                      <th style="text-align:left;" colspan="5">Grand Total</th>
                      <th style="text-align:center;" colspan="2">
                        <input class="form-control" id="grandTotal" name="grandtotal" value="" readonly>
                      </th>
                    </tr>
                  </div>
                  <div class="form-group">
                    <input type="hidden" id="trx_tipe" name="trx_tipe" value="">
                  </div>
                  </tfoot>
                </div>
              </table>
            </div>
            <div class="card card-body no-margin" style="border-radius: 10px;padding: 10px;">

              <a href="#" style="text-align:left;" id="simpanPesanan" onclick="prosesKitchen()" class="btn btn-primary btn-raised">Proses</button>
                <a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_add_voucher">Voucher</a>

                <div class="pull-right">
                  <div class="input-group-btn btn-raised dropup">
                    <button type="button" class="btn btn-primary btn-flat btn-raised" tabindex="-1">Bayar</button>
                    <button type="button" class="btn btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1">
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="<?php echo base_url('pos/pos/printBill/') ?>" id="printBill" target="_blank">Print</a></li>
                      <?php
                      foreach ($payment as $k) :
                        $k_id = $k['payment_id'];
                        $k_nama = $k['payment_nama'];
                      ?>
                        <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran"><?= $k_nama; ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
            </div>
            <!-- </form> -->
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-xs-12 col-sm-6" style="padding-right:0px;">
          <div class="card">
            <div class="tab-slider">
              <div class="wrap">
                <ul class="nav nav-tabs" id="menus" role="tablist" id="example-tabs" data-tabs>
                  <li role="presentation" class="active"><a href="#panel-all" aria-controls="home" role="tab" data-toggle="tab">Semua</a></li>
                  <?php foreach ($kategori_all as $index => $tab) : ?>
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
                <?php foreach ($makanan as $index => $table_content) : ?>
                  <div class="col-lg-3 col-md-3 col-lg-4 col-sm-6">
                    <div class="no-padding card thumbnail btn">
                      <a data-toggle="modal" data-target="#option_menu<?= $table_content['menu_id'] ?>">
                        <td>
                          <img loading="lazy" style="width:auto;height:12rem;border-radius:4px" class="width-1 img-responsive rounded" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" />
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
          <?php foreach ($kategori_all as $index => $tab) : ?>
            <div role="tabpanel" class="tab-pane" id="panel-<?= $index; ?>">
              </br>
              <?php foreach ($kategori_makanan as $index => $table_content) : ?>
                <?php if (($table_content['kategori_id'] == $tab['kategori_id'])) : ?>
                  <div class="col-lg-3 col-md-3 col-lg-4 col-sm-6">
                    <div class="table-responsive">
                      <div class="no-padding card thumbnail btn">
                        <a data-toggle="modal" data-target="#option_menu<?= $table_content['menu_id'] ?>">
                          <td>
                            <img loading="lazy" style="width:auto;height:12rem;border-radius:4px" class="width-1 img-responsive rounded" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" />
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
<?php foreach ($makanan as $index => $table_content) : ?>
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
            <?php foreach ($table_all as $row) : ?>

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
                    <input class="form-control" list="pelanggan-<?= $row['meja_id'] ?>" data-tableText="<?= $row['meja_nama'] ?>" id="list-<?= $row['meja_id'] ?>" value="<?= $pelangganValue ?>">
                    <input type="text" name="plg_id" id="list-<?= $row['meja_id'] ?>-hidden" value="<?= $row['meja_pelanggan']; ?>">
                    <?php $p = ""; ?>
                    <div class="card-body text-center">
                      <button data-dismiss="modal" aria-hidden="true" onclick="addTable('<?= $row['meja_id'] ?>')" class="btn btn-primary btn-raised select-table">Pilih</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>

          <?php else : ?>
            <?php $queue = 0; ?>
            <?php foreach ($trx_all as $row) : ?>
              <?php if ($row['trx_tipe'] == $t['tipe_transaksi_id']) : ?>
                <?php $queue += 1; ?>

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
                            <?php foreach ($order_all as $o) :
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
                        <button data-dismiss="modal" aria-hidden="true" class="btn btn-primary btn-raised" onclick="viewOtherOrder('<?= $row['trx_id'] ?>','<?= $t['tipe_transaksi_nama']; ?>')">Pilih</button>
                      </div>
                    </div>
                  </div>
                </div>

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
        <form class="form-horizontal">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pelanggan</label>
              <div class="col-sm-8">
                <!-- loop untuk dropdown pilih pelanggan -->
                <!-- <datalist id="pelanggan-<?= $t['tipe_transaksi_id'] ?>">
                  ?php foreach ($customer as $c) : ?>
                    ?php if ($c['plg_login_flg'] == 'Y') : ?>
                      ?php (($row['meja_pelanggan'] == $c['plg_id']) && ($c['plg_order'] != 0)) ? $p = $c['plg_nama'] : "" ?>
                      <option data-value="<?= $c['plg_id'] ?>"><?= $c['plg_nama'] ?></option>
                    ?php endif; ?>
                  ?php endforeach; ?>
                </datalist> -->

                <?php isset($p) && ($p !== "") ? $pelangganValue = $p : $pelangganValue = "" ?>
                <input class="form-control" list="pelanggan-<?= $t['tipe_transaksi_id']; ?>" id="list-<?= str_replace(' ', '', $t['tipe_transaksi_nama']); ?>" value="<?= $pelangganValue ?>">
                <input type="hidden" name="plg_id" id="list-<?= str_replace(' ', '', $t['tipe_transaksi_nama']); ?>-hidden" value="">
                <?php $p = ""; ?>
              </div>
            </div>
            <?php if ($t['tipe_transaksi_id'] == 3) : ?>
              <div class="form-group">
                <label class="col-sm-3 control-label">Plat no</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="trx-platno" name="plg_platno" required>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($t['tipe_transaksi_id'] == 4) : ?>
              <div class="form-group">
                <label class="col-sm-3 control-label">Alamat </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="trx-address" name="plg_alamat" required>
                </div>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label class="col-sm-3 control-label">No. Telp </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="trx-notelp-<?= $t['tipe_transaksi_id'] ?>" name="plg_notelp" value="">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger btn-flat btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button data-dismiss="modal" aria-hidden="true" onclick="addOtherOrder('<?= $t['tipe_transaksi_id'] ?>','<?= $t['tipe_transaksi_nama'] ?>')" class="btn btn-primary btn-raised select-table">Tambah</button>
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
      <form class="form-horizontal" action="#">
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

        <form id="form_paid_<?= $k_id ?>" action="<?= base_url('pos/pos/check_out/') ?>" method="post" target="_blank">
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label class="col-sm-4 control-label">No Transaksi</label>
                  <div class="col-sm-7">
                    <input type="hidden" name="voucher_id" class="potong_voucher_id">
                    <input type="hidden" name="discount_nominal" class="discountValModal">
                    <input type="text" name="trx_nomor" value="INV<?= str_pad(9, 3, "0", STR_PAD_LEFT); ?>" class="form-control" readonly>
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
                    <input type="text" name="trx_meja" class="form-control paymentMeja" readonly>
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
                    <input type="hidden" name="trx_cardno" class="form-control trx_cardno" id="nomorKartu<?= $k_id ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="nomorReff" class="col-sm-4 control-label">Reff ID</label>
                  <div class="col-sm-7">
                    <input type="<?= $type ?>" class="form-control trx_payreff_source_<?= $k_id ?>">
                    <input type="hidden" name="trx_payreff" class="form-control trx_payreff" id="nomorReff<?= $k_id ?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label for="notes" class="col-sm-2 control-label">Notes</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="notes<?= $k_id ?>" style="border-color:darkgrey"></textarea>
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
                      <img loading="lazy" src="<?= base_url() . 'assets/img/' . $k['payment_qrcode']; ?>">
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
                  <button type="button" class="btn btn-primary btn-flat btn-raised" tabindex="-1" data-toggle="dropdown" tabindex="-1">Split Bill</button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <?php
                    foreach ($payment as $split) :
                      $split_k_id = $split['payment_id'];
                      $split_k_nama = $split['payment_nama'];
                    ?>
                      <li><a href="#" class="splitBill" data-toggle="modal" data-target="#modal_bayar<?= $split_k_id ?>" data-dismiss="modal" data-payment="<?= $k_id ?>" aria-hidden="true"><?= $split_k_nama; ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
              <div class="col-sm-2">
                <a onclick="prosesKitchen(this)" data-paymentId="<?= $k_id ?>" class="btn btn-success btn-raised"> Proses</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- ?php echo json_decode($customerHadOrder) ?> -->


<script type="text/javascript" src="<?= base_url() . 'assets/js/jquery-3.4.1.min.js' ?>"></script>
<script type="text/javascript">
  /* GLOBAL VAR */
  var allTrx = JSON.parse('<?= json_encode($trx_all); ?>')
  var allOrder = JSON.parse('<?= json_encode($order_all); ?>')
  var allCustHasOrder = JSON.parse('<?= json_encode($customerHadOrder); ?>')
  var clearFormating = (value) => Number(value.val().replace(/[($)\s\._\-]+/g, ''))
  var assignFormatingValueToElement = (element, value) => element.val(Number(value).toLocaleString('id-ID'))
  var dividedByOneHundred = (value) => (value / 100)
  var makanan = JSON.parse('<?= json_encode($makanan) ?>')
  var ingredient = JSON.parse('<?= json_encode($ingredient) ?>')
  var taxResto = parseInt('<?= $taxresto ?>')
  var inventory = JSON.parse('<?= json_encode($inventory) ?>')
  var taxService = parseInt('<?= $taxservice ?>')
  var activeCust = [];
  var subTotal = clearFormating($('#subTotal'));
  var idVoucher = '';

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
      this.isNewOrder = true;
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
          String(cart[item].notes) === String(notes) &&
          cart[item].isNewOrder == true) {
          cart[item].count++;
          cart[item].recipe = recipe;
          console.log(
            cart[item].recipe
          )
          for (let [key, value] of Object.entries(cart[item].recipe)) {
            value.val *= cart[item].count;
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
          String(cart[item].notes) === String(notes) &&
          cart[item].isNewOrder == true) {
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
          String(cart[item].notes) === String(notes) &&
          cart[item].isNewOrder == true) {
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

  shoppingCart.clearCart();

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
      .map(mappedIng => {
        return {
          id: mappedIng.ing_inv_id,
          val: mappedIng.ing_qty * mappedIng.satuan_val,
        }
        // return nm;
      })
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
    subTotal = 0;
    for (var i in cartArray) {
      subTotal += Number(cartArray[i].total)
      output +=
        `<tr>
        <td> ${cartArray[i].name} - ${cartArray[i].notes} </td>
        <td> ${Number(cartArray[i].price)} </td>
        <td class="text-right">`

      if (cartArray[i].isNewOrder) {
        output +=
          `<a class="btn-icon-toggle plus-item pull-right"
          data-notes="${cartArray[i].notes}" data-name="${cartArray[i].name}"><span class="fa fa-plus"</span></a>`
      }

      output +=
        `</td>
        <td class="text-center">${cartArray[i].count}</td>
        <td class="text-left">`

      if (cartArray[i].isNewOrder) {
        output +=
          `<a class="btn-icon-toggle minus-item pull-left"
          data-notes="${cartArray[i].notes}" data-name="${cartArray[i].name}">
          <span class="fa fa-minus"></span></a>`
      }

      output +=
        `</td>
        <td> ${Number(cartArray[i].total)} </td>
        <td class="text-right">`
      if (cartArray[i].isNewOrder) {
        output +=
          `<a href="#" class="text-danger btn btn-icon-toggle btn-raised delete-item"
          id="c.rowid" title="hapus pesanan" data-notes="${cartArray[i].notes}" data-name="${cartArray[i].name}">
          <i class="fa fa-trash"></i></a>`
      }
      output +=
        `</td>
        <tr>`;
    }

    totalTaxResto = (subTotal * dividedByOneHundred(taxResto));
    totalServiceCharge = (subTotal * dividedByOneHundred(taxService));
    assignFormatingValueToElement($('#subTotal'), subTotal);
    assignFormatingValueToElement($('#totalService'), totalServiceCharge);
    assignFormatingValueToElement($('#totalPph'), totalTaxResto);
    calculateGrandTotal();
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
      .map(mappedIng => {
        return {
          id: mappedIng.ing_inv_id,
          val: mappedIng.ing_qty * mappedIng.satuan_val,
        }
        // return nm;
      })
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
      .map(mappedIng => {
        return {
          id: mappedIng.ing_inv_id,
          val: mappedIng.ing_qty * mappedIng.satuan_val,
        }
        // return nm;
      })
    }
    shoppingCart.addItemToCart(name, '', '', notes, recipe);
    displayCart();
  })
  displayCart();


  /* Cust API */
  // ************************************************
  // Cust API
  // ************************************************
  function addTable(id) {
    let cust = document.querySelector(`#list-${id}-hidden`);
    let custText = document.querySelector(`#list-${id}`);
    let data = {
      trxTipe: {
        id: 1,
        text: 'dine-in',
      },
      trxTipeIdentifier: {
        id: id,
        nama: custText.getAttribute('data-tableText'),
      },
      cust: {
        id: cust.value,
        nama: custText.value,
      },
    }

    let checkCustOrders = data => {
      let custNomorOrder = allCustHasOrder
        .filter(cust => Number(cust.plg_id) == data.cust.id)
        .map(mappedCust => Number(mappedCust.plg_order))

      return custNomorOrder;
    }

    let getCustOrders = custNomorOrder => {
      let custOrders = allOrder
        .filter(order => Number(order.trx_id) == custNomorOrder)

      return custOrders;
    }

    activeCust = data;
    let custNomorOrder = checkCustOrders(data);
    let custOrders = (custNomorOrder) ? getCustOrders(custNomorOrder) : '';

    if (custOrders) {
      cart = [];
      shoppingCart.clearCart()
      for (let item in custOrders) {
        recipe = {}
        shoppingCart.addItemToCart(custOrders[item].order_menu,
          custOrders[item].order_harga,
          custOrders[item].order_qty,
          custOrders[item].order_notes,
          recipe)
        cart[item].isNewOrder = false;
        displayCart()
      }
    }

    $("#trx-info").html(`${activeCust.cust.nama} - ${activeCust.trxTipeIdentifier.nama}`)
    $(".paymentMeja").val(activeCust.trxTipeIdentifier.nama)
  }

  function addOtherOrder(tipeTrx, namaTipeTrx) {
    let cust = document.querySelector(`#list-${namaTipeTrx.replace(/\s+/g, '')}`);
    let platno = document.querySelector('#trx-platno');
    let alamat = document.querySelector('#trx-address');
    let notelp = document.querySelector(`#trx-notelp-${tipeTrx}`);
    let data = {
      trxTipe: {
        id: tipeTrx,
        text: namaTipeTrx,
      },
      trxTipeIdentifier: {
        nama: namaTipeTrx,
        platno: platno.value,
        notelp: notelp.value,
        alamat: alamat.value,
      },
      cust: {
        id: cust.value,
        nama: cust.value,
      },
    }

    activeCust = data;
    cart = [];
    shoppingCart.clearCart()
    displayCart()
    $("#trx-info").html(`${activeCust.cust.nama} - ${activeCust.trxTipeIdentifier.nama}`)
  }

  function viewOtherOrder(trxId, namaTipeTrx) {
    let custOrders = allOrder
      .filter(order => Number(order.trx_id) == Number(trxId))

    let customer = allCustHasOrder
      .filter(cust => Number(cust.plg_order) == Number(trxId))

    console.log(trxId)
    let data = {
      trxTipe: {
        id: custOrders[0].trx_tipe,
        text: namaTipeTrx,
      },
      trxTipeIdentifier: {
        nama: namaTipeTrx,
        platno: customer[0].plg_platno,
        notelp: customer[0].plg_notelp,
        alamat: customer[0].plg_alamat,
      },
      cust: {
        id: customer[0].plg_id,
        nama: customer[0].plg_nama,
      },
    }
    activeCust = data;

    cart = [];
    shoppingCart.clearCart()
    for (let item in custOrders) {
      recipe = {}
      shoppingCart.addItemToCart(custOrders[item].order_menu,
        custOrders[item].order_harga,
        custOrders[item].order_qty,
        custOrders[item].order_notes,
        recipe)
      cart[item].isNewOrder = false;
    }
    displayCart()
  }

  function prosesKitchen(el = false) {
    let discount = (clearFormating($("#discount")) ? clearFormating($("#discount")) : 0);
    let totalPph = clearFormating($("#totalPph"));
    let totalService = clearFormating($("#totalService"));
    let paymentData = '';

    if (el) {
      console.log('this running');
      let paymentId = $(el).data("paymentid");
      let formPayment = document.querySelector(`#form_paid_${paymentId}`);
      let getFormValue = () => {
        let obj = {};
        const formData = new FormData(formPayment);
        for (var key of formData.keys()) {
          obj[key] = formData.get(key);
        }
        console.log(obj)
        return obj;
      };
      paymentData = getFormValue();
      console.log(paymentData)
    }

    let grandTotal = subTotal - discount + totalPph + totalService;
    let data = {
      cust: activeCust,
      cart: cart,
      subTotal: subTotal,
      discount: {
        idVoucher: idVoucher,
        discount: discount,
      },
      totalPph: totalPph,
      totalService: totalService,
      grandTotal: grandTotal,
      payment: paymentData,
    }

    console.log(data)
    console.log(paymentData)
    const postKitchen = async () => {
      const response = await fetch('<?= base_url('pos/pos/proses_kitchen') ?>', {
        method: 'POST',
        header: 'Content-Type: application/json',
        body: JSON.stringify(data),
      })
      const result = await response.json();
      (result) && shoppingCart.clearCart()
      displayCart()
      activeCust = []
      $('#base').html(result)
    }
    postKitchen()
  }
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


  /* CALCULATE PEMBAYARAN PELANGGAN */
  var calculateDiscount = (percentage) => {
    assignFormatingValueToElement($("#percentageDiscount"), percentage);
    subTotal = clearFormating($("#subTotal"));
    let discount = (dividedByOneHundred(percentage) * subTotal);
    assignFormatingValueToElement($("#discount"), discount);
    assignValToPrintBillUrl(discount);
  }

  var calculateGrandTotal = () => {
    let discount = (clearFormating($("#discount")) ? clearFormating($("#discount")) : 0);
    subTotal = clearFormating($("#subTotal"));
    let totalPph = clearFormating($("#totalPph"));
    let totalService = clearFormating($("#totalService"));
    let grandTotal = subTotal - discount + totalPph + totalService;
    assignFormatingValueToElement($("#grandTotal"), grandTotal);
    assignFormatingValueToElement($(".trx_grand_total"), grandTotal);
    assignFormatingValueToElement($(".grandTotalModal"), grandTotal);
  }

  $('.inputPembayaran').keyup(function() {
    console.log('Bayar');
    let grandTotal = clearFormating($(".grandTotalModal"));
    let paid = clearFormating($(this));
    let change = paid - grandTotal;
    assignFormatingValueToElement($(".valueKembalian"), change);
  })

  displayCart();
</script>
</div>
</div>
</body>

</html>