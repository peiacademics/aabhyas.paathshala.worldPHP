<div class="row text-right">
  <a href="<?php echo base_url('team/add')?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>   
</div>
<div class="row">
  <div class="row">
    <div class="form-group col-sm-12">
    <div class="input-group">
        <input type="text" placeholder="Search Employee" id="search" class="input-sm form-control"> 
        <span class="input-group-btn">
            <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> 
        </span>
    </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="row" id="team">
        <?php
        foreach ($DETAIL as $key => $value) 
        { ?>
        <div class="col-lg-4" id="remove<?php echo $value['ID'];?>" style="height: 300px;">
            <div class="contact-box">
                <a href="<?php echo base_url('Team/view/'.$value["ID"]);?>">
                <div class="col-sm-4">
                    <div class="text-center">
                        <?php
                        $img = $this->str_function_library->call('fr>SS>path:ID=`'.$value['Image_ID'].'`');
                        $des = $this->str_function_library->call('fr>DS>post:ID=`'.$value['Type'].'`');
                        $add_id = explode(',', $value['address_ID']);
                        $add = $this->str_function_library->call('fr>AD>address:ID=`'.$add_id[0].'`');
                        $phone_id = explode(',', $value['phone_no_ID']);
                        $phone = $this->str_function_library->call('fr>PH>phone_number:ID=`'.$phone_id[0].'`');
                        ?>
                        <img alt="image" class="img-circle m-t-xs img-responsive" src="<?php echo base_url($img); ?>">
                    </div>
                </div>
                <div class="col-sm-8">
                    <h3><strong><?php echo $value['Name']; ?></strong></h3>
                    <p class="m-t-xs font-bold"><?php echo $des; ?></p>
                    <p><i class="fa fa-phone"></i> <?php echo $phone; ?></p>
                    <address>
                        <?php echo '<i class="fa fa-map-marker"></i>    '.$add; ?>
                    </address>
                </div>
                <div class="clearfix"></div>
                    </a>
                <div class="contact-box-footer">
                    <div class="m-t-xs btn-group">
                        <a href="<?php echo base_url('Team/view/'.$value["ID"]);?>" class="btn btn-xs btn-white"><i class="fa fa-eye"></i> View </a>
                        <a href="<?php echo base_url('Team/edit/'.$value["ID"]);?>" class="btn btn-xs btn-white"><i class="fa fa-pencil"></i> Edit</a>
                        <button onClick="del1('<?php echo $value["ID"]; ?>');" class="btn btn-xs btn-white"><i class="fa fa-trash"></i> Delete</button>

                    </div>

                </div>

            </div>
        </div>
        <?php }
        ?>
    </div>
</div>
<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<!-- Datatable -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.flash.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/jszip.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/pdfmake.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/vfs_fonts.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.html5.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.print.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>">
</script>

<script type="text/javascript">
    $("#search").keyup(function(){
    _this = this;
      // Show only matching TR, hide rest of them
      $.each($("#team .contact-box"), function() {
          if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
             $(this).parent('div').hide();
          else
             $(this).parent('div').show();                
      });
    });

function del1(id)
{
    bootbox.confirm('Are you sure you want to delete?', function(result) {
    if(result == true)
    {
      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
      $("#Login_screen").fadeIn('fast');
      $.ajax({
        url:'<?php echo base_url(); ?>'+'Team/delete/'+id,
        method:'POST',
        datatype:'JSON',
        error: function(jqXHR, exception) {
                $("#Login_screen").fadeOut(2000);
                //Remove Loader
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            },
        success:function(response){
          $("#Login_screen").fadeOut(2000);
          response = JSON.parse(response);
          if(response === true)
          {
            toastr.success('Successfully deleted.');
            setTimeout(function(){
              $("#remove"+id).fadeOut(1500);
            }, 3000);
          }
          else
          {
            toastr.error("Something went wrong!");
          }
        }
      });
    }
  });
}


</script>


