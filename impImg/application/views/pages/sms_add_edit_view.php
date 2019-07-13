<div class="row">
  <!-- <div class="ibox-title">
    <h5><?php echo ucfirst($this->lang_library->translate('Message Master')); ?></h5>
    <div class="ibox-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>
  </div> -->
  <div class="ibox-content">
    <div class="page-content">
      <div class="wrap">
        <h4 id="success" style="text-align:center;"></h4>
        <form class="form-horizontal" role="form" action="<?php echo base_url('sms/add'); ?>" method="post" id="sms_add">
          <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
            <div class="form-group">
              <label  class="col-sm-3 control-label">Type : </label>
              <div class="col-sm-6">
                <select class="form-control chosen-select" id="type" placeholder="Type" name="message_type_ID">
                </select>
              </div>
              <span id="sms"></span>
            </div>

            <div class="form-group">
              <label  class="col-sm-3 control-label">Message : </label>
              <div class="col-sm-6">
                <textarea type="text" class="form-control" id="Name" placeholder="Message" name="sms" value=""><?php echo @$View['sms']; ?></textarea>
              </div>
              <span id="sms"></span>
            </div>

            <div class="form-group">
              <label  class="col-sm-3 control-label">Description : </label>
              <div class="col-sm-6">
                <textarea type="text" class="form-control" id="Desc" placeholder="Description" name="desc" value=""><?php echo @$View['desc']; ?></textarea>
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

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  getChosenData('type','MT',[{'label':'type','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['message_type_ID']; ?>');
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    
    // var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
  
    // $('.datepicker').datepicker({
    //             format: js_date_format,
    //             keyboardNavigation: false,
    //             forceParse: false,
    //             autoclose: true
    //         });

    $("#sms_add").postAjaxData(function(result){
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


$("#sms_add").validate({
                 rules: {
                     sms: {
                         required: true,
                     }
                 }
             });
  });    
</script>