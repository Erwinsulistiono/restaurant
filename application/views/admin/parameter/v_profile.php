<div id="base">

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
              <div class="hbox-column col-md-12  style-default-light">
                <div class="row">

                  <div class="col-xs-12">
                    <div class="row text-center">
                      <img class="img-circle size-3" src="<?= base_url('assets/images/user_blank.png'); ?>" alt="user" />
                      <div>
                        <br>
                        <h1 class="text-light no-margin"><?= $data['pt_nama']; ?></h1>
                      </div>
                    </div>
                    <div class="row">
                      <div class="card-body">
                        <br />
                        <form class="form" action="<?= base_url('admin/parameter/simpan_profile_company'); ?>" method="post">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                <input class="form-control" name="pt_id" id="pt_id" value="<?= $data['pt_id'] ?>" type="hidden">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_nama" id="pt_nama" value="<?= $data['pt_nama'] ?>">
                                <label for="pt_nama">Nama PT</label>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_npwp" id="pt_npwp" value="<?= $data['pt_npwp'] ?>">
                                <label for="pt_npwp">NPWP</label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_alamat" id="pt_alamat" value="<?= $data['pt_alamat'] ?>">
                                <label for="pt_alamat">Alamat</label>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_negara" id="pt_negara" value="<?= $data['pt_negara'] ?>">
                                <label for="pt_negara">Negara</label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_nama_pic" id="pt_nama_pic" value="<?= $data['pt_nama_pic'] ?>">
                                <label for="pt_nama_pic">Nama PIC</label>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_telp_pic" id="pt_telp_pic" value="<?= $data['pt_telp_pic'] ?>">
                                <label for="pt_telp_pic">Telp PIC</label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_email" id="pt_email" value="<?= $data['pt_email'] ?>">
                                <label for="pt_email">E-Mail</label>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <input class="form-control" name="pt_website" id="pt_website" value="<?= $data['pt_website'] ?>">
                                <label for="pt_website">Website</label>
                              </div>
                            </div>
                          </div>
                          <div class="card-actionbar">
                            <div class="card-actionbar-row">
                              <button type="submit" class="btn btn-flat btn-raised btn-primary">Update
                                Company</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>