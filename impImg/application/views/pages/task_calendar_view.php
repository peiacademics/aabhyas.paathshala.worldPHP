<!-- <div class="form-group"> -->
	<!-- <label for="DOB" class="col-sm-2 control-label flt-left">Select Batch :</label> -->
	<!-- <div class="col-sm-9 text-left"> -->
    <input type="hidden" id="branch_ID" value="<?php echo $ID; ?>">
	  <!-- <select class="form-control chosen-select" name="language" id="batch" onchange="getClass(this)" required>
	  </select> -->
	<!-- </div> -->
	<!-- <span id="Gender"></span> -->
	<!-- <br> -->
	<!-- <br> -->
<!-- </div> -->
<div class="row">
  <div class="ibox-content">
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
            url: base_url+'task/lists/'+branch_ID,
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
            fetchEventbyDatesforClass(date.format());
        },
        eventClick: function(calEvent, jsEvent, view) {
            $('#dateAssign').val(calEvent.start._i);
            $(this).css('border-color', 'red');
            date = calEvent.start._i.split(" ");
            fetchEventbyDatesforClass(date[0],calEvent.id);
        },
        events: [

        ],
         eventRender: function(event, element) {
             if (event.task_status==='Completed') {
                bClass = "btn-warning";
                bfClass = "fa-check";
             }
             else
             {
                bClass = "btn-primary";
                bfClass = "fa-clock-o";
             }
              element.find('.fc-time').html('');
              element.find('.fc-title').html('<button id="'+event.id+'" class="btn '+bClass+' btn-circle" type="button"><i class="fa '+bfClass+'"></i></button><b>'+event.title+'</b>');
                if (event.imageurl) {
                    element.find("div.fc-content").prepend("<img src='" + base_url+event.imageurl +"' width='30' class='crlwName'>");
                }
        }
    });


function fetchEventbyDatesforClass(date,id=null) {
    var branch_ID = $('#branch_ID').val();
    $.ajax({
        type:'POST',
        data:{Date:date},
        dataType:'json',
        url: base_url+'task/calendarTasks/'+branch_ID,
        success:function(response)
        {
            if (typeof response==='object') {
                showClassData(response,id);
                // $('input[name="branch_ID"]').val(branch_ID);
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

    getChosenData('taskType','TT',[{'label':'title','value':'ID'}],[{'Status':'A'}]);
}

function showClassData(response ,id) {
  $('#classesAssigned').html('');
  var base_url = "<?php echo base_url(); ?>"
  if (response !== null) {
    data ='';
    $.each(response,function(key,val) {
      if('<?php echo $Login['Login_as']; ?>' == 'DSSK10000001')
      {
        // alert(val.task_status);
        var check = (val.task_status == 'Pending') ? " <button type='button' "+stat+" class='pull-center "+stat+" btn btn-info btn-xs' onClick='mark_completed(\""+val.id+"\");'><i class='fa fa-check'></i> Mark as Completed </button>" :' <span class="pull-center label label-success"> Completed </span>';
      }
      else{
        var check = (val.task_status == 'Pending') ? ' <span class="pull-center label label-warning"> Pending </span>' : ' <span class="pull-center label label-success"> Completed </span>';
      }
      data += check+'';
      data += "<div class='feed-element' id='classes"+val.id+"'><a href='#' class='pull-left'><img alt='image' class='img-circle' src='"+base_url+val.imageurl+"'></a><div class='media-body'><small class='pull-right'></small><a href='"+base_url+"Team/view/"+val.Added_by+"'><strong>"+val.name+"</strong></a> scheduled task <strong>"+val.title+"</strong> on <strong class='text-primary'>"+moment(val.date).format("MMMM Do YYYY, h:mm a")+"</strong>";
      data += (val.dept == '-NA-') ? "" : " for <strong>"+val.dept+"</strong>.";
      data +="<br><small class='text-muted'>";
      data += (val.description == null) ? "" : val.description;

      data += "</small>";
      var stat = (val.task_status == 'Pending') ? '' :'disabled';
      data += "<div class='pull-right'><button type='button' "+stat+" class='"+stat+" btn btn-primary btn-xs' onClick='add_comment(\""+val.id+"\");'><i class='fa fa-comment'></i> comment</button></div>";

      data += "<div class='feed-activity-list'>";
      if((val.comments != false) && (val.comments != '') && (val.comments != null))
      {
        data += "<br><br>";
        $.each(val.comments, function(key1, val1) {
          data += "<div class='feed-element ibox-heading'><a href='"+base_url+val1.ID+"' class='pull-left'><img alt='image' class='img-circle' src='"+base_url+val1.pathr+"'></a><strong class='text-success'>"+val1.namer+"</strong> commented<br><small class='text-muted'>"+moment(val1.Added_on).format("MMMM Do YYYY, h:mm a")+"</small><div class='well'>"+val1.comment+"</div></div>";
        });
      }
      data += "</div></div></div>";
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
    $('#classesAssigned').html('<div class="feed-element text-danger"><h1><strong>No Tasks Today</strong></h1></div>');
  }
}

function scroll(id) {
  $('html,body').animate({
        scrollTop: $(id).offset().top-500},
        'slow');
}

$(document).ready(function() {
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
        url: base_url+'task/addCalendarTask',
        success:function(result)
        {
          if(result === true)
          {
            fetchCalDataClass();
            toastr.success('Successfully Saved.');
            setTimeout(function(){
              $('#classModal')
                .find("input,textarea,select")
                  .val('')
                    .end();
              $('#classModal').modal("hide");
            }, 500);
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
})
</script>

<div class="modal inmodal fade" id="comment_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-danger">Comment</h4>
                <b><small  class="text-danger">add</small></b>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-lg-12">
                    <form id="form_comment" class="wizard-big" method="post" action="#">
                      <input type="hidden" name="calender_task_ID" id="calender_task_ID">
                      <input type="hidden" id="date_ID">
                      <div class="row">
                        <div class="form-group">
                          <label for="number" class="col-sm-3 control-label">Comment :</label>
                          <div class="col-sm-9">
                            <textarea type="text" class="form-control" id="comment" name="comment" placeholder="Comment" required></textarea>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="text-center">
                        <button type="button" id="save_comment" class="btn btn-success btn-facebook btn-outline">
                          <i class="fa fa-plus"> </i> Save
                        </button>
                      </div>
                    </form>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>

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
                                    <div class="row text-center">
                                      <button type="button" class="btn btn-danger btn-lg btn-outline" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                              <div id="tab-5" class="tab-pane">
                                  <div class="panel-body">
                                    <form id="form" class="wizard-big" method="post" action="#">
                                    <input type="hidden" name="date" id="dateClasss">
                                    <input type="hidden" id="branchID" name="branch_ID" value="<?php echo $this->uri->segment(3); ?>">
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Title :</label>
                                        <div class="col-sm-9">
                                          <input type="text" class="form-control" name="title" placeholder="Title" id="topic" value="" required>
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Description :</label>
                                        <div class="col-sm-9">
                                          <textarea type="text" class="form-control" id="description" name="description" placeholder="Description" value=""></textarea>
                                          <input type="hidden" name="type" id="type" value="add">
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                  <div class="form-group">
                                    <label for="number" class="col-sm-2 control-label">Department :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="task_type_ID" id="taskType" >
                                        </select>
                                    </div>
                                  </div>
                                    </div>
                                    <br>

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

  function edit(res)
  {
    $('#tab_show').removeClass('active');
    $('#tab_add').addClass('active');
    $('#ID').val(res.id);
    $('#Date').val(res.start_date+' - '+res.end_date);
    $('#Time').val(res.time);
    $('#classs').val(res.class_ID).trigger('chosen:updated');
    $('#prof').val(res.professor).trigger('chosen:updated');
    $('#sub').val(res.subject).trigger('chosen:updated');
    $('#chapter').val(res.chapter);
    $('#topic').val(res.topic);
    $('#description').val(res.description);
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
    $('#description').text('');
    $('#add_Classesed').text('Add');
    $('#type').val('add');
  });

  function add_comment(task_id)
  {
    $('#calender_task_ID').val(task_id);
    $('#comment').val('');
    $('#comment_modal').modal('show');
    $('#classModal').modal('hide');
  }

  function mark_completed($task_id)
  {
    var branch_ID = $('#branch_ID').val();
    var date = $('#dateClasss').val();
    $.ajax({
      type:'POST',
      dataType:'json',
      url: base_url+'task/mark_completed/'+$task_id,
      success:function(result)
      {
        if(result == true)
        {
          toastr.success('Marked Completed.');
          fetchEventbyDatesforClass(date, branch_ID);
          fetchCalDataClass();
          $('#comment_modal').modal('hide');
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  }

  $("#save_comment").on('click',function(e){
    var branch_ID = $('#branch_ID').val();
    var date = $('#dateClasss').val();
    var fdata = $('#form_comment').serialize();
    $.ajax({
      type:'POST',
      data:fdata,
      dataType:'json',
      url: base_url+'task/add_comment',
      success:function(result)
      {
        if(result == true)
        {
          toastr.success('Saved Successfully.');
          fetchEventbyDatesforClass(date, branch_ID);
          $('#comment_modal').modal('hide');
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  });
</script>