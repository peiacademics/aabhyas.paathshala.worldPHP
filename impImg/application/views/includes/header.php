
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Paathshala</title>
        <link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("font-awesome/css/font-awesome.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("css/animate.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("css/plugins/codemirror/codemirror.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("css/plugins/codemirror/ambiance.css"); ?>" rel="stylesheet">
        <!-- <link href="<?php echo base_url("css/plugins/dataTables/dataTables.bootstrap.css"); ?>" rel="stylesheet"> -->
        <link href="<?php echo base_url("css/plugins/dataTables/jquery.dataTables.min.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("css/plugins/dataTables/responsive.dataTables.min.css"); ?>" rel="stylesheet">
        <!-- <link href="<?php echo base_url("css/plugins/dataTables/dataTables.tableTools.min.css"); ?>" rel="stylesheet"> -->
        <link href="<?php echo base_url("css/plugins/datapicker/datepicker3.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("css/plugins/daterangepicker/daterangepicker-bs3.css"); ?>" rel="stylesheet">

        <!-- croper -->
        <link href="<?php echo base_url('css/plugins/cropper/cropper.min.css'); ?>" rel="stylesheet">
        <!-- summer note -->
        <link href="<?php echo base_url('css/plugins/summernote/summernote.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('css/plugins/summernote/summernote-bs3.css');?>" rel="stylesheet"> 
        <link href="<?php //echo base_url("css/jquery.qtip.css"); ?>" rel="stylesheet">
        <!-- Mainly scripts -->
        <script src="<?php echo base_url("js/jquery-2.1.1.js"); ?>"></script>


        <link href="<?php echo base_url('css/plugins/fullcalendar/fullcalendar.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/plugins/fullcalendar/fullcalendar.print.css'); ?>" rel='stylesheet' media='print'>

        <script src="<?php echo base_url('js/plugins/fullcalendar/moment.min.js'); ?>"></script>
        <script src="<?php echo base_url('js/plugins/fullcalendar/fullcalendar.min.js'); ?>"></script>
        
         <script src="<?php //echo base_url("js/jquery.qtip.js"); ?>"></script>
        <!-- Chosen -->
        <script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
        
       <link href="<?php echo base_url("css/plugins/iCheck/custom.css"); ?>" rel="stylesheet">
        <!-- Chosen -->
        <link href="<?php echo base_url("css/plugins/chosen/chosen.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("css/style.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url("css/d.css"); ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/plugins/dropzone/basic.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/plugins/dropzone/dropzone.css'); ?>" rel="stylesheet">
    </head>
    <?php $img = $this->str_function_library->call('fr>US>Image_ID:ID=`'.$Login['ID'].'`');
        $img_path = $this->str_function_library->call('fr>SS>path:ID=`'.$img.'`');
                                $app_config = $this->config->item('app');
        $skin = $this->str_function_library->call('fr>US>Skin:ID=`'.$Login['ID'].'`');
        $fixed_footer = $this->str_function_library->call('fr>US>fixed_footer:ID=`'.$Login['ID'].'`');
        $top_navbar = $this->str_function_library->call('fr>US>top_navbar:ID=`'.$Login['ID'].'`');
        $boxed_layout = $this->str_function_library->call('fr>US>boxed_layout:ID=`'.$Login['ID'].'`');
        $fixed_slidebar = $this->str_function_library->call('fr>US>fixed_slidebar:ID=`'.$Login['ID'].'`');
        $collaps_menu = $this->str_function_library->call('fr>US>collaps_menu:ID=`'.$Login['ID'].'`');
                            ?>

    <body class="fixed-sidebar skin-1">
    <script type="text/javascript">
        function getChosenData(id,tbl,contents,where,ispresent,multiAdd=false) {
        $('#'+id).html('');
        $.ajax({
          type: 'POST',
          data:{'tbl':tbl,'contents':contents,'where':where},
          url: '<?php echo base_url(); ?>'+'bank/getChosenData/',
          dataType: 'json',
          success:function(data)
          {
            $('#'+id).append('<option value="" selected disabled>Select</option>');
            if (multiAdd===true) {
                ispresent = ispresent.split(',');
            }
            $.each(data,function(k,v)
            {
                if (multiAdd===false) {
                    if (ispresent===v[contents[0].value]) {
                        $('#'+id).append('<option value="'+v[contents[0].value]+'" selected>'+v[contents[0].label]+'</option>');
                    }
                    else
                    {
                        $('#'+id).append('<option value="'+v[contents[0].value]+'">'+v[contents[0].label]+'</option>');
                    }
                }
                else
                {
                    $('#'+id).append('<option value="'+v[contents[0].value]+'">'+v[contents[0].label]+'</option>');
                    $("#"+id).val(ispresent);
                }
                
            });
          $(".chosen-select").trigger('chosen:updated');
          $(".chosen-select").chosen();
          $("#"+id+"_chosen").css('width','100%');
          }
        });
        }
        </script>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            <!-- <img alt="image" class="img-circle" src="<?php //echo base_url($img_path); ?>" onerror="if (this.src != 'error.jpg') this.src = '<?php //echo base_url('impImg/main.jpg'); ?>';"/ > -->
                            <img alt="image" class="img-circle" src="<?php echo base_url("img/logo.jpg"); ?>" onerror="if (this.src != 'error.jpg') this.src = '<?php echo base_url('impImg/main.jpg'); ?>';"/ >
                         </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        <?php echo $Login['Name']; ?>
                                    </strong>
                                </span>
                                <span class="text-muted text-xs block">
                                    <?php echo $this->str_function_library->call('fr>DS>post:ID=`'.$this->data['Login']['Login_as'].'`'); ?>
                                </span>
                            </span> 
                        </a>
                    </div>
                    <div class="logo-element">
                        <i class="fa fa-user padding-right5"></i>
                    </div>
                </li>
        <?php 
            foreach(@$menu['menu'] as $one){
                // var_dump($one);
                if(array_key_exists('children', $one))
                {
        ?>
                <li class="" id="<?php echo 'A'.md5(base_url(@$one['link'])); ?>">
                    <a href="<?php echo base_url(@$one['link']); ?>"><i class="fa fa-<?php echo $one['icon']?>"></i> <span class="nav-label"><?php echo $this->lang_library->translate($one['title']); ?></span><span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                    <?php   foreach($one['children'] as $two)
                        { 
                    ?>
                    <?php if(@$two['modal']) { ?>
                        <li class="" id="<?php echo 'A'.md5(base_url(@$one['link'])); ?>">
                            <a href="#" data-toggle="modal" data-target="#<?php echo $two['target']; ?>">
                               <i class="fa fa-<?php echo $two['icon']?>"></i>
                                 <!--<span class="nav-label"> -->
                                    <?php echo $this->lang_library->translate($two['title']); ?>
                                <!-- </span> -->
                            </a>
                        </li>
                    <?php }else{ 
                        if(array_key_exists('children', $two))
                        { ?>
                            <li class="" id="<?php echo 'A'.md5(base_url(@$two['link'])); ?>">
                                <a href="<?php echo base_url(@$two['link']); ?>"><i class="fa fa-<?php echo $two['icon']?>"></i> <span class="nav-label"><?php echo $this->lang_library->translate($two['title']); ?></span><span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-third-level collapse">
                                <?php   foreach($two['children'] as $three)
                                        {

                                        if(array_key_exists('children', $three))
                                        { ?>
                                            <li class="" id="<?php echo 'A'.md5(base_url(@$three['link'])); ?>">
                                                <a href="<?php echo base_url(@$three['link']); ?>"><i class="fa fa-<?php echo $three['icon']?>"></i> <span class="nav-label"><?php echo $this->lang_library->translate($three['title']); ?></span><span class="fa arrow"></span>
                                                </a>
                                                <ul class="nav nav-fourth-level collapse">
                                                <?php   foreach($three['children'] as $four)
                                                        { 
                                                    ?>
                                                    <li class="" id="<?php echo 'A'.md5(base_url(@$four['link'])); ?>" >
                                                        <a href="<?php echo base_url(@$four['link']); ?>"><i class="fa fa-<?php echo $four['icon']?>"></i>
                                                            <?php echo $this->lang_library->translate($four['title']); ?>
                                                        </a>
                                                    </li>
                                                    <?php }?>
                                                    </ul>
                                        <?php }
                                        else{ 

                                    ?>
                                    <li class="" id="<?php echo 'A'.md5(base_url(@$three['link'])); ?>" >
                                        <a href="<?php echo base_url(@$three['link']); ?>"><i class="fa fa-<?php echo $three['icon']?>"></i>
                                            <?php echo $this->lang_library->translate($three['title']); ?>
                                        </a>
                                    </li>
                                    <?php } }?>
                                    </ul>
                        <?php }
                        else{?>
                        <li class="" id="<?php echo 'A'.md5(base_url(@$two['link'])); ?>" >
                            <a href="<?php echo base_url(@$two['link']); ?>"><i class="fa fa-<?php echo $two['icon']?>"></i>
                                <?php echo $this->lang_library->translate($two['title']); ?>
                            </a>
                        </li>
                    <?php 
                }  
                    }
                       }
                        ?>
                    </ul>
                </li>
                <?php
                        }
                        else
                        {
                ?>  
                <li class="" id="<?php echo 'A'.md5(base_url(@$one['link'])); ?>">
                    <?php if(@$one['modal']) { ?>
                     <a href="#" data-toggle="modal" data-target="#<?php echo $one['target']; ?>"><i class="fa fa-<?php echo $one['icon']?>"></i>
                        <span class="nav-label">
                            <?php echo $this->lang_library->translate($one['title']); ?>
                        </span>
                     </a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url(@$one['link']); ?>"><i class="fa fa-<?php echo $one['icon']?>"></i>
                        <span class="nav-label">
                            <?php echo $this->lang_library->translate($one['title']); ?>
                        </span>
                    </a>
                    <?php }?>
                </li>
              <?php     }
                    } ?>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to Paathshala</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>  <span class="label label-primary" id="chat_notify"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts" id="chat_notification">
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                           <span class="text-xs block"><i class="fa fa-gear"></i>Options<b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <?php 
                             $dropdwn = $this->config->item('dropdown_menu');
                             $login_as = $this->data['Login']['Login_as'];
                             foreach($dropdwn[$login_as] as $one){
                            ?>
                            <li>
                                <a href="<?php echo base_url($one['Link']); ?>"><i class="fa fa-<?php echo $one['Icon']?> padding-right5"></i> <?php echo $this->lang_library->translate($one['Title']); ?></a>
                            </li>
                                <?php 
                               }
                                ?>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo base_url('Login/logout'); ?>"><i class="fa fa-sign-out padding-right5"></i> <?php echo $this->lang_library->translate('Log out'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2><?php echo @$breadcrumb['heading']; ?></h2>
                <ol class="breadcrumb">
                    <?php
                    if(isset($breadcrumb['route']))
                    { 
                        foreach ($breadcrumb['route'] as $route)
                        {
                            if(is_array($route))
                            {
                                echo "<li><a href=".base_url($route['path']).">".$route['title']."</a></li>";
                            }
                            else
                            {
                                echo "<li class='active'><strong>".$route."</strong></li>";
                            }
                        }
                    }
                    ?>

                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
            
        </div>

    <script type="text/javascript">
        $(document).ready(function() {
            Login_as='<?php echo $this->session_library->get_session_data('Login_as');?>';
            Login_Employee='<?php echo $this->session_library->get_session_data('employeeID');?>';
            $('#A<?php echo md5(current_url()); ?>').addClass('active');
            $("#A<?php echo md5(current_url()); ?>").parent().parent().addClass("active");
            $("#A<?php echo md5(current_url()); ?>").parent().addClass("in");
            $("#A<?php echo md5(current_url()); ?>").parent().parent().parent().parent().addClass("active");
            $("#A<?php echo md5(current_url()); ?>").parent().parent().addClass("in");
            $("#A<?php echo md5(current_url()); ?>").parent().parent().parent().parent().parent().parent().addClass("active");
            $("#A<?php echo md5(current_url()); ?>").parent().parent().parent().addClass("in");
            // Dropzone.options.myAwesomeDropzone = {
            //     autoProcessQueue: false,
            //     uploadMultiple: true,
            //     parallelUploads: 100,
            //     maxFiles: 100,
                // acceptedFiles:'.xlsx,.xlsm,.xlsb,.xltx,.xltm,.xls,.xmlm',

                // Dropzone settings
            //     init: function() {
            //         var myDropzone = this;
            //         this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
            //             e.preventDefault();
            //             e.stopPropagation();
            //             myDropzone.processQueue();
            //         });
            //         this.on("sendingmultiple", function() {
            //             alert('deepk');
            //         });
            //         this.on("successmultiple", function(files, response) {
            //            response = $.parseJSON(response);
            //           //response=JSON.parse(response);
            //           console.log(response);
            //           alert('deepk');
            //           console.log(typeof response);
            //           if (response === true) {
            //             $('#errorShow').append('<div class="alert alert-success alert-dismissible" role="alert">Successfully Added Data </div>');
            //           }
            //           else if (typeof response === 'object'){
            //              $.each(response,function(obj,col){
            //                if (obj === 'success') {
            //                  $('#errorShow').append('<div class="alert alert-success alert-dismissible" role="alert">Successfully Added Data </div>');
            //                }
            //                else
            //                if (obj === 'errormultiple') {
            //                 $.each(col, function(key, value){
            //                   toastr.error(value);
            //                  });
            //                  $('#errorShow').append('<div class="alert alert-danger alert-dismissible" role="alert">Required columns cannot be empty !!!</div>');
            //                  $(".dz-preview").addClass('dz-error dz-image-preview');
            //                  $(".dz-error-message").text('Required columns cannot be empty !!!');
            //                }
            //                else if (obj === 'errormultiple1') {
            //                 $('#errorShow').append('<div class="alert alert-danger alert-dismissible" role="alert">Some Data Containing Errors </div>');
            //                }
            //              });
            //           }
            //           else{
            //             toastr.error("Please select Three mandatory columns or Please select First Name & Contact Number.");
            //             $('#errorShow').append('<div class="alert alert-danger alert-dismissible" role="alert">Please select Three mandatory columns or Please select First Name & Contact Number.</div>');
            //             $(".dz-preview").addClass('dz-error dz-image-preview');
            //             $(".dz-error-message").text('Please select Three mandatory columns or Please select First Name & Contact Number.');
            //           }
            //         });
            //         this.on("errormultiple", function(files, response) {
            //             alert('deepk');
            //         });
            //     }
            // }
        });

    </script>

    <!-- <div class=""> -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <?php echo $this->session->flashdata('itemUpdate');?>
        <div id="errorShow"></div>