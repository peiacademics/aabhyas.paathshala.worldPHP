<!-- <link href="<?php //echo base_url('css/plugins/iCheck/custom.css'); ?>" rel="stylesheet">
 --><link href="<?php echo base_url('css/plugins/steps/jquery.steps.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">

<div class="page-content">
  <div class="wrap">
<div class="ibox">
<div class="i-checks">
        <div class="ibox-title">
            <h5>Language Settings</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
          <form id="form" action="#" class="wizard-big" method="post">
              <h1>Language</h1>
              <fieldset>
                  <h2> Add Language</h2>
                  <div class="row">
                      <div class="">
                          <div class="form-group col-lg-12">
                               <label class="col-lg-2">Title : </label>
                               <div class="col-lg-8"><input type="text" class="form-control" name="Title" placeholder="Title" required></div>
                              <!--<input id="userName" name="userName" type="text" class="form-control required"> -->
                          </div>
                          <div class="form-group col-lg-12">
                              <label class="col-lg-2">Substitute English:</label>
                                <div class="checkbox-inline"><input type="radio" name="Substitute_English" id="Substitute_English1" value="1" checked></div> <i></i><label for="Substitute_English1"> Yes</label>
                                <div class="checkbox-inline"><input type="radio" name="Substitute_English" id="Substitute_English2" value="0"></div> <i></i><label for="Substitute_English1"> No</label>
                                <div class="col-lg-offset-2"></div>
                          </div>
                          <div class="form-group col-lg-12">
                              <label class="col-lg-2">Right to Left:</label>
                                <div class="checkbox-inline"><input type="radio" name="rtl" id="rtl2" value="0" > </div><i></i><label for="rtl2"> No</label>
                                <div class="checkbox-inline"><input type="radio" name="rtl" id="rtl1" value="1"> </div><i></i><label for="rtl1"> Yes</label>
                          </div>
                  </div>

              </fieldset>
              <h1>Translations</h1>
              <fieldset>
                  <h2>Enter The Translation Of Selected Language</h2>
                  <div class="row">
                      <?php if($word_array != FALSE) {
                                foreach($word_array as $words) { ?>
                                  <div class="form-group col-sm-12">
                                      <label for="" class="col-sm-4 control-label"><?php echo $words['Word']; ?></label>
                                      <div class="col-sm-8">
                                        <input type="hidden" class="form-control" name="Word[]" value="<?php echo $words['Word'];?>">
                                        <input type="text" class="form-control" id="Translation" name="Translation[]" placeholder="Translation For <?php echo $words['Word'];?>">
                                      </div>
                                        <span id="Translation"></span>
                                  </div>
                          <?php }
                            }
                           ?>

                                  <div class="form-group">
                                      <div class="col-sm-6">
                                        <input type="hidden" id="langID" name="Language_ID">
                                      </div>
                                      <span id="Language_ID"></span>
                                 </div>
                  </div>
              </fieldset>

              <h1>Finish</h1>
              <fieldset>
                  <input type="hidden" id="languageID" name="Lang_ID">
                  <input id="acceptTerms" name="checkbox" type="checkbox" class="required">
                  <label for="acceptTerms">
                    <h3>Check Here If You Want To Add Language Permanently.</h3>
                  </label>
       
              </fieldset>
            </form>
        </div>
    </div>
  </div>
</div>
<!-- Steps -->
     <script src="<?php echo base_url(); ?>js/plugins/staps/jquery.steps.min.js"></script>

<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
 <!-- iCheck -->
    <script src="<?php echo base_url(); ?>js/plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){

              $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    console.log('New Index : '+newIndex);
                    console.log('Current Index : '+currentIndex);
                    console.log($('input[name="rtl"]').val());
                    switch(currentIndex)
                    {
                      case 0: 
                        formdata = 'Title='+$('input[name="Title"]').val()+'&Substitute_English='+$('input[name="Substitute_English"]').val()+'&rtl='+$('input[name="rtl"]').val();
                        console.log(formdata);
                        $.ajax({
                          url: '<?php echo base_url(); ?>settings/add_language',
                          type: "POST",
                          data: formdata,
                          dataType:"json",
                          success: function(response) {
                            if(typeof(response) !== 'object')
                            {
                              console.log(response);                     
                              $("#langID").val(response);
                            
                               //alert("Language Added Successfully.");
                            }
                          }
                        });
                      break; 

                      case 1:
                        formdata = $('#form').serialize();
                        console.log(formdata);
                        var s  = formdata.split("rtl=1&");
                        if(s.length == 1)
                        {
                          var s  = formdata.split("rtl=0&");
                        }
                        console.log(s[1]);
                        $.ajax({
                          url: '<?php echo base_url(); ?>settings/add_translations',
                          type: "POST",
                          data: s[1],
                          dataType:"json",
                          success: function(response) {
                            console.log(response);                     
                            $("#languageID").val(response);
                          }
                        });
                      break;

                    }
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    /*if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }*/

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";
                    console.log(form.valid());
                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }
                    //return true;
                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);
                    console.log(currentIndex);
                    console.log(event);
                    var lang_id=$('#languageID').val();
                    $.ajax({
                      url: '<?php echo base_url(); ?>settings/update_custom_lang_file',
                      type: "POST",
                      data: {Lang_ID:lang_id},
                      dataType:"json",
                      success: function(response) {
                        console.log(response);                     
                        return true;
                      }
                    });

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);
                    console.log(currentIndex);
                    console.log(event);
                    // Submit form input
                    swal({
                      title: "Done!",
                      text: "Language Added Successfully!",
                      type: "success"
                    },function(){ location.reload(); });
                }
            });

});
</script>