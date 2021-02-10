<!-- BEGIN BASE-->
<div id="base" style="margin:0px;">

  <!-- BEGIN CONTENT-->
  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-person"></span> Waitress</h2>
      </div>
      <section class="style-default no-padding no-margin">
        <div class="container-fluid no-padding no-margin">
          <div class="card">
            <div class="card-body no-margin">
              <button id="getWaitress" href="#" class="btn btn-primary pull-left btn-raised"><span class="fa fa-refresh"></span> Refresh</button>
              <h1 id="timer" class="pull-right no-margin no-padding"></h1>
            </div>
            <div class="card-body">
              <div class="table-responsive" id="target">
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>

    <?php foreach ($order as $o) : ?>
      <!-- Modal Return Order -->
      <?php if ($o['order_kitchen_flg'] == 'Y') : ?>
        <form class="form-horizontal" action="<?= base_url('pos/waitress/return_order/'); ?>" method="post">
          <div class="modal fade" id="return_order_<?= $o['order_id'] ?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
                    <span class="fa fa-times"></span></button>
                  <h3 class="modal-title" id="myModalLabel">Return to kitchen</h3>
                </div>

                <div class="card no-margin">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-xs-4">
                        <label>Menu Return ke Kitchen :</label>
                      </div>
                      <div class="col-xs-7">
                        <input class="form-control" type="hidden" name="order_id" value="<?= $o['order_id'] ?>">
                        <input class="form-control" type="text" name="order_nama" value="<?= $o['menu_nama'] ?>" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <label>Menu Potong Stock :</label>
                      </div>
                      <div class="col-xs-7">
                        <select name="potong_stock" class="form-control" required>
                          <option value="">&nbsp;</option>
                          <?php foreach ($menu as $m) : ?>
                            <option value="<?= $m['menu_id']; ?>"><?= $m['menu_nama']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <label>Qty</label>
                      </div>
                      <div class="col-xs-7">
                        <input class="form-control" type="number" name="qty_potong" value="1">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
                  <button class="btn btn-primary btn-raised" type="submit">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      <?php endif; ?>
    <?php endforeach; ?>


    <script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
    <script type="text/javascript">
      const formReturnOrder = document.querySelector('#form-return-order');
      let urlGetPesanan = '<?= base_url('pos/Pesanan/'); ?>';
      let getTrxWaitress = () => {
        $.ajax({
          type: 'GET',
          url: `${urlGetPesanan}`,
          dataType: 'json',
          success: function(data) {
            printCard(data)
          }
        })
      }

      let printCard = data => {
        console.log(data)
        $('#target').html('');
        let trx = data.trx;
        let order = data.order;
        var no = 1;

        let filteredTrx = trx.filter((v, i, a) => a.findIndex(t => (t.trx_id === v.trx_id)) === i)
        console.log(filteredTrx)
        filteredTrx.forEach(t => {
          let card = '';
          let iteration = 0;
          let date = new Date(t.order_date);
          let iterationReturnOrderToCashier = 0;
          let trxId = t.trx_id;
          let isTrxCanceled = (t.trx_cancel_flg == 'Y');
          if (t.trx_table == t.trx_cust) {
            headerTipeOrder = `Take Away - ${t.trx_cust}`;
          } else {
            headerTipeOrder = `${t.trx_table} - ${t.trx_cust}`;
          }

          card +=
            `<form role="form" method="post" class="form-${no} header-${t.trx_id}">
              <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="card">
                  <div class="card-head style-gray">
                    <h3 class="text-center text-light">${headerTipeOrder}</h3>
                  </div>
                <div class="card-body">`;

          order.forEach(o => {
            let isIdHeadAndDetailSame = ((trxId) === (o.order_trx_reff));
            let cookingStatus = (o.order_kitchen_flg);
            let deliveringStatus = (o.order_waitress_flg);
            let cancelStatus = (o.order_cancel_flg);

            if ((cancelStatus == 'Y') && isIdHeadAndDetailSame) {
              iterationReturnOrderToCashier++
            }
            let menu = (deliveringStatus === 'Y') ? `<s>${o.menu_nama} (${o.order_qty})</s>` : `${o.menu_nama} (${o.order_qty})`;
            let buttonDisabled = (deliveringStatus === 'Y') ? 'disabled' : '';

            if (isIdHeadAndDetailSame && cookingStatus === 'Y') {
              card +=
                `<div class="clearfix">
                  <div class="pull-left">${menu}</div>
                    <div class="pull-right no-padding">
                      <a href="#" data-toggle="modal" data-target="#return_order_${o.order_id}"
                        id="orderFlg${order.order_date}" class="btn btn-icon text-danger no-padding btn-return-order-${t.trx_id}" ${buttonDisabled}>
                        <span class="fa fa-times"></span></a>&nbsp;&nbsp;
                      <a href="#" onclick="updateFlg(${o.order_id})"
                        id="orderFlg${order.order_date}" class="btn btn-icon text-success no-padding btn-coret-${t.trx_id}" ${buttonDisabled}>
                        <span class="fa fa-pencil"></span></a>
                    </div>
                  </div>`;

              card += ((o.order_notes)) ? `<div class="clearfix pull-left"> - ${o.order_notes}</div>` : '';
              iteration++;
            }
          })

          card += `</br>
            <div class="text-center">
              <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()}</div>
              <h4 id="dispTime-${filteredTrx.trx_id}-${date.getTime()}"></h4>`;

          card +=
            `<div class="text-center">
              <div class="timeShow">${new Date(t.order_date).toLocaleTimeString('id-ID')}</div></div>`;

          if (isTrxCanceled) {
            card += `<br/>
                      <div class="row">
                        <div class="col-xs-12 no-padding">
                          <a href="#" data-qty="${t.order_qty}" data-menuid="${t.order_menu}" onclick="updateFlgOrderAfterCancelation(${t.order_id},${t.trx_id});" 
                          class="btn btn-danger btn-raised btn-block">clear order</a>
                        </div>
                      </div>`;
          }

          card +=
            `</div>
            </div>
            </div>
            </div>
            </form>`;

          (iteration > 0) && $('#target').append(card);
          if (iterationReturnOrderToCashier > 0 || isTrxCanceled) {
            let head = document.querySelectorAll(`.form-${no}`)
            head.forEach(h => {
              let header = h.querySelector('.card-head');
              header.style.backgroundColor = '#f44336'
              header.querySelector('h3').innerHTML += ' (Canceled by kasir)'
              h.querySelectorAll(`.btn-return-order-${t.trx_id}`).forEach(attr => attr.setAttribute("disabled", "disabled"));
              h.querySelectorAll(`.btn-coret-${t.trx_id}`).forEach(attr => attr.setAttribute("disabled", "disabled"));
            })
          } else if (iterationReturnOrderToCashier) {
            let head = document.querySelectorAll(`.form-${no}`)
            head.forEach(h => {
              let header = h.querySelector('.card-head');
              header.style.backgroundColor = '#f44336'
              header.querySelector('h3').innerHTML += ' (Canceled by kitchen)';
              h.querySelectorAll(`.btn-return-order-${t.trx_id}`).forEach(attr => attr.setAttribute("disabled", "disabled"));
              h.querySelectorAll(`.btn-coret-${t.trx_id}`).forEach(attr => attr.setAttribute("disabled", "disabled"));
            })
          }
          no++;

          setInterval(function() {
            let now = new Date();
            let dispTime = new Date((now - date));
            let h = dispTime.getUTCHours();
            let m = dispTime.getUTCMinutes();
            let s = dispTime.getUTCSeconds();
            m = (m < 10) ? `0${m}` : m;
            s = (s < 10) ? `0${s}` : s;

            timercard = `${h} : ${m} : ${s}`;
            $(`#dispTime-${filteredTrx.trx_id}-${date.getTime()}`).html(timercard);
          }, 1000);
        })
      }

      let getdate = () => {
        let today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        s = (s < 10) ? `0${s}` : s;
        m = (m < 10) ? `0${m}` : m;

        $("#timer").text(`${h} : ${m} : ${s}`);
        setTimeout(function() {
          getdate()
        }, 1000);
      }

      setInterval(function() {
        $("#getWaitress").click();
      }, 60000);

      let updateFlg = (id) => {
        let confirmCoret = confirm("Coret Pesanan?")
        if (confirmCoret) {
          let data = {
            orderId: id,
          }
          console.log(data)
          $.ajax({
            type: 'POST',
            url: '<?= base_url('pos/waitress/end_proses_waitress'); ?>',
            data: data,
            dataType: 'json',
            success: function(data) {
              printCard(data);
            }
          })
        }
      }

      let updateFlgOrderAfterCancelation = (orderId, trxId) => {
        event.preventDefault()
        let form = $(`.header-${trxId}`)
        let url = '<?= base_url('pos/waitress/'); ?>'
        $.ajax({
          type: 'POST',
          url: `${url}return_order_after_cancelation`,
          data: {
            orderId: orderId,
            trxId: trxId
          },
          dataType: 'json',
          success: function(data) {
            console.log(data)
            form.remove();
          }
        })
      }

      $('#getWaitress').click(function() {
        getdate();
        getTrxWaitress();
      });

      getdate();
      getTrxWaitress();
    </script>