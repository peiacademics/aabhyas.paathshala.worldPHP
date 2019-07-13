<div class="page-content">
  <div class="wrap">
<div class="ibox-content">
    <h4 id="success" style="text-align:center;"></h4>
    <form class="form-horizontal" role="form" action="<?php echo base_url('settings/themes_setting'); ?>" method="post" id="themeSetting">
      <div class="body_text_text">  
       <div class="form-group">
          <label for="Company_Name" class="col-sm-2 control-label">Select Theme Color :</label>
          <div class="col-sm-10">
            <div class="col-sm-2">
              <input type="radio" id="inputOne" name="Skin" value="skin-1" <?php echo $item['Skin']==='skin-1'?'checked':false ?>/>
              <label for="inputOne"></label>
            </div>

            <div class="col-sm-2">
              <input type="radio" id="inputOne2" name="Skin" value="skin-3" <?php echo $item['Skin']==='skin-3'?'checked':false ?>/>
              <label for="inputOne2"></label>
            </div>

            <div class="col-sm-2">
              <input type="radio" id="inputOne3" name="Skin" value="skin-4" <?php echo $item['Skin']==='skin-4'?'checked':false ?>/>
              <label for="inputOne3"></label>
            </div>

            <div class="col-sm-2">
              <input type="radio" id="inputOne1" name="Skin" value="md-skin"<?php echo $item['Skin']==='md-skin'?'checked':false ?>/>
              <label for="inputOne1"></label>
            </div>
          </div>
        </div>
         <!-- <div class="form-group">
            <label for="Address" class="col-sm-2 control-label">Fixed footer :</label>
            <div class="col-sm-10">
              <input type="checkbox" class="js-switch" name="fixed_footer" value="fixed" <?php echo $item['fixed_footer']==='fixed'?'checked':false ?>/>
            </div>
        </div>
        <div class="form-group">
            <label for="Address" class="col-sm-2 control-label">Top navbar :</label>
            <div class="col-sm-10">
              <input type="checkbox" class="js-switch_2"  name="top_navbar" id="fixednavbar" value="fixed-nav" <?php echo $item['top_navbar']==='fixed-nav'?'checked':false ?>/>
            </div>
        </div> -->
        <div class="form-group">
            <label for="Address" class="col-sm-2 control-label">Boxed layout :</label>
            <div class="col-sm-10">
              <input type="checkbox" class="js-switch_3" name="boxed_layout" value="boxed-layout" <?php echo $item['boxed_layout']==='boxed-layout'?'checked':false ?>/>
            </div>
        </div>

        <div class="form-group">
            <label for="Address" class="col-sm-2 control-label">Fixed sidebar :</label>
            <div class="col-sm-10">
              <input type="checkbox" class="js-switch_4" name="fixed_slidebar" value="fixed-sidebar" <?php echo $item['fixed_slidebar']==='fixed-sidebar'?'checked':false ?>/>
            </div>
        </div>

        <div class="form-group">
            <label for="Address" class="col-sm-2 control-label">Collapse menu :</label>
            <div class="col-sm-10">
              <input type="checkbox" class="js-switch_5" name="collaps_menu" value="mini-navbar" <?php echo $item['collaps_menu']==='mini-navbar'?'checked':false ?>/>
            </div>
        </div>
      </div>
           
      <div class="form_footer">
        <div class="row">
          <div class="col-md-6 col-md-offset-2">
            <button type="submit" class="btn btn-primary" id="themeSet">Update</button>
          </div>
        </div>
      </div>
    </form>
    </div> 
  </div>
</div>

<link href="<?php echo base_url("css/plugins/switchery/switchery.css"); ?>" rel="stylesheet">
<link href="<?php echo base_url("css/themes.css"); ?>" rel="stylesheet">
<!-- Gritter -->
   <script src="<?php echo base_url("js/plugins/switchery/switchery.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/gritter/jquery.gritter.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

<script type="text/javascript">
var elem = document.querySelector('.js-switch');
var switchery = new Switchery(elem, { color: '#1AB394' });
var base_url="<?php echo base_url();?>";

var elem_2 = document.querySelector('.js-switch_2');
var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

var elem_3 = document.querySelector('.js-switch_3');
var switchery_3 = new Switchery(elem_3, { color: '#0e9aef' });

var elem_3 = document.querySelector('.js-switch_4');
var switchery_3 = new Switchery(elem_3, { color: '#EFE80E' });

var elem_3 = document.querySelector('.js-switch_5');
var switchery_3 = new Switchery(elem_3, { color: '#0EEFE5' });
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
 // $(".js-switch_3").prop("checked", false);
 $(document).ready(function() {
  $('.js-switch_3').change(function(){
   if ($(".js-switch_3").is(":checked")) {
        $('body').addClass('boxed-layout');
    }else{
       $('body').removeClass('boxed-layout');
    }
  });

   $('.js-switch_2').change(function(){
   if ($(".js-switch_2").is(":checked")) {
        $('body').addClass('fixed-nav');
    }else{
       $('body').removeClass('fixed-nav');
    }
  });

  $('.js-switch').change(function(){
   if ($(".js-switch").is(":checked")) {
        $('#ftr').addClass('fixed');
    }else{
       $('#ftr').removeClass('fixed');
    }
  });

  $('.js-switch_4').change(function(){
   if ($(".js-switch_4").is(":checked")) {
        $('body').addClass('fixed-sidebar');
    }else{
       $('body').removeClass('fixed-sidebar');
    }
  });

  $('.js-switch_5').change(function(){
   if ($(".js-switch_5").is(":checked")) {
        $('body').addClass('mini-navbar');
    }else{
       $('body').removeClass('mini-navbar');
    }
  });

  $('#inputOne').change(function(){
   if ($("#inputOne").is(":checked")) {
        $('body').removeClass('skin-3 skin-4 md-skin').addClass('skin-1');
    }else{
       $('body').removeClass('skin-1');
    }
  });

  $('#inputOne1').change(function(){
   if ($("#inputOne1").is(":checked")) {
        $('body').removeClass('skin-3 skin-1 skin-4').addClass('md-skin');
    }else{
       $('body').removeClass('skin-3 skin-1');
    }
  });

  $('#inputOne2').change(function(){
   if ($("#inputOne2").is(":checked")) {
        $('body').removeClass('md-skin skin-1 skin-4').addClass('skin-3');
    }else{
       $('body').removeClass('skin-3');
    }
  });

  $('#inputOne3').change(function(){
   if ($("#inputOne3").is(":checked")) {
        $('body').removeClass('md-skin skin-1 skin-3').addClass('skin-4');
    }else{
       $('body').removeClass('skin-3');
    }
  });


$("#themeSetting").postAjaxData(function(result){
  if (result){
    swal({
      title: 'Done',
      text: 'Successfully Updated',
      type: "success"               
    });
  }
  });


});
</script>