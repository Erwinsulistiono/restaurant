<img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%; z-index: 1001;" />
<div id="base" style="margin:0px; display:none;">
  <div id="content">
    <section>
      <div class="section-header  ">
        <!-- <h2><span class="fa fa-cutlery"></span> Kitchen</h2> -->
        <div class="row">
          <div class="col-xs-6">
            <p><a href="#" class="popup-btn btn btn-primary btn-raised"><span class="fa fa-arrow-left"></span>
                Kembali</a>
              <button id="getKitchen" href="#" class="btn btn-primary btn-raised btn-flat" style="border:solid; border-width:1px; border-color:#08867e">
                <span class="fa fa-refresh"></span> Refresh</button>
          </div>
          <div class="col-xs-6">
            <h1 id="timer" class="pull-right text-light no-padding"></h1>
          </div>
        </div>
      </div>
      <section class="style-default no-padding no-margin">
        <div class="container-fluid no-padding no-margin">

          <div class="card">
            <div class="row">

              <div class="col-xs-4">
                <div class="card-body" style="padding-top:0; padding-bottom:0">
                  <h3 class="text-center text-primary-dark">Kitchen</h3>
                  <div class="table-responsive card-body" id="targetKitchen">
                  </div>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="card-body" style="padding-top:0; padding-bottom:0">
                  <h3 class="text-center text-primary-dark">Waitress</h3>
                  <div class="table-responsive card-body" id="targetWaitress">
                  </div>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="card-body" style="padding-top:0; padding-bottom:0">
                  <h3 class="text-center text-primary-dark">Done</h3>
                  <div class="table-responsive card-body" id="targetDone">
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </section>
    </section>

    <script src="<?= base_url() . 'assets/js/jquery-3.4.1.min.js' ?>"></script>
    <script type="text/javascript">
      let urlGetPesanan = '<?php echo base_url('pos/Pesanan/'); ?>'
      let trx;
      let order;
      let recipe;
      let tipe;
      let getTrxKitchen = () => {
        $.ajax({
          type: 'GET',
          url: `${urlGetPesanan}`,
          dataType: 'json',
          success: function(data) {
            console.log(data)
            $('#targetKitchen').html('');
            $('#targetWaitress').html('');
            $('#targetDone').html('');
            trx = data.trx;
            order = data.order;
            recipe = data.recipe;
            tipe = data.tipe;
            console.log(tipe);
            var no = 1;

            let filteredTrx = trx.filter((v, i, a) => a.findIndex(t => (t.trx_id === v.trx_id)) === i)
            console.log(filteredTrx);

            filteredTrx.forEach(t => {
              let cardKitchen = '';
              let cardWaitress = '';
              let cardDone = '';
              let cardHead = '';
              let cardFoot = '';
              let iterationKitchen = 0;
              let iterationWaitress = 0;
              let iterationDone = 0;
              let iterationReturnOrderToCashier = 0;
              let date = new Date(t.order_date);
              let timerCard = '';
              let isOrderCanceled = t.trx_cancel_flg;

              tipe.forEach(tp => {
                if (t.trx_tipe == tp.tipe_transaksi_id) {
                  tipe_order = tp.tipe_transaksi_nama;
                }
              });

              if (isOrderCanceled == 'N') {
                cardHead +=
                  `<form role="form" class="form-${no} header-${t.trx_id}" method="post">
                  <div class="col-xs-12">
                  <div class="card">
                  <div class="card-head style-gray">
                  <h3 class="text-center text-light">${t.trx_table} - ${tipe_order}</h3>
                  </div>
                  <div class="card-body">`;

                cardKitchen += cardHead;
                cardWaitress += cardHead;
                cardDone += cardHead;
                order.forEach(o => {
                  let isIdHeadAndDetailSame = ((t.trx_id) === (o.order_trx_reff));
                  let cookingStatus = (o.order_kitchen_flg);
                  let deliveringStatus = (o.order_waitress_flg);
                  let cancelStatus = (o.order_cancel_flg);

                  if (isIdHeadAndDetailSame &&
                    (cookingStatus == 'N')) {
                    cardKitchen += `<div class="clearfix">
                    <div class="pull-left">${o.menu_nama}</div>
                    <div class="pull-right">${o.order_qty}</div>
                    </div>`;
                    cardKitchen += ((o.order_notes)) ? `<div class="clearfix pull-left"> - ${o.order_notes}</div><br/>` : '';
                    iterationKitchen++;
                    (cancelStatus == 'Y') && (iterationReturnOrderToCashier++)
                  }
                  if (isIdHeadAndDetailSame &&
                    (cookingStatus == 'Y') && (deliveringStatus == 'N')) {
                    cardWaitress += `<div class="clearfix">
                    <div class="pull-left">${o.menu_nama}</div>
                    <div class="pull-right">${o.order_qty}</div>
                    </div>`;
                    cardWaitress += ((o.order_notes)) ? `<div class="clearfix pull-left"> - ${o.order_notes}</div><br/>` : '';
                    iterationWaitress++;
                    (cancelStatus == 'Y') && (iterationReturnOrderToCashier++)
                  }
                  if (isIdHeadAndDetailSame &&
                    (cookingStatus == 'Y') && (deliveringStatus == 'Y')) {
                    cardDone += `<div class="clearfix">
                    <div class="pull-left">${o.menu_nama}</div>
                    <div class="pull-right">${o.order_qty}</div>
                    </div>`;
                    cardDone += ((o.order_notes)) ? `<div class="clearfix pull-left"> - ${o.order_notes}</div><br/>` : '';
                    iterationDone++;
                    (cancelStatus == 'Y') && (iterationReturnOrderToCashier++)
                  }
                })

                if (iterationDone == 0) {
                  cardFoot += `<br/>
                    <br/>
                    <div class="text-center">
                    <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()}</div>
                    <h4 class="dispTime-${filteredTrx.trx_id}-${date.getTime()}"></h4>
                    <br/>`;

                  cardFoot += `
                    <div class="row">
                    <div class="col-xs-12">
                    <a href="#" onclick="cancelTrx(${t.trx_id},${no})"
                    class="btn btn-danger btn-raised btn-block" >cancel order</a>
                    </div>
                    </div>`;
                } else {
                  cardFoot += `<br/>
                    <br/>
                    <div class="text-center">
                    <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()}</div>
                    <h4>${date.toLocaleTimeString('id-ID')}</h4>
                    <br/>`;

                  cardFoot += `
                    <div class="row">
                    <div class="col-xs-12">
                    <a href="#" onclick="clearOrder(${t.trx_id})"
                    class="btn btn-success btn-raised btn-block" >finish order</a>
                    </div>
                    </div>`;
                }

                cardFoot += `
                </div>
                </div>
                </div>
                </div>
                </form>`;

                cardKitchen += cardFoot;
                cardWaitress += cardFoot;
                cardDone += cardFoot;

                (iterationKitchen > 0) && $('#targetKitchen').append(cardKitchen);
                (iterationWaitress > 0) && $('#targetWaitress').append(cardWaitress);
                (iterationDone > 0) && $('#targetDone').append(cardDone);
                if (iterationReturnOrderToCashier > 0) {
                  let head = document.querySelectorAll(`.form-${no}`)
                  head.forEach(h => {
                    let header = h.querySelector('.card-head');
                    header.style.backgroundColor = '#f44336'
                    header.querySelector('h3').innerHTML += ' (Canceled)'
                  })
                }
                no++;

                setInterval(function() {
                  let today = new Date();
                  let dispTime = new Date((today - date));
                  let h = dispTime.getUTCHours();
                  let m = dispTime.getUTCMinutes();
                  let s = dispTime.getUTCSeconds();
                  m = (m < 10) ? `0${m}` : m;
                  s = (s < 10) ? `0${s}` : s;

                  timercard = `${h} : ${m} : ${s}`;
                  $(`.dispTime-${filteredTrx.trx_id}-${date.getTime()}`).html(timercard);
                }, 1000);
              }
            })
          }
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

      let btn = document.getElementById("getKitchen");
      setInterval(function() {
        btn.click();
      }, 60000);

      let updateFlg = (date, id) => {
        event.preventDefault()
        let form = $(`#form-${id}`)
        $.ajax({
          type: 'POST',
          url: `${urlKitchen}end_proses_kitchen`,
          data: {
            groupOrder: date,
            groupId: id
          },
          dataType: 'json',
          success: function() {
            form.remove();
          }
        })
      }

      let clearOrder = trx_id => {
        let form = document.querySelector(`.header-${trx_id}`);
        let isOrderNotFinish = false;
        order.forEach(o => {
          if (o.order_waitress_flg == 'N') isOrderNotFinish = true;
        })

        // if (isOrderNotFinish) return alert("Beberapa Order Belum Selesai..");

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url("pos/pos/clear_order/"); ?>',
          data: {
            trx_id: trx_id,
          },
          dataType: 'json',
          success: function(data) {
            (data.type == 'error') && alert(data.message);
            (data.type == 'success') &&
            (form.remove(),
              alert(data.message));
          }
        })
      };

      $('#getKitchen').click(function() {
        getdate();
        getTrxKitchen();
      });

      getdate();
      getTrxKitchen();

      function close_window() {
        close();
      }

      async function cancelTrx(id) {
        let confirmCancel = confirm("Batalkan Pesanan?")
        if (!confirmCancel) {
          event.preventDefault()
          return
        }
        let response = await fetch('<?= base_url('pos/pos/batalkan_transaksi/') ?>' + id)
        let result = await response.json();
        document.querySelectorAll(`form.form-${id}`).forEach(el => {
          el.remove();
        })
        alert(result);
      }

      $(function() {
        setTimeout(() => {
          document.querySelector('#loading-screen').style.display = 'none';
          document.querySelector('#base').removeAttribute('style');
        }, 700)
      })
    </script>