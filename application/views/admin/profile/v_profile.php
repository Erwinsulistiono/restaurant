<div id="base">
  <div class="offcanvas">
  </div>
  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="fa fa-user"></span> Profil</h2>
        <?= $this->session->flashdata('msg'); ?>
      </div>

      <br>
      <div class="section-body">
        <div class="card">
          <div class="card-tiles">
            <div class="hbox-md col-md-12">
              <div class="hbox-column col-md-4  style-default-light">
                <div class="row">

                  <div class="col-xs-12">
                    <div class="text-center">
                      <img class="img-circle size-3" src="<?= base_url("assets/images/${users['pengguna_photo']}"); ?>" alt="user" />
                      <div>
                        <br>
                        <h1 class="text-light no-margin"><?= $this->session->userdata("user_nama") ?></h1>
                        <h5>
                          Administrator
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="hbox-column col-md-9">
                <div class="row">
                  <div class="card-body">
                    <br />
                    <form class="form" action="<?= base_url("admin/profile/update"); ?>" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <input type="hidden" name="pengguna_id" value="<?= $this->session->userdata('idadmin'); ?>">
                        <input class="form-control" name="username" id="pengguna_username" value="<?= $this->session->userdata('pengguna_username') ?>">
                        <label for="pengguna_username">Username</label>
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" id="pengguna_email" value="<?= $this->session->userdata('pengguna_email') ?>">
                        <label for="pengguna_email">E-Mail</label>
                      </div>
                      <div class="form-group">
                        <input class="form-control" name="kontak" id="pengguna_nohp" value="<?= $this->session->userdata('pengguna_nohp') ?>">
                        <label for="pengguna_nohp">Contact Person</label>
                      </div>
                      <div class="row">
                        <div class="form-group">
                          <label for="labelfile">Foto</label>
                          <input type="file" name="filefoto" class="form-control" id="labelfile">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <input type="password" class="form-control" name="password" id="pengguna_password">
                            <label for="pengguna_password">Password</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" id="pengguna_password_conf">
                            <label for="pengguna_password_conf">Confirm Password</label>
                          </div>
                        </div>
                      </div>
                      <div class="card-actionbar">
                        <div class="card-actionbar-row">
                          <button type="submit" class="btn btn-primary btn-raised">Update account</button>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>