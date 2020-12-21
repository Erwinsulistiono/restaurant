<div id="menubar" class="menubar-inverse ">
  <div class="menubar-fixed-panel">
    <div>
      <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    <div class="expanded">
      <a href="<?= base_url() . 'login' ?>">
        <span class="text-lg text-bold text-primary">F1&nbsp;RESTAURANT</span>
      </a>
    </div>
  </div>
  <div class="menubar-scroll-panel">
    <ul id="main-menu" class="gui-controls">
      <?php if ($data['pos'] == 'Y') : ?>
        <li class="gui-folder">
          <a href="<?= base_url() . 'pos/saldo' ?>">
            <div class="gui-icon"><i class="fa fa-desktop"></i></div>
            <span class="title">POS</span>
          </a>
        </li>
      <?php endif; ?>

      <?php if ($data['inventory'] == 'Y') : ?>
        <li class="gui-folder">
          <a href="<?= base_url() . 'pos/inventory' ?>">
            <div class="gui-icon"><i class="fa fa-cubes"></i></div>
            <span class="title">Inventory</span>
          </a>
        </li>
      <?php endif; ?>

      <?php if ($data['transaction'] == 'Y') : ?>
        <li class="gui-folder">
          <a href="<?= base_url() . 'pos/transaksi' ?>">
            <div class="gui-icon"><i class="fa fa-book"></i></div>
            <span class="title">Transaction</span>
          </a>
        </li>
      <?php endif; ?>

      <?php if ($data['kitchen'] == 'Y') : ?>
        <li class="gui-folder">
          <a href="<?= base_url() . 'pos/kitchen' ?>">
            <div class="gui-icon"><i class="fa fa-cutlery"></i></div>
            <span class="title">Kitchen</span>
          </a>
        </li>
      <?php endif; ?>

      <?php if ($data['waitress'] == 'Y') : ?>
        <li class="gui-folder">
          <a href="<?= base_url() . 'pos/waitress' ?>">
            <div class="gui-icon"><i class="fa fa-user"></i></div>
            <span class="title">Waitress</span>
          </a>
        </li>
      <?php endif; ?>

      <?php if ($data['laporan'] == 'Y') : ?>
        <li class="gui-folder">
          <a>
            <div class="gui-icon"><i class="fa fa-file"></i></div>
            <span class="title">Laporan</span>
          </a>
          <ul>
            <li><a href="<?= base_url('pos/laporan'); ?>"><span class="title">Laporan</span></a></li>
            <li><a href="<?= base_url('pos/laporan_pendapatan'); ?>"><span class="title">Laporan Pendapatan</span></a></li>
          </ul>
        </li>
      <?php endif; ?>

      <?php if ($data['settings'] == 'Y') : ?>
        <li class="gui-folder">
          <a>
            <div class="gui-icon"><i class="fa fa-cog"></i></div>
            <span class="title">Settings</span>
          </a>
          <ul>
            <li><a href="<?= base_url(); ?>pos/settings/close_kasir"><span class="title">Closing Kasir</span></a></li>
          </ul>
        </li>
      <?php endif; ?>

      <?php if ($data['user'] == 'Y') : ?>
        <li class="gui-folder">
          <a href="<?= base_url() . 'pos/pengguna' ?>">
            <div class="gui-icon"><i class="fa fa-user"></i></div>
            <span class="title">User</span>
          </a>
        </li>
      <?php endif; ?>


      <li class="gui-folder">
        <a href="<?= base_url() . 'pos/about' ?>">
          <div class="gui-icon"><i class="fa fa-info-circle"></i></div>
          <span class="title">Info</span>
        </a>
      </li>
    </ul>

  </div>
</div>