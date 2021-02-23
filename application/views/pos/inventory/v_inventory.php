<div id="base">

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-cubes"></span> Inventory</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#approve_transfer_stock">
            <span class="fa fa-list-ul"></span> Pending Stock</a></p>

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
                    <td id="qty-<?= $stock_id ?>"> <?= floatval($stock_qty) . " (${stock_satuan})"; ?> </td>
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


<div class="modal fade" id="approve_transfer_stock" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-close"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Menu</h3>
      </div>

      <div class="card no-margin">
        <div class="card-body">
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
                    <th>Tgl Pengiriman</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($pending as $table_content) :
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
                      <td id="qty-<?= $stock_id ?>"> <?= floatval($stock_qty) . " (${stock_satuan})"; ?> </td>
                      <td> <?= $table_content['stock_trf_date']; ?> </td>
                      <td class="text-right">
                        <a href="<?= base_url("pos/inventory/approval_inventory/${stock_id}") ?>" class="btn btn-icon btn-primary btn-flat"><i class="fa fa-check" aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-icon btn-warning btn-flat" data-toggle="modal" data-target="#edit_qty_approval_<?= $stock_id ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="<?= base_url("pos/inventory/reset_stock/${stock_id}") ?>" class="btn btn-icon btn-danger btn-flat" onclick="resetStock(this)" data-satuan="<?= $stock_satuan ?>" data-id="<?= $stock_id ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php foreach ($pending as $table_content) :
  $pengguna_outlet = $this->session->userdata('pengguna_outlet');
  $stock_id = $table_content['stock_id'];
?>
  <form class="form-horizontal" role="form" method="post" action="<?= base_url("pos/inventory/approval_inventory/${stock_id}"); ?>" enctype="multipart/form-data">
    <div class="modal fade" id="edit_qty_approval_<?= $table_content['stock_id'] ?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
              <span class="fa fa-close"></span></button>
            <h3 class="modal-title" id="myModalLabel">Tambah Menu</h3>
          </div>

          <div class="card no-margin">
            <div class="card-body">
              <div class="section-body">
                <div class="row">


                  <div class="modal-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nama Barang</label>
                      <div class="col-sm-8">
                        <input type="hidden" name="stock_id" class="form-control" value="<?= $table_content['stock_id'] ?>">
                        <input name="stock_nama" class="form-control" value="<?= $table_content['stock_nama'] ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Qty</label>
                      <div class="col-sm-8">
                        <input name="stock_qty" class="form-control" value="<?= number_format($table_content['stock_qty']) ?>">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button class="btn btn-primary btn-raised" type="submit">Approve</button>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php endforeach; ?>


<?php foreach ($data as $table_content) :
  $pengguna_outlet = $this->session->userdata('pengguna_outlet');
  $stock_id = $table_content['stock_id'];
?>
  <div class="modal fade" id="modal_edit_stok<?= $stock_id; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-times"></span></button>
          <h3 class="modal-title" id="myModalLabel">Edit Stock</h3>
        </div>
        <form class="form-horizontal" role="form" method="post" action="<?= base_url("admin/inventory/simpan_inventory/$pengguna_outlet"); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-3 control-label">Kode Barang</label>
              <div class="col-sm-8">
                <input type="hidden" name="stock_id" class="form-control" value="<?= $stock_id; ?>">
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