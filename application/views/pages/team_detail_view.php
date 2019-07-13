<div class="row m-b-lg m-t-lg">

<a href="<?php echo base_url('Team/edit/'.@$DETAIL[0]['employee_ID']);?>" type="button" class="btn btn-outline btn-warning"><i class="fa fa-pencil"></i> Edit</a>

<button type="button" onClick="del1();" class="btn btn-outline btn-danger"><i class="fa fa-trash"></i> Delete</button>

                <div class="col-md-6">

                    <div class="profile-image">

                    <?php $img = $this->str_function_library->call('fr>SS>path:ID=`'.@$DETAIL[0]['img_ID'].'`'); ?>

                        <img src="<?php echo base_url($img); ?>" class="img-circle circle-border m-b-md" alt="profile">

                    </div>

                    <div class="profile-info">

                        <div class="">

                            <div>

                                <h2 class="no-margins">

                                    <code><?php echo ucfirst($DETAIL[0]['Name']); ?></code>

                                </h2>

                                <small><?php echo $DETAIL[0]['employee_ID']; ?></small>

                                <h4><?php $position = $this->str_function_library->call('fr>DS>post:ID=`'.$DETAIL[0]['Position_ID'].'`');

                                echo $position; ?></h4>

                                <small>

                                    <?php echo $DETAIL[0]['details']; ?>

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

                                <strong><i class="fa fa-envelope"></i></strong> <?php echo ($DETAIL[0]['Email']); ?>

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

            ?>

                        <?php

                            switch ($col_val['phone_type']) {

                              case 'Work':

                                $icon = 'building';

                                break;

                              

                              case 'Home':

                                $icon = 'home';

                                break;

                              

                              case 'Mobile':

                                $icon = 'mobile';

                                break;

                              

                              case 'Personal':

                                $icon = 'user-secret';

                                break;

                              

                              case 'Fax':

                                $icon = 'fax';

                                break;

                              

                              default:

                                $icon = 'black-tie';

                                break;

                            }

                           

                        ?> 

                          <p><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo $col_val['phone_type']; ?> :

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

                            switch ($col_val['address_type']) {

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

                                            <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true">Attendance</a></li>

                                            <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">Salaries</a></li>

                                        </ul>

                                    </div>

                                </div>



                                <div class="panel-body">



                                <div class="tab-content">

                                <div class="tab-pane active" id="tab-1">

    

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

                                                <small><?php echo ucfirst($DETAIL[0]['Name']); ?> is <strong id="percent"></strong>%. present is this month.</small>

                                            </dd>

                                        </dl>

                                    </div>

                                </div>

                                        <div class="todo-list m-t row"  >

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

                                            <div id="calendar"></div>

                                        </div>

                                  </div>

                                  </div>

                                  <div class="col-sm-4">

                                    <div class="ibox float-e-margins">

                                        <div class="ibox-title">

                                            <h5>Monthy Attendance Table  </h5>

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

                                               <!--  <tr>

                                                    <td>1</td>

                                                    <td><span class="pie">0.52,1.041</span></td>

                                                    <td>Samantha</td>

                                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>

                                                </tr> -->



                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                  </div>

                                </div>

                                </div>

                                <div class="tab-pane" id="tab-2">

                                   <div class="ibox-content table-responsive">

                                        <div>

                                        <?php if (!empty($DETAIL[0]['Position_ID'])) { ?>

                                         <a class="btn btn-info btn-lg btn-block dim btn-outline" onclick="getSalaryDetail()"><i class="fa fa-info-circle"></i> Generate Salary</a>

                                         <?php }else{?>

                                          <a class="btn btn-info btn-lg btn-block dim btn-outline" data-toggle="popover" data-content="Designation Is not set yet, Please Set designation first" data-placement="top"><i class="fa fa-info-circle"></i> Generate Salary</a>

                                       <?php }?>

                                          

                                        </div>

                                        <hr>

                                        <div class="">

                                        <table id="example1" class="table table-striped table-bordered" cellspacing="0" >

                                          <thead>

                                            <tr>

                                              <th>Month</th>

                                              <th>Salary Amount</th>

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



                                </div>

                                </div>



          </div>

</div>



<!-- Data Tables -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

        <h4 class="modal-title">Perticulars</h4>

      </div>

      <div class="modal-body">

      <div class="form-group has-success">

          <div class="col-sm-3 control-label"><i class="fa fa-calendar"></i> Select Month</div>

            <div class="col-sm-7"><input type="text" id="datepicker" class="form-control" value="<?php echo $this->date_library->db2date(@$DETAIL['View'][0]['date'],"Y-m");?>"></div>

            <div class="col-sm-2"><button type="button" id="isPresentSalary" class="btn btn-primary">GO</button></div>

        </div>

      <div class="row showPerticular" hidden>

                    <small>Uncheck to change the value</small>

                    <form id="vendor_add" method="post" action="<?php echo base_url('team/addSalary');?>">

                    <input type="hidden" name="employee_ID" value="<?php echo $DETAIL[0]['employee_ID']; ?>">

                    <input type="hidden" name="date" value="" id="monthYr">

                        <ul class="todo-list m-t agile-list" id="perticularSalary">

                        </ul>

            </div>

          </div>

          <div class="col-sm-12 showEror" hidden>

            <div class="text-center">

              <div class="well">

                  <span>Salary Slip Already generated </span>

              </div>

            </div>

          </div>

      <div class="modal-footer showPerticular" hidden>

        <button type="submit" class="btn btn-primary" id="salGen">Generate</button>

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </form>

      </div>

      <div class="modal-footer showEror" hidden>

        <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>

        </form>

      </div>

    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

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



function del1()

{

    /*id = '<?php echo $DETAIL[0]["employee_ID"]; ?>';

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
                window.location.href = "<?php echo base_url('team'); ?>";
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

    designationID='<?php echo $DETAIL[0]['Position_ID']?>';

    employeeID='<?php echo $DETAIL[0]['employee_ID']?>';

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

                toastr.success('Successfully Added.');
                setTimeout(function(){
                  $("#myModal").modal('hide');
                  oTable1.ajax.reload();
                }, 3000);
            }

            else if (err==="Something went wrong in yout Email setting Please Check your Email setting <a href='"+base_url+"Settings/email_setting'>Click here</a> to Check") {

                toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 10000

                };

                toastr.error('Successfully Added BUT... mail not sent To employee, '+err, 'Skyq.in');

                toastr.success('Successfully Added.');
                setTimeout(function(){
                  $("#myModal").modal('hide');
                  oTable1.ajax.reload();
                }, 3000);

            }

            else if (err==="Must have to configure your Email setting <a href='"+base_url+"Settings/email_setting'>Click here</a> to Configure") {

                toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 10000

                };

                toastr.error('Successfully Added BUT... mail not sent To employee, '+err, 'Skyq.in');

                toastr.success('Successfully Added.');
                setTimeout(function(){
                  $("#myModal").modal('hide');
                  oTable1.ajax.reload();
                }, 3000);

            }

            else

            {

                mess = mess+err+"\n";

                toastr.error(mess);

            }

          });

        }

        else

        {

          toastr.error("Something went wrong!");

        }

      }

    });





 $("#isPresentSalary").click(function(){

    $('.showPerticular').fadeOut(1000);

    $('.showEror').fadeOut(100);

        date=$("#datepicker").val();

        id='<?php echo $DETAIL[0]['employee_ID']?>';

         $.ajax({

            type:'POST',

            data:{'date':date,'id':id},

            dataType:'json',

            url: '<?php echo base_url(); ?>'+'team/isPresentSalary',

            success:function(response)

            {

              if (response===false) {

                $('.showPerticular').fadeIn(1000);

                $('.showEror').fadeOut(1000);

                 toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 4000

                };

                toastr.success('You can generate Salary Slip Now', 'Skyq.in');

              }

              else 

                if (response===true) {

                $('.showPerticular').fadeOut(1000);

                $('.showEror').fadeIn(1000);

                toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 4000

                };

                toastr.error('Salary Slip Already generated', 'Skyq.in');

              }

              else

              {

                toastr.options = {

                    closeButton: true,

                    progressBar: true,

                    showMethod: 'slideDown',

                    timeOut: 4000

                };

                toastr.error('Something went Wrong please try again later', 'Skyq.in');

              }

            }

          });

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
              oTable1.ajax.reload();
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