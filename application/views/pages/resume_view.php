<link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>" rel="stylesheet">
<div class="row">
  <div class="pull-right <?php echo ($this->data['Login']['Login_as'] == 'DSSK10000011' || $this->data['Login']['Login_as'] == 'DSSK10000012') ? 'hidden' : ''; ?>">
    <a href="<?php echo base_url('Hr_recruitment/add/'); ?>">
      <button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Resume</button>
    </a>
  </div>
  <div class="ibox-content">
      <form class="form-horizontal">
        <div class="row">
          <div class="form-group">
            <div class="col-xs-6">
              <label class="control-label">City</label>
              <select id="city" class="form-control chosen-select">
                <option value="">Select City</option>
                <?php 
                  foreach ($filter['city'] as $key => $city) {
                ?>
                    <option><?php echo $city['city']; ?></option>
                <?php
                  }
                ?>
              </select>
            </div>

            <div class="col-xs-6">
              <label class="control-label">Area</label>
              <select id="area" class="form-control chosen-select">
                <option value="">Select Area</option>
                <?php
                  foreach ($filter['area'] as $key => $area) {
                ?>
                    <option><?php echo $area['area']; ?></option>
                <?php
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-6">
              <label class="control-label">Gender</label>
              <select id="gender" class="form-control chosen-select">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>

            <div class="col-xs-6">
              <label class="control-label">Designation</label>
              <select id="designation" class="form-control chosen-select">
                <option value="">Select Designation</option>
                <?php 
                  foreach ($filter['designation'] as $key => $place) {
                ?>
                    <option value="<?php echo $place['ID']; ?>"><?php echo $place['title']; ?></option>
                <?php
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label class="control-label">Search</label>
              <input class="form-control" type="text" id="detail" placeholder="Search Name, Contact & Email.">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="table-responsive">
            <table class="table" width="100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>DOB</th>
                  <th>Area</th>
                  <th>Gender</th>
                  <th>City</th>
                  <th>Designation</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="filtered_data">
              </tbody>
            </table>
          </div>
          <div class="row col-sm-12 text-center">
            <button type="button" id="commune" class="btn btn-lg btn-success"><i class="fa fa-comment"></i> Communicate about Job Posting</button>
          </div>
        </div>
  </div>
</div>

<div class="modal inmodal fade" id="hr_message_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg m-lgg">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title">Communicate</h4>
            </div>
            <div class="modal-body">
              <strong>Candidates</strong>
              <div class="row">
                <div class="col-lg-12">
                  <select class="form-group chosen-select" id="candidate" multiple></select>
                </div>
              </div>
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
                          <input type="hidden" id="hr_id" value="">
                          <div class="tab-content">
                              <div id="smsMobile" class="tab-pane active">
                                <div class="panel-body">
                                  <form id="mobile">
                                  <small class="text-muted">Send Message From Mobile</small>
                                    <div class="row"> 
                                      <div class="col-sm-12" id="messagess">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label class="font-noraml">Message</label>
                                            <div>
                                              <textarea class="form-control" id="mobile" placeholder="Message" name="message"></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-12 text-center">
                                          <a class="btn btn-primary btn-lg btn-outline" onclick="send_message('smsMobile','mobile')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a>
                                        </div>
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
                                      <div class="col-sm-12" id="messagess1">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label class="font-noraml">Message</label>
                                            <div>
                                              <textarea class="form-control" id="gateway_mess" placeholder="Message" name="message"></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-12 text-center">
                                          <a class="btn btn-primary btn-lg btn-outline" onclick="send_message('gateway','gateway')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a>
                                        </div>
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
                                            <label class="font-noraml">Subject</label>
                                            <div>
                                              <input class="form-control" id="email_sub" placeholder="Subject" name="Subject">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label class="font-noraml">Message</label>
                                            <div>
                                              <textarea class="form-control" id="email" placeholder="Message" name="message"></textarea>
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
                                          <a class="btn btn-primary btn-lg btn-outline" onclick="send_message('EmailCommunicate','email')"><i class="fa fa-envelope" aria-hidden="true"></i> Send</a>
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

<!-- Chosen -->
<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
<script type="text/javascript">

$(document).ready(function() {
  $('.chosen-select').chosen();

  //On Place Selection
  get_filtered_resumes();
  $('#city, #area, #designation, #gender').on('change',function(){
    get_filtered_resumes();
  });
  $('#detail').on('keyup',function() {
    get_filtered_resumes();
  });
});

function get_filtered_resumes()
{
  $('#filtered_data').html('<th align="center" colspan="9"><i class="fa fa-spin fa-spinner fa-5x"></i></th>');
  var city = $('#city').val();
  var area = $('#area').val();
  var designation = $('#designation').val();
  var gender = $('#gender').val();
  var detail = $('#detail').val();
  $.ajax({
    type:'POST',
    data:{'city':city,'area':area,'designation':designation,'gender':gender,'detail':detail},
    url: base_url+'hr_recruitment/get_filtered_resumes',
    success:function(response){
      $('#commune').removeAttr('onClick');
      response = JSON.parse(response);
      var data = '';
      var ids = '';
      var ids2 = '';
      $.each(response,function(k,v){
        ids += v.ID+'||';
        ids2 += v.ID+',';
        data += '<tr><td>'+v.name+'</td><td>'+v.phone+'</td><td>'+v.email+'</td><td>'+v.dob+'</td><td>'+v.area+'</td>';
        if(v.gender == 'male')
        {
          data += '<td>Male</td>';
        }
        else{
          data += '<td>Female</td>';          
        }
        data += '<td>'+v.city+'</td>';          
        data += '<td width="10%">'+v.designation+'</td>';
        data += '<td width="10%">'+v.link+'</td></tr>';
      });
      $('#commune').attr('onClick','comm(\''+ids+'\',\''+ids2+'\')');
      if(response == false)
      {
        data += '<td colspan="9">No data found</td>';
      }

      $('#filtered_data').html(data);
    }
  })
}

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
              window.location.reload();
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

function send_message(formID,type) {
  var msg = $('#'+formID).find('textarea').val();
  var ids = $('#candidate').val();
  var subject = $('#email_sub').val();
  comm_cnt = '';
  $.ajax({
    type:'POST',
    data:{'message':msg,'message_type':type,'attachments':$('#attachments').val(),'ID':ids,'Subject':subject},
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'hr_recruitment/send_message',
    success:function(response)
    {
      if (typeof response==='object') {
        if (response.types==='mobile') {
          var link = '';
          link += 'sms:+91'+response.data;
          link += 'sms:/open?addresses='+response.data;
          link += '?;&body='+msg;
          window.location.href=link;
        }
        else if (response.types==='gateway') {
          if(typeof response.data === 'object')
          {
            var cnt = response.data.length;
            var phno = 0;
            $.each(response.data,function(keyg,valg) {
              var lnk = 'https://control.msg91.com/api/sendhttp.php?authkey=154805AGulz3hLkX593255d2&mobiles=91'+valg.studentNo+'&message='+valg.msg+'&sender=PSHALA&route=4&country=0';
              $.ajax({
                url:lnk,
                error:function(err){
                  phno++;
                  if(cnt === phno)
                  {
                    $('#messagess').html('');
                    $('#messagess1').html('');
                    $('#messageMasters').html('');
                    $('#msgMastersAll').html('');
                    $('#messageMasters1').html('');
                    $('#msgMastersAll1').html('');
                    $('#comunicationModal').modal('hide');
                    toastr.warning('Message Sent!!!');
                    console.clear();
                    window.location.reload();
                  }
                },
                success:function(res){
                  response = true;
                }
              });
            });
          }
          else
          {
            var lnk = 'https://control.msg91.com/api/sendhttp.php?authkey=154805AGulz3hLkX593255d2&mobiles=91'+response.data+'&message='+msg+'&sender=PTSHLA&route=4&country=0';
            $.ajax({
              url:lnk,
              error:function(err){
                $('#messagess').html('');
                $('#messagess1').html('');
                $('#messageMasters').html('');
                $('#msgMastersAll').html('');
                $('#messageMasters1').html('');
                $('#msgMastersAll1').html('');
                $('#comunicationModal').modal('hide');
                toastr.warning('Message Sent!!!');
                console.clear();
                window.location.reload();
              },
              success:function(res){
                response = true;
              }
            });
          }
          // if(window.location.href=lnk)
          // {
          //   response = true;
          // }
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
        window.location.reload();
      }
      else
      {
         toastr.warning('Something Went Wrong');
      }
    }
  });
}

function comm(ids,ids2)
{
  $.ajax({
    url:'<?php echo base_url("communicate/get_record"); ?>',
    method:'POST',
    data:{ID:ids,rec_id:'CMSSK10000013',tbl:'HR'},
    datatype:'JSON',
    success:function(response){
      response = JSON.parse(response);
      getChosenData('candidate','HR',[{'label':'name','value':'ID'}],[{'Status':'A','ID':ids}],ids2,true);
      $('#mobile').text(response.setting.sms_mobile);
      $('#gateway_mess').text(response.setting.sms_gateway);
      $('#email').text(response.setting.email);
      $('#email_sub').val('Recruitment HR');
      $('#chosen-select').css('width:100%');
      $('#chosen-select').trigger('chosen:updated');
      $('#hr_message_modal').modal('show');
    }
  });
}
</script>