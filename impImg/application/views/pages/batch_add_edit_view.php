<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Batch')); ?></h5>
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
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('Batch/add'); ?>" method="post" id="bank_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                         <div class="form-group">
                              <label  class="col-sm-3 control-label">Batch Name : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="Name" placeholder="Batch Name" name="name" value="<?php echo @$View['name']; ?>">
                              </div>
                                <span id="bank_name"></span>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-3 control-label">Description : </label>
                              <div class="col-sm-6">
                                 <textarea type="text" class="form-control" name="description" placeholder="Description"><?php echo @$View['description']; ?></textarea>
                              </div>
                                <span id="description"></span>
                          </div>

                        <?php $user_type = $this->session_library->get_session_data('Login_as');
                          if($user_type === 'DSSK10000001') { ?>
                          <div class="form-group">
                              <label  class="col-sm-3 control-label">Branch Name : </label>
                              <div class="col-sm-6">
                                <select class="form-control chosen-select" id="branch_ID" name="branch_ID" placeholder="Select Branch..." required>
                                <option disabled selected>Select Branch...</option>
                                <?php if($branch !== NULL) { 
                                  foreach ($branch as $key => $value) { ?>
                                    <option value="<?php echo $value['ID']; ?>" <?php echo (@$View['branch_ID'] === $value['ID']) ? 'selected':''; ?>><?php echo $value['name']; ?></option>
                                <?php } } else { ?>
                                  <option disabled>No records found</option>
                                <?php } ?>
                                </select>
                              </div>
                                <span id="branch_name"></span>
                          </div>
                          <?php } else { ?>
                            <input type="hidden" name="branch_ID" value="<?php echo $this->session_library->get_session_data('branch_ID'); ?>">
                          <?php } ?>

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
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    
    var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
 
    $('.datepicker').datepicker({
                format: js_date_format,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

    $("#bank_add").postAjaxData(function(result){
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


$("#bank_add").validate({
                 rules: {
                     name: {
                         required: true,
                     }
                 }
             });
  });    
</script>