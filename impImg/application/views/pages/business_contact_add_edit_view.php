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
        <h5>Business Contact</h5>
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
          <form id="form" action="<?php echo base_url('Business_contact/add'); ?>" class="wizard-big" method="post">
              <input type="hidden" name="ID" value="<?php echo @$DETAIL['View'][0]['ID'];?>">
                
              <!-- <div class="col-sm-12 text-right" border="1"> -->
                <div class="row">
                  <div class="form-group">
                    <label for="Name" class="col-sm-3 control-label flt-left">Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo @$DETAIL['View'][0]['name']?>" required>
                    </div>
                    <span id="Name"></span>
                  </div>
                </div>
                <div class="row">
                  <br>
                   <div class="form-group">
                    <label for="Middle_Name" class="col-sm-3 control-label flt-left">Business Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="business_name" placeholder="Business Name" value="<?php echo @$DETAIL['View'][0]['business_name']?>">
                    </div>
                    <span id="business_name"></span>
                  </div>
                </div>

                <div class="row">
                <br>
                  <div class="form-group">
                    <label for="Email" class="col-sm-3 control-label flt-left">Email :</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo @$DETAIL['View'][0]['email']?>" required>
                    </div>
                    <span id="Email"></span>
                  </div>
                </div>

                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label flt-left">Business Category :</label>
                    <div class="col-sm-9 text-left">
                      <select class="form-control chosen-select" name="category_ID" id="category">
                      </select>
                    </div>
                    <span id="Gender"></span>
                  </div>
                </div>

                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label flt-left">Branch :</label>
                    <div class="col-sm-9 text-left">
                      <select class="form-control chosen-select" name="branch_ID" id="branch">
                      </select>
                    </div>
                    <span id=""></span>
                  </div>
                </div>

                <div class="row">
                <br>
                <?php 
                    if(isset($DETAIL['List']['Phone']) && (!empty($DETAIL['List']['Phone']))) 
                    {
                      $i = 0;
                      foreach(@$DETAIL['List']['Phone'] as $col_val)
                      {
                        $i++;
              ?>    
                          <div class="form-group" id="<?php echo ($i !== 1) ? 'phone-div-'.$i : '';?>">
                              <input type="hidden" name="PH-ID-<?php echo $i; ?>" value="<?php echo @$col_val['ID'];?>">
                              <label for="" class="col-sm-3 control-label"><?php echo ($i === 1) ? 'Phone no : ': ''; ?></label>
                              <div class="col-sm-3">
                                <select class="form-control" name="PH-phone_type-<?php echo $i; ?>">
                                  <option value="Work" <?php echo ($col_val['phone_type']) === 'Work' ? 'selected':''; ?>>Work</option>
                                  <option value="Home" <?php echo ($col_val['phone_type']) === 'Home' ? 'selected':''; ?>>Home</option>
                                  <option value="Mobile" <?php echo ($col_val['phone_type']) === 'Mobile' ? 'selected':''; ?>>Mobile</option>
                                  <option value="Personal" <?php echo ($col_val['phone_type']) === 'Personal' ? 'selected':''; ?>>Personal</option>
                                  <option value="Fax" <?php echo ($col_val['phone_type']) === 'Fax' ? 'selected':''; ?>>Fax</option>
                                  <option value="Main" <?php echo ($col_val['phone_type']) === 'Main' ? 'selected':''; ?>>Main</option>
                                </select>
                              </div>
                              <div class="col-sm-5">
                                <input type="number" class="form-control" name="PH-phone_number-<?php echo $i; ?>" placeholder="Phone no." value="<?php echo @$col_val['phone_number']; ?>" min="100000" minlength="6" maxlength="12">
                              </div>
                              <div class="col-sm-1">
                        <?php if($i === 1)
                              {
                        ?>
                                <button type="button" class="btn btn-white btn-bitbucket add_phone">
                                    <i class="fa fa-plus"></i>
                                </button>
                        <?php }
                              else
                              {
                        ?>
                                <button type="button" class="btn btn-danger btn-bitbucket remove_phone" onclick="delete_phone('phone-div-<?php echo $i; ?>','yes','<?php echo $col_val['ID']; ?>');"><i class="fa fa-trash"></i></button>
                        <?php }   
                        ?>
                              </div>
                              <br><br>
                                <span id="cst"></span>
                          </div>
                          
                <?php } ?>
                      <div id="add-phone">

                      </div>
                      <input type="hidden" id="row_count1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
                      <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">

              <?php }
                  else
                  {
              ?>  
                   <div class="form-group">
                    <label for="Contact" class="col-sm-3 control-label flt-left">Contact :</label>
                     <div class="col-sm-3">
                        <select class="form-control" name="PH-phone_type-1" >
                          <option value="Work">Work</option>
                          <option value="Home">Home</option>
                          <option value="Mobile">Mobile</option>
                          <option value="Personal">Personal</option>
                          <option value="Fax">Fax</option>
                          <option value="Main">Main</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <input type="number" class="form-control" name="PH-phone_number-1" placeholder="Phone no." value=""  min="100000" minlength="6" maxlength="12" required="required">
                      </div>
                      <div class="col-sm-1">
                        <button type="button" class="btn btn-white btn-bitbucket add_phone">
                            <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    <span id="phone_no_ID"></span>
                  </div>
                  <?php } ?>
                  <input type="hidden" id="row_count1" value="1">
                  <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
                </div>
                <div class="row" id="add-phone">
                </div>

                <div class="row">
                <br>
                <?php if(isset($DETAIL['List']['Address']) && !empty($DETAIL['List']['Address'])) 
                    {
                      $i = 0;

                      foreach(@$DETAIL['List']['Address'] as $col_val)
                      {
                        $i++;
            ?>
                          <div class="form-group" id="<?php echo ($i !== 1) ? 'address-div-'.$i : '';?>">
                              <input type="hidden" name="AD-ID-<?php echo $i; ?>" value="<?php echo @$col_val['ID'];?>">
                              <label for="cst_tin_no" class="col-sm-3 control-label"><?php echo ($i === 1) ? 'Address : ': ''; ?></label>
                              <div class="col-sm-3">
                                <select class="form-control" name="AD-address_type-<?php echo $i; ?>">
                                  <option value="Work" <?php echo ($col_val['address_type']) === 'Work' ? 'selected':''; ?>>Work</option>
                                  <option value="Home" <?php echo ($col_val['address_type']) === 'Home' ? 'selected':''; ?>>Home</option>
                                </select>
                              </div>
                              <div class="col-sm-5">
                                <textarea type="text" class="form-control" name="AD-address-<?php echo $i; ?>" placeholder="Address" required><?php echo @$col_val['address']; ?></textarea>
                              </div>
                              <div class="col-sm-1">
                      <?php if($i === 1)
                            {
                      ?>
                              <button type="button" class="btn btn-white btn-bitbucket add_address">
                                  <i class="fa fa-plus"></i>
                              </button>
                      <?php }
                            else
                            {
                      ?>
                              <button type="button" class="btn btn-danger btn-bitbucket" onclick="delete_adr('address-div-<?php echo $i; ?>','yes','<?php echo $col_val['ID']; ?>');"><i class="fa fa-trash"></i></button>
                      <?php }   
                      ?>
                              </div>
                              <br><br><br>
                                <span id="cst"></span>
                          </div>
                <?php } ?>
                          <div id="add-address">
                          </div>
                          <input type="hidden" id="row_count2" value="<?php echo count(@$DETAIL['List']['Address']); ?>">
                          <input type="hidden" name="num_row2" id="num_row2" value="<?php echo (!empty($DETAIL['List']['Address'])) ? count(@$DETAIL['List']['Address']) : 0; ?>">
              <?php }
                  else
                  {
              ?>
                   <div class="form-group">
                    <label for="Contact" class="col-sm-3 control-label flt-left">Address :</label>
                     <div class="col-sm-3">
                        <select class="form-control" name="AD-address_type-1" >
                          <option value="Work">Work</option>
                          <option value="Home">Home</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <textarea type="text" class="form-control" name="AD-address-1" placeholder="Address" required></textarea>
                      </div>
                      <div class="col-sm-1">
                        <button type="button" class="btn btn-white btn-bitbucket add_address">
                            <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    <span id="address_ID"></span>
                  </div>
                  <?php } ?>
                  <input type="hidden" id="row_count2" value="1">
                  <input type="hidden" name="num_row2" id="num_row2" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
                </div>
                <div class="row" id="add-address">
                </div>

              <!-- </div> -->
            <!-- </div> -->
              <!-- <br> -->

              <div class="row">
                <br>
                 <div class="form-group">
                  <label for="reference" class="col-sm-3 control-label flt-left">Reference :</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" name="reference" placeholder="Reference"><?php echo @$DETAIL['View'][0]['reference']?></textarea>
                    <!-- <input type="text" class="form-control" name="reference" placeholder="Reference" value="<?php echo @$DETAIL[0]['reference']?>"> -->
                  </div>
                  <span id="website"></span>
                </div>
              </div>

              <div class="row">
                <br>
                 <div class="form-group">
                  <label for="website" class="col-sm-3 control-label flt-left">Website :</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="website" placeholder="Website" value="<?php echo @$DETAIL['View'][0]['website']?>">
                  </div>
                  <span id="website"></span>
                </div>
              </div>

        </div> <!-- end of well -->


          <!-- <div class="row">
          <div class="col-sm-2 col-sm-offset-8">
            <button type="submit" class="btn btn-primary" >Next</button>
            </form>
          </div>
        </div> -->
        <div class="form_footer">
                          <div class="row">
                              <div class="col-md-6 text-center col-md-offset-3 ">
                                        <button type="submit" class="btn btn-primary"><?php echo isset($DETAIL['What']) ? 'Update' : 'Add'; ?></button>
                                    </div>
                              </div>

                            </form> 
                        

            </div>
      <!-- </div> -->
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
<script src="<?php echo base_url("js/plugins/cropper/cropper.min.js"); ?>"></script>
<script>
$.validator.setDefaults({ 
    ignore: [],
    // any other default options and/or rules
});
// $.validator.setDefaults({ ignore: ":hidden:not(select)" });
$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })
var base_url="<?php echo base_url(); ?>"
id="<?php echo @$id; ?>";
$("#form").validate();


$("#form").postAjaxData(function(result)
    {
      console.log(typeof result);
      // if(result === 1)
      // {
      //   window.location.href = "<?php echo base_url('Student/add/step1/"+id+"'); ?>"
      // }
      // else
      // {
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
          var type = "<?php echo isset($DETAIL['What']) ? 'Updated' : 'Added'; ?>";
          toastr.success('Successfully '+type+'.');
          setTimeout(function(){
            window.location.href = "<?php echo current_url(); ?>";
          }, 3000);
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      // }
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
              toastr.error("Please select Image.");
          }
        }
      });
}


var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
$('.datepicker').datepicker({
  format: js_date_format,
  keyboardNavigation: false,
  forceParse: false,
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
              toastr.error("Please select Image.");
          }
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
  console.log(c);
  ++c;
  $('<div class="form-group" id="phone-div-'+c+'"><br><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="PH-phone_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option><option value="Mobile">Mobile</option><option value="Personal">Personal</option><option value="Fax">Fax</option><option value="Main">Main</option></select></div><div class="col-sm-5"><input type="number" class="form-control" name="PH-phone_number-'+c+'" placeholder="Phone no." value="" required  min="100000" minlength="6" maxlength="12"></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br></div>').appendTo('#add-phone');
  $("#row_count1").val(c);
});

$('.add_address').on('click',function(){
  var c = $("#row_count2").val();
  ++c;
  $('<div class="form-group" id="address-div-'+c+'"><br><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="AD-address_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option></select></div><div class="col-sm-5"><textarea class="form-control" name="AD-address-'+c+'" placeholder="Address" required></textarea></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_address" onclick="remove_address(\'address-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br><br></div>').appendTo('#add-address');
  $("#row_count2").val(c);
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

function delete_phone(prod_div,e,id)
{
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Business_contact/delete_Field/'+id,
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
        url: '<?php echo base_url(); ?>'+'Business_contact/delete_Field/'+id,
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
// [{'description':'des','name':'SSC'}]
getChosenData('board','BO',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['prevDetail']['Board']?>');
getChosenData('branch','BR',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['View'][0]['branch_ID']?>');
getChosenData('category','BSC',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['View'][0]['category_ID']?>',true);
</script>