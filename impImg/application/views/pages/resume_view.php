<link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>" rel="stylesheet">
<div class="row">
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
        </div>
  </div>
</div>

<div class="modal inmodal fade" id="hr_message_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg m-lgg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <span ><i style="color: green;" class="fa fa-volume-control-phone modal-icon"></i></span>
                <h4 class="modal-title">Communicate</h4>
                <small class="font-bold">Communicate With <strong id="hr_name" class="text-danger"></strong>.</small>
            </div>
            <div class="modal-body">
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
                                              <textarea class="form-control" id="gateway" placeholder="Message" name="message"></textarea>
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
      response = JSON.parse(response);
      var data = '';
      $.each(response,function(k,v){
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

function message(id,name)
{
  $('#mobile').val('');
  $('#gateway').val('');
  $('#email').val('');
  $('#hr_id').val(id);
  $('#hr_name').html(name);
  $('#hr_message_modal').modal('show');
}

function send_message(formID,type) {
  var msg = $('#'+formID).find('textarea').val();
  var ID = $('#hr_id').val();
  comm_cnt = '';
  $.ajax({
    type:'POST',
    data:{'message':msg,'message_type':type,'attachments':$('#attachments').val(),'ID':ID},
    dataType:'json',
    url: '<?php echo base_url(); ?>'+'hr_recruitment/send_message',
    success:function(response)
    {
      console.log(response);
      if (typeof response === 'object') {
        if (response.types === 'mobile') {
          var link = '';
          link += 'sms:+91'+response.data;
          link += '?;&body='+msg;
          window.location.href = link;
        }
        else
          if (response.types === 'gateway') {
          }
          else{
            toastr.warning('Something Went Wrong');
          }
        toastr.warning("Message Sent !!!");
        $('#hr_message_modal').modal('hide');
      }
      else 
      if (response === true) {
        $('#mobile').val('');
        $('#gateway').val('');
        $('#email').val('');
        $('#hr_message_modal').modal('hide');
        toastr.warning('Message Sent!!!');
      }
      else
      {
         toastr.warning('Something Went Wrong');
      }
    }
  });
}
</script>