<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Centre & Inventory')); ?></h5>
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
                <form class="form-horizontal" role="form" action="<?php echo base_url('Centerandinventory/add'); ?>" method="post" id="bank_add">
                    <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                    <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo (@$View['branch_ID'] == NULL) ? $this->uri->segment(3, 0) : $View['branch_ID']; ?>">
                    
                     <div class="form-group">
                          <label class="col-sm-1 control-label">Name : </label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo @$View['name']; ?>" required>
                          </div>
                          <label class="col-sm-2 control-label">Add Quantity : </label>
                          <div class="col-sm-3">
                            <input type="number" class="form-control" id="quantity" placeholder="Quantity" min="<?php echo (isset($What) == 'Updated') ? 0 : 1; ?>" value="0" onChange="add_items()" required>
                            <input type="hidden" name="quantity" value="<?php echo @$View['quantity']; ?>">
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-1 control-label">Details : </label>
                          <div class="col-sm-6">
                             <textarea type="text" class="form-control" name="description" placeholder="Description"><?php echo @$View['description']; ?></textarea>
                          </div>
                          <?php if(isset($What) == 'Update') { ?>
                          <div class="col-sm-4">
                            <strong class="h1 text-danger" id="qty_or">Total Quantity : <?php echo (@$View['quantity'] != NULL) ? @$View['quantity'] : '0'; ?></strong>
                          </div>
                          <?php } ?>
                      </div>

                      <div class="form-group" id="item_rec">
                        <?php if((@$View['serial_nos'] != NULL) && !empty(@$View['serial_nos'])) {
                          $i = 0;
                          foreach ($View['serial_nos'] as $key => $value) {
                            $i++; ?>
                          <div class="col-xs-3" id="item_edit_div-<?php echo $i; ?>">
                            <div class="input-group">
                              <input type="hidden" id="ID-<?php echo $i; ?>" name="ID-<?php echo $i; ?>" value="<?php echo $value['ID']; ?>">
                              <input type="text" class="form-control" id="serial_no-<?php echo $i; ?>" placeholder="Serial Number" name="serial_no-<?php echo $i; ?>"  value="<?php echo $value['serial_no']; ?>" required>
                              <span class="input-group-addon btn btn-danger" onClick="delete_item('<?php echo $i; ?>','<?php echo $value['ID']; ?>')">
                                <i class="fa fa-trash-o" area-hidden="true"></i>
                              </span>
                            </div>
                          </div>
                          <?php if(fmod($i, 4) == 0) { ?>
                            <br><br>
                          <?php } ?>
                        <?php } } ?>
                      </div>
                      <input type="hidden" id="count_sr" value="<?php echo count(@$View['serial_nos']); ?>">
                      <div class="form-group" id="item"></div>
     					</div>
                       
                    	<div class="form_footer">
                    	<div class="row">
                        	<div class="col-md-6 text-center col-md-offset-3 ">
                                    <button type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>
                                </div>
                        	</div>

                        </form> 
                    

        </div>
    </div>
  </div>
</div>

<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    
    $("#bank_add").postAjaxData(function(result){
      if(result === 1)
      {
        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully '+type+'.');
        setTimeout(function(){
          window.location.href = "<?php echo current_url(); ?>";
        }, 1000);
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
    $("#bank_add").validate();
  });

  function add_items()
  {
    var qty = $('input[name="quantity"]').val();
    qty = $('#quantity').val();
    var sr_no = 0;
    sr_no = $('#count_sr').val();
    var tot_qty = 0;
    tot_qty = parseInt(parseInt(sr_no)+parseInt(qty));
    var data = '';
    var j = 0;
    j = parseInt(parseInt(sr_no)+1);
    var k = 0;
    for(var i=j;i<=tot_qty;i++)
    {
      k++;
      data += '<div class="col-xs-3" id="item_div-'+i+'"><div class="input-group"><input type="hidden" id="ID-'+i+'" name="ID-'+i+'" value=""><input type="text" class="form-control" id="serial_no-'+i+'" placeholder="Serial Number" name="serial_no-'+i+'" required><span class="input-group-addon btn btn-default" onClick="remove_item('+i+')"><i class="fa fa-times" area-hidden="true"></i></span></div></div>';
      if((k % 4) == 0)
      {
        data += '<br><br>';
      }
    }
    $('#item').html(data);
    $('#count_sr').val(tot_qty);
    $('input[name="quantity"]').val(tot_qty);
    $('#qty_or').html('Total Quantity : '+tot_qty);
    $('#quantity').attr('disabled',true);
  }

  function remove_item(num)
  {
    var qty = $('input[name="quantity"]').val();
    $('#serial_no-'+num).attr('hidden',true);
    $('#serial_no-'+num).removeAttr('name');
    $('#item_div-'+num).remove();
    qty--;
    $('input[name="quantity"]').val(qty);
    $('#qty_or').html('Total Quantity : '+qty);
  }

  function delete_item(num,id)
  {
    bootbox.confirm('Are you sure you want to delete?', function(result) {
      if(result == true)
      {
        $.ajax({
          type:'POST',
          url: '<?php echo base_url(); ?>'+'Centerandinventory/delete_item/'+id,
          success:function(response)
          {
            response = JSON.parse(response);
            if(response == true)
            {
              toastr.success('Successfully deleted.');
              var qty = $('input[name="quantity"]').val();
              $('#serial_no-'+num).attr('hidden',true);
              $('#serial_no-'+num).removeAttr('name');
              $('#item_edit_div-'+num).remove();
              qty--;
              $('input[name="quantity"]').val(qty);
              $('#qty_or').html('Total Quantity : '+qty);
              setTimeout(function(){
                window.location.href = "<?php echo current_url(); ?>";
              }, 1000);
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