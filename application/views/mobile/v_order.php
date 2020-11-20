<section class="style-default no-padding no-margin">
  <div class="container-fluid no-padding">
    <div class="col-xs-12 col-sm-12 no-padding">
      <div class="card no-margin">
        <div class="card-body" style="overflow-y:scroll; height:90vh">
          <div class="pull-right">
            <h4><?php ($table && print($table['meja_nama'])); ?></h4>
          </div>
          <form role="form" id="order_form" method="post" action="<?= base_url() . 'mobile/pos/confirm_order/'; ?>">
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
                    <tr>
                      <td><?= $c['name'] . ' - ' . $c['options']['notes']; ?></td>
                      <td><?= $c['price']; ?></td>
                      <td><?= $c['qty']; ?></td>
                      <td><?= $c['subtotal']; ?></td>
                      <td class="text-right">
                        <a href="#" class="hapus_cart btn btn-icon-toggle btn-raised" id="<?= $c['rowid']; ?>" title="hapus pesanan">
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
                  <th style="text-align:center;" colspan="3"><input class="form-control" id="subTotal" name="subtotal" value="<?= number_format($valueSubTotal, 0, '', '.'); ?>" readonly>
                  </th>
                </tr>
                <div class="form-group">
                  <tr>
                    <?php (isset($valueDiscount)) ? $valueDiscount = $valueDiscount : $valueDiscount = 0; ?>
                    <th style="text-align:left;" colspan="3">Discount
                      <input type="text" id="percentageDiscount" onkeyup="calculateDiscount(value)" style="width: 55px;height: 10px;padding:10px;" name="discount" autocomplete="off" readonly> %</th>
                    <th style="text-align:center;" colspan="3">
                      <input type="text" class="form-control" id="discount" onkeyup="calculateGrandTotal()" name="discount" value="<?= number_format($valueDiscount, 0, '', '.'); ?>" readonly>
                    </th>
                  </tr>
                </div>
                <div class="form-group">
                  <?php $valueServiceCharge = ($valueSubTotal * $taxservice / 100); ?>
                  <tr>
                    <th style="text-align:left;" colspan="3">Service Charge (<?= $taxservice ?>%)
                    <th style="text-align:center;" colspan="3">
                      <input class="form-control" id="totalService" name="totalservice" value="<?= number_format($valueServiceCharge, 0, '', '.'); ?>" readonly>
                    </th>
                  </tr>
                </div>
                <div class="form-group">
                  <?php $valuePpn = ($valueSubTotal * $taxresto / 100); ?>
                  <tr>
                    <th style="text-align:left;" colspan="3">Pajak Resto (<?= $taxresto ?>%)
                    <th style="text-align:center;" colspan="3">
                      <input class="form-control" id="totalPph" name="totalpph" value="<?= number_format($valuePpn, 0, '', '.'); ?>" readonly>
                    </th>
                  </tr>
                </div>
                <div class="form-group">
                  <?php $valueGrandTotal = $valueSubTotal - ($valueDiscount) + $valueServiceCharge + $valuePpn ?>
                  <tr>
                    <th style="text-align:left;" colspan="3">Grand Total</th>
                    <th style="text-align:center;" colspan="3">
                      <input class="form-control" id="grandTotal" name="grandtotal" value="<?= number_format($valueGrandTotal, 0, '', '.'); ?>" readonly>
                    </th>
                  </tr>
                </div>
                </tfoot>
              </div>
            </table>
        </div>
      </div>
      <div class="card-body no-padding" style="height:10vh">
        <div class="row">
          <div class="col-xs-6 no-padding" id="methodOfPayment">
            <div class="">
              <button type="button" class="btn btn-block btn-primary dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                Confirm Order<div class="pull-right"><span class="caret"></span></div>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#" class="simpanPembayaran">Open Table</a></li>
                <?php
                foreach ($payment as $k) :
                  $k_id = $k['payment_id'];
                  $k_nama = $k['payment_nama'];
                ?>
                  <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>" onclick="getGrandTotal()"><?= $k_nama; ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <div class="col-xs-6 no-padding">
            <a href="#" class="btn btn-block btn-default-dark btn-raised" data-toggle="modal" data-target="#modal_add_voucher">Add Voucher</a>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</section>


<div class="modal fade" id="modal_add_voucher" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
      </div>
      <form class="form-horizontal" id="form_search" action="#" method="post">
        <div class="modal-body">
          <div class="form-group target-validasi">
            <label class="col-sm-3 control-label">Input Nomor Voucher</label>
            <div class="col-sm-8">
              <input type="hidden" name="voucher_id" class="potong_voucher_id">
              <input type="hidden" name="id" id="voucher_id" class="voucher_discount form-control">
              <input type="text" name="title" id="voucher_input" class="voucher_discount form-control">
            </div>
          </div>
          <div class="form-group" hidden>
            <label class="col-sm-3 control-label">Terms and Condition</label>
            <div class="col-sm-8">
              <textarea type="text" class="form-control" id="voucher_tandc"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a id="check_tandc" class="btn btn-primary btn-raised btn-flat">Check</a>
          <a id="add_voucher" class="btn btn-primary btn-raised" data-dismiss="modal" aria-hidden="true">add</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
foreach ($payment as $k) :
  $k_id = $k['payment_id'];
  $k_nama = $k['payment_nama'];
  $k_rek = $k['payment_norek'];
  $k_qr = $k['payment_qrcode'];
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
          <h3 class="modal-title" id="myModalLabel">Pembayaran <?= $k_nama; ?></h3>
        </div>
        <?php
        if (!$k_rek) : ?>
          <form>
            <div class="card-body">
              Proses pemesanan makanan sudah selesai.
              Silahkan ke kasir untuk melakukan pembayaran.
            </div>
            <div class="modal-footer">
              <button class="simpanPembayaran btn btn-success btn-raised" data-paymentid="<?= $k_id; ?>" data-paymentnama="<?= $k_nama; ?>">Proses</button>
              <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Cancel</button>
            </div>
          </form>
        <?php elseif (empty($k_qr)) : ?>
          <form>
            <div class="card-body">
              Proses pemesanan makanan sudah selesai.
              Silahkan ke kasir untuk melakukan pembayaran.
            </div>
            <div class="modal-footer">
              <button class="simpanPembayaran btn btn-success btn-raised" data-paymentid="<?= $k_id; ?>" data-paymentnama="<?= $k_nama; ?>">Proses</button>
              <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Cancel</button>
            </div>
          </form>
        <?php else : ?>
          <form>
            <div class="card-body">
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-12">
                    <label class="col-xs-4 control-label">Grand Total</label>
                    <div class="col-xs-7">
                      <input type="text" name="trx_grand_total" value="<?= $valueGrandTotal; ?>" class="form-control grandTotalModal" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group" style="visibility:<?= $type ?>">
                <div class="row">
                  <div class="col-xs-12">
                    <label for="nomorKartu" class="col-xs-4 control-label">No.HP/Kartu *</label>
                    <div class="col-xs-7">
                      <input type="<?= $type ?>" name="trx_cardno" class="form-control" id="nomorKartu" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group" style="visibility:<?= $type ?>">
                <div class="row">
                  <div class="col-xs-12">
                    <label for="nomorReff" class="col-xs-4 control-label">Reff ID *</label>
                    <div class="col-xs-7">
                      <input type="<?= $type ?>" name="trx_payreff" class="form-control" id="nomorReff" required>
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
            <div class="card-body">
              Silahkan scan qrcode dan lakukan pembayaran.
              Masukan no-reff transaksi dan no-handphone pada kolom yang telah disediakan. (Required*)
            </div>
            <div class="modal-footer">
              <a class="simpanPembayaran btn btn-success btn-raised" data-paymentid="<?= $k_id; ?>" data-paymentnama="<?= $k_nama; ?>">Proses</a>
              <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Cancel</button>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<script src="<?= base_url() . 'assets/js/jquery-3.4.1.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/socket.io/dist/socket.io.js' ?>"></script>

<script type="text/javascript">
  /* GLOBAL VAR */
  const clearFormating = (value) => Number(value.val().replace(/[($)\s\._\-]+/g, ''));
  const assignFormatingValueToElement = (element, value) => element.val(Number(value).toLocaleString('id-ID'));
  const dividedByOneHundred = (value) => (value / 100);
  let cart = JSON.parse('<?php echo json_encode($cart) ?>');
  let pajakResto = '<?= $taxresto ?>';
  let serviceCharge = '<?= $taxservice ?>';

  $(document).keydown(function(e) {
    if (e.which == 116 || e.keyCode == 82 && e.ctrlKey) { //116 = F5
      let data = {
        cart: cart,
      }
      $.ajax({
        url: '<?= base_url(); ?>mobile/pos/update_cart',
        method: "POST",
        data: data,
        dataType: 'json',
      });
      return true;
    }
  });


  //check T&C
  $('#check_tandc').click(function(event) {
    event.preventDefault();
    var kodeDiskon = $('#voucher_input').val();
    $.ajax({
      url: '<?= base_url(); ?>mobile/pos/voucher_tandc',
      method: "POST",
      data: {
        kodeDiskon: kodeDiskon,
      },
      dataType: 'json',
      success: function(data) {
        let terms = data[0].voucher_syarat;
        let id = data[0].voucher_id;
        let inputForm = $('.target-validasi');
        let checklistState = '<span class="fa fa-check form-control-feedback"></span>';
        inputForm.addClass('has-success').addClass('has-feedback');
        inputForm.append(checklistState);
        $("#voucher_id").val(id);
      },
    });
  })

  /* USE VOUCHER */
  $('#add_voucher').click(function() {
    var id = $("#voucher_id").val();
    $.ajax({
      url: '<?= base_url(); ?>mobile/pos/voucher',
      method: "POST",
      data: {
        id: id,
      },
      dataType: 'json',
      success: function(data) {
        let isNominal = data.voucher_nominal;
        let isPercentage = data.voucher_discount;
        (isNominal) && assignFormatingValueToElement($("#discount"), data.voucher_nominal);
        (isPercentage) && calculateDiscount(data.voucher_discount);
        $(".potong_voucher_id").val(data.voucher_id);
        $('#modal_add_voucher').modal('hide');
      },
    })
  })

  let printPrice = () => {
    let grandTotal = Object.values(cart)
      .map(c => c.subtotal)
      .reduce((c, curr) => c + curr, 0)
    let totalTaxResto = (grandTotal * (pajakResto / 100));
    let totalServiceCharge = (grandTotal * (serviceCharge / 100));
    $('#subTotal').val(Number(grandTotal).toLocaleString('id-ID'));
    $('#totalService').val(Number(totalServiceCharge).toLocaleString('id-ID'));
    $('#totalPph').val(Number(totalTaxResto).toLocaleString('id-ID'));
    calculateGrandTotal();
  }

  //menghapus element diluar script
  $(document).on('click', '.hapus_cart', function() {
    var row_id = $(this).attr("id");
    $(`#${row_id}`).parent().parent().remove();
    Object.keys(cart)
      .filter(key => key == row_id)
      .forEach(key => delete cart[key]);
    printPrice()
  })

  let calculateDiscount = percentage => {
    document.getElementById("discount").readOnly = true;
    assignFormatingValueToElement($("#percentageDiscount"), percentage);
    let subTotal = clearFormating($("#subTotal"));
    let discount = (dividedByOneHundred(percentage) * subTotal);
    assignFormatingValueToElement($("#discount"), discount);
  }

  let calculateGrandTotal = () => {
    let discount = clearFormating($("#discount"));
    let subTotal = clearFormating($("#subTotal"));
    let totalPph = clearFormating($("#totalPph"));
    let totalService = clearFormating($("#totalService"));
    let grandTotal = subTotal - discount + totalPph + totalService;
    assignFormatingValueToElement($("#grandTotal"), grandTotal);
  }

  let getGrandTotal = () => {
    let grandTotal = clearFormating($("#grandTotal"));
    assignFormatingValueToElement($(".grandTotalModal"), grandTotal);
  }

  $(".simpanPembayaran").click(function(e) {
    e.preventDefault();
    let data = {
      cart: cart,
      voucher_id: $('#voucher_id').val(),
      payment_id: $(this).data("paymentid"),
      payment_nama: $(this).data("paymentnama"),
      nomor_kartu: $("#nomorKartu").val(),
      nomor_reff: $("#nomorReff").val(),
    };
    $.ajax({
      url: "<?= base_url('mobile/pos/confirm_order') ?>",
      method: "POST",
      data: data,
      type: "json",
      async: false,
      success: function(data) {
        const url = "<?= base_url('order/outlet/'); ?>" + JSON.parse(data);
        location.replace(url);
      },
      error: function(err) {
        console.log('error simpan')
      }
    });
  })
</script>
</div>
</div>
</body>

</html>