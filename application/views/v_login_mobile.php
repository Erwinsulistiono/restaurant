<section class="card section-account" style="height:100%">
  <div class="card contain-xs style-transparent">
    <div class="card-body" style="padding-top:20%">
      <div class="row">
        <div class="col-xs-12">
          <br />
          <span class="text-lg text-bold text-primary">F1 Restaurant</span>
          <br /><br />
          <?= $this->session->flashdata('msg'); ?>
          <form class='form floating-label' action='<?= base_url('order/auth/') . $outlet ?>' accept-charset='utf-8' method='post'>
            <div class="form-group">
              <input type="text" class="form-control" id="username" name="plg_nama" required>
              <label for="username">Nama : </label>
            </div>
            <div class="form-group">
              <input type="number" class="form-control" id="plg_notelp" name="plg_notelp">
              <label for="plg_notelp">No Telp : </label>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" id="plg_email" name="plg_email">
              <label for="plg_email">E-Mail : </label>
            </div>
            <div class="form-group">
              <select id="selectMethodOfTable" name="tipe_transaksi" class="form-control">
                <option value="">&nbsp;</option>
                <?php foreach ($method_of_order as $row) : ?>
                <option value="<?= $row['tipe_transaksi_id']; ?>"><?= $row['tipe_transaksi_nama']; ?></option>
                <?php endforeach; ?>
              </select>
              <label for="selectMethodOfTable">Jenis Order : </label>
            </div>
            <div class="form-group" id="selectInput">
            </div>
            <br />
            <div class="row">
                <button class="btn btn-block btn-primary btn-raised" type="submit"><span class="fa fa-receipt"></span> Order</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="<?= base_url() . 'assets/js/jquery-3.4.1.min.js' ?>"></script>
<script type="text/javascript">
  $('#selectMethodOfTable').change(function() {
    let methodType = $(this).val();
    let divElement = '';
    let meja = '<?php echo json_encode($data); ?>';
    
    if (methodType == 1){
      divElement += 
      `<select name="meja_pelanggan" class="form-control">
      <option value="">&nbsp;</option>`;
      
      Object.values(meja).forEach(m => {
        divElement += (m.meja_pelanggan == 0) ? `<option value="${meja[i].meja_id}">${meja[i].meja_nama}</option>` : '';
      })
      
      divElement += `</select>
      <label>Pilih Meja : </label>`;
    }

    if (methodType == 3){
      divElement +=
      `<div class="form-group">
        <input type="text" class="form-control" id="username" name="plg_platno" required>
        <label >Nomor Plat Kendaraan : </label>
      </div>`;
    }

    if (methodType == 4){
      divElement +=
      `<div class="form-group">
        <input type="text" class="form-control" id="username" name="plg_alamat" required>
        <label >alamat pengiriman : </label>
      </div>`;
    }

    $('#selectInput').html(divElement);
  });
</script>