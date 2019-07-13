<div class="row">
  <div class="ibox-content">
    <div class="form-group">
    	<label for="DOB" class="col-sm-2 control-label flt-left">Select Batch :</label>
    	<div class="col-sm-9 text-left">
        <input type="hidden" id="branch_ID" value="<?php echo $ID; ?>">
    	  <select class="form-control chosen-select" name="language" id="batch" onchange="getClass(this)" required>
    	  </select>
    	</div>
    	<span id="Gender"></span>
    	<br>
    	<br>
    </div>

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
            fetchEventbyDatesforClass(date.format(),$('#batch').val());
        },
        eventClick: function(calEvent, jsEvent, view) {
            $('#dateAssign').val(calEvent.start._i);
            $(this).css('border-color', 'red');
            date = calEvent.start._i.split(" ");
            fetchEventbyDatesforClass(date[0],$('#batch').val(),calEvent.id);
        },
        events: [

        ],
         eventRender: function(event, element) {
             if (event.description==='Completed') {
                bClass = "btn-warning";
                bfClass = "fa-check";
             }
             else
             {
                bClass = "btn-primary";
                bfClass = "fa-spinner fa-pulse";
             }
              element.find('.fc-time').html('');
              element.find('.fc-title').html('<button id="'+event.id+'" class="btn '+bClass+' btn-circle" type="button"><i class="fa '+bfClass+'"></i></button><b>'+event.title+'</b>');
                if (event.imageurl) {
                    element.find("div.fc-content").prepend("<img src='" + base_url+event.imageurl +"' width='30' class='crlwName'>");
                }
        }
    });


function fetchEventbyDatesforClass(date,classs,id=null) {
    var branch_ID = $('#branch_ID').val();
    $.ajax({
        type:'POST',
        data:{Date:date,Class_ID:classs},
        dataType:'json',
        url: base_url+'batch/classes/'+branch_ID,
        success:function(response)
        {
            if (typeof response==='object') {
                showClassData(response,id);
                $('#classModal').modal("show");
                $('#dateClass').text(date);
                $('#dateClasss').val(date);
                $('#branchID').val('<?php echo $ID; ?>');
            }else
            if (response===false) {
                $('#MainTask1').removeAttr('style');
                $('.whTask1').removeAttr('style');
                $('#classModal').modal("show");
                $('#dateClass').text(date);
                $('#dateClasss').val(date);
                $('#branchID').val('<?php echo $ID; ?>');
                $('#classesAssigned').html('<h4><code>No Task Found</code></h4>');
            }
            else
            {
                alert('not satisfied');
                $('#MainTask1').removeAttr('style');
                $('.whTask1').removeAttr('style');
                $('#classModal').modal("show");
            }
        }
      });
    getChosenData('prof','US',[{'label':'Name','value':'ID'}],[{'Status':'A','branch_ID':branch_ID}]);
    getChosenData('sub','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}]);
    getChosenData('classs','BT',[{'label':'name','value':'ID'}],[{'Status':'A','Branch_ID':branch_ID}]);
    $('#classs').append('<option value="all">All</option>');
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
          if(result === true)
          {
            fetchCalDataClass();
             toastr.success('Successfully Saved.');
             setTimeout(function(){
                $('#classModal').modal("hide");
            }, 1000);
          }
          else
          {
            if(typeof result === 'object')
            {
              mess = "";
              $.each(result,function(dom,err)
              {
                mess = mess+err+"\n";
                toastr.error(mess);
              });
            }
            else
            {
              toastr.error("Something went wrong!");
            }
          }
        }
      });
    }
  });

$('#classModal').on('hidden.bs.modal', function () {
  $('#classModal').find("input,textarea,select").val('').end();
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
                              <li id="tab_add"><a data-toggle="tab" href="#tab-5"><i class="fa fa-plus"></i> Add</a></li>
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
  			                                <label for="number" class="col-sm-2 control-label">Time :</label>
  			                                <div class="col-sm-9">
                                          <input type="text" class="form-control modalTime" id="Time" name="Time" placeholder="Time" value="" required>
                                          <input type="hidden" name="date" id="dateClasss" required>
  			                                  <input type="hidden" name="Branch_ID" id="branchID" value="<?php echo $ID; ?>" required>
  			                                </div>
  			                              </div>
  			                            </div>
  			                            <br>
  			                            <div class="row">
  			                              <div class="form-group">
  			                                <label for="number" class="col-sm-2 control-label">Class :</label>
  			                                <div class="col-sm-9">
  			                                  <select class="form-control chosen-select" id="classs" name="Class_ID" required onChange="get_all_students()">
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
  			                              </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Chapter :</label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" name="chapter" placeholder="Chapter" id="chapter" value="" required>
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Topics :</label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" name="topic" placeholder="Topics" id="topic" value="" required>
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Description :</label>
                                        <div class="col-sm-9">
                                          <textarea type="text" class="form-control" id="desc" name="description" placeholder="Description" value=""></textarea>
                                          <input type="hidden" name="type" id="type" value="add">
                                        </div>
                                      </div>
                                    </div>
                                    </form>
                                    <br>
                                    <div class="text-center">
                                      <button type="button" id="add_Classesed" class="btn btn-success btn-facebook btn-outline">
                                        <i class="fa fa-plus"> </i> Add
                                      </button>
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
</script>