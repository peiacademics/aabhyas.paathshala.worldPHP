<div class="page-content">
            <div class="wrap">
        <div class="ibox">
          <div class="ibox-title">
              <h5><?php echo ucfirst($this->lang_library->translate('Cash Book')); ?></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div>
          <div class="ibox-content table-responsive">
            <div id="data_table">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" >
              <tfoot>
                <tr>
                  <th colspan='3' class="text-right"><h3>Balance : </h3></th>
                  <th colspan='3'><h3><?php echo $balance; ?></h3></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
</div>
</div>

<!-- script -->

<!-- Data Tables -->
    <script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
    <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>
    <script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
    <script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>

<script type="text/javascript">
$(document).ready(function() {
 $('#A8fdf397b482d6e6a1c3b954ae523aafe').addClass('active');
            $("#A8fdf397b482d6e6a1c3b954ae523aafe").parent().parent().addClass("active");
            $("#A8fdf397b482d6e6a1c3b954ae523aafe").parent().addClass("in");
  var dataset=<?php echo $cashBookData; ?>;
    oTable = $('#example').DataTable( {
        // "processing": true,
        // "serverSide": true,
        "data":dataset,
        columns: [
            { title: "Remark" },
            { title: "Date" },
            { title: "Reference" },
            { title: "Credit" },
            { title: "Debit" },
            { title: "Action" }
        ]
        // "ajax": "<?php echo base_url('account/get_show_data/cash'); ?>",
        //  "dom": 'lBftipB',
        // "buttons": [
        //       'copy', 'csv', 'excel', 'pdf', 'print'
        //   ]
    } );
    $('.dt-buttons').css({'float':'right'});
});

function deletef(id,href)
{
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if(result == true)
    {
      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
      $("#Login_screen").fadeIn('fast');
      $.ajax({
        url:href,
        method:'POST',
        datatype:'JSON',
        error: function(jqXHR, exception) {
                $("#Login_screen").fadeOut(2000);
                //Remove Loader
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            },
        success:function(response){
          $("#Login_screen").fadeOut(2000);
          response = JSON.parse(response);
          if(response === true)
          {
            toastr.success('Successfully deleted.');
            setTimeout(function(){
              window.location.href = "<?php echo base_url('account/cash/'); ?>";
            }, 3000);
          }
          else
          {
            toastr.error("Something went wrong!");
            setTimeout(function(){
              window.location.href = "<?php echo base_url('account/cash/'); ?>";
            }, 3000);
          }
        }
      });
    }
  });
}
</script>