<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Bank Account')); ?></h5>
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
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('bank/add'); ?>" method="post" id="bank_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                         <div class="form-group">
                              <label  class="col-sm-3 control-label">Bank Name : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="Name" placeholder="Bank Name" name="bank_name" value="<?php echo @$View['bank_name']; ?>">
                              </div>
                                <span id="bank_name"></span>
                          </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Branch : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="price" name="branch_name" placeholder="Branch Name" value="<?php echo @$View['branch_name']; ?>">
                              </div>
                                <span id="branch_name"></span>
                          </div>

                          <div class="form-group">
                              <label for="price" class="col-sm-3 control-label">IFSC Code : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="ifsc_code" placeholder="IFSC Code" value="<?php echo @$View['ifsc_code']; ?>">
                              </div>
                                <span id="ifsc_code"></span>
                          </div>

                          <div class="form-group">
                              <label for="price" class="col-sm-3 control-label">Account Number : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="account_no" placeholder="Account Number" value="<?php echo @$View['account_no']; ?>">
                              </div>
                                <span id="account_no"></span>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-3 control-label">Account Opening Date : </label>
                              <div class="col-sm-6">
                                <input type="text" class="datepicker form-control" name="account_opening_date" placeholder=" Opening Date" value="<?php echo (@$View['account_opening_date'] != NULL) ? date('Y-m-d', strtotime(@$View['account_opening_date'])) : date('Y-m-d'); ?>">
                                <!-- account_opening_date  -->
                              </div>
                                <span id="account_opening_date"></span>
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
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>

<script type="text/javascript">
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    
    //var js_date_format = "<?php //echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
  
    $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
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
                     bank_name: {
                         required: true,
                     },
                     branch_name: {
                         required: true,
                     },
                     ifsc_code: {
                         required: true,
                     },
                     account_no: {
                         required: true,
                         number: true,
                     },
                     account_opening_date: {
                         required: true,
                     }
                 }
             });
  });    
</script>