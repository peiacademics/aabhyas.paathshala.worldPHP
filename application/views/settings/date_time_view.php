<div class="page-content">
  <div class="wrap">
    <h4 id="success" style="text-align:center;"></h4>
<div class="ibox-content">
    <form class="form-horizontal" role="form" action="<?php echo base_url('settings/date_time_setting'); ?>" method="post" id="date_time_update">
      <div class="body_text_text">
        <div class="form-group">
            <label for="Timezone" class="col-sm-2 control-label">Timezone:</label>
            <div class="col-sm-10">

              <?php echo timezone_menu(@$user_details['Timezone'],'form-control chosen-select','Timezone'); ?>
            </div>
            <span id="Timezone"></span>
        </div>

        <div class="form-group">
            <label for="Date_Format" class="col-sm-2 control-label">Date Format:</label>
            <div class="col-sm-10">
              <select class="form-control chosen-select" name="Date_Format" placeholder="Date Format">
                <option value="">----------Select----------</option>
                <option <?php echo (@$user_details['Date_Format']==='d M Y')?'selected': '';?> value="d M Y">dd Mon yyyy(01 Jan 2016)</option>
                <option <?php echo (@$user_details['Date_Format']==='d m Y')?'selected': '';?> value="d m Y">dd mm yyyy(01 01 2016)</option>
                <option <?php echo (@$user_details['Date_Format']==='M d Y')?'selected': '';?> value="M d Y">Mon dd yyyy(Jan 01 2016)</option>
                <option <?php echo (@$user_details['Date_Format']==='m d Y')?'selected': '';?> value="m d Y">mm dd yyyy(01 01 2016)</option>
                <option <?php echo (@$user_details['Date_Format']==='Y M d')?'selected': '';?> value="Y M d">yyyy Mon dd(2016 Jan 01)</option>
                <option <?php echo (@$user_details['Date_Format']==='Y m d')?'selected': '';?> value="Y m d">yyyy mm dd(2016 01 01)</option>
                <option <?php echo (@$user_details['Date_Format']==='d F Y')?'selected': '';?> value="d F Y">dd Month yyyy(01 January 2016)</option>
              </select>
            </div>
            <span id="Date_Format"></span>
        </div>

        <div class="form-group">
          <label for="Time_Format" class="col-sm-2 control-label">Time Format: </label>
          <div class="col-sm-10">
            <select class="form-control chosen-select" name="Time_Format" placeholder="Time Format">
             <option value="">----------Select----------</option>
               <option <?php echo (@$user_details['Time_Format']==='12 Hrs')?'selected': '';?> value="12 Hrs">12 Hrs</option>
               <option <?php echo (@$user_details['Time_Format']==='24 Hrs')?'selected': '';?> value="24 Hrs">24 Hrs</option>                                           
            </select>                           
          </div>
          <span id="Time_Format"></span>
        </div>

        <!-- <div class="form-group">
            <label for="TimeInterval_Format" class="col-sm-2 control-label">Alert Interval (In Days):</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="alert_interval" placeholder="Date Format" value="<?php //echo @$user_details['alert_interval']?>">
            </div>
            <span id="alert_interval"></span>
        </div> -->

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
<!-- Gritter -->
<script src="<?php echo base_url("js/plugins/gritter/jquery.gritter.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.chosen-select').chosen();
    
    $("#date_time_update").validate({
                 rules: {
                     Timezone: {
                         required: true,
                     },
                     Date_Format: {
                         required: true,
                     },
                     Time_Format: {
                         required: true,
                     }
                 }
             });

    $("#date_time_update").postAjaxData(function(result){
      var d = $('#date_time_update').serializeArray();
      $.each(d,function(obj,col){
                //$.each(col,function(column,value){
                  console.log(col.name);
                  $("#"+col.name).text('');
                //});
      });
      //alert(result);
      if(result === 1)
      {
          //alert(result);
          $("#success").html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Settings Updated Successfully.</div>');
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