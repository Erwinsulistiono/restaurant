<div id="base">
  <div class="offcanvas">

  </div>
  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-cubes"></span> Inventory</h2>
      </div>
      <section class="card style-default-bright" style="margin-top:0px;">
        <div class="section-body">
          <div class="row">

            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Kategori</th>
                  <th>Stock</th>
                  <th class="text-right">Reset Stock</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                foreach ($data as $table_content) :
                  $stock_id = $table_content['stock_id'];
                  $stock_satuan = $table_content['stock_satuan'];
                  $stock_qty = $table_content['stock_qty'];
                  $i++;
                ?>
                  <tr>
                    <td> <?= $i; ?> </td>
                    <td> <?= $table_content['stock_kode']; ?> </td>
                    <td> <?= $table_content['stock_nama']; ?> </td>
                    <td> <?= $table_content['stock_kat']; ?> </td>
                    <td id="qty-<?= $table_content['stock_id'] ?>"> <?= floatval($stock_qty) . " (${stock_satuan})"; ?> </td>
                    <td class="text-right"> <a href="<?= base_url("pos/inventory/reset_stock/${stock_id}") ?>" class="btn btn-icon btn-primary btn-flat" onclick="resetStock(this)" data-satuan="<?= $stock_satuan ?>" data-id="<?= $stock_id ?>" disabled><i class="fa fa-repeat" aria-hidden="true"></i></a> </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </section>
  </div>
</div>

<?php foreach ($data as $table_content) : ?>
  <div class="modal fade" id="modal_edit_stok<?= $table_content['stock_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Edit Stock</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url('admin/inventory/simpan_inventory/') . $this->session->userdata('pengguna_outlet'); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Kode Barang</label>
              <div class="col-sm-8">
                <input type="hidden" name="stock_id" class="form-control" value="<?= $table_content['stock_id'] ?>">
                <input name="stock_kode" class="form-control" value="<?= $table_content['stock_kode'] ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Nama Barang</label>
              <div class="col-sm-8">
                <input name="stock_nama" class="form-control" value="<?= $table_content['stock_nama'] ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="select13" class="col-sm-3 control-label">Kategori</label>
              <div class="col-sm-8">
                <input list="kategori" id="select13" name="stock_kat" class="form-control" value="<?= $table_content['stock_kat'] ?>" readonly />
                <datalist id="kategori">
                  <option value="">&nbsp;</option>
                  <?php $kat = "";
                  foreach ($data as $row) :
                    if ($kat !== $row['stock_kat']) : ?>
                      <option value="<?= $row['stock_kat'] ?>"></option>
                      <?php $kat = $row['stock_kat']; ?>
                    <?php else : ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Stock (<?= $table_content['stock_satuan'] ?>)</label>
              <div class="col-sm-8">
                <input name="stok_brg" class="form-control" value="<?= number_format($table_content['stock_qty']); ?>" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button class="btn btn-primary btn-raised" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?> -->

<script type="text/javascript">
  async function resetStock() {
    event.preventDefault()
    const satuan = this.event.target.getAttribute("data-satuan")
    const id = this.event.target.getAttribute("data-id")
    const url = this.event.target.getAttribute("href")

    const response = await fetch(url)
    document.querySelector(`#qty-${id}`).innerHTML = `0 (${satuan})`
  }
</script>