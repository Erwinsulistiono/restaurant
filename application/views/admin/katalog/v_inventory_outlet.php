<div id="base">
  <div class="offcanvas"></div>

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-cubes"></span> Data Inventory</h2>
      </div>
      <?php ($dataBase == 'master') ? $visibility = '' : $visibility = 'hidden'; ?>
      <?= $this->session->flashdata('msg'); ?>
      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="<?= base_url('admin/inventory'); ?>" class="btn btn-primary btn-raised"><span class="fa fa-arrow-left"></span>
            Kembali</a>
          <span style="visibility:<?= $visibility ?>;">
          <a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#modal_buat_stock"><span
              class="fa fa-plus"></span> Barang</a></span></p>

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
                  <th>Minimum Stock</th>
                  <th>Satuan</th>
                  <th>Harga / Satuan</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 0;
                foreach ($data as $table_content) :
                  $no++ ?>
                  <tr>
                    <td> <?= $no ?> </td>
                    <td> <?= $table_content['stock_kode'] ?></td>
                    <td> <?= $table_content['stock_nama'] ?></td>
                    <td> <?= $table_content['stock_kat'] ?></td>
                    <td> <?= $table_content['stock_qty'] ?></td>
                    <td> <?= $table_content['stock_min_qty'] ?></td>
                    <td> <?= $table_content['stock_satuan'] ?></td>
                    <td> <?= $table_content['stock_harga'] ?></td>
                    <td class="text-right">
                      <span style="visibility:<?= $visibility ?>;">
                        <a href="#" class="btn btn-icon-toggle btn-raised" title="Tambah Stock Barang" data-toggle="modal"
                          data-target="#modal_add_stock<?= $table_content['stock_id'] ?>"><i class="fa fa-plus" hidden></i></a>
                      </span>
                      <span style="visibility:<?= $visibility ?>;">
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Transfer Stock Barang" data-toggle="modal"
                        data-target="#modal_transfer_stock<?= $table_content['stock_id'] ?>"><i
                          class="fa fa-exchange text-primary-dark" <?= $visibility ?>></i></a>
                      </span>
                      <a href="#" class="btn btn-icon-toggle btn-raised" title="Edit Stock Barang" data-toggle="modal"
                        data-target="#modal_edit_stock<?= $table_content['stock_id'] ?>"><i
                          class="fa fa-pencil text-warning" <?= $visibility ?>></i></a>
                      <a href="<?= base_url('admin/inventory/hapus_inventory/') . $dataBase . '/' . $table_content['stock_id']; ?>"
                        class="btn btn-icon-toggle btn-raised" title="Hapus Barang">
                        <i class="fa fa-trash-o text-danger"></i></a>
                    </td>
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


<!-- ============ MODAL BUAT STOCK =============== -->
<div class="modal fade" id="modal_buat_stock" tabindex="-1" role="dialog" aria-labelledby="largeModal"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Data Barang</h3>
      </div>
      <form class="form-horizontal" role="form" method="post"
        action="<?= base_url('admin/inventory/simpan_inventory/') . $dataBase; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Kode Barang</label>
            <div class="col-sm-8">
              <input name="stock_kode" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Barang</label>
            <div class="col-sm-8">
              <input name="stock_nama" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label for="select13" class="col-sm-3 control-label">Kategori</label>
            <div class="col-sm-8">
              <input list="kategori" id="select13" name="stock_kat" class="form-control" required />
              <datalist id="kategori">
                <option value="">&nbsp;</option>
                <?php $kat = "";
                foreach ($data as $row) :
                  if ($kat !== $row['stock_kat']) : ?>
                    <option value="<?= $row['stock_kat'] ?>"></option>
                    <?php $kat = $row['stock_kat']; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              </datalist>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Stock</label>
            <div class="col-sm-8">
              <input name="stock_qty" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Minimum Stock Alert</label>
            <div class="col-sm-8">
              <input name="stock_min_qty" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <label for="select13" class="col-sm-3 control-label">Satuan</label>
            <div class="col-sm-8">
              <select id="select13" name="stock_satuan" class="form-control" required>
                <option value="">&nbsp;</option>
                <option value="PCS">PCS</option>
                <option value="KG">KG</option>
                <option value="Liter">Liter</option>
                <option value="Pack">Pack</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Harga / Satuan</label>
          <div class="col-sm-8">
            <input name="stock_harga" type="number" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
          <button class="btn btn-primary btn-raised" type="submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- ============ MODAL EDIT STOCK =============== -->
<?php foreach ($data as $table_content) : ?>
<div class="modal fade" id="modal_edit_stock<?= $table_content['stock_id']; ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Edit data Barang</h3>
      </div>
      <form class="form-horizontal" role="form" method="post"
        action="<?= base_url('admin/inventory/simpan_inventory/') . $dataBase; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Kode Barang</label>
            <div class="col-sm-8">
              <input name="stock_id" type="hidden" class="form-control" value="<?= $table_content['stock_id'] ?>"
                required>
              <input name="stock_kode" class="form-control" value="<?= $table_content['stock_kode'] ?>"
                required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Barang</label>
            <div class="col-sm-8">
              <input name="stock_nama" class="form-control" value="<?= $table_content['stock_nama'] ?>"
                required>
            </div>
          </div>
          <div class="form-group">
            <label for="select13" class="col-sm-3 control-label">Kategori</label>
            <div class="col-sm-8">
              <input list="kategori" id="select13" name="stock_kat" class="form-control"
                value="<?= $table_content['stock_kat'] ?>" required />
              <datalist id="kategori">
                <option value="">&nbsp;</option>
                <?php $kat = "";
                  foreach ($data as $row) :
                    if ($kat !== $row['stock_kat']) : ?>
                    <option value="<?= $row['stock_kat'] ?>"></option>
                    <?php $kat = $row['stock_kat']; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              </datalist>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Stock</label>
            <div class="col-sm-8">
              <input name="stock_qty" class="form-control" value="<?= $table_content['stock_qty'] ?>"
                required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Minimum Stock Alert</label>
            <div class="col-sm-8">
              <input name="stock_min_qty" class="form-control"
                value="<?= $table_content['stock_min_qty']; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="select13" class="col-sm-3 control-label">Satuan</label>
            <div class="col-sm-8">
              <select id="select13" name="stock_satuan" class="form-control" required>
                <option value="<?= $table_content['stock_satuan'] ?>"><?= $table_content['stock_satuan'] ?></option>
                <option value="PCS">PCS</option>
                <option value="KG">KG</option>
                <option value="Liter">Liter</option>
                <option value="Pack">Pack</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Harga / Satuan</label>
            <div class="col-sm-8">
              <input name="stock_harga" type="number" class="form-control"
                value="<?= floatval($table_content['stock_harga']); ?>" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat btn-raised" data-dismiss="modal" aria-hidden="true">Tutup</button>
          <button class="btn btn-primary" type="submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!---- MODAL TAMBAH STOCK ----->
<?php foreach ($data as $table_content) : ?>
<div class="modal fade" id="modal_add_stock<?= $table_content['stock_id'] ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Tambah Stock</h3>
      </div>
      <form class="form-horizontal" role="form" method="post"
        action="<?= base_url('admin/inventory/tambah_inventory/') . $dataBase; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Barang</label>
            <div class="col-sm-8">
              <input name="stock_nama" class="form-control" value="<?= $table_content['stock_nama']; ?>"
                readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Tambahan Qty Barang</label>
            <div class="col-sm-8">
              <input type="hidden" name="stock_id" class="form-control" 
                value="<?= $table_content['stock_id']; ?>" required>
              <input name="stock_qty" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary btn-raised btn-flat" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!---- MODAL TRANSFER STOCK ---->
<?php foreach ($data as $table_content) : ?>
<div class="modal fade" id="modal_transfer_stock<?= $table_content['stock_id'] ?>" tabindex="-1" role="dialog"
  aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
          <span class="fa fa-times"></span></button>
        <h3 class="modal-title" id="myModalLabel">Transfer Stock</h3>
      </div>
      <form class="form-horizontal" role="form" method="post"
        action="<?= base_url('admin/inventory/transfer_inventory/') . $dataBase; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">Nama Barang</label>
            <div class="col-sm-8">
              <input type="hidden" name="stock_id" class="form-control"
                value="<?= $table_content['stock_id']; ?>" required>
              <input name="stock_nama" class="form-control" value="<?= $table_content['stock_nama']; ?>"
                readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Outlet Tujuan</label>
            <div class="col-sm-8">
              <select name="db_target" class="form-control">
                <option value="">&nbsp;</option>
                <?php foreach ($outlet as $row) : ?>
                <option value="<?= $row['out_id']; ?>"><?= $row['out_nama']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Qty Barang ( <?= $table_content['stock_satuan'] ?>
              )</label>
            <div class="col-sm-8">
              <input name="stock_qty" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-raised btn-flat btn-primary" data-dismiss="modal" aria-hidden="true">Tutup</button>
            <button class="btn btn-primary" type="submit">Transfer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>