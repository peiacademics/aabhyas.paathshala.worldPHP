<div class="page-content">
  <div class="row">
    <div class="pull-right">
     <a href="<?php echo base_url('assignment/add/'.$branch_ID); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add assignment</button></a>
    </div>
    <div class="ibox">
      <!-- <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Assignments')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div> -->
      <div class="ibox-content table-responsive">
        <!-- <div class="<?php echo ($this->data['Login']['Login_as'] == 'DSSK10000011') ? 'hidden' : ''; ?>">
          <a href="<?php echo base_url('assignment/add/'.$branch_ID); ?>" class="btn btn-w-m btn-primary">Add Assignment</a>
        </div>
        <hr> -->
        <input type="hidden" id="branch_ID" value="<?php echo $branch_ID; ?>">
        <div id="data_table" class="row">
          <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Assignment Name</th>
                <th>Chapter</th>
                <th>Topic</th>
                <th>Submission Date</th>
                <th>Subject</th>
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

<div class="modal inmodal in" id="student_attendace" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg m-lgg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Attendance</h4>
      </div>
      <div class="modal-body">
        <form id="records" method="post" action="<?php //echo base_url("Stock/stockBook");?>">
          <div id="student_record" class="row"></div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
</div>

<div class="modal inmodal in" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Assignment Record</h4>
      </div>
      <div class="modal-body">
        <div id="assignment_record" class="row"></div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
</div>

<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script> -->
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
<script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var branch_ID = $('#branch_ID').val();
    var login_as = '<?php echo $this->data['Login']['Login_as']; ?>';
    oTable = $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?php echo base_url('assignment/get_show_data'); ?>"+'/'+branch_ID,
       dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('.dt-buttons').css({'float':'right'});
    setInterval(function(){
      if(login_as == 'DSSK10000011')
      {
        $('.label-danger').addClass('hidden');
      }
    }, 100);
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

function student_attendace(id)
{
  var login_as = '<?php echo $this->data['Login']['Login_as']; ?>';
  $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
  $("#Login_screen").fadeIn('fast');
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'assignment/student_attendace/'+id,
    success:function(response)
    {
      var data = '<table class="table table-responsive table-striped table-bordered" width="100%"><thead><tr><th class="text-center">Sr. No.</th><th class="text-center">Name</th><th class="text-center">Status</th><th class="text-center">Latency Reason</th><th class="text-center">Remark</th></tr></thead><tbody>';
      if(response != '')
      {
        response = JSON.parse(response);
        var i = 1;
        $.each(response, function(key,value){
          data += '<tr><td><input type="hidden" id="as_ID-'+i+'" name="as_ID-'+i+'" value="'+value.ID+'">'+i+'</td><td>'+value.name+'</td>';
          data += '<td><select class="chosen-select" id="asgn_status-'+i+'" name="asgn_status-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '><option value="submitted" ';
          data += value.asgn_status == 'submitted' ? "selected" : "";
          data += '>Submitted</option><option value="not_submitted" ';
          data += value.asgn_status == 'not_submitted' ? "selected" : "";
          data += '>Not Submitted</option></select></td>';
          data += '</td><td><textarea name="late-'+i+'" id="late-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '>';
          data += value.late == null ? '' : value.late;
          data += '</textarea></td><td><textarea name="remark-'+i+'" id="remark-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data +='>';
          data += value.remark == null ? '' : value.remark;
          data += '</textarea></td></tr>';
          i++;
        });
        data += '</tbody><tfooter><tr><td colspan="5" class="text-center"><button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button> <button type="button" id="trnsc" class="btn btn-lg btn-primary" onClick="save_attendance();">Save</button> <button id="cmt" type="button" class="btn btn-lg btn-success hidden" onClick="commun(\''+id+'\');">Communicate</button></td></tr></tfooter>';
      }
      else
      {
        data += '<tr><td colspan="5" class="text-center"><span class="text-danger h1">No records found</span></td></tr></tbody>';
      }
      data += '</table>';
      $('#student_record').html(data);
      $('#student_attendace').modal('show');
      $("#Login_screen").fadeOut(1000);
      $('.chosen-select').chosen();
    }
  });
}

function save_attendance()
{
  var fdata = $('#records').serialize();
  $.ajax({
    type:'POST',
    data:fdata,
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'assignment/save_attendance',
    success:function(response)
    {
      if(response == true)
      {
        $('#cmt').removeClass('hidden');
        toastr.success("Saved data successfully");
      }
      else
      {
        $('#cmt').addClass('hidden');
        toastr.error("Something went wrong!");
      }
    }
  });
}

function view(id)
{
  var base_url = '<?php echo base_url(); ?>';
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'assignment/view/'+id,
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
        data += '<tr><td><strong>Assignment Name</strong></td><td>';
        data += response.title == null ? '' : response.title+'</td></tr>';
        data += '<tr><td><strong>Submission Date</strong></td><td>';
        data += response.submission_date == null ? '' : response.submission_date+'</td></tr>';
        data += '<tr><td><strong>Details</strong></td><td>';
        data += response.description == null ? '' : response.description+'</td></tr>';
        data += '<tr><td colspan="2" class="text-center"><strong>Students</strong></td></tr><tr><td colspan="2">';
        data += '<div class="col-sm-12 hideStudent"><div class="ibox"><div class="ibox-content"><div class="input-group"><input type="text" placeholder="Search Student" id="search" class="input-sm form-control"><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button></span></div><div class="clients-list"><div class="tab-content"><div class="full-height-scroll"><div class="table-responsive"><table class="table table-striped table-hover" id="table"><tbody>';
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
  // hideStudent
}

function commun(id)
{
  $.ajax({
    url:'<?php echo base_url("communicate/get_record"); ?>',
    method:'POST',
    data:{ID:id,rec_id:'CMSSK10000004',tbl:'AS'},
    datatype:'JSON',
    success:function(response){
      response = JSON.parse(response);
      $('#branch_added select option[value="'+response.rec.branch_ID+'"]').prop('selected', true).trigger("chosen:updated");
      $('#typeCom option[value="'+response.setting.type+'"]').prop('selected', true).trigger("chosen:updated");
      getTypeList(response.setting.type);
      setTimeout(function() {
        if (response.rec.batch_ID.indexOf(',') > -1){
          var batches2 = [];
          $.each(response.rec.batch_ID.split(','), function(i,e) {
            batches2.push(e);
          });
          $('#listsOfperson').val(batches2).trigger('chosen:updated');
          $.each(response.rec.batch_ID.split(','), function(i,e2) {
            personsToSendMsg(e2);
          });
        }
        else
        {
          $('#listsOfperson').val(response.rec.batch_ID).trigger('chosen:updated');
          personsToSendMsg(response.rec.batch_ID);
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
        }, 500);
      }, 500);
    }
  });
  $('#comunicationModal').modal('show');
}
</script>