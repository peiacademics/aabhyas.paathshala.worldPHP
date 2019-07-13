<div class="pull-right">
  <a href="<?php echo base_url('package/add'); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Package</button></a>
</div>
<div class="row">
  <div class="ibox">
<!--     <div class="ibox-title">
        <h5><?php //echo ucfirst($this->lang_library->translate('Aabhyas Package')); ?></h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
       </div>
    </div> -->
    <div class="ibox-content">
      <div class="page-content">
        <!-- <a href="<?php echo base_url('package/add'); ?>"><button type="button" class="btn btn-primary btn-block btn-lg dim"> <i class="fa fa-plus"></i> ADD PACKAGE </button></a> -->
        <div id="data_table" class="row">
          <table id="example" class="display responsive nowrap" cellspacing="0" >
            <thead>
              <tr>
                <th>Package</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script> -->
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script> -->
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<!-- Datatable -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.flash.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/jszip.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/pdfmake.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/vfs_fonts.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.html5.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.print.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>">
</script>
<script src="<?php echo base_url("js/plugins/pdfjs/pdf.js"); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    oTable = $('#example').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "<?php echo base_url('package/get_show_data'); ?>",
       dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    });
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
              toastr.success('Successfully Deleted.');
              setTimeout(function(){
                oTable.ajax.reload();
              }, 100);
            }
            else
            {
              toastr.error("Something went wrong!");
            }
          }
        });
      }
    });
  }
</script>
