


        </div>
        <div class="footer">
            <!-- <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div> -->
            <div id="actall" style="position: fixed;
                          bottom: 20px;
                          right: 20px;
                          z-index: 100;">
                <button class="btn btn-lg btn-success btn-circle" id="actBtn" type="button" data-toggle="tooltip" title="" data-original-title="Communicate" onClick="communicate()"><i class="fa fa-commenting"></i></button>
            </div>
            <div>
                <strong>Copyright</strong> SkyQ Infotech &copy; 2016-2017.
            </div>
        </div>

        </div>
        </div>






<!-- activity modal -->


<script type="text/javascript">
  base_url="<?php echo base_url();?>";
</script>
<link href="<?php echo base_url('css/bootstrap-datetimepicker.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/bootstrap-datetimepicker.js"); ?>"></script> 
<!-- Mainly scripts -->
<script src="<?php echo base_url("js/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/metisMenu/jquery.metisMenu.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/slimscroll/jquery.slimscroll.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/inspinia.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/pace/pace.min.js"); ?>"></script>
<link href="<?php echo base_url('css/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('js/plugins/toastr/toastr.min.js'); ?>"></script>

<link href="<?php //echo base_url('css/jquery.mCustomScrollbar.css'); ?>" rel="stylesheet">
<script src="<?php //echo base_url('js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<!-- DROPZONE -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>


<div class="modal inmodal fade" id="comunicationModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg m-lgg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <span ><i style="color: green;" class="fa fa-volume-control-phone modal-icon"></i></span>
                <h4 class="modal-title">Communication</h4>
                <small class="font-bold">Communicate With xxxxxxx.</small>
            </div>
            <div class="modal-body">
            <strong>To</strong>
              <div class="row">
                <div class="col-sm-12">
                  <div class="ibox-content">
                    <div class="row">
                      <div class="col-sm-12">
                      <h4 class="text-danger" id="errMsg"></h4>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="font-noraml">Branch</label>
                            <div id="branch_added">
                            <?php if ($this->session_library->get_session_data('Login_as')==='DSSK10000001') { ?>
                              <select id="brnchIDSelected" class="chosen-select" onchange="branchChange()" >
                              </select>
                            <?php }else{?>
                             <h3 class="m-b-xs text-warning text-center"><strong><?php echo $this->str_function_library->call('fr>BR>name:ID=`'.$this->session_library->get_session_data('branch_ID').'`');;?></strong></h3>
                             <input type="hidden" id="brnchIDSelected" value="<?php echo $this->session_library->get_session_data('branch_ID'); ?>">
                            <?php } ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="font-noraml">Send To</label>
                            <div>
                              <select id="typeCom" class="chosen-select" onchange="getTypeList(this.value)">
                                <option selected disabled>Select</option>
                                <option value="Employee">Employee</option>
                                <option value="Student">Student</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group" id="getTypeList">
                            
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="col-lg-12">
                        <div class="col-sm-12" id="brBtns">
                        </div>
                      </div>
                      <br>
                      <div class="col-lg-12">
                        <div class="col-sm-12">
                          <div class="form-group" id="personsToSendMsg">
                                
                          </div>
                        </div>
                      </div>

                    </div>
                    
                  </div>
                </div>
              </div>
              
              <br>
              <strong>Type</strong>
              <div class="row">
                    <div class="col-lg-12">
                      <div class="tabs-container">
                          <ul class="nav nav-tabs">
                              <li class="active"><a data-toggle="tab" href="#smsMobile"><i class="fa fa-mobile" aria-hidden="true"></i> SMS Mobile</a></li>
                              <li><a data-toggle="tab" href="#smsGateway"><i class="fa fa-comment" aria-hidden="true"></i> SMS Gateway</a></li>
                              <li class=""><a data-toggle="tab" href="#EmailCommunicate"><i class="fa fa-envelope" aria-hidden="true"></i> Email</a></li>
                              <li class=""><a data-toggle="tab" href="#NotificationComm"><i class="fa fa-bell" aria-hidden="true"></i> App. Notification</a></li>
                          </ul>
                          <div class="tab-content">
                              <div id="smsMobile" class="tab-pane active">
                                <div class="panel-body">
                                  <form id="mobile">
                                  <small class="text-muted">Send Message From Mobile</small>
                                    <!-- <strong>Sms Mobile</strong>9920184402@1103 -->
                                    <div class="row"> 
                                      <div class="col-sm-12">
                                        <div class="col-sm-4">
                                          <div class="form-group">
                                            <label class="font-noraml">Type Of Message</label>
                                            <div>
                                              <select class="chosen-select" onchange="getTypeMEssages(this.value)">
                                                <option selected disabled>Select</option>
                                                <option value="Manual">Manual</option>
                                                <option value="Masters">From Masters</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-group" id="messageMasters">

                                          </div>
                                        </div>

                                      </div>
                                    </div>

                                    <div class="row" id="msgMastersAll">
                                    </div>

                                    <div class="row"> 
                                      <div class="col-sm-12" id="messagess">
                                      </div>
                                    </div>
                                  </form>
                                </div>

                              </div>

                              <div id="smsGateway" class="tab-pane">
                                <div class="panel-body">
                                <form id="gateway">
                                  <small class="text-muted">Send Message From SMS Gateway</small>
                                    <div class="row"> 
                                      <div class="col-sm-12">
                                        <div class="col-sm-4">
                                          <div class="form-group">
                                            <label class="font-noraml">Type Of Message</label>
                                            <div>
                                              <select class="chosen-select" onchange="getTypeMEssages(this.value,1)">
                                                <option selected disabled>Select</option>
                                                <option value="Manual">Manual</option>
                                                <option value="Masters">From Masters</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-group" id="messageMasters1">

                                          </div>
                                        </div>

                                      </div>
                                    </div>

                                    <div class="row" id="msgMastersAll1">
                                    </div>

                                    <div class="row"> 
                                      <div class="col-sm-12" id="messagess1">
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>

                              <div id="EmailCommunicate" class="tab-pane">
                                  <div class="panel-body">
                                    <form id="emailSend">
                                      <small class="text-muted">Send Email</small>
                                      <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label class="font-noraml">Message</label>
                                            <div>
                                              <textarea class="form-control" placeholder="Message" name="message"></textarea>
                                              <input type="hidden" name="attachments" id="attachments">
                                            </div>
                                          </div>
                                        </div>
                                    </form>
                                    <br>
                                    <div class="row" id="drpZoneEmail" hidden>
                                      <div class="col-sm-12 ">
                                        <form id="my-file-dropzone" class="dropzone" action="<?php echo base_url('settings/uploadFile'); ?>" method="post">
                                          <div class="dropzone-previews"></div>
                                        </form>
                                      </div>
                                    </div>
                                    <br>
                                     <div class="col-sm-12">
                                          <div class="form-group">
                                            <div class="text-center">
                                              <button type="button" class="btn btn-lg btn-success" onClick="open_dropzone();"><i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files</button>
                                              <input type="hidden" name="ctn_files" id="ctn_files">
                                            </div>
                                          </div>
                                        </div>
                                       
                                        <div class="col-sm-12 text-center">
                                          <a class="btn btn-primary btn-lg btn-outline" onclick="sendMsg('emailSend','email')"><i class="fa fa-envelope" aria-hidden="true"></i> Send</a>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <div id="NotificationComm" class="tab-pane">
                                  <div class="panel-body">
                                      <strong>Notification</strong>
                                      <strong class="text-danger">Commimng Soon <small class="text-muted">On Node</small></strong>
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

<script src="<?php echo base_url('js/plugins/dropzone/dropzone.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/iCheck/icheck.min.js');?>"></script>
<script type="text/javascript">
  $('.chosen-select').chosen({'width':'100%'});
  getChosenData('brnchIDSelected','BR',[{'label':'name','value':'ID'}],[{'Status':'A'}]);
  var comm_cnt = '';
  Dropzone.options.myFileDropzone = {
    success: function(file, response) {
            // console.log(this);
            $('.dz-image-preview').addClass('dz-success');
            // console.log(response);
            response = JSON.parse(response);
            comm_cnt += response.ID+',';
            $('#attachments').val(comm_cnt);
          },

    error: function(file, response) {
              alert(response);
          }
        
};


// alert(d);
function sendMsg(formID,type) {
  var msg=$('#'+formID).find('textarea').val();
  var to=$('#listsOfpersonS').val();
  var typeofPerson=$('#typeCom').val();
  var branch=$('#brnchIDSelected').val();
  if (to===undefined) {
    toastr.warning('Select <strong class="text-info">Person TO</strong> send message');
  }
  else if (msg==='' || msg===undefined || msg===null) {
    toastr.warning('Please type <strong class="text-danger">message</strong>');
  }
  else
  {
    if ($('#typeCom').val()==='Student') {
      var toTypeStudent=$('input[name="student"]').iCheck('update')[0].checked;
      var toTypeG1=$('input[name="guardian1"]').iCheck('update')[0].checked;
      var toTypeG2=$('input[name="guardian2"]').iCheck('update')[0].checked;
    }
    else
    {
      var toTypeStudent='';
      var toTypeG1='';
      var toTypeG2='';
    }
    comm_cnt = '';
    $.ajax({
      type:'POST',
      data:{'message':msg,'msgto':to,'message_type':type,'branch_ID':branch,'typeofPerson':typeofPerson,'toTypeStudent':toTypeStudent,'toTypeG1':toTypeG1,'toTypeG2':toTypeG2,'attachments':$('#attachments').val()},
      dataType:'json',
      url: '<?php echo base_url(); ?>'+'Communicate/sendMsg',
      success:function(response)
      {
        if (typeof response==='object') {
          if (response.types==='mobile') {
            var link = '';
            link += 'sms:+91'+response.data;
            // link += 'sms:/open?addresses='+response.data;
            link += '?;&body='+msg;
            window.location.href=link;
          }
          else
            if (response.types==='gateway') {
            }
            else{
              toastr.warning('Something Went Wrong');
            }
        }
        else 
        if (response===true) {
          $('#messagess').html('');
          $('#messagess1').html('');
          $('#messageMasters').html('');
          $('#msgMastersAll').html('');
          $('#messageMasters1').html('');
          $('#msgMastersAll1').html('');
          $('#comunicationModal').modal('hide');
          toastr.warning('Message Sent!!!');
        }
        else
        {
           toastr.warning('Something Went Wrong');
        }
      }
    });
  }
}

function getTypeMEssages(typeMsg,val) {
  if (val===1) {
    var sndType='gateway';
    var sndID='gateway';
    val=1;
  }
  else{
    val='';
    var sndType='mobile';
    var sndID='mobile';
  }

  $('#messagess').html('');
  $('#messagess1').html('');
  if (typeMsg==='Manual') {
    // $('#messageMasters'+val).html('');
    // $('#msgMastersAll'+val).html('');
    $('#messageMasters').html('');
    $('#msgMastersAll').html('');
    $('#messageMasters1').html('');
    $('#msgMastersAll1').html('');
    $('#messagess'+val).html('<div class="col-sm-12"><div class="form-group"><label class="font-noraml">Message</label><div><textarea class="form-control" placeholder="Message" name="message"></textarea></div></div></div><div class="col-sm-12 text-center"><a class="btn btn-primary btn-lg btn-outline" onclick="sendMsg(\''+sndID+'\',\''+sndType+'\')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a></div>');
  }
  else
  {
    if (val===1) {
      $('#messageMasters'+val).html('<label class="font-noraml">Masters</label><div><select id="msgMaster1" class="chosen-select" onchange="getMsgMaster(this.value,1)"></select></div>');
      getChosenData('msgMaster1','MT',[{'label':'type','value':'ID'}],[{'Status':'A'}]);
    }
    else
    {
      $('#messageMasters').html('<label class="font-noraml">Masters</label><div><select id="msgMaster" class="chosen-select" onchange="getMsgMaster(this.value)"></select></div>');
      getChosenData('msgMaster','MT',[{'label':'type','value':'ID'}],[{'Status':'A'}]);
    }
  }
}

function getMsgMaster(msgID,val) {
  $.ajax({
    type:'POST',
    data:{'msgID':msgID},
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'Communicate/getMsgMaster',
    success:function(response)
    {
      if (typeof response === 'object') {
        var data = '';
        $.each(response,function(k,v) {
           if (val === 1) {
            data += '<div class="col-lg-4"><a href="#" onclick="putItinMsg(\''+v.ID+'\',1)"><div class="widget style1 navy-bg"><div class="col-sm-12">'+v.sms+'<input type="hidden" id="text'+v.ID+'" value="'+v.sms+'"></div><div class="clearfix"></div></div></a></div>';
          }
          else
          {
            data += '<div class="col-lg-4"><a href="#" onclick="putItinMsg(\''+v.ID+'\')"><div class="widget style1 navy-bg"><div class="col-sm-12">'+v.sms+'<input type="hidden" id="text'+v.ID+'" value="'+v.sms+'"></div><div class="clearfix"></div></div></a></div>';
          }
        });
        if (val === 1) {
          $('#msgMastersAll1').html(data);
        }
        else
        {
          $('#msgMastersAll').html(data);
        }
        
      }
    }
  });
}

function putItinMsg(ID,val){
  var sms=$('#text'+ID).val();
  if (val===1) {
    $('#messagess1').html('<div class="col-sm-12"><div class="form-group"><label class="font-noraml">Message</label><div><textarea class="form-control" placeholder="Message" name="message">'+sms+'</textarea></div></div></div><div class="col-sm-12 text-center"><a class="btn btn-primary btn-lg btn-outline" onclick="sendMsg(\'gateway\',\'gateway\')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a></div>');
  }
  else
  {
    $('#messagess').html('<div class="col-sm-12"><div class="form-group"><label class="font-noraml">Message</label><div><textarea class="form-control" placeholder="Message" name="message">'+sms+'</textarea></div></div></div><div class="col-sm-12 text-center"><a class="btn btn-primary btn-lg btn-outline" onclick="sendMsg(\'mobile\',\'mobile\')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a></div>');
  }
}

function branchChange() {
  $('#brBtns').html('');
  $('#personsToSendMsg').html('');
  $('#errMsg').html('');
  if ($('#typeCom').val()===null || $('#typeCom').val()===undefined) {}
  else
  {
     getTypeList($('#typeCom').val());
  }
}

function selectAll(ID) {
  if (ID==='all') {
    $('#listsOfpersonS option').prop('selected',true).trigger("chosen:updated");
  }
  else
  {
    $('#listsOfpersonS option[data-typeid="'+ID+'"]').prop('selected',true).trigger("chosen:updated");
  }
}

function deselectAll(ID) {
  if (ID==='all') {
    $('#listsOfpersonS option').prop('selected',false).trigger("chosen:updated");
  }
  else
  {
    $('#listsOfpersonS option[data-typeid="'+ID+'"]').prop('selected',false).trigger("chosen:updated");
  }
}

function getTypeList(type) {
  $('#brBtns').html('');
  $('#personsToSendMsg').html('');
  $('#errMsg').html('');
  if ($('#brnchIDSelected').val()===null || $('#brnchIDSelected').val()===undefined) {
    $('#errMsg').html('Please Select Branch First!!!!');
  }
  else
  {
    $.ajax({
      type:'POST',
      data:{'type':type,'branch_ID':$('#brnchIDSelected').val()},
      dataType:'json',
      url: '<?php echo base_url(); ?>'+'Communicate/getTypeList',
      success:function(response)
      {
        if (typeof response==='object') {
          var data='<label class="font-noraml">'+response.type+'</label><div><select id="listsOfperson" class="chosen-select" onchange="personsToSendMsg(this.value)" multiple><option selected disabled value="">Select</option><option value="all">All</option>'
          $.each(response.data,function(k,v) {
            data+='<option value="'+v.ID+'">'+v.name+'</option>';
          })
          data+='</select></div>'
          $('#getTypeList').html(data);
        }
        $('.chosen-select').chosen({'width':'100%'});
      }
    })
  }
}

function personsToSendMsg(getTypeListID) {
  $('#errMsg').html('');
   if ($('#listsOfperson').val().length === 0) {
    // $('#errMsg').html('Please Select Branch First!!!!');
    $('#brBtns').html('');
    $('#personsToSendMsg').html('');

    $("#listsOfperson option[value='all']").prop('disabled',false).trigger("chosen:updated");
    $("#listsOfperson option[value='all']").siblings().attr('disabled',false).trigger("chosen:updated");
    $("#listsOfperson option[value='']").attr('disabled',true).trigger("chosen:updated");
  }
  else
  {
    var selectedoptnsFoot=$("#listsOfpersonS").val();
    // if (selectedoptns!==null) {
    //   $('#student_ID').multiSelect('select', selectedoptns);  
    // }


    if ($('#listsOfperson').val()!='all') {
      $("#listsOfperson option[value='all']").prop('disabled',true).trigger("chosen:updated");
    }
    else
    {
      $("#listsOfperson option[value='all']").siblings().prop('disabled',true).trigger("chosen:updated");
    }
    $.ajax({
        type:'POST',
        data:{'type':$('#typeCom').val(),'branch_ID':$('#brnchIDSelected').val(),'typeList':$('#listsOfperson').val()},
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
              var data='<label class="font-noraml">'+response.type+'</label><div><select id="listsOfpersonS" name="assignTo" class="chosen-select" multiple><option selected disabled>Select</option>';

              $.each(response.data,function(k,v) {
                data+='<option data-typeid="'+v.Type+'" value="'+v.ID+'">'+v.Name+'</option>';
              })
              data+='</select></div>';
              if ($('#typeCom').val()==='Student') {
                data+='<br><div class="row"><div class="col-sm-2"><strong>Send To:</strong></div><div class="col-sm-10"><label class="i-checks checkbox-inline"><label> <input type="checkbox" value="" name="student"> <i></i> Student </label></label><label class="i-checks checkbox-inline""><label> <input type="checkbox" value="" name="guardian1"> <i></i> Guardian 1</label></label><label class="i-checks checkbox-inline""><label> <input type="checkbox" value="" name="guardian2"> <i></i> Guardian 2 </label></label><code><strong>Note:- </strong>By default message will go to student if nothing has been selected</code></div></div>';
              }
              
              $('#personsToSendMsg').html(data);
               $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                if (selectedoptnsFoot!==null) {
                  $('#listsOfpersonS').val(selectedoptnsFoot).trigger("chosen:updated");  
                }
            }
          }
          $('.chosen-select').chosen({'width':'100%'});
        }
      })
  }
}



function open_dropzone()
{
  $('#drpZoneEmail').removeAttr('hidden');
}

setInterval(function(){
  var id = '<?php echo $this->session_library->get_session_data('ID'); ?>';
  get_chat_notification(id);
},1000);

function get_chat_notification(id)
{
  $.ajax({
    method:'POST',
    datatype:'JSON',
    data : {'member_ID':id},
    url : base_url+'student/get_chat_notification',
    success:function(res){
      res = JSON.parse(res);
      if((res.count != '0') && (res.rec != '0'))
      {
        var data = '';
        var des = "<?php echo $this->session_library->get_session_data('Login_as'); ?>";
        $('#chat_notify').html(res.count);
        $('#chat_notify').removeClass('hidden');
        if((des == 'DSSK10000011') || (des == 'DSSK10000012'))
        {
          var branch_ID = $('#brnchIDSelected').val();
          $('#chat_notify').parent().removeAttr('data-toggle');
          $('#chat_notify').parent().removeClass('dropdown-toggle');
          $('#chat_notify').parent().attr('href',base_url+'student/chat_room/'+branch_ID+'/');
        }
        else
        {
          $('#chat_notification').removeClass('hidden');
          $.each(res.rec,function(key,val)
          {
            data += '<li><a href="'+base_url+'student/chat_room/'+val.branch_ID+'/'+val.student_ID+'"><div><i class="fa fa-envelope fa-fw"></i> '+val.cnt+' Chats in Group <b>'+val.student+'</b></div></a></li><li class="divider"></li>';
          });
          $('#chat_notification').html(data);
        }
        data = '';
      }
      else
      {
        $('#chat_notify').addClass('hidden');
        $('#chat_notification').addClass('hidden');
      }
    }
  });
}

function communicate()
{
  $('.chosen-select').css('width','100%');
  $('.chosen-select').trigger("chosen:updated");
  $('#comunicationModal').modal('show');
}
</script>
</body>
</html>