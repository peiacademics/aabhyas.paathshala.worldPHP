 <div class="page-content">

     <div class="row">
        <!-- <div class="pull-right">
          <a href="<?php echo base_url('designation/add'); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Designation</button></a>
        </div> -->
        <div class="ibox">

          <!-- <div class="ibox-title">

              <h5><?php echo ucfirst($this->lang_library->translate('Designation')); ?></h5>

              <div class="ibox-tools">

                  <a class="collapse-link">

                      <i class="fa fa-chevron-up"></i>

                  </a>

              </div>

          </div> -->

          <div class="ibox-content table-responsive">  

<!--             <div>

          <a href="<?php echo base_url('designation/add'); ?>" class="btn btn-w-m btn-primary">Add Designation</a>      

          </div>

          <hr>
 -->
        <div id="data_table" class="">

          <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
            <thead>

              <tr>

                <th>Title</th>

                <th>Description</th>

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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

        <h4 class="modal-title">Particulars</h4>

      </div>

      <div class="modal-body">

        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">

                                <thead>

                                <tr>

                                    <th data-toggle="true">#</th>

                                    <th data-toggle="true">Pertucular</th>

                                    <th data-hide="phone">Amount</th>

                                    <th data-hide="all">Status</th>

                                </tr>

                                </thead>

                                <tbody id="perti">

                                </tbody>

                            </table>

          

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div>

</div>



<!-- Data Tables -->

<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>

<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script> -->

<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script> -->

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

  oTable = $('#example').DataTable( {

          "processing": true,

          "serverSide": true,

          "ajax": "<?php echo base_url('designation/get_show_data'); ?>",

          dom: 'lBfrtip',

        "buttons": [

              'copy', 'csv', 'excel', 'pdf', 'print'

          ]

    } );

    $('.dt-buttons').css({'float':'right'});

  });



function view(id,href)

{ 

    $.ajax({

    type:'POST',

    dataType:'json',

    url: '<?php echo base_url(); ?>'+'designation/view/'+id,

    success:function(response)

    {
      $('#perti').html('');
      var x=1;

      $.each(response, function(key,value){

      $('#perti').append('<tr><td>'+x+'</td><td>'+value.perticular+'</td><td>'+value.amount+'</td><td><span class="label label-warning">'+value.payStatus+'</span></td></tr>');

      x++;

      });

      $("#myModal").modal('show');    

    }

  })   

}



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

</script>