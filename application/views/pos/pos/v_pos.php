<img id="loading-screen" src="<?= base_url('assets/img/loading.svg'); ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%; z-index: 1001;" />

<div id="base" style="display:none;">

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-cutlery"></span> Point of Sale</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>
      <div class="msg"></div>
      <section class="style-default no-padding no-margin">

        <div class="container-fluid no-padding">
          <div class="col-lg-4 col-md-5 col-xs-12 col-sm-6" style="padding-left:0px; ">
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
                          <li><a href="#" data-toggle="modal" data-target="#modal_transaksi_<?= $t['tipe_transaksi_id'] ?>" onClick="fetchTransaksi(<?= $t['tipe_transaksi_id'] ?>)"><?= $t['tipe_transaksi_nama']; ?></a></li>
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
                    <tfoot>
                      <tr>
                        <th style="text-align:left;" colspan="5">Sub Total</th>
                        <th style="text-align:center;" colspan="2"><input class="form-control" id="subTotal" name="subtotal" value="0" readonly>
                        </th>
                      </tr>
                      <div class="form-group">
                        <tr>
                          <th style="text-align:left;" colspan="5">Discount
                            <input type="text" style="width: 4rem;height: 1rem;padding:1rem;" id="percentageDiscount" name="discount" autocomplete="off"> %
                          </th>
                          <th style="text-align:center;">
                            <input type="text" class="form-control " id="discount" name="discount" value="" data-type="currency">
                          </th>
                          <th class="no-padding no-margin">
                            <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_add_voucher" style="border:solid; border-width:1px; border-color:#08867e">Add</a>
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
                    </tfoot>
                  </div>
                </table>

                <div class="card-body no-padding row">
                  <div class="col-sm-3 no-padding ">
                    <button style="text-align:left;" id="simpanPesanan" onclick="prosesPesanan()" class="btn btn-primary btn-raised">Proses</button>
                  </div>
                  <div class="col-sm-3 no-padding ">
                    <a class="btn btn-primary btn-raised" href="<?= base_url("pos/pos/printBill/"); ?>" id="printBill" target="_blank">Print Bill</a>
                  </div>

                  <div class="col-sm-3 pull-right no-padding ">
                    <div class="input-group-btn btn-raised">
                      <button type="button" class="btn btn-primary dropdown-toggle btn-raised" data-toggle="dropdown" tabindex="-1">
                        Bayar <i class="fa fa-caret-up"></i>
                      </button>
                      <ul class="dropdown-menu pull-right" role="menu" style="border:solid; border-color:#0AAb9E; border-radius:15px">
                        <?php foreach ($payment as $k) :
                          $k_id = $k['payment_id'];
                          $k_nama = $k['payment_nama'];
                        ?>
                          <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" class="modalPembayaran"><?= $k_nama; ?></a></li>
                        <?php endforeach; ?>
                        <li><a href="https://web.whatsapp.com/send?phone=62" target="_blank" id="whatsapp-pelanggan" class="modalPembayaran">Whatsapp</a></li>
                      </ul>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-7 col-xs-12 col-sm-6" style="padding-right:0px;">
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
                  <?php foreach ($makanan as $index => $table_content) :
                    $menu_gambar = $table_content['menu_gambar'];
                  ?>
                    <div class="col-md-4 col-lg-3 col-sm-6">
                      <div class="no-padding card thumbnail btn" style="box-shadow: 1px 1px 4px 1px rgba(0, 0, 0, 0.33)">
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
            <?php foreach ($kategori_all as $index => $tab) : ?>
              <div role="tabpanel" class="tab-pane" id="panel-<?= $index; ?>">
                </br>
                <?php foreach ($kategori_makanan as $index => $table_content) :
                  $menu_gambar = $table_content['menu_gambar'];
                ?>
                  <?php if (($table_content['kategori_id'] == $tab['kategori_id']) && $table_content['menu_nama'] != '') : ?>
                    <div class="col-md-4 col-lg-3 col-sm-6">
                      <div class="no-padding card thumbnail btn" style="box-shadow: 1px 1px 4px 1px rgba(0, 0, 0, 0.33)">
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
                <textarea type="text" class="form-control" id="notes-pesanan-<?= $table_content['menu_id']; ?>"></textarea>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <a href="#" class="add_cart btn btn-primary btn-raised" data-dismiss="modal" aria-hidden="true" data-itemid="<?= $table_content['menu_id']; ?>" data-itemnama="<?= $table_content['menu_nama']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>">Add Pesanan</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<!-- MODAL KATEGORI TRANSAKSI PESANAN -->
<?php foreach ($tipe_transaksi as $t) : ?>
  <div class="modal fade" id="modal_transaksi_<?= $t['tipe_transaksi_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
        </div>
        <div class="table-responsive" id="order-target-<?= $t['tipe_transaksi_id']; ?>">

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
        <form class="form-horizontal" id="form-order-<?= $t['tipe_transaksi_id']; ?>" action="<?= base_url('pos/pos/'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Pelanggan</label>
              <div class="col-sm-8">
                <input class="form-control" name="nama" required>
              </div>
            </div>
            <?php if ($t['tipe_transaksi_id'] == 3) : ?>
              <div class="form-group">
                <label class="col-sm-3 control-label">Plat no</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="platno" required>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($t['tipe_transaksi_id'] == 4) : ?>
              <div class="form-group">
                <label class="col-sm-3 control-label">Alamat </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="alamat" required>
                </div>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label class="col-sm-3 control-label">No. Telp </label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="telp" value="">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger btn-flat btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button data-dismiss="modal" aria-hidden="true" class="btn btn-primary btn-raised" onClick="addOtherOrder('<?= $t['tipe_transaksi_id']; ?>', '<?= $t['tipe_transaksi_nama']; ?>')">Tambah</button>
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
        <form id="form_paid_<?= $k_id ?>" action="#" method="post">
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
                    <input type="text" value="<?= $k_nama; ?>" name="trx_payment" class="form-control" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Meja</label>
                  <div class="col-xs-7">
                    <input type="text" name="trx_meja" class="form-control paymentMeja" readonly>
                  </div>
                </div>
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Grand Total</label>
                  <div class="col-xs-7">
                    <input type="text" name="trx_grand_total" class="form-control grandTotalModal" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Bayar</label>
                  <div class="col-xs-7">
                    <input type="text" name="trx_paid" data-type="currency" class="form-control inputPembayaran">
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
                    <input type="<?= $type ?>" name="trx_cardno" class="form-control paymentTelp">
                  </div>
                </div>
                <div class="col-xs-6">
                  <label class="col-xs-4 control-label">Reff ID</label>
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
                    <input type="<?= $type ?>" name="trx_payreff" class="form-control" value=<?= $noreff  ?>>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-xs-12">
                  <label for="notes-<?= $k_id ?>" class="col-xs-2 control-label">Notes</label>
                  <div class="col-xs-10">
                    <textarea class="form-control" id="notes-<?= $k_id ?>" style="border-color:darkgrey"></textarea>
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
                  <button type="button" class="btn btn-primary btn-flat btn-raised" tabindex="-1" data-toggle="dropdown" tabindex="-1" disabled>Split Bill</button>
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
                <button data-payment="<?= $k_id ?>" onclick="prosesPesanan(this)" class="btn btn-success btn-raised" data-dismiss="modal" aria-hidden="true"> Proses</button>
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
  // let activeTrx = JSON.parse('<= json_encode($trx) ?>');
  // let isMobile = '<= @$trx['is_mobile'] ?>';
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

  $('.inputPembayaran').keyup(function() {
    inputPembayaran(clearFormating($(this)));
  })
  $('.modalPembayaran').click(function() {
    modalPembayaran();
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
    assignFormatingValueToElement($('.grandTotalModal'), grandTotal);
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
    let url = "";
    // "<= base_url('pos/pos/printBill/') . $trx_prop['plg_id'] . '/'; ?>";
    let targetUrl = url + discount;
    $("#printBill").attr("href", targetUrl);
  }
  let paidAndPrintReceipt = () => {
    let formPaid = $('#form_paid');
    formPaid.submit();
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
                      onClick="return confirm(Apakah anda yakin?)" class="btn btn-flat text-danger btn-raised">Decline</a>
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
                      onClick="return confirm(Apakah anda yakin?)" class="btn btn-flat btn-raised text-danger">Decline</a>
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


<script type="text/javascript">
  let allTrx = JSON.parse('<?= json_encode($trx_all); ?>')
  let allOrder = JSON.parse('<?= json_encode($order_all); ?>')
  let allCustHasOrder = JSON.parse('<?= json_encode($plg_sudah_order); ?>')
  let makanan = JSON.parse('<?= json_encode($makanan) ?>')
  let ingredient = JSON.parse('<?= json_encode($ingredient) ?>')
  let taxResto = parseInt('<?= $taxresto ?>')
  let inventory = JSON.parse('<?= json_encode($inventory) ?>')
  let taxService = parseInt('<?= $taxservice ?>')
  let activeCust = {};
  let subTotal = clearFormating($('#subTotal'));
  let idVoucher = '';

  /* Cart API */
  // ************************************************
  // Cart API
  // ************************************************
  let shoppingCart = (function() {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];

    // Constructor
    function Item(id, name, price, count, notes, recipe, isNewOrder) {
      this.id = id;
      this.name = name;
      this.price = price;
      this.count = count;
      this.notes = notes;
      this.recipe = recipe;
      this.isNewOrder = isNewOrder;
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
    obj.addItemToCart = function(id, name, price, count, notes, recipe, isNewOrder = true) {
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
      var item = new Item(id, name, price, count, notes, recipe, isNewOrder);
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
    var notes = $('#notes-pesanan-' + $(this).data("itemid")).val();

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
    shoppingCart.addItemToCart(id, name, price, 1, notes, recipe)
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
    var id = $(this).data('id')
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
    shoppingCart.addItemToCart(id, name, '', '', notes, recipe);
    displayCart();
  })
  displayCart();


  /* Cust API */
  // ************************************************
  // Cust API
  // ************************************************
  function checkCustOrders(data) {
    let custNomorOrder = allCustHasOrder
      .filter(cust => Number(cust.plg_id) == data.cust.plg_id)
      .map(mappedCust => Number(mappedCust.plg_order))

    return custNomorOrder;
  }

  function getCustOrders(custNomorOrder) {
    let custOrders = allOrder
      .filter(order => Number(order.trx_id) == custNomorOrder)

    return custOrders;
  }

  function addTableOrder(id) {
    let formElement = document.querySelector(`#form-table-${id}`);
    let formData = new FormData(formElement);

    activeCust.cust = (Object.fromEntries(formData))
    activeCust.trxTipe = {
      id: 1,
      text: 'dine-in'
    }

    let custNomorOrder = checkCustOrders(activeCust);
    let custOrders = (custNomorOrder) ? getCustOrders(custNomorOrder) : '';

    if (custOrders) {
      cart = [];
      shoppingCart.clearCart()

      custOrders.forEach(item => {
        let recipe = {}
        let isNewOrder = false
        let {
          menu_id,
          menu_nama,
          order_harga,
          order_qty,
          order_notes,
        } = item
        shoppingCart.addItemToCart(menu_id, menu_nama, order_harga, order_qty, order_notes, recipe, isNewOrder)
      })
    }

    displayCart();
    $("#trx-info").html(`${activeCust.cust.nama} - ${activeCust.cust.meja_text}`)
    $(".paymentMeja").val(activeCust.cust.meja_text)
    $(".paymentTelp").val(activeCust.cust.telp)
  }


  function addOtherOrder(id, namaTrx) {
    let formElement = document.querySelector(`#form-order-${id}`);
    let formData = new FormData(formElement);

    activeCust.cust = (Object.fromEntries(formData))
    activeCust.trxTipe = {
      id: id,
      text: namaTrx
    }

    cart = [];
    shoppingCart.clearCart()
    displayCart()
    $("#trx-info").html(`${activeCust.cust.nama} - ${activeCust.trxTipe.text}`)
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
      shoppingCart.addItemToCart(
        custOrders[item].order_id,
        custOrders[item].order_menu,
        custOrders[item].order_harga,
        custOrders[item].order_qty,
        custOrders[item].order_notes,
        recipe)
      cart[item].isNewOrder = false;
    }
    displayCart()
  }

  const prosesPembayaran = async data => {
    console.log(data)
    const response = await fetch('<?= base_url('pos/pos/proses_pembayaran') ?>', {
      method: 'POST',
      header: 'Content-Type: application/json',
      body: JSON.stringify(data),
    })
    const result = await response.json();
    (result) && shoppingCart.clearCart();

    document.querySelector('#trx-info').innerHTML = ' - ';
    displayCart()
    activeCust = []
    $('.msg').html(alert(result.msg));
    setTimeout(() => {
      $('.msg').html('');
    }, 3000)
  }

  const prosesKitchen = async data => {
    const response = await fetch('<?= base_url('pos/pos/proses_kitchen') ?>', {
      method: 'POST',
      header: 'Content-Type: application/json',
      body: JSON.stringify(data),
    })
    const result = await response.json();
    (result) && shoppingCart.clearCart()
    displayCart()
    activeCust = []
    $('.msg').html(alert(result.msg));
    setTimeout(() => {
      $('.msg').html('');
    }, 3000)
  }

  function prosesPesanan(el = false) {
    event.preventDefault();
    let discount = (clearFormating($("#discount")) ? clearFormating($("#discount")) : 0);
    let totalPph = clearFormating($("#totalPph"));
    let totalService = clearFormating($("#totalService"));

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
      grandTotal: subTotal - discount + totalPph + totalService,
    }

    if (el) {
      let paymentId = $(el).data("payment");
      let formPayment = document.querySelector(`#form_paid_${paymentId}`);

      let getFormValue = () => {
        let obj = {};
        const formData = new FormData(formPayment);
        for (var key of formData.keys()) {
          obj[key] = formData.get(key);
        }
        return obj;
      };
      data.payment = getFormValue();
      prosesKitchen(data);
      prosesPembayaran(data);
    } else {
      prosesKitchen(data);
    }
  }

  $('.inputPembayaran').keyup(function() {
    let grandTotal = clearFormating($(".grandTotalModal"));
    let paid = clearFormating($(this));
    let change = paid - grandTotal;
    assignFormatingValueToElement($(".valueKembalian"), change);
  })

  function displayCart() {
    console.log("cart updated");
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
          data-id="${cartArray[i].id}" data-notes="${cartArray[i].notes}" data-name="${cartArray[i].name}"><span class="fa fa-plus"</span></a>`
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

  displayCart();

  let fetchTransaksi = (tipeTrx) => {
    if (tipeTrx == 1) {
      let cardDineIn = '';
      const fetchMeja = async () => {
        const response = await fetch("<?= base_url('pos/pos/fetch_meja') ?>");
        const data = await response.json();
        printMeja(data);
      }

      const printMeja = (data) => {
        const meja = data
        meja.forEach(m => {
          if (m.trx_id) {
            let cardHeadStyle = 'cooking';
            if (m.trx_kitchen_flg == 'Y') cardHeadStyle = 'waitress';
            if (m.trx_waitress_flg == 'Y') cardHeadStyle = 'delivered';

            cardDineIn += printHeader(`${m.meja_nama} - ${cardHeadStyle}`, cardHeadStyle, m.meja_id);
          } else {
            cardDineIn += printHeader(m.meja_nama, 'style-default', m.meja_id);
          }

          cardDineIn += printBodyMeja(m.area_nama, m.area_level, m.meja_cptcy);
          cardDineIn += printBodyIdentitasDinein(m.plg_nama, m.meja_id, m.meja_nama, m.plg_id, m.plg_notelp, m.trx_payment);
          cardDineIn += (m.trx_id) ? printTglDanJam(m) : '';
          cardDineIn += printClosedBody();
          cardDineIn += printBtnFooterMeja(m.plg_id, m.meja_id, m.meja_nama)
          cardDineIn += printFooter();
        })

        document.querySelector(`#order-target-${tipeTrx}`).innerHTML = cardDineIn;
      }
      fetchMeja()

    } else {
      let cardTrx = '';
      const fetchTrx = async () => {
        const response = await fetch("<?= base_url('pos/pos/fetch_all_transaksi_by_tipe/'); ?>" + tipeTrx);
        const data = await response.json();
        printTrx(data);
      }

      const printTrx = (data) => {
        const trx = data;
        trx.forEach(t => {
          let cardHeadStyle = 'cooking';
          if (t.trx_kitchen_flg == 'Y') cardHeadStyle = 'waitress';
          if (t.trx_waitress_flg == 'Y') cardHeadStyle = 'delivered';

          let cardHeadName = 'Take Away';
          if (t.trx_tipe == '3') cardHeadName = 'Mobil'
          if (t.trx_tipe == '4') cardHeadName = 'Delivery'

          let cardHeadPropName = `${t.trx_cust}`;
          if (t.trx_tipe == '3') cardHeadPropName = t.trx_table
          if (t.trx_tipe == '4') cardHeadPropName = t.trx_table

          cardTrx += printHeader(`${cardHeadName} - ${cardHeadStyle}`, cardHeadStyle);
          cardTrx += printBodyIdentitas(t.plg_nama, t.plg_notelp, t.trx_payment);
          cardTrx += printTglDanJam(t);
          cardTrx += printClosedBody();
          cardTrx += printBtnFooter(t.plg_id, t.plg_alamat, t.plg_platno)
          cardTrx += printFooter();
        })

        document.querySelector(`#order-target-${tipeTrx}`).innerHTML = cardTrx;
      }

      fetchTrx()
    }

    $(`#modal_transaksi_${tipeTrx}`).on('hidden.bs.modal', function() {
      document.querySelector(`#order-target-${tipeTrx}`).innerHTML = '';
    });
  }

  /* Print Card Header */
  const printHeader = (text, status = 'style-default', mejaId = "") => {
    let card = `
      <form role="form" id="${mejaId ? 'form-table-' + mejaId : ''}" method="post" action="<?= base_url('pos/pos/'); ?>">
        <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card">
            <div class="card-head ${status}">
              <h3 class="text-center text-light">${text}</h3>
            </div>
            <div class="card-body no-padding card-type-pricing">
              <ul class="list-unstyled">`;

    return card;
  }

  /* Print Card Body Area Lantai Kapasitas */
  const printBodyMeja = (area, lantai, kapasitas) => {

    let card = `<li>
                  <div class="clearfix">
                    <div class="pull-left">Area :</div>
                    <div class="pull-right"> ${area} </div>
                  </div>
                </li>
                <li>
                  <div class="clearfix">
                    <div class="pull-left">Lantai :</div>
                    <div class="pull-right"> ${lantai} </div>
                  </div>
                </li>
                <li>
                  <div class="clearfix">
                    <div class="pull-left">Kapasitas :</div>
                    <div class="pull-right"> ${kapasitas} </div>
                  </div>
                </li>`;

    return card;
  }

  /* Print Card Body Identitas */
  const printBodyIdentitasDinein = (nama = '', mejaId = '', mejaNama = '', plgId = '', telp = '', pembayaran = '', ) => {

    let card;
    if (!nama) {
      card = `<li>
              <div class="clearfix">
                <input class="form-control input-sm" id="plg-nama-meja-${mejaId}" name="nama" placeholder="nama pelanggan">
              </div>
            </li>
            <li>
              <div class="clearfix">
                <input class="form-control input-sm" id="plg-tlp-meja-${mejaId}" name="telp" placeholder="Tlp Pelanggan">
              </div>
            </li>
            <input type="hidden" name="plg_id" value="">
            <input type="hidden" name="meja_text" value="${mejaNama}">
            <input type="hidden" name="meja" value="${mejaId}">`;

      return card;
    }

    card = `<li>
              <div class="clearfix">
                <div class="pull-left">Nama :</div>
                <div class="pull-right"> ${nama} </div>
              </div>
            </li>
            <input type="hidden" name="nama" value="${nama}">
            <input type="hidden" name="plg_id" value="${plgId}">
            <input type="hidden" name="meja_text" value="${mejaNama}">
            <input type="hidden" name="meja" value="${mejaId}">`;

    (telp) &&
    (card += `<li>
                  <div class="clearfix">
                    <div class="pull-left">Telp :</div>
                    <div class="pull-right"> ${telp} </div>
                  </div>
                </li>
                <input type="hidden" name="telp" value="${telp}">
                `);

    (pembayaran) &&
    (card += `<li>
                  <div class="clearfix">
                    <div class="pull-left">Pembayaran :</div>
                    <div class="pull-right"> ${pembayaran} </div>
                  </div>
                </li>`);

    return card;
  }

  const printBodyIdentitas = (nama, telp = '', pembayaran = '') => {

    let card;
    card = `<li>
            <div class="clearfix">
              <div class="pull-left">Nama :</div>
              <div class="pull-right"> ${nama} </div>
            </div>
          </li>`;

    (telp) &&
    (card += `<li>
                <div class="clearfix">
                  <div class="pull-left">Telp :</div>
                  <div class="pull-right"> ${telp} </div>
                </div>
              </li>`);

    (pembayaran) &&
    (card += `<li>
                <div class="clearfix">
                  <div class="pull-left">Pembayaran :</div>
                  <div class="pull-right"> ${pembayaran} </div>
                </div>
              </li>`);

    return card;
  }


  /* Print Tgl + Jam */
  const printTglDanJam = (trx) => {
    const date = new Date(trx.trx_date);
    const card = `
              <li>
                <div class="text-center">
                  <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()}</div>
                  <h4 class="dispTime-${trx.trx_id}-${date.getTime()}"></h4>
                </div>
              </li>`;

    setInterval(() => {
      let today = new Date();
      let dispTime = new Date((today - date));
      let h = dispTime.getUTCHours();
      let m = dispTime.getUTCMinutes();
      let s = dispTime.getUTCSeconds();
      m = (m < 10) ? `0${m}` : m;
      s = (s < 10) ? `0${s}` : s;

      timercard = `${h} : ${m} : ${s}`;
      $(`.dispTime-${trx.trx_id}-${date.getTime()}`).html(timercard);
    }, 1000);

    return card;
  }

  /* Print Notes */
  const printNotes = (notes) => {

    const card = `
              <li>
                <div class="clearfix">
                  <div class="pull-left">Cust Notes :</div>
                  <div class="pull-right"> ${notes} </div>
                </div>
              </li>`;

    return card;
  }

  /* Print closed body */
  const printClosedBody = () => {
    const card = `
            </ul>
          </div>`;

    return card;
  }

  /* Print Button Footer */
  const printBtnFooterMeja = (plgId, mejaId, mejaNama, isOrdered = false) => {
    let card = `
          <div class="card-body no-padding card-type-pricing">
            <div class="card-body text-center">
              <button data-dismiss="modal" aria-hidden="true" onClick="addTableOrder(${mejaId})" class="btn btn-primary btn-raised select-table">Pilih</button>`;

    isOrdered ?
      card += `
              <a href="<?= base_url('pos/pos/') ?>batalkan_pemesanan_mobile/${plgId}"
                onClick="return confirm(Apakah anda yakin?)" class="btn btn-flat btn-raised text-danger">Cancel</a>
            </div>
          </div>` :
      card += `
              <a onclick="clearSeat('${mejaId}','${mejaNama}')" class="btn btn-primary btn-flat btn-raised" type="submit">Clear</a>
            </div>
          </div>`;

    return card;
  }

  const printBtnFooter = (plgId, plgAlamat, plgPlatno) => {
    let card = `
          <div class="card-body no-padding card-type-pricing">
            <input type="hidden" name="plg_id" value="${plgId}">`;

    card += plgAlamat ? `<input type="hidden" name="plg_alamat" value="${plgAlamat}">` : '';
    card += plgPlatno ? `<input type="hidden" name="plg_platno" value="${plgPlatno}">` : '';

    card += `
            <div class="card-body text-center">
              <button class="btn btn-primary btn-raised" type="submit">Pilih</button>
              <a href="<?= base_url('pos/pos/') ?>batalkan_pemesanan_mobile/${plgId}"
                onClick="return confirm(Apakah anda yakin?)" class="btn btn-flat btn-raised text-danger">Cancel</a>
            </div>
          </div>`;

    return card;
  }

  /* Print Footer */
  const printFooter = () => {
    const card = `
        </div> 
      </div> 
    </form>`;

    return card;
  }


  function clearSeat(id, nama) {
    console.log(id)
    console.log(nama)
    $.ajax({
      url: "<?= base_url('pos/pos/clear_seat/'); ?>",
      method: "POST",
      data: {
        row_id: id,
      },
      dataType: 'json',
      success: function(data) {
        console.log(data)
        let input1 = document.querySelector(`#plg-nama-meja-${id}`);
        let input2 = document.querySelector(`#list-${id}-hidden`);
        input1.parentNode.parentElement.querySelector('.card-head').setAttribute("class", "card-head style-default");
        input1.parentNode.parentElement.querySelector(`h3.nama-meja`).innerHTML = nama;
        input1.removeAttribute('readonly');
        input1.value = '';
        input2.value = '';
      }
    });
  }
</script>

<script type="text/javascript">
  $(function() {
    reloadMobileOrder();
    setTimeout(() => {
      document.querySelector('#loading-screen').style.display = 'none';
      document.querySelector('#base').style.display = 'block';

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
    }, 500)
  })
</script>


</div>
</div>
</body>

</html>