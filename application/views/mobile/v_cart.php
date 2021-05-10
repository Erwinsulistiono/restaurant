<body class="full-content">

  <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
  <div id="base" style="display: none;">
    <!-- BEGIN BASE-->
    <section class="style-default no-margin" style="padding-bottom: 7vh;">
      <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:10001">
        <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left" aria-hidden="true"></span> Back</button>
      </div>
      <div class="container-fluid no-padding" style="min-height:87vh; margin-top:5vh;">
        <div class="col-md-12 col-xs-12 col-sm-12 no-padding">
          <form role="form" id="order_form" method="post" action="<?= base_url('mobile/pos/confirm_order/'); ?>">
            <table class="table no-margin">
              <div class="caption">
                <tbody id="detail-cart">

                </tbody>
                </tfoot>
                <tr>
                  <td style="text-align:left;" colspan="3">Sub Total</td>
                  <th colspan="3"><input style="text-align:center;" class="form-control" id="subTotal" name="subtotal" readonly>
                  </th>
                </tr>
                <div class="form-group">
                  <tr>
                    <td style="text-align:left;" colspan="1">Discount
                    <th style="text-align:right;" colspan="2">
                      <a href="#" style="color:#1a0dab;" data-toggle="modal" data-target="#modal_add_voucher"><strong><ins>Voucher</ins></strong></a>
                    <th colspan="3">
                      <input style="text-align:center;" type="text" class="form-control" id="discount" onkeyup="calculateGrandTotal()" name="discount" readonly>
                      </td>
                  </tr>
                </div>
                <div class="form-group">
                  <tr>
                    <td style="text-align:left;" colspan="3">Service Charge (<?= $taxservice ?>%)</td>
                    <th colspan="3">
                      <input style="text-align:center;" class="form-control" id="totalService" name="totalservice" readonly>
                    </th>
                  </tr>
                </div>
                <div class="form-group">
                  <tr>
                    <td style="text-align:left;" colspan="3">Pajak Resto (<?= $taxresto ?>%)</td>
                    <th colspan="3">
                      <input style="text-align:center;" class="form-control" id="totalPph" name="totalpph" readonly>
                    </th>
                  </tr>
                </div>
                <div class="form-group">
                  <tr>
                    <td style="text-align:left;" colspan="3">Grand Total</td>
                    <th colspan="3">
                      <input style="text-align:center;" class="form-control" id="grandTotal" name="grandtotal" readonly>
                    </th>
                  </tr>
                </div>

                </tfoot>
              </div>
            </table>
        </div>
      </div>
    </section>
    <div class="row" style="position:fixed; bottom:0; left:0; right:0;">
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
  </div>
  </form>


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
                      <label for="nomorKartu" class="col-xs-4 control-label">No.HP/Kartu <sup style="color: red;">&#10038<sup></label>
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
                Masukan no-reff transaksi dan no-handphone pada kolom yang telah disediakan. (Required<sup style="color: red;">&#10038<sup>)
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
        el +=
          `<tr>
            <th colspan="3" style="width:95%; font-weight:bold; padding-left:1em;"><em> ${Number(cart.count)} x </em> &nbsp;&nbsp;&nbsp; 
            <b><strong>${cart.name} ${cart.notes && ' - (' + cart.notes + ')'} </strong></b><br/>
            <p style="color:#1a0dab;"><strong><ins>(Edit)</strong></ins></p> 
            </th>
            <th colspan="2" class="text-right" style="padding-right:2em;"> ${Number(cart.count * cart.price)}</th>
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
          msg.innerHTML =
            `<div class="alert alert-warning animate">
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
      const url = '<?= base_url('mobile/pos/confirm_order'); ?>';
      const customer = JSON.parse(sessionStorage.getItem('order'));
      const db = JSON.parse(sessionStorage.getItem('db'));
      customerId = customer.plg_id ? customer.plg_id : customerId;
      let nomor_kartu = document.querySelector(`#nomorKartu${payment_id}`) ? document.querySelector(`#nomorKartu${payment_id}`).value : '';
      let nomor_reff = document.querySelector(`#nomorReff${payment_id}`) ? document.querySelector(`#nomorReff${payment_id}`).value : '';
      let discount = clearFormating(document.querySelector('#discount'));
      const data = {
        customerId: customerId,
        cart: carts,
        cust_nama: customer.plg_nama,
        cust_platno: (customer.plg_platno) ? customer.plg_platno : '',
        cust_telp: (customer.plg_notelp) ? customer.plg_notelp : nomor_kartu,
        cust_notes: (customer.notes) ? customer.notes : '',
        cust_meja: (customer.meja_pelanggan) ? customer.meja_pelanggan : '',
        cust_alamat: (customer.plg_alamat) ? customer.plg_alamat : '',
        cust_status: (customer.plg_status) ? customer.plg_status : '',
        cust_discount: discount,
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
          window.location.href = "<?= base_url('order/'); ?>";
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
          alert("berhasil bayar");
          window.location.href = "<?= base_url('order/') ?>";
          return false;
        } else {
          alert('gagal bayar');
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

      displayCart()

      setTimeout(() => {
        document.querySelector('#loading-screen').style.display = 'none';
        document.querySelector('#base').style.display = 'block';

        if (customer.plg_status == 'member') {
          let subtotal = document.querySelector('#subTotal').value.replace('.', '');
          assignFormatingValueToElement(document.querySelector('#discount'), (parseInt(subtotal) / 10));
          displayCart();
        }
      }, 2000)
    })
  </script>

  <script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>

</body>

</html>