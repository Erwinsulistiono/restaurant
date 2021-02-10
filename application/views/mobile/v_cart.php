<!DOCTYPE html>
<html lang="en">

<head>
  <title>Mi Resto</title>

  <!-- BEGIN META -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url('assets/img/logo.png'); ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/materialadmin.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style-material.css'); ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" />
</head>

<body class="full-content">

  <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" />
  <div id="base">

    <section class="style-default no-padding">
      <div class="card" style="min-height:100vh">
        <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
          <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left "></span> Back</button>
        </div>
        <div class="container-fluid no-padding">
          <div class="col-xs-12 col-sm-12 no-padding">
            <div class="card no-margin">
              <div class="card-body" style="overflow-y:scroll; height:90vh; margin-top:7vh;">
                <div class="pull-right">
                  <h4></h4>
                </div>
                <form role="form" id="order_form" method="post" action="<?= base_url('mobile/pos/confirm_order/'); ?>">
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
                      <tbody id="detail-cart">

                      </tbody>
                      </tfoot>
                      <tr>
                        <th style="text-align:left;" colspan="3">Sub Total</th>
                        <th style="text-align:center;" colspan="3"><input class="form-control" id="subTotal" name="subtotal" readonly>
                        </th>
                      </tr>
                      <div class="form-group">
                        <tr>
                          <th style="text-align:left;" colspan="3">Discount
                          <th style="text-align:center;" colspan="3">
                            <input type="text" class="form-control" id="discount" onkeyup="calculateGrandTotal()" name="discount" readonly>
                          </th>
                        </tr>
                      </div>
                      <div class="form-group">
                        <tr>
                          <th style="text-align:left;" colspan="3">Service Charge (<?= $taxservice ?>%)
                          <th style="text-align:center;" colspan="3">
                            <input class="form-control" id="totalService" name="totalservice" readonly>
                          </th>
                        </tr>
                      </div>
                      <div class="form-group">
                        <tr>
                          <th style="text-align:left;" colspan="3">Pajak Resto (<?= $taxresto ?>%)
                          <th style="text-align:center;" colspan="3">
                            <input class="form-control" id="totalPph" name="totalpph" readonly>
                          </th>
                        </tr>
                      </div>
                      <div class="form-group">
                        <tr>
                          <th style="text-align:left;" colspan="3">Grand Total</th>
                          <th style="text-align:center;" colspan="3">
                            <input class="form-control" id="grandTotal" name="grandtotal" readonly>
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
                  <div class="btn-raised dropup">
                    <button type="button" class="btn btn-block btn-primary dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                      Confirm Order<div class="pull-right"><span class="caret"></span></div>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a class="simpanPembayaran" id="openTable">Open Table</a></li>
                      <?php
                      foreach ($payment as $k) :
                        $k_id = $k['payment_id'];
                        $k_nama = $k['payment_nama'];
                      ?>
                        <li><a href="#" data-toggle="modal" data-target="#modal_bayar<?= $k_id ?>"><?= $k_nama; ?></a></li>
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
      </div>
    </section>

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
              <form id="form-payment-<?= $k_id ?>">
                <div class="card-body">
                  Proses pemesanan makanan sudah selesai.
                  Silahkan ke kasir untuk melakukan pembayaran.
                </div>
                <div class="modal-footer">
                  <button class="simpanPembayaran btn btn-success btn-raised" data-paymentid="<?= $k_id; ?>" data-paymentnama="<?= $k_nama; ?>">Ok</button>
                  <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Cancel</button>
                </div>
              </form>
            <?php elseif (empty($k_qr)) : ?>
              <form id="form-payment-<?= $k_id ?>">
                <div class="card-body">
                  Proses pemesanan makanan sudah selesai.
                  Silahkan ke kasir untuk melakukan pembayaran.
                </div>
                <div class="modal-footer">
                  <button class="simpanPembayaran btn btn-success btn-raised" data-paymentid="<?= $k_id; ?>" data-paymentnama="<?= $k_nama; ?>">Ok</button>
                  <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Cancel</button>
                </div>
              </form>
            <?php else : ?>
              <form id="form-payment-<?= $k_id ?>">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12">
                        <label class="col-xs-4 control-label">Grand Total</label>
                        <div class="col-xs-7">
                          <input type="text" name="trx_grand_total" class="form-control grandTotalModal" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" style="visibility:<?= $type ?>">
                    <div class="row">
                      <div class="col-xs-12">
                        <label for="nomorKartu" class="col-xs-4 control-label">No.HP/Kartu *</label>
                        <div class="col-xs-7">
                          <input type="<?= $type ?>" name="trx_cardno" class="form-control" id="nomorKartu<?= $k_id ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" style="visibility:<?= $type ?>">
                    <div class="row">
                      <div class="col-xs-12">
                        <label for="nomorReff" class="col-xs-4 control-label">Reff ID</label>
                        <div class="col-xs-7">
                          <input type="<?= $type ?>" name="trx_payreff" class="form-control" id="nomorReff<?= $k_id ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-sm-12 text-center">
                          <?php if ($k['payment_qrcode']) :
                            $qr_code = $k['payment_qrcode'];
                          ?>
                            <img src="<?= base_url("assets/img/${qr_code}"); ?>" id="qrcode<?= $k_id ?>" class="img-responsive">
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
                  <a class="simpanPembayaran btn btn-success btn-raised" data-paymentid="<?= $k_id; ?>" data-paymentnama="<?= $k_nama; ?>">Ok</a>
                  <button class="btn btn-danger btn-raised" data-dismiss="modal" aria-hidden="true">Cancel</button>
                </div>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="modal fade" id="modal_add_voucher" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" style="margin-top:9vh">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
              <span class="fa fa-times"></span></button>
          </div>
          <div class="msg"></div>
          <form class="form-horizontal" id="form-voucher" action="<?= base_url('mobile/pos/voucher_tandc') ?>" method="post">
            <div class="modal-body">
              <div class="form-group target-validasi">
                <label class="col-sm-3 control-label">Input Nomor Voucher</label>
                <div class="col-sm-8">
                  <input type="text" name="title" id="voucher_input" class="voucher_discount form-control">
                  <span class="checklist has-feedback form-control-feedback"></span>
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
              <a id="check_tandc" class="btn btn-primary btn-raised btn-flat" href="<?= base_url('mobile/pos/voucher_tandc') ?>">Check</a>
              <a id="add_voucher" class="btn btn-primary btn-raised" data-dismiss="modal" aria-hidden="true">add</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    const clearFormating = (value) => Number(value.value.replace(/[($)\s\._\-]+/g, ''))
    const assignFormatingValueToElement = (element, value) => element.value = (Number(value).toLocaleString('id-ID'))
    const dividedByOneHundred = (value) => (value / 100)
    const taxResto = parseInt('<?= $taxresto ?>')
    const taxService = parseInt('<?= $taxservice ?>')
    let dataVoucher = {};
    let voucher_id = '';
    let voucher_nominal = '';
    let carts = JSON.parse(sessionStorage.getItem('shoppingCart'));

    let displayCart = () => {
      let el = "";
      let subTotal = 0;
      carts.forEach(cart => {
        subTotal += Number(cart.price)
        el += `<tr>
        <td> ${cart.name} - ${cart.notes} </td>
        <td> ${Number(cart.price)} </td>
        <td> ${Number(cart.count)} </td>
        <td> ${Number(cart.count * cart.price)} </td>
        <td class="text-right">
        <a href="#" class="text-danger btn btn-icon-toggle btn-raised delete-item"
        data-id="${cart.id}" title="hapus pesanan" data-notes="${cart.notes}" data-name="${cart.name}">
        <i class="fa fa-trash"></i></a>
        </td>
        <tr>`;
      })

      totalTaxResto = (subTotal * dividedByOneHundred(taxResto));
      totalServiceCharge = (subTotal * dividedByOneHundred(taxService));
      assignFormatingValueToElement(document.querySelector('#subTotal'), subTotal);
      assignFormatingValueToElement(document.querySelector('#totalService'), totalServiceCharge);
      assignFormatingValueToElement(document.querySelector('#totalPph'), totalTaxResto);
      document.querySelector('#detail-cart').innerHTML = el;

      hitungGrandTotal();
      let buttonsDelete = document.querySelectorAll('.delete-item')

      buttonsDelete.forEach((button) => {
        button.addEventListener('click', (event) => {
          let id = event.currentTarget.dataset.id;
          for (var item in carts) {
            if (carts[item].id === Number(id)) {
              carts.splice(item, 1)
            }
          }
          console.log(carts)
          saveCart()
          displayCart()
        });
      });
    }

    function hitungGrandTotal() {
      let subTotal = clearFormating(document.querySelector('#subTotal'))
      let totalServiceCharge = clearFormating(document.querySelector('#totalService'))
      let totalPph = clearFormating(document.querySelector('#totalPph'))
      let discount = (document.querySelector('#discount').value == '') ? 0 : clearFormating(document.querySelector('#discount'))
      grandTotal = subTotal + totalTaxResto + totalServiceCharge - discount;
      assignFormatingValueToElement(document.querySelector('#grandTotal'), grandTotal);
      document.querySelectorAll('.grandTotalModal').forEach(el => {
        assignFormatingValueToElement(el, grandTotal);
      })
    }

    function saveCart() {
      sessionStorage.setItem('shoppingCart', JSON.stringify(carts));
    }
  </script>

  <script>
    document.querySelector('#check_tandc').addEventListener('click', (e) => {
      e.preventDefault()
      const kodeDiskon = $('#voucher_input').val();
      const msg = document.querySelector('.msg')
      const grandTotal = Number(document.querySelector('#grandTotal').value.replace(/[($)\s\._\-]+/g, ''))
      const inputForm = document.querySelector('.target-validasi')
      const checklistInput = document.querySelector('.checklist')

      var checkVoucher = async () => {
        const response = await fetch(`${e.target.href}/${kodeDiskon}`, {
          method: 'GET'
        })
        const result = await response.json()
        const data = await result[0];
        const tandc = Number(data.voucher_min_tandc)
        let state
        let icon

        if (grandTotal < tandc) {
          msg.innerHTML = `<div class="alert alert-warning animate">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Syarat min total pembelian belum cukup</div>`;
          state = 'has-warning';
          icon = 'fa-times';
        } else {
          state = 'has-success';
          icon = 'fa-check';
          voucher_id = Number(data.voucher_id);
          voucher_nominal = (data.voucher_nominal != 0) ? data.voucher_nominal : data.voucher_discount;
        }

        inputForm.classList.add(state)
        checklistInput.classList.add('fa')
        checklistInput.classList.add(icon)

        setTimeout(() => {
          msg.innerHTML = '';
          inputForm.classList.remove(state)
          checklistInput.classList.remove(icon)
        }, 3000)
      }

      checkVoucher();
    })

    document.querySelector('#add_voucher').addEventListener('click', (e) => {
      const kodeDiskon = $('#voucher_input').val();
      const url = "<?= base_url('mobile/pos/voucher_tandc'); ?>";
      const grandTotal = Number(document.querySelector('#grandTotal').value.replace(/[($)\s\._\-]+/g, ''))

      var checkVoucher = async () => {
        const response = await fetch(`${url}/${kodeDiskon}`, {
          method: 'GET'
        })
        const result = await response.json()
        const data = await result[0];
        const tandc = Number(data.voucher_min_tandc)

        if (grandTotal < tandc) {
          return true
        }

        voucher_id = Number(data.voucher_id);
        voucher_nominal = (data.voucher_nominal != 0) ? data.voucher_nominal : data.voucher_discount;

        if (data.voucher_nominal == 0) {
          let discount = clearFormating(document.querySelector('#subTotal')) * dividedByOneHundred(data.voucher_discount);
          assignFormatingValueToElement(document.querySelector('#discount'), discount);
        } else {
          assignFormatingValueToElement(document.querySelector('#discount'), voucher_nominal);
        }

        hitungGrandTotal();
        return true
      }

      checkVoucher();
    })
  </script>

  <script>
    let simpanPembayaran = document.querySelectorAll('.simpanPembayaran');
    let payment_id;
    let payment_nama;
    let customerId

    function confirmOrder() {
      const url = '<?= base_url('mobile/pos/confirm_order'); ?>'
      const customer = JSON.parse(sessionStorage.getItem('order'))
      const db = JSON.parse(sessionStorage.getItem('db'))
      let nomor_kartu = document.querySelector(`#nomorKartu${payment_id}`) ? document.querySelector(`#nomorKartu${payment_id}`).value : '';
      let nomor_reff = document.querySelector(`#nomorReff${payment_id}`) ? document.querySelector(`#nomorReff${payment_id}`).value : '';
      const data = {
        customerId: customerId,
        cart: carts,
        cust_nama: customer.plg_nama,
        cust_platno: (customer.plg_platno) ? customer.plg_platno : '',
        cust_telp: (customer.plg_notelp) ? customer.plg_notelp : nomor_kartu,
        cust_notes: (customer.notes) ? customer.notes : '',
        cust_meja: (customer.meja_pelanggan) ? customer.meja_pelanggan : '',
        cust_alamat: (customer.plg_alamat) ? customer.plg_alamat : '',
        tipe_transaksi: customer.tipe_transaksi,
        voucher_id: voucher_id,
        payment_id: payment_id,
        payment_nama: payment_nama,
        nomor_kartu: nomor_kartu,
        nomor_reff: nomor_reff,
        db: db,
      }

      async function postOrder() {
        const response = await fetch(url, {
          method: 'POST',
          headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result) {
          carts = [];
          saveCart();
          sessionStorage.setItem('dataPelanggan', JSON.stringify(result));
          alert("berhasil order");
          window.location.href = "<?= base_url('order/outlet/'); ?>" + db;
          return false;
        }
      }

      postOrder()
    }

    function paidOrder() {
      const url = '<?= base_url('mobile/pos/paid_order'); ?>';
      const db = JSON.parse(sessionStorage.getItem('db'))
      let nomor_kartu = document.querySelector(`#nomorKartu${payment_id}`) ? document.querySelector(`#nomorKartu${payment_id}`).value : '';
      let nomor_reff = document.querySelector(`#nomorReff${payment_id}`) ? document.querySelector(`#nomorReff${payment_id}`).value : '';
      const data = {
        customerId: customerId,
        voucher_id: voucher_id,
        payment_id: payment_id,
        payment_nama: payment_nama,
        nomor_kartu: nomor_kartu,
        nomor_reff: nomor_reff,
        db: db,
      }

      async function paid() {
        const response = await fetch(url, {
          method: 'POST',
          headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result) {
          (result) && alert(result);
          // (result) && sessionStorage.clear();

          window.location.href = "<?= base_url('order/outlet/') ?>" + db;
          return false;
        } else {
          alert('gagal');
        }
      }

      paid()
    }

    simpanPembayaran.forEach(bayar => {
      bayar.addEventListener('click', (e) => {
        e.preventDefault();
        payment_id = (event.currentTarget.dataset.paymentid) ? event.currentTarget.dataset.paymentid : 'Open Table';
        payment_nama = (event.currentTarget.dataset.paymentnama) ? event.currentTarget.dataset.paymentnama : 'Open Table';
        customerId = ((sessionStorage.getItem('dataPelanggan')) ? JSON.parse(sessionStorage.getItem('dataPelanggan')).plg_id : 0);

        (customerId) ? paidOrder(): confirmOrder();
      })
    })
  </script>

  <script>
    let trxTipe = JSON.parse(sessionStorage.getItem('order')).tipe_transaksi;
    (Number(trxTipe) != 1) && (document.querySelector('#openTable').style.display = 'none');
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const customer = JSON.parse(sessionStorage.getItem('order'))

      if (customer.plg_notelp) {
        let el = document.querySelectorAll('input[id^="nomorKartu"]')

        el.forEach(e => {
          e.value = customer.plg_notelp
        })
      }

      setTimeout(() => {
        document.querySelector('#loading-screen').style.display = 'none';
        document.querySelector('#base').style.display = 'block';
      }, 1000)
      displayCart()
    })
  </script>

  <script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>
</body>

</html>