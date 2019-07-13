<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Email Setting')); ?></h5>
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
    <form class="form-horizontal" role="form" action="<?php echo base_url('settings/EsettingAdd'); ?>" method="post" id="EmailSetting">
      <div class="body_text_text">
        <?php 
        if (@$Detail) {
          $Detail=json_decode($Detail);
        } ?>
       <div class="form-group">
            <label for="Company_Name" class="col-sm-3 control-label">Hostname :</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="Host" placeholder="Host" value="<?php echo @$Detail->Host; ?>" required>
            <b>Eg :-</b>  <code>ssl://example.com</code>
            </div>
            <span id="Host" class="text-danger"></span>
        </div>
            
       <div class="form-group">
            <label for="Company_Name" class="col-sm-3 control-label">Username :</label>
            <div class="col-sm-6">
              <input type="email" class="form-control" name="Username" placeholder="Username" value="<?php echo @$Detail->Username; ?>" required>
            </div>
            <span id="Username" class="text-danger"></span>
        </div>
         <div class="form-group">
            <label for="Address" class="col-sm-3 control-label">Password :</label>
            <div class="col-sm-6">
              <input type="Password" class="form-control" name="Password" placeholder="Password" value="<?php echo @$Detail->Password;?>" required>
            </div>
            <span id="Password" class="text-danger"></span>
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

<!-- Gritter -->
<script src="<?php echo base_url('js/plugins/gritter/jquery.gritter.min.js'); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url('js/bootbox.min.js'); ?>"></script>
<script src="<?php echo base_url('js/formSerialize.js'); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url('js/plugins/validate/jquery.validate.min.js'); ?>"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";
$("#EmailSetting").validate();
$("#EmailSetting").postAjaxData(function(result){
  if(result === 1)
  {
    swal({
        title: 'Done',
        text: 'Successfully Updated',
        type: "success"               
      },
        function()
        {
          window.location.href = "<?php echo current_url(); ?>"
        }
    );
  }
  else
  {
    swal("Oops...", "Something went wrong!", "error");
  }
});
</script>