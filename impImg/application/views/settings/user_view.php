 <div class="page-content">
            <div class="wrap">

              <h4 id="success" style="text-align:center;"></h4>
                    <form class="form-horizontal" role="form" action="<?php echo base_url('settings/add_user'); ?>" method="post" id="user_add">
                      <div class="body_text_text">

                          <!-- <div class="form-group">
                              <label for="Timezone" class="col-sm-3 control-label">Timezone</label>
                              <div class="col-sm-6">
                                <?php //echo timezone_menu('UP55','form-control chosen-select','Timezone'); ?>
                              </div>
                                <span id="Timezone"></span>
                          </div>

                          <div class="form-group">
                              <label for="Date_Format" class="col-sm-3 control-label">Date Format</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="Date_Format" placeholder="Date Format">
                              </div>
                                <span id="Date_Format"></span>
                          </div>

                          <div class="form-group">
                          <label for="Time_Format" class="col-sm-3 control-label">Time Format </label>
                          <div class="col-sm-6">
                          <select class="form-control chosen-select" name="Time_Format" placeholder="Time Format">
                           <option value="">----------Select----------</option>
                             <option value="12 Hrs">12 Hrs</option>
                             <option value="24 Hrs">24 Hrs</option>                                           
                          </select>                           
                          </div>
                          <span id="Time_Format"></span>
                          </div> -->

                          <div class="form-group">
                          <label for="Type" class="col-sm-3 control-label">Select Type Of User </label>
                          <div class="col-sm-6">
                          <select class="form-control chosen-select" name="Type">
                           <option value="">----------Select----------</option>
                             <option value="Admin">Admin</option>
                             <option value="Client">Client</option>
                             <option value="Team Member">Team</option>                            
                          </select>                           
                          </div>
                          <span id="Type"></span>
                          </div>

                          <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Name</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="Name" placeholder="Name">
                              </div>
                                <span id="Name"></span>
                          </div>
                                        
                          <div class="form-group">
                              <label for="Email" class="col-sm-3 control-label">Email</label>
                              <div class="col-sm-6">
                                <input type="email" class="form-control" name="Email" placeholder="Email">
                              </div>
                               <span id="Email"></span>
                          </div>

                          <div class="form-group">
                              <label for="Password" class="col-sm-3 control-label">Password</label>
                              <div class="col-sm-6">
                                <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
                              </div>
                              <span id="Password"></span>
                          </div>

                          <div class="form-group">
                          <label for="Language_ID" class="col-sm-3 control-label">Select Language</label>
                          <div class="col-sm-6">
                          <select class="form-control chosen-select" name="Language_ID">
                           <option value="">----------Select----------</option>
                           <?php 
                           if($language_array != FALSE) {
                                  foreach ($language_array as $key => $value) {
                           ?>
                                        <option value="<?php echo $value['ID']; ?>"> <?php echo $value['Title']; ?></option>
                                   
                           <?php    }
                                 }
                           else{
                            ?>
                                <option value="">Data Not Found.</option>
                           <?php } ?>
                         
                                                   
                          </select>                           
                          </div>
                          <span id="Language_ID"></span>
                          </div> 

                                                              
                         
                      </div>
                           
                          <div class="form_footer">
                          <div class="row">
                              <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Add User</button>
                                    </div>
                              </div>
                          </div>

                            </form> 
                        

            </div>
        </div>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Gritter -->
<script src="<?php echo base_url("js/plugins/gritter/jquery.gritter.min.js"); ?>"></script>
<!-- Chosen -->

<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#user_add").validate({
                 rules: {
                     Type: {
                         required: true,
                     },
                     Name: {
                         required: true,
                     },
                     Email: {
                         required: true,
                     },
                     Password: {
                         required: true,
                     },
                     Language_ID: {
                         required: true,
                     }
                 }
             });
      
      $("#user_add").postAjaxData(function(result){
      //console.log($("#user_add").valid());
      var d = $('#user_add').serializeArray();
      $.each(d,function(obj,col){
        console.log(col.name);
        $("#"+col.name).text('');
      });
      //alert(result);

      if(result === 1)
      {
          //alert(result);
          $("#success").html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>New User Added Successfully.</div>');
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