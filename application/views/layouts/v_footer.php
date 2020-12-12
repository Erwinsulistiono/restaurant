<!-- BEGIN JAVASCRIPT -->
<script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<!-- <script src="= base_url('assets/js/jquery/jquery-1.11.2.min.js'); ?>"></script> -->
<!-- <script src="= base_url('assets/js/jquery/jquery-migrate-1.2.1.min.js'); ?>"></script> -->
<script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/spin/spin.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/autosize/jquery.autosize.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/moment/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/nanoscroller/jquery.nanoscroller.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/d3/d3.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/d3/d3.v3.js'); ?>"></script>
<script src="<?= base_url('assets/js/rickshaw/rickshaw.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/App.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/AppNavigation.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/AppOffcanvas.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/AppCard.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/AppForm.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/AppNavSearch.js'); ?>"></script>
<script src="<?= base_url('assets/js/source/AppVendor.js') ?>"></script>
<script src="<?= base_url('assets/js/DataTables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/DataTables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/core/DemoTableDynamic.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery-ui.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.bundle.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-select.js'); ?>"></script>
<!-- END JAVASCRIPT -->

<script type="text/javascript">
  $('.datepicker').datepicker({
    format: "yyyy/mm/dd",
    autoclose: true,
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    if (window.opener) {
      $('#menubar').remove();
      $('#header').remove();
      $('#base').addClass('no-padding');
      $('#content').addClass('no-padding');
      $('.popup-btn').attr("onClick", "close_window();return false;");
    }
  })
</script>

<script type="text/javascript">
  (function($, undefined) {
    "use strict";

    $(function() {
      var $form = $(".form");
      $("input[data-type='currency']").on("keyup", function(event) {

        var selection = window.getSelection().toString();
        if (selection !== '') {
          return;
        }
        if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
          return;
        }
        var $this = $(this);
        var input = $this.val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt(input, 10) : 0;

        $this.val(function() {
          return (input === 0) ? "" : input.toLocaleString("id-ID");
        });
      });

      $form.on("submit", function(event) {

        var $this = $(this);
        var arr = $this.serializeArray();

        for (var i = 0; i < arr.length; i++) {
          arr[i].value = arr[i].value.replace(/[($)\s\._\-]+/g, '');
        };
      });

    });
  })(jQuery);
</script>

</body>

</html>