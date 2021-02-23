<div id="base">

  <div id="content">
    <section>
      <div class="section-header">
        <h2><span class="	fa fa-map-marker"></span> Data Log</h2>
      </div>
      <?= $this->session->flashdata('msg'); ?>
      <!-- BEGIN TABLE HOVER -->
      <section class="card style-default-bright" style="margin-top:0px;">
        <div class="section-body">
          <div class="row">
            <table class="table table-hover" id="datatable1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tipe Transaksi</th>
                  <th>Modul Menu</th>
                  <th>Reffid</th>
                  <th>Oldval</th>
                  <th>Newval</th>
                  <th>User</th>
                  <th>Tgl Update</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 0;
                foreach ($data as $table_content) :
                  $no++;
                ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $table_content['log_type']; ?></td>
                    <td><?= $table_content['log_menu']; ?></td>
                    <td><?= $table_content['log_reffid']; ?></td>
                    <td><?= $table_content['log_oldval']; ?></td>
                    <td><?= $table_content['log_newval']; ?></td>
                    <td><?= $table_content['log_nama']; ?></td>
                    <td><?= $table_content['log_tgl']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <!--end .section-body -->
      </section>
    </section>
    <!-- END TABLE HOVER -->
  </div>
  <!--end #content-->
  <!-- END CONTENT -->
</div>
<!--end #base-->
<!-- END BASE -->