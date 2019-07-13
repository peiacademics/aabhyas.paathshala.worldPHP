
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
        <link rel="icon" href="<?php echo base_url('img/logo.jpg'); ?>" type="image/x-icon"/>
    </head>

    <body class="fixed-sidebar skin-4 ">
      <div class="">
        <div class="row">
          <div class="text-center">
            <div class="input-group">
              <select class="form-control input-lg" id="speed" placeholder="Select Speed" onChange="change_speed()">
                <option value="0.25">0.25</option>
                <option value="0.5">0.5</option>
                <option value="0.75">0.75</option>
                <option value="1" selected>Normal Speed</option>
                <option value="1.25">1.25</option>
                <option value="1.5">1.5</option>
                <option value="1.75">1.75</option>
                <option value="2">2</option>
              </select>
              <span class="input-group-addon input-lg" onClick="backward()">
                <i class="fa fa-backward"></i>
              </span>
              <span class="input-group-addon input-lg" onClick="forward()">
              <i class="fa fa-forward"></i>
              </span>
            </div>
            <video width="420" id="frame_ID" src="<?php echo base_url($link); ?>" controls controlsList="nodownload">
            </video>
          </div>
        </div>
      </div>



<link href="<?php echo base_url('css/bootstrap-datetimepicker.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/bootstrap-datetimepicker.js"); ?>"></script> 
<!-- Mainly scripts -->
<script src="<?php echo base_url("js/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/metisMenu/jquery.metisMenu.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/slimscroll/jquery.slimscroll.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/inspinia.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/pace/pace.min.js"); ?>"></script>
<link href="<?php echo base_url('css/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('js/plugins/toastr/toastr.min.js'); ?>"></script>

<link href="<?php //echo base_url('css/jquery.mCustomScrollbar.css'); ?>" rel="stylesheet">
<script src="<?php //echo base_url('js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<!-- DROPZONE -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>

    </body>
</html>


<script type="text/javascript">
  $(document).ready(function() {

    $('#frame_ID').attr('src',get_u('<?php echo base_url($link); ?>'));
    $('#frame_ID').bind('contextmenu',function() {
      return false;
    });
    setInterval(function(){
      $('#frame_ID').attr('controlslist','nodownload');
    },100);
  });

  function get_u(url_l)
  {
    return url_l;
  }

  function change_speed()
  {
    var vid = document.getElementById("frame_ID");
    var rate = $('#speed').val();
    vid.playbackRate = rate;
  }

  function backward()
  {
    var vid = document.getElementById("frame_ID");
    var time = vid.currentTime;
    time = time - 15;
    vid.currentTime = time;
  }

  function forward()
  {
    var vid = document.getElementById("frame_ID");
    var time = vid.currentTime;
    time = time + 15;
    vid.currentTime = time;
  }
</script>