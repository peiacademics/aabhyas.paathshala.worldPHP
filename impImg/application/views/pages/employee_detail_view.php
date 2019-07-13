<div class="row m-b-lg m-t-lg">
  <a href="<?php echo base_url('Team/edit/'.@$DETAIL[0]['ID']);?>" type="button" class="btn btn-outline btn-warning"><i class="fa fa-pencil"></i> Edit</a>
  <button type="button" onClick="del1('<?php echo @$DETAIL[0]['ID']; ?>');" class="btn btn-outline btn-danger"><i class="fa fa-trash"></i> Delete</button>
  <div class="col-md-6">
    <div class="profile-image">
    <?php 
    $img = $this->str_function_library->call('fr>SS>path:ID=`'.@$DETAIL[0]['Image_ID'].'`'); ?>
      <img src="<?php echo base_url($img); ?>" class="img-circle circle-border m-b-md" alt="profile">
    </div>
    <div class="profile-info">
      <div class="">
        <div>
          <h2 class="no-margins">
              <code><?php echo ucfirst(@$DETAIL[0]['Name']); ?></code>
          </h2>
          <small><?php echo @$DETAIL[0]['employee_ID']; ?></small>
          <h5><?php @$position = @$this->str_function_library->call('fr>DS>post:ID=`'.@$DETAIL[0]['Type'].'`');
                echo $position; ?></h5>
          <h5 class="text-navy"><?php echo @$this->str_function_library->call('fr>BR>name:ID=`'.@$DETAIL[0]['branch_ID'].'`'); ?></h5>
          <small>
            <p><?php echo @$DETAIL[0]['details']; ?></p>
          </small>
        </div>
        </div>
    </div>
  </div>

  <div class="col-md-3">
      <table class="table small m-b-xs">
        <tbody>
          <tr>
            <td>
            <strong><i class="fa fa-envelope"></i></strong> <?php echo (@$DETAIL[0]['Email']); ?>
            </td>
          </tr>
          <tr>
            <td>
<?php if(isset($DETAIL['List']['Phone'])) 
      {
        $i = 0;
        foreach(@$DETAIL['List']['Phone'] as $col_val)
        {
          $i++; 
              switch (@$col_val['phone_type']) {
                case 'Work':
                  @$icon = 'building';
                  break;
                case 'Home':
                  @$icon = 'home';
                  break;
                case 'Mobile':
                  @$icon = 'mobile';
                  break;
                case 'Personal':
                  @$icon = 'user-secret';
                  break;
                case 'Fax':
                  @$icon = 'fax';
                  break;
                default:
                  @$icon = 'black-tie';
                  break;
              }
          ?> 
            <p><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo @$col_val['phone_type']; ?> :
            <?php echo @$col_val['phone_number']; ?></p>
<?php     }
      }
?>
              </td>
          </tr>
          <tr>
              <td>
    <?php if(isset($DETAIL['List']['Address'])) 
      {
        $i = 0;
        foreach(@$DETAIL['List']['Address'] as $col_val)
        {
          $i++;
?>
          <?php
              switch (@$col_val['address_type']) {
                case 'Work':
                  $icon = 'building';
                  break;
                case 'Home':
                  $icon = 'home';
                  break;
                default:
                  $icon = 'black-tie';
                  break;
              }
          ?> 
            <p><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo $col_val['address_type']; ?> :
            <?php echo @$col_val['address']; ?></p>
<?php     }
      }
?>
              </td>
          </tr>
          </tbody>
      </table>
  </div>
</div>



<div class="wrapper wrapper-content">
  <div class="row animated fadeInRight">
    <div class="col-lg-12">
      <div class="panel blank-panel">
        <div class="panel-heading">
          <div class="panel-options">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true">Task</a></li>
              <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">Awards</a></li>
              <li class=""><a href="#tab-3" data-toggle="tab" aria-expanded="false">Attendance</a></li>
              <li class=""><a href="#tab-4" data-toggle="tab" aria-expanded="false">Post</a></li>
              <li class=""><a href="#tab-5" data-toggle="tab" aria-expanded="false">Attachments</a></li>
            </ul>
          </div>
        </div>

        <div class="panel-body">
          <div class="tab-content">
            <div class="tab-pane" id="tab-3">
              <div class="ibox-content">
                <h2>Statistics</h2>
                  <small>This is total Statistics of this month</small>
                    <div class="row">
                      <div class="col-lg-12">
                        <dl class="dl-horizontal">
                          <dt>Attendance:</dt>
                            <dd>
                            <div class="progress progress-striped active m-b-sm">
                              <div style="width: 60%;" class="progress-bar"></div>
                            </div>
                            <small><?php echo ucfirst(@$DETAIL[0]['Name']); ?> is <strong id="percent"></strong>%. present is this month.</small>
                              </dd>
                        </dl>
                      </div>
                    </div>
                    <div class="todo-list m-t row">
                      <div class="col-sm-3">
                        <span class="m-l-xs">Working Days</span>
                          <small class="btn btn-warning m-r-sm" id="workingDays"> </small>
                      </div>
                      <div class="col-sm-3">
                        <span class="m-l-xs">Holidays</span>
                          <small class="btn btn-success m-r-sm" id="holidays"> </small>
                      </div>
                      <div class="col-sm-3">
                        <span class="m-l-xs">Present Days</span>
                          <small class="btn btn-primary m-r-sm" id="presentDay"></small>
                      </div>
                      <div class="col-sm-3">
                        <span class="m-l-xs">Absent Days</span>
                          <small class="btn btn-danger m-r-sm" id="absentDay"> </small>
                      </div>
                    </div>
              </div>
              <div class="row">
                <br>
                  <div class="col-sm-8">
                    <div class="ibox float-e-margins">
                      <div class="ibox-title">
                        <h5>Attendance </h5>
                      </div>
                        <div class="ibox-content">
                          <div id="calendar">
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="ibox float-e-margins">
                      <div class="ibox-title">
                        <h5>Monthy Attendance Table</h5>
                          <div class="ibox-tools">
                            <a class="collapse-link">
                              <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                              <i class="fa fa-times"></i>
                            </a>
                          </div>
                      </div>

                      <div class="ibox-content">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Hours</th>
                              <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="dataTable1">
                           <tr>
                            <td>1</td>
                              <td><span class="pie">0.52,1.041</span></td>
                              <td>Samantha</td>
                              <td class="text-navy"><i class="fa fa-level-up"></i> 40% </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                   </div>
                  </div>
              </div>
            </div>

             <!--  <end-panel-1> -->

            <div class="tab-pane" id="tab-2">
              Awards
            </div>

    <!--         <end panel-2> -->

             <div class="tab-pane active" id="tab-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Task Alloted</h5>
                        <div class="ibox-tools">
                            <span class="label label-warning-light pull-right">Total <?php echo count(@$DETAIL['Task']); ?></span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="feed-activity-list">
                          <?php if((@$DETAIL['Task'] != NULL) && !empty(@$DETAIL['Task']) && (@$DETAIL['Task'] != FALSE)) {
                            foreach ($DETAIL['Task'] as $key => $value) { ?>
                              <div class="feed-element">
                                <a href="#" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php echo base_url($value['path']); ?>">
                                </a>
                                <div class="media-body">
                                  <strong class="text-warning"><?php echo $value['user']; ?></strong>
                                  <?php if($value['type'] === 'Task') { ?>
                                    <small class="pull-right">Assigned on <?php echo $value['Added_on']; ?></small>
                                    <strong>
                                      Assigned a task <a href="#" class="text-navy"><?php echo $value['title']; ?></a>
                                    </strong>
                                    <span class="text-muted"> (<?php echo $value['description']; ?>)</span><br>
                                    <small class="text-muted">Started on <?php echo $value['start_time']; ?> - <?php if($value['tStatus'] === 'Completed') { ?>
                                      Completed on <?php echo $value['end_time']; ?>.
                                    <?php } else { ?>
                                      Expected on <?php echo $value['expected_end_time']; ?>.
                                    <?php } ?>
                                    </small>
                                  <?php } else { ?>
                                    <small class="pull-right">Assigned on <?php echo $value['Added_on']; ?></small>
                                    <strong>Scheduled a lecture of <a href="#" class="text-navy"><?php echo $value['Subject']; ?></a> for batch <a href="#" class="text-success"><?php echo $value['Class_ID']; ?></a></strong><br>
                                    <small class="text-muted">From <?php echo $value['start_date']; ?> - to <?php echo $value['end_date']; ?> at <?php echo $value['Time']; ?>.</small>
                                  <?php } ?>
                                </div>
                            </div>
                          <?php } } else { ?>
                            <h1 class="text-danger text-center">No Tasks Assigned.</h1>
                          <?php } ?>
                        </div>
                    </div>
                </div>
             </div>

              <!-- <end-panel-3> -->

            <div class="tab-pane" id="tab-4">
            Posts
            </div>
            <!-- <end-panel-4> -->
             <div class="tab-pane" id="tab-5">
             <div class="col-lg-12 animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="file-box">
                                <?php
                                if (!empty($DETAIL[0]['Image_ID'])) 
                                {
                                  $img = $this->str_function_library->call('fr>SS>path:ID=`'.$DETAIL[0]['Image_ID'].'`'); 
                                }
                                ?>
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>
                                        <?php  if (!empty($img)) {
                                         ?>
                                          <div class="image">
                                              <img alt="image" class="img-responsive" src="<?php echo base_url().$img;?>">
                                          </div>
                                       <?php } else { ?>
                                          <div class="icon"><i class="img-responsive fa fa-film"></i></div>
                                        <?php } ?>
                                        <div class="file-name">
                                            <?php echo 'Profile Photo';?>
                                            
                                            <span class="text-right"><a href="<?php echo base_url('bank/downloadFile/'.$img);?>"><h3><i class="fa fa-download" aria-hidden="true"></i></h3></a></span>
                                        </div>
                                    </a>

                                </div>
                            </div>
                           <?php 
                           if (!empty($DETAIL['doc'])) { 
                            foreach ($DETAIL['doc'] as $key => $value) {
                            $ext = pathinfo($value['path'], PATHINFO_EXTENSION); 
                            ?>
                            <div class="file-box">
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>
                                        <?php  if ($ext==='jpg' || $ext==='png' || $ext==='JPG' || $ext==='PNG') {
                                         ?>
                                          <div class="image">
                                              <img alt="image" class="img-responsive" src="<?php echo base_url().$value['path'];?>">
                                          </div>
                                       <?php } else { ?>
                                          <div class="icon"><i class="img-responsive fa fa-film"></i></div>
                                        <?php } ?>
                                        <div class="file-name">
                                            <?php echo '..'.substr($value['path'], -7);?>
                                            
                                            <span class="text-right"><a href="<?php echo base_url('bank/downloadFile/'.$value['path']);?>"><h3><i class="fa fa-download" aria-hidden="true"></i></h3></a></span>
                                        </div>
                                    </a>

                                </div>
                            </div>
                           <?php }
                         }
                           else
                           { ?>
                                <h3 class="text-danger"><i class="fa fa-times"></i> NO Attachments Found</h3>
                            <?php }
                           ?>
                        </div>
                      </div>
                    </div>
             
            </div>
            <!-- <end-panel-5> -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>





<script type="text/javascript">

    var base_url="<?php echo base_url(); ?>";

</script>

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

<link href="<?php echo base_url("css/plugins/fullcalendar/fullcalendar.css"); ?>" rel="stylesheet">

<link href="<?php echo base_url("css/plugins/fullcalendar/fullcalendar.print.css"); ?>" rel='stylesheet' media='print'>

<!-- Full Calendar -->

<script src="<?php echo base_url("js/plugins/fullcalendar/fullcalendar.min.js"); ?>"></script>

<script src="<?php echo base_url("js/attendance.js"); ?>"></script>

<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>

<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">

$(document).ready(function() {

id='<?php echo @$DETAIL[0]['employee_ID']; ?>';

attendance(id);



date='<?php echo date('Y-m'); ?>';

getAtData(id,date);

});



function del1(id)

{

    /*id = '<?php //echo $DETAIL[0]["employee_ID"]; ?>';

    alert(id);*/

    bootbox.confirm('Are you sure you want to delete?', function(result) {

    if(result == true)

    {

      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');

      $("#Login_screen").fadeIn('fast');

      $.ajax({

        url:'<?php echo base_url(); ?>'+'Team/delete/'+id,

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
              window.location.href = "<?php echo base_url('Team/lists'); ?>";
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



function getSalaryDetail() {

    designationID='<?php echo $DETAIL[0]['Type']?>';

    // employeeID='<?php //echo $DETAIL[0]['employee_ID']?>';

    $.ajax({

        type:'POST',

        dataType:'json',

        url: '<?php echo base_url(); ?>'+'designation/showDetails/'+designationID,

        success:function(response)

        {

            $('#perticularSalary').html('');

            if (typeof response==='object') {

                if (response.Dynamic==='Yes') {

                    $c=1;

                    $.each(response.perticular, function(key,value){

                        if (value.payStatus==='Dynamic') {

                            $('#perticularSalary').append('<li class="info-element"><input type="checkbox" value="Cm'+value.ID+'" class="i-checks" checked/><span class="m-l-xs col-sm-4">'+value.perticular+'</span><input type="hidden" value="'+value.perticular+'" name="PP-perticular-'+$c+'"><input type="hidden" value="'+value.amountType+'" name="PP-amountType-'+$c+'"><span class="col-sm-4"><input type="number" readonly class="form-control amountSum" id="Am'+value.ID+'" value="'+value.amount+'" name="PP-amount-'+$c+'" onkeyup="sum()"></span></li>');

                        }

                        else

                        {

                            $('#perticularSalary').append('<li class="warning-element"><input type="checkbox" disabled value="" name="" class="i-checks col-sm-1" checked/><span class="m-l-xs col-sm-4">'+value.perticular+'</span><input type="hidden" value="'+value.perticular+'" name="PP-perticular-'+$c+'"><input type="hidden" value="'+value.amountType+'" name="PP-amountType-'+$c+'"><span class="col-sm-4"><input type="number" readonly class="form-control col-sm-4 amountSum" value="'+value.amount+'" name="PP-amount-'+$c+'"></span></li>');

                        }

                        $c++;

                    });

                    if (response.deduction.length===0) {

                        $('#perticularSalary').append('<div class="row"><div class="col-sm-4 col-sm-offset-4"><h4>No Deduction</h4></div><span class="col-sm-4"></span></div>');

                    }

                    else

                    {

                        $('#perticularSalary').append('<div class="row"><div class="col-sm-4 col-sm-offset-4"><h4>Deduction</h4></div><span class="col-sm-4"></span></div>');



                       $.each(response.deduction, function(key,value){

                        if (value.payStatus==='Dynamic') {

                            $('#perticularSalary').append('<li class="info-element"><input type="checkbox" value="Cm'+value.ID+'" class="i-checks" checked/><span class="m-l-xs col-sm-4">'+value.perticular+'</span><input type="hidden" value="'+value.perticular+'" name="PP-perticular-'+$c+'"><input type="hidden" value="'+value.amountType+'" name="PP-amountType-'+$c+'"><span class="col-sm-4"><input type="number" readonly class="form-control amountSub" id="Am'+value.ID+'" value="'+value.amount+'" name="PP-amount-'+$c+'" onkeyup="sum()"></span></li>');

                        }

                        else

                        {

                            $('#perticularSalary').append('<li class="warning-element"><input type="checkbox" disabled value="" name="" class="i-checks col-sm-1" checked/><span class="m-l-xs col-sm-4">'+value.perticular+'</span><input type="hidden" value="'+value.perticular+'" name="PP-perticular-'+$c+'"><input type="hidden" value="'+value.amountType+'" name="PP-amountType-'+$c+'"><span class="col-sm-4"><input type="number" readonly class="form-control col-sm-4 amountSub" value="'+value.amount+'" name="PP-amount-'+$c+'"></span></li>');

                        }

                        $c++;

                    });

                    }



                    $('#perticularSalary').append('<div class="row"><div class="col-sm-4 col-sm-offset-4"><h3>Total salary</h3></div><span class="col-sm-4"><input type="number" id="ttlSum" readonly class="form-control col-sm-4" value="" name="Total_Amount"></span></div>');



                    $('.i-checks').iCheck({

                        checkboxClass: 'icheckbox_square-green',

                        radioClass: 'iradio_square-green'

                    });



                   $('input').on('ifChecked', function(event){

                        myString=$(this).val();

                        myString=myString.replace('Cm','');

                        $('#Am'+myString).attr('readonly',true);

                    });



                    $('input').on('ifUnchecked', function(event){

                        myString=$(this).val();

                        myString=myString.replace('Cm','');

                        $('#Am'+myString).removeAttr('readonly');

                    });

                    sum();

                    $("#datepicker").datepicker( {

                        format: "yyyy-mm",

                        viewMode: "months", 

                        minViewMode: "months",

                        endDate: '<?php echo  date("Y-m-d");?>'

                    });

                    $("#myModal").modal('show');

                }

                else

                {

                    alert("wtf");

                }

            }

        }

      });

}





function sum() {

    var sum = 0;

    $( '.amountSum' ).each( function( i , e ) {

        var v = parseInt( $( e ).val() );

        if ( !isNaN( v ) )

            sum += v;

    } );



    var sub = 0;

    $( '.amountSub' ).each( function( i , e ) {

        var v = parseInt( $( e ).val() );

        if ( !isNaN( v ) )

            sub += v;

    } );





    $("#ttlSum").val(sum-sub);

}







$("#vendor_add").postAjaxData(function(result)

    {

      if(result === 1)

      {

        var type = "<?php echo isset($DETAIL['What']) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully Added and Mail send successfully');
        setTimeout(function(){
          $("#myModal").modal('hide');
          oTable1.ajax.reload();
        }, 3000);
      }

      else

      {

        if(typeof result === 'object')

        {

          mess = "";

          $.each(result,function(dom,err)

          {

            if (err==='The date field must contain a unique value.') {

                 toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 4000

                };

                toastr.error('Salary Slip Already generated for This month please check', 'Skyq.in');

            }

            else if (err==='Email is must') {

                toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 10000

                };

                toastr.error('Successfully Added BUT...EmailID of employee Is not set. so mail not sent To employee,', 'Skyq.in');
                toastr.success('Successfully Added .');
                setTimeout(function(){
                  $("#myModal").modal('hide');
                  oTable1.ajax.reload();
                },3000);
            }

            else if (err==="Something went wrong in yout Email setting Please Check your Email setting <a href='"+base_url+"Settings/email_setting'>Click here</a> to Check") {

                toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 10000

                };

                toastr.error('Successfully Added BUT... mail not sent To employee, '+err, 'Skyq.in');
                toastr.success('Successfully Added .');
                setTimeout(function(){
                  $("#myModal").modal('hide');
                  oTable1.ajax.reload();
                },3000);
            }

            else if (err==="Must have to configure your Email setting <a href='"+base_url+"Settings/email_setting'>Click here</a> to Configure") {

                toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 10000

                };

                toastr.error('Successfully Added BUT... mail not sent To employee, '+err, 'Skyq.in');

                toastr.success('Successfully Added .');
                setTimeout(function(){
                  $("#myModal").modal('hide');
                  oTable1.ajax.reload();
                },3000);

            }

            else

            {

                mess = mess+err+"\n";

                toastr.error(mess);

            }

          });

          //console.log(result);

        }

        else

        {

          toastr.error("Something went wrong!");

        }

      }

    });


$("#salGen").click(function(){

     date=$("#datepicker").val();

     $('#monthYr').val(date);

});





 $('#myModal').on('hidden.bs.modal', function () {

   $('.showPerticular').fadeOut();

    $('.showEror').fadeOut();

})

id='<?php echo @$DETAIL[0]['employee_ID']; ?>';

 oTable1 = $('#example1').DataTable( {

        "processing": true,

        "serverSide": true,

        "ajax": "<?php echo base_url('team/get_show_data'); ?>/"+id

    } );



 function deletef(id,href)

{

  bootbox.confirm('Are you sure you want to delete?', function(result) {

    if(result == true)

    {

      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');

      $("#Login_screen").fadeIn('fast');

      console.log(id);

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