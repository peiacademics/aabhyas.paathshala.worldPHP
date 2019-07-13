<div class="page-content">
  <div class="<?php echo ($this->data['Login']['Login_as'] == 'DSSK10000011' || $this->data['Login']['Login_as'] == 'DSSK10000012') ? 'hidden' : ''; ?>">
    <div class="pull-right">
       <a href="<?php echo base_url('parent_meeting/add/'.$branch_ID); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Parent Meeting</button></a>
    </div>
  </div>
  <div class="row">
    <div class="ibox">
      <!-- <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Parent Meetings')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div> -->
      <div class="ibox-content table-responsive">
        <div class="<?php echo ($this->data['Login']['Login_as'] == 'DSSK10000011') ? 'hidden' : ''; ?>">
          <!-- <a href="<?php echo base_url('parent_meeting/add/'.$branch_ID); ?>" class="btn btn-w-m btn-primary">Add Parent Meeting</a> -->
          <input type="hidden" id="branch_ID" value="<?php echo $branch_ID; ?>">
        </div>
        <div id="data_table" class="row">
          <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Topic</th>
                <th>Batch</th>
                <th>Date</th>
                <th>Description</th>
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
      <form id="records" method="post" action="<?php //echo base_url("Stock/stockBook");?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Attendance</h4>
      </div>
      <div class="modal-body row table-responsive" id="student_record">
      </div><!-- /.modal-content -->
      </form>
    </div><!-- /.modal-dialog -->
  </div>
</div>

<div class="modal inmodal in" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Parent Meeting Record</h4>
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
<script type="text/javascript">
  $(document).ready(function() {
    var branch_ID = $('#branch_ID').val();
    var login_as = '<?php echo $this->data['Login']['Login_as']; ?>';
    oTable = $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?php echo base_url('parent_meeting/get_show_data'); ?>"+'/'+branch_ID,
      dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('.dt-buttons').css({'float':'right'});
    setInterval(function(){
      if(login_as != 'DSSK10000001' && login_as != 'DSSK10000002' && login_as != 'DSSK10000004')
      {
        $('.label-danger').addClass('hidden');
        $('.label-primary').addClass('hidden');
        $('.label-default').addClass('hidden');
      }
    }, 100);
  });
  function deletef(id,href)
  {
    bootbox.confirm('Are you sure you want to delete?', function(result) {
      if(result == true)
      {
        $('body').prepend('<div id="Login_screen"><img src="'+IMAGE_PATH+'img/loader.gif"></div>');
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

function meeting_attendace(id)
{
  var login_as = '<?php echo $this->data['Login']['Login_as']; ?>';
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'parent_meeting/meeting_attendace/'+id,
    success:function(response)
    {
      var data = '<div class="table-responsive"><table class="table table-striped table-bordered" width="100%"><thead><tr><th class="text-center" width="8%">Sr. No.</th><th class="text-center" width="8%">Name</th><th class="text-center" width="8%">Presenty</th><th class="text-center" width="8%">Gaurgdian 1</th><th class="text-center" width="8%">Gaurgdian 2</th><th class="text-center" width="15%">Student Feedback</th><th class="text-center" width="15%">Parent Feedback</th><th class="text-center" width="15%">Paathshala Suggestions</th><th class="text-center" width="15%">Action Plan</th></tr></thead><tbody>';
      if(response != '')
      {
        response = JSON.parse(response);
        var i = 1;
        $.each(response, function(key,value){
          data += '<tr><td><input type="hidden" id="pma_ID-'+i+'" name="pma_ID-'+i+'" value="'+value.ID+'">'+i+'</td><td>'+value.name+'</td>';
          data += '<td><select class="chosen-select" id="present-'+i+'" name="present-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '><option value="Y" ';
          data += value.present == 'Y' ? "selected" : "";
          data += '>Present</option><option value="N" ';
          data += value.present == 'N' ? "selected" : "";
          data += '>Absent</option></select></td>';
          data += '<td><select class="chosen-select" id="parent_1-'+i+'" name="parent_1-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '><option value="Y" ';
          data += value.parent_1 == 'Y' ? "selected" : "";
          data += '>Present</option><option value="N" ';
          data += value.parent_1 == 'N' ? "selected" : "";
          data += '>Absent</option></select></td>';
          data += '<td><select class="chosen-select" id="parent_2-'+i+'" name="parent_2-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '><option value="Y" ';
          data += value.parent_2 == 'Y' ? "selected" : "";
          data += '>Present</option><option value="N" ';
          data += value.parent_2 == 'N' ? "selected" : "";
          data += '>Absent</option></select></td>';
          data += '<td><textarea class="form-control" name="student_feedback-'+i+'" id="student_feedback-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '>';
          data += value.student_feedback == null ? '' : value.student_feedback;
          data += '</textarea></td><td><textarea class="form-control" name="parent_feedback-'+i+'" id="parent_feedback-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '>';
          data += value.parent_feedback == null ? '' : value.parent_feedback;
          data += '</textarea></td>';
          data += '<td><textarea class="form-control" name="paathshala_suggestions-'+i+'" id="paathshala_suggestions-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '>';
          data += value.paathshala_suggestions == null ? '' : value.paathshala_suggestions;
          data += '</textarea></td><td><textarea class="form-control" name="action_plan-'+i+'" id="action_plan-'+i+'"';
          data += login_as == 'DSSK10000011' ? "disabled" : "";
          data += '>';
          data += value.action_plan == null ? '' : value.action_plan;
          data += '</textarea></td>';
          data += '</tr>';
          i++;
        });
        data += '</tbody><tfooter><tr><td colspan="9" class="text-center"><button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button> <button type="button" id="trnsc" class="btn btn-lg btn-primary" onClick="save_attendance();">Save</button> <button id="cmt" type="button" class="btn btn-lg btn-success hidden" onClick="commun(\''+id+'\');">Communicate Parent Meeting Details</button></td></tr></tfooter>';
      }
      else
      {
        data += '<tr><td colspan="5" class="text-center"><span class="text-danger h1">No records found</span></td></tr></tbody>';
      }
      data += '</table></div>';
      $('#student_record').html(data);
      $('#student_attendace').modal('show');
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
    url: '<?php echo base_url(); ?>'+'parent_meeting/save_attendance',
    success:function(response)
    {
      if(response == true)
      {
        $('#cmt').removeClass('hidden');
        toastr.success("Saved data successfully!");
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
  var login_as = '<?php echo $this->data['Login']['Login_as']; ?>';
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'parent_meeting/view/'+id,
    success:function(response)
    {
      var data = '<table class="table table-responsive table-striped table-bordered" width="100%"><tbody>';
      if(response != '')
      {
        response = JSON.parse(response);
        data += '<tr><td><strong>Meeting About</strong></td><td>';
        data += response.title == null ? '' : response.title+'</td></tr>';
        data += '<tr><td><strong>Meeting Date</strong></td><td>';
        data += response.date == null ? '' : response.date+'</td></tr>';
        data += '<tr><td><strong>Meeting Detail</strong></td><td>';
        data += response.description == null ? '' : response.description+'</td></tr>';
        data += '<tr><td colspan="2" class="text-center"><strong>Staff</strong></td></tr><tr><td colspan="2">';
        data += '<div class="col-sm-12"><div class="ibox"><div class="ibox-content"><div class="input-group"><input type="text" placeholder="Search Staff" id="search1" class="input-sm form-control"><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button></span></div><div class="clients-list"><div class="tab-content"><div class="full-height-scroll"><div class="table-responsive"><table class="table table-striped table-hover" id="table1"><tbody>';
        $.each(response.staffs, function(key1,value1){
          data += '<tr><td><img class="client-avatar" alt="image" src="'+IMAGE_PATH+value1.path+'"> '+value1.staff+'</td></tr>';
        });
        data += '</tbody></table></div></div></div></div></div></div></div></td></tr>';
        data += '<tr><td colspan="2" class="text-center"><strong>Students</strong></td></tr><tr><td colspan="2">';
        data += '<div class="col-sm-12"><div class="ibox"><div class="ibox-content"><div class="input-group"><input type="text" placeholder="Search Student" id="search" class="input-sm form-control"><span class="input-group-btn"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button></span></div><div class="clients-list"><div class="tab-content"><div class="full-height-scroll"><div class="table-responsive"><table class="table table-striped table-hover" id="table"><tbody>';
        $.each(response.students, function(key,value){
          data += '<tr><td><img class="client-avatar" alt="image" src="'+IMAGE_PATH+value.path+'"> '+value.student+'</td></tr>';
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
      $("#search1").keyup(function(){
        _this = this;
        $.each($("#table1 tbody tr"), function() {
          if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
      if(login_as == 'DSSK10000011' || login_as == 'DSSK10000012')
      {
        $('#cmt_add').addClass('hidden');
      }
    }
  });
}

function commun(id)
{
  $.ajax({
    url:'<?php echo base_url("communicate/get_record"); ?>',
    method:'POST',
    data:{ID:id,rec_id:'CMSSK10000002',tbl:'PME'},
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