<header id="header">
  <div class="headerbar">
    <div class="headerbar-left">
      <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    <div class="headerbar-right">
      <ul class="header-nav header-nav-profile">
        <li class="dropdown">
          <?php $photo = $this->session->userdata('pengguna_photo');  ?>
          <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
            <img src="<?= base_url("assets/images/$photo"); ?>" alt="" />
            <span class="profile-info">
              <?= $this->session->userdata('user_nama'); ?>
            </span>
          </a>
          <ul class="dropdown-menu animation-dock">
            <li><a href="<?= base_url('login/logout'); ?>"><i class="fa fa-fw fa-power-off text-danger"></i>
                Logout</a></li>
            <li><a href="<?= base_url('admin/profile'); ?>"><i class="fa fa-pencil"></i> My Profile</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</header>

<body class="menubar-hoverable header-fixed menubar-first">