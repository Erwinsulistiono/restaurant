<div id="base" style="margin:0px;">
  <div id="content">
    <section>
      <div class="section-header  ">
        <h2><span class="fa fa-cutlery"></span>&nbsp; <?= $kitchen['kitchen_nama'] ?></h2>
      </div>
      <section class="style-default no-padding no-margin">
        <div class="container-fluid no-padding no-margin">

          <div class="card">
            <div class="card-body no-margin">
              <button id="getKitchen" href="#" class="btn btn-primary btn-raised"><span class="fa fa-refresh"></span> Refresh</button>
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


    <!-- Modal Return Order -->
    <form class="form-horizontal" id="form-return-order" action="<?= base_url('pos/kitchen/return_order/'); ?>" method="post">
      <div class="modal fade" id="return_order" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
                <span class="fa fa-times"></span></button>
              <h3 class="modal-title" id="myModalLabel">Cancel Order</h3>
            </div>

            <div class="card no-margin">
              <div class="card-body">

                <div class="row">
                  <div class="col-md-4">
                    <label>Menu :</label>
                  </div>
                  <div class="col-md-7">
                    <input class="form-control" id="return_menu" type="text" name="otherIngredient" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Stock Habis :</label>
                  </div>
                  <div class="col-md-7">
                    <select name="stock_id" id="empty_stock" class="form-control">
                      <option value="">&nbsp;</option>
                    </select>
                  </div>
                </div>
                <div class="row" id="otherIngredient">
                  <div class="col-md-4">
                    <label>Ingredient Lain :</label>
                  </div>
                  <div class="col-md-7">
                    <input class="form-control" type="text" name="otherIngredient">
                  </div>
                </div>

              </div>
            </div>

            <div class="modal-footer">
              <button class="btn btn-primary btn-raised btn-flat" id="close-modal" data-dismiss="modal" aria-hidden="true">Tutup</button>
              <button class="btn btn-primary btn-raised" id="simpan-return-menu" type="submit">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>


    <script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
    <script type="text/javascript">
      let kitchen_id = '<?= $kitchen['kitchen_id']; ?>';
      let urlGetPesanan = '<?= base_url('pos/Pesanan/'); ?>';
      let order = '';
      let recipe = '';
      let trx = '';
      let setActiveTrx = '';
      let orderId = '';
      let canceledOrderHeader = [];
      let canceledOrder = 0;
      let currTrxId = 0;
      let iteration = 0;

      /*------------------ GET DATA TRX ------------------*/
      let getTrxKitchen = () => {
        $.ajax({
          type: 'GET',
          url: `${urlGetPesanan}`,
          dataType: 'json',
          success: function(data) {
            printCard(data);
          }
        })
      }

      /*------------------ PRINT CARD ------------------*/
      let printCard = data => {
        $('#target').html('');
        trx = data.trx;
        order = data.order;
        recipe = data.recipe;

        trx.forEach(t => {
          let card = '';
          let timerCard = '';
          let buttonAttribute = "";
          let isTrxCanceledByKitchen = (t.trx_cancel_kitchen_flg);
          let isOrderCanceledByKitchen = (t.order_cancel_flg);
          iteration = 0;
          card += printCardHeader(t);
          card += printCardBody(t);
          card += printCardFoot(t);

          (iteration > 0) && $('#target').append(card);
          // }
        })
      }

      /*------------------ PRINT CARD HEADER ------------------*/
      let printCardHeader = (t) => {
        let headerStyle = "style-gray-light";
        let headerText = "";
        let headerTipeOrder = "";
        let buttonAttribute = "";
        let card = "";
        let isOrderCanceledByKitchen = t.order_cancel_flg;
        let isTrxCanceledByKasir = t.trx_cancel_flg;

        if (t.trx_table == t.trx_cust) {
          headerTipeOrder = `Take Away - ${t.trx_cust}`;
        } else {
          headerTipeOrder = `${t.trx_table} - ${t.trx_cust}`;
        }

        if (currTrxId != t.trx_id) {
          currTrxId = t.trx_id;
          canceledOrder = 0;
        }

        if (isOrderCanceledByKitchen == 'Y' || isTrxCanceledByKasir == 'Y') {
          headerStyle = 'style-danger';
          headerText = " - (Canceled)";
          if (canceledOrder == 0 && currTrxId == t.trx_id) {
            let form = document.querySelectorAll(`.form-${t.trx_id}`);
            form.forEach(h => {
              h.querySelector('.card-head').style.backgroundColor = '#f44336';
              h.querySelector('h3').innerHTML = `${headerTipeOrder} (Canceled)`;
              if (isTrxCanceledByKasir == 'N') {
                h.querySelectorAll('a')[0].setAttribute('disabled', buttonAttribute);
                h.querySelectorAll('a')[1].setAttribute('disabled', buttonAttribute);
              }
            })
          }
          canceledOrder++;
        }

        if (canceledOrder > 0) {
          headerStyle = 'style-danger';
          headerText = " - (Canceled)";
        }

        card +=
          `<form role="form" id="form-${t.order_id}" class="form-${t.trx_id}" method="post">
            <div class="col-md-3 col-sm-4 col-xs-6">
              <div class="card">
                <div class="card-head ${headerStyle}">
                  <h3 class="text-center text-light">${headerTipeOrder} ${headerText}</h3>
                </div>
                <div class="card-body">`;

        return card;
      }

      /*------------------ PRINT CARD FOOT ------------------*/
      let printCardFoot = (t) => {
        let card = '';
        let buttonAttribute = (canceledOrder) ? "disabled" : "";
        let isTrxCanceledByKasir = t.trx_cancel_flg;

        if (isTrxCanceledByKasir == 'Y') {
          card += `<br/>
                  <div class="row">
                    <div class="col-xs-12 no-padding">
                      <a href="#" data-qty="${t.order_qty}" data-menuid="${t.order_menu}" onclick="updateFlgOrderAfterCancelation(${t.order_id},${t.trx_id});" 
                        class="btn btn-danger btn-raised btn-block">clear order</a>
                    </div>
                  </div>`;
        } else {
          card += `<br/>
                  <div class="row">
                    <div class="col-xs-6 no-padding">
                      <a href="#" onclick="updateFlgOrder(${t.order_id})" class="btn btn-success btn-raised btn-block" ${buttonAttribute}><i class="fa fa-check"></i></a>
                    </div>
                    <div class="col-xs-6 no-padding">
                      <a href="#" data-toggle="modal" data-target="#return_order" onclick="populateModalReturn(${t.order_id})" class="btn btn-danger btn-raised btn-block" ${buttonAttribute}><i class="fa fa-times"></i></a>
                    </div>
                  </div>`;
        }

        card += `
                </div>
              </div>
            </div>
          </form>`;

        return card;
      }

      /*------------------ PRINT CARD BODY ------------------*/
      let printCardBody = (t) => {
        let date = new Date(t.order_date);
        let isDoneCooking = t.order_kitchen_flg;
        let isChoosenKitchen = (Number(t.menu_kitchen) == Number(kitchen_id));
        let card = '';
        let isTrxCanceledByKasir = t.trx_cancel_flg;
        let isOrderCanceledByKitchen = t.order_cancel_flg;

        if (isDoneCooking == 'N' && isChoosenKitchen && (isTrxCanceledByKasir == 'N' || isOrderCanceledByKitchen == 'N')) {
          card +=
            `<div class="clearfix">
              <div class="pull-left">${t.menu_nama}</div>
              <div class="pull-right">${t.order_qty}</div>
            </div>`;
          card += ((t.order_notes)) ? `<div class="clearfix pull-left"> - (${t.order_notes})</div>` : '';
          iteration++;
        }

        card += `<br/>
            <div class="text-center">
              <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()}</div>
              <h4 class="dispTime-${trx.trx_id}-${date.getTime()}"></h4>`;

        setInterval(function() {
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

      let updateFlgOrder = (id) => {
        event.preventDefault()
        let form = $(`#form-${id}`)
        let url = '<?= base_url('pos/kitchen/') ?>'
        $.ajax({
          type: 'POST',
          url: `${url}end_proses_kitchen`,
          data: {
            orderId: id
          },
          dataType: 'json',
          success: function() {
            form.remove();
          }
        })
      }

      let updateFlgOrderAfterCancelation = (orderId, trxId) => {
        event.preventDefault()
        let form = $(`#form-${orderId}`)
        let url = '<?= base_url('pos/kitchen/') ?>'
        let qty = event.target.getAttribute('data-qty');
        let menuId = event.target.getAttribute('data-menuid');
        $.ajax({
          type: 'POST',
          url: `${url}return_order_after_cancelation`,
          data: {
            orderId: orderId,
            menuId: menuId,
            qty: qty,
            trxId: trxId
          },
          dataType: 'json',
          success: function(data) {
            form.remove();
          }
        })
      }
    </script>

    <script>
      var inputOptionRecipe = document.querySelector('#empty_stock');
      var inputOptionMenu = document.querySelector('#return_menu');
      var form = document.querySelector('#form-return-order');
      var otherIngredient = document.querySelector('#otherIngredient');

      let populateModalReturn = id => {
        otherIngredient.style.display = 'none';
        orderId = id;

        ([...inputOptionRecipe.options]).forEach(opt => {
          if (opt.value) {
            opt.remove();
          }
        });

        let selectedOrder = order.filter(o => o.order_id == id);
        inputOptionMenu.value = selectedOrder[0].menu_nama;

        recipe.filter(r => (r.order_id == id))
          .forEach(item => {
            let optChild = document.createElement("option");
            optChild.value = item.stock_id;
            optChild.innerHTML = item.stock_nama;
            inputOptionRecipe.appendChild(optChild);
          })

        let optChild = document.createElement("option");
        optChild.value = '0';
        optChild.innerHTML = 'Lainnya';
        inputOptionRecipe.appendChild(optChild);
      }

      inputOptionRecipe.addEventListener('change', () => {

        let idRecipe = this.event.target.value
        if (idRecipe == 0) {
          otherIngredient.style.display = 'block';
        } else {
          otherIngredient.style.display = 'none';
        }
      });

      form.addEventListener('submit', () => {
        event.preventDefault()
        let formData = new FormData(this.event.target)
        let objData = Object.fromEntries(formData)
        let recipeText = (Number(objData.stock_id)) ? inputOptionRecipe.options[inputOptionRecipe.selectedIndex].innerHTML : objData.otherIngredient;
        let data = {
          idStock: objData.stock_id,
          menu: objData.return_order,
          notes: `Stock ${recipeText} Habis`,
          orderId: orderId,
        }

        let returnOrder = async () => {
          const response = await fetch(this.event.target.action, {
            method: 'POST',
            header: {
              'Accept': 'application/json, text/plain, */*',
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
          })
          const result = await response.json();
          (result) && document.querySelector('#close-modal').click();
          getTrxKitchen();
        }

        returnOrder();
      })

      $('#getKitchen').click(function() {
        getdate();
        getTrxKitchen();
      });

      getdate();
      getTrxKitchen();
    </script>