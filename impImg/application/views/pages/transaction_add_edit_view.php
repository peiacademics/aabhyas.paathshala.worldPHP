<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Transaction')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div>
<div class="ibox-content dashboard-bottom">
 <div class="page-content">
            <div class="wrap">
<h4 id="success" style="text-align:center;"></h4>
                    <form class="form-horizontal" role="form" action="<?php echo base_url('transaction/add'); ?>" method="post" id="transaction_add">
                      <input type="hidden" name="ID" value="<?php echo @$DETAIL['View'][0]['ID'];?>">
                      <?php $desi = $this->session_library->get_session_data('Login_as'); 
                        if($desi == 'DSSK10000001') { ?>
                          <div class="form-group">
                            <label for="Name" class="col-sm-3 control-label">Branch : </label>
                             <div class="col-sm-3">
                             <select id="branch" data-placeholder="Select A Branch..." class="form-control chosen-select" name="branch_ID">                                  
                               <option value="">Please Select..</option>
                              <?php 
                              if($DETAIL['Branch'] != FALSE) {
                                    foreach ($DETAIL['Branch'] as $key => $value) {

                                          if(isset($DETAIL['View']) && $value['ID'] == $DETAIL['View'][0]['branch_ID'] ){
                              ?>
                                            <option value="<?php echo $value['ID']; ?>" selected> <?php echo $value['name']; ?></option>
                              <?php       }
                                          else{
                              ?>            <option value="<?php echo $value['ID']; ?>"> <?php echo $value['name']; ?></option>
                                     
                              <?php       }    
                                    }
                              }
                              else{ ?>
                                  <option value="">Data Not Found.</option>
                              <?php } ?>
                                </select>
                                </div>
                            </div>

                      <?php } else { ?>
                          <?php if(@$DETAIL['View'][0]['branch_ID'] != NULL) { ?>
                              <input type="hidden" name="branch_ID" value="<?php echo $DETAIL['View'][0]['branch_ID']; ?>">
                          <?php } else { ?>
                                <input type="hidden" name="branch_ID" value="<?php echo $this->uri->segment(3); ?>">
                              <?php } ?>
                      <?php } ?>
              <div class="form-group">
                                  <label for="Name" class="col-sm-3 control-label">Expence Category : </label>
                                   <div class="col-sm-3">
                                   <select id="expense_cat" data-placeholder="Select A payment mode..." class="form-control chosen-select" name="expence_category_ID" onChange = "get_reference()">                                  
                                     <option value="">Please Select..</option>
                                    <?php 
                                   
                                    if($DETAIL['Expence'] != FALSE) {
                                          foreach ($DETAIL['Expence'] as $key => $value) {

                                                if(isset($DETAIL['View']) && $value['ID'] == $DETAIL['View'][0]['expence_category_ID'] ){
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

                              <div class="col-sm-3 <?php echo @$DETAIL['View'][0]['referance_Name'] ? '':'hidden'; ?>" id="reference">
                                <select id="reference_bill" data-placeholder="Select " class="form-control chosen-select" name="reference_ID" onChange = "get_product_details2()">
                                <?php 
                                  if(isset($DETAIL['Reference']))
                                  { 
                                    foreach($DETAIL['Reference'] as $key => $references_id)
                                    {
                                      foreach($references_id as $key => $reference_id)
                                      { ?>
                                        <option value="<?php echo $reference_id['ID']; ?>" <?php echo (@$DETAIL['Reference1'] === $reference_id['ID']) ? 'selected':''; ?>><?php echo strpos($reference_id['ID'], 'BA')!== false ? $reference_id['bank_name'] :  $reference_id['Name']; ?></option>
                                  <?php 
                                      }
                                    }
                                  }
                                ?>
                                </select>
                              </div>

                              <div class="col-sm-3 <?php echo @$DETAIL['View'][0]['month_year'] ? '':'hidden'; ?>" id="reference2">
                                <input type="text" id="datepicker" name="month_year" class="form-control" onChange="get_product_details2()" value="<?php echo $this->date_library->db2date(@$DETAIL['View'][0]['month_year'],"Y-m");?>">
                              </div>

                              <input type="hidden" name="salary" id="salary">

                        </div>

                        <div class="form-group" id="model2">
                        </div>

              <h4 id="success" style="text-align:center;"></h4>
                    <form class="form-horizontal" role="form" action="<?php echo base_url('transaction/add'); ?>" method="post" id="transaction_add">
                      <input type="hidden" name="ID" value="<?php echo @$DETAIL['View'][0]['ID'];?>">
                          <div class="form-group">
                            <label for="Type" class="col-sm-3 control-label">Transaction Type : </label>
                            <div class="col-sm-4">
                            <select class="form-control chosen-select" name="transaction_type">
                              <option value="">----------Select----------</option>
                              <option value="Debit" <?php echo (@$DETAIL['View'][0]['transaction_type']) === 'Debit' ? 'selected':''; ?>>Debit</option>
                              <option value="Credit" <?php echo (@$DETAIL['View'][0]['transaction_type']) === 'Credit' ? 'selected':''; ?>>Credit</option>                            
                            </select>                           
                            </div>
                            <label for="Type" class="col-sm-2 control-label">Date : </label>
                            <div class="col-sm-3">
                            <input type="text" id="stock_date" class="datepicker form-control" name="date" placeholder="Date" value="<?php echo $this->date_library->db2date(@$DETAIL['View'][0]['date'],$this->date_library->get_date_format());?>" onChange="get_product_details()">
                            </div>
                            <span id="Type"></span>
                          </div>

                          <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Amount : </label>
                              <div class="col-sm-9">
                                <div class="input-group">
                                  <span class="input-group-addon"><?php echo @$DETAIL['Currency'][0]['symbol']; ?></span>
                                  <input type="number" class="form-control" placeholder="Amount" name="amount" value="<?php echo @$DETAIL['View'][0]['amount']; ?>" required>
                                </div>
                              </div>
                                <span id="Name"></span>
                          </div>
                         <div class="form-group">
                                  <label for="Name" class="col-sm-3 control-label">Payment mode : </label>
                                   <div class="col-sm-4">
                                   <select id="pay_mode" data-placeholder="Select A payment mode..." class="form-control chosen-select" name="payment_mode_ID" onChange = "get_bank()">                                  
                                     <option value="">Please Select..</option>
                                    <?php 
                                   
                                    if($DETAIL['Payment'] != FALSE) {
                                          foreach ($DETAIL['Payment'] as $key => $value) {

                                                if(isset($DETAIL['View']) && $value['ID'] == $DETAIL['View'][0]['payment_mode_ID'] ){
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
                              <div id="bank_dropdown" class="<?php echo @$DETAIL['View'][0]['bank_ID'] ? '':'hidden'; ?>">
                                <label for="Name" class="col-sm-2 control-label">Bank : </label>
                                     <div class="col-sm-3">
                                     <select id="bank" data-placeholder="Select A bank..." class="form-control chosen-select" name="bank_ID">                                  
                                       <option value="">Please Select..</option>
                                      <?php 
                                     
                                      if($DETAIL['Bank'] != FALSE) {
                                            foreach ($DETAIL['Bank'] as $key => $value) {

                                                  if(isset($DETAIL['View']) && $value['ID'] == $DETAIL['View'][0]['bank_ID'] ){
                                      ?>
                                                    <option value="<?php echo $value['ID']; ?>" selected> <?php echo $value['bank_name']; ?>-<?php echo $value['branch_name']; ?></option>
                                      <?php       }
                                                  else{
                                      ?>            <option value="<?php echo $value['ID']; ?>"> <?php echo $value['bank_name']; ?>-<?php echo $value['branch_name']; ?></option>
                                             
                                      <?php       }    
                                            }
                                      }
                                      else{ ?>
                                          <option value="">Data Not Found.</option>
                                      <?php } ?> 
                                      </select>  
                                     
                                  </div>
                                </div>
                          </div>
                         
                          <div class="form-group">
                              <label for="Name" class="col-sm-3 control-label">Details : </label>
                              <div class="col-sm-9">
                               <textarea class="form-control" id="Name" placeholder="Details" name="other_details" value=""><?php echo @$DETAIL['View'][0]['other_details']; ?></textarea>
                              </div>
                                <span id="description"></span>
                          </div>

                        <div class="form_footer">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-6">
                                      <button type="submit" class="btn btn-primary"><?php echo isset($DETAIL['What']) ? 'Update' : 'Add'; ?></button>
                                  </div>
                            </div>
                        </form>    
                        </div>
                      </div>         
        </div>
       </div>
      </div>

<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script type="text/javascript">

<?php
if (!empty($DETAIL['View'][0]['ID']) && (empty($DETAIL['View'][0]['reference_ID']) && ($DETAIL['View'][0]['expence_category_ID']!=='ECSK10000003' && $DETAIL['View'][0]['expence_category_ID']!=='ECSK10000004'))) { ?>
get_product_details2(); 

                                         <?php }
?>

$.validator.setDefaults({ ignore: ":hidden:not(select)" });
function get_bank()
{
  $("#bank").val('');
  $("#bank").trigger('chosen:updated');
  //$('#model2').addClass('hidden');
  var pay_mode = $('#pay_mode').val();
  if(pay_mode !== 'PMSK10000001' && pay_mode !== '')
  {
    console.log(pay_mode);
    $('#bank_dropdown').removeClass('hidden');
    $('#bank_chosen').css('width','244px');
  }
  else
  {
    $('#bank_dropdown').addClass('hidden');
    $('#bank').val('BASK10000001');
  }
}

function get_reference()
{
  //$('#reference_bill').html('');
  $('#reference_1').addClass('hidden');
  $('#reference_bill_1').addClass('hidden');
  $('#reference_bill_1').html('');

  $('#reference2').addClass('hidden');
  $('#reference2').val('');
  $('#salary').val('');
  $('#month_year').val('');

  //$('#model2').addClass('hidden');
  var expense_cat = $('#expense_cat').val();
  $('#reference_bill_chosen').addClass('hidden');
  $('#reference').removeClass('hidden');
  $('#reference_bill').html('');
  $('#model2').addClass('hidden');
  $('#reference').prepend('<span class="loader col-sm-12 h3 font-bold text-center"><i class="fa fa-spinner fa-spin"></i></span>');
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'transaction/get_reference/'+expense_cat,
    success:function(response)
    {
      $(".loader").remove();
      response = JSON.parse(response);
      if(typeof response === 'object')
      {
        $('#reference').removeClass('hidden');
        $('#reference_bill_chosen').removeClass('hidden');
        $('#reference_bill_chosen').css('width','244px');
        $.each(response, function(type,res){
          $('#reference_bill').append('<option value="" id="cat_type">Select '+type+'</option>');
          $.each(res, function(key,value){
            if(value.ID.indexOf('BA') === -1)
            {
              $('#reference_bill').append('<option value="'+value.ID+'">'+value.Name+'</option>');
            }
            else
            {
               $('#reference_bill').append('<option value="'+value.ID+'">'+value.bank_name+'</option>');
            }

            if(value.ID.indexOf('US') >= 0)
            {
              document.getElementById("reference_bill").setAttribute("onChange", "get_datepicker()");
               $('#salary').val(value.salary);
            }
            else if(value.ID.indexOf('BA') >= 0)
            {
              document.getElementById("reference_bill").setAttribute("onChange", "");
            }
            else
            {
              document.getElementById("reference_bill").setAttribute("onChange", "get_product_details2()");
            }

          });
          <?php
            if (isset($_SESSION['abc'])) { ?>
                $('#reference_bill').val("<?php echo $_SESSION['abc'];?>");
                $('#reference_bill').trigger("chosen:updated");
                get_reference_bill();
           <?php  }
           ?>
          $("#reference_bill").trigger('chosen:updated');
        });
      }
    }
  });
}

function get_datepicker()
{
  $('#model2').addClass('hidden');
  $('#reference2').removeClass('hidden');
  $("#datepicker").datepicker( {
    format: "yyyy-mm",
    viewMode: "months", 
    minViewMode: "months"
  });
}

function get_reference_bill()
{
  $('#reference_bill_1').html('');
  var reference_bill = $('#reference_bill').val();
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>transaction/get_reference_bill/'+reference_bill,
    success:function(response)
    {
      $(".loader").remove();
      response = JSON.parse(response);
      if(typeof response === 'object')
      {
        $('#reference_1').removeClass('hidden');
        $('#reference_bill_1_chosen').css('width','auto');
        $('#reference_bill_1').append('<option value="" id="cat_type">Select Bill or AMC</option>');
        $.each(response,function(type,res){
          $.each(res, function(key,value){
            if(type == 'Bill')
            {
            $('#reference_bill_1').append('<option value="'+value.ID+'">BILL - '+value.bill_number+'</option>');
            }
            else
            {
            $('#reference_bill_1').append('<option value="'+value.ID+'">AMC - '+value.amc_no+'</option>');
            }
          });
        });
        $("#reference_bill_1").trigger('chosen:updated');
      }
    }
  });
}

function get_product_details2()
{
  $('#model2').removeClass('hidden');
  $('#model2').html('<span class="col-sm-12 h3 font-bold text-center"><i class="fa fa-spinner fa-spin"></i></span>');
  var invoice_total = $('#reference_bill').val();
  var month_year = $('#datepicker').val();
  $.ajax({
    type:'POST',
    data :{'Name':invoice_total,'month_year':month_year},
    url: '<?php echo base_url(); ?>'+'dashboard/show_invoice_data2/'+invoice_total+'/'+month_year,
    success:function(response)
    {
      response = JSON.parse(response);
      $('#model2').html('');
      if(typeof response === 'object')
      {
        if(response.collection === null){
          response.collection = 0;
        }
        var balance = parseInt(response.grandtotal) - parseInt(response.collection);
        var percent = parseInt((parseInt(response.collection)/parseInt(response.grandtotal)) * 100);
        if(balance > 0)
        {
          status = "UNPAID";
          stat_class = "danger";
        }
        else
        {
          status = "PAID";
          stat_class = "success";
        }
        var data = '<p><div class="ibox-content col-sm-8 col-sm-offset-2"><h2 class="font-bold text-'+stat_class+'">'+status+'</h2><small><div class="stat-percent black-cl">'+percent+'% </small></div><div class="progress progress-small"><div style="width: '+percent+'%;" class="progress-bar progress-bar-'+stat_class+'"></div></div><ul class="todo-list m-t ui-sortable black-cl"> <li> <span class="m-l-xs">Total Amount : </span> <span class="m-l-xs"><i class="fa fa-inr"></i> '+parseInt(response.grandtotal)+'</span> </li>';
          data += '<li> <span class="m-l-xs">Paid Amount :</span> <span class="m-l-xs"><i class="fa fa-inr"></i> '+parseInt(response.collection)+'</span> </li><li> <span class="m-l-xs">Balance : </span> <span class="m-l-xs"><i class="fa fa-inr"></i> '+balance+'</span> </li>';
        data += '</ul></div><p>';
        $('#model2').append(data);
      }
      else{
        $('#model2').append('<p><div class="alert alert-danger">Something went wrong..<i class="fa fa-frown-o"></i></div><p>');
      }
    }
  });
}

  $(document).ready(function() {
   $('#A255ef9db8487b82a24f6031d1fd4e4fc').addClass('active');
            $("#A255ef9db8487b82a24f6031d1fd4e4fc").parent().parent().addClass("active");
            $("#A255ef9db8487b82a24f6031d1fd4e4fc").parent().addClass("in");
    $('.chosen-select').chosen();
    $.validator.setDefaults({ ignore: ":hidden:not(select)" });
    var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
    
    $('.datepicker').datepicker({
      format: js_date_format,
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true
    });
    
    $("#transaction_add").validate({
                 rules: {
                     transaction_type: {
                         required: true,
                     },
                     date: {
                         required: true,
                     },
                     amount: {
                         required: true,
                     },
                     description: {
                         required: true,
                     },
                     payment_mode_ID: {
                         required: true,
                     },
                     expence_category_ID: {
                         required: true,
                     }
                 }
             });

    $("#transaction_add").postAjaxData(function(result){
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
}); 

<?php
  if (isset($_SESSION['abc'])) { ?>
    $('#expense_cat').val("ECSK10000001");
    $('#expense_cat').trigger("chosen:updated");
     // $('#reference').removeClass('hidden');
    get_reference()
      $('#reference_bill').val("<?php echo $_SESSION['abc'];?>");
      $('#reference_bill').trigger("chosen:updated");
      get_reference_bill();
 <?php  }
 unset($_SESSION['abc']);
 ?>
</script>