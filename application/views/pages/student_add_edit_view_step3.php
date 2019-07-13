<script type="text/javascript">
  function caldisabledtotl(config) {
    var sum = 0;
    $('#mydiv'+config).find('input[name^=IN-amount-][class*=paid]').each(function(){
        sum += parseInt($(this).val())
    });
    $('#mydiv'+config).find('input[name=total]').val(sum);
    ++config;
    $('#mydiv'+config).find('input[name^=IN-amount-1]').val(sum);
  }
</script>

<style type="text/css">
  
.flt-left{float: left;}

.pad-rgt{padding-right: 10px;
         display: inline;
         }

.mgr-left{margin-left: -22px}

.dsp-inln{display: inline;}

@media (max-width: 768px){

  .pad-rgt{
   display: inline;
    float: left;
    width: 33px;
    margin: 10px 30px 0px 20px;
  }

  .pad-rgt a{font-size: 10px;}

  .mgr-left{margin-left: -45px;}
}

</style>
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox">
              <div class="ibox-title">
                <h5>Student Add</h5>
                  <div class="ibox-tools">
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                      <i class="fa fa-times"></i>
                    </a>
                  </div>
              </div>
                <div class="ibox-content">
                  <div class="row">
                            <ul class="mgr-left">
                            <li class="pad-rgt">
                              <a class="btn btn-primary" href="<?php echo base_url('student/add/step/'.$id.'');?>"><span class="hidden-xs">Personal Details</span> <span class="visible-xs">1.Personal</span></a></li>
                          
                            <li class="pad-rgt">
                              <a class="btn btn-primary" href="<?php echo base_url('student/add/step1/'.$id.'');?>"><span class="hidden-xs">Guardian Details</span><span class="visible-xs">2.Guardian</span></a>
                            </li>
                            <li class="pad-rgt">
                              <a class="btn btn-primary" href="<?php echo base_url('student/add/step2/'.$id.'');?>"><span class="hidden-xs">Admission Details</span><span class="visible-xs">3.Admission</span>
                             </a>
                             </li>
                            <li class="pad-rgt"><a href="#" class="btn btn-primary active"><span class="hidden-xs">Fees & Receipt</span><span class="visible-xs">4.receipt</span></a></li>
                           </ul>
                          </div>
                  <div class="row"><br></div>
                    <div class="well">
                      <form id="form" action="<?php echo base_url('Student/add/step3/'.$id.'');?>" class="wizard-big" method="post">
                        <div class="row">
                          <h2 class="col-sm-3">Fees & Reciept</h2>
                          <span class="text-danger text-right col-sm-offset-3 col-sm-6"><i>Mandatory fields marked by (*) mark !</i></span>
                        </div>
                        <!-- <h2>Fees & Reciept</h2> -->
                        <!-- <div class="ibox-content"> -->
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <br>
                              <label class="col-sm-7 control-label"><span class="text-danger text-right"><i>*</i></span> Course Fees</label>
                              <div class="col-sm-5 input-group control-label">
                                <input type="number" class="form-control" name="Course_fees" id="Course_fees" onkeyup="calculatettlfees()" value="<?php echo (empty(@$DETAIL['fees']['Course_fees']) ? 0 :@$DETAIL['fees']['Course_fees'] );?>" placeholder="Course Fees" required>
                                <input type="hidden" name="ID" value="<?php echo @$DETAIL['fees']['ID'];?>">
                                <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                              </div>
                            </div>
                            <div class="col-sm-4">
                             <br>
                              <label class="col-sm-7 control-label">Pending Fees</label>
                                <div class="col-sm-5 input-group control-label">
                                  <input type="number" class="form-control" name="Pending_fees" placeholder="Pending Fees" value="<?php echo (empty(@$DETAIL['fees']['Pending_fees']) ? 0 :@$DETAIL['fees']['Pending_fees'] );?>" id="pending">
                                  <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                              <br>
                                <label class="col-sm-7 control-label">Over Due Fees</label>
                                <div class="col-sm-5 input-group control-label">
                                <input type="number" class="form-control" name="Over_due_fees" placeholder="Over Due Fees" value="<?php echo (empty(@$DETAIL['fees']['Over_due_fees']) ? 0 :@$DETAIL['fees']['Over_due_fees'] );?>">
                                <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                                </div>
                            </div>
                            </div>
                            <hr style="border-color: rgb(199, 199, 199)">

                            <div class="row form-group">
                            <div class="col-sm-4">
                              <br>
                              <label class="col-sm-7 control-label">Discount if Applicable</label>
                                <div class="col-sm-5 input-group control-label"><input type="number" class="form-control" name="discount" id="discount" onkeyup="calculatettlfees()" value="<?php echo (empty(@$DETAIL['fees']['discount']) ? 0 :@$DETAIL['fees']['discount'] );?>" placeholder="Discount">
                                <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                              <br>
                                <label class="col-sm-7 control-label">Type of Discount if Any</label>
                                <div class="col-sm-5">
                                <select class="form-control chosen-select" name="discount_type" id="discountType">
                                </select></div>
                            </div>
                            <div class="col-sm-4">
                              <br>
                                <label class="col-sm-7 control-label">Service Tax as Applicable</label>
                                <div class="col-sm-5 input-group control-label"><input type="number" value="<?php echo (empty(@$DETAIL['fees']['service_tax']) ? 0 :@$DETAIL['fees']['service_tax'] );?>" class="form-control" name="service_tax" id="service_tax" placeholder="Service Tax as Applicable" onkeyup="calculatettlfees()">
                                <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                                </div>
                            </div>
                          </div>
                          <hr style="border-color: rgb(199, 199, 199);">

                          <div class="row form-group">
                            <div class="col-sm-12">
                              <br>
                              <label class="col-sm-4 control-label">Referral Leads if Any</label>
                              <div class="col-sm-8">
                                <select class="form-control chosen-select" name="referral_lead" id="r_lead" >
                                </select>
                            </div>
                            </div>
                          </div>
                          <hr style="border-color: rgb(199, 199, 199);">
                           <div class="row form-group">
                            <div class="col-sm-12">
                              <br>
                                <label class="col-sm-7 control-label">Total Fees</label>
                                <div class="col-sm-5"><span class="form-control-static" id="ttlAmt"><?php echo (empty(@$DETAIL['fees']['total_fees']) ? 0 :@$DETAIL['fees']['total_fees'] );?> </span> <i class="fa fa-inr"></i><input type="hidden" name="total_fees" id="ttlAmtval" value="<?php echo (empty(@$DETAIL['fees']['total_fees']) ? 0 :@$DETAIL['fees']['total_fees'] );?>" readonly></div>
                            </div>
                          </div>
                          <hr style="border-color: rgb(199, 199, 199);">
                        <!-- </div> -->
<br>




<?php if (!empty(@$DETAIL['fees']['installments'])) {
  $y=0;
  foreach ($DETAIL['fees']['installments'] as $key => $value) {
    $y++;
    ?>
                        <h2 class="text-danger"><b>Configuration <?php echo $key; ?></b></h2>
                          <div class="ibox-content" id="mydiv<?php echo $key; ?>">
                            <div class="row">
                              <label class="col-sm-2 col-sm-offset-1 control-label">Installments</label>
                              <label class="col-sm-5 control-label text-center">Description</label>
                              <label class="col-sm-2 control-label">Date</label>
                              <label class="col-sm-2 control-label">Amount</label>
                              <label class="col-sm-1 control-label"></label>
                            </div>
          <?php 
            $x=0;
            foreach ($DETAIL['fees']['installments'][$key] as $k => $v) {
              $x++;
              if ($v['reconfig']>1 && $x===1) { ?>
              <br><div class="row"><div class="col-sm-1"><input type="hidden" name="IN-paid-1" value="false"><button type="button" class="btn btn-primary bbd b" disabled><i class="fa fa-check ffc ddd"></i></button></div><div class="col-sm-1">Installment<b>1</b></div><div class="col-sm-7 text-center"><div class="label label-primary col-sm-11 col-sm-offset-1"><h3 class="m-b-xs"><strong>Previous Payment</strong></h3></div></div><div class="col-sm-2"><input type="number" class="form-control paid" placeholder="Amount" name="IN-amount-1" value="" onKeyup="make_total(this)" id="prevPaid<?php echo $y; ?>" readonly></div></div>
                <?php 
                 $x++;
              }
              ?>
                            <br>
                            <div class="row" >
                              <div class="col-sm-1">
                              <input type="hidden" name="IN-paid-<?php echo $x; ?>" value="<?php echo (empty(@$v['isTransaction']) ? 'false' :'true' );?>">
                                <button type="button" class="btn <?php echo (empty(@$v['isTransaction']) ? 'btn-default' :'btn-primary' );?>  bbd b" onclick="payInstallment(this)" <?php echo (empty(@$v['isTransaction']) ? '' :'disabled' );?>><i class="fa fa-check ffc ddd"></i></button>
                              </div>

                              <div class="col-sm-1">
                                Installment<b><?php echo $x; ?></b>
                              </div>
                              <div class="col-sm-5">
                                <div class="<?php echo (empty(@$v['bank']) ? 'col-sm-12' : 'col-sm-6');?>" id="paymode<?php echo $x; ?>">
                                  <select class="form-control chosen-select" name="IN-paymentmode-<?php echo $x; ?>" id="paymentmode<?php echo $key.$x; ?>" onchange="get_bank('<?php echo $x; ?>','<?php echo $key; ?>')">
                                  </select>
                                  <script type="text/javascript">
                                     getChosenData('paymentmode<?php echo $key.$x; ?>','PM',[{'label':'title','value':'ID'}],[{'Status':'A'}],'<?php echo @$v['paymentmode'];?>');
                                  </script>
                                </div>
                                <div class="<?php echo (empty(@$v['bank']) ? '' : 'col-sm-6');?>" id="bankID<?php echo $x; ?>">
                                  <?php if (!empty(@$v['bank'])) { ?>

                                   <select class="form-control chosen-select" name="IN-bank-<?php echo $x; ?>" id="bank<?php echo $key.$x; ?>"></select>
                                   <script type="text/javascript">
                                      getChosenData('bank<?php echo $key.$x; ?>','BA',[{'label':'bank_name','value':'ID'}],[{'Status':'A'}],'<?php echo @$v['bank'];?>');
                                   </script>
                                  <?php } ?>
                                  
                                </div>

                                  <div class="col-sm-12">
                                    <br>
                                    <textarea class="form-control" placeholder="Description" name="IN-Description-<?php echo $x; ?>"><?php echo $v['Description']; ?></textarea>
                                  </div>
                              </div>
                              
                              <div class="col-sm-2">
                                <input type="text" class="form-control datepicker" name="IN-date-<?php echo $x; ?>" placeholder="Date" value="<?php echo $this->date_library->db2date(@$v['date'],$this->date_library->get_date_format());?>">
                              </div>
                              <div class="col-sm-2">
                                <input type="number" class="form-control <?php echo (empty(@$v['isTransaction']) ? '' :'paid' );?>" name="IN-amount-<?php echo $x; ?>" placeholder="Amount" value="<?php echo $v['amount']; ?>" <?php echo (empty(@$v['isTransaction']) ? ' onKeyup="make_total(this);"' :'onkeyup="calcamt();make_total(this);"' );?>>
                                <input type="hidden" name="IN-ID-<?php echo $x; ?>" value="<?php echo $v['ID']; ?>" >
                              </div>
                            </div>
                        <?php
                        } ?>
                            <br>
                            <div id="add-installments">
                              
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-sm-2 col-sm-offset-1">
                                <h3>Total Paid</h3>
                              </div>
                              <div class="col-sm-2 col-sm-offset-6">
                                <input type="number" class="form-control" name="total" placeholder="Total" value="<?php 
                                if (count(@$DETAIL['fees']['installments'])===$y) {
                                  echo @$DETAIL['fees']['total'];
                                }?>" id="paidAmt" readonly>

                                <!-- <?php 
                                if (count(@$DETAIL['fees']['installments'])!==$y) { ?>
                                  <script type="text/javascript">caldisabledtotl('<?php echo $y; ?>')</script>
                                <?php } ?> -->
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-left">
                                <button type="button" class="btn btn-outline btn-success <?php echo (@$DETAIL['fees']['Course_fees'] === @$DETAIL['fees']['total']) ? 'hidden' : '';?>" onclick="add_Installlments()"><i class="fa fa-plus"></i> Add</button>
                              </div>
                            </div>
                            <?php if ($v['reconfig']>1) {?>
                            <input type="hidden" id="row_countInstallments" value="<?php echo count(@$DETAIL['fees']['installments'][$key])+1;?>">
                            <?php }else{ ?>
                            <input type="hidden" id="row_countInstallments" value="<?php echo count(@$DETAIL['fees']['installments'][$key]);?>">
                            <?php } ?>
                          </div>

<?php 
if ((count(@$DETAIL['fees']['installments']))!==$y) { ?>
 <script type="text/javascript">
    $('#mydiv<?php echo $y;?>').find('input, textarea, button, select').attr('disabled','disabled').trigger("chosen:updated");
    $('#mydiv<?php echo $y;?>').find('input, textarea, button,div').removeAttr('id');
 </script>
<?php  
}
} 

$z=0;
foreach ($DETAIL['fees']['installments'] as $ks => $vs) {
  ++$z;
  if (count(@$DETAIL['fees']['installments'])!==$z) { ?>
      <script type="text/javascript">caldisabledtotl('<?php echo $z; ?>')</script>
<?php }
  }
}else{ ?>
                      <!-- <div class="ibox-content"> -->
                        <!-- <div class="well"> -->
                        <h2 class="text-danger"><b>Configuration 1</b></h2>
                          <div class="ibox-content" id="mydiv1">
                            <div class="row">
                              <label class="col-sm-2 col-sm-offset-1 control-label">Installments</label>
                              <label class="col-sm-5 control-label text-center">Description</label>
                              <label class="col-sm-2 control-label">Date</label>
                              <label class="col-sm-2 control-label">Amount</label>
                              <label class="col-sm-1 control-label"></label>
                            </div>
                            <br>
                            <div class="row" >
                              <div class="col-sm-1">
                              <input type="hidden" name="IN-paid-1" value="false">
                                <button type="button" class="btn btn-default bbd b" onclick="payInstallment(this)"><i class="fa fa-check ffc ddd"></i></button>
                              </div>
                              <div class="col-sm-1">
                                Installment<b>1</b>
                              </div>
                              <div class="col-sm-5">
                                <div class="col-sm-12" id="paymode1">
                                  <select class="form-control chosen-select" name="IN-paymentmode-1" id="paymentmode1" onchange="get_bank(1)">
                                  </select>
                                </div>
                                <div id="bankID1"></div>

                                  <div class="col-sm-12">
                                    <br>
                                    <textarea class="form-control" placeholder="Description" name="IN-Description-1"></textarea>
                                  </div>
                              </div>
                              
                              <div class="col-sm-2">
                                <input type="text" class="form-control datepicker" name="IN-date-1" placeholder="Date">
                              </div>
                              <div class="col-sm-2">
                                <input type="number" class="form-control" name="IN-amount-1" placeholder="Amount" onKeyup="make_total(this)">
                              </div>
                            </div>
                            <br>
                            <div id="add-installments">
                              
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-sm-2 col-sm-offset-1">
                                <h3>Total Paid</h3>
                              </div>
                              <div class="col-sm-2 col-sm-offset-6">
                                <input type="number" class="form-control" name="total" placeholder="Total" value="0" id="paidAmt" readonly>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-left">
                                <button type="button" class="btn btn-outline btn-success" onclick="add_Installlments()"><i class="fa fa-plus"></i> Add</button>
                              </div>
                            </div>
                            <input type="hidden" id="row_countInstallments" value="1">
                          </div>
                      <!-- </div> -->
                     
                    <!-- </div> -->
<?php } ?>
<div id="reconfigAdd">
</div>
<br>
 <div class="row">
  <div class="col-sm-12 text-right">
    <button type="button" class="btn btn-outline btn-danger add_Reconfiguration <?php echo (@$DETAIL['fees']['Course_fees'] === @$DETAIL['fees']['total']) ? 'hidden' : '';?>"><i class="fa fa-plus"></i> Add Reconfiguration</button>
  </div>
  <input type="hidden" id="recCount" value="<?php echo (empty(@$DETAIL['fees']['installments']) ? 1 :count($DETAIL['fees']['installments']) );?>" name="reconfig">
</div>


                      </div>
                          
                          <div class="row col-sm-offset-8">
                            <ul>
                              <li class="dsp-inln">
                                <a class="btn btn-primary" href="<?php echo base_url('student/add/step2/'.$id.'');?>">Prev</a>
                              </li>
                              <li class="dsp-inln">
                                <button class="btn btn-primary" id="finish" type="submit">Finish</button>
                              </li>
                            </ul>
                          </div>
                          </form>
                        </div>
            </div>
          </div>
        </div>

<link href="<?php echo base_url('css/plugins/steps/jquery.steps.css'); ?>" rel="stylesheet">
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Date -->
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script>
$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
var base_url="<?php echo base_url(); ?>"
id="<?php echo @$id; ?>";
$("#form").validate();
/*$("#form").submit(function() {
  $(d).parent().parent().find('select[name^=IN-paymentmode]').attr('disabled','disabled').trigger("chosen:updated");
  $(d).parent().parent().find('select[name^=IN-bank]').attr('disabled','disabled').trigger("chosen:updated");
});*/
var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
$('.datepicker').datepicker({
  format: js_date_format,
  keyboardNavigation: false,
  forceParse: false,
  autoclose: true
});

$("#form").postAjaxData(function(result){
  if(result === 1){
    var id = '<?php echo $this->db_library->find_max_id("ST"); ?>';
    toastr.success('Successfully Added');
    setTimeout(function(){
      window.location.href = "<?php echo base_url('student/view/'); ?>"+'/'+id;
    }, 2000);
  }
  else
  {
    if(typeof result === 'object'){
      mess = "";
      $.each(result,function(dom,err){
        mess = mess+err+"\n";
        toastr.error(mess);
      });
    }
    else{
      toastr.error("Something went wrong!");
    }
  }
});


// $('.add_Reconfiguration').on('click',function(){
//   bootbox.confirm('Are you sure you want to Add new Configuration?', function(result) {
//     if (result===true) {
//       var recCount=$('#recCount').val();
//       $('#mydiv'+recCount).find('input, textarea, button, select').attr('disabled','disabled').trigger("chosen:updated");
//       $('#mydiv'+recCount).find('input, textarea, button, select,div').removeAttr('id');
//       ++recCount;
//       $('<br><h2 class="text-danger"><b>Configuration '+recCount+'</b></h2><div class="ibox-content" id="mydiv'+recCount+'"><div class="row"><label class="col-sm-2 col-sm-offset-1 control-label">Installments</label><label class="col-sm-5 control-label text-center">Description</label><label class="col-sm-2 control-label">Date</label><label class="col-sm-2 control-label">Amount</label><label class="col-sm-1 control-label"></label></div><br><div class="row"><div class="col-sm-1"><input type="hidden" name="IN-paid-1" value="false"><button type="button" class="btn btn-default bbd b" onclick="payInstallment(this)"><i class="fa fa-check ffc ddd"></i></button></div><div class="col-sm-1">Installment<b>1</b></div><div class="col-sm-5"><div class="col-sm-12" id="paymode1"><select class="form-control chosen-select" name="IN-paymentmode-1" id="paymentmode1" onchange="get_bank(1)" ></select></div><div id="bankID1"></div><div class="col-sm-12"><br><textarea class="form-control" placeholder="Description" name="IN-Description-1"></textarea></div></div><div class="col-sm-2"><input type="text" class="form-control datepicker" name="IN-date-1" placeholder="Date"></div><div class="col-sm-2"><input type="text" class="form-control" name="IN-amount-1" placeholder="Amount"></div></div><br><div id="add-installments"></div><br><div class="row"><div class="col-sm-2 col-sm-offset-1"><h3>Total Paid</h3></div><div class="col-sm-2 col-sm-offset-6"><input type="number" class="form-control" name="total" id="paidAmt" placeholder="Total" required></div></div><div class="row"><div class="col-sm-5 text-left"><button type="button" class="btn btn-outline btn-success " onclick="add_Installlments()"><i class="fa fa-plus"></i> Add</button></div></div><input type="hidden" id="row_countInstallments" value="1"></div>').appendTo('#reconfigAdd');
//       $("#recCount").val(recCount);
//       getChosenData('paymentmode1','PM',[{'label':'title','value':'ID'}],[{'Status':'A'}]);
//       $('.datepicker').datepicker({
//         format: js_date_format,
//         keyboardNavigation: false,
//         forceParse: false,
//         autoclose: true
//       });
//     }
//   });
// });

$('.add_Reconfiguration').on('click',function(){
  bootbox.confirm('Are you sure you want to Add new Configuration?', function(result) {
    if (result === true) {
      var recCount = $('#recCount').val();
      var paidAmt = $("#paidAmt").val();
      $('#mydiv'+recCount).find('input, textarea, button, select').attr('disabled','disabled').trigger("chosen:updated");
      $('#mydiv'+recCount).find('input, textarea, button, select,div').removeAttr('id');
      ++recCount;
      $('<br><h2 class="text-danger"><b>Configuration '+recCount+'</b></h2><div class="ibox-content" id="mydiv'+recCount+'"><div class="row"><label class="col-sm-2 col-sm-offset-1 control-label">Installments</label><label class="col-sm-5 control-label text-center">Description</label><label class="col-sm-2 control-label">Date</label><label class="col-sm-2 control-label">Amount</label><label class="col-sm-1 control-label"></label></div><br><div class="row"><div class="col-sm-1"><input type="hidden" name="IN-paid-1" value="false"><button type="button" class="btn btn-primary bbd b" disabled><i class="fa fa-check ffc ddd"></i></button></div><div class="col-sm-1">Installment<b>1</b></div><div class="col-sm-7 text-center"><div class="label label-primary col-sm-11 col-sm-offset-1"><h3 class="m-b-xs"><strong>Previous Payment</strong></h3></div></div><div class="col-sm-2"><input type="number" class="form-control paid" placeholder="Amount" name="IN-amount-1" value="'+paidAmt+'" readonly></div></div><br><div id="add-installments"></div><br><div class="row"><div class="col-sm-2 col-sm-offset-1"><h3>Total Paid</h3></div><div class="col-sm-2 col-sm-offset-6"><input type="number" class="form-control" name="total" id="paidAmt" placeholder="Total"  value="'+paidAmt+'" required readonly></div></div><div class="row"><div class="col-sm-5 text-left"><button type="button" class="btn btn-outline btn-success" onclick="add_Installlments()"><i class="fa fa-plus"></i> Add</button></div></div><input type="hidden" id="row_countInstallments" value="1"></div>').appendTo('#reconfigAdd');
      // value="'+paidAmt+'"
      $("#recCount").val(recCount);
      //$('#finish').attr('disabled',true);
      calpendAmt(paidAmt)
      getChosenData('paymentmode1','PM',[{'label':'title','value':'ID'}],[{'Status':'A'}]);
      $('.datepicker').datepicker({
        format: js_date_format,
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
      });
    }
  });
});

function add_Installlments() {
  var c = $("#row_countInstallments").val();
  ++c;
  $('<div class="form-group" id="phone-div-'+c+'"><br><div class="row"><div class="col-sm-1"><input type="hidden" name="IN-paid-'+c+'" value="false"><button type="button" class="btn btn-default bbd b" onclick="payInstallment(this)"><i class="fa fa-check ffc ddd"></i></button></div><div class="col-sm-1">Installment<b>'+c+'</b></div><div class="col-sm-5"><div class="col-sm-12" id="paymode'+c+'"><select class="form-control chosen-select" name="IN-paymentmode-'+c+'" id="paymentmode'+c+'" onchange="get_bank('+c+')" required></select></div><div id="bankID'+c+'"></div><div class="col-sm-12"><br><textarea class="form-control" placeholder="Description" name="IN-Description-'+c+'"></textarea></div></div><div class="col-sm-2"><input type="text" class="form-control datepicker" name="IN-date-'+c+'" placeholder="Date"></div><div class="col-sm-2"><input type="number" class="form-control" name="IN-amount-'+c+'" placeholder="Amount" onKeyup="make_total(this)"></div><div><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div></div></div>').appendTo('#add-installments');
  $("#row_countInstallments").val(c);
  // added
  getChosenData('paymentmode'+c,'PM',[{'label':'title','value':'ID'}],[{'Status':'A'}],'<?php //echo @$DETAIL['prevDetail']['Board']?>');
  $('.datepicker').datepicker({
    format: js_date_format,
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true
  });
  // added
}

getChosenData('discountType','DT',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['fees']['discount_type'];?>');
getChosenData('r_lead','ST',[{'label':'Name','value':'ID'}],[{'Status':'A','admStatus':'Active'}],'<?php echo @$DETAIL['fees']['referral_lead'];?>');
getChosenData('paymentmode1','PM',[{'label':'title','value':'ID'}],[{'Status':'A'}]);

function calculatettlfees() {
  var Course_fees=$('#Course_fees').val();
  var discount=$('#discount').val();
  var service_tax=$('#service_tax').val();
  ttlminusAmt=parseFloat(discount)+parseFloat(service_tax);
  var ttl=parseFloat(Course_fees)-ttlminusAmt;
  $('#ttlAmt').text(ttl);
  $('#ttlAmtval').val(ttl);
}

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
      var c = $("#row_countInstallments").val();
      var j = --c;
      $("#row_countInstallments").val(j);
    }
      $('#'+phone_div).remove();
  }

function get_bank(c,k)
{
  var pay_mode = $('#paymentmode'+c).val();
  if (pay_mode===undefined) {
    pay_mode=$('#paymentmode'+k+c).val();
  }
  if(pay_mode !== 'PMSK10000001' && pay_mode !== '')
  {
    $('#paymode'+c).removeClass('col-sm-12').addClass('col-sm-6');
    $('#bankID'+c).addClass('col-sm-6');
    $('#bankID'+c).html('<select class="form-control chosen-select" name="IN-bank-'+c+'" id="bank'+c+'" required></select>');
    getChosenData('bank'+c,'BA',[{'label':'bank_name','value':'ID'}],[{'Status':'A'}]);
  }
  else
  {
    $('#bankID'+c).html('');
    $('#bankID'+c).removeClass('col-sm-6');
    $('#paymode'+c).removeClass('col-sm-6').addClass('col-sm-12');
    // $('#bank_dropdown').addClass('hidden');
  }
}


function payInstallment(d) {
    toastr.options = {
      "closeButton": true,
        positionClass:'toast-bottom-right',
        showMethod: 'slideDown',
        "progressBar": true,
        tapToDismiss : true,
        timeOut: 5000
    };
    var date=$(d).parent().parent().find('input[name^=IN-date]').val();
    var amt=$(d).parent().parent().find('input[name^=IN-amount]').val();
    var desc=$(d).parent().parent().find('textarea[name^=IN-Description]').val();
    var paymode=$(d).parent().parent().find('select[name^=IN-paymentmode]').val();
    var bank=$(d).parent().parent().find('select[name^=IN-bank]').val();
    if ($('#ttlAmtval').val()==="0" || $('#ttlAmtval').val()===undefined || $('#ttlAmtval').val()===null) {
        $('#Course_fees').focus();
        toastr.error('Please Insert Total Fees First');
    }
    else if (date===''||date===undefined||date===null) {
      toastr.error('Please fill date of this Installment');
    }
    else if (amt===''||amt===undefined||amt===null) {
      toastr.error('Please fill Amount of this Installment');
    }
    else if (desc===''||desc===undefined||desc===null) {
      toastr.error('Please fill Description of this Installment');
    }
    else if (paymode===''||paymode===undefined||paymode===null) {
      toastr.error('Please select Payment mode for this Installment');
    }
    else if (paymode!=='PMSK10000001') {
      if (bank===''||bank===undefined||bank===null) {
        toastr.error('Please select Bank for this Installment');
      }
      else
      {
        bootbox.confirm('<b>Paid this Installment?</b><p><small>Once you paid this Installment you are not able to change it..<small></p>', function(result) {
          addPayment(d,date,amt,desc,paymode,bank);
          $(d).parent().parent().find('input[name^=IN-date]').attr('readonly',true);
          $(d).parent().parent().find('input[name^=IN-amount]').attr('readonly',true);
          $(d).parent().parent().find('textarea[name^=IN-Description]').attr('readonly',true);
          $(d).parent().parent().find('input[name^=IN-date]').removeClass('datepicker');
        });
      }
    }
    else
    {
      bootbox.confirm('<b>Paid this Installment?</b><p><small>Once you paid this Installment you are not able to change it..<small></p>', function(result) {
          addPayment(d,date,amt,desc,paymode,bank);
          $(d).parent().parent().find('input[name^=IN-date]').attr('readonly',true);
          $(d).parent().parent().find('input[name^=IN-amount]').attr('readonly',true);
          $(d).parent().parent().find('textarea[name^=IN-Description]').attr('readonly',true);
          $(d).parent().parent().find('input[name^=IN-date]').removeClass('datepicker');
        });
    }
}

function addPayment(d,date,amt,desc,paymode,bank) {
   var feesID="<?php echo @$DETAIL['fees']['ID'];?>";
  if (feesID===undefined||feesID===""||feesID===null) {
      $(d).parent().find('input[name^=IN-paid]').val(true);
      $(d).parent().find('input[name^=IN-amount]').addClass('paid');
      $(d).removeClass('btn-default').addClass('btn-primary').attr('disabled',true);
      calcPaidAmt(d,amt);
      toastr.success('transaction will completed after finish the step');
  }
  else
  {
      $(d).parent().find('input[name^=IN-paid]').val(true);
      $(d).parent().find('input[name^=IN-amount]').addClass('paid');
      $(d).removeClass('btn-default').addClass('btn-primary').attr('disabled',true);
      calcPaidAmt(d,amt);
      toastr.success('transaction will completed after finish the step');

    // reconfig=$("#recCount").val();
    // var id="<?php echo @$id; ?>";
    // toastr.success('enters in function');
    //   $.ajax({
    //   type:'POST',
    //   dataType:'json',
    //   data:{'date':date,'amount':amt,'paymentmode':paymode,'Description':desc,'bank':bank,'reconfig':reconfig,'Student_ID':id,'feesID':feesID},
    //   url: '<?php echo base_url(); ?>'+'student/addInstallments',
    //   success:function(response)
    //   {
    //     console.log(response);
    
    //   }
    // });
  }
}

function calcPaidAmt(d,amt) {
  var ttlamt=parseFloat($("#paidAmt").val())+parseFloat(amt);
  $("#paidAmt").val(ttlamt);
  calpendAmt(ttlamt);
}
// calcamt();
function calcamt(){
  var sum = 0;
    $('input[name^=IN-amount][class*=paid]').not('input[disabled]').each(function(){
        sum += parseInt($(this).val())
    });
    $("#paidAmt").val(sum);
    calpendAmt(sum);
}

function calpendAmt(amt) {
  var pending=parseFloat($('#ttlAmtval').val())-amt;
  $('#pending').val(pending);
}

function make_total(d)
{
  //var course_fees = parseFloat($('input[name="Course_fees"]').val());
  var course_fees = parseFloat($('#ttlAmt').text());
  var recCount = $('#recCount').val();
  var c = $('#mydiv'+recCount).find("#row_countInstallments").val();
  var amt = 0;
  var i;
  for(i=1; i<=c; i++)
  {
    amt = parseFloat(amt) + parseFloat($('#mydiv'+recCount).find('input[name="IN-amount-'+i+'"]').val());
  }
  /*if(course_fees == amt && amt != 0)
  {
    $('#finish').attr('disabled',false);
  }
  else
  {
    $('#finish').attr('disabled',true);
  }*/
}
</script>


