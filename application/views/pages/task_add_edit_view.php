<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Task')); ?></h5>
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
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('Task/add'); ?>" method="post" id="cust_add">

                        <input type="hidden" name="ID" value="<?php echo @$DETAIL['View'][0]['ID'];?>">
                        <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo (@$View['branch_ID'] == NULL) ? $this->uri->segment(3, 0) : $View['branch_ID']; ?>">

                        <div class="form-group">
                              <label for="task_type" class="col-sm-3 control-label">Task Type  : </label>
                              <div class="col-sm-9">
                                <select class="form-control chosen-select" id="task_type_ID" name="task_type_ID[]" placeholder="Task Type" required multiple>
                                </select>
                              </div>
                                <span id="task_type"></span>
                          </div>

                         <div class="form-group">
                              <label  class="col-sm-3 control-label">Task Name : </label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Task Name" name="title" value="<?php echo @$DETAIL['View'][0]['title']; ?>" required>
                              </div>
                                <span id="name"></span>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label">Task Details : </label>
                            <div class="col-sm-9">
                              <textarea class="form-control" placeholder="Task Details" name="description"><?php echo @$DETAIL['View'][0]['description']; ?></textarea>
                            </div>
                            <span id="name"></span>
                          </div>

                          <div class="form-group">
                              <label for="Assigned_by" class="col-sm-3 control-label">Assigned By  : </label>
                              <div class="col-sm-9">
                                <select class="form-control chosen-select" id="assigned_by" name="assigned_by" placeholder="Assigned By">
                                </select>
                              </div>
                                <span id="assigned_by"></span>
                          </div>

                          <div class="form-group">
                              <label for="desg" class="col-sm-3 control-label">Select Posts : </label>
                              <div class="col-sm-9">
                                <select class="form-control chosen-select" id="designation" placeholder="Select Posts" onChange="get_employees();" required multiple>
                                </select>
                              </div>
                                <span id="desg"></span>
                          </div>

                          <div class="form-group">
                              <label for="Assigned_to" class="col-sm-9 col-sm-offset-3 text-danger" id="errMsg"></label>
                              <div class="col-sm-9 col-sm-offset-3" id="brBtns"></div>
                          </div>

                          <div class="form-group">
                              <div id="employees"></div>
                          </div>
                          <span></span>

                          <div class="form-group">
                            <label for="Starting_time" class="col-sm-3 control-label">Starting at : </label>
                            <div class="col-sm-5">
                              <input type="text" class="datepicker form-control" name="start_time" placeholder="starting Date" value="<?php echo $this->date_library->db2date(@$DETAIL['View'][0]['sdate'],$this->date_library->get_date_format());?>" required>
                            </div>
                            <div class="input-group col-sm-3">
                              <input id="timepicker1" type="text" name="sTime" value="<?php echo @$DETAIL['View'][0]['stime'];?>" class="form-control input-small timepicker" placeholder="Starting Time" required>
                              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                            <span id="Starting_time"></span>
                          </div>

                          <div class="form-group">
                            <label for="Over_time" class="col-sm-3 control-label">Expected over at : </label>
                            <div class="col-sm-5">
                              <input type="text" class="datepicker form-control" name="expected_end_time" placeholder="Over Date" value="<?php echo $this->date_library->db2date(@$DETAIL['View'][0]['exdate'],$this->date_library->get_date_format());?>" required>
                            </div>
                            <div class="input-group col-sm-3">
                              <input id="timepicker1" type="text" name="exTime" value="<?php echo @$DETAIL['View'][0]['extime'];?>" class="form-control input-small timepicker" placeholder="Over Time">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                            <span id="Over_at"></span>
                          </div>

                          <div class="form-group">
                            <label for="priority" class="col-sm-3 control-label">Set Prority : </label>
                            <div class="col-sm-3">
                              <select class="form-control chosen-select" id="prority" name="priority" placeholder="Set Priority To" required>
                                <option selected disabled>Set Priority</option>
                                <option value="1" <?php echo (@$DETAIL['View'][0]['priority']==1) ? 'selected' : ''; ?>>1</option>
                                <option value="2" <?php echo (@$DETAIL['View'][0]['priority']==2) ? 'selected' : ''; ?>>2</option>
                                <option value="3" <?php echo (@$DETAIL['View'][0]['priority']==3) ? 'selected' : ''; ?>>3</option>
                                <option value="4" <?php echo (@$DETAIL['View'][0]['priority']==4) ? 'selected' : ''; ?>>4</option>
                                <option value="5" <?php echo (@$DETAIL['View'][0]['priority']==5) ? 'selected' : ''; ?>>5</option>
                                <option value="6" <?php echo (@$DETAIL['View'][0]['priority']==6) ? 'selected' : ''; ?>>6</option>
                                <option value="7" <?php echo (@$DETAIL['View'][0]['priority']==7) ? 'selected' : ''; ?>>7</option>
                                <option value="8" <?php echo (@$DETAIL['View'][0]['priority']==8) ? 'selected' : ''; ?>>8</option>
                                <option value="9" <?php echo (@$DETAIL['View'][0]['priority']==9) ? 'selected' : ''; ?>>9</option>
                                <option value="10" <?php echo (@$DETAIL['View'][0]['priority']==10) ? 'selected' : ''; ?>>10</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="doc" class="col-sm-3 control-label">Upload Document : </label>
                            <div class="col-sm-9">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span><input type="file" value="deepak" onChange="uploadFile(this)" /></span>
                                <?php //echo (!empty(@$DETAIL['View'][0]['file_path']) ? '' :'required'); ?>
                                <span class="fileinput-filename"><?php echo @$DETAIL['View'][0]['file_path']; ?></span>
                                <input type="hidden" name="file_path" id="file_path" value="<?php echo @$DETAIL['View'][0]['file_path']; ?>">
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="priority" class="col-sm-3 control-label">Completed : </label>
                            <div class="col-sm-3 i-checks">
                              <label><input type="checkbox" name="tStatus" id="tStatus" value="Completed" <?php echo (@$DETAIL['View'][0]['tStatus']=='Completed') ? 'checked' : ''; ?>> Yes</label>
                            </div>
                          </div>

                          <div class="form-group hidden" id="compl">
                            <label for="completed_time" class="col-sm-3 control-label">Completed On : </label>
                            <div class="col-sm-5">
                              <input type="text" class="datepicker form-control" id="end_time" name="end_time" placeholder="completed Date" value="<?php echo $this->date_library->db2date(@$DETAIL['View'][0]['edate'],$this->date_library->get_date_format());?>" required disabled>
                            </div>
                            <div class="input-group col-sm-3">
                              <input type="text" id="eTime" name="eTime" value="<?php echo @$DETAIL['View'][0]['etime'];?>" class="form-control input-small timepicker" placeholder="completed Time" required disabled>
                              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                            <span id="completed_at"></span>
                          </div>

         			  	</div>
                           
                        	<div class="form_footer">
                        	<div class="row">
                            	<div class="col-md-6 text-center col-md-offset-3 ">
                                        <button type="submit" class="btn btn-primary"><?php echo isset($DETAIL['What']) ? 'Update' : 'Add'; ?></button>
                                    </div>
                            	</div>

                            </form> 
                        

            </div>
        </div>
    </div>
  </div>
<style type="text/css">
  .datepicker {
    z-index: 1000;
  }
</style>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<link href="<?php echo base_url("css/plugins/Timepicker/bootstrap-datetimepicker.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/plugins/Timepicker/bootstrap-datetimepicker.js"); ?>"></script>
<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<!-- Jasny -->
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<script type="text/javascript">
  var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($this->date_library->get_date_format())?>";
  $('.datepicker').datepicker({
    format: js_date_format,
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true
  });
  $('.timepicker').datetimepicker({
    format: 'LT'
  });
  /*$('.chosen-select').on('change',function (argument) {
    //disabledSelect();
  });*/
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  $(".chosen-select").chosen();

  function remove_phone(phone_div,n)
  {
    if(n == 'yes')
    {
      var d = $("#num_row1").val();
      var k = --d;
      $("#num_row1").val(k);
    }
    else
    {
      var c = $("#row_count1").val();
      var j = --c;
      $("#row_count1").val(j);
    }
      $('#'+phone_div).remove();
    
  }

 function remove_address(phone_div,n)
  {
    if(n == 'yes')
    {
      var d = $("#num_row2").val();
      var k = --d;
      $("#num_row2").val(k);
    }
    else
    {
      var c = $("#row_count2").val();
      var j = --c;
      $("#row_count2").val(j);
    }
      $('#'+phone_div).remove();
  }
  
  function get_duplicate(count)
{
  findDuplicates();
  var item_id = $('#email').val();
  var form = $("#add_prod").serialize();
    $.ajax({
      type:'POST',
      data:{'email':item_id},
      url: '<?php echo base_url(); ?>'+'customer/get_duplicate',
      success:function(response){
        response = JSON.parse(response);
        if(response == false)
        {
          $('#email').css("background-color", "yellow");
          /*jQuery(el1).css("background-color", "yellow");*/
          $.gritter.add({
          text: '<h4>Duplicate Values Found for email id Please Change</h4>',                   
          class_name: 'gritter-center',
          time: '4000'
        });
        }
        else
        {
          $('#email').css("background-color", "white");
        }
      }
    });
}

function findDuplicates() {
    var isDuplicate = false;
    jQuery("input[name^='email']").each(function (i,el1) {

        var current_val = jQuery(el1).val();
        if (current_val != "") {
            jQuery("input[name^='email']").each(function (i,el2) {
                if (jQuery(el2).val() == current_val && jQuery(el1).attr("name") != jQuery(el2).attr("name")) {
                    isDuplicate = true;
                    jQuery(el2).css("background-color", "yellow");
                    jQuery(el1).css("background-color", "yellow");
                    return;
                }
            });
        }
    });

    if (isDuplicate) {
        $.gritter.add({
          text: '<h4>Duplicate Values Found for email id Please Change</h4>',                   
          class_name: 'gritter-center',
          time: '4000'
        });
        return false;
    } else {
        return true;
    }
}

 

  $(document).ready(function() {
  //var ID = "<?php echo @$DETAIL['View'][0]['ID']; ?>";
  //if(!empty(ID))
  //{
  //$('#Adf8a2a4855e73aeeb929bd3b9913c6f2').addClass('active');
  //$("#Adf8a2a4855e73aeeb929bd3b9913c6f2").parent().parent().addClass("active");
  //$("#Adf8a2a4855e73aeeb929bd3b9913c6f2").parent().addClass("in");
//}
    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
    });
    $('.add_phone').on('click',function(){
      var c = $("#row_count1").val();
      ++c;
      $('<div class="form-group" id="phone-div-'+c+'"><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="PH-phone_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option><option value="Mobile">Mobile</option><option value="Personal">Personal</option><option value="Fax">Fax</option><option value="Main">Main</option></select></div><div class="col-sm-5"><input type="number" class="form-control" name="PH-phone_number-'+c+'" placeholder="Phone no." value="" required  min="100000" minlength="6" maxlength="12"></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div><span id="cst"></span></div>').appendTo('#add-phone');
      $("#row_count1").val(c);
    });

    if ($('#tStatus').is(':checked')) {
      $('#end_time').removeAttr('disabled');
      $('#eTime').removeAttr('disabled');
      $('#compl').removeClass('hidden');
    }
    else
    {
      $('#end_time').attr('disabled');
      $('#eTime').attr('disabled');
      $('#compl').addClass('hidden');
    }
    $('#tStatus').on('ifChecked', function(event){
      $('#end_time').removeAttr('disabled');
      $('#eTime').removeAttr('disabled');
      $('#compl').removeClass('hidden');
    });
    $('#tStatus').on('ifUnchecked', function(event){
      $('#end_time').attr('disabled');
      $('#eTime').attr('disabled');
      $('#end_time').val('');
      $('#eTime').val('');
      $('#compl').addClass('hidden');
    });

    $('.add_address').on('click',function(){
      var c = $("#row_count2").val();
      ++c;
      $('<div class="form-group" id="address-div-'+c+'"><label for="cst_tin_no" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="AD-address_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option></select></div><div class="col-sm-5"><textarea type="text" class="form-control" name="AD-address-'+c+'" placeholder="Address" required></textarea></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_address" onclick="remove_address(\'address-div-'+c+'\');"><i class="fa fa-close"></i></button></div><span id="cst"></span></div>').appendTo('#add-address');
      $("#row_count2").val(c);
    });

    $("#cust_add").postAjaxData(function(result){
      //alert(result);
       if(result === 1)
      {
        var type = "<?php echo isset($DETAIL['What']) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully '+type+'.');
        setTimeout(function(){
          window.location.href = "<?php echo current_url(); ?>";
        }, 3000);
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
    });
  


$("#cust_add").validate({
                 rules: {
                     title: {
                         required: true,
                     }
                 }
             });
  });

var login_as = "<?php echo $this->session_library->get_session_data('Login_as'); ?>";
var branch_ID = $('#branch_ID').val();
/*if(login_as == 'DSSK10000001')
{
  getChosenData('assigned_by','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['View'][0]['assigned_by']?>');
  getChosenData('assigned_to','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['View'][0]['assignTo']?>');
}
else
{*/
  getChosenData('task_type_ID','TT',[{'label':'title','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['View'][0]['task_type_ID']?>');
  getChosenData('assigned_by','US',[{'label':'Name','value':'ID'}],[{'Status':'A','branch_ID':branch_ID}],'<?php echo @$DETAIL['View'][0]['assigned_by']?>');
  getChosenData('designation','DS',[{'label':'post','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['View'][0]['designation']?>');
  // getChosenData('assigned_to','US',[{'label':'Name','value':'ID'}],[{'Status':'A','branch_ID':branch_ID}],'<?php echo @$DETAIL['View'][0]['assignTo']?>');
// }

function uploadFile(f) {
  toastr.options = {
              timeOut:0,
            };
            toastr.warning('<i class="fa fa-spinner fa-spin"></i> UPLOADING...',{timeOut: 0});
  var file_data = $(f).prop('files')[0]; 
        var form_data = new FormData();                  
        form_data.append('file', file_data);
      $.ajax({
        datatype:'text',
        data:form_data,
        type:'POST',
        cache: false,
        contentType: false,
        processData: false,
        url: '<?php echo base_url("task/upload_AnyFile");?>',
        success:function(response)
        {
          if (typeof response==='string')
          {
            $('#file_path').val(response);
            toastr.clear();
             toastr.options = {
              "closeButton": true,
                positionClass:'toast-bottom-right',
                showMethod: 'slideDown',
                "progressBar": true,
                tapToDismiss : true,
                timeOut: 5000
            };
            toastr.success('File Uploaded');
          }
          else
          {
            toastr.error("Please select image!");
          }
        }
      });
}

function get_employees(getTypeListID) {
  $('#errMsg').html('');
   if ($('#designation').val().length===0) {
    $('#brBtns').html('');
    $('#employees').html('');
  }
  else
  {
    $.ajax({
        type:'POST',
        data:{'type':'Employee','branch_ID':$('#branch_ID').val(),'typeList':$('#designation').val()},
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Communicate/personsToSendMsg',
        success:function(response)
        {
          if (typeof response==='object') {
            if (response.data===undefined || response.data===null) {
              $('#errMsg').html('No '+response.type+' present');
            }
            else
            {
              var btns='';
              $.each(response.list,function(k,v) {
                btns+='<a class="btn btn-primary" onclick="selectAll(\''+v.ID+'\')">Select '+v.Name+'</a>&nbsp;&nbsp;';
                btns+='<a class="btn btn-danger" onclick="deselectAll(\''+v.ID+'\')">Deselect '+v.Name+'</a>&nbsp;&nbsp;';
              })
              $('#brBtns').html(btns);
              var data='<label class="col-sm-3 control-label">'+response.type+' : </label><div class="col-sm-9"><select id="designation" name="assignTo[]" class="form-control chosen-select" multiple><option selected disabled>Select</option>'
              $.each(response.data,function(k,v) {
                data+='<option data-typeid="'+v.Type+'" value="'+v.ID+'">'+v.Name+'</option>';
              })
              data+='</select></div>'
              $('#employees').html(data);
            }
          }
          $('.chosen-select').chosen({'width':'100%'});
        }
      });
  }
}
</script>