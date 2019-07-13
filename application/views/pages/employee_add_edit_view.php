<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Product')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div>
<div class="ibox-content">
 <div class="page-content">
            <div class="wrap">

              <h4 id="success" style="text-align:center;"></h4>
                    <form class="form-horizontal" role="form" action="<?php echo base_url('Task/add'); ?>" method="post" id="product_add">
                      <input type="hidden" name="ID" value="<?php echo @$DETAIL['View'][0]['ID'];?>">
                      <div class="body_text_text">
                         
                         <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Select Vendor : </label>
                              <div class="col-sm-1">
                              <?php
                                if (!empty(@$DETAIL['View'])) 
                                { ?>
                                   <input type="checkbox" class="form-control checkbox3" value="Yes" <?php echo (@!empty($DETAIL['View'][0]['purchase_ID']))? 'checked':''; ?>> 
                              <?php  }
                              else
                              { ?>
                                <input type="checkbox" class="form-control checkbox3" value="Yes" >
                              <?php }
                              ?>
                              </div>
                          </div>
                          <?php //print_r($DETAIL); ?>
                          <div class="form-group" id="txtVendr" <?php echo (@!empty($DETAIL['View'][0]['purchase_ID']))? '':'hidden'; ?>>
                              <label for="Name" class="col-sm-3 control-label">Add Price : </label>

                              <div class="col-sm-5">
                                <select data-placeholder="Select Validity Peroid" id="vndr" class="form-control chosen-select" name="vendor_ID" required>
                                  <option value="">Select Vendor </option>
                                  <?php if (isset($Vendors)) {
                                    foreach ($Vendors as $key => $value) { ?>
                                    <option value="<?php echo $value['ID'];?>" <?php echo (@$DETAIL['View'][0]['vendor_ID']===$value['ID']) ? 'selected' :'' ;?>><?php echo $value['name'];?></option>
                                  <?php  }
                                  }else{?>
                                  <option value="">Data Not Found </option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="col-sm-4">
                                <input type="number" class="form-control" id="pPrice" placeholder="Price" name="purchase_cost" value="<?php echo @$DETAIL['View'][0]['purchase_cost']; ?>" required>
                              </div>
                              
                                <span id="description"></span>
                                <!-- <input type="hidden" name="num_row1" id="num_row1" value=""> -->
                          </div>

                          <div class="form-group">
                          <label for="Type" class="col-sm-3 control-label">Type : </label>
                          <div class="col-sm-9">
                            <select id="contact" data-placeholder="Select A Client..." class="form-control chosen-select" name="product_type" required>


                            <option value="">Please Select</option>
                            
                              <?php 


                              if($DETAIL['Product_type'] != FALSE) {
                                    foreach ($DETAIL['Product_type'] as $key => $value) {

                                          if(isset($DETAIL['View']) && $value['ID'] == $DETAIL['View'][0]['product_type'] ){
                              ?>
                                            <option value="<?php echo $value['ID']; ?>" selected> <?php echo $value['title']; ?></option>
                              <?php       }
                                          else{
                              ?>            <option value="<?php echo $value['ID']; ?>"> <?php echo $value['title']; ?></option>
                                     
                              <?php       }    
                                    }
                              }
                              else{ ?>
                                  <option value="">Data Not Found.</option>
                              <?php } ?> 
                              </select>
                          </div>
                          <span id="Type"></span>
                          </div>

                          <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Title : </label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="Name" placeholder="Product Name" name="name" value="<?php echo @$DETAIL['View'][0]['name']; ?>" required>
                              </div>
                                <span id="Name"></span>
                          </div>
                           
                          <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Description : </label>
                              <div class="col-sm-9">
                                <textarea type="text" class="form-control" name="description" placeholder="Description"><?php echo @$DETAIL['View'][0]['description']; ?></textarea>
                              </div>
                                <span id="description"></span>
                          </div>

                          <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Show Validity : </label>
                              <div class="col-sm-1">
                              <?php
                                if (!empty(@$DETAIL['View'])) 
                                { ?>
                                   <input type="checkbox" class="form-control checkbox2" name="is_validate" value="Yes" id="isvalidate" <?php echo (@$DETAIL['View'][0]['is_validate']=='Yes')? 'checked':''; ?>> 
                              <?php  }
                              else
                              { ?>
                                <input type="checkbox" class="form-control checkbox2" name="is_validate" value="Yes" checked id="isvalidate">
                              <?php }
                              ?>
                              </div>
                          </div>

                          <div class="form-group" id="txtAge">
                              <label for="Name" class="col-sm-3 control-label">Validity : </label>
                              <div class="col-sm-4">
                                <input type="number" class="form-control" id="validity" placeholder="Number" name="validity" value="<?php echo @$DETAIL['View'][0]['validity']; ?>" required>
                              </div>
                              <div class="col-sm-5">
                                <select data-placeholder="Select Validity Peroid" id="unit" class="form-control chosen-select" name="unit" required>
                                  <option value="">Select validity...</option>
                                  <option value="Week" <?php echo @$DETAIL['View'][0]['unit'] == 'Week' ? 'selected' : '' ?> >Week</option>
                                  <option value="Month" <?php echo @$DETAIL['View'][0]['unit'] == 'Month' ? 'selected' : '' ?> >Month</option>
                                  <option value="Year" <?php echo @$DETAIL['View'][0]['unit'] == 'Year' ? 'selected' : '' ?> >Year</option>
                                </select>
                              </div>
                                <span id="description"></span>
                                <!-- <input type="hidden" name="num_row1" id="num_row1" value=""> -->
                          </div>

                          <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Price : </label>
                              <div class="col-sm-9">
                                <input type="number" class="form-control" id="price" placeholder="Price" name="price" value="<?php echo @$DETAIL['View'][0]['price']; ?>" required>
                              </div>
                          </div>

                      </div>
                        <div class="form_footer">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-6">
                                      <button type="submit" class="btn btn-primary"><?php echo isset($DETAIL['What']) ? 'Update' : 'Add'; ?></button>
                            </div>
                        </div>
                        </div>
                        </form>    
                        
        </div>
      </div>
    </div>
</div>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
$(".chosen-select").chosen();
var isvalidate = "<?php echo (@$DETAIL['View'][0]['is_validate'] == 'No') ? 'hide' : 'show'; ?>";
if (isvalidate == 'hide') 
{
  $("#txtAge").hide();
  // $('#validity').removeAttr('required',true);​​​​​ 
  // $('#unit').removeAttr('required',true);​​​​​ 
  $('#validity').prop('required',false);
  $('#unit').prop('required',false);
}
 $(".checkbox2").change(function() {
    $('#validity').val('');
    $('#unit').val('').trigger("chosen:updated");

    if(this.checked) {
      $("#txtAge").show();
      $('#validity').prop('required',true);
      $('#unit').prop('required',true);
    }
    else
    {
      $("#txtAge").hide();
      // $('#validity').removeAttr('required',true);​​​​​ 
      // $('#unit').removeAttr('required',true);​​​​​ 
      $('#validity').prop('required',false);
      $('#unit').prop('required',false);
    }
});

$.validator.setDefaults({ ignore: ":hidden:not(select)" });
  $(document).ready(function() {
   
    $("#product_add").validate({
                 rules: {
                     product_type: {
                         required: true,
                     },
                     name: {
                         required: true,
                     },
                     modelID: {
                         required: true,
                     },
                     model_name: {
                         required: true,
                     },
                     warranty_period: {
                         required: true,
                      },
                     capacity: {
                         required: true,
                     },
                     price: {
                         required: true,
                     }
                 }
             });

      $("#product_add").postAjaxData(function(result){
      var d = $('#product_add').serializeArray();
      $.each(d,function(obj,col){
        $("#"+col.name).text('');
      });

        if(result === 1)
        {
          var type = "<?php echo isset($DETAIL['What']) ? 'Updated' : 'Added'; ?>";
          toastr.success('Successfully '+type+'.');
          setTimeout(function(){
            window.location.href = "<?php echo current_url(); ?>";
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

  $('.add_prod').on('click',function(){
    var c = $("#row_count1").val();
    c++;
    $(' <div class="form-group" id="model-div-'+c+'"><label for="Name" class="col-sm-3 control-label"></label><div class="col-sm-8"><div class="col-sm-4"><input type="text" class="form-control" name="M-model_name-'+c+'" placeholder="Model Number or Name" value="" required></div><div class="col-sm-2"><input type="number" class="form-control" name="M-warranty_period-'+c+'" placeholder="Months" value="" required></div><div class="col-sm-2"><input type="number" class="form-control" name="M-capacity-'+c+'" placeholder="Capacity" value="" required></div><div class="col-sm-2"><select class="form-control chosen-select" name="M-unit-'+c+'" required><option value="">Select..</option><option value="Ampere">Ampere</option><option value="Volt">Volt</option><option value="Unit">Unit</option><option value="Hertz">Hertz</option></select></div><div class="col-sm-2"><input type="number" class="form-control" name="M-price-'+c+'" placeholder="Price" value="" required></div></div><button type="button" class="btn btn-white btn-bitbucket remove_prod" onclick="remove_prod(\'model-div-'+c+'\');"><i class="fa fa-close"></i></button></div>').appendTo('#add-prod');
    $("#row_count1").val(c);
    });

}); 

function remove_prod(model_div,n)
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
    $('#'+model_div).remove();
  }

// var isvalidate = "<?php echo (@$DETAIL['View'][0]['is_validate'] == 'No') ? 'hide' : 'show'; ?>";
// if (isvalidate == 'hide') 
// {
//   $("#txtAge").hide();
//   // $('#validity').removeAttr('required',true);​​​​​ 
//   // $('#unit').removeAttr('required',true);​​​​​ 
//   $('#validity').prop('required',false);
//   $('#unit').prop('required',false);
// }
$('#vndr').removeAttr('required');
 $(".checkbox3").change(function() {
    $('#vndr').val("").trigger("chosen:updated");
    $('#pPrice').val('');
    if(this.checked) {
      $("#txtVendr").show();
      $('#vndr_chosen').css('width','100%');
      $('#vndr').prop('required',true);
      $('#pPrice').prop('required',true);
    }
    else
    {
      $("#txtVendr").hide();
      // $('#validity').removeAttr('required',true);​​​​​ 
      // $('#unit').removeAttr('required',true);​​​​​ 
      $('#vndr').removeAttr('required');
      $('#pPrice').prop('required',false);
    }
});
</script>