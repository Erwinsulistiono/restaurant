<div id="base">
  <div id="content">
    <br />
    <section class="section-account">
      <div class="contain-xs style-transparent">
        <div class="card-body">
          <div class="row">
            <div class="col-xs-12">
              <br />
              <span class="text-lg text-bold text-primary">Pilih Outlet</span>
              <br />
              <form class='form floating-label' action='<?= base_url('admin/inventory/outlet') ?>' accept-charset='utf-8' method='post'>
                <div class="form-group">
                  <h2><select name="outlet_id" class="form-control" onchange="changeData();">
                      <option value="">&nbsp;</option>
                      <option value="master">Master Inventory</option>
                      <?php foreach ($outlet as $row) : ?>
                        <option value="<?= $row['out_id']; ?>"><?= $row['out_kode']; ?> - <?= $row['out_nama']; ?></option>
                      <?php endforeach; ?>
                    </select></h2>
                </div>
                <div class="row">
                  <div class="col-xs-6 text-left">
                  </div>
                  <div class="col-xs-6 text-right">
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
</div>