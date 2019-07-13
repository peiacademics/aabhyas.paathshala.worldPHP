<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="en-us">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $this->lang_library->translate('Login'); ?></title>
        <link href="<?php echo base_url("css/animate.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url("css/style.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("font-awesome/css/font-awesome.css"); ?>" rel="stylesheet">
    </head>
    <body class="skBlueLight">
        <div class="container">
            <div class="row login-screen">
                <div class="col-md-4 col-md-offset-4 text-center">
                    <img src="<?php echo base_url('img/logo.jpg'); ?>" class="margin-bottom50" / height="200">
                    <br>
                    <br>
                    <?php /*$stud = @$this->uri->segment(2);
                    if($stud == NULL) {*/ ?>
                    <!-- <form id="loginForm" action="<?php //echo base_url('login/process'); ?>" class="form-horizontal" method="post" id="loginForm"> -->
                    <?php //} elseif($stud=='student') { ?>
                    <form id="loginForm" action="<?php echo base_url('login/process_student'); ?>" class="form-horizontal" method="post" id="loginForm">
                    <?php //} elseif($stud=='parent') { ?>
                    <!-- <form id="loginForm" action="<?php //echo base_url('login/process_parent'); ?>" class="form-horizontal" method="post" id="loginForm"> -->
                    <?php //} ?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="text" class="form-control" id="u" name="email" placeholder="<?php echo $this->lang_library->translate('Username'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control" id="p" name="password" placeholder="<?php echo $this->lang_library->translate('Password'); ?>">
                            </div>
                        </div>
                        <?php //if($stud=='student') { ?>
                        <div class="form-group">
                            <div class="col-xs-2">
                                <input type="checkbox" class="form-control" name="external">
                            </div>
                            <div class="col-xs-8 text-left">
                                <label class="control-label text-warning h4">Login as Aabhyas Student.</label>
                            </div>
                        </div>
                        <?php //} ?>
                        <div id="login_error"></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-block skYellowNormal"><i class="fa fa-sign-in padding-right5"></i> <?php echo $this->lang_library->translate('Sign In'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
        <script src="<?php echo base_url('js/jquery-2.1.1.js'); ?>"></script>
        <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
        <!-- Jquery Validate -->
        <script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
        <script src="<?php echo base_url('js/formSerialize.js'); ?>"></script>
        <script type="text/javascript">
        base_url = '<?php echo base_url(); ?>';
        $(document).ready(function() {
            $("#loginForm").postAjaxData(function(result){
                if(typeof result == 'object')
                {
                    if(result.status === true)
                    {
                        switch(result.type)
                        {
                            case 'DSSK10000001':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000002':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000003':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000004':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000005':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000006':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000007':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000009':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000010':
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                            case 'DSSK10000011':
                                window.location.href = '<?php echo base_url("student/view/"); ?>'+'/'+result.ID;
                                break;
                            case 'DSSK10000012':
                                window.location.href = '<?php echo base_url("student/view/"); ?>'+'/'+result.student_ID;
                                break;
                            default:
                                window.location.href = '<?php echo base_url($this->config->item("skyq")["default_home_page"]); ?>';
                                break;
                        }
                    }
                    else {
                        $("#login_error").text("Authentication Failed!!");
                    }
                }
                else
                {
                    $("#login_error").text("Authentication Failed!!");
                }
            });
        });

if (localStorage.getItem('token')===undefined 
    || localStorage.getItem('token')===null || localStorage.getItem('token')=='null') {
}else
{
     redirect();
}
        function redirect() {
            var token=localStorage.getItem('token');
            var ID=localStorage.getItem('studebt');
            $.ajax({
              method:'POST',
              data: {'token':token,'studentID':ID},
              dataType:'json',
               url:"<?php echo base_url('login/redirectStudent'); ?>",
              success:function(result){
                if(typeof result == 'object')
                {
                     window.location.href = '<?php echo base_url("student/view/"); ?>'+'/'+result.ID;
                }
                else
                {
                  // toastr.warning('Something went wrong', 'Skyq.in');
                }
              }
            });            
        }         
        </script>
    </body>
</html>