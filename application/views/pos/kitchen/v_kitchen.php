  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-cutlery"></span> Kitchen</h2>
      </div>
      <section class="card style-default no-padding no-margin">
        <div class="container-fluid no-padding no-margin">
          <div class="card no-margin">
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

    <script type="text/javascript">
      var urlKitchen = '<?php echo base_url('pos/kitchen/'); ?>'
      var buttonRefreshKitchen = document.querySelector("#getKitchen")

      var printCardKitchen = data => {
        let target = document.getElementById('target')
        target.innerHTML = ''
        let table = data.table
        let order = data.order
        table.forEach(t => {
          let card = ''
          let iteration = 0
          let date = new Date(t.order_date)
          let timerCard = ''

          card +=
            `<form role="form" id="form-${t.trx_id}" method="post">
              <div class="col-md-2">
              <div class="card">
              <div class="card-head style-gray-light">
              <h3 class="text-center text-light">${t.trx_table}</h3>
              </div>
              <div class="card-body">`;

          order.forEach(o => {
            if (((t.trx_id) === (o.order_trx_reff)) &&
              ((t.order_date) === (o.order_date)) &&
              ((o.order_kitchen_flg) == 'N')) {
              card += `<div class="clearfix">
                  <div class="pull-left">${o.order_menu}</div>
                  <div class="pull-right">${o.order_qty}</div>
                  </div>`;
              card += ((o.order_notes)) ? `<div class="clearfix pull-left"> - ${o.order_notes}</div>` : '';
              iteration++;
            }
          })

          card += `<br/>
              <div class="text-center">
              <div>${date.getDate()} / ${(date.getMonth()+1)} / ${date.getFullYear()}</div>
              <h4 id="dispTime-${table.trx_id}-${date.getTime()}"></h4>`;
          card += `<br/>
              <a href="#" onclick="updateFlgKitchen(\'${t.order_date}\',\'${t.trx_id}\')" 
              class="btn btn-primary-dark btn-raised" >Finish</a>
              </div>
              </div>
              </div>
              </div>
              </form>`;

          if (iteration > 0) {
            var newEl = document.createElement('div');
            newEl.innerHTML = card;
            target.appendChild(newEl);
          }

          var cardTimerKitchen = document.getElementById(`dispTime-${table.trx_id}-${date.getTime()}`)
          setInterval(function() {
            let now = new Date();
            let dispTime = new Date((now - date));
            let h = dispTime.getUTCHours();
            let m = dispTime.getUTCMinutes();
            let s = dispTime.getUTCSeconds();
            m = (m < 10) ? `0${m}` : m;
            s = (s < 10) ? `0${s}` : s;

            timercard = `${h} : ${m} : ${s}`;
            (cardTimerKitchen) && (cardTimerKitchen.innerHTML = timercard);
          }, 1000);
        })
      }

      try {
        var getTrxKitchen = async () => {
          const response = await fetch(`${urlKitchen}getDataTrx`)
          const result = await response.json()
          await printCardKitchen(result);
        }
      } catch (err) {
        throw err
      }

      refreshPage =
        setInterval(function() {
          buttonRefreshKitchen.click();
        }, 60000);


      var updateFlgKitchen = async (date, id) => {
        let data = new FormData()
        data.append('groupOrder', date)
        data.append('groupId', id)

        const response = await fetch(`${urlKitchen}end_proses_kitchen`, {
          method: 'POST',
          body: data,
        })
        let form = document.querySelector(`#form-${id}`)
        form.innerHTML = ''
      }

      buttonRefreshKitchen.addEventListener('click', function() {
        getTrxKitchen();
      })

      getdate();
      getTrxKitchen();
    </script>