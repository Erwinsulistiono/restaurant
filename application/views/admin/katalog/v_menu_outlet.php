<div id="base">
  <div class="offcanvas"></div>

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-cutlery"></span> Data Menu</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>

      <section class="card style-default-bright" style="margin-top:0px;">
        <p><a href="<?= base_url('admin/menu'); ?>" class="btn btn-primary btn-raised"><span class="fa fa-arrow-left"></span>
            Kembali</a>
          <?php (($dataBase == 'master') && print('<a href="#" class="btn btn-primary btn-raised" data-toggle="modal" data-target="#addNewModal"><span
              class="fa fa-plus"></span> Tambah Menu</a>')) ?>
        </p>

        <div class="section-body">
          <div class="row">

            <table class="table no-margin no-padding table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>Gambar</th>
                  <th>Nama Menu</th>
                  <th style="width:35%;">Deskripsi</th>
                  <th style="text-align:center;">Harga</th>
                  <th style="width:15%;">Kategori</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $table_content) :  ?>
                  <tr>
                    <td><img style="width:80px;height:80px;" class="img-thumbnail width-1" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" /></td>
                    <td><?= $table_content['menu_nama']; ?></td>
                    <td><?= limit_words($table_content['menu_deskripsi'], 10) . '...'; ?></td>
                    <?php if (empty($table_content['menu_harga_lama'])) : ?>
                      <td style="text-align:right;"><?= 'Rp ' . number_format($table_content['menu_harga_baru']); ?></td>
                    <?php else : ?>
                      <td style="vertical-align:middle;text-align:right;">
                        <b><?= 'Rp ' . number_format($table_content['menu_harga_baru']); ?></b>
                        <p style="font-size:9px;">
                          <del><?= 'Rp ' . number_format($table_content['menu_harga_lama']); ?></del></p>
                      </td>
                    <?php endif; ?>
                    <td>
                      <?php foreach ($kategori_makanan as $row) :
                        if (($table_content['menu_id']) == ($row['menu_id'])) :
                          echo $row['kategori_nama'] . ', ';
                        endif;
                      endforeach;
                      ?>
                    </td>
                    <td class="text-right">
                      <?php (($dataBase == 'master') && print('<a href="#" class="btn btn-icon-toggle btn-raised" title="Edit row" data-toggle="modal"
                      data-target="#UpdateModal' . $table_content['menu_id'] . '"><i class="fa fa-pencil"></i></a>
                    <a href="#" data-row="' . $table_content['menu_id'] . '" class="addIng btn btn-icon-toggle btn-raised"
                      title="Edit recipe" data-toggle="modal" data-target="#RecipeModal' . $table_content['menu_id'] . '"><i
                        class="fa fa-file text-primary-dark"></i></a>
                    <a href="#" data-row="' . $table_content['menu_id'] . '" class="addIng btn btn-icon-toggle btn-raised"
                      title="Tambah Menu Ke Outlet" data-toggle="modal" data-target="#MenuTransferModal' . $table_content['menu_id'] . '"><i
                        class="fa fa-exchange text-primary-dark"></i></a>')); ?>
                      <a href="<?= base_url('admin/menu/hapus_menu/') . $dataBase . '/' . $table_content['menu_id']; ?>" onclick="return confirm('Apakah anda yakin?')" class="btn btn-icon-toggle text-danger btn-raised" title="Delete row"><i class="fa fa-trash-o"></i></a>
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


<!-- ================== Modal Add New Menu =======================-->
<form class="form" role="form" action="<?= base_url('admin/menu/simpan_menu/'); ?>" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
            <span class="fa fa-close"></span></button>
          <h3 class="modal-title" id="myModalLabel">Tambah Menu</h3>
        </div>

        <div class="card no-margin">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="menu_nama" class="form-control" required>
                  <label>Tambah Data Menu</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="hidden" name="menu_harga_lama" class="form-control" value="">
                  <input type="text" name="menu_harga_baru" class="form-control" required>
                  <label>Harga Menu</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <label style="padding-top:1.9rem;opacity:0.5; font-size:1.7rem;">Kategori</label>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <div class="form-control select2-list">
                    <select class="bootstrap-select" name="product[]" data-width="100%" data-live-search="true" multiple required>
                      <?php foreach ($kategori as $row) : ?>
                        <option value="<?= $row['kategori_id']; ?>"><?= $row['kategori_nama']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <textarea type="text" rows="3" name="menu_deskripsi" class="form-control"></textarea>
                  <label>Deskripsi</label>
                </div>
              </div>
            </div>
            <!-- BEGIN FILE UPLOAD -->
            <div class="row">
              <div class="col-md-2">
                <label style="padding-top:1.9rem;opacity:0.5; font-size:1.7rem;">Foto</label>
              </div>
              <div class="form-group">
                <input type="file" name="filefoto" class="form-control">
              </div>
              <!--end .row -->
              <!-- END FILE UPLOAD -->
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-raised" type="submit">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>


<?php
foreach ($data as $table_content) :
?>
  <!-- MODAL EDIT MENU -->
  <form action="<?= base_url('admin/menu/simpan_menu/'); ?>" method="post">
    <div class="modal fade" id="UpdateModal<?= $table_content['menu_id']; ?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
              <span class="fa fa-times"></span></button>
            <h3 class="modal-title" id="myModalLabel">Edit Menu</h3>
          </div>

          <div class="card no-margin">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" name="menu_id" class="form-control" value="<?= $table_content['menu_id']; ?>">
                    <input type="text" name="menu_nama" class="form-control" value="<?= $table_content['menu_nama']; ?>" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" name="menu_harga_lama" class="form-control" value="<?= $table_content['menu_harga_baru']; ?>">
                    <input type="text" name="menu_harga_baru" class="form-control" value="<?= $table_content['menu_harga_baru']; ?>" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <label style="opacity:0.5; font-size:1.7rem;">Kategori</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <div class="form-control select2-list">
                      <select class="bootstrap-select" name="product[]" data-width="100%" data-live-search="true" multiple required>
                        <?php
                        foreach ($kategori as $row) :
                          foreach ($kategori_makanan as $k) : (($table_content['menu_id'] == $k['menu_id']) && ($row['kategori_id'] == $k['kategori_id'])) ? $select = "selected" : "";
                          endforeach;
                        ?>
                          <option value="<?= $row['kategori_id']; ?>" <?= $select; ?>><?= $row['kategori_nama']; ?></option>
                        <?php
                          $select = "";
                        endforeach;
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label style="opacity:0.5; font-size:1.7rem;">Deskripsi</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <textarea type="text" rows="3" name="menu_deskripsi" class="form-control"><?= $table_content['menu_deskripsi'] ?></textarea>
                  </div>
                </div>
              </div>
              <!-- BEGIN FILE UPLOAD -->
              <div class="row">
                <div class="col-md-2">
                  <label style="opacity:0.5; font-size:1.7rem;">Foto</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <input type="file" name="filefoto" class="form-control">
                    <span>"<?= $table_content['menu_gambar'] ?>"</span>
                  </div>
                </div>
              </div>
              <!--end .row -->
              <!-- END FILE UPLOAD -->
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-primary btn-raised" type="submit">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php endforeach; ?>

<?php
foreach ($data as $table_content) :
?>
  <form class="form-horizontal" action="<?= base_url('admin/menu/transfer_menu/') . $table_content['menu_id']; ?>" method="post">
    <div class="modal fade" id="MenuTransferModal<?= $table_content['menu_id']; ?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
              <span class="fa fa-close"></span></button>
            <h3 class="modal-title" id="myModalLabel">Transfer Menu <?= $table_content['menu_nama']; ?></h3>
          </div>

          <div class="card no-margin">
            <div class="form-group">
              <label class="col-sm-3 control-label">Outlet Tujuan</label>
              <div class="col-sm-8">
                <select name="outlet_tujuan" class="form-control">
                  <option value="">&nbsp;</option>
                  <?php foreach ($outlet as $row) : ?>
                    <option value="<?= $row['out_id']; ?>"><?= $row['out_nama']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn btn-primary btn-raised" type="submit">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php endforeach; ?>

<?php
foreach ($data as $table_content) :
?>
  <!-- Modal Add/Update Resep-->
  <form class="form-horizontal formIngredient" action="<?= base_url('admin/menu/simpan_recipe/') . $dataBase . '/' . $table_content['menu_id']; ?>" method="post">
    <div class="modal fade" id="RecipeModal<?= $table_content['menu_id']; ?>" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="close-recipe<?= $table_content['menu_id'] ?>" class="close btn-raised text-danger" data-dismiss="modal" aria-hidden="true">
              <span class="fa fa-close"></span></button>
            <h3 class="modal-title" id="myModalLabel">Edit Recipe <?= $table_content['menu_nama']; ?></h3>
          </div>

          <div class="card no-margin">
            <div class="repeater card-body"></div>
            <div class="card-body">
              <button type="button" class="addInputIng btn btn-flat btn-raised btn-primary"><span class="fa fa-plus"> Recipe</button>
            </div>
          </div>

          <div class="modal-footer">
            <a class="submitRecipe btn btn-raised btn-primary" data-dismiss="modal" data-menuid="<?= $table_content['menu_id']; ?>" aria-hidden="true" data-form="<?= $table_content['menu_id']; ?>">Simpan</a>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php endforeach; ?>

<!--Load JavaScript File-->
<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<script type="text/javascript">
  $(function() {
    $('.bootstrap-select').selectpicker();
  });

  let no;
  let dataBase = '<?php echo $dataBase ?>';
  let inventory = [];
  let checkRecipeDuplicate;
  let ingredient = JSON.parse('<?php echo $ingredient ?>');
  let satuan = JSON.parse('<?php echo $satuan ?>');
  let ing_inv_id;
  let ing_qty;
  let ing_satuan_id;

  $('.addIng').click(function(e) {
    no = 0
    let menu_id = $(this).data('row');
    let data = ingredient.filter(ing => ing.ing_menu_id == menu_id);
    printIng(data);
  });

  $('.addInputIng').click(function(e) {
    printNewIngLine();
  });

  $(document).on('change', '.ing_qty', function() {
    let qty = $(this).val();
    ing_qty.push(qty);
  })

  $(document).on('change', '.sat-change', function() {
    let satuan = $(this).val();
    ing_satuan_id.push(satuan);
  })

  $(document).on('click', '.remove_field', function(e) {
    e.preventDefault();
    const k = $(this).data("delete");
    let deletedId = Number($('.ingId-' + k).val().replace(/[($)\s\._\-]+/g, ''));
    let strdeletedId = '\"' + deletedId + '\"'
    $(this).closest('div.additional').remove();
    let deletedIndex = ing_inv_id.indexOf('' + deletedId + '');
    ing_inv_id.splice(deletedIndex, 1);
    (deletedIndex < ing_qty.length) && ing_qty.splice(deletedIndex, 1);
    (deletedIndex < ing_satuan_id.length) && ing_satuan_id.splice(deletedIndex, 1);
    removeIdAndAssignToSelect(deletedId);
  })

  function printNewIngLine() {
    no++;
    let repeatInput = '';
    let divs = $("div.repeater").html();

    repeatInput += `<div class="row additional">
      <div class="col-xs-7">
      <div class="form-group">
      <label class="col-xs-3" style="opacity:0.5; font-size:1.7rem;">ingredient</label>
      <div class="col-xs-8">
      <select name="ing_inv_id[]" data-ing="${no}" class="ingId-${no} ing
      form-control" onchange="printAvailSatuan( value ,${no})">
      <option value="">&nbsp;</option>
      </select>
      </div>
      </div>
      </div>
      <div class="col-xs-4">
      <div class="form-group">
      <label class="col-xs-2" style="opacity:0.5; font-size:1.7rem;">Qty</label>
      <div class="col-xs-4">
      <input type="number" name="ing_qty[]" class="ing_qty form-control text-right" value="">
      </div>
      <div class="col-xs-6">
      <select name="ing_satuan_id[]" class="satuan-${no} sat-change form-control">
      <option value="">
      </option>
      </select>
      </div>
      </div>
      </div>
      <div class="col-xs-1">
      <a class="remove_field btn btn-icon-toggle text-danger" title="Delete row" data-delete="${no}">
      <i class="fa fa-trash-o"></i></a>
      </div>
      </div>`;
    $('.repeater').append(repeatInput);
    populateOptionIngredient();
  }

  function printIng(data) {
    inventory = JSON.parse('<?php echo $inventory ?>');
    ing_inv_id = [];
    ing_qty = [];
    ing_satuan_id = [];
    let repeatInput = '';
    let divs = $("div.repeater").html();

    const filterOutId = data.map(data_id => data_id.ing_inv_id);
    let selectInventory = inventory.filter(inv => !filterOutId.includes(inv.stock_id));

    for (let j in data) {
      no++;
      repeatInput += `<div class="row additional">
        <div class="col-xs-7">
        <div class="form-group">
        <label class="col-xs-3" style="opacity:0.5; font-size:1.7rem;">ingredient</label>
        <div class="col-xs-8">
        <select name="ing_inv_id[]" data-ing="${no}" class="ingId-${no} ing
        form-control" disabled>`;

      for (let i in inventory) {
        if (data[j].ing_inv_id == inventory[i].stock_id) {
          ing_inv_id.push(inventory[i].stock_id);
          repeatInput +=
            `<option value="${inventory[i].stock_id}" selected>${inventory[i].stock_nama} (${inventory[i].stock_satuan})</option>`;
        };
      };

      repeatInput += `</select>
        </div>
        </div>
        </div>
        <div class="col-xs-4">
        <div class="form-group">
        <label class="col-xs-2" style="opacity:0.5; font-size:1.7rem;">Qty</label>
        <div class="col-xs-4">
        <input type="number" name="ing_qty[]" class="form-control text-right" value="${Number(data[j].ing_qty)}" disabled>
        </div>
        <div class="col-xs-6">
        <select name="ing_satuan_id[]" class="satuan-${no} sat-change form-control" disabled>
        <option value="${data[j].satuan_id}" selected>${data[j].satuan_kode}</option>
        </select>
        </div>
        </div>
        </div>
        <div class="col-xs-1">
        <a class="remove_field btn btn-icon-toggle text-danger" title="Delete row" data-delete="${no}">
        <i class="fa fa-trash-o"></i></a>
        </div>
        </div>`;

      ing_satuan_id.push(data[j].satuan_id);
      ing_qty.push(Number(data[j].ing_qty));
    }
    inventory = selectInventory;
    checkRecipeDuplicate = filterOutId;
    $('.repeater').html(repeatInput);
    populateOptionIngredient();
  }

  let removeIdAndAssignToSelect = (deletedId) => {
    const allInventory = JSON.parse('<?php echo $inventory ?>');
    const addInventory = allInventory.filter(a => a.stock_id == deletedId);
    checkRecipeDuplicate.pop(deletedId);
    inventory = allInventory.filter(inv => !checkRecipeDuplicate.includes(inv.stock_id));
  }

  let printAvailSatuan = (ingId, id) => {
    $('.ing').prop('disabled', true);

    ing_inv_id.push(ingId);
    checkRecipeDuplicate.push(ingId);
    let ing = Number(ingId.replace(/[($)\s\._\-]+/g, ''));
    const resepDetail = inventory.filter(a => a.stock_id == ingId);
    const resepSatuan = resepDetail.map(satuan => satuan.stock_satuan);
    let satuanAvailiable = satuan.filter(b => resepSatuan.includes(b.satuan_reff));

    populateOptionSatuanAvail(satuanAvailiable, id);
    let selectInventory = inventory.filter(inv => inv.stock_id != ing);
    inventory = selectInventory;
  };

  let populateOptionSatuanAvail = (satuan, id) => {
    $.each(satuan, function(key, entry) {
      $('select.satuan-' + id).append($('<option></option>')
        .attr('value', entry.satuan_id).text(entry.satuan_kode));
    });
  }

  let populateOptionIngredient = () => {
    $.each(inventory, function(key, entry) {
      $('.ing').append($('<option></option>')
        .attr('value', entry.stock_id)
        .text(entry.stock_nama + ' (' + entry.stock_satuan + ') '));
    });
  }

  $(document).on('click', '.submitRecipe', function() {
    let data = {
      post_inv_id: ing_inv_id,
      post_qty: ing_qty,
      post_satuan_id: ing_satuan_id,
    };
    let menu_id = $(this).data('menuid');
    !isDuplicate(checkRecipeDuplicate) && alert("Duplicate Ingredient");
    isDuplicate(checkRecipeDuplicate) &&
      $.ajax({
        url: '<?= base_url('admin/menu/simpan_recipe/') ?>' + dataBase + '/' + menu_id,
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(data) {
          ingredient = data;
        },
        error: function() {
          ingredient = Object.values(ingredient).filter(val => {
            return val.ing_menu_id != menu_id
          })
        }
      })
    // $(`#close-recipe${menu_id}`).click();
    return false;
  })

  let isDuplicate = (array) => {
    return new Set(array).size == array.length
  }
</script>