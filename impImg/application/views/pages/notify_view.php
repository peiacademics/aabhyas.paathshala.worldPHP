 

 <?php if (@$print) { ?>

   <script src="<?php echo base_url("js/jquery-2.1.1.js"); ?>"></script>

    <script src="<?php echo base_url("js/bootstrap.min.js"); ?>"></script>

    <link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet">

 <?php } ?>



 <div class="page-content">

            <div class="wrap">

        <div class="ibox">

          <div class="ibox-title">

              <h5><?php echo ucfirst($this->lang_library->translate('Expiry Notification Details')); ?></h5> 

                <div class="ibox-tools">

                  <a class="collapse-link">

                      <i class="fa fa-chevron-up"></i>

                  </a>

                  <?php if (@$print!==true) { ?>

                  <a id="pColor" href="<?php echo current_url().'/print';?>" target="_blank">

                      <i class="fa fa-print"></i> 

                  </a>

                   <?php } ?>

              </div>

          </div>

          <div class="ibox-content table-responsive">

            <div id="data_table" class="">

            <table id="example" class="table table-striped table-bordered" cellspacing="0" >

              <thead>

                <tr>

                  <th>#</th>

                  <th>Customer Name</th>

                  <th>Bill No</th>

                  <th>Product</th>

                  <th>Expiry Date</th>

                  <th>Action</th>

                </tr>

                <?php 

                if (@$amcDetails){

                  $x=1;

                  foreach ($amcDetails as $key => $value) { //print_r($value);?>

                  <tr>

                    <td><?php echo $x; ?></td>

                    <td><?php echo $this->str_function_library->call('fr>C>name:ID=`'.$value['bill_ID'][0]['customer_ID'].'`');?></td>

                    <td><?php echo $value['bill_ID'][0]['bill_number']; ?></td>

                    <td><?php echo $this->str_function_library->call('fr>P>name:ID=`'.$value['product_ID'].'`');?></td>

                    <td><?php echo $this->date_library->db2date($value['warranty_end_date'],$this->date_library->get_date_format());?></td>

                    <td><a href="<?php echo base_url('Customer/view/'.$value['bill_ID'][0]['customer_ID'].'#tab-4');?>"><i class="fa fa-eye"></i></a></td>

                  </tr>

                  <?php $x++;

                  }

                }else{ ?>

                <tr>

                  <td colspan='5'>No Next Visit</td>

                </tr>

                <?php }?>

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

<script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>

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

<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">

$(document).ready(function() {

  var print="<?php echo $print; ?>";

  if (print) 

    {

      printVisits();

    }

});

function printVisits()

{

   window.print();

    return false;

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

            toastr.error('Something went wrong!');
            setTimeout(function(){
              oTable.ajax.reload();
            }, 3000);

          }

        }

      });

    }

  });

}

 

</script>