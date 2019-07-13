 <div class="page-content">

            <div class="row">
              <div class="pull-right">
                <a href="<?php echo base_url('Batch/add'); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Batch</button></a>
              </div>
        <div class="ibox">

          <!-- <div class="ibox-title">

              <h5><?php echo ucfirst($this->lang_library->translate('Batch')); ?></h5>

              <div class="ibox-tools">

                  <a class="collapse-link">

                      <i class="fa fa-chevron-up"></i>

                  </a>

              </div>

          </div> -->

          <div class="ibox-content table-responsive">

            <!-- <div>

              <a href="<?php //echo base_url('Batch/add'); ?>" class="btn btn-w-m btn-primary">Add Batch</a>

            </div> -->

            <!-- <hr> -->

            <div id="data_table" class="">

            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">

              <thead>

                <tr>
                  <th>Batch Name</th>
                  <th>Description</th>
                  <?php $user_type = $this->session_library->get_session_data('Login_as');
                    if($user_type === 'DSSK10000001') { ?>
                    <th>Branch</th>
                  <?php } ?>
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



<!-- Data Tables -->

<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>

<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>
 -->
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

    /*var oTable = $('#example').dataTable( {

        "bProcessing": true,

        "sAjaxSource": "<?php echo base_url('clients/get_show_data'); ?>",

        "aoColumns": [

            { "mData": "Client_name" },

            { "mData": "Company_name" },

            { "mData": "Email" },

            { "mData": "Address" },

            { "mData": "Contact_no" },

            { "mData": "Links"}

        ],

        "dom": 'lTfigt',

        "tableTools": {

                    "sSwfPath": "<?php echo base_url('js/plugins/dataTables/swf/copy_csv_xls_pdf.swf'); ?>"

                }



    } );*/

    oTable = $('#example').DataTable( {

        "processing": true,

        "serverSide": true,

        

        /*"aoColumns": [

            { "mData": "bank_name" },

            { "mData": "branch_name" },

            { "mData": "ifsc_code" },

            { "mData": "account_no" },

            { "mData": "account_opening_date" },

            { "mData": "Links" },

        ],*/

        "ajax": "<?php echo base_url('Batch/get_show_data'); ?>",

        /*"dom": 'lTfigt',

        "tableTools": {

            "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"

        }*/

         dom: 'lBfrtip',

        "buttons": [

              'copy', 'csv', 'excel', 'pdf', 'print'

          ]

    } );

    $('.dt-buttons').css({'float':'right'});



});



function view(id)

{ 

    $.ajax({

    type:'POST',

    url: '<?php echo base_url(); ?>'+'Batch/view/'+id,

    success:function(response)

    {

      $.each(response, function(key,value){

        $("#"+key).text(value);

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

            toastr.success('Successfully '+type+'.');
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