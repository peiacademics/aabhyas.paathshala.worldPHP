 <div class="page-content">
  <div class="wrap">
    <h4 id="success" style="text-align:center;"></h4>
    <form class="form-horizontal" role="form" action="<?php echo base_url('settings/add_help_category'); ?>" method="post" id="help_category_add">
      <div class="body_text_text">
        <div class="form-group">
						<label for="Title" class="col-sm-3 control-label">Title</label>
						<div class="col-sm-6">
								<input type="text" class="form-control"  name="Title" placeholder="Title">
						</div>
            <span id="Title"></span>
				</div>
                        
        <div class="form-group">
						<label for="Icon" class="col-sm-3 control-label">Icon</label>
						<div class="col-sm-6">
								<input type="text" class="form-control" name="Icon" placeholder="Icon">
						</div>
             <span id="Icon"></span>
				</div>                                                             
			</div>
           
    	<div class="form_footer">
      	<div class="row">
        	<div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Add Category</button>
          </div>
        </div>
      </div>
    </form> 
  </div>
</div>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#help_category_add").validate({
                 rules: {
                     Icon: {
                         required: true,
                     },
                     Title: {
                         required: true,
                     }
                 }
             });
    
    $("#help_category_add").postAjaxData(function(result){
      if(result === 1)
      {
          //alert(result);
          $("#success").html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Help category added successfully.</div>');
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