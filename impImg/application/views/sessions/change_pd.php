  <div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Change Password')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div>
<div class="ibox-content">
        <div class="page-content">
            <div class="" style="overflow:hidden;">
              <h6 class="heading text-center">Change Password</h6>
             <h4 id="success" style="text-align:center;"></h4>
            <div class="row margin-top50">
                <div class="col-md-4 col-md-offset-4 text-center">
                    
                    <form class="form-horizontal" role="form" action="<?php echo base_url('Settings/cp'); ?>" method="post" id="change_pass">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="password" class="form-control" id="u" name="old_pw" placeholder="<?php echo $this->lang_library->translate('Old Password'); ?>">
                            </div>
                            <span id="er_old"></span>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control" id="p" name="new_pw" placeholder="<?php echo $this->lang_library->translate('New Password'); ?>">
                            </div>
                             <span id="er_new"></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control" id="p" name="confirm_pw" placeholder="<?php echo $this->lang_library->translate('Conform Password'); ?>">
                            </div>
                             <span id="er_cnew"></span>
                        </div>
                        <div id="login_error"></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-block skYellowNormal"><i class="fa fa-exchange padding-right5"></i>&nbsp;&nbsp;<?php echo $this->lang_library->translate('Change Password'); ?></button>
                        </div>
                    </form>
                    
                    
                </div>
            </div>
                                
            </div>
                
        </div>
      </div>
    </div>    
<!-- Jquery Validate -->
    <script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>  
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#change_pass").postAjaxData(function(result){
      if(result === true)
      {
          $("#success").text('Password has been changed successfully.');
      }
      else {
        if(typeof result === 'object')
        {
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
