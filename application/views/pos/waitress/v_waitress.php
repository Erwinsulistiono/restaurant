<div id="content">
  <section>
    <div class="section-header">
      <h2><span class="fa fa-person"></span> Waitress</h2>
    </div>
    <section class="card style-default no-padding no-margin">
      <div class="container-fluid no-padding no-margin">
        <div class="card no-margin">
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

  <?php foreach ($trx as $t) : ?>
    <!-- Modal Add/Update Resep-->
    <form class="form-horizontal" id="form" action="<?= base_url('pos/waitress/return_order/'); ?>" method="post">
      <div class="modal fade" id="return_order_<?= $t['trx_id'] ?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
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
                  <div class="col-md-4">
                    <label>Menu Return ke Kitchen :</label>
                  </div>
                  <div class="col-md-7">
                    <select name="return_order" class="form-control" required>
                      <option value="">&nbsp;</option>
                      <?php foreach ($order as $o) :
                        if (($t['trx_id'] == $o['order_trx_reff']) && ($t['trx_date'] == $o['order_date'])) :
                      ?>
                          <option value="<?= $o['order_id'] . ',' . $o['order_qty']; ?>"><?= $o['order_menu']; ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Menu Potong Stock :</label>
                  </div>
                  <div class="col-md-7">
                    <select name="potong_stock" class="form-control" required>
                      <option value="">&nbsp;</option>
                      <?php foreach ($menu as $m) : ?>
                        <option value="<?= $m['menu_id']; ?>"><?= $m['menu_nama']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Qty</label>
                  </div>
                  <div class="col-md-7">
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
  <?php endforeach; ?>

  <script type="text/javascript">
    var urlWaitress = '<?php echo base_url('pos/waitress/'); ?>'
    var buttonRefreshWaitress = document.querySelector("#getWaitress")
    var getTrxWaitress = async () => {
      const response = await fetch(`${urlWaitress}getDataTrx`)
      const result = await response.json()
      await printCardWaitress(result);
    }

    var printCardWaitress = (data) => {
      let target = document.getElementById('target')
      target.innerHTML = ''
      let table = data.table
      let order = data.order
      table.forEach(t => {
        let cardPending = ''
        let cardSuccess = ''
        let iterationPending = 0
        let iterationSuccess = 0
        let date = new Date(t.order_date)
        cardPending +=
          `<form role="form" method="post" id="form-${t.trx_id}"
              action="${urlWaitress}end_proses_waitress">
              <div class="col-md-2">
              <div class="card">
              <div class="card-head style-gray">
              <h3  class="text-center text-light">${t.trx_table}</h3>
              </div>
              <div class="card-body">`;
        order.forEach(o => {
          if (((t.trx_id) === (o.order_trx_reff)) &&
            ((t.order_date) === (o.order_date)) &&
            ((o.order_kitchen_flg) === 'Y') &&
            ((o.order_waitress_flg) === 'N')) {
            cardPending += `<div class="clearfix">
                  <div class="pull-left">${o.order_menu}</div>
                  <div class="pull-right">${o.order_qty}</div>
                  </div>`;
            cardPending += ((o.order_notes)) ? `<div class="clearfix pull-left"> - ${o.order_notes}</div>` : '';
            iterationPending++;
          }
        })

        cardPending += `</br>
              <div class="text-center">
              <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()}</div>
              <h4 id="dispTime-${table.trx_id}-${date.getTime()}"></h4>`;

        cardPending +=
          `<div class="text-center">
              <div class="timeShow">${new Date(t.order_date).toLocaleTimeString()}</div></div>`;

        cardPending +=
          `<div class="clearfix"><div class="pull-left">
              <a href="#" onclick="updateFlgWaitress(\'${t.order_date}\',\'${t.trx_id}\')"
              id="orderFlg${order.order_date}" class="btn btn-default text-success btn-raised">
              <span class="fa fa-check"></span></a></div>
              <div class="pull-right"><a href="#" 
              data-toggle="modal" data-target="#return_order_${t.trx_id}"
              id="orderFlg${order.order_date}" class="btn btn-default text-danger btn-raised">
              <span class="fa fa-times"></span></a></div>
              </div>
              </div>
              </div>
              </div>
              </form>`;

        cardSuccess +=
          `<form role="form" method="post" id="form-${t.trx_id}"
              action="<?= base_url() . "pos/pos/clear_order/" ?>">
              <div class="col-md-2">
              <div class="card">
              <div class="card-head style-success">
              <h3 class="text-center text-light">${t.trx_table} (sudah diantar)</h3>
              </div>
              <div   class="card-body">`;
        order.forEach(o => {
          if (((t.trx_id) === (o.order_trx_reff)) &&
            ((t.order_date) === (o.order_date)) &&
            ((o.order_kitchen_flg) === 'Y') &&
            ((o.order_waitress_flg) === 'Y')) {
            cardSuccess += `<div class="clearfix">
                  <div class="pull-left">${o.order_menu}</div>
                  <div class="pull-right">${o.order_qty}</div>
                  </div>`;
            cardSuccess += ((o.order_notes)) ? `<div class="clearfix pull-left"> - ${o.order_notes}</div>` : '';
            iterationSuccess++;
          }
        })

        cardSuccess += `</br>
              <div class="text-center">
              <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()} </div>
              <h4 style="display:none;" id="dispTime-${table.trx_id}-${date.getTime()}"></h4>`;

        cardSuccess +=
          `<div class="text-center">
              <div class="timeShow">${new Date(t.order_date).toLocaleTimeString()}</div></div>`;

        cardSuccess +=
          `<a href="#" onclick="updateFlgWaitress(\'${t.order_date}\',\'${t.trx_id}\')"
              id="orderFlg${order.order_date}" class="btn btn-block btn-default btn-raised" >
              Finish</a>
              </div>
              </form>`;

        if (iterationPending > 0) {
          var newEl = document.createElement('div');
          newEl.innerHTML = cardPending;
          target.appendChild(newEl);
        }
        if (iterationSuccess > 0) {
          var newEl = document.createElement('div');
          newEl.innerHTML = cardSuccess;
          target.appendChild(newEl);
        }

        var cardTimerWaitress = document.getElementById(`dispTime-${table.trx_id}-${date.getTime()}`)
        setInterval(function() {
          let now = new Date();
          let dispTime = new Date((now - date));
          let h = dispTime.getUTCHours();
          let m = dispTime.getUTCMinutes();
          let s = dispTime.getUTCSeconds();
          m = (m < 10) ? `0${m}` : m;
          s = (s < 10) ? `0${s}` : s;

          timercard = `${h} : ${m} : ${s}`;
          (cardTimerWaitress) && (cardTimerWaitress.innerHTML = '');
        }, 1000);
      })
    }

    refreshPage =
      setInterval(function() {
        buttonRefreshWaitress.click();
      }, 60000);


    var updateFlgWaitress = async (date, id) => {
      event.preventDefault()
      let form = document.getElementById(`form-${id}`)
      let url = form.getAttribute('action')
      let data = new FormData()
      data.append('groupOrder', date)
      data.append('groupId', id)

      try {
        const response = await fetch(url, {
          method: 'POST',
          body: data,
        })
        const result = await response.json()
        await (form.innerHTML = '');
        await (result.type == 'error') && alert(result.message);
        await printCardWaitress(result);
      } catch (err) {
        target.innerHTML = '';
      }
    }

    buttonRefreshWaitress.addEventListener('click', function() {
      getTrxWaitress();
    })

    getdate();
    getTrxWaitress();

    var form = document.querySelector('#form')
    if (form) {
      form.addEventListener('submit', function(el) {
        el.preventDefault()
        var url = el.target.action
        var data = new FormData(form)

        fetch_page(url, el.target.method, data)
      })
    }
  </script>