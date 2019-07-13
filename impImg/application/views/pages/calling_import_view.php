 <div class="page-content">
    <div class="row">
        <div class="ro">
          <!-- <div class="ibox-title">
              <h5><?php echo ucfirst($this->lang_library->translate('Import Calling List')); ?></h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div> -->
          <div class="ibox-content">
            <div class="">
              <div class="row">
                <center><span class="text-danger"><i>Mandatory fields marked by (*) mark, First Name and Contact 1 is must be selected.</i></span></center><br>
                <form id="my-awesome-dropzone" class="dropzone" action="<?php echo base_url('lists/importDatabase1/'.$branch_ID); ?>" method="post">
                  <div class="dropzone-previews"></div>
                      <div class="form-group">
                        <div class="row">
                          <label for="list_Name" class="col-sm-2 control-label"><span class="text-danger text-right"><i>*</i></span> Column 1 : </label>
                          <div class="col-sm-2">
                            <select id="column-1" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-1" required>
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label"><span class="text-danger text-right"><i>*</i></span> Column 2 : </label>
                          <div class="col-sm-2">
                            <select id="column-2" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-2" required>
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label"><span class="text-danger text-right"><i>*</i></span> Column 3 : </label>
                          <div class="col-sm-2">
                            <select id="column-3" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-3" required>
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <label for="list_Name" class="col-sm-2 control-label">Column 4 : </label>
                          <div class="col-sm-2">
                            <select id="column-4" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-4">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 5 : </label>
                          <div class="col-sm-2">
                            <select id="column-5" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-5">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 6 : </label>
                          <div class="col-sm-2">
                            <select id="column-6" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-6">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <!-- <div class="form-group">
                        <div class="row">
                          <label for="list_Name" class="col-sm-2 control-label">Column 7 : </label>
                          <div class="col-sm-2">
                            <select id="column-7" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-7">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 8 : </label>
                          <div class="col-sm-2">
                            <select id="column-8" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-8">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 9 : </label>
                          <div class="col-sm-2">
                            <select id="column-9" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-9">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <label for="list_Name" class="col-sm-2 control-label">Column 10 : </label>
                          <div class="col-sm-2">
                            <select id="column-10" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-10">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 11 : </label>
                          <div class="col-sm-2">
                            <select id="column-11" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-11">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 12 : </label>
                          <div class="col-sm-2">
                            <select id="column-12" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-12">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <label for="list_Name" class="col-sm-2 control-label">Column 13 : </label>
                          <div class="col-sm-2">
                            <select id="column-13" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-13">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 14 : </label>
                          <div class="col-sm-2">
                            <select id="column-14" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-14">
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>

                          <label for="list_Name" class="col-sm-2 control-label">Column 6 : </label>
                          <div class="col-sm-2">
                            <select id="column-6" data-placeholder="Select contact number column..." class="form-control chosen-select" name="column-6" required>
                              <option value="">Please Select</option>
                              <option value="f_Name">First Name</option>
                              <option value="fa_Name">Father Name</option>
                              <option value="mo_Name">Mother Name</option>
                              <option value="l_Name">Last Name</option>
                              <option value="city">City</option>
                              <option value="contact_No">Contact 1</option>
                              <option value="contact_No2">Contact 2</option>
                              <option value="contact_No3">Contact 3</option>
                              <option value="s_no">Serial Number</option>
                              <option value="address">Address</option>
                              <option value="area">Area</option>
                              <option value="email">E-mail</option>
                              <option value="comments">Comments</option>
                              <option value="misc">Miscellaneous</option>
                            </select>
                          </div>
                        </div>
                      </div> -->

                      <div class="">
                      <div class="form-group">
                        <div class="row">
                          <label for="list_Name" class="col-sm-2 control-label">Assign To  : </label>
                          <div class="col-sm-5">
                              <select id="assign_to" data-placeholder="Select revised bill number..." class="form-control chosen-select" name="assign_to" required>
                                <option value="">Please Select</option>
                                  <?php 
                                  if($employee != FALSE) {
                                        foreach ($employee as $key => $value) {
                                  ?>  
                                  <option value="<?php echo $value['ID']; ?>"> <?php echo $value['Name']; ?></option>
                                  <?php        
                                        }
                                  }
                                  else{ ?>
                                      <option value="">Data Not Found.</option>
                                  <?php } ?> 
                                  </select>
                          </div>
                            <span id="assign_to"></span>
                        <!-- </div> -->
                    <!-- </div>
                    <div class="form-group"> -->
                            <button type="submit" id="addRecall"  class="btn btn-primary"><i class="fa fa-upload"></i> Import</button>
                        </div>
                      </div>
                      </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</div>
</div>
<link href="<?php echo base_url('css/plugins/dropzone/basic.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('css/plugins/dropzone/dropzone.css'); ?>" rel="stylesheet">
<!-- DROPZONE -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<script src="<?php echo base_url('js/plugins/dropzone/dropzone.js'); ?>"></script>

<!-- Jquery Validate -->
    <script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

    <script>
     $(".chosen-select").chosen();
    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
    $("#my-awesome-dropzone").validate();
        $(document).ready(function(){

            Dropzone.options.myAwesomeDropzone = {

                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                acceptedFiles:'.xlsx,.xlsm,.xlsb,.xltx,.xltm,.xls,.xmlm',

                // Dropzone settings
                init: function() {
                    var myDropzone = this;
                    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on("sendingmultiple", function() {
                    });
                    this.on("successmultiple", function(files, response) {
                     	 response=$.parseJSON(response);
                      //response=JSON.parse(response);
                      if (response === true) {
                        $('#errorShow').append('<div class="alert alert-success alert-dismissible" role="alert">Successfully Added Data </div>');
                      }
                      else if (typeof response === 'object'){
                         $.each(response,function(obj,col){
                           if (obj === 'success') {
                             $('#errorShow').append('<div class="alert alert-success alert-dismissible" role="alert">Successfully Added Data </div>');
                           }
                           else
                           if (obj === 'errormultiple') {
                            $.each(col, function(key, value){
                              toastr.error(value);
                             });
                             $('#errorShow').append('<div class="alert alert-danger alert-dismissible" role="alert">Required columns cannot be empty !!!</div>');
                             $(".dz-preview").addClass('dz-error dz-image-preview');
                             $(".dz-error-message").text('Required columns cannot be empty !!!');
                           }
                           else if (obj === 'errormultiple1') {
                            $('#errorShow').append('<div class="alert alert-danger alert-dismissible" role="alert">Some Data Containing Errors </div>');
                           }
                         });
                      }
                      else{
                        //swal("Oops...", "Please select First Name & Contact Number.", "error");
                        toastr.error("Please select Three mandatory columns or Please select First Name & Contact Number.");
                        $('#errorShow').append('<div class="alert alert-danger alert-dismissible" role="alert">Please select Three mandatory columns or Please select First Name & Contact Number.</div>');
                        $(".dz-preview").addClass('dz-error dz-image-preview');
                        $(".dz-error-message").text('Please select Three mandatory columns or Please select First Name & Contact Number.');
                      }
                    });
                    this.on("errormultiple", function(files, response) {
                    });
                }
            }

       });
    </script>