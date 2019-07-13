<div class="row">
    <div class="text-left col-sm-10 col-xs-10">
      <?php if($branch_ID == NULL) { ?>
        <a href="<?php echo base_url('Monthly_fee'); ?>"><button class=" btn btn-outline btn-success dim" type="button"><i class="fa fa-rupee"></i> Monthly Fees</button></a>
      <?php } else { ?>
        <a href="<?php echo base_url('Monthly_fee/index/'.$branch_ID); ?>"><button class=" btn btn-outline btn-success dim" type="button"><i class="fa fa-rupee"></i> Monthly Fees</button></a>
      <?php } ?>
    </div>
    <div class="text-right col-sm-2 col-xs-2">
      <?php if($branch_ID == NULL) { ?>
        <a href="<?php echo base_url('Transaction/add'); ?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>
      <?php } else { ?>
        <a href="<?php echo base_url('Transaction/add/'.$branch_ID); ?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>
      <?php } ?>
    </div>
</div>
<div class="row">
            <!-- <div class="wrap"> -->
        <div class="">
          <!-- <div class="ibox-title">
              <h5><?php echo ucfirst($this->lang_library->translate('Transaction')); ?></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div> -->
          <div class="ibox-content">

          <div class="row">
            <ul class="nav nav-pills nav-justified">
              <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"><i class="fa fa-newspaper-o"></i> Transaction</a></li>
              <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false"><i class="fa fa-briefcase"></i> Contra Transaction</a></li>
            </ul>

            <div class="tab-content">

              <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <div class="row">
                        <table id="example" class="display nowrap" width="100%">
                          
                        </table>
                        <table class="table">
                          <tfoot>
                            <tr>
                              <td colspan="4" class="text-right"></td>
                              <th>Credit</th>
                              <th>Debit</th>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td colspan="4" class="text-right"><b>Page Total</b></td>
                              <td id="totlAmt"></td>
                              <td id="totlAmt1"></td>
                              <td class="text-right"><b>Page Profit</b></td>
                              <td id="pageProfit"></td>
                            </tr>
                            <tr>
                              <td colspan="4" class="text-right"><b>Total</b></td>
                              <td id="Amt"></td>
                              <td id="Amt1"></td>
                              <td class="text-right"><b>Total Profit</b></td>
                              <td id="Profit"></td>
                            </tr>
                          </tfoot>
                        </table>
                    </div>
                  </div>
                </div>

                <div id="tab-2" class="tab-pane active">
                  <div class="panel-body">
                    <div class="row">
                        <table id="example2" class="display nowrap" width="100%">
                          
                        </table>
                        <table class="table">
                          <tfoot>
                            <tr>
                              <td colspan="4" class="text-right"></td>
                              <th>Credit</th>
                              <th>Debit</th>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr >
                              <td colspan="4" class="text-right"><b>Page Total</b></td>
                              <td id="totlAmt2"></td>
                              <td id="totlAmt12"></td>
                              <td class="text-right"><b>Page Profit</b></td>
                              <td id="pageProfit2"></td>
                            </tr>
                             <tr>
                              <td colspan="4" class="text-right"><b>Total</b></td>
                              <td id="Amt2"></td>
                              <td id="Amt12"></td>
                              <td class="text-right"><b>Total Profit</b></td>
                              <td id="Profit2"></td>
                            </tr>
                          </tfoot>
                        </table>
                    </div>
                  </div>
                </div>

             </div> 

          </div>         


        </div>
      </div>
<!-- </div> -->
</div>

<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.min.js"); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script> -->
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
 -->
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<!-- Datatable -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/sum().js"); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.flash.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/jszip.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/pdfmake.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/vfs_fonts.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.html5.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.print.min.js'); ?>"></script>


<script type="text/javascript">
$(document).ready(function() {
$('#A255ef9db8487b82a24f6031d1fd4e4fc').addClass('active');
            $("#A255ef9db8487b82a24f6031d1fd4e4fc").parent().parent().addClass("active");
            $("#A255ef9db8487b82a24f6031d1fd4e4fc").parent().addClass("in");
  var dataset=<?php echo $transactionData; ?>;
  var dataset2=<?php echo $contratransactionData; ?>;
    oTable = $('#example').DataTable( {
        "data":dataset,
        responsive: true,
        columns: [
            { title: "Date" },
            { title: "Expence Category" },
            { title: "Reference" },
            { title: "Payment Mode" },
            { title: "Credit" },
            { title: "Debit" },
            { title: "Remark" },
            { title: "Actions" }
        ],
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        drawCallback: function() {
           var api = this.api();
           var total = api.column(5).data().sum();
           var pageTotal = api.column(5, {page:'current'}).data().sum();
           var total1 = api.column(4).data().sum();
           var pageTotal1 = api.column(4, {page:'current'}).data().sum();
           var pageProfit = pageTotal1 - pageTotal;
           var Profit = total1 - total;
           $('#totlAmt').html("<i class='text-success'>"+pageTotal1+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#Amt').html(" <i class='text-danger'><b>"+total1 +"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#pageProfit').html(" <i class='text-danger'><b>"+pageProfit+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#totlAmt1').html("<i class='text-success'>"+pageTotal+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#Amt1').html(" <i class='text-danger'><b>"+ total+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#Profit').html(" <i class='text-danger'><b>"+Profit+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
        }
    } );

    oTable2 = $('#example2').DataTable( {
        "data":dataset2,
        responsive: true,
        columns: [
            { title: "Date" },
            { title: "Expence Category" },
            { title: "Reference" },
            { title: "Payment Mode" },
            { title: "Credit" },
            { title: "Debit" },
            { title: "Remark" },
            { title: "Actions" }
        ],
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        drawCallback: function() {
           var api = this.api();
           var total = api.column(5).data().sum();
           var pageTotal = api.column(5, {page:'current'}).data().sum();
           var total1 = api.column(4).data().sum();
           var pageTotal1 = api.column(4, {page:'current'}).data().sum();
           var pageProfit = pageTotal1 - pageTotal;
           var Profit = total1 - total;
           $('#totlAmt2').html("<i class='text-success'>"+pageTotal1+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#Amt2').html(" <i class='text-danger'><b>"+total1 +"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#pageProfit2').html(" <i class='text-danger'><b>"+pageProfit+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#totlAmt12').html("<i class='text-success'>"+pageTotal+"</i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#Amt12').html(" <i class='text-danger'><b>"+ total+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
           $('#Profit2').html(" <i class='text-danger'><b>"+Profit+"</b></i> &nbsp;&nbsp;<i class='fa fa-inr'></i>");
        }
    } );

    $('.dt-buttons').css({'float':'right'});
    $('#tab-2').removeClass('active');
});

function view(id)
{ 
    $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'transaction/view/'+id,
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
            toastr.success('Successfully deleted.');
            setTimeout(function(){
              window.location.href = "<?php echo base_url('transaction'); ?>";
            }, 3000);
          }
          else
          {
            toastr.error('Somthing went wrong !');
            setTimeout(function(){
              window.location.href = "<?php echo base_url('transaction'); ?>";
            }, 3000);
          }
        }
      });
    }
  });
}
</script>