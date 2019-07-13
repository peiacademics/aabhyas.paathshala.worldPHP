<div class="row">
  <!-- <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Communication Setting')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div> -->
  <div class="ibox white-bg">
    <div class="page-content">
      <div class="">
        <h4 id="success" style="text-align:center;"></h4>
        <div class="">
          <div class="tabs-container">
            <ul class="nav nav-pills nav-justified">
              <li class="active"><a data-toggle="tab" href="#tab-1"> Student</a></li>
              <li class=""><a data-toggle="tab" href="#tab-2">Employee</a></li>
            </ul>

            <div class="tab-content">
              <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                  <div class="full-height-scroll">
                    <div class="table-responsive">
                      <form class="form-horizontal" role="form" action="#" method="post" id="student_setting_add">
                        <table class="table table-striped table-hover" id="table_student">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Student</th>
                              <th>Gaurdian 1</th>
                              <th>Gaurdian 2</th>
                              <th>SMS Mobile</th>
                              <th>SMS Gateway</th>
                              <th>Email</th>
                              <th>App Notification</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(@$student != NULL) { 
                              foreach ($student as $key => $value) { ?>
                              <tr>
                                <td><label class="control-label"><?php echo $value['name']; ?></label></td>
                                <td><label class="i-checks"><input type="checkbox" name="self-<?php echo $value['ID']; ?>" <?php echo ($value['self'] == 'Y') ? 'checked' : '' ?>></label></td>
                                <td><label class="i-checks"><input type="checkbox" name="guardian1-<?php echo $value['ID']; ?>" <?php echo ($value['guardian1'] == 'Y') ? 'checked' : '' ?>></td>
                                <td><label class="i-checks"><input type="checkbox" name="guardian2-<?php echo $value['ID']; ?>" <?php echo ($value['guardian2'] == 'Y') ? 'checked' : '' ?>></label></td>
                                <td><textarea class="form-control" placeholder="SMS Mobile" name="sms_mobile-<?php echo $value['ID']; ?>" id="sms_mobile"><?php echo $value['sms_mobile']; ?></textarea></td>
                                <td><textarea class="form-control" placeholder="SMS Gateway" name="sms_gateway-<?php echo $value['ID']; ?>" id="sms_gateway"><?php echo $value['sms_gateway']; ?></textarea></td>
                                <td><textarea class="form-control" placeholder="Email" name="email-<?php echo $value['ID']; ?>" id="email"><?php echo $value['email']; ?></textarea></td>
                                <td><textarea class="form-control" placeholder="App Notification" name="app_notification-<?php echo $value['ID']; ?>" id="app_notification"><?php echo $value['app_notification']; ?></textarea></td>
                              </tr>
                            <?php } } else { ?>
                              <tr><td colspan="8"><h1 class="text-center text-danger">No records found</td></tr>
                            <?php } ?>
                          </tbody>
                          <tfooter>
                            <tr>
                              <td colspan="8" class="text-center"><button type="button" id="save_student" class="btn btn-lg btn-primary <?php echo (@$student != NULL) ? '' : 'hidden'; ?>">Save</button></td>
                            </tr>
                          </tfooter>
                        </table>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div id="tab-2" class="tab-pane">
                <div class="panel-body">
                  <div class="full-height-scroll">
                    <div class="table-responsive">
                      <form class="form-horizontal" role="form" action="#" method="post" id="employee_setting_add">
                        <table class="table table-striped table-hover" id="table_employee">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>SMS Mobile</th>
                              <th>SMS Gateway</th>
                              <th>Email</th>
                              <th>App Notification</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(@$employee != NULL) { 
                              foreach ($employee as $key => $value) { ?>
                              <tr>
                                <td><label class="control-label"><?php echo $value['name']; ?></label></td>
                                <td><textarea class="form-control" placeholder="SMS Mobile" name="sms_mobile-<?php echo $value['ID']; ?>" id="sms_mobile"><?php echo $value['sms_mobile']; ?></textarea></td>
                                <td><textarea class="form-control" placeholder="SMS Gateway" name="sms_gateway-<?php echo $value['ID']; ?>" id="sms_gateway"><?php echo $value['sms_gateway']; ?></textarea></td>
                                <td><textarea class="form-control" placeholder="Email" name="email-<?php echo $value['ID']; ?>" id="email"><?php echo $value['email']; ?></textarea></td>
                                <td><textarea class="form-control" placeholder="App Notification" name="app_notification-<?php echo $value['ID']; ?>" id="app_notification"><?php echo $value['app_notification']; ?></textarea></td>
                              </tr>
                            <?php } } else { ?>
                              <tr><td colspan="5"><h1 class="text-center text-danger">No records found</td></tr>
                            <?php } ?>
                          </tbody>
                          <tfooter>
                            <tr>
                              <td colspan="5" class="text-center"><button type="button" id="save_employee" class="btn btn-lg btn-primary <?php echo (@$employee != NULL) ? '' : 'hidden'; ?>">Save</button></td>
                            </tr>
                          </tfooter>
                        </table>
                      </form>
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

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  $(document).ready(function() {
    var href = '<?php echo base_url("communicate/add_communication_setting"); ?>';
    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
    });
    $("#save_student").on("click", function() {
      fdata = $('#student_setting_add').serialize();
      $.ajax({
        url:href,
        method:'POST',
        datatype:'JSON',
        data:fdata,
        success:function(response){
          response = JSON.parse(response);
          if(response == true)
          {
            toastr.success('Successfully Saved.');
            setTimeout(function(){
              location.reload();
            }, 3000);
          }
          else
          {
            toastr.error("Something went wrong!");
          }
        }
      });
    });

    $("#save_employee").on("click", function() {
      fdata = $('#employee_setting_add').serialize();
      $.ajax({
        url:href,
        method:'POST',
        datatype:'JSON',
        data:fdata,
        success:function(response){
          response = JSON.parse(response);
          if(response == true)
          {
            toastr.success('Successfully Saved.');
            setTimeout(function(){
              location.reload();
            }, 3000);
          }
          else
          {
            toastr.error("Something went wrong!");
          }
        }
      });
    });
  });    
</script>