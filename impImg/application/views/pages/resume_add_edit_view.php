<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Resume')); ?></h5>
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
                    	<!-- <pre>
                      <?php// var_dump($View); ?>
                      </pre> -->
                    <form class="form-horizontal" role="form" action="<?php echo base_url('hr_recruitment/add'); ?>" method="post" id="hr_recruitment_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                         <div class="form-group">
                              <label  class="col-sm-3 control-label">Name : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo @$View['name']; ?>">
                              </div>
                                <span id="bank_name"></span>
                          </div>

                        <?php if((@$View['phone'] != NULL) && (!empty(@$View['phone']))) { 
                          $i = 0 ;
                          $phone = explode(',', $View['phone']);
                          foreach ($phone as $keyp => $valuep) {
                            $i++;
                            if($valuep != NULL) { ?>
                          <div class="form-group" id="<?php echo ($i !== 1) ? 'phone-div-'.$i : '';?>">
                              <label for="Branch Name" class="col-sm-3 control-label">Contact No : </label>
                              <div class="col-sm-5">
                                <input type="number" class="form-control" id="phone" name="phone-<?php echo $i; ?>" placeholder="Contact Number" min="100000" minlength="6" maxlength="12" value="<?php echo $valuep; ?>">
                              </div>
                              <div class="col-sm-1">
                                <?php if($i === 1) { ?>
                                  <button type="button" class="btn btn-white btn-bitbucket add_phone"> <i class="fa fa-plus"></i></button>
                                <?php } else { ?>
                                  <button type="button" class="btn btn-danger btn-bitbucket remove_phone" onclick="delete_phone('phone-div-<?php echo $i; ?>','yes','<?php echo @$View['ID'];?>','<?php echo $valuep; ?>');"><i class="fa fa-trash"></i></button>
                                <?php } ?>
                              </div>
                              <span id="phone"></span>
                          </div>
                        <?php } } ?>
                          <input type="hidden" id="row_count1" value="<?php echo count(@$phone); ?>">
                          <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$phone); ?>">
                          <div id="add-phone"></div>
                        <?php } else { ?>
                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Contact No : </label>
                              <div class="col-sm-5">
                                <input type="number" class="form-control" id="phone-1" name="phone-1" placeholder="Contact Number" min="100000" minlength="6" maxlength="12" value="<?php echo @$View['phone']; ?>">
                              </div>
                              <div class="col-sm-1">
                                <button type="button" class="btn btn-white btn-bitbucket add_phone"><i class="fa fa-plus"></i></button>
                              </div>
                              <span id="phone"></span>
                          </div>
                          <input type="hidden" id="row_count1" value="1">
                          <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$phone); ?>">
                          <div id="add-phone"></div>
                        <?php } ?>

                        <?php if((@$View['email'] != NULL) && (!empty(@$View['email']))) { 
                          $j = 0 ;
                          $email = explode(',', $View['email']);
                          foreach ($email as $keye => $valuee) {
                            $j++;
                            if($valuee != NULL) { ?>
                          <div class="form-group" id="<?php echo ($j !== 1) ? 'email-div-'.$j : '';?>">
                              <label for="Branch Name" class="col-sm-3 control-label">Email : </label>
                              <div class="col-sm-5">
                                <input type="email" class="form-control" id="email" name="email-<?php echo $j; ?>" placeholder="Email" value="<?php echo @$valuee; ?>">
                              </div>
                              <div class="col-sm-1">
                                <?php if($j === 1) { ?>
                                  <button type="button" class="btn btn-white btn-bitbucket add_email"> <i class="fa fa-plus"></i></button>
                                <?php } else { ?>
                                  <button type="button" class="btn btn-danger btn-bitbucket remove_email" onclick="delete_email('email-div-<?php echo $j; ?>','yes','<?php echo @$View['ID'];?>','<?php echo $valuee; ?>');"><i class="fa fa-trash"></i></button>
                                <?php } ?>
                              </div>
                              <span id="email"></span>
                          </div>
                          <?php } } ?>
                            <input type="hidden" id="row_count2" value="<?php echo count(@$email); ?>">
                            <input type="hidden" name="num_row2" id="num_row2" value="<?php echo count(@$email); ?>">
                            <div id="add-email"></div>
                          <?php } else { ?>
                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Email : </label>
                              <div class="col-sm-5">
                                <input type="email" class="form-control" id="email" name="email-1" placeholder="Email" value="<?php echo @$View['email']; ?>">
                              </div>
                              <div class="col-sm-1">
                                <button type="button" class="btn btn-white btn-bitbucket add_email"><i class="fa fa-plus"></i></button>
                              </div>
                              <span id="email"></span>
                          </div>
                            <input type="hidden" id="row_count2" value="<?php echo count(@$email); ?>">
                            <input type="hidden" name="num_row2" id="num_row2" value="<?php echo count(@$email); ?>">
                            <div id="add-email"></div>
                          <?php } ?>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Address : </label>
                              <div class="col-sm-6">
                                <textarea class="form-control" id="address" name="address" placeholder="Address"><?php echo @$View['address']; ?></textarea>
                              </div>
                                <span id="address"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Area : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="area" name="area" placeholder="Area" value="<?php echo @$View['area']; ?>">
                              </div>
                                <span id="email"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">City : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo @$View['city']; ?>">
                              </div>
                                <span id="email"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Qualification : </label>
                              <div class="col-sm-6">
                                <textarea class="form-control" id="qualification" name="qualification" placeholder="Qualification"><?php echo @$View['qualification']; ?></textarea>
                              </div>
                                <span id="qualification"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Gender : </label>
                              <div class="col-sm-6">
                                <span class="i-checks"><label>
                                  <input type="radio" value="male" name="gender" <?php if(!empty(@$View['gender'])){echo (@$View['gender']==='male'?'checked':''); }else{echo 'checked';} ?> > <i></i> Male</label>
                                </span>
                                <span class="i-checks"><label>
                                  <input type="radio" value="female" name="gender" <?php echo (@$View['gender']==='female'?'checked':'')?>> <i></i> Female</label>
                                </span>
                              </div>
                                <span id="gender"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Date of Birth : </label>
                              <div class="col-sm-6">
                                 <input type="text" id="" class="datepicker form-control" name="dob" placeholder="Date of Birth" value="<?php echo @$View['dob']; ?>">
                              </div>
                                <span id="dob"></span>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label">Designation : </label>
                            <div class="col-sm-6">
                              <select class="form-control chosen-select" id="dept_ID" placeholder="Batch" name="dept_ID[]" value="<?php @$View['dept_ID']; ?>" multiple required>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label">Upload Resume : </label>
                            <div class="col-sm-6">
                              <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                                <span class="fileinput-exists">Change</span>
                                  <input type="file" name="..."/ onChange="uploadFile(this)" />
                                  <input type="hidden" id="resume_ID" name="resume_ID" value="<?php echo @$View['resume_ID']; ?>">
                                </span>
                                <span class="fileinput-filename"><?php echo @$View['path']; ?></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                              </div> 
                            </div>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Work Experience : </label>
                              <div class="col-sm-6">
                                <div class="input-group">
                                  <input type="number" class="form-control" id="year" name="year" placeholder="Years" min="0" value="<?php echo @$View['year']; ?>">
                                  <span class="input-group-addon">Years</span>
                                  <input type="number" class="form-control" id="month" name="month" placeholder="Months" min="0" value="<?php echo @$View['month']; ?>">
                                  <span class="input-group-addon">Months</span>
                                </div>
                              </div>
                                <span id="we"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Current Salary : </label>
                              <div class="col-sm-6">
                                <div class="input-group">
                                  <input type="text" class="datepicker form-control" id="cdate" name="cdate" placeholder="Date" value="<?php echo @$View['cdate']; ?>">
                                  <span class="input-group-addon">On</span>
                                  <input type="number" class="form-control" id="csal" name="csal" placeholder="Salary" value="<?php echo @$View['csal']; ?>">
                                  <span class="input-group-addon">Rs./-</span>
                                </div>
                              </div>
                                <span id="email"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Expected Salary : </label>
                              <div class="col-sm-6">
                                <div class="input-group">
                                  <input type="text" class="datepicker form-control" id="edate" name="edate" placeholder="Date" value="<?php echo @$View['edate']; ?>">
                                  <span class="input-group-addon">On</span>
                                  <input type="number" class="form-control" id="esal" name="esal" placeholder="Salary" value="<?php echo @$View['esal']; ?>">
                                  <span class="input-group-addon">Rs./-</span>
                                </div>
                              </div>
                                <span id="email"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Description : </label>
                              <div class="col-sm-6">
                                <textarea class="form-control" id="desc" name="desc" placeholder="Description"><?php echo @$View['desc']; ?></textarea>
                              </div>
                                <span id="desc"></span>
                          </div>

         					</div>
                           
                        	<div class="form_footer">
                        	<div class="row">
                            	<div class="col-md-6 text-center col-md-offset-3 ">
                                        <button type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>
                                    </div>
                            	</div>

                            </form> 
                        

            </div>
        </div>
      </div>
    </div>    

<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<!-- Jasny -->
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/iCheck/icheck.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/cropper/cropper.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>

<script type="text/javascript">
  var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
  $('.datepicker').datepicker({
    format: js_date_format,
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true
  });
  $('.i-checks').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
  });
  getChosenData('dept_ID','TT',[{'label':'title','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['dept_ID']; ?>',true);
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  $(document).ready(function() {
    $("#hr_recruitment_add").postAjaxData(function(result){
      if(result === 1)
      {
        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
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


    $("#hr_recruitment_add").validate();
  });

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
      url: '<?php echo base_url("Team/upload_AnyFile");?>',
      success:function(response)
      {
        if (typeof response==='string')
        {
          $('#resume_ID').val(response);
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
          toastr.error("Something went wrong!");
        }
      }
    });
  }

  $('.add_phone').on('click',function(){
    var c = $("#row_count1").val();
    ++c;
    $('<div class="form-group" id="phone-div-'+c+'"><label for="" class="col-sm-3 control-label"></label><div class="col-sm-5"><input type="number" class="form-control" name="phone-'+c+'" placeholder="Contact Number" value="" min="100000" minlength="6" maxlength="12" required></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br></div>').appendTo('#add-phone');
    $("#row_count1").val(c);
  });

  $('.add_email').on('click',function(){
    var c = $("#row_count1").val();
    ++c;
    $('<div class="form-group" id="email-div-'+c+'"><label for="" class="col-sm-3 control-label"></label><div class="col-sm-5"><input type="text" class="form-control" name="email-'+c+'" placeholder="Email" required></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_email" onclick="remove_email(\'email-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br></div>').appendTo('#add-email');
    $("#row_count1").val(c);
  });

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

  function remove_email(phone_div,n)
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

  function delete_phone(prod_div,e,id,value)
  {
    bootbox.confirm('Are you sure you want to delete?', function(result) {
      if (result == true) {
        $.ajax({
          type:'POST',
          dataType:'json',
          data:{'ID':id,'type':'phone','value':value},
          url: '<?php echo base_url(); ?>'+'Hr_recruitment/delete_Field/',
          success:function(response){
            if(response === true)
            {
              var d = $("#row_count2").val();
              var k = --d;
              $("#row_count2").val(k);
              $('#'+prod_div).remove();
              toastr.success('Phone No deleted');
            }
            else
            {
              toastr.error('Something Went Wrong');
            }
          }
        });
      }
    });
  }

  function delete_email(prod_div,e,id,value) {
    bootbox.confirm('Are you sure you want to delete?', function(result) {
      if (result == true) {
        $.ajax({
          type:'POST',
          dataType:'json',
          data:{'ID':id,'type':'email','value':value},
          url: '<?php echo base_url(); ?>'+'Hr_recruitment/delete_Field/',
          success:function(response){
            if(response === true)
            {
              var d = $("#num_row1").val();
              var k = --d;
              $("#num_row1").val(k);
              $('#'+prod_div).remove();
              toastr.success('Email Deleted');
            }
            else
            {
              toastr.error('Something Went Wrong');
            }
          }
        });
      }
    });
  }
</script>