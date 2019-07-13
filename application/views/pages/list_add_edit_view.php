<div class="row">
  <!-- <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Calling Lists')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div> -->
<div class="ibox-content">
<div class="page-content">
  <div class="wrap">
    <h4 id="success" style="text-align:center;"></h4>
    <form class="form-horizontal" role="form" action="<?php echo base_url('lists/add'); ?>" method="post" id="cust_add">
      <input type="hidden" name="ID" value="<?php echo @$DETAIL['View'][0]['ID'];?>">

        <div class="form-group">
          <span class="col-sm-offset-9 text-danger text-right"><i>Mandatory fields marked by (*) mark !</i></span>
        </div>

       <div class="form-group">
            <label  class="col-sm-2 control-label"><span class="text-danger text-right"><i>*</i></span> List No : </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="List No" name="list_ID" value="<?php echo $listID; ?>" readonly required>
              <input type="hidden" name="branch_id" value="<?php echo $branch_ID; ?>">
            </div>
              <span id="list_ID"></span>
        </div>

        <div class="form-group">
            <label for="list_Name" class="col-sm-2 control-label"><span class="text-danger text-right"><i>*</i></span> List Name  : </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="list_Name" placeholder="List Name" value="<?php echo @$DETAIL['View'][0]['list_Name']; ?>" required>
            </div>
              <span id="list_Name"></span>
        </div>

        <div class="form-group">
            <label for="list_Name" class="col-sm-2 control-label">Assign To  : </label>
            <div class="col-sm-10">
              <select id="assign_to" data-placeholder="Select revised bill number..." class="form-control chosen-select" name="assign_to">
                <option value="">Please Select</option>
                  <?php 
                  if($employee != FALSE) {
                        foreach ($employee as $key => $value) {
                  ?>  
                  <option value="<?php echo $value['ID']; ?>"> <?php echo $value['Name']; ?></option>
                  <?php        
                        }
                  }
                else{ ?>
                <option value="">Data Not Found.</option>
                <?php } ?> 
              </select>
            </div>
              <span id="assign_to"></span>
        </div>

              <?php 
                    if(isset($DETAIL['List']['Phone']) && (!empty($DETAIL['List']['Phone']))) 
                    {
                      $i = 0;

                      foreach(@$DETAIL['List']['Phone'] as $col_val)
                      {
                        $i++;
              ?>    
                          <div class="form-group" id="<?php echo ($i !== 1) ? 'phone-div-'.$i : '';?>">
                              <input type="hidden" name="PH-ID-<?php echo $i; ?>" value="<?php echo @$col_val['ID'];?>">
                              <label for="" class="col-sm-3 control-label"><?php echo ($i === 1) ? 'Phone no : ': ''; ?></label>
                              <div class="col-sm-2">
                                <select class="form-control" name="PH-phone_type-<?php echo $i; ?>">
                                  <option value="Work" <?php echo ($col_val['phone_type']) === 'Work' ? 'selected':''; ?>>Work</option>
                                  <option value="Home" <?php echo ($col_val['phone_type']) === 'Home' ? 'selected':''; ?>>Home</option>
                                  <option value="Mobile" <?php echo ($col_val['phone_type']) === 'Mobile' ? 'selected':''; ?>>Mobile</option>
                                  <option value="Personal" <?php echo ($col_val['phone_type']) === 'Personal' ? 'selected':''; ?>>Personal</option>
                                  <option value="Fax" <?php echo ($col_val['phone_type']) === 'Fax' ? 'selected':''; ?>>Fax</option>
                                  <option value="Main" <?php echo ($col_val['phone_type']) === 'Main' ? 'selected':''; ?>>Main</option>
                                </select>
                              </div>
                              <div class="col-sm-3">
                                <input type="number" class="form-control" name="PH-phone_number-<?php echo $i; ?>" placeholder="Phone no." value="<?php echo @$col_val['phone_number']; ?>" min="100000" minlength="6" maxlength="12">
                              </div>
                              <div class="col-sm-1">
                        <?php if($i === 1)
                              {
                        ?>
                                <button type="button" class="btn btn-white btn-bitbucket add_contact">
                                    <i class="fa fa-plus"></i>
                                </button>
                        <?php }
                              else
                              {
                        ?>
                                <button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone('phone-div-<?php echo $i; ?>','yes');"><i class="fa fa-close"></i></button>
                        <?php }   
                        ?>
                              </div>
                                <span id="cst"></span>
                          </div>
                          
                <?php } ?>
                      <div id="add-contact">
                      </div>
                      <input type="hidden" id="row_count1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
                      <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">

              <?php }
                  else
                  {
              ?>        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Contact Details : </label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                              <div class="input-group">
                                <span class="text-danger text-right input-group-addon"  id="basic-addon1"><i>*</i></span>
                                <input type="text" class="form-control" placeholder="First Name" name="C-f_Name-1" value="" required aria-describedby="basic-addon1">
                              </div>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" placeholder="Father Name" name="C-fa_Name-1" value="">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" placeholder="Mother Name" name="C-mo_Name-1" value="">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" placeholder="Last Name" name="C-l_Name-1" value="">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" placeholder="City" name="C-city-1" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Contact Numbers : </label>
                            <div class="col-sm-3">
                              <div class="input-group">
                                <span class="text-danger text-right input-group-addon"  id="basic-addon2"><i>*</i></span>
                                <input type="number" class="form-control" name="C-contact_No-1" placeholder="Contact no. 1" value=""  min="100000" minlength="6" maxlength="12" required aria-describedby="basic-addon2">
                              </div>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="C-contact_No2-1" placeholder="Contact no. 2" value=""  min="100000" minlength="6" maxlength="12">
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="C-contact_No3-1" placeholder="Contact no. 3" value=""  min="100000" minlength="6" maxlength="12">
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-white btn-bitbucket add_contact">
                                  <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <span id="cst"></span>
                        <div id="add-contact">
                        </div>
                        <input type="hidden" id="row_count1" value="1">
                        <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
            <?php 
                  }
                 ?>
         			  	</div>
                           
                        	<div class="form_footer">
                        	<div class="row">
                            	<div class="col-md-6 text-center col-md-offset-3 ">
                                        <button type="submit" class="btn btn-primary"><?php echo isset($DETAIL['What']) ? 'Update' : 'Add'; ?></button>
                                    </div>
                            	</div>

                            </form> 
                        

            </div>
        </div>
    </div>
  </div>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>

<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
    
<script type="text/javascript">
$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
// $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  function remove_phone(phone_div,n)
  {
    if(n == 'yes')
    {
      var d = $("#num_row1").val();
      var k = --d;
      $("#num_row1").val(k);
    }
    else
    {
      var c = $("#row_count1").val();
      var j = --c;
      $("#row_count1").val(j);
    }
      $('#'+phone_div).remove();
    
  }


 

  $(document).ready(function() {
    $(".chosen-select").chosen();
    $('.add_contact').on('click',function(){
      var c = $("#row_count1").val();
      ++c;
      $('<div id="phone-div-'+c+'"><div class="form-group"><div class="col-sm-3"><div class="input-group"><span class="text-danger text-right input-group-addon"  id="basic-addon'+c+'"><i>*</i></span><input type="text" class="form-control" placeholder="First Name" name="C-f_Name-'+c+'" value="" required  aria-describedby="basic-addon'+c+'"></div></div><div class="col-sm-2"><input type="text" class="form-control" placeholder="Father Name" name="C-fa_Name-'+c+'" value=""></div><div class="col-sm-2"><input type="text" class="form-control" placeholder="Mother Name" name="C-mo_Name-'+c+'" value=""></div><div class="col-sm-3"><input type="text" class="form-control" placeholder="Last Name" name="C-l_Name-'+c+'" value=""></div><div class="col-sm-2"><input type="text" class="form-control" placeholder="City" name="C-city-'+c+'" value=""></div></div><div class="form-group"><label for="" class="col-sm-2 control-label">Contact Numbers : </label><div class="col-sm-3"><div class="input-group"><span class="text-danger text-right input-group-addon"  id="basic-addon2"><i>*</i></span><input type="number" class="form-control" name="C-contact_No-'+c+'" placeholder="Phone no." value=""  min="100000" minlength="6" maxlength="12" required></div></div><div class="col-sm-3"><input type="number" class="form-control" name="C-contact_No2-'+c+'" placeholder="Contact no. 2" value=""  min="100000" minlength="6" maxlength="12"></div><div class="col-sm-3"><input type="number" class="form-control" name="C-contact_No3-'+c+'" placeholder="Contact no. 3" value=""  min="100000" minlength="6" maxlength="12"></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div></div></div>').appendTo('#add-contact');
      $("#row_count1").val(c);
    });

    $("#cust_add").postAjaxData(function(result){
       if(result === 1)
      {
        var type = "<?php echo isset($DETAIL['What']) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully '+type+'.');
        setTimeout(function(){
          location.reload();
        }, 3000);
      }
      else
      {
        if(typeof result === 'object')
        {
          mess = "";
          $.each(result,function(dom,err)
          {
            mess = mess+err+"\n";
            toastr.error(mess);
          });
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  


$("#cust_add").validate({
                 rules: {
                     name: {
                         required: true,
                     }
                 }
             });
  });    

  

</script>