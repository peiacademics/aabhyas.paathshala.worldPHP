<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Employee Award')); ?></h5>
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
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('team/add_employee_award/'.$branch_ID); ?>" method="post" id="awards_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                        <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo (@$View['branch_ID'] == NULL) ? $this->uri->segment(3, 0) : $View['branch_ID']; ?>">

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Award Date : </label>
                          <div class="col-sm-6">
                            <input type="text" class="datepicker form-control" name="date" placeholder="Award Date" value="<?php echo (@$View['date'] != NULL) ? date('m/d/Y H:i a', strtotime(@$View['date'])) : date('m/d/Y H:i a'); ?>" required>
                          </div>
                          <span id="account_opening_date"></span>
                        </div>

                          <div class="form-group">
                              <label for="Branch Name" class="col-sm-3 control-label">Employee : </label>
                              <div class="col-sm-6">
                                <select class="form-control chosen-select" id="employee_ID" name="employee_ID" placeholder="Employee"></select>
                              </div>
                                <span id="employee"></span>
                          </div>

                          <div class="form-group">
                              <label for="price" class="col-sm-3 control-label">Award : </label>
                              <div class="col-sm-6">
                                <select class="form-control chosen-select" id="award_ID" name="award_ID" placeholder="Award"></select>
                              </div>
                                <span id="award"></span>
                          </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Description : </label>
                          <div class="col-sm-6">
                            <textarea type="text" class="form-control" name="description" placeholder="Description" rows="10"><?php echo @$View['description']; ?></textarea>
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

<script type="text/javascript">
  $(document).ready(function() {
    var br_id = $('#branch_ID').val();
    $.validator.setDefaults({ ignore: ":hidden:not(select)" });
    getChosenData('employee_ID','US',[{'label':'Name','value':'ID'}],[{'Status':'A','branch_ID':br_id}],'<?php echo @$View['employee_ID']; ?>');
    getChosenData('award_ID','AW',[{'label':'title','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['award_ID']; ?>');    
    var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
  
    $('.datepicker').datetimepicker();

    $("#awards_add").postAjaxData(function(result){
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


$("#awards_add").validate();
  });    
</script>