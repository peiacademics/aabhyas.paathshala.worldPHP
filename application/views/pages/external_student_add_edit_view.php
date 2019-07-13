<style type="text/css">
  
.flt-left{float: left;}

.pad-rgt{padding-right: 10px;
         display: inline;
         }

.mgr-left{margin-left: -22px}

@media (max-width: 768px){

  .pad-rgt{
   display: inline;
    float: left;
    width: 33px;
    margin: 10px 30px 0px 20px;
  }

  .pad-rgt a{font-size: 10px;}

  .mgr-left{margin-left: -45px;}
}

</style>
<div class="row">
  <div class="col-lg-12">
    <div class="ibox">
      <div class="ibox-title">
        <h5>External Student Add</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
          <a class="close-link">
            <i class="fa fa-times"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">
        
        <div class="well">
          <form id="form" action="<?php echo base_url('external_student/add'); ?>" class="wizard-big" method="post">
              <h2>Student Info</h2>
              <div class="row text-center">
              <span class="text-danger text-right"><i>Mandatory fields marked by (*) mark !</i></span><br><br>
              <div class="col-sm-12 text-right" border="1">
                <input type="hidden" name="ID" value="<?php echo @$View['ID']; ?>">
                <div class="row">
                  <div class="form-group">
                    <label for="Name" class="col-sm-3 control-label pull-left"><span class="text-danger text-right"><i>*</i></span> Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Name" placeholder="Name" value="<?php echo @$View['Name']?>" required>
                    </div>
                    <span id="Name"></span>
                  </div>
                </div>
                <div class="row">
                  <br>
                   <div class="form-group">
                    <label for="Middle_Name" class="col-sm-3 control-label pull-left">Middle Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Middle_name" placeholder="Middle Name" value="<?php echo @$View['Middle_name']?>">
                    </div>
                    <span id="Middle_Name"></span>
                  </div>
                </div>
                <div class="row">
                  <br>
                   <div class="form-group">
                    <label for="Last_Name" class="col-sm-3 control-label pull-left">Last Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Last_name" placeholder="Last Name" value="<?php echo @$View['Last_name']?>">
                    </div>
                    <span id="Last_Name"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                  <div class="form-group">
                    <label for="Email" class="col-sm-3 control-label pull-left"><span class="text-danger text-right"><i>*</i></span> Email :</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo @$View['Email']?>" required>
                    </div>
                    <span id="Email"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                  <div class="form-group">
                    <label for="Password" class="col-sm-3 control-label pull-left"><span class="text-danger text-right"><i>*</i></span> Login Password :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Password" placeholder="Password" value="<?php echo @$View['Password']?>" required>
                    </div>
                    <span id="Password"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label pull-left">DOB :</label>
                    <div class="col-sm-9">
                      <input type="text" id="" class="datepicker form-control" name="DOB" placeholder="Date of Birth" value="<?php echo (@$View['DOB'] == NULL) ? '' : $this->date_library->db2date(@$View['DOB'],$this->date_library->get_date_format()); ?>">
                    </div>
                    <span id="DOB"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label pull-left">Gender :</label>
                    <div class="col-sm-9 text-left">
                      <span class="i-checks"><label>
                        <input type="radio" value="male" name="Gender" <?php if(!empty(@$View['Gender'])){echo (@$View['Gender']==='male'?'checked':''); }else{echo 'checked';} ?> > <i></i> Male</label>
                      </span>
                      <span class="i-checks"><label>
                        <input type="radio" value="female" name="Gender" <?php echo (@$View['Gender']==='female'?'checked':'')?>> <i></i> Female</label>
                      </span>
                    </div>
                    <span id="Gender"></span>
                  </div>
                </div>

                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label pull-left">Pacakges :</label>
                    <div class="col-sm-9 text-left">
                      <select class="form-control chosen-select" name="package_ID[]" id="lang" multiple>
                      </select>
                    </div>
                    <span id="Gender"></span>
                  </div>
                </div>

                <div class="row">
                  <br>
                   <div class="form-group">
                    <label for="Last_Name" class="col-sm-3 control-label pull-left"><span class="text-danger text-right"><i>*</i></span> Phone Number :</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" name="phone" placeholder="Contact Number" value="<?php echo @$View['phone']?>" required>
                    </div>
                    <span id="Last_Name"></span>
                  </div>
                </div>

                <div class="row">
                  <br>
                   <div class="form-group">
                    <label for="Last_Name" class="col-sm-3 control-label pull-left">Address :</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" rows="3" name="address" placeholder="Address"><?php echo @$View['address']?></textarea>
                    </div>
                    <span id="Last_Name"></span>
                  </div>
                </div>

              </div>
            </div>

        </div> <!-- end of well -->


          <div class="row">
          <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>
            </form>
          </div>
        </div>
      </div>
  </div>
  </div>
</div>

<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<!-- Jasny -->
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<link href="<?php echo base_url('css/plugins/steps/jquery.steps.css'); ?>" rel="stylesheet">
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- SUMMERNOTE -->
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<!-- Date -->
<script src="<?php echo base_url("js/plugins/iCheck/icheck.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/cropper/cropper.min.js"); ?>"></script>
<script>
$.validator.setDefaults({ 
    ignore: [],
    // any other default options and/or rules
});

$('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
  });
// $.validator.setDefaults({ ignore: ":hidden:not(select)" });
$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })
var base_url="<?php echo base_url(); ?>"
id="<?php echo @$id; ?>";
$("#form").validate();


$("#form").postAjaxData(function(result)
    {
      if(result == true)
      {
        // window.location.href = "<?php //echo base_url('external_student/add/"+id+"'); ?>"
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
        else if(typeof result === 'string')
        {
          window.location.href = "<?php echo base_url('external_student/add/"+result+"'); ?>"
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });


function uploadFile(f,id) {
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
        url: '<?php echo base_url("student/upload_AnyFile");?>',
        success:function(response)
        {
          if (typeof response==='string')
          {
            $('#'+id).val(response);
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


var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
$('.datepicker').datepicker({
  format: js_date_format,
  keyboardNavigation: false,
  forceParse: false,
  startDate: '-20y',
  endDate: '-15y',
  autoclose: true
});


    $('#setConfirm').on('click',function(){
    $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
      $("#Login_screen").fadeIn('fast');
        var data1=$($image).cropper('getData');
        var file_data = $('#inputImage').prop('files')[0]; 
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('cropdata', JSON.stringify(data1));
      $.ajax({
        datatype:'text',
        data:form_data,
        type:'POST',
        cache: false,
        contentType: false,
        processData: false,
        url: '<?php echo base_url("Settings/image_upload");?>',
        success:function(response)
        {
        $("#Login_screen").fadeOut(2000);
          if (typeof response==='object')
          {
            $('#imgID').val(response['ID']);
            $('#imgUploadBx').modal('hide');
            path="<?php echo base_url(); ?>"+response['path'];
            $("#pImg").fadeOut(1500,function(){
              $('#pImg').attr("src",path);
              $("#pImg").fadeIn(1500);
            });
          }
          else
          {
             toastr.error("Something went wrong!");
          }
            // console.log(response['ID']); 
        }
      });
    });

    var $image = $(".image-crop > img")
    $($image).cropper({
        aspectRatio: 1.618,
        preview: ".img-preview",
        done: function(data) {

            // Output the result data for cropping image.
        }
    });

    setTimeout(function(){
     $(".cropper-dragger").remove();
     $(".cropper-canvas").removeClass('cropper-modal');
     $(".cropper-canvas").removeClass('cropper-canvas');
    },100);
    var $inputImage = $("#inputImage");
    if (window.FileReader) {
        $inputImage.change(function() {
              // $("div").removeClass("cropper-dragger");

            var fileReader = new FileReader(),
                    files = this.files,
                    file;
            if (!files.length) {
                return;
            }
            file = files[0];
             //console.log(file);
            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $image.cropper("reset", true).cropper("replace", this.result);
                    setTimeout(function(){
                     $(".cropper-dragger").remove();
                     $(".cropper-canvas").removeClass('cropper-modal');
                     $(".cropper-canvas").removeClass('cropper-canvas');
                    },100);

                };
            } else {
                showMessage("Please choose an image file.");
            }
        });
    } else {
        $inputImage.addClass("hide");
    }


$('.add_phone').on('click',function(){
  var c = $("#row_count1").val();
  ++c;
  $('<div class="form-group" id="phone-div-'+c+'"><br><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="PH-phone_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option><option value="Mobile">Mobile</option><option value="Personal">Personal</option><option value="Fax">Fax</option><option value="Main">Main</option></select></div><div class="col-sm-5"><input type="number" class="form-control" name="PH-phone_number-'+c+'" placeholder="Phone no." value="" min="100000" minlength="6" maxlength="12" required></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br></div>').appendTo('#add-phone');
  $("#row_count1").val(c);
});

$('.add_address').on('click',function(){
  var c = $("#row_count2").val();
  ++c;
  $('<div class="form-group" id="address-div-'+c+'"><br><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="AD-address_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option></select></div><div class="col-sm-5"><textarea class="form-control" name="AD-address-'+c+'" placeholder="Address" required></textarea></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_address" onclick="remove_address(\'address-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br><br></div>').appendTo('#add-address');
  $("#row_count2").val(c);
});

$('.add_doc').on('click',function(){
  var c = $("#row_count3").val();
  ++c;
  $('<div class="row"><div class="col-sm-6"><div class="form-group" id="doc-div-'+c+'"><label for="" class="col-sm-6 control-label"></label><div class="col-sm-5"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,\'document_ID'+c+'\')"/ required></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a></div></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket add_doc" onclick="remove_doc(\'doc-div-'+c+'\');"><i class="fa fa-times"></i></button></div><input type="hidden" name="DC-document_ID-'+c+'" id="document_ID'+c+'"></div></div></div>').appendTo('#add-doc');
  $("#row_count3").val(c);
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

   function remove_doc(phone_div,n)
  {
    if(n == 'yes')
    {
      var d = $("#num_row3").val();
      var k = --d;
      $("#num_row3").val(k);
    }
    else
    {
      var c = $("#row_count3").val();
      var j = --c;
      $("#row_count3").val(j);
    }
      $('#'+phone_div).remove();
  }

function delete_doc(prod_div,e,id,std) {
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Student/delete_File/'+id+'/'+std,
        success:function(response){
          if(response === true)
          {
            var d = $("#row_count3").val();
            var k = --d;
            $("#row_count3").val(k);
            $('#'+prod_div).remove();
            toastr.success('File deleted');
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
function delete_phone(prod_div,e,id)
{
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Student/delete_Field/'+id,
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

function delete_adr(prod_div,e,id) {
    bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Student/delete_Field/'+id,
        success:function(response){
          if(response === true)
          {
            var d = $("#num_row1").val();
            var k = --d;
            $("#num_row1").val(k);
            $('#'+prod_div).remove();
            toastr.success('Address Deleted');
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

// where
// [{'description':'des','name':'SSC'}] branch_ID
getChosenData('lang','APG',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['package_ID']?>',true);
</script>