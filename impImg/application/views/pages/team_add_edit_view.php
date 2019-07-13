<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Staff')); ?>- <code><?php echo @$DETAIL[0]['Name']?></code></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div>
<div class="ibox-content">
<div class="page-content">
  <div class="wrap">
  <?php //print_r($DETAIL); ?>
    <h4 id="success" style="text-align:center;"></h4>
    <form class="form-horizontal" role="form" action="<?php echo base_url('team/add'); ?>" method="post" id="date_time_update">

      <div class="body_text_text">
      <input type="hidden" name="ID" value="<?php echo @$DETAIL[0]['ID']?>">
      <div class="form-group">
            <div class="col-sm-6 col-sm-offset-4">
            <?php
              if (!empty($DETAIL[0]['Image_ID'])) 
              {
                $img_path = $this->str_function_library->call('fr>SS>path:ID=`'.$DETAIL[0]['Image_ID'].'`'); 
              }
              else
              {
                $img_path = 'img/employee.jpg';
              }
             ?>
              <img alt="image" width="300" id="pImg" class="img-circle1 img-responsive" src="<?php echo base_url($img_path);?>">
               <input type="hidden" id="imgID" name="Image_ID" value="<?php echo @$DETAIL[0]['Image_ID']?>">
            </div>
            <span id="Name"></span>
        </div>

        <div class="form-group text-center">
          <div class=""> 
            <a data-toggle="modal" class="btn btn-primary" href="#imgUploadBx"><i class="fa fa-upload"></i> Upload</a>
          </div>
        </div>

        <div class="form-group">
            <label for="Company_Name" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="Name" placeholder="Name" value="<?php echo @$DETAIL[0]['Name']?>">
            </div>
            <span id="Name"></span>
        </div>

        <div class="form-group">
          <label for="DOB" class="col-sm-3 control-label flt-left">Designation :</label>
          <div class="col-sm-6 text-left">
            <select class="form-control chosen-select" name="Type" id="des" required>
            </select>
          </div>
          <span id="Gender"></span>
        </div>

        <div class="form-group">
          <label for="DOB" class="col-sm-3 control-label flt-left">Subjects :</label>
          <div class="col-sm-6 text-left">
            <select class="form-control chosen-select" placeholder="Select Subject" name="subject_ID[]" id="subject_ID" multiple>
            </select>
          </div>
          <span id="Gender"></span>
        </div>

        <div class="form-group">
          <label for="DOB" class="col-sm-3 control-label flt-left">Reporting Authority :</label>
          <div class="col-sm-6 text-left">
            <select class="form-control chosen-select" name="reporting_to" id="reporting" required>
            </select>
          </div>
          <span id="Gender"></span>
        </div>

        <div class="form-group">
          <label for="DOB" class="col-sm-3 control-label flt-left">Branch :</label>
          <div class="col-sm-6 text-left">
            <select class="form-control chosen-select" name="branch_ID" id="branch" required>
            </select>
          </div>
          <span id="Gender"></span>
        </div>

        <div class="form-group">
          <label for="DOB" class="col-sm-3 control-label flt-left">Seniority 1 :</label>
          <div class="col-sm-6 text-left">
            <select class="form-control chosen-select" name="seniority1_ID" id="seniority1" required>
            </select>
          </div>
          <span id="Gender"></span>
        </div>

        <div class="form-group">
          <label for="DOB" class="col-sm-3 control-label flt-left">Seniority 2 :</label>
          <div class="col-sm-6 text-left">
            <select class="form-control chosen-select" name="seniority2_ID" id="seniority2" required>
            </select>
          </div>
          <span id="Gender"></span>
        </div>

        <div class="form-group">
          <label for="DOB" class="col-sm-3 control-label flt-left">Seniority 3 :</label>
          <div class="col-sm-6 text-left">
            <select class="form-control chosen-select" name="seniority3_ID" id="seniority3" required>
            </select>
          </div>
          <span id="Gender"></span>
        </div>
        
        <div class="form-group">
            <label for="Email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-6">
              <input type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo @$DETAIL[0]['Email']?>" required>
            </div>
            <span id="employee_ID"></span>
        </div>

        <div class="form-group">
            <label for="Password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="Password" placeholder="Password" value="<?php echo @$DETAIL[0]['Password']?>" required>
            </div>
            <span id="employee_ID3"></span>
        </div>        

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
                                <button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone('phone-div-<?php echo $i; ?>','yes');"><i class="fa fa-close"></i></button>
                        <?php }   
                        ?>
                              </div>
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
              ?>        <div class="form-group">
                              <label for="" class="col-sm-3 control-label">Phone no : </label>
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
                                <input type="number" class="form-control" name="PH-phone_number-1" placeholder="Phone no." value="<?php echo @$View['phone_no_ID']; ?>"  min="100000" minlength="6" maxlength="12" required="required">
                              </div>
                              <div class="col-sm-1">
                                <button type="button" class="btn btn-white btn-bitbucket add_phone">
                                    <i class="fa fa-plus"></i>
                                </button>
                              </div>
                                <span id="cst"></span>
                          </div>
                          <div id="add-phone">
                          </div>       
                          <input type="hidden" id="row_count1" value="1">
                          <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
            <?php 
                  }
            ?>

            <?php if(isset($DETAIL['List']['Address']) && (!empty($DETAIL['List']['Address']))) 
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
                              <button type="button" class="btn btn-white btn-bitbucket remove_address" onclick="remove_address('address-div-<?php echo $i; ?>','yes');"><i class="fa fa-close"></i></button>
                      <?php }   
                      ?>
                              </div>
                                <span id="cst"></span>
                          </div>
                <?php } ?>
                          <div id="add-address">
                          </div>
                          <input type="hidden" id="row_count2" value="<?php echo count(@$DETAIL['List']['Address']); ?>">
                          <input type="hidden" name="num_row2" id="num_row2" value="<?php echo count(@$DETAIL['List']['Address']); ?>">
              <?php }
                  else
                  {
              ?>
                          <div class="form-group">
                              <label for="cst_tin_no" class="col-sm-3 control-label">Address : </label>
                              <div class="col-sm-3">
                                <select class="form-control" name="AD-address_type-1" required="required">
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
                                <span id="cst"></span>
                          </div>
                          <div id="add-address">
                          </div>
                          <input type="hidden" id="row_count2" value="1">
                          <input type="hidden" name="num_row2" id="num_row2" value="<?php echo count(@$DETAIL['List']['Address']); ?>">
              <?php 
                  }
              ?>
        <div class="form-group">
            <label for="Salary" class="col-sm-3 control-label">Salary</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" name="salary" placeholder="Salary" value="<?php echo @$DETAIL[0]['salary']?>">
            </div>
            <span id="salary"></span>
        </div>

        <?php if (empty(@$DETAIL[0]['document_ID'])) { ?>
        <div class="row">
          <br>
            <div class="col-sm-6">
              <div class="form-group" id="doc-div-1">
                  <label for="" class="col-sm-6 control-label">Documents</label>
                  <div class="col-sm-5">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                      <span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,'document_ID1')" required /></span>
                      <span class="fileinput-filename"><?php echo @$DETAIL['doc'][0]['path']; ?></span>
                      <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                    </div> 
                  </div>
                  <div class="col-sm-1">
                    <button type="button" class="btn btn-white btn-bitbucket add_doc">
                        <i class="fa fa-plus"></i>
                    </button>
                  </div>
                  <input type="hidden" id="row_count3" value="1">
                  <input type="hidden" name="DC-document_ID-1" id="document_ID1" value="<?php echo @$DETAIL['doc'][0]['ID']; ?>" required>
              </div>
            </div>
          </div>
          <?php }else{
            $x=0;
            foreach ($DETAIL['doc'] as $key => $value) { 
              ++$x; ?>
          <div class="row">
            <br>
              <div class="col-sm-6">
                <div class="form-group" id="doc-div-<?php echo $x; ?>">
                    <label for="" class="col-sm-6 control-label">
                     <?php if ($x===1) { ?>Scanned copy JPG or PDF of Previous years marksheet
                     <?php }?></label>
                    <div class="col-sm-5">
                      <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,'document_ID<?php echo $x; ?>')" /></span>
                        <span class="fileinput-filename"><?php echo substr($value['path'], 19);; ?></span>
                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                      </div> 
                    </div>
                    <div class="col-sm-1">
                    <?php if ($x===1) { ?>
                      <button type="button" class="btn btn-white btn-bitbucket add_doc">
                          <i class="fa fa-plus"></i>
                      </button>
                      <?php }else{ ?>
                      <button type="button" class="btn btn-danger btn-bitbucket" onclick="delete_doc('doc-div-<?php echo $x; ?>','<?php echo $x; ?>','<?php echo $value['ID']; ?>','<?php echo $DETAIL[0]['ID']; ?>')">
                          <i class="fa fa-trash"></i>
                      </button>
                    <?php } ?>
                      
                    </div>
                    <input type="hidden" name="DC-document_ID-<?php echo $x; ?>" id="document_ID<?php echo $x; ?>" value="<?php echo  $value['ID']; ?>" required>
                </div>
              </div>
            </div>
            <?php }?>
            <input type="hidden" id="row_count3" value="<?php echo  count(@$DETAIL['doc']); ?>">
          <?php } ?>
          <div id="add-doc">
          </div>


        <div class="form-group">
            <label for="Company_Name" class="col-sm-3 control-label">Details</label>
            <div class="col-sm-6">
              <textarea type="text" class="form-control" name="details" placeholder="Details"><?php echo @$DETAIL[0]['details']?></textarea>
            </div>
            <span id="Name"></span>
        </div>
      </div>
           
      <div class="form_footer">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary"><?php echo isset($DETAIL['What']) ? 'Update' : 'Add'; ?></button>
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

<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<!-- Jasny -->
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/cropper/cropper.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

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
            toastr.error("Please select image!");
          }
        }
      });
    });
    $.validator.setDefaults({ ignore: ":hidden:not(select)" });
    $("#date_time_update").validate();

    $("#date_time_update").postAjaxData(function(result){
      var type = "<?php echo isset($DETAIL['What']) ? 'Updated' : 'Added'; ?>";
      if(result === 1)
      {
        toastr.success('Successfully '+type+'.');
        setTimeout(function(){
          window.location.href = "<?php echo current_url(); ?>";
        }, 3000);
      }
      else {
        if(typeof result === 'object')
        {
          $.each(result,function(dom,err){
            $("#"+dom).text(err);
          });
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
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
        url: '<?php echo base_url("Team/upload_AnyFile");?>',
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
            toastr.error("Please select image!");
          }
        }
      });
}


  $('.add_phone').on('click',function(){
      var c = $("#row_count1").val();
      ++c;
      $('<div class="form-group" id="phone-div-'+c+'"><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="PH-phone_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option><option value="Mobile">Mobile</option><option value="Personal">Personal</option><option value="Fax">Fax</option><option value="Main">Main</option></select></div><div class="col-sm-5"><input type="number" class="form-control" name="PH-phone_number-'+c+'" placeholder="Phone no." value="" required  min="100000" minlength="6" maxlength="12"></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div><span id="cst"></span></div>').appendTo('#add-phone');
      $("#row_count1").val(c);
    });



    $('.add_address').on('click',function(){
      var c = $("#row_count2").val();
      ++c;
      $('<div class="form-group" id="address-div-'+c+'"><label for="cst_tin_no" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="AD-address_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option></select></div><div class="col-sm-5"><textarea type="text" class="form-control" name="AD-address-'+c+'" placeholder="Address" required></textarea></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_address" onclick="remove_address(\'address-div-'+c+'\');"><i class="fa fa-close"></i></button></div><span id="cst"></span></div>').appendTo('#add-address');
      $("#row_count2").val(c);
    });

$('.add_doc').on('click',function(){
  var c = $("#row_count3").val();
  ++c;
  $('<div class="row"><div class="col-sm-6"><div class="form-group" id="doc-div-'+c+'"><label for="" class="col-sm-6 control-label"></label><div class="col-sm-5"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,\'document_ID'+c+'\')" required/></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a></div></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket add_doc" onclick="remove_doc(\'doc-div-'+c+'\');"><i class="fa fa-times"></i></button></div><input type="hidden" name="DC-document_ID-'+c+'" id="document_ID'+c+'" required></div></div></div>').appendTo('#add-doc');
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
        url: '<?php echo base_url(); ?>'+'Team/delete_File/'+id+'/'+std,
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

getChosenData('des','DS',[{'label':'post','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['designation']?>');
getChosenData('subject_ID','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL[0]['subject_ID']?>',true);
getChosenData('reporting','DS',[{'label':'post','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL[0]['reporting_to']?>');
getChosenData('branch','BR',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['branch']?>');
getChosenData('seniority1','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['seniority1']?>');
getChosenData('seniority2','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['seniority2']?>');
getChosenData('seniority3','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['seniority3']?>');

/*function get_proff_status()
{
  var ID = $('#des').val();
  $.ajax({
    type:'POST',
    dataType:'json',
    data:{'ID':ID},
    url: '<?php //echo base_url("Team/get_proff_status");?>',
    success:function(response)
    {
      if (typeof response === 'object')
      {
        if(response[0].teach == 'Y')
        {
          $('#sub_ID').removeClass('hidden');
        }
        else
        {
          $('#sub_ID').addClass('hidden');
        }
      }
      else
      {
        toastr.error("Something went wrong!");
      }
    }
  });
}*/
</script>