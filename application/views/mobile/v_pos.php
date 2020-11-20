<img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" />
<div id="base">
  <!-- BEGIN BASE-->
  <div class="msg"></div>
  <section class="style-default no-padding no-margin">

    <div class="container-fluid no-padding">
      <div class="col-md-12 col-xs-12 col-sm-12 no-padding">
        <div class="card-head style-primary" style="position:sticky; top:0; z-index:10001">
          <a class="btn btn-icon ink-reaction pull-right" href="#offcanvas-demo-left" data-toggle="offcanvas"><span class="fa fa-bars"></span></a>
          <!-- <div class="tools pull-left"> 
            <form class="navbar-search" role="search">
              <div class="form-group">
                <input type="text" class="form-control" name="contactSearch" placeholder="Search Outlet">
              </div>
              <button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
            </form>
          </div> -->
        </div>
        <div class="card">
          <div class="tab-slider">
            <div class="wrap">
              <ul class="nav nav-tabs" id="menus" role="tablist" id="example-tabs" data-tabs>
                <li role="presentation" class="active"><a href="#panel-all" aria-controls="home" role="tab" data-toggle="tab">Semua</a></li>
                <?php foreach ($kategori as $index => $tab) : ?>
                  <li role="presentation"><a href="#panel-<?= $index; ?>" role="tab" data-toggle="tab"><?= $tab['kategori_nama']; ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <button id="goPrev" class="btn btn-default btn-icon"><i class="fa fa-chevron-left "></i></button>
            <button id="goNext" class="btn btn-default btn-icon"><i class="fa fa-chevron-right "></i></button>
          </div>
          <div class="tabs-content" data-tabs-content="example-tabs" style="overflow-y:scroll">
            <div role="tabpanel" class="tab-pane active" id="panel-all">
              <?php foreach ($data as $index => $table_content) : ?>
                <div class="col-md-2 col-xs-6 col-sm-3">
                  <div class="table-responsive">
                    <div class="no-padding card thumbnail btn">
                      <a data-toggle="modal" class="modal_add_cart btn-raised" data-itemid="<?= $table_content['menu_id'] ?>" data-target="#option_menu<?= $table_content['menu_id'] ?>" data-itemname="<?= $table_content['menu_nama'] ?>">
                        <td>
                          <img style="width:auto;height:13rem;border-radius:4px;" class="width-1 img-responsive rounded" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" />
                        </td>
                        <div class="caption text-left no-padding">
                          <h5 class="text-light">&nbsp;<strong><?= $table_content['menu_nama']; ?></strong></h5>
                          <div>
                            <h5 class="no-margin text-light">&nbsp;
                              <strong><?= number_format($table_content['menu_harga_baru']); ?></strong></h5>
                      </a>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
        <?php foreach ($kategori as $index => $tab) : ?>
          <div role="tabpanel" class="tab-pane" id="panel-<?= $index; ?>">
            <?php foreach ($kategori_makanan as $index => $table_content) : ?>
              <?php if (($table_content['kategori_id'] == $tab['kategori_id'])) : ?>
                <div class="col-md-3 col-xs-6 col-sm-3">
                  <div class="table-responsive">
                    <div class="no-padding card thumbnail btn">
                      <a data-toggle="modal" class="modal_add_cart btn-raised" data-itemid="<?= $table_content['menu_id'] ?>" data-target="#option_menu<?= $table_content['menu_id'] ?>" data-itemname="<?= $table_content['menu_nama'] ?>">
                        <td>
                          <img style="width:auto;height:13rem;border-radius:4px;" class="width-1 img-responsive rounded" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" />
                        </td>
                        <div class="caption text-left no-padding">
                          <h5 class="text-light">&nbsp;<strong><?= $table_content['menu_nama']; ?></strong></h5>
                          <div>
                            <h5 class="no-margin text-light">&nbsp;
                              <strong><?= number_format($table_content['menu_harga_baru']); ?></strong></h5>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php
  $qty_in_view_cart_button = 0;
  $grand_total_in_view_cart_button = 0;
  foreach ($cart as $c) :
    $qty_in_view_cart_button += $c['qty'];
    $grand_total_in_view_cart_button += $c['subtotal'];
  endforeach;
  ?>
  <a style="position:fixed; bottom:0" href="<?= base_url('mobile/pos/display_table_cart/'); ?>" class="btn btn-block btn-primary btn-raised">
    <div class="row">
      <div class="col-xs-4">View Basket</div>
      <div class="col-xs-4" id="qtyViewCart"><?= $qty_in_view_cart_button ?> Items</div>
      <div class="col-xs-4" id="grandTotalViewCart">Rp. <?= number_format($grand_total_in_view_cart_button); ?></div>
    </div>
  </a>
</div>

<!-- BEGIN OFFCANVAS DEMO LEFT -->
<div class="offcanvas">
  <div id="offcanvas-demo-left" class="offcanvas-pane width-6">
    <div class="offcanvas-head">
      <header>Left off-canvas</header>
      <div class="offcanvas-tools">
        <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
          <i class="md md-close"></i>
        </a>
      </div>
    </div>

    <div class="offcanvas-body">
      <p>
        An off-canvas can hold any content you want.
      </p>
      <p>
        Close this off-canvas by clicking on the backdrop or press the close button in the upper right corner.
      </p>
      <p>&nbsp;</p>
      <h4>Some details</h4>
      <ul class="list-divided">
        <li><strong>Width</strong><br /><span class="opacity-75">240px</span></li>
        <li><strong>Height</strong><br /><span class="opacity-75">100%</span></li>
        <li><strong>Body scroll</strong><br /><span class="opacity-75">disabled</span></li>
        <li><strong>Background color</strong><br /><span class="opacity-75">Default</span></li>
      </ul>
    </div>
  </div>
</div>
<!-- END OFFCANVAS DEMO LEFT -->

<?php foreach ($data as $index => $table_content) : ?>
  <div class="modal fade" id="option_menu<?= $table_content['menu_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="card-body">
          <div class="modal-header">
            <button type="button" class="close text-danger btn-raised" data-dismiss="modal" aria-hidden="true">
              <span class="fa fa-times"></span></button>
          </div>
          <form class="form-horizontal" id="form_search" action="#" method="post">
            <div class="modal-body">
              <img style="width:35rem;height:18rem;" class="width-1 img-responsive" src="<?= base_url() . 'assets/gambar/' . $table_content['menu_gambar']; ?>" alt="" />
              <div class="form-group card-body">
                <h3 class="text-light pull-left"><strong><?= $table_content['menu_nama']; ?></strong></h3>
                <h3 class="text-light pull-right">
                  <strong><?= number_format($table_content['menu_harga_baru']); ?></strong></h3>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Add Notes (Optional)</label>
                <div class="col-sm-8">
                  <textarea type="text" class="form-control" id="notes_pesanan<?= $table_content['menu_id']; ?>"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-5 text-right no-padding">
                  <a class="addQtyItems btn btn-default btn-icon btn-raised" data-itemname="<?= $table_content['menu_nama']; ?>" data-itemid="<?= $table_content['menu_id']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>"><i class="fa fa-plus"></i></a>
                </div>
                <div class="col-xs-2">
                  <div class="form-group">
                    <input type="number" class="form-control text-center" id="qty-<?= $table_content['menu_id']; ?>" name="qty" value="0" required>
                  </div>
                </div>
                <div class="col-xs-5 text-left no-padding">
                  <a class="minusQtyItems btn btn-default btn-icon btn-raised" data-itemname="<?= $table_content['menu_nama']; ?>" data-itemid="<?= $table_content['menu_id']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>"><i class="fa fa-minus"></i></a>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <a href="#" class="add_cart btn btn-block btn-primary btn-raised" data-dismiss="modal" id="add_cart_<?= $table_content['menu_id'] ?>" aria-hidden="true" data-itemid="<?= $table_content['menu_id']; ?>" data-itemname="<?= $table_content['menu_nama']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>">Add to basket</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<script src="<?= base_url() . 'assets/js/jquery-3.4.1.min.js' ?>"></script>
<script type="text/javascript">
  var data = JSON.parse('<?= json_encode($data) ?>')
  var ingredient = JSON.parse('<?= json_encode($ingredient) ?>')
  var inventory = JSON.parse('<?= json_encode($inventory) ?>')

  var shoppingCart = (function() {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];

    // Constructor
    function Item(id, name, price, count, notes, recipe) {
      this.id = id;
      this.name = name;
      this.price = price;
      this.count = count;
      this.notes = notes;
      this.recipe = recipe;
    }

    // Save cart
    function saveCart() {
      sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    // Load cart
    function loadCart() {
      cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
    }
    if (sessionStorage.getItem("shoppingCart") != null) {
      loadCart();
    }


    // =============================
    // Public methods and propeties
    // =============================
    var obj = {};

    // Add to cart
    obj.addItemToCart = function(id, name, price, count, notes, recipe) {
      for (var item in cart) {
        if (cart[item].id === id) {
          cart.splice(item, 1);
        }
      }
      var item = new Item(id, name, price, count, notes, recipe);
      (count > 0) && cart.push(item);
      saveCart();
    }

    // Total cart
    obj.totalCart = function() {
      let totalCart = cart.reduce((totItem, item) => totItem += item.price * item.count, 0)
      // for (var item in cart) {
      //   totalCart += cart[item].price * cart[item].count;
      // }
      return Number(totalCart.toFixed(2));
    }

    // List cart
    obj.listCart = function() {
      var cartCopy = [];
      for (i in cart) {
        item = cart[i];
        itemCopy = {};
        for (p in item) {
          itemCopy[p] = item[p];

        }
        itemCopy.total = Number(item.price * item.count).toFixed(2);
        cartCopy.push(itemCopy)
      }
      return cartCopy;
    }

    return obj;
  })();


  $('.add_cart').click(function(event) {
    event.preventDefault();
    var id = $(this).data('itemid')
    var name = $(this).data('itemname');
    var qty = $(`#qty-${id}`).val();
    var price = Number($(this).data('itemharga')) * qty;
    var notes = $('#notes_pesanan' + $(this).data("itemid")).val();

    var recipe = {
      ...ingredient
      .filter(ing => ing.ing_menu_id == id)
      .reduce((nm, currnm) => {
        nm[currnm.ing_inv_id] = (currnm.ing_qty * currnm.satuan_val);
        return nm
      }, {})
    }

    if (isEmptyObj(recipe)) {
      var msg = `<div class="alert alert-warning animate">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      Belum Buat Stock</div>`
      $('.msg').html(msg);
      setTimeout(() => {
        $('.msg').html('');
      }, 3000)
      return true;
    }
    if (isStockZero(recipe)) {
      var nullRecipe = isStockZero(recipe)
      var msg = `<div class="alert alert-warning animate">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      Stock Bahan `
      nullRecipe.forEach(r => msg += `<strong>Menu Kosong </strong></div>`)

      $('.msg').html(msg);
      setTimeout(() => {
        $('.msg').html('');
      }, 3000)
      return true;
    }
    shoppingCart.addItemToCart(id, name, price, qty, notes, recipe)
    calculateItemTotalPriceButtonViewCart()
  });

  var isEmptyObj = Obj => {
    return ((Object.keys(Obj).length == 0) ? true : false)
  }

  var isStockZero = Obj => {
    let nullInventory =
      inventory.filter(inv => (Object.keys(Obj)
        .includes(inv.stock_id)) && parseInt(inv.stock_qty) === 0)

    return ((nullInventory.length > 0) ? nullInventory : false)
  }

  //Button Prev Next Category
  let menus = $("#menus"),
    menuWidth = menus.parent().outerWidth();
  let menupage = Math.ceil(menus[0].scrollWidth / menuWidth),
    currPage = 1;
  if (menupage > 1) {
    $('#goPrev').click(function() {
      $('.wrap').animate({
        scrollLeft: '-=100'
      }, 200);
    });

    $('#goNext').click(function() {
      $('.wrap').animate({
        scrollLeft: '+=100'
      }, 200);
    });
    $(window).on("resize", function() {
      menuWidth = menus.parent().outerWidth();
      menupage = Math.ceil(menus[0].scrollWidth / menuWidth);
      currPage = Math.ceil(-parseInt(menus.css("left")) / menuWidth) + 1;
    });
  }

  //button add minus qty
  $('.addQtyItems').click(function(e) {
    e.preventDefault();
    if (!event.detail || event.detail == 1) {
      let id = $(this).data("itemid");
      let harga = $(this).data("itemharga");
      let qty = Number($(`#qty-${id}`).val());
      if (qty == 0) {
        $('.add_cart').css("background-color", "#0aa89e");
      };
      qty += 1;
      calculateItemTotalPriceButtonAddCart(id, harga, qty)
    };
  });

  $('.minusQtyItems').click(function(e) {
    e.preventDefault();
    if (!event.detail || event.detail == 1) {
      let id = $(this).data("itemid");
      let harga = $(this).data("itemharga");
      let qty = Number($(`#qty-${id}`).val());
      if (qty > 0) {
        qty -= 1;
        calculateItemTotalPriceButtonAddCart(id, harga, qty);
      };
    };
  });

  let calculateItemTotalPriceButtonAddCart = (id, harga, qty) => {
    if (qty > 0) {
      harga *= qty;
      $(`#qty-${id}`).val(qty);
      $('.add_cart').html(`add to basket - ${Intl.NumberFormat().format(harga)}`);
      return
    }
    harga = 0;
    $(`#qty-${id}`).val(qty);
    $('.add_cart').html('add to basket')
    if (isEmptyObj(cart)) {
      return
    }
    console.log('poop')
    for (var item in cart) {
      console.log('inner poop')
      if (cart[item].id === id) {
        console.log('deep inner poop')
        $(`#add_cart_${cart[item].id}`).html(`Delete Item`);
        $(`#add_cart_${cart[item].id}`).css("background-color", "red");
      }
    }
  }


  let calculateItemTotalPriceButtonViewCart = () => {
    let qtyViewCartButton = 0;
    let subTotalViewCartButton = 0;
    for (var item in cart) {
      qtyViewCartButton += Number(cart[item].count);
      subTotalViewCartButton += cart[item].price;
    }
    $('#qtyViewCart').html(`${qtyViewCartButton} ITEMS`);
    $('#grandTotalViewCart').html(`Rp ${Number(subTotalViewCartButton).toLocaleString('id-ID')}`);
  }

  $('.modal_add_cart').click(function() {
    let id = $(this).data("itemid");
    let qty = $(`#qty-${id}`).val();
    if (qty == 0) {
      $('.add_cart').html('add to basket');
      $('.add_cart').css("background-color", "#0aa89e");
      $(`#qty-${id}`).val(qty);
    }
  });

  $(() => {
    setTimeout(() => {
      document.querySelector('#loading-screen').style.display = 'none';
      document.querySelector('#base').style.display = 'block';
    }, 1000)
    let qtyViewCartButton = 0;
    let subTotalViewCartButton = 0;
    if (isEmptyObj(cart)) {
      return
    };
    for (var item in cart) {
      $(`#qty-${cart[item].id}`).val(cart[item].count);
      $(`#add_cart_${cart[item].id}`).html(`add to basket ${(cart[item].count * cart[item].price).toLocaleString('id-ID')}`);
      qtyViewCartButton += Number(cart[item].count);
      subTotalViewCartButton += cart[item].price;
    }
    $('#qtyViewCart').html(`${qtyViewCartButton} ITEMS`);
    $('#grandTotalViewCart').html(`Rp ${Number(subTotalViewCartButton).toLocaleString('id-ID')}`);
  });
</script>
</div>
</div>
</body>

</html>