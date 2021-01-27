<section class="section-account">
  <div class="spacer"></div>
  <div class="card contain-xs style-transparent">
    <div class="card-body">
      <div class="row">
        <div class="col-xs-12">
          <br />
          <span class="text-lg text-bold text-primary">LOGIN TO START YOUR SESSION</span>
          <br /><br />
          <?= $this->session->flashdata('msg'); ?>
          <form class='form floating-label' action='<?= base_url('login/auth') ?>' accept-charset='utf-8' method='post'>
            <div class="form-group">
              <input type="text" class="form-control" id="username" name="username" required>
              <label for="username">Username</label>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="form-password" name="password" required>
              <label for="password">Password</label>
            </div>
            <div style="color: #abacae">
              <input type="checkbox" class="form-checkbox"><label>&nbsp;Show Password</label>
            </div>
            <br />
            <div class="row">
              <div class="col-xs-6 text-left">
              </div>
              <div class="col-xs-6 text-right">
                <button class="btn btn-primary btn-raised" type="submit"><span class="fa fa-lock"></span> Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $(".form-checkbox").click(function() {
      if($(this).is(':checked')){
        $("#form-password").attr("type","text");
      }else{
        $("#form-password").attr("type","password");
      }
    });
  });
</script>