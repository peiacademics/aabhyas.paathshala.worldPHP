<div class="page-content">
  <div class="wrap">
    <div class="ibox">
      <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Syllabus Coverage <code>'.$this->str_function_library->call('fr>ST>Name:ID=`'.$student_ID.'`')).'</code>'); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content table-responsive">
        <div class="tabs-container">
          <ul class="nav nav-tabs">
          <?php reset($subjects['sub']);
          $first_key = key($subjects['sub']); ?>
          <input type="hidden" id="f_sub" value="<?php echo $first_key; ?>">
          <?php
          if(($subjects['sub'] != NULL) && !empty($subjects['sub']) && ($subjects['sub'] != FALSE) && (@$subjects['sub']['-NA-'] != '-NA-')) {
            foreach ($subjects['sub'] as $key => $value) { ?>
            <li id="list-<?php echo $key; ?>"><a data-toggle="tab" href="#tab-<?php echo $key; ?>" aria-expanded="true"><i class="fa fa-trophy"></i> <?php echo $value; ?></a></li>
           <?php } } else { ?>
            <li id="list-0">No Records Found</li>
           <?php } ?>
          </ul>
          <div class="tab-content">

            <?php if(($subjects['sub'] != NULL) && !empty($subjects['sub']) && ($subjects['sub'] != FALSE) && (@$subjects['sub']['-NA-'] != '-NA-')) {
            foreach ($subjects['sub'] as $key => $value) { ?>
            <div id="tab-<?php echo $key; ?>" class="tab-pane">
              <div class="panel-body">
                <form class="form-horizontal" role="form" action="#" method="post" id="remark_add-<?php echo $key; ?>">
                <input type="hidden" name="subject_ID" value="<?php echo $key; ?>">
                <input type="hidden" id="student_ID" name="student_ID" value="<?php echo $student_ID; ?>">
                <div class="table-responsive">
                  <table id="example-<?php echo $key; ?>" class="table table-striped" cellspacing="0">
                    <thead>
                      <tr id="row-<?php echo $key; ?>">
                        <th>Chapter</th>
                        <th>Topic</th>
                        <th>Professor</th>
                        <th>Date</th>
                        <?php $i = 4; ?>
                        <?php if($subjects[$key]['self_study'] != NULL) {
                          foreach ($subjects[$key]['self_study'] as $keyss => $valuess) { 
                            if($valuess != NULL) { 
                              $i++; ?>
                            <th><?php echo $valuess['self_study']; ?><input type="hidden" id="columnSK-<?php echo $i; ?>" value="<?php echo $valuess['ID']; ?>"></th>
                        <?php } } } ?>
                        <input type="hidden" id="col_count" value="<?php echo $i; ?>">
                      </tr>
                      <button type="button" class="btn btn-outline btn-warning btn-xs btn-circle pull-right" onClick="add_column('<?php echo $key; ?>');"><i class="fa fa-plus"></i></button>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td class="text-center" id="save_form" colspan="<?php echo $i; ?>">
                          <button type="button" class="btn btn-primary btn-lg" onClick="save_data('remark_add-<?php echo $key; ?>')">Save</button>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                </form>
              </div>
            </div>
            <?php } } else { ?>
              <div class="row col-sm-12 text-center text-danger">
                <strong>No records found ...</strong>
              </div>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal inmodal in" id="student_attendace" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg m-lgg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Syllabus Coverage <span id="subject"></span></h4>
      </div>
      <div class="modal-body">
        <form id="records" method="post" action="<?php //echo base_url("Stock/stockBook");?>">
          <div id="student_record" class="row"></div>
        </form>
      </div><!-- /.modal-content -->
      <div class="modal-footer">
        <div class="text-center">
          <button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
          </button>
        </div>
      </div>
    </div><!-- /.modal-dialog -->
  </div>
</div>

<div class="modal inmodal in" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Test Record</h4>
      </div>
      <div class="modal-body">
        <div id="assignment_record" class="row"></div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
</div>

<div class="modal inmodal in" id="column_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add Self Study</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <label class="col-sm-6">Self Study : </label>
            <div class="col-sm-6">
              <input type="hidden" id="id" />
              <input type="text" id="column" />
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
      <div class="modal-footer">
        <div class="row col-sm-12 text-center">
          <button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal"> Close</button> 
          <button type="button" id="save_col" class="btn btn-lg btn-primary"> Save</button>
        </div>
      </div>
    </div><!-- /.modal-dialog -->
  </div>
</div>

<div class="modal inmodal in" id="remark_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add Professor Remark</h4>
      </div>
      <form id="status_add" method="post" action="<?php //echo base_url("Stock/stockBook");?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <label class="col-sm-6">Select Status : </label>
            <div class="col-sm-6">
              <input type="hidden" id="remark_ID" name="remark_ID" />
              <select class="chosen-select form-control" name="checked_status" id="checked_status" required>
                <option value="accepcted">Accept</option>
                <option value="rejected">Reject</option>
              </select>
            </div>
            <br><br>
            <label class="col-sm-6">Grade : </label>
            <div class="col-sm-6 input-group">
              <input type="number" class="form-control" name="grade" id="grade" placeholder="Enter Grade" min="0" max="10">
              <span class="input-group-addon" id="basic-addon2">/10</span>
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
      </form>
      <div class="modal-footer">
        <div class="row col-sm-12 text-center">
          <button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal"> Close</button> 
          <button type="button" id="save_status" class="btn btn-lg btn-primary"> Save</button>
        </div>
      </div>
    </div><!-- /.modal-dialog -->
  </div>
</div>

<div class="modal inmodal in" id="append_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add Additional Study</h4>
      </div>
      <form id="study_add" method="post" action="">
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <label class="col-sm-6">Additional Study : </label>
            <div class="col-sm-6">
              <input type="hidden" id="rem_ID" name="rem_ID" />
              <textarea id="append_remark" name="append_remark" placeholder="Enter Study done." required></textarea>
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
      </form>
      <div class="modal-footer">
        <div class="row col-sm-12 text-center">
          <button type="button" id="close_remark" class="btn btn-lg btn-danger" data-dismiss="modal"> Close</button> 
          <button type="button" id="save_remark" class="btn btn-lg btn-primary"> Save</button>
        </div>
      </div>
    </div><!-- /.modal-dialog -->
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
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#status_add").validate();
    $("#study_add").validate();
    var first_key = $('#f_sub').val();
    $('#list-'+first_key).addClass('active');
    $('#tab-'+first_key).addClass('active');
    var student_ID = $('#student_ID').val();
    <?php foreach ($subjects['sub'] as $key => $value) {?>
      var subject_ID = '<?php echo $key; ?>';
      $.ajax({
        type:'POST',
        data:{'student_ID':student_ID, 'subject_ID':subject_ID},
        url: '<?php echo base_url(); ?>'+'syllabus_coverage/student_syllabus/',
        success:function(response)
        {
          var data = '';
          response = JSON.parse(response);
          var i = 0;
          $.each(response.cols, function(key,value){
            data += '<tr><td><input type="hidden" id="sc_row-<?php echo $key; ?>-'+i+'" value="'+value.ID+'">'+value.chapter+'</td><td>'+value.topic+'</td><td>'+value.proff_ID+'</td><td>'+value.date+'</td>';
            if(value.self_study.length > 0)
            {
              $.each(value.self_study, function(key1,value1){
                if(value1.remarks.length > 0)
                {
                  $.each(value1.remarks, function(key2,value2){ 
                    data += '<td><textarea disabled>'+value2.remark.replace('<br>','\n')+'</textarea><br><input type="hidden" id="'+value2.ID+'">';
                    if(value2.checked_status == 'accepcted')
                    {
                      data += '<button type="button" id="btn-'+value2.ID+'" class="btn btn-sm btn-success btn-circle"><i class="fa fa-check" aria-hidden="true"></i></button>';
                    }
                    else if(value2.checked_status == 'rejected')
                    {
                      data += '<button type="button" id="btn-'+value2.ID+'" class="btn btn-sm btn-danger btn-circle"><i class="fa fa-times" aria-hidden="true"></i></button>';
                    }
                    else
                    {
                      <?php if(($this->data['Login']['Login_as'] != 'DSSK10000011') && ($this->data['Login']['Login_as'] != 'DSSK10000012')) { ?>
                        data += '<button type="button" id="btn-'+value2.ID+'" class="btn btn-sm btn-primary btn-circle" onClick="checked_status(\''+value2.ID+'\')"><i class="fa fa-plus" aria-hidden="true"></i></button>';
                        data += '<button type="button" id="btne-'+value2.ID+'" class="btn btn-sm btn-warning btn-circle" onClick="append_remark(\''+value2.ID+'\')"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                      <?php } ?>
                    }
                    data += '</td>';
                  });
                }
                else
                {
                  data += '<td><textarea placeholder="Enter study done." name="remark_ID='+value.ID+'-'+value1.ID+'"></textarea></td>';
                }
              });
              data += '</tr>';
            }
            i++;
          });
          $('#example-<?php echo $key; ?>').append(data);
        }
      });
    <?php } ?>
  });
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
            toastr.error("Something went wrong!");
          }
        }
      });
    }
  });
}

function test_attendace(id)
{
  // var base_url = '<?php echo base_url(); ?>';
  $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
  $("#Login_screen").fadeIn('fast');
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'syllabus_coverage/student_attendace/'+id,
    success:function(response)
    {
      var data = '<div class="col-sm-12">';
      if(response != '')
      {
        response = JSON.parse(response);
        $('#subject').html('('+response.subject+')');
        data += '<div class="col-sm-6"><div class="ibox float-e-margins"><div class="ibox-title"><h5>Student referred book</h5></div><div class="ibox-content"><div><div class="feed-activity-list">';
        if(response.present != null)
        {
          $.each(response.present, function(key,value){
            data += '<div class="feed-element"><a href="'+base_url+'student/view/'+value.ID+'" class="pull-left"><img alt="image" class="img-circle" src="'+base_url+value.path+'"></a><div class="media-body "><strong>'+value.name+'</strong></div></div>';
          });
        }
        else
        {
          data += '<span class="text-danger h1">No records found</span>';
        }
        data += '</div></div></div></div></div>';
        data += '<div class="col-sm-6"><div class="ibox float-e-margins"><div class="ibox-title"><h5>Student not referred book</h5></div><div class="ibox-content"><div><div class="feed-activity-list">';
        if(response.absent != null)
        {
          $.each(response.absent, function(key,value){
            data += '<div class="feed-element"><a href="#'+value.ID+'" class="pull-left"><img alt="image" class="img-circle" src="'+base_url+value.path+'"></a><div class="media-body "><strong>'+value.name+'</strong></div></div>';
          });
        }
        else
        {
          data += '<span class="text-danger h1">No records found</span>';
        }
        data += '</div></div></div></div><div>';
      }
      else
      {
        data += '<tr><td colspan="6" class="text-center"><span class="text-danger h1">No records found</span></td></tr></tbody>';
      }
      data += '</div>';
      // $('#sub').html(response.subject);
      $('#student_record').html(data);
      $('#student_attendace').modal('show');
      $("#Login_screen").fadeOut(2000);
    }
  });
}

function save_attendance()
{
  $("#records").validate();
  var fdata = $('#records').serialize();
  $.ajax({
    type:'POST',
    data:fdata,
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'syllabus_coverage/save_attendance',
    success:function(response)
    {
      $('#student_attendace').modal('hide');
      if(response == true)
      {
        toastr.success('Data saved Successfully.');
      }
      else
      {
        toastr.error("Something went wrong!");
      }
    }
  });
}

function view(id)
{
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'syllabus_coverage/view/'+id,
    success:function(response)
    {
      var data = '<table class="table table-responsive table-striped table-bordered" width="100%"><tbody>';
      if(response != '')
      {
        response = JSON.parse(response);
        data += '<tr><td><strong>Subject</strong></td><td>'+response.subject_ID+'</td></tr>';
        data += '<tr><td><strong>Chapter</strong></td><td>';
        data += response.chapter == null ? '' : response.chapter+'</td></tr>';
        data += '<tr><td><strong>Topic</strong></td><td>';
        data += response.topic == null ? '' : response.topic+'</td></tr>';
        data += '<tr><td><strong>Test Name</strong></td><td>';
        data += response.title == null ? '' : response.title+'</td></tr>';
        data += '<tr><td><strong>Test Date</strong></td><td>';
        data += response.test_date == null ? '' : response.test_date+'</td></tr>';
        data += '<tr><td><strong>Details</strong></td><td>';
        data += response.description == null ? '' : response.description+'</td></tr>';
        data += '<tr><td><strong>Maximum Marks</strong></td><td>';
        data += response.max_marks == null ? '' : response.max_marks+'</td></tr>';
        data += '<tr><td colspan="2" class="text-center"><strong>Students</strong></td></tr><tr><td colspan="2">';
        data += '<div class="col-sm-12"><div class="ibox"><div class="ibox-content"><div class="input-group"><input type="text" placeholder="Search Student" id="search" class="input-sm form-control"><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button></span></div><div class="clients-list"><div class="tab-content"><div class="full-height-scroll"><div class="table-responsive"><table class="table table-striped table-hover" id="table"><tbody>';
        $.each(response.students, function(key,value){
          data += '<tr><td><img class="client-avatar" alt="image" src="'+base_url+value.path+'"> '+value.student+'</td></tr>';
        });
        data += '</tbody></table></div></div></div></div></div></div></div></td></tr>';
        data += '</tbody>';
      }
      else
      {
        data += '<tr><td colspan="2" class="text-center"><span class="text-danger h1">No records found</span></td></tr></tbody>';
      }
      data += '<tfooter><tr><td colspan="2" class="text-center"><button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button></td></tr></tfooter></table>';
      $('#assignment_record').html(data);
      $('#view_modal').modal('show');
      $("#search").keyup(function(){
        _this = this;
        $.each($("#table tbody tr"), function() {
          if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    }
  });
}

function add_column(id)
{
  $('#id').val(id);
  $('#column').val('');
  $('#column_modal').modal('show');
}

$('#save_col').on('click', function() {
  var id = $('#id').val();
  var count = $('#col_count').val();
  var column = $('#column').val();
  var sc_row = '';
  var i = 0;
  $('#example-'+id+' tbody tr').append($("<td>"));
  $('#row-'+id).append('<th>');
  $('#row-'+id).append('<input type="hidden" name="columnSK-'+count+'" value="'+column+'">');
  $('#row-'+id+'>th:last').html(column);
  $('#example-'+id+' tbody tr').each(function(){
    sc_row = $('#sc_row-'+id+'-'+i).val();
    $(this).children('td:last').append($('<textarea name="self='+sc_row+'-'+i+'" class="form-control">'));
    i++;
  });
  count++;
  $('#col_count').val(count);
  $('#save_form').attr('colspan',count);
  $('#column_modal').modal('hide');
});

function save_data(form_id)
{
  $("#"+form_id).validate();
  var fdata = $('#'+form_id).serialize();
  $.ajax({
    type:'POST',
    data:fdata,
    url: '<?php echo base_url(); ?>'+'syllabus_coverage/add_remark/',
    success:function(response)
    {
      if(response == 'true')
      {
        toastr.success('Successfully saved.');
        setTimeout(function(){
          window.location.href = "<?php echo current_url(); ?>";
        }, 3000);
      }
      else
      {
        toastr.error("Something went wrong!");
      }
    }
  });
}

function checked_status(id)
{
  $('#remark_ID').val(id);
  $('#remark_modal').modal('show');
}

$('#save_status').on('click', function() {
  if($("#status_add").valid() == true)
  {
    var ID = $('#remark_ID').val();
    var checked_status = $('#checked_status').val();
    var grade = $('#grade').val();
    var student = $('#student_ID').val();
    $.ajax({
      type:'POST',
      data:{'id':ID,'status':checked_status,'grade':grade,'student_ID':student},
      url: '<?php echo base_url(); ?>'+'syllabus_coverage/change_checked_status/',
      success:function(response)
      {
        response = JSON.parse(response);
        if(response.bool == true)
        {
          if(response.status == 'accepcted')
          {
            $('#btn-'+ID).addClass('btn btn-success');
            $('#btn-'+ID).removeAttr('onClick');
            $('#btn-'+ID).html('<i class="fa fa-check" aria-hidden="true"></i>');
          }
          else
          {
            $('#btn-'+ID).addClass('btn btn-danger');
            $('#btn-'+ID).removeAttr('onClick');
            $('#btn-'+ID).html('<i class="fa fa-times" aria-hidden="true"></i>');
          }
          $('#remark_modal').modal('hide');
          toastr.success('Data saved Successfully.');
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  }
  else
  {
    toastr.error("Enter proper value!");
  }
});

function append_remark(id)
{
  $('#rem_ID').val(id);
  $('#append_remark').val('');
  $('#append_modal').modal('show');
}

$('#save_remark').on('click', function() {
  if($("#study_add").valid() == true)
  {
    var ID = $('#rem_ID').val();
    var checked_status = $('#append_remark').val();
    $.ajax({
      type:'POST',
      data:{'id':ID,'remark':checked_status},
      url: '<?php echo base_url(); ?>'+'syllabus_coverage/append_remark/',
      success:function(response)
      {
        response = JSON.parse(response);
        if(response == true)
        {
          $('#append_modal').modal('hide');
          toastr.success('Data saved Successfully.');
          setTimeout(function(){
            window.location.reload();
          }, 1000);
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  }
  else
  {
    toastr.error("Enter proper value.");
  }
});
</script>