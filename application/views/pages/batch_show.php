<div class="row">
  <div class="ibox-content">
    <input type="hidden" id="branch_ID" value="<?php echo $ID; ?>">
    <?php if($this->session_library->get_session_data('Login_as') != 'DSSK10000011') { ?>
    <div class="form-group">
    	<label for="DOB" class="col-sm-2 control-label flt-left">Select Batch :</label>
    	<div class="col-sm-9 text-left">
    	  <select class="form-control chosen-select" name="language" id="batch" onchange="getClass(this)" required>
    	  </select>
    	</div>
    	<span id="Gender"></span>
    	<br>
    	<br>
    </div>
    <?php } ?>
    <div id="calendarClass"></div>
  </div>
</div>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<script type="text/javascript">
  base_url="<?php echo base_url(); ?>";
	getChosenData('batch','BT',[{'label':'name','value':'ID'}],[{'branch_ID':'<?php echo $ID; ?>'}]);
  $("#batch").find("option").eq(0).remove();
  $('#batch').prepend('<option value="">All<option>');
	function getClass(d) {
    fetchCalDataClass($(d).val());
	}
  fetchCalDataClass();
  function fetchCalDataClass(classs) {
    var branch_ID = $('#branch_ID').val();
    $.ajax({
            type:'POST',
            data:{Class_ID:classs},
            dataType:'json',
            url: base_url+'batch/classes/'+branch_ID,
            success:function(response)
            {
                $('#calendarClass').fullCalendar('removeEvents')
                $('#calendarClass').fullCalendar( 'removeEventSource', response)
                $('#calendarClass').fullCalendar( 'addEventSource', response)
            }
          });
}

	$('#calendarClass').fullCalendar({
        dayClick: function(date, jsEvent, view) {
            $('#dateAssign').val(date.format());
            <?php if(($this->data['Login']['Login_as'] != 'DSSK10000011') && ($this->data['Login']['Login_as'] != 'DSSK10000012')) { ?>
              fetchEventbyDatesforClass([date.format('YYYY-MM-DD'),date.format('DD|MM|YYYY')],$('#batch').val());
            <?php } ?>
        },
        eventClick: function(calEvent, jsEvent, view) {
            $('#dateAssign').val(calEvent.start._i);
            $(this).css('border-color', 'red');
            date = calEvent.start._i.split(" ");
            date2 = $.fullCalendar.moment(date[0]).format('DD|MM|YYYY');
            <?php if(($this->data['Login']['Login_as'] != 'DSSK10000011') && ($this->data['Login']['Login_as'] != 'DSSK10000012')) { ?>
              fetchEventbyDatesforClass([date[0],date2],$('#batch').val(),calEvent.id);
            <?php } ?>
        },
        events: [
        ],
        eventRender: function(event, element) {
             if (event.description==='Completed') {
                bfClass = "fa-check";
                }
                else
                {
                  bfClass = "fa-spinner fa-pulse";
                }
              bClass = event.color;
              element.find('.fc-time').html('');
              element.find('.fc-title').html('<button id="'+event.id+'" class="btn btn-circle" type="button" style="background:'+bClass+'"><i class="fa '+bfClass+'"></i></button><b>'+event.title+'</b>');
                if (event.imageurl) {
                    element.find("div.fc-content").prepend("<img src='" + base_url+event.imageurl +"' width='30' class='crlwName'>");
                }
        }
    });


function fetchEventbyDatesforClass(date,classs,id=null) {
    var branch_ID = $('#branch_ID').val();
    $.ajax({
        type:'POST',
        data:{Date:date[0],Class_ID:classs},
        dataType:'json',
        url: base_url+'lecture/classes/'+branch_ID,
        success:function(response)
        {
            if (typeof response==='object') {
                showClassData(response,id);
                $('#tab-4').addClass('active');
                $('#tab_show').addClass('active');
                $('#tab-5').removeClass('active');
                $('#tab_add').removeClass('active');
                $('#classModal').modal("show");
                $('#dateClass').text(date[1]);
                $('#lec_date').text(date[1]);
                $('#dateClasss').val(date[1]);
                $('#branchID').val('<?php echo $ID; ?>');
            }else
            if (response===false) {
                $('#MainTask1').removeAttr('style');
                $('.whTask1').removeAttr('style');
                $('#tab-4').addClass('active');
                $('#tab_show').addClass('active');
                $('#tab-5').removeClass('active');
                $('#tab_add').removeClass('active');
                $('#classModal').modal("show");
                $('#dateClass').text(date[1]);
                $('#lec_date').text(date[1]);
                $('#dateClasss').val(date[1]);
                $('#branchID').val('<?php echo $ID; ?>');
                $('#classesAssigned').html('<h4><code>No Class Found</code></h4>');
            }
            else
            {
                alert('not satisfied');
                $('#MainTask1').removeAttr('style');
                $('.whTask1').removeAttr('style');
                $('#tab-4').addClass('active');
                $('#tab_show').addClass('active');
                $('#tab-5').removeClass('active');
                $('#tab_add').removeClass('active');
                $('#classModal').modal("show");
            }
        }
      });
    $('#days_chosen').css('width', '100%');
    $('#days').trigger('chosen:updated');
    getChosenData('prof','US',[{'label':'Name','value':'ID'}],[{'Status':'A','branch_ID':branch_ID}]);
    getChosenData('sub','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}]);
    getChosenData('classs','BT',[{'label':'name','value':'ID'}],[{'Status':'A','Branch_ID':branch_ID}]);
    $('#classs').append('<option value="all">Select student by Name</option>');
    getChosenData('student_ID','ST',[{'label':'Name','value':'ID'}],[{'Status':'A'}]);
    $('.modalTime').datetimepicker({
        format: 'LT'
    });
}
function showClassData(response ,id) {
  $('#classesAssigned').html('');
  var base_url = "<?php echo base_url(); ?>"
  if (response !== null) {
    data ='';
    $.each(response,function(key,val) {
      seprtn = val['title'].split("-");
      data += "<div class='feed-element' id='classes"+val.id+"'><a href='profile.html' class='pull-left'><img alt='image' class='img-circle' src='"+base_url+val.imageurl+"'></a><div class='media-body'><small class='pull-right'></small><a href='"+base_url+"Team/view/"+val.EmpID+"'><strong>"+val.EmpName+"</strong></a> is conducting a lecture of <strong>"+seprtn[0]+"</strong> on <strong class='text-primary'>"+moment(val.date).format("MMMM Do YYYY, h:mm a")+"</strong> for <strong>"+seprtn[1]+"</strong>. <br><small class='text-muted'>Scheduled from Date "+moment(val.start_date).format("MMMM Do YYYY")+" to "+moment(val.end_date).format("MMMM Do YYYY")+" on Time "+val.time+"</small><div class='pull-right'><a class='btn btn-xs btn-primary' href='#tab-5' data-toggle='tab' onClick='edit("+JSON.stringify(val)+");'><i class='fa fa-pencil'></i> Edit </a></div></div></div>";
    });
    $('#classesAssigned').html(data);
    if (id !== null) {
      $('#classes'+id).addClass('highlighted');
      setTimeout(function(){
        $('#classes'+id).removeClass('highlighted',1000);
      }, 2000);
      $('#classes'+id).focus();
    }
    
  }
  else
  {
    $('#classesAssigned').html('<div class="feed-element text-danger"><h1><strong>No classes Today</strong></h1></div>');
  }
}

function scroll(id) {
  $('html,body').animate({
        scrollTop: $(id).offset().top-500},
        'slow');
}

$(document).ready(function() {
  // body...
  //commun('CLSK10000006');
$("#add_Classesed").on('click',function(e){
  e.preventDefault();
    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
    $('.modal-content').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader1.gif"></div>');
    var form = $("#form").serialize();
    e.preventDefault();
    if($("#form").valid())
    {
    $.ajax({
        type:'POST',
        data:form,
        dataType:'json',
        url: base_url+'batch/addClass',
        success:function(result)
        {
          if(typeof result === 'object')
          {
            if(result.stat == true)
            {
              fetchCalDataClass();
              var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
              $('#cmt').attr('onclick','commun("'+result.id+'")');
              // $('#cmt').removeClass('hidden');
              // $('#add_Classesed').addClass('hidden');
              toastr.success('Successfully '+type+'.');
            }
            else
            {
              toastr.error("Something went wrong!");
            }
          }
          else
          {
            toastr.error("Something went wrong!");
          }
        }
      });
    }
  });

$('#classModal').on('hidden.bs.modal', function () {
  $('#classModal').find("input,textarea,select").val('').end();
  $('#tab-5').removeClass('active');
  $('#tab_add').removeClass('active');
});

});
</script>

<div class="modal inmodal fade" id="classModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg m-lgg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-danger" id="dateClass">Class</h4>
                <b><small  class="text-danger"></small></b>
            </div>
            <div class="modal-body">
              <div class="row">
                    <div class="col-lg-12">
                      <div class="tabs-container">
                          <ul class="nav nav-tabs">
                              <li id="tab_show" class="active"><a data-toggle="tab" href="#tab-4"><i class="fa fa-eye"></i> Show</a></li>
                              <li id="tab_add"><a data-toggle="tab" href="#tab-5"><i class="fa fa-plus"></i> Add / Edit</a></li>
                          </ul>
                          <div class="tab-content">
                              <div id="tab-4" class="tab-pane active">
                                  <div class="panel-body">
                                    <div class="ibox-content">
                                        <div>
                                            <div class="feed-activity-list" id="classesAssigned">
                                            </div>
                                        </div>

                                    </div>
                                  </div>
                              </div>
                              <div id="tab-5" class="tab-pane">
                                  <div class="panel-body">
                                    <form id="form" class="wizard-big" method="post" action="#">
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Date Range :</label>
                                        <div class="col-sm-9">
                                          <input type="text" id="Date" class="form-control daterange" name="Date" placeholder="Date" value="" required>
                                          <input type="hidden" name="ID" id="ID">
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                    	<div class="form-group">
  			                                <label for="number" class="col-sm-2 control-label"> From Time :</label>
  			                                <div class="col-sm-9">
                                          <input type="text" class="form-control modalTime" id="Time" name="Time" placeholder="From Time" value="" required>
                                          <input type="hidden" name="date" id="dateClasss" required>
  			                                  <input type="hidden" name="Branch_ID" id="branchID" value="<?php echo $ID; ?>" required>
  			                                </div>
  			                              </div>
  			                            </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">To Time :</label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control modalTime" id="Totime" name="Totime" placeholder="To Time" value="" required>
                                        </div>
                                      </div>
                                    </div>
  			                            <br>
  			                            <div class="row">
  			                              <div class="form-group">
  			                                <label for="number" class="col-sm-2 control-label">Batch :</label>
  			                                <div class="col-sm-9">
  			                                  <select class="form-control chosen-select" id="classs" name="Class_ID[]" multiple required onChange="get_all_students()">
  	  										                </select>
  			                                </div>
  			                              </div>
  			                            </div> <br>
                                    <div class="row hidden stud_ids">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Student :</label>
                                        <div class="col-sm-9">
                                          <select class="form-control chosen-select" id="student_ID" name="student_ID[]" disabled multiple required>
                                          </select>
                                        </div>
                                      </div>
                                    </div> <br class="stud_ids hidden">
  			                            <div class="row">
  			                              <div class="form-group">
  			                                <label for="number" class="col-sm-2 control-label">Professor :</label>
  			                                <div class="col-sm-9">
  			                                  <select class="form-control chosen-select" name="professor_ID" id="prof" required>
  	  										                </select>
  			                                </div>
  			                              </div>
  			                            </div> <br>
  			                            <div class="row">
  			                              <div class="form-group">
  			                                <label for="number" class="col-sm-2 control-label">Subject :</label>
  			                                <div class="col-sm-9">
  			                                  <select class="form-control chosen-select" name="Subject" id="sub" required>
                                          </select>
  			                                </div>
                                        <input type="hidden" name="type" id="type" value="add">
  			                              </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Days of Week :</label>
                                        <div class="col-sm-9">
                                          <select class="form-control chosen-select" name="Days[]" id="days" multiple required>
                                            <option disabled selected>Select Days</option>
                                            <option value="Sunday">Sunday</option>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                            <option value="Saturday">Saturday</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Chapter :</label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" name="chapter" placeholder="Chapter" id="chapter" value="">
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Topics :</label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" name="topic" placeholder="Topics" id="topic" value="">
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Description :</label>
                                        <div class="col-sm-9">
                                          <textarea type="text" class="form-control" id="desc" name="description" placeholder="Description" value=""></textarea>
                                        </div>
                                      </div>
                                    </div> -->
                                    </form>
                                    <br>
                                    <div class="text-center">
                                      <button type="button" id="add_Classesed" class="btn btn-success btn-facebook btn-outline">
                                        <i class="fa fa-plus"> </i> Add
                                      </button>
                                      <button id="cmt" type="button" class="btn btn-success">Communicate</button>
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
<script type="text/javascript">
  $('.daterange').daterangepicker({
    format: 'DD|MM|YYYY',
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

  function edit(res)
  {
    $('#tab_show').removeClass('active');
    $('#tab_add').addClass('active');
    $('#ID').val(res.id);
    $('#Date').val(res.start_date+' - '+res.end_date);
    $('#Time').val(res.time);
    $('#classs').val(res.class_ID).trigger('chosen:updated');
    if(res.class_ID == 'all')
    {
      $('.stud_ids').removeClass('hidden');
      $('#student_ID').removeAttr('disabled');
      var data = '';
      var studs = res.student_ID.split(',');
      $.each(studs,function(key,val){
        $('#student_ID option[value='+val+']').attr('selected','selected');
      });
      $('#student_ID_chosen').css('width', '100%');
      $('#student_ID').trigger('chosen:updated');
    }
    else
    {
      $('#student_ID').val('');
      $('.stud_ids').addClass('hidden');
      $('#student_ID').attr('disabled','disabled');
    }
    $('#prof').val(res.professor).trigger('chosen:updated');
    $('#sub').val(res.subject).trigger('chosen:updated');
    $('#chapter').val(res.chapter);
    $('#topic').val(res.topic);
    $('#desc').val(res.description);
    $('#add_Classesed').text('Save');
    $('#type').val('edit');
    $('#Totime').val(res.Totime);
    $('#days').val(res.hiddenDays).trigger('chosen:updated');
  }
  $("#tab_add").on('click',function(e){
    $('#ID').val('');
    $('#Date').val('');
    $('#Time').val('');
    $('#classs').val('').trigger('chosen:updated');
    $('#prof').val('').trigger('chosen:updated');
    $('#sub').val('').trigger('chosen:updated');
    $('#chapter').val('');
    $('#topic').val('');
    $('#student_ID').val('').trigger('chosen:updated');
    $('#desc').text('');
    $('#add_Classesed').text('Add');
    $('#type').val('add');
    $('.stud_ids').addClass('hidden');
    $('#student_ID').attr('disabled','disabled');
  });

  function get_all_students()
  {
    var batch = $('#classs').val();
    var branch_ID = $('#branch_ID').val();
    if(batch =='all')
    {
      $('.stud_ids').removeClass('hidden');
      $('#student_ID').removeAttr('disabled');
      $('#student_ID_chosen').css('width', '100%');
      $('#student_ID').trigger('chosen:updated');
    }
    else
    {
      $('#student_ID').val('');
      $('#student_ID').attr('disabled','disabled');
      $('.stud_ids').addClass('hidden');
    }
  }

  function commun(id)
  {
    $.ajax({
      url:'<?php echo base_url("communicate/get_record"); ?>',
      method:'POST',
      data:{ID:id,rec_id:'CMSSK10000005',tbl:'CL'},
      datatype:'JSON',
      success:function(response){
        response = JSON.parse(response);
        console.log(response);
        $('#branch_added select option[value="'+response.rec.Branch_ID+'"]').prop('selected', true).trigger("chosen:updated");
        $('#typeCom option[value="'+response.setting.type+'"]').prop('selected', true).trigger("chosen:updated");
        getTypeList(response.setting.type);
        setTimeout(function() {
          if (response.rec.Class_ID.indexOf(',') > -1){
            var batches2 = [];
            $.each(response.rec.Class_ID.split(','), function(i,e) {
              batches2.push(e);
            });
            $('#listsOfperson').val(batches2).trigger('chosen:updated');
            $.each(response.rec.Class_ID.split(','), function(i,e2) {
              personsToSendMsg(e2);
            });
          }
          else
          {
            $('#listsOfperson').val(response.rec.Class_ID).trigger('chosen:updated');
            personsToSendMsg(response.rec.Class_ID);
          }
          setTimeout(function() {
            if (response.rec.student_ID.indexOf(',') > -1){
              var stuff = [];
              $.each(response.rec.student_ID.split(','), function(i1,e1) {
                stuff.push(e1);
              });
              $('#listsOfpersonS').val(stuff).trigger('chosen:updated');
            }
            else
            {
              $('#listsOfpersonS').val(response.rec.student_ID).trigger('chosen:updated');
            }
            if(response.setting.self == 'Y')
            {
              $('.icheckbox_square-green input[name="student"]').iCheck('check');
            }
            if(response.setting.guardian1 == 'Y')
            {
              $('.icheckbox_square-green input[name="guardian1"]').iCheck('check');
            }
            if(response.setting.guardian2 == 'Y')
            {
              $('.icheckbox_square-green input[name="guardian2"]').iCheck('check');
            }
            $('#send_type').val(response.setting.send_type);
            $('#tbl_name').val('CL');
            $('#tbl_ID').val(id);
            if(response.setting.send_type == 'individual')
            {
              setTimeout(function() {
                $('#smsMobile select option[value="Manual"]').prop('selected', true).trigger('chosen:updated');
                getTypeMEssages('Manual');
                $('#smsMobile textarea[name="message"]').val(static_message);
                $('#smsMobile textarea[name="message"]').attr('readonly',true);
                setTimeout(function() {
                  $('#smsGateway select option[value="Manual"]').prop('selected', true).trigger('chosen:updated');
                  $('#messagess1').html('<div class="col-sm-12"><div class="form-group"><label class="font-noraml">Message</label><div><textarea class="form-control" placeholder="Message" name="message" readonly>'+static_message+'</textarea></div></div></div><div class="col-sm-12 text-center"><a class="btn btn-primary btn-lg btn-outline" onclick="sendMsg(\'gateway\',\'gateway\')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a></div>');
                  $('#EmailCommunicate textarea[name="message"]').val(static_message);
                  $('#EmailCommunicate textarea[name="message"]').attr('readonly',true);
                }, 500);
              }, 500);
            }
            else
            {
              setTimeout(function() {
                $('#smsMobile select option[value="Manual"]').prop('selected', true).trigger('chosen:updated');
                getTypeMEssages('Manual');
                $('#smsMobile textarea[name="message"]').val(response.setting.sms_mobile);
                setTimeout(function() {
                  $('#smsGateway select option[value="Manual"]').prop('selected', true).trigger('chosen:updated');
                  $('#messagess1').html('<div class="col-sm-12"><div class="form-group"><label class="font-noraml">Message</label><div><textarea class="form-control" placeholder="Message" name="message">'+response.setting.sms_gateway+'</textarea></div></div></div><div class="col-sm-12 text-center"><a class="btn btn-primary btn-lg btn-outline" onclick="sendMsg(\'gateway\',\'gateway\')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a></div>');
                  $('#EmailCommunicate textarea[name="message"]').val(response.setting.email);
                }, 500);
              }, 500);
            }
          }, 500);
        }, 500);
      }
    });
    $('#comunicationModal').modal('show');
  }
</script>