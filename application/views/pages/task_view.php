<link href="<?php echo base_url("css/plugins/iCheck/custom.css"); ?>" rel="stylesheet">
<!-- <div id="actall" data-spy="scroll" data-target=".scrollspy" style="position: fixed;
    bottom: 45px;
    right: 20px;
    z-index: 100;">
    <button class="btn btn-lg btn-danger btn-circle" id="actBtn" type="button" onclick="simpleModal()" data-toggle="tooltip" title="Add Task"><i class="fa fa-calendar-plus-o"></i></button>
  </div> -->
<div class="row">
  <div class="row text-right">
    <a href="<?php echo base_url('task/add/'.$branch_ID)?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>
    <input type="hidden" id="branch_ID" value="<?php echo $branch_ID; ?>">
  </div>
  <div class="row">
    <div class="col-sm-12 ">
      <div class="ibox-content">
        <div class="tabs-container">
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a data-toggle="tab" href="#tab-1">Department Wise</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">Employee Wise</a></li>
                <li class=""><a data-toggle="tab" href="#tab-3">Date Range Wise</a></li>
                <li class=""><a data-toggle="tab" href="#tab-4">Waiting For Your Approval</a></li>
            </ul>

          <div class="tab-content">
            
            <div id="tab-1" class="tab-pane active">
              <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Select Department : </label>
                    <div class="col-sm-8">
                      <select class="form-control chosen-select" id="type_ID" placeholder="Task Department" name="type_ID" onChange="type_wise()" value="<?php @$View['type_ID']; ?>" required>
                      </select>
                    </div>
                  </div>
                  <br><br>

                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      <h3 class="text-center">Major Tasks</h3>
                      <div class="panel-group black-cl" id="type_wise"></div>
                    </div>
                    <div class="col-sm-6">
                      <h3 class="text-center">Calender Tasks</h3>
                      <div class="panel-group black-cl" id="calender_tasks"></div>
                    </div>
                  </div>
              </div>
            </div>

            <div id="tab-2" class="tab-pane">
              <div class="panel-body">
                <div class="ibox">
                  <div class="ibox-content">
                    <div class="form-group">
                    <label class="col-sm-4 control-label">Select Employee : </label>
                      <div class="col-sm-8">
                        <select class="form-control chosen-select" id="employee_ID" placeholder="Employee" name="employee_ID" onChange="changeDateTask()" required>
                        </select>
                      </div>
                    </div>
                    <div class="panel-group black-cl" id="accordion"></div>
                  </div>
                </div>
              </div>
            </div>

            <div id="tab-3" class="tab-pane">
              <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Select Date : </label>
                    <div class="col-sm-8">
                      <input class="daterange form-control" id="date" placeholder="Date" name="date" onChange="date_wise()" value="<?php @$View['date']; ?>" required>
                    </div>
                  </div>
                  <div class="panel-group black-cl" id="date_wise"></div>
              </div>
            </div>

            <div id="tab-4" class="tab-pane">
                  <!-- <div id="ionrange_1" class="slider"></div> -->
              <div class="panel-body">
                <div class="panel-group black-cl">
                  <div class="table-responsive">
                      <table class="table shoping-cart-table">
                        <tbody id="waiting_approval">
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
      </div>
    </div>
    <!-- <div class="col-sm-6">
      <div class="ibox-content">
        <h3 class="font-bold no-margins">
                 <i class="fa fa-envira"></i> Timeline 
                </h3>
          <label>Date</label>
          <div class="black-cl">
            <input class="form-control input-md daterange black-cl" id="DateRange1" name="date" placeholder="Todays" onchange="getTimeline()">
            <br>
            <div  id="Timeline" class="font-bold black-cl">
              
            </div>
          </div>
      </div>
      <div id="getTitle"></div>
    </div> -->
    </div>
  </div>
</div>


<div class="modal inmodal fade" id="taskShowModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg m-lgg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="closeTaskModal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-danger" id="dateClass">Tasks</h4>
                <b><small  class="text-danger"></small></b>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="tabs-container">
                    <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#tab-4"><i class="fa fa-eye"></i> Show</a></li>
                    </ul>
                    <div class="tab-content">
                      <div id="tab-4" class="tab-pane active">
                        <div class="panel-body">
                          <div class="ibox-content">
                            <div>
                              <div class="feed-activity-list" id="tasksAssigned">
                                <h1 class="text-center text-danger">No Tasks scheduled on this date.</h1>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>


<?php if ($this->session->flashdata('alert'))
{
  @$x=true;
}
else
{
  $x=false;
}
?>


<!-- Knob -->
<script src="<?php echo base_url('js/plugins/jsKnob/jquery.knob.js'); ?>"></script>


<!-- description modal -->
<div class="modal inmodal" id="description" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-check modal-icon"></i>
              <h4 class="modal-title">Task Completion</h4>
          </div>
          <div class="modal-body">
          <form id="contacted" method="post" action="<?php echo base_url('dashboard/contacted');?>">
            <input type="hidden" id="ltID" name="ID"></input>
            <div class="form-group">
              <label for="completed_time" class="col-sm-12">Completed On : </label>
              <div class="col-sm-6">
                <input type="text" class="datepicker form-control" id="end_time" name="end_time" placeholder="completed Date" required>
              </div>
              <div class="input-group col-sm-6">
                <input type="text" id="eTime" name="eTime" class="form-control input-small timepicker" placeholder="completed Time" required>
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              </div>
              <span id="completed_at"></span>
            </div>
            <!-- <div class="form-group"><label>Description</label> <textarea name="description" placeholder="Add description" id="desc" class="form-control" required></textarea></div> -->
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
      </div>
  </div>
</div>

<div class="modal inmodal" id="scheduled_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg m-lgg">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-graduation-cap modal-icon"></i>
              <h4 class="modal-title">Take Attendance</h4>
          </div>
          <div class="modal-body">
          <form id="nos_doubts" method="post" action="<?php echo base_url('student/add_doubts');?>">
            <div class="form-group">
              <label for="completed_time" class="col-sm-6">Number of Doubts : </label>
              <div class="col-sm-6">
                <input type="number" class="form-control" id="doubt_nos" name="doubts" placeholder="Enter Number" min="1" required>
                <input type="hidden" id="student_ID" name="student_ID">
                <input type="hidden" id="solved_doubts" name="solved_doubts" value="0">
                <input type="hidden" id="where_from" name="where_from" value="buy">
                <input type="hidden" id="buy" name="buy">
                <input type="hidden" id="Added_by_og" name="Added_by_og" value="<?php echo $this->session_library->get_session_data('ID'); ?>">
              </div>
              <span id="completed_at"></span>
            </div>
            
            <div class="form-group">
              <label for="amount" class="col-sm-6">Enter Amount : </label>
              <div class="col-sm-6">
                <input type="number" class="form-control" id="price" name="price" placeholder="Amount" min="0" required>
              </div>
              <span id="amount"></span>
            </div>
            <br>
            <div class="form-group">
              <label for="completed_time" class="col-sm-6">Description : </label>
              <div class="col-sm-6">
                <textarea class="form-control" id="desc" name="description" placeholder="Description"></textarea>
              </div>
              <span id="Description"></span>
            </div>
          </div>
          <br><br>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
          </div>
          </form>
      </div>
  </div>
</div>

<style type="text/css">
  .datepicker {
    z-index: 1000000 !important;
  }
</style>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script> 
<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!--<link href="<?php echo base_url('css/bootstrap-datetimepicker.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/bootstrap-datetimepicker.js"); ?>"></script>-->
<link href="<?php echo base_url("css/plugins/Timepicker/bootstrap-datetimepicker.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/plugins/Timepicker/bootstrap-datetimepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('js/plugins/iCheck/icheck.min.js'); ?>"></script>
<script type="text/javascript">

getChosenData('employee_ID','US',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['employee_ID']; ?>');
getChosenData('type_ID','TT',[{'label':'title','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['type_ID']; ?>');
$("#type_ID option:disabled").attr('hidden',true);
$('#type_ID').append('<option value="all">All</option>');
$('#employee_ID').append('<option value="all">All</option>');
var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($this->date_library->get_date_format())?>";
$('.i-checks').iCheck({
  checkboxClass: 'icheckbox_square-green',
  radioClass: 'iradio_square-green'
});
$('.datepicker').datepicker({
  format: js_date_format,
  keyboardNavigation: false,
  forceParse: false,
  autoclose: true,
  container: '#description modal-body'

});
$('.daterange').daterangepicker({
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    // window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  });

$('.timepicker').datetimepicker({
  format: 'LT'
});

var x="<?php echo $x;?>";

var toalVisits="<?php echo empty($amc) ? 0 : count($amc);?>";
var fromdate="<?php echo @$from_date;?>";
var todate="<?php echo @$to_date;?>";
var base_url="<?php echo base_url(); ?>";
var alert_interval="<?php echo @$alert_interval; ?>";
var dd=base_url+"dashboard/notify/"+fromdate+"/"+todate;

// contacts Alert
 <?php if ($Login['Login_as']==='Admin') { ?>
  var toalContacts="<?php echo empty($remainsToContacts) ? 0 : $remainsToContacts['totalCount'];?>";
  var name="<?php echo empty($remainsToContacts) ? 0 : $remainsToContacts['Added_by'];?>";
  <?php }else{ ?>
  var toalContacts="<?php echo empty($remainsToContacts) ? 0 : count($remainsToContacts);?>";
  <?php } ?>



if (x) {
  if (toalVisits<1)
  {
    alr();
  }
  else
  {
    alerrr();
  }

 <?php if ($Login['Login_as']==='Admin') { ?>
  alrCntctAdmin();
  <?php }else{ ?>
  alrCntct();
  <?php } ?>
}

/*function alerrr()
{
  swal({
      title: "Welcome to Paathshala",
          //text: "You have total "+toalVisits+" visits pending in next "+alert_interval+" days click OK to see",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "OK",
          closeOnConfirm: false
        }, function () {
        window.location.href=dd;
    });
}

function alr() 
{
  swal({
      title: "Welcome to Paathshala",
          //text: "You have total "+toalVisits+" visits pending in next "+alert_interval+" days "
        });
}*/

function alrCntct()
{
   toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 0,
        extendedTimeOut: 0
    };
    toastr.warning('You still have to contact '+toalContacts+' persons', 'Paathshala');
}

function alrCntctAdmin() {
  toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 0,
        extendedTimeOut: 0
    };
    toastr.warning(name+' still have to contact '+toalContacts+' Persons', 'Paathshala');
}

function get_product_details()
{
  $('#model').html('<span class="col-sm-12 h3 font-bold text-center"><i class="fa fa-spinner fa-spin"></i></span>');
  $('#model2').html('');
  var customer_name = $('#customer').val();
  $.ajax({
    type:'POST',
    data :{'Name':customer_name},
    url: '<?php echo base_url(); ?>'+'dashboard/show_invoice_data/'+customer_name,
    success:function(response)
    {
      $('#model').html('');
      if(response == 1)
      {
        $('#myModal').modal('show');
      }
      else
      {
        var response = JSON.parse(response);
        var c=0;
        if(typeof response == 'object')
        {
          var data = '<span class="col-sm-4 h5 font-bold text-right">Invoice Number : </span><div class="col-sm-8"><select id="invoice" data-placeholder="Select A Client..." class="form-control chosen-select" name="invoice_ID" onChange = "get_product_details2()"><option value="">Please Select</option>';
          $.each(response,function(key,val){
            c++;
            data += '<option value="'+val.ID+'"> '+val.bill_number+'</option>';
          });
          data += '</select></div>';
          $('#model').append(data);
          $('.chosen-select').chosen();
        
          $('#invoice_chosen a span').text('Select Invoice...');
          $('.chosen-drop').addClass('black-cl');            
        }
        else
        {
          var data = '<div class="ibox"><div class="ibox-content"><span class="h3 block black-cl text-center"><i class="fa fa-frown-o"></i> No Invoice</span></div></div>';
          $('#model').append(data);
        }
      }
    }

  })
}

function get_product_details2()
{
  $('#model2').html('<span class="col-sm-12 h3 font-bold text-center"><i class="fa fa-spinner fa-spin"></i></span>');
  var invoice_total = $('#invoice').val();
  $.ajax({
    type:'POST',
    data :{'Name':invoice_total},
    url: '<?php echo base_url(); ?>'+'dashboard/show_invoice_data2/'+invoice_total,
    success:function(response)
    {
      response = JSON.parse(response);
      $('#model2').html('');
      // console.log(response);
      if(typeof response === 'object')
      {
        if(response.collection === null){
          response.collection = 0;
        }
        var balance = parseInt(response.grandtotal) - parseInt(response.collection);
        var percent = parseInt((parseInt(response.collection)/parseInt(response.grandtotal)) * 100);
        if(balance > 0)
        {
          status = "UNPAID";
          stat_class = "danger";
        }
        else
        {
          status = "PAID";
          stat_class = "success";
        }
        var data = '<p><div class=""><h2 class="font-bold text-'+stat_class+'">'+status+'</h2><small><div class="stat-percent black-cl">'+percent+'% </small></div><div class="progress progress-small"><div style="width: '+percent+'%;" class="progress-bar progress-bar-'+stat_class+'"></div></div><ul class="todo-list m-t ui-sortable black-cl"> <li> <span class="m-l-xs">Total Amount : </span> <span class="m-l-xs"><i class="fa fa-inr"></i> '+parseInt(response.grandtotal)+'</span> </li>';
          data += '<li> <span class="m-l-xs">Paid Amount :</span> <span class="m-l-xs"><i class="fa fa-inr"></i> '+parseInt(response.collection)+'</span> </li><li> <span class="m-l-xs">Balance : </span> <span class="m-l-xs"><i class="fa fa-inr"></i> '+balance+'</span> </li>';
        data += '</ul></div><p>';
        $('#model2').append(data);
      }
      else{
        $('#model2').append('<p><div class="alert alert-danger">Something went wrong..<i class="fa fa-frown-o"></i></div><p>');
      }
    }

  })
}

function get_product_details3()
{
  $('#model3').html('<span class="col-sm-12 h3 font-bold text-center"><i class="fa fa-spinner fa-spin"></i></span>');
  var invoice_total = $('#invoice').val();
  var product_name = $('#product').val();
  $.ajax({
    type:'POST',
    data :{'Name':product_name},
    url: '<?php echo base_url(); ?>'+'dashboard/show_product/'+product_name,
    success:function(response)
    {
      $('#model3').html('');
      response = JSON.parse(response);
      if(response.pm == 0)
      {
        var data = '<p><ul class="todo-list ui-sortable black-cl"> <li> <span class="m-l-xs">No Stock</span> </li></ul></p>';
      }
      else
      {
        var data = '<p><ul class="todo-list ui-sortable black-cl"> <li> <span class="m-l-xs"> Volume : '+response.pm+'</span> </li></ul></p>';
      }
        $('#model3').append(data);
    }
  })
}


$(document).ready(function() {
  $('.chosen-select').chosen();
  $('#customer_chosen a span').text('Select Customer...');
  $('.chosen-drop').addClass('black-cl');
  $('#datetimepicker3').datetimepicker({
    format: 'DD/MM/YYYY, HH:mm:ss',
  });
  get();
  $('#closeTaskModal').on( "click", function() {
    $('#activityModal').modal('show');
  });
});


function get() {
    $("#timeLineAlert").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
    $.ajax({
    type:'POST',
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'dashboard/get',
    success:function(response)
    {
        // console.log(response);
         $("#timeLineAlert").html('');
        $.each(response, function(key,value){
          if (key==='timeLineAlert') {
          }
          else
          {
            $("#"+key).text(value);
          }
        });

        var data='';
        var x='';
        $.each(response.timeLineAlert, function(key,value){
          data +='<div class="ibox"><div class="ibox-content "><div>';
          x='active';
          if (value.length===0) {
             data += '<h5><code>'+key+'</code></h5>';
            data += '<table class="table "><tr><td colspan="4" class="text-danger"><h4><i class="fa fa-bell-slash"></i> NO Alert Set </h4></td></tr>';
          }
          else
          {
             data += '<div class="text-warning"><h4><span class="fa fa-bell"></span> '+key+'</h4></div>';
            data +='<table class="table "><thead><tr><th>Status</th><th>Time</th><th>Customer</th><th>Action</th></tr></thead>';
            $.each(value, function(k,v){
              var dateParts = v.DateTime.split("-");
              var time=v.DateTime.split(" ");
              mainTime=time[1].split(":");
              var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2), mainTime[0],mainTime[1],mainTime[2]);
              amPM=formatAMPM(jsDate);
              data += '<tr><td id="res'+v.ID+'"><small>'+v.cnt_Result+'</small></td><td><i class="fa fa-clock-o"></i> '+amPM+'</td><td>'+v.lead_ID+'</td>'
              if (v.cnt_Result==='Pending.....') {
                data +='<td class="text-navy"> <a onclick="contacted(\''+v.ID+'\',\''+v.description+'\')"><i class="fa fa-volume-control-phone"></i> </a></td></tr>';
              }
              else
              {
                data +='<td id="act'+v.ID+'" class="text-warning"> <i class="fa fa-volume-control-phone"></i> Contacted</td></tr>';
              }
              
              x='info';
            });
          }
          // console.log(value);
          data +='</table></div></div></div>';
        });
        
      $("#timeLineAlert").append(data);
    }
  });
}
function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}

function contacted(id,desc) {
  $('#ltID').val(id);
  $('#desc').val(desc);
  $('#myModal').modal("show");
}

$('#contacted').validate();
$("#contacted").postAjaxData(function(result)
{
  id=$('#ltID').val();
  if (result===true) {
  //   $('#ltID').val('');
  //   $('#desc').val('');
  //   $('#myModal').modal("hide");
  //   $('#act'+id).html('<i class="fa fa-volume-control-phone"></i> Contacted');
  //   $('#res'+id).html('<small><span class="label label-primary">Completed</span></small>');
  //   toastr.options = {
  //               closeButton: true,
  //               progressBar: true,
  //               showMethod: 'slideDown',
  //               timeOut: 4000
  //           };
  //           toastr.warning("Alert Updated", 'Paathshala');
  // }
  // else
  // {
  //   toastr.options = {
  //               closeButton: true,
  //               progressBar: true,
  //               showMethod: 'slideDown',
  //               timeOut: 4000
  //           };
  //           toastr.error("Something went wrong", 'Paathshala');
  // }

             toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            type_wise();
            changeDateTask();
            date_wise();
            toastr.warning("Task Completed Successfully.", 'Paathshala');
            $("#description").modal('hide');
            var idss=$('#idss').text();
            // $('#'+idss).attr({'checked':"checked", 'disabled':"disabled"});
            // $('.'+idss).html('<i class="fa fa-check"></i> Completed').removeClass('label-warning').addClass('label-primary');
  }
  else
  {
    toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.error("Something went wrong", 'Paathshala');
  }
});

$('.daterange').daterangepicker({
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    // window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  });

function changeDate() {
  $("#timeLineAlert").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  var date=$('#DateRange').val();
  $.ajax({
    type:'POST',
    data:{'date':date},
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'dashboard/getAlertData',
    success:function(response)
    {
      $("#timeLineAlert").html('');
        var data='';
        var x='';
        $.each(response, function(key,value){
          data +='<div class="ibox"><div class="ibox-content "><div>';
          x='active';
          if (value.length===0) {
             data += '<code>'+key+'</code>';
            data += '<table class="table "><tr><td colspan="4" class="text-danger"><h4><i class="fa fa-bell-slash"></i> NO Alert Set </h4></td></tr>';
          }
          else
          {
             data += '<div class="text-warning"><h4><span class="fa fa-bell"></span> '+key+'</h4></div>';
            data +='<table class="table "><thead><tr><th>Status</th><th>Time</th><th>Customer</th><th>Action</th></tr></thead>';
            $.each(value, function(k,v){
              var dateParts = v.DateTime.split("-");
              var time=v.DateTime.split(" ");
              mainTime=time[1].split(":");
              var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2), mainTime[0],mainTime[1],mainTime[2]);
              amPM=formatAMPM(jsDate);
              data += '<tr><td id="res'+v.ID+'"><small>'+v.cnt_Result+'</small></td><td><i class="fa fa-clock-o"></i> '+amPM+'</td><td>'+v.lead_ID+'</td>'
              if (v.cnt_Result==='Pending.....') {
                data +='<td class="text-navy"> <a onclick="contacted(\''+v.ID+'\',\''+v.description+'\')"><i class="fa fa-volume-control-phone"></i> </a></td></tr>';
              }
              else
              {
                data +='<td id="act'+v.ID+'" class="text-warning"> <i class="fa fa-volume-control-phone"></i> Contacted</td></tr>';
              }
              
              x='info';
            });
          }
          // console.log(value);
          data +='</table></div></div></div>';
        });
        
      $("#timeLineAlert").append(data);
    }
  });
}
getTimeline();
function getTimeline() {
  $("#Timeline").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  var date = $('#DateRange1').val();
  $.ajax({
    type:'POST',
    data:{'date':date},
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'dashboard/getTimeline',
    success:function(response)
    {
      $("#Timeline").html('');
        var data='';
        var x='';
        // console.log(response);
        // console.log(typeof response);
        if (typeof response === 'object') {
          data = '';
          $.each(response, function(key,value){
            // console.log(value);
            var dateParts = value.mainDateTime.split("-");
              var time = value.mainDateTime.split(" ");
              mainTime = time[1].split(":");
              var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2), mainTime[0],mainTime[1],mainTime[2]);
              var amPm = formatAMPM(jsDate);
            data += '<div class="timeline-item" ><div class="row" id="wholeDiv'+value.ID+'"><div class="col-xs-3 date"><i id="icn'+value.ID+'" class="fa '+value.meet_type.icon+'"></i><span id="tm'+value.ID+'">'+amPm+'</span><br/><small class="text-danger" id="'+value.ID+'Interval">'+value.showDateTime+'</small></div><div class="col-xs-7 content no-top-border"><a class="text-navy" onclick="editActivity(\''+value.ID+'\',\''+value.mainDateTime+'\',\''+value.mainDateTime+'\',\''+value.description+'\')" style="float: right;" id="edit'+value.ID+'"></a> &nbsp;&nbsp;<span class="text-warning" style="float: right;" id="bell'+value.ID+'"></span>';
            if (value.delete_status === 'D') {
              data += '<strike><p class="m-b-xs"><strong id="titl'+value.ID+'">'+value.title;
              if (value.heading_status==='Sub') {
                data += ' to '+value.refCus;
              }
              data += '</strong></p><p id="decs'+value.ID+'">'+value.description+'</p></strike><span class="text-danger" style="float: right;"><i class="fa fa-trash"></i> Deleted</span></div></div></div>';
            }
            else
            {
              data += '<p class="m-b-xs"><strong id="titl'+value.ID+'">'+value.title;
              if (value.heading_status==='Sub') {
                data += ' to '+value.refCus;
              }
              data += '</strong></p><p id="decs'+value.ID+'">'+value.description+'</p></div></div></div>';
            }
          });
        }
        else
        {
          data +='<table class="table " style="background:#e7eaec"><tr><td colspan="4" class="text-danger"><h4><i class="fa fa-envira"></i> NO recent Activity </h4></td></tr>';
        }
      $("#Timeline").append(data);
    }
  });
}

var removeElements = function(text, selector) {
                var wrapped = $("<div>" + text+"deepak" + "</div>");
  // console.log(wrapped.find(selector).remove());
  // console.log(wrapped);

    wrapped.find(selector).remove();
    return wrapped.html();
}

function sendMail(type) {
  email=$('#introMail').val();
      if (email===undefined || email==='') {
        toastr.options = {
            "closeButton": true,
              positionClass:'toast-bottom-right',
              showMethod: 'slideDown',
              "progressBar": true,
              tapToDismiss : true,
              timeOut: 5000
          };
          toastr.error('Please Enter Email');
      }
      else
      {
        bootbox.confirm('Are you sure you want to Send '+type+' Mail', function(result) {
          if(result == true)
          {
            $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
            $("#Login_screen").fadeIn('fast');
            $.ajax({
              type:'POST',
              data:{'type':type,'email':email},
              dataType:'json',
              url: '<?php echo base_url(); ?>'+'dashboard/sendManualEmail',
              success:function(response)
              {
                $("#Login_screen").fadeOut(2000);
                if (typeof response==='object') {
                  $.each(response, function(key,value){
                    toastr.options = {
                        "closeButton": true,
                          positionClass:'toast-bottom-right',
                          showMethod: 'slideDown',
                          "progressBar": true,
                          tapToDismiss : true,
                          timeOut: 5000
                      };
                      toastr.error(value);
                  });
                }
                else if (response===true) {
                  toastr.options = {
                    "closeButton": true,
                      positionClass:'toast-bottom-right',
                      showMethod: 'slideDown',
                      "progressBar": true,
                      tapToDismiss : true,
                      timeOut: 5000
                  };
                  toastr.warning(type+' Mail Send Successfully');
                  // $('#timeline').prepend('<div class="timeline-item" ><div class="row" id="wholeDiv"><div class="col-xs-3 date"><i id="icn" class="fa fa-magnet"></i><span id="tm">'++'</span><br/><small class="text-navy" id="'+id+'Interval"></small></div><div class="col-xs-7 content no-top-border"><p class="m-b-xs"><strong id="titl">'+'<code><?php echo $this->data['Login']['Name']?></code> '+response.title+'</strong></p><p id="decs'+id+'">'+decr+'</p></div></div></div>');
                }
                else
                {
                  toastr.options = {
                      "closeButton": true,
                        positionClass:'toast-bottom-right',
                        showMethod: 'slideDown',
                        "progressBar": true,
                        tapToDismiss : true,
                        timeOut: 5000
                    };
                    toastr.error('Somthing Went Wrong');
                }
                // console.log(response);
              }
            });
            }
        });
  }
}

type_wise();
changeDateTask();
date_wise();
waiting_approval();
function waiting_approval()
{
  var branch_ID = $('#branch_ID').val();
  // $("#waiting_approval").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  $.ajax({
    type:'POST',
    dataType:'json',
    data:{'branch_ID':branch_ID},
    url: '<?php echo base_url(); ?>'+'dashboard/waiting_approval',
    success:function(resp)
    {
      var dt = '';
      $.each(resp,function(k,v){
        dt += '<tr><td width="90"><div class="cart-product-imitation">'+v.assignTo+'</div></td><td class="desc"><h3><a href="#" class="text-navy">'+v.title+'</a></h3><p class="small">'+v.description+'</p><div class="m-t-sm"><a href="">Start Time : '+v.start_time+'<br>Expected End Time : '+v.expected_end_time+'<br>End Time : '+v.end_time+'</a></div><td><input name="rating-'+v.ID+'" id="rating-'+v.ID+'" type="text" value="0" class="dial m-r" data-fgColor="#1AB394" data-max="10" data-width="85" data-height="85"/></td><td><a onclick="make_approval(\''+v.ID+'\')" class="btn btn-white"><i class="fa fa-folder"></i> Approve </a></td></tr>';       
      });
      $("#waiting_approval").html(dt);      
      $(".dial").knob();
      console.log(resp);
    }
  });
}

function changeDateTask() {
  var branch_ID = $('#branch_ID').val();
  var employee_ID = $('#employee_ID').val();
  $("#accordion").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  $.ajax({
    type:'POST',
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'dashboard/getTodaysTask'+'/'+branch_ID+'/'+employee_ID,
    success:function(response)
    {
      $("#accordion").html('');
      if (response === false) {
        data = '<br><br><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" checked disabled class="i-checks"/><span class="m-l-xs"><code>No task Today</code></span><small class="label label-danger"><i class="fa fa-times"></i> ......</small></h4></div></div>';
         $("#accordion").append(data);
          $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green'
              });
      }
      else
      {
        if (response.type === 'Admin') {
          $("#accordion").html('');
          var data='';
          var x=1;
          $.each(response.data, function(k,v){
            data += k
          $.each(v, function(key,value){
            if (value.tStatus==='Completed') {
              attr='checked="checked" disabled="disabled"';
              lClass='primary';
              lIcn='check';
            }
            else if (value.tStatus==='Copied') {
              attr='checked disabled';
              lClass='warning';
              lIcn='check';
            }
            else
            {
              attr='';
              lClass='warning';
              lIcn='spinner fa-pulse';
            }
            if(value.tStatus === 'Completed') {
              data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_acc'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_acc'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
            }
            else{
              data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_acc'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_acc'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code></div></div></div>';
            }
            x++;
          });
          });
          
        $("#accordion").append(data);
        $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green'
              });
          $('input').on('ifChecked', function(event){
            // console.log($(this).attr('value'));
            $('#idss').text($(this).attr('id'));
            $('#ltID').val($(this).val());
            $("#description").modal('show');
            // $("#search_emp").keyup(function(){
            //   console.log("Search");
            //   _this = this;
            //   $.each($("#accordion b"), function() {
            //     if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            //       $(this).hide();
            //     else
            //       $(this).show();
            //   });
            // });
            // $('.datepicker').datepicker({
            //   format: js_date_format,
            //   keyboardNavigation: false,
            //   forceParse: false,
            //   autoclose: true
            // });   
        });
        }
        else
        {
          $("#accordion").html('');
            var data='';
            var x=1;
            $.each(response.data, function(key,value){
              if (value.tStatus==='Completed') {
                attr='checked="checked" disabled="disabled"';
                lClass='primary';
                lIcn='check';
                // copiedWholeTask
              }
              else if (value.tStatus==='Copied') {
                attr='checked disabled';
                lClass='warning';
                lIcn='check';
              }
              else
              {
                attr='';
                lClass='warning';
                lIcn='spinner fa-pulse';
              }
              if(value.type == 'class')
              {
                data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks" disabled/><a data-toggle="collapse" href="#collapse_acc'+x+'"><span class="m-l-xs">Lecture </span><small class="label label-warning '+x+'"><i class="fa fa-'+lIcn+'"></i> Scheduled</small></a><small class="btn btn-sm btn-primary pull-right" onClick="take_attendance(\''+value+'\');"> click</small></h4></div><div id="collapse_acc'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><div class="well">'+value.description+'</div></div></div></div>';
                // data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks" disabled/><a data-toggle="collapse" href="#collapse'+x+'"><span class="m-l-xs">Lecture </span><small class="label label-warning '+x+'"><i class="fa fa-'+lIcn+'"></i> Scheduled</small></a><small class="btn btn-sm btn-primary pull-right" onClick="take_attendance('+value+');"> click</small></h4></div><div id="collapse'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="text-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
              }
              else{
                if (value.tStatus === 'Completed') {
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_acc'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_acc'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="text-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
                }
                else{
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_acc'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_acc'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code></div></div></div>';
                }
              }
              x++;
            });
            
          $("#accordion").append(data);
          $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });
            $('input').on('ifChecked', function(event){
              // console.log($(this).attr('value'));
              $('#idss').text($(this).attr('id'));
              $('#ltID').val($(this).val());
              $("#description").modal('show');
              // $("#search_emp").keyup(function(){
              //   _this = this;
              //   $.each($("#accordion b"), function() {
              //     if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
              //       $(this).hide();
              //     else
              //       $(this).show();
              //   });
              // });
          });
        }
      }
    }
  });
}

function type_wise() {
  var branch_ID = $('#branch_ID').val();
  var type_ID = $('#type_ID').val();
  $("#type_wise").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  $("#calender_tasks").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  $.ajax({
    type:'POST',
    dataType:'json',
    data:{'branch_ID':branch_ID,'type_ID':type_ID},
    url: '<?php echo base_url(); ?>'+'dashboard/type_wise',
    success:function(response)
    {
      console.log(response);
      $("#type_wise").html('');
      $("#calender_tasks").html('');
      if (response === false) {
        data = '<br><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" checked disabled class="i-checks"/><span class="m-l-xs"><code>No task Today</code></span><small class="label label-danger"><i class="fa fa-times"></i> ......</small></h4></div></div>';
        data_cal = '<br><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><span class="m-l-xs"><code>No Calender tasks</code></span><small class="label label-danger"><i class="fa fa-times"></i> ......</small></h4></div></div>';
         $("#type_wise").append(data);
         $("#calender_tasks").append(data_cal);
          $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
          });
      }
      else
      {
        if (response.type === 'Admin') {
          $("#type_wise").html('');
          var data='';
          var data_cal='';
          var x=1;
          var xxx = 0;
          var yyy = 0;
          var tbx = 0;
          var tby = 0;

          $.each(response.data, function(k,v){
            console.log(response.data);
            
            v.filter(function (person) {
              if (person.type == "calender") {
                xxx++;
                // alert(xxx);
              }
              else
              {
                yyy++;
                // alert(yyy);
              }
            });
            if(xxx > 0)
            {
              data_cal += k;
              xxx=0;
            }
            if(yyy > 0)
            {
              data += k;
              yyy = 0;
            }

            $.each(v, function(key,value){
              if(value.type=='calender')
              {
                ++tbx;
                // alert(tbx);
              }
              if(value.type=='task')
              {
                ++tby;
              }
              if (value.tStatus==='Completed') {
                attr='checked="checked" disabled="disabled"';
                lClass='primary';
                lIcn='check';
              }
              else if (value.tStatus==='Copied') {
                attr='checked disabled';
                lClass='warning';
                lIcn='check';
              }
              else
              {
                attr='';
                lClass='warning';
                lIcn='spinner fa-pulse';
              }

              if(value.type == "task") {
                if(value.tStatus === 'Completed') {
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
                }
                else{
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code></div></div></div>';
                }
              }
              else
              {
                if(value.tStatus === 'Completed') {
                  data_cal += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.Added_on+'</small><strong class="pull-right">'+moment(value.Added_on).fromNow()+'</strong><div class="well">'+value.description+'</div></div></div></div>';
                }
                else{
                  data_cal += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.Added_on+'</small><strong class="pull-right">'+moment(value.Added_on).fromNow()+'</strong><div class="well">'+value.description+'</div></div></div></div>';
                }
              }
              x++;
            });
          });
          
            // alert(tby);
            // alert(tbx);
            if(tby == 0)
            {
              data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" checked disabled class="i-checks"/><span class="m-l-xs"><code>No task Today</code></span><small class="label label-danger"><i class="fa fa-times"></i> ......</small></h4></div></div>';
              
            }
            if(tbx == 0)
            {
              data_cal += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" checked disabled class="i-checks"/><span class="m-l-xs"><code>No Calender Tasks</code></span><small class="label label-danger"><i class="fa fa-times"></i> ......</small></h4></div></div>';
            }

          
        $("#type_wise").append(data);
        $("#calender_tasks").append(data_cal);
        $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green'
              });
          $('input').on('ifChecked', function(event){
            // console.log($(this).attr('value'));
            $('#idss').text($(this).attr('id'));
            $('#ltID').val($(this).val());
            $("#description").modal('show');
            // $('.datepicker').datepicker({
            //   format: js_date_format,
            //   keyboardNavigation: false,
            //   forceParse: false,
            //   autoclose: true
            // });   
        });
        }
        else
        {
          $("#type_wise").html('');
          $("#calender_tasks").html('');
            var data='';
            var x=1;
            $.each(response.data, function(key,value){
              if (value.tStatus==='Completed') {
                attr='checked="checked" disabled="disabled"';
                lClass='primary';
                lIcn='check';
                // copiedWholeTask
              }
              else if (value.tStatus==='Copied') {
                attr='checked disabled';
                lClass='warning';
                lIcn='check';
              }
              else
              {
                attr='';
                lClass='warning';
                lIcn='spinner fa-pulse';
              }
              if(value.type == 'class')
              {
                data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks" disabled/><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">Lecture </span><small class="label label-warning '+x+'"><i class="fa fa-'+lIcn+'"></i> Scheduled</small></a><small class="btn btn-sm btn-primary pull-right" onClick="take_attendance(\''+value+'\');"> click</small></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><div class="well">'+value.description+'</div></div></div></div>';
              }
              else if(value.type == 'calender')
              {
                if (value.tStatus === 'Completed') {
                  data_cal += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.Added_by+'</small><strong class="text-right">'+moment(value.Added_by).fromNow()+'</strong><div class="well">'+value.description+'</div><code></div></div></div>';
                }
                else{
                  data_cal += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.Added_by+'</small><strong class="pull-right">'+moment(value.Added_by).fromNow()+'</strong><div class="well">'+value.description+'</div></div></div></div>';
                }
              }
              else{
                if (value.tStatus === 'Completed') {
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="text-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
                }
                else{
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_tw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_tw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code></div></div></div>';
                }
              }
              x++;
            });
            
          $("#type_wise").append(data);
          $("#calender_tasks").append(data_cal);
          $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });
            $('input').on('ifChecked', function(event){
              // console.log($(this).attr('value'));
              $('#idss').text($(this).attr('id'));
              $('#ltID').val($(this).val());
              $("#description").modal('show');
          });
        }
      }
    }
  });
}

function date_wise()
{
  var branch_ID = $('#branch_ID').val();
  var date = $('#date').val();
  $("#date_wise").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  $.ajax({
    type:'POST',
    dataType:'json',
    data:{'branch_ID':branch_ID,'date':date},
    url: '<?php echo base_url(); ?>'+'dashboard/date_wise',
    success:function(response)
    {
      $("#date_wise").html('');
      if (response === false) {
        data = '<br><br><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" checked disabled class="i-checks"/><span class="m-l-xs"><code>No task Today</code></span><small class="label label-danger"><i class="fa fa-times"></i> ......</small></h4></div></div>';
         $("#date_wise").append(data);
          $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
          });
      }
      else
      {
        if (response.type === 'Admin') {
          $("#date_wise").html('');
          var data='<br><br>';
          var x=1;
          $.each(response.data, function(k,v){
            // data += k
          $.each(v, function(key,value){
            if (value.tStatus==='Completed') {
              attr='checked="checked" disabled="disabled"';
              lClass='primary';
              lIcn='check';
            }
            else if (value.tStatus==='Copied') {
              attr='checked disabled';
              lClass='warning';
              lIcn='check';
            }
            else
            {
              attr='';
              lClass='warning';
              lIcn='spinner fa-pulse';
            }
            if(value.tStatus === 'Completed') {
              data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_dw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_dw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
            }
            else{
              // data += '<br><div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_dw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_dw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code></div></div></div>';
              data += '<div class="col-sm-4"><div class="ibox"><div class="ibox-title"><h5>'+value.title+'</h5></div><div class="ibox-content"><div class="team-members"><a href="#">'+value.img+'</a></div><h4>'+value.name+'</h4><p>'+value.description+'</p><code>Stating Date : '+value.start_time+'</code><br><code>Expected End Date : '+value.expected_end_time+'</code></div></div></div>';
            }
            x++;
          });
          });
          
        $("#date_wise").append(data);
        $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green'
              });
          $('input').on('ifChecked', function(event){
            // console.log($(this).attr('value'));
            $('#idss').text($(this).attr('id'));
            $('#ltID').val($(this).val());
            $("#description").modal('show');
            // $('.datepicker').datepicker({
            //   format: js_date_format,
            //   keyboardNavigation: false,
            //   forceParse: false,
            //   autoclose: true
            // });   
        });
        }
        else
        {
          $("#date_wise").html('');
            var data='';
            var x=1;
            $.each(response.data, function(key,value){
              if (value.tStatus==='Completed') {
                attr='checked="checked" disabled="disabled"';
                lClass='primary';
                lIcn='check';
                // copiedWholeTask
              }
              else if (value.tStatus==='Copied') {
                attr='checked disabled';
                lClass='warning';
                lIcn='check';
              }
              else
              {
                attr='';
                lClass='warning';
                lIcn='spinner fa-pulse';
              }
              if(value.type == 'class')
              {
                data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks" disabled/><a data-toggle="collapse" href="#collapse_dw'+x+'"><span class="m-l-xs">Lecture </span><small class="label label-warning '+x+'"><i class="fa fa-'+lIcn+'"></i> Scheduled</small></a><small class="btn btn-sm btn-primary pull-right" onClick="take_attendance(\''+value+'\');"> click</small></h4></div><div id="collapse_dw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><div class="well">'+value.description+'</div></div></div></div>';
                // data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks" disabled/><a data-toggle="collapse" href="#collapse'+x+'"><span class="m-l-xs">Lecture </span><small class="label label-warning '+x+'"><i class="fa fa-'+lIcn+'"></i> Scheduled</small></a><small class="btn btn-sm btn-primary pull-right" onClick="take_attendance('+value+');"> click</small></h4></div><div id="collapse'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="text-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
              }
              else{
                if (value.tStatus === 'Completed') {
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_dw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_dw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="text-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code><br><code><b>Actual End Time : </b>'+value.end_time+'</code></div></div></div>';
                }
                else{
                  data += '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><input type="checkbox" id="'+x+'" value="'+value.ID+'" name="" '+attr+' class="i-checks"/><a data-toggle="collapse" href="#collapse_dw'+x+'"><span class="m-l-xs">'+value.title+'</span><small class="label label-'+lClass+' '+x+'"><i class="fa fa-'+lIcn+'"></i> '+value.tStatus+'</small></a></h4></div><div id="collapse_dw'+x+'" class="panel-collapse collapse"><div class="panel-body"><span class="text-success">'+value.copiedWholeTask+'</span><small class="text-muted"><b>Task Starting Time : </b>'+value.start_time+'</small><strong class="pull-right">'+moment(value.start_time).fromNow()+'</strong><div class="well">'+value.description+'</div><code><b>Expected End Eime : </b>'+value.expected_end_time+'</code></div></div></div>';
                }
              }
              x++;
            });
            
          $("#date_wise").append(data);
          $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });
            $('input').on('ifChecked', function(event){
              // console.log($(this).attr('value'));
              $('#idss').text($(this).attr('id'));
              $('#ltID').val($(this).val());
              $("#description").modal('show');
          });
        }
      }
    }
  });
}

function make_approval(id)
{
  var branch_ID = $('#branch_ID').val();
  var rating = $('#rating-'+id).val();
  // $("#waiting_approval").html('<div class="text-center text-danger"><span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span></div>');
  $.ajax({
    type:'POST',
    dataType:'json',
    data:{'branch_ID':branch_ID,'rating':rating,'ID':id},
    url: '<?php echo base_url(); ?>'+'task/make_approval',
    success:function(resp)
    {
      toastr.warning("Approved Successfully.", 'Paathshala');
      waiting_approval();
    }
  });
}

$(document).on('hidden.bs.modal','.modal', function () {
  changeDateTask();
  getTimeline();
  $('#Timeline').focus();
})

function take_attendance(record)
{
  $('#scheduled_modal').modal('show');
}
</script>
