<div class="offcanvas">
</div>
<div id="content">
  <br />
  <section class="section-account">
    <div class="card contain-xs style-transparent">
      <div class="card-body">
        <div class="row">
          <div class="col-xs-12">
            <br />
            <span class="text-lg text-bold text-primary">Pilih Tanggal</span>
            <br />
            <form class='form floating-label' id="form" action='<?= base_url('pos/laporan/filter') ?>' accept-charset='utf-8'
              method='post'>
              <div class=" col-md-5">
                <label>Tanggal Awal</label>
                <input type="date" name="tgl_awal" class="form-control" value="<?= date('Y-m-d'); ?>">
              </div>
              <div class="col-md-5">
                <label>Tanggal Akhir</label>
                <input type="date" name="tgl_akhir" class="form-control" value="<?= date('Y-m-d'); ?>">
              </div>
              <div class="row">
                <div class="col-xs-2 text-left">
                </div>
                <div class="col-xs-2 text-right">
                  <button class="btn btn-primary btn-raised" type="submit">Pilih</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
  var form = document.querySelector('#form')
  form.addEventListener('submit', function(el) {
    el.preventDefault()
    var form = $(this)
    var url = el.target.action
    var data = new FormData(form[0])  

    fetch_page(url, el.target.method, data)
  })
</script>