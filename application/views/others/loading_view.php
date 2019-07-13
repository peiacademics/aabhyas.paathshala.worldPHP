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
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
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
            if (localStorage.getItem('Logged_in')===null || localStorage.getItem('Logged_in')===undefined || localStorage.getItem('Logged_in')==='') {
                window.location.href = '<?php echo base_url("login/student"); ?>';
            }
            else
            {
                // alert('hiii');
                if (localStorage.getItem('Logged_in')==='TRUE') {
                    $.ajax({
                        type:'POST',
                        dataType:'json',
                        data:{'email':localStorage.getItem('Email'),'password':localStorage.getItem('Password')},
                        url: '<?php echo base_url("login/process_student"); ?>',
                        success:function(result)
                        {
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
                        }
                    })
                }
                else
                {
                     window.location.href = '<?php echo base_url("login/student"); ?>';
                }
            }
        });
            
        </script>
    </body>
</html>