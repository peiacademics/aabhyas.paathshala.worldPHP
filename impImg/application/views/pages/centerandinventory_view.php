<div class="page-content">
  <div class="row">
    <div class="pull-right">
     <a href="<?php echo base_url('Centerandinventory/add/'.$branch_ID); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Centre Inventory</button></a>
    </div>
    <div class="ibox">
      <!-- <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Centre & Inventory')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div> -->
      <div class="ibox-content table-responsive">
        <div>
          <!-- <a href="<?php echo base_url('Centerandinventory/add/'.$branch_ID); ?>" class="btn btn-w-m btn-primary">Add Centre Inventory</a> -->
          <input type="hidden" id="branch_ID" value="<?php echo $branch_ID; ?>">
        </div>
        <!-- <hr> -->
        <div id="data_table" class="">
        <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Quantity</th>
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

<div class="modal inmodal in" id="Centerandinventory_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Inventory Details</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 text-center">
            <h3 class="text-danger text-center" id="name_modal"></h3>
            <label class="col-sm-10 text-left" id="desc_modal"></label>
            <label class="col-sm-2 control_label" id="qty_modal"></label>
          </div>
          <div class="col-sm-12 table-responsive" id="item_modal">
          </div>
        </div>
      </div><!-- /.modal-content -->
      <div class="modal-footer">
        <div class="row text-center">
          <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true"> Close</button>
        </div>
      </div>
    </div><!-- /.modal-dialog -->
  </div>
</div>

<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script> -->
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
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

<script type="text/javascript">
  $(document).ready(function() {
    var branch_ID = $('#branch_ID').val();
    oTable = $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?php echo base_url('Centerandinventory/get_show_data'); ?>"+'/'+branch_ID,
      dom: 'lBfrtip',
      "buttons": [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
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
                oTable.ajax.reload();
              }, 3000);
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

  function get_details(id)
  {
    var base_url = '<?php echo base_url(); ?>';
    $.ajax({
      url:base_url+'Centerandinventory/get_details/'+id,
      method:'POST',
      datatype:'JSON',
      success:function(response){
        response = JSON.parse(response);
        $('#name_modal').html(response.name);
        $('#desc_modal').html('Detail : '+response.description);
        $('#qty_modal').html('Total : '+response.quantity);
        var data = '<table class="table table-bordered table-striped" border="1" width="100%"><tr>';
        var i = 1;
        $.each(response.serial_nos, function(key,value){
          data += '<td class="text-left"><strong class="h5 text-success">'+i+'. </strong> '+value.serial_no+'</td>';
          if((i%4) == 0)
          {
            data += '</tr><tr>';
          }
          i++;
        });
        data += '</tr></table>';
        $('#item_modal').html(data);
        $('#Centerandinventory_view').modal('show');
      }
    });
  }
</script>