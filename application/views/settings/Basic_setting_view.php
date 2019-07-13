<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Basic Setting ')); ?></h5>
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
    <form class="form-horizontal" role="form" action="<?php echo base_url('settings/basic_setting'); ?>" method="post" id="date_time_update">
      <div class="body_text_text">
       <div class="form-group">
            <label for="Company_Name" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="Name" placeholder="Name" value="<?php echo @$DETAIL['user_detail'][0]['Name']?>">
            </div>
            <span id="Name"></span>
        </div>
 
       <div class="form-group">
            <label for="Company_Name" class="col-sm-3 control-label">Company Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="Company_Name" placeholder="Company Name" value="<?php echo @$DETAIL['user_detail'][0]['Company_Name']?>">
            </div>
            <span id="Company_Name"></span>
        </div>

         <div class="form-group">
            <label for="Address" class="col-sm-3 control-label">Address</label>
            <div class="col-sm-6">
              <textarea class="form-control" name="Address" placeholder="Address" value="<?php echo @$DETAIL['user_detail'][0]['Address']?>"><?php echo @$DETAIL['user_detail'][0]['Address']?></textarea>
            </div>
            <span id="Address"></span>
        </div>

         <div class="form-group">
            <label for="Contact" class="col-sm-3 control-label">Contact</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" name="Contact" placeholder="Contact" value="<?php echo @$DETAIL['user_detail'][0]['Contact']?>">
            </div>
            <span id="Contact"></span>
        </div>

        <div class="form-group">
          <label for="Contact" class="col-sm-3 control-label">Currency</label>
          <div class="col-sm-6">
            <select id="contact" data-placeholder="Select A Client..." class="form-control chosen-select" name="currency_ID">


            <option value="">Please Select</option>
            
              <?php 


              if($DETAIL['currency'] != FALSE) {
                    foreach ($DETAIL['currency'] as $key => $value) {

                          if(isset($DETAIL['user_detail']) && $value['ID'] == $DETAIL['user_detail'][0]['currency_ID'] ){
              ?>
                            <option value="<?php echo $value['ID']; ?>" selected> <?php echo $value['title']; ?></option>
              <?php       }
                          else{
              ?>            <option value="<?php echo $value['ID']; ?>"> <?php echo $value['title']; ?></option>
                     
              <?php       }    
                    }
              }
              else{ ?>
                  <option value="">Data Not Found.</option>
              <?php } ?> 
              </select>
          </div>
        </div>

         <div class="form-group">
            <label for="Contact" class="col-sm-3 control-label">VAT Tin No.</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="vat_tin_no" placeholder="VAT tin no." value="<?php echo @$DETAIL['user_detail'][0]['vat_tin_no']?>">
            </div>
            <span id="Vat_tin_no"></span>
        </div>

         <div class="form-group">
            <label for="Contact" class="col-sm-3 control-label">CST Tin No.</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="cst_tin_no" placeholder="CST tin no." value="<?php echo @$DETAIL['user_detail'][0]['cst_tin_no']?>">
            </div>
            <span id="Cst_tin_no"></span>
        </div>

        <div class="form-group">
          <label for="Contact" class="col-sm-2 control-label"></label>
          <div class="col-sm-1">
            <input type="checkbox" class="form-control" name="is_discount"value="Yes" <?php echo (@$DETAIL['user_detail'][0]['is_discount']=='Yes')? 'checked':''; ?>>
          </div>
            <label for="Contact" class="col-sm-1 control-label">Do you want discount?</label>
          <span id="Cst_tin_no"></span>
        </div>

         <div class="form-group">
            <label for="Business_name" class="col-sm-3 control-label">Upload Image  : </label>
            <div class="col-sm-6">
              <a data-toggle="modal" class="btn btn-primary" href="#imgUploadBx"><i class="fa fa-upload"></i> Upload</a>
            </div>
            <input type="hidden" name="Image_ID" id="imgID" value="<?php echo @$DETAIL['user_detail'][0]['Image_ID']; ?>">
             <span id="Image_ID"></span>
        </div>
      </div>
           
      <div class="form_footer">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </div>
    </form> 
  </div>
</div>
</div>
</div>
 
<div id="imgUploadBx" class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content animated flipInY">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="starter-template">
                      <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="image-crop">
                                <?php
                                $img_path = $this->str_function_library->call('fr>SS>path:ID=`'.$DETAIL['user_detail'][0]['Image_ID'].'`');
                             ?>
                                    <img src="<?php echo @base_url($img_path); ?>">
                                </div> 
                            </div>
                            <form id="iUpload" action="#" method="post">
                            <div class="col-md-6">
                                <h4>Preview image</h4>
                                <div class="img-preview img-preview-sm hidden"></div>
                                <div class="btn-group">
                                    <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                        <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
                                        <i class="fa fa-upload"></i>Upload new image
                                    </label>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-warning" id="setConfirm" type="button">Done</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
  </div>
<!-- iCheck -->
<link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('js/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url("js/plugins/cropper/cropper.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Gritter -->
<link href="<?php echo base_url("js/plugins/gritter/jquery.gritter.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/plugins/gritter/jquery.gritter.min.js"); ?>"></script>
<!-- Chosen -->
<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.chosen-select').chosen();
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

    $('#setConfirm').on('click',function(){
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
          if (typeof response==='object')
          {
            $('#imgID').val(response['ID']);
            $('#imgUploadBx').modal('hide');
          }
          else
          {
              swal("Oops...", "Please select image!", "error");
          }
            // console.log(response['ID']); 
        }
      });
    });
    
    $("#date_time_update").validate({
                 rules: {
                     Address: {
                         required: true,
                     },
                     Company_Name: {
                         required: true,
                     },
                     Contact: {
                         required: true,
                     }
                 }
             });

    $("#date_time_update").postAjaxData(function(result){
      var d = $('#date_time_update').serializeArray();
      $.each(d,function(obj,col){
                //$.each(col,function(column,value){
                  console.log(col.name);
                  $("#"+col.name).text('');
                //});
      });
      //alert(result);
      if(result === 1)
      {
          $("#success").html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Settings Updated Successfully.</div>');
      }
      else {
        if(typeof result === 'object')
        {
          // alert(result);
          console.log(result);
          $.each(result,function(dom,err){
            $("#"+dom).text(err);
          });
        }
        else
        {
          alert('something went wrong.');
        }
      }
    });
  });    
</script>