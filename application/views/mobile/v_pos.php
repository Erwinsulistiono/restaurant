<body class="full-content">

  <img id="loading-screen" src="<?= base_url('assets/img/loading.svg') ?>" class="img-responsive" alt="" style="display: block; position: fixed; top: 40%; left: 45%;" />
  <div id="base" style="display: none;">
    <!-- BEGIN CONTENT-->

    <!-- BEGIN BASE-->
    <section class="style-default no-padding no-margin">
      <div class="card-head style-primary" style="position:fixed; top:0; left:0; right:0; z-index:1002">
        <button onclick="window.history.back()" class="btn btn-primary"><span class="fa fa-chevron-left" aria-hidden="true"></span> Back</button>
        <a href="#offcanvas-kategori" data-toggle="offcanvas" class="btn filter btn-primary pull-right" style="margin-top:3%;">Kategori &nbsp;<i class="fa fa-filter "></i></a>
      </div>
      <div class="container-fluid no-padding" style="min-height:89vh; margin-top:8vh;">
        <div class="col-md-12 col-xs-12 col-sm-12 no-padding">
          <div class="card" style="min-height:89vh; padding-top: 2vh">
            <div id="msgPos" style="position:fixed; top:10vh; left:0; right:0; z-index:10001"></div>
            <div class="tabs-content" data-tabs-content="example-tabs" style="overflow-y:scroll">
              <div role="tabpanel" class="tab-pane active" id="panel-all">
                <?php foreach ($data as $index => $table_content) :
                  $menu_gambar = $table_content['menu_gambar'];
                ?>
                  <div class="col-md-2 col-xs-6 col-sm-3">
                    <div class="no-padding card thumbnail" style="box-shadow: 1px 1px 4px 1px #e5e0e0;">
                      <a data-toggle="modal" class="modal_add_cart btn-raised" data-itemid="<?= $table_content['menu_id'] ?>" data-target="#option_menu<?= $table_content['menu_id'] ?>" data-itemname="<?= $table_content['menu_nama'] ?>">
                        <td>
                          <img loading="lazy" style="width:auto;height:13rem;border-radius:4px;" class="width-1 img-responsive rounded" src="<?= base_url("assets/gambar/${menu_gambar}"); ?>" alt="" />
                        </td>
                        <div class="caption text-left no-padding">
                          <h5 class="text-light">&nbsp;<?= ucwords($table_content['menu_nama']); ?></h5>
                          <div>
                            <h4>&nbsp;<?= number_format($table_content['menu_harga_baru']); ?></h4>
                      </a>
                    </div>
                  </div>
              </div>
            </div>
          <?php endforeach; ?>
          </div>
          <?php foreach ($kategori as $index => $tab) : ?>
            <div role="tabpanel" class="tab-pane" id="panel-<?= $index; ?>">
              <?php foreach ($kategori_makanan as $index => $table_content) :
                $menu_gambar = $table_content['menu_gambar'];
              ?>
                <?php if (($table_content['kategori_id'] == $tab['kategori_id']) && $table_content['menu_nama'] != '') : ?>
                  <div class="col-md-3 col-xs-6 col-sm-3">
                    <div class="no-padding card thumbnail" style="box-shadow: 1px 1px 4px 1px #e5e0e0">
                      <a data-toggle="modal" class="modal_add_cart btn-raised" data-itemid="<?= $table_content['menu_id'] ?>" data-target="#option_menu<?= $table_content['menu_id'] ?>" data-itemname="<?= $table_content['menu_nama'] ?>">
                        <td>
                          <img loading="lazy" style="width:auto;height:13rem;border-radius:4px;" class="width-1 img-responsive rounded" src="<?= base_url("assets/gambar/${menu_gambar}"); ?>" alt="" />
                        </td>
                        <div class="caption text-left no-padding">
                          <h5 class="text-light">&nbsp;<?= ucwords($table_content['menu_nama']); ?></h5>
                          <div>
                            <h4>&nbsp;<?= number_format($table_content['menu_harga_baru']); ?></h4>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <a style="position:fixed; bottom:0" href="<?= base_url('mobile/pos/display_table_cart/'); ?>" id="viewCart" class="btn btn-block btn-primary btn-raised">
      <div class="row">
        <div class="col-xs-4">View cart</div>
        <div class="col-xs-4" id="qtyViewCart">0 Items</div>
        <div class="col-xs-4" id="grandTotalViewCart">Rp. </div>
      </div>
    </a>
  </div>


  <?php foreach ($data as $index => $table_content) :
    $menu_gambar = $table_content['menu_gambar'];
  ?>
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
                <img loading="lazy" style="width:35rem;height:18rem;" class="width-1 img-responsive" src="<?= base_url("assets/gambar/$menu_gambar"); ?>" alt="" />
                <div class="form-group card-body">
                  <h3 class="text-light pull-left"><strong><?= $table_content['menu_nama']; ?></strong></h3>
                  <h3 class="text-light pull-right">
                    <strong><?= number_format($table_content['menu_harga_baru']); ?></strong>
                  </h3>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Add Notes (Optional)</label>
                  <div class="col-sm-8">
                    <textarea type="text" class="form-control" id="notes_pesanan<?= $table_content['menu_id']; ?>"></textarea>
                  </div>
                </div>
                <div class="row">

                  <div class="col-xs-5 text-right no-padding">
                    <a class="minusQtyItems btn btn-default btn-icon btn-raised" data-itemname="<?= $table_content['menu_nama']; ?>" data-itemid="<?= $table_content['menu_id']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>"><span class="fa fa-minus"></span></a>
                  </div>
                  <div class="col-xs-2">
                    <div class="form-group">
                      <input type="number" class="form-control text-center" id="qty-<?= $table_content['menu_id']; ?>" name="qty" value="0" required readonly>
                    </div>
                  </div>
                  <div class="col-xs-5 text-left no-padding">
                    <a class="addQtyItems btn btn-default btn-icon btn-raised" data-itemname="<?= $table_content['menu_nama']; ?>" data-itemid="<?= $table_content['menu_id']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>"><span class="fa fa-plus"></span></a>
                  </div>

                </div>
              </div>
              <div class="modal-footer">
                <a href="#" class="add_cart btn btn-block btn-primary btn-raised" data-dismiss="modal" id="add_cart_<?= $table_content['menu_id'] ?>" aria-hidden="true" data-itemid="<?= $table_content['menu_id']; ?>" data-itemname="<?= $table_content['menu_nama']; ?>" data-itemharga="<?= $table_content['menu_harga_baru']; ?>">Add to cart</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="offcanvas">
    <!-- BEGIN OFFCANVAS DEMO LEFT -->
    <div id="offcanvas-kategori" class="offcanvas-pane width-6">
      <div class="offcanvas-head">
        <!-- <header>Left off-canvas</header> -->
        <div class="offcanvas-tools">
          <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
            <i class="fa fa-times text-danger"></i>
          </a>
        </div>
      </div>

      <div class="offcanvas-body">
        <ul class="list divider-full-bleed">
          <li class="tile">
            <a class="tile-content ink-reaction" onclick="setFilterName(this)" href="#panel-all" role="tab" data-toggle="tab" data-dismiss="offcanvas">
              <div class="tile-text">
                All
              </div>
            </a>
          </li>
          <?php foreach ($kategori as $index => $tab) : ?>
            <li class="tile">
              <a class="tile-content ink-reaction" onclick="setFilterName(this)" href="#panel-<?= $index; ?>" role="tab" data-toggle="tab" data-dismiss="offcanvas">
                <div class="tile-text">
                  <?= $tab['kategori_nama']; ?>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div id="offcanvas-cart" class="offcanvas-pane width-6">
      <div class="offcanvas-head">
        <!-- <header>Left off-canvas</header> -->
        <div class="offcanvas-tools">
          <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
            <i class="fa fa-times text-danger"></i>
          </a>
        </div>
      </div>

      <div class="offcanvas-body">
        <ul class="list divider-full-bleed">
          <li class="tile">
            <a class="tile-content ink-reaction" onclick="setFilterName(this)" href="#panel-all" role="tab" data-toggle="tab" data-dismiss="offcanvas">
              <div class="tile-text">
                All
              </div>
            </a>
          </li>
          <?php foreach ($kategori as $index => $tab) : ?>
            <li class="tile">
              <a class="tile-content ink-reaction" onclick="setFilterName(this)" href="#panel-<?= $index; ?>" role="tab" data-toggle="tab" data-dismiss="offcanvas">
                <div class="tile-text">
                  <?= $tab['kategori_nama']; ?>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- END OFFCANVAS LEFT -->

  <script type="text/javascript">
    var data = JSON.parse('<?= json_encode($data) ?>');
    var ingredient = JSON.parse('<?= json_encode($ingredient) ?>');
    var inventory = JSON.parse('<?= json_encode($inventory) ?>');
    let viewCartBtn = document.querySelector('#viewCart');
    let addToCartBtn = document.querySelectorAll('.add_cart');
    let modalMenuBtn = document.querySelectorAll('.modal_add_cart')
      .forEach(btn => {
        btn.addEventListener('click', (event) => {
          openModal(this);
        })
      });

    let addQtyBtn = document.querySelectorAll('.addQtyItems')
      .forEach(btn => {
        btn.addEventListener('click', (event) => {
          addQtyItemsToAddToCartBtn(this);
        })
      });

    let minusQtyBtn = document.querySelectorAll('.minusQtyItems')
      .forEach(btn => {
        btn.addEventListener('click', (event) => {
          minusQtyItemsToAddToCartBtn(this);
        })
      });

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
      if (sessionStorage.getItem("shoppingCart")) {
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


    addToCartBtn.forEach(btn => {
      btn.addEventListener('click', (event) => {
        let id = event.target.dataset.itemid;
        let name = event.target.dataset.itemname;
        let qty = document.querySelector(`#qty-${id}`).value;
        let price = Number(event.target.dataset.itemharga) * qty;
        let notes = document.querySelector(`#notes_pesanan${id}`).value;

        var recipe = {
          ...ingredient
          .filter(ing => ing.ing_menu_id == id)
          .reduce((nm, currnm) => {
            nm[currnm.ing_inv_id] = (currnm.ing_qty * currnm.satuan_val);
            return nm
          }, {})
        }

        if (isEmptyObj(recipe)) {
          let msg = 'Belum Buat Resep Menu';
          messageAndResetButton(msg, id);
          return true;
        }

        if (isStockZero(recipe)) {
          let nullRecipe = isStockZero(recipe);
          let msg = 'Stock Bahan ';
          nullRecipe.forEach(r => msg += `<strong> ${r.stock_nama} Kosong, </strong>`);

          messageAndResetButton(msg, id);
          return true;
        }
        shoppingCart.addItemToCart(id, name, price, qty, notes, recipe)
        calculateItemTotalPriceButtonViewCart()
      })
    });

    let isEmptyObj = Obj => {
      return ((Object.keys(Obj).length == 0) ? true : false)
    }

    let isStockZero = Obj => {
      let nullInventory =
        inventory.filter(inv => (Object.keys(Obj)
          .includes(inv.stock_id)) && parseInt(inv.stock_qty) === 0)

      return ((nullInventory.length > 0) ? nullInventory : false)
    }

    let messageAndResetButton = (Obj, id) => {
      let el = document.querySelector('#msgPos');
      let qtyBtn = document.querySelector(`#qty-${id}`);
      let addToCartBtnById = document.querySelector(`#add_cart_${id}`);
      let msg = `
        <div class="alert alert-warning animate">
          <button type="button" class="close" data-dismiss="alert">&times;</button> ${Obj} 
        </div>`;
      el.innerHTML = msg;
      qtyBtn.value = 0;
      addToCartBtnById.innerHTML = 'add to cart';

      setTimeout(() => {
        el.innerHTML = '';
      }, 3000);
    }

    //button add minus qty
    let addQtyItemsToAddToCartBtn = e => {
      event.preventDefault();
      if (!event.detail || event.detail == 1) {
        let id = e.event.target.closest('a').dataset.itemid;
        let harga = e.event.target.closest('a').dataset.itemharga;
        let qty = Number(document.querySelector(`#qty-${id}`).value);

        if (qty == 0) {
          addToCartBtn.forEach(btn => btn.style.backgroundColor = '#0aa89e');
        };
        qty += 1;
        calculateItemTotalPriceButtonAddCart(id, harga, qty)
      };
    }

    let minusQtyItemsToAddToCartBtn = e => {
      event.preventDefault();
      if (!event.detail || event.detail == 1) {
        let id = e.event.target.closest('a').dataset.itemid;
        let harga = e.event.target.closest('a').dataset.itemharga;
        let qty = Number(document.querySelector(`#qty-${id}`).value);
        if (qty > 0) {
          qty -= 1;
          calculateItemTotalPriceButtonAddCart(id, harga, qty);
        };
      };
    }

    let calculateItemTotalPriceButtonAddCart = (id, harga, qty) => {
      let qtyBtn = document.querySelector(`#qty-${id}`);
      let addToCartBtnById = document.querySelector(`#add_cart_${id}`);
      qtyBtn.value = qty;
      addToCartBtnById.innerHTML = 'add to cart';

      if (qty > 0) {
        harga *= qty;
        addToCartBtnById.innerHTML += ` - ${Intl.NumberFormat().format(harga)}`;
      } else {
        for (var item in cart) {
          if (parseInt(cart[item].id) === parseInt(id)) {
            addToCartBtnById.innerHTML = 'Delete Item';
            addToCartBtnById.style.backgroundColor = 'red';
          }
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

      viewCartBtn.querySelector('#qtyViewCart').innerHTML = `${qtyViewCartButton} ITEMS`;
      viewCartBtn.querySelector('#grandTotalViewCart').innerHTML = `Rp ${Number(subTotalViewCartButton).toLocaleString('id-ID')}`;
    }

    let openModal = e => {
      addToCartBtn.forEach(btn => {
        btn.style.backgroundColor = '#0aa89e';
        btn.innerHTML = 'add to cart';
      });
      let id = e.event.target.parentNode.dataset.itemid;
      let qtyBtn = document.querySelector(`#qty-${id}`);
      let addCartBtn = document.querySelector(`#add_cart_${id}`);

      cart.forEach(c => {
        if (parseInt(c.id) === parseInt(id)) {
          qtyBtn.value = c.count;
          addCartBtn.innerHTML = `add to cart - ${(c.price).toLocaleString('id-ID')}`;
        }
      })
    }

    function setFilterName(e) {
      let tag = e.querySelector('.tile-text').innerHTML.trim();
      document.querySelector('.filter').innerHTML = `${tag} &nbsp;<i class="fa fa-filter "></i>`;
    }

    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(() => {
        document.querySelector('#loading-screen').style.display = 'none';
        document.querySelector('#base').style.display = 'block';
      }, 2000)

      let qtyViewCartButton = 0;
      let subTotalViewCartButton = 0;
      if (isEmptyObj(cart)) {
        return
      };

      for (var item in cart) {
        qtyViewCartButton += Number(cart[item].count);
        subTotalViewCartButton += cart[item].price;
      }
      viewCartBtn.querySelector('#qtyViewCart').innerHTML = `${qtyViewCartButton} ITEMS`
      viewCartBtn.querySelector('#grandTotalViewCart').innerHTML = `Rp ${Number(subTotalViewCartButton).toLocaleString('id-ID')}`
    });
  </script>

  <script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/source/App.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/source/AppNavigation.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/source/AppOffcanvas.min.js'); ?>"></script>
</body>

</html>