<div class="page-content">
  <div class="<?php echo ($this->data['Login']['Login_as'] == 'DSSK10000011') ? 'hidden' : ''; ?>">
    <div class="pull-right">
       <a href="<?php echo base_url('counseling_session/add/'.$branch_ID); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Counselling Session</button></a>
    </div>
  </div>
  <div class="row">
    <div class="ibox">
      <!-- <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Couseling Sessions')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div> -->
      <div class="ibox-content table-responsive">
        <div class="<?php echo ($this->data['Login']['Login_as'] == 'DSSK10000011') ? 'hidden' : ''; ?>">
          <!-- <a href="<?php echo base_url('counseling_session/add/'.$branch_ID); ?>" class="btn btn-w-m btn-primary">Add Counseling Session</a> -->
          <input type="hidden" id="branch_ID" value="<?php echo $branch_ID; ?>">
        </div>
        <div id="data_table" class="row">
          <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Topic</th>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Attendance</h4>
      </div>
      <div class="modal-body">
        <div class="page-content">
        <form id="records" method="post" action="<?php //echo base_url("Stock/stockBook");?>">
          <div id="student_record" class="row"></div>
        </form>
        </div>
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
      "ajax": "<?php echo base_url('counseling_session/get_show_data'); ?>"+'/'+branch_ID,
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
        $('.label-primary').addClass('hidden');
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

function counseling_attendace(id)
{
  var login_as = '<?php echo $this->data['Login']['Login_as']; ?>';
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'counseling_session/counseling_attendace/'+id,
    success:function(response)
    {
      var data = '';
      if(response != '')
      {
        response = JSON.parse(response);
        data += '<input type="hidden" name="ID" id="ID" value="'+response.ID+'"><div class="form-group"><label class="col-sm-6 control-label">Student Name : </label><label class="col-sm-6 control-label">'+response.name+'</label></div>';
        data += '<div class="form-group"><label class="col-sm-6 control-label">Presenty : </label><div class="col-sm-6"><select class="chosen-select form-control" id="present" name="present"';
        data += login_as == 'DSSK10000011' ? "disabled" : "";
        data += '><option value="Y" ';
        data += response.present == 'Y' ? "selected" : "";
        data += '>Present</option><option value="N" ';
        data += response.present == 'N' ? "selected" : "";
        data += '>Absent</option></select></div></div>';
        data += '<div class="form-group"><label class="col-sm-6 control-label">Student Feedback : </label><div class="col-sm-6"><textarea class="form-control" name="student_feedback" id="student_feedback" ';
        data += login_as == 'DSSK10000011' ? "disabled" : "";
        data += '>';
        data += response.student_feedback == null ? '' : response.student_feedback;
        data += '</textarea></div></div><div class="form-group"><label class="col-sm-6 control-label">Parent Feedback : </label><div class="col-sm-6"><textarea class="form-control" name="parent_feedback" id="parent_feedback" ';
        data += login_as == 'DSSK10000011' ? "disabled" : "";
        data += '>';
        data += response.parent_feedback == null ? '' : response.parent_feedback;
        data += '</textarea></div></div>';
        data += '<div class="form-group"><label class="col-sm-6 control-label">Paathshala Suggestions : </label><div class="col-sm-6"><textarea class="form-control" name="paathshala_suggestions" id="paathshala_suggestions" ';
        data += login_as == 'DSSK10000011' ? "disabled" : "";
        data += '>';
        data += response.paathshala_suggestions == null ? '' : response.paathshala_suggestions;
        data += '</textarea></div></div><div class="form-group"><label class="col-sm-6 control-label">Action Plan : </label><div class="col-sm-6"><textarea class="form-control" name="action_plan" id="action_plan" ';
        data += login_as == 'DSSK10000011' ? "disabled" : "";
        data += '>';
        data += response.action_plan == null ? '' : response.action_plan;
        data += '</textarea></div><div>';
        data += '<div class="col-sm-6 text-center col-md-offset-3"><button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button> <button type="button" id="trnsc" class="btn btn-lg btn-primary" onClick="save_attendance();">Save</button>  <button id="cmt" type="button" class="btn btn-lg btn-success hidden" onClick="commun(\''+id+'\');">Communicate</button></div>';
      }
      else
      {
        data += '<h1 class="text-center text-danger">No records found.</h1>';
        data += '<div class="col-md-6 text-center col-md-offset-3"><button type="button" id="cls" class="btn btn-lg btn-danger" data-dismiss="modal">Close</button></div>';
      }
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
    url: '<?php echo base_url(); ?>'+'counseling_session/save_attendance',
    success:function(response)
    {
      if(response == true)
      {
        $('#cmt').removeClass('hidden');
        toastr.success('Successfully saved.');
      }
      else
      {
        $('#cmt').addClass('hidden');
        toastr.error("Something went wrong!");
      }
    }
  });
}

function commun(id)
{
  $.ajax({
    url:'<?php echo base_url("communicate/get_record"); ?>',
    method:'POST',
    data:{ID:id,rec_id:'CMSSK10000011',tbl:'SC'},
    datatype:'JSON',
    success:function(response){
      response = JSON.parse(response);
      $('#branch_added select option[value="'+response.rec.branch_ID+'"]').prop('selected', true).trigger("chosen:updated");
      $('#typeCom option[value="'+response.setting.type+'"]').prop('selected', true).trigger("chosen:updated");
      getTypeList(response.setting.type);
      setTimeout(function() {
        $('#listsOfperson').val('all').trigger('chosen:updated');
        personsToSendMsg('all');
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