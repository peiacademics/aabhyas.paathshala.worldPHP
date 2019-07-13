<div class="page-content">
    <div class="row">
        <div class="ibox">
          <!-- <div class="ibox-title">
              <h5><?php echo ucfirst($this->lang_library->translate('Monthly Pending Fees')); ?></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div> -->
          <div class="ibox-content table-responsive">
            <div class="col-sm-6 input-group">
              <!-- <div class=""> -->
                <input type="hidden" id="branch_ID" name="branch_ID" value="<?php echo $branch_ID; ?>">
                <input type="text" class="input-lg form-control" id="datepicker" name="date">
              <!-- </div> -->
              <!-- <span class=""> -->
                  <a href="#" class="input-group-addon navy-bg btn btn-block btn-w-m btn-primary" onClick="get_data()">Go !</a>
              <!-- </span> -->
            </div>
            <hr>
            <div id="data_table" class="">
            <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Total Fees</th>
                  <th>Pending Fees</th>
                  <th>Monthly Fees</th>
                  <th>Monthly Paid Fees</th>
                  <th>Monthly Fees Status</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <th><h3><b>Total</b> : </h3></th>
                  <th id="tot_amt"></th>
                  <th id="tot_pend"></th>
                  <th id="month_tot"></th>
                  <th id="month_pend"></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>
 --><script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<!-- Datatable -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>">
</script>
<script src="<?php echo base_url("js/plugins/dataTables/sum().js"); ?>"></script>
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

$("#datepicker").daterangepicker( {
    /*format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"*/
});

$(document).ready(function() {
  var branch_ID = $('#branch_ID').val();
  oTable = $('#example').DataTable( {
        "ajax": "<?php echo base_url('monthly_fee/get_monthly_fees'); ?>/"+branch_ID,
        dom: 'lBfrtip',
        "buttons": [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
         "columns": [
            { "data": "name" },
            { "data": "total_fees" },
            { "data": "pending_fees" },
            { "data": "monthly_fees" },
            { "data": "paid_fees" },
            { "data": "status" }
        ],
        drawCallback: function() {
           var api = this.api();
           // var total = api.column(5).data().sum();
           // var total1 = api.column(4).data().sum();
           /*var tot_amt = api.column(1, {page:'current'}).data().sum();
           var tot_pend = api.column(2, {page:'current'}).data().sum();
           var month_tot = api.column(3, {page:'current'}).data().sum();
           var month_pend = api.column(4, {page:'current'}).data().sum();*/
           var tot_amt = api.column(1).data().sum();
           var tot_pend = api.column(2).data().sum();
           var month_tot = api.column(3).data().sum();
           var month_pend = api.column(4).data().sum();
           $('#tot_amt').html("<h3 class=''><i class='text-success'>"+tot_amt+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           $('#tot_pend').html("<h3 class=''> <i class='text-danger'><b>"+tot_pend +"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           $('#month_tot').html("<h3 class=''> <i class='text-danger'><b>"+month_tot+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           $('#month_pend').html("<h3 class=''><i class='text-success'>"+month_pend+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
        }
      } );
      $('.dt-buttons').css({'float':'right'});
});

function get_data()
{
  $('#example').DataTable().clear().destroy();
  var date = $('#datepicker').val();
  var branch_ID = $('#branch_ID').val();
  oTable = $('#example').DataTable( {
        "ajax": "<?php echo base_url('monthly_fee/get_monthly_fees'); ?>/"+branch_ID+'/'+date,
        "dom": 'lBftipB',
        "buttons": [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
         "columns": [
            { "data": "name" },
            { "data": "total_fees" },
            { "data": "pending_fees" },
            { "data": "monthly_fees" },
            { "data": "paid_fees" },
            { "data": "status" }
        ],
        drawCallback: function() {
           var api = this.api();
           // var total = api.column(5).data().sum();
           // var total1 = api.column(4).data().sum();
           /*var tot_amt = api.column(1, {page:'current'}).data().sum();
           var tot_pend = api.column(2, {page:'current'}).data().sum();
           var month_tot = api.column(3, {page:'current'}).data().sum();
           var month_pend = api.column(4, {page:'current'}).data().sum();*/
           var tot_amt = api.column(1).data().sum();
           var tot_pend = api.column(2).data().sum();
           var month_tot = api.column(3).data().sum();
           var month_pend = api.column(4).data().sum();
           $('#tot_amt').html("<h3 class=''><i class='text-success'>"+tot_amt+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           $('#tot_pend').html("<h3 class=''> <i class='text-danger'><b>"+tot_pend +"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           $('#month_tot').html("<h3 class=''> <i class='text-danger'><b>"+month_tot+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
           $('#month_pend').html("<h3 class=''><i class='text-success'>"+month_pend+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i></h3>");
        }
      } );
      $('.dt-buttons').css({'float':'right'});
}
</script>