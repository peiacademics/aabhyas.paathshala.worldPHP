<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Lead Reason')); ?></h5>
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
        <form class="form-horizontal" role="form" action="<?php echo base_url('lead_reasons/add'); ?>" method="post" id="lead_reason_add">
          <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">

          <div class="form-group">
            <label  class="col-sm-3 control-label">Reason : </label>
            <div class="col-sm-6">
              <textarea class="form-control" id="reason" placeholder="Reason" name="reason" rows="5" required><?php echo @$View['reason']; ?></textarea>
            </div>
            <span id="reason_name"></span>
          </div>

          <div class="form-group">
            <label for="Branch Name" class="col-sm-3 control-label">Description : </label>
            <div class="col-sm-6">
              <textarea class="form-control" id="description" name="description" placeholder="Description" rows="5"><?php echo @$View['description']; ?></textarea>
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
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  $(document).ready(function() {
    $("#lead_reason_add").postAjaxData(function(result){
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
    $("#lead_reason_add").validate();
  });    
</script>