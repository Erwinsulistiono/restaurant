<div id="menubar" class="menubar-inverse">
  <div class="menubar-fixed-panel">
    <div>
      <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    <div class="expanded">
      <a href="<?= base_url() . 'admin/dashboard' ?>">
        <span class="text-lg text-bold text-primary ">F1&nbsp;RESTAURANT</span>
      </a>
    </div>
  </div>
  <div class="menubar-scroll-panel">

    <ul id="main-menu" class="gui-controls">

      <?php if ($data['parameter'] == 'Y') : ?>
      <li class="gui-folder">
        <a>
          <div class="gui-icon"><i class="fa fa-tachometer"></i></div>
          <span class="title">Parameter</span>
        </a>
        <ul>
          <li><a href="<?= base_url('admin/parameter/profile_company'); ?>"><span class="title">Profile
                Company</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/parameter/wewenang_admin'); ?>"><span class="title">Wewenang Admin</span></a>
          </li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/parameter/wewenang_pos'); ?>"><span class="title">Wewenang POS</span></a>
          </li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/parameter/outlet'); ?>"><span class="title">Outlet</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/parameter/pelanggan'); ?>"><span class="title">Pelanggan</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/parameter/tax'); ?>"><span class="title">Tax</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/konversi'); ?>"><span class="title">Konversi Satuan</span></a></li>
        </ul>
      </li>
      <?php endif; ?>

      <?php if ($data['katalog'] == 'Y') : ?>
      <li class="gui-folder">
        <a>
          <div class="gui-icon"><i class="fa fa-book"></i></div>
          <span class="title">Katalog</span>
        </a>
        <ul>
          <li><a href="<?= base_url('admin/menu'); ?>"><span class="title">Menu</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/katalog/kategori_menu'); ?>"><span class="title">Kategori Menu</span></a>
          </li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/inventory'); ?>"><span class="title">Inventory</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/katalog/gallery'); ?>"><span class="title">Gallery</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/katalog/voucher'); ?>"><span class="title">Voucher</span></a></li>
        </ul>
      </li>
      <?php endif; ?>

      <?php if ($data['pos'] == 'Y') : ?>
      <li class="gui-folder">
        <a>
          <div class="gui-icon"><i class="fa fa-cutlery"></i></div>
          <span class="title">Point of Sale</span>
        </a>
        <ul>
          <li class="gui-folder">
            <a href="javascript:void(0);">
              <span class="title">POS Settings</span>
            </a>
            <ul>
              <li><a href="<?= base_url('admin/pos/payment'); ?>"><span class="title">Pembayaran POS</span></a></li>
            </ul>
        </ul>
        <ul>
          <li class="gui-folder">
            <a href="javascript:void(0);">
              <span class="title">Restaurant Mode</span>
            </a>
            <ul>
              <li><a href="<?= base_url('admin/restaurant/area'); ?>"><span class="title">Settings Area</span></a></li>
              <li><a href="<?= base_url('admin/restaurant/pilih_meja'); ?>"><span class="title">Settings Meja</span></a></li>
            </ul>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/pos/pilih_saldo'); ?>"><span class="title">Saldo Kas Harian</span></a>
          </li>
        </ul>
      </li>
      <?php endif; ?>

      <?php if ($data['laporan'] == 'Y') : ?>
      <li class="gui-folder">
        <a href="<?= base_url('admin/laporan/'); ?>">
          <div class="gui-icon"><i class="fa fa-tachometer"></i></div>
          <span class="title">Laporan</span>
        </a>
      </li>
      <?php endif; ?>

      <?php if ($data['sistem'] == 'Y') : ?>
      <li class="gui-folder">
        <a>
          <div class="gui-icon"><i class="fa fa-cogs"></i></div>
          <span class="title">Sistem</span>
        </a>
        <ul>
          <li><a href="<?= base_url('admin/log'); ?>"><span class="title">Log</span></a></li>
        </ul>
        <ul>
          <li><a href="<?= base_url('admin/about') ?>"><span class="title">About</span></a></li>
        </ul>
      </li>
      <?php endif; ?>

      <?php if ($data['user'] == 'Y') : ?>
      <li class="gui-folder">
        <a>
          <div class="gui-icon"><i class="fa fa-user"></i></div>
          <span class="title">User</span>
        </a>
        <ul>
          <li><a href="<?= base_url() . 'admin/pengguna' ?>"><span class="title">User List</span></a></li>
        </ul>
      </li>
      <?php endif; ?>

    </ul>
  </div>
</div>