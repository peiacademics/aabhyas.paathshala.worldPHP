<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Counseling Session')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div>
<div class="ibox-content">
<div class="page-content">
            <div class="wrap">
              <h4 id="success" style="text-align:center;"></h4>
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('counseling_session/add'); ?>" method="post" id="session_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                        <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo (@$View['branch_ID'] == NULL) ? $this->uri->segment(3, 0) : $View['branch_ID']; ?>">

                        <div class="form-group">
                          <label  class="col-sm-3 control-label">Counseling Title : </label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="Name" placeholder="Counseling Title" name="title" value="<?php echo @$View['title']; ?>" required>
                          </div>
                          <span id="title"></span>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Date : </label>
                          <div class="col-sm-6">
                            <input type="text" class="datepicker form-control" name="date" placeholder="Date" value="<?php echo (@$View['date'] != NULL) ? date('m/d/Y H:i a', strtotime(@$View['date'])) : date('m/d/Y H:i a'); ?>" required>
                          </div>
                          <span id="account_opening_date"></span>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Select Students : </label>
                          <div class="col-sm-6">
                            <select class="form-control chosen-select" id="student_ID" placeholder="student" name="student_ID" value="<?php @$View['student_ID']; ?>" required>
                                  <option selected disabled>Select</option>
                              <?php if((@$students != NULL) && !empty(@$students) && (@$students != FALSE)) {
                                foreach (@$students as $key => $value) { ?>
                                  <option value="<?php echo $value['ID']; ?>" <?php echo (@$value['ID'] == @$View['student_ID']) ? 'selected' : ''; ?>><?php echo $value['Name'].' '.$value['Middle_name'].' '.$value['Last_name']; ?></option>
                              <?php } } else { ?>
                                  <option disabled>No records found.</option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Select Staff : </label>
                          <div class="col-sm-6">
                            <select class="form-control chosen-select" id="staff_ID" placeholder="Staff" name="staff_ID[]" value="<?php @$View['staff_ID']; ?>" multiple required>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Description : </label>
                          <div class="col-sm-6">
                            <textarea class="form-control" placeholder="Description" name="description" id="description" rows="10"><?php echo @$View['description']; ?></textarea>
                          </div>
                          <span id="description"></span>
                        </div>

        					</div>
                           
                	<div class="form_footer">
                	<div class="row">
                    <div class="col-md-6 text-center col-md-offset-3 ">
                      <button id="save" type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>
                      <button id="cmt" type="button" class="btn btn-success hidden">Communicate</button>
                    </div>
                  </div>

                </form> 
                        

            </div>
        </div>
      </div>
    </div>    

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var br_id = $('#branch_ID').val();
    getChosenData('staff_ID','US',[{'label':'Name','value':'ID'}],[{'Status':'A','branch_ID':br_id}],'<?php echo @$View['staff_ID']; ?>',true);
    $.validator.setDefaults({ ignore: ":hidden:not(select)" });  
    var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
    $('.datepicker').datetimepicker();

    $("#session_add").postAjaxData(function(result){
      if(typeof result === 'object')
      {
        if(result.stat == true)
        {
          var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
          $('#cmt').attr('onclick','commun("'+result.id+'")');
          $('#cmt').removeClass('hidden');
          $('#save').addClass('hidden');
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
    });
    $("#session_add").validate();
  });

  function commun(id)
  {
    $.ajax({
      url:'<?php echo base_url("communicate/get_record"); ?>',
      method:'POST',
      data:{ID:id,rec_id:'CMSSK10000010',tbl:'SC'},
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