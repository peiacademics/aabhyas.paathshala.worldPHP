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
                              <a class="btn btn-primary " href="<?php echo base_url('student/add/step1/'.$id.'');?>"><span class="hidden-xs">Guardian Details</span><span class="visible-xs">2.Guardian</span></a>
                            </li>
                            <li class="pad-rgt">
                              <a class="btn btn-primary active"><span class="hidden-xs">Admission Details</span><span class="visible-xs">3.Admission</span>
                             </a>
                             </li>
                            <li class="pad-rgt"><a <?php
                              if (!empty(@$DETAIL['fees']))
                              { ?>
                                href="<?php echo base_url('student/add/step3/'.$id.''); ?>"
                             <?php  }?> class="btn <?php
                                if (!empty(@$DETAIL['fees'])) { 
                                  echo "btn-primary";
                                }
                                else
                                {
                                  echo "btn-default";
                                }
                                ?>"><span class="hidden-xs">Fees & Receipt</span><span class="visible-xs">4.receipt</span></a></li>
                           </ul>
                          </div>
                          <div class="row"><br></div>
                          <div class="well">
                            <form id="form" action="<?php echo base_url('student/add/step2/'.$id.'');?>" class="wizard-big" method="post">
                            <div class="row">
                              <h2 class="col-sm-3">Admission Detail</h2>
                              <span class="text-danger text-right col-sm-offset-3 col-sm-6"><i>Mandatory fields marked by (*) mark !</i></span>
                            </div>
                            <div class="ibox-content">
                              <div class="row">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Year of Admission :</label>
                                    <div class="col-sm-9">
                                      <input type="number" class="form-control yearpicker" name="Year" placeholder="Year of admission" value="<?php echo @$DETAIL['admissionDetail']['Year']?>"required>
                                      <input type="hidden" name="ID" value="<?php echo @$DETAIL['admissionDetail']['ID']?>"required>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Batch :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="Batch" id="batch">
                                      </select>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Course :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="Course" id="course">
                                      </select>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Subject :</label>
                                    <div class="col-sm-9">
                                      <select multiple class="form-control chosen-select" name="Subject[]" id="subject" required>
                                      </select>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Package :</label>
                                    <div class="col-sm-9">
                                      <select multiple class="form-control chosen-select" name="package_ID[]" id="package_ID" required>
                                      </select>
                                    </div>
                                </div>
                              </div>
                               <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Mentor Faculty :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="Mentor" id="Mentor">
                                      </select>
                                    </div>
                                </div>
                              </div>
                               <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Admin :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="Admin" id="Admin">
                                      </select>
                                    </div>
                                </div>
                              </div>
                               <div class="row">
                                <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Student Welfare Cousellor 1 :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="Welfare1" id="Welfare1">
                                      </select>
                                    </div>
                                </div>
                              </div>
                               <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Student Welfare Cousellor 2 :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="Welfare2" id="Welfare2">
                                      </select>
                                    </div>
                                </div>
                              </div>
                               <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Branch Manager :</label>
                                    <div class="col-sm-9">
                                      <select class="form-control chosen-select" name="Branch_manager" id="Branch_manager">
                                      </select>
                                    </div>
                                </div>
                              </div>
                            </div>
<br>
                            <div class="ibox-content">
                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Basic Aim :</label>
                                    <div class="col-sm-9">
                                      <textarea type="text" class="form-control" name="Aim" placeholder="Basic aim or Expectations of parents"><?php echo @$DETAIL['admissionDetail']['Aim']?></textarea>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Timings :</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="Timings" placeholder="Timings" value="<?php echo @$DETAIL['admissionDetail']['Timings']?>">
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Current/Prev Coaching Class :</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="Coaching_class" placeholder="Current/Previous coaching class if any" value="<?php echo @$DETAIL['admissionDetail']['Coaching_class']?>">
                                    </div>
                                </div>
                              </div>
                               <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Reasons for which additional help is required? :</label>
                                    <div class="col-sm-9">
                                      <textarea class="form-control" name="Reason" placeholder="Type Reason..." ><?php echo @$DETAIL['admissionDetail']['Reason']?></textarea>
                                    </div>
                                </div>
                              </div>      
                            </div>
<br>
                            <div class="ibox-content">

                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Abhyas Login :</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="Login" placeholder="Roll no or Email address" value="<?php echo @$DETAIL['admissionDetail']['Login']?>">
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                              <br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Abhyas Password Student :</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="Student_pwd" placeholder="Student Password" value="<?php echo @$DETAIL['admissionDetail']['Student_pwd']?>">
                                    </div>
                                </div>
                              </div>
                              <div class="row"><br>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Abhyas Password Parent :</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="Parent_pwd" placeholder="Parent Password" value="<?php echo @$DETAIL['admissionDetail']['Parent_pwd']?>">
                                    </div>
                                </div>
                              </div>
                            </div>
<br>
                            <div class="ibox-content">
                              <?php if (empty(@$DETAIL['admissionDetail']['document_ID']) || (@$DETAIL['admissionDetail']['document_ID'] == ',')) { ?>
                            <div class="row">
                              <br>
                                <div class="col-sm-6">
                                  <div class="form-group" id="doc-div-1">
                                      <label for="" class="col-sm-6 control-label">Scanned copy of duly signed terms & conditions & admission form:</label>
                                      <div class="col-sm-5">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                          <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                                          <span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,'document_ID1')"/></span>
                                          <span class="fileinput-filename"></span>
                                          <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                        </div> 
                                      </div>
                                      <div class="col-sm-1">
                                        <button type="button" class="btn btn-white btn-bitbucket add_doc">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                      </div>
                                      <input type="hidden" id="row_count3" value="1">
                                      <input type="hidden" name="DC-document_ID-1" id="document_ID1" value="<?php echo @$DETAIL['doc'][0]['ID']; ?>">
                                  </div>
                                </div>
                              </div>
                              <?php }else{
                                $x=0;
                                foreach ($DETAIL['AdmissionDoc'] as $key => $value) { 
                                  ++$x; ?>
                              <div class="row">
                                <br>
                                  <div class="col-sm-6">
                                    <div class="form-group" id="doc-div-<?php echo $x; ?>">
                                        <label for="" class="col-sm-6 control-label">
                                         <?php if ($x===1) { ?>Scanned copy of duly signed terms & conditi admission form:
                                         <?php }?></label>
                                        <div class="col-sm-5">
                                          <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,'document_ID<?php echo $x; ?>')" /></span>
                                            <span class="fileinput-filename"><?php echo substr($value['path'], 19);; ?></span>
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                          </div> 
                                        </div>
                                        <div class="col-sm-1">
                                        <?php if ($x===1) { ?>
                                          <button type="button" class="btn btn-white btn-bitbucket add_doc">
                                              <i class="fa fa-plus"></i>
                                          </button>
                                          <?php }else{ ?>
                                          <button type="button" class="btn btn-danger btn-bitbucket" onclick="delete_doc('doc-div-<?php echo $x; ?>','<?php echo $x; ?>','<?php echo $value['ID']; ?>','<?php echo $DETAIL['studentDetail'][0]['ID']; ?>')">
                                              <i class="fa fa-trash"></i>
                                          </button>
                                        <?php } ?>
                                          
                                        </div>
                                        <input type="hidden" name="DC-document_ID-<?php echo $x; ?>" id="document_ID<?php echo $x; ?>" value="<?php echo  $value['ID']; ?>">
                                    </div>
                                  </div>
                                </div>
                                <?php }?>
                                <input type="hidden" id="row_count3" value="<?php echo  count(@$DETAIL['doc']); ?>">
                              <?php } ?>
                              <div id="add-doc">
                              </div>
                            </div>
                             
                          </div>

                          <div>

                            <div class="row col-sm-offset-8">

                            
                            <ul>
                              <li class="dsp-inln">
                                <a class="btn btn-primary" href="<?php echo base_url('student/add/step1/'.$id.''); ?>">Prev</a>
                              </li
            
                              <li class="dsp-inln">
                              <button class="btn btn-primary" >Next</button>
                              </li>
                            </ul>
                             
                          </div>

                          </div>

                           </form>

                        </div>

                    </div>

                    </div>

                </div>
<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<!-- Jasny -->
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<link href="<?php echo base_url('css/plugins/steps/jquery.steps.css'); ?>" rel="stylesheet">

<!-- Custom and plugin javascript -->

<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>

<!-- Jquery Validate -->

<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>


<!-- Date -->

<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>

<script>
$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
$('.add_doc').on('click',function(){
  var c = $("#row_count3").val();
  ++c;
  $('<div class="row"><div class="col-sm-6"><div class="form-group" id="doc-div-'+c+'"><label for="" class="col-sm-6 control-label"></label><div class="col-sm-5"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,\'document_ID'+c+'\')" required/></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a></div></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket add_doc" onclick="remove_doc(\'doc-div-'+c+'\');"><i class="fa fa-times"></i></button></div><input type="hidden" name="DC-document_ID-'+c+'" id="document_ID'+c+'" required></div></div></div>').appendTo('#add-doc');
  $("#row_count3").val(c);
});

  function remove_doc(phone_div,n)
  {
    if(n == 'yes')
    {
      var d = $("#num_row3").val();
      var k = --d;
      $("#num_row3").val(k);
    }
    else
    {
      var c = $("#row_count3").val();
      var j = --c;
      $("#row_count3").val(j);
    }
      $('#'+phone_div).remove();
  }

function delete_doc(prod_div,e,id,std) {
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Student/delete_File/'+id+'/'+std,
        success:function(response){
          if(response === true)
          {
            var d = $("#row_count3").val();
            var k = --d;
            $("#row_count3").val(k);
            $('#'+prod_div).remove();
            toastr.success('File deleted');
          }
          else
          {
            toastr.error('Something Went Wrong');
          }
        }
      });
      }
    });
}
var base_url="<?php echo base_url(); ?>"

id="<?php echo @$id; ?>";

$("#form").validate();



var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";

$('.datepicker').datepicker({
  format: js_date_format,
  keyboardNavigation: false,
  forceParse: false,
  autoclose: true
});



$('.yearpicker').datepicker({
  format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
});

function uploadFile(f,id) {
  toastr.options = {
              timeOut:0,
            };
            toastr.warning('<i class="fa fa-spinner fa-spin"></i> UPLOADING...',{timeOut: 0});
  var file_data = $(f).prop('files')[0]; 
        var form_data = new FormData();                  
        form_data.append('file', file_data);
      $.ajax({
        datatype:'text',
        data:form_data,
        type:'POST',
        cache: false,
        contentType: false,
        processData: false,
        url: '<?php echo base_url("student/upload_AnyFile");?>',
        success:function(response)
        {
          if (typeof response==='string')
          {
            $('#'+id).val(response);
            toastr.clear();
             toastr.options = {
              "closeButton": true,
                positionClass:'toast-bottom-right',
                showMethod: 'slideDown',
                "progressBar": true,
                tapToDismiss : true,
                timeOut: 5000
            };
            toastr.success('File Uploaded');
          }
          else
          {
            toastr.error("Something went wrong!");
          }
        }
      });
}

$("#form").postAjaxData(function(result){
if(result === 1)
  {
    window.location.href = "<?php echo base_url('Student/add/step3/"+id+"'); ?>"
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
    else if(typeof result === 'string')
    {
      window.location.href = "<?php echo base_url('Student/add/step3/"+result+"'); ?>"
    }
    else
    {
      toastr.error("Something went wrong!");
    }
  }
});



function getBoxes(count)
{
  var Quantity=$("#S-volume-"+count).val();
  var boxeSize =  $('#S-Box_Size-'+count).val();
  var Boxes=Quantity/boxeSize;
  // $("#S-Boxes-"+count).val(parseInt(Boxes));
  $("#S-Boxes-"+count).val(Boxes.toFixed(2));
  // calculate_total_amount(count);
  calculate_remaining();
}



function getQuantity(count)
{
  var boxes = $('#S-Boxes-'+count).val();
  var boxeSize =  $('#S-Box_Size-'+count).val();
  var Quantity=boxes*boxeSize;
  $("#S-volume-"+count).val(Quantity);
  // calculate_total_amount(count);
  calculate_remaining();
}



function calculate_remaining() {
  var sum = 0;
  var type=$('#remaining_Unit option:selected').attr('data-type');
  var toUnit=$('#remaining_Unit option:selected').val();
  $('.total').each(function(){
    Size=$(this).attr('data-size');
    fromUnit=$(this).attr('data-unit');
    mainSize=Size*this.value;
    // console.log(fromUnit+toUnit+mainSize+type);
      $.ajax({
      type:'POST',
      dataType:'json',
      url: '<?php echo base_url(); ?>'+'batching/getconverted/'+fromUnit+'/'+toUnit+'/'+mainSize+'/'+type,
      success:function(response)
      {
        if (typeof response==='number') {
          sum += parseFloat(response);
            var produced='<?php echo @$DETAIL["batchDetail"][0]["quantity_produced_Total"]; ?>';
          var remaining = produced-sum;
          var waste=$('#waste').val();
          if (waste !== undefined || waste !=='Nan' || waste !==null) {
            remaining=remaining-waste;
          }

          if (remaining < 0){
            toastr.error("Something went wrong!");
            $('.remaining').val();
          }
          else
          {
            $('#remaining').val(remaining);
          }
        }
      }
    });
      
  });
}

getChosenData('batch','BT',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Batch']?>');
getChosenData('course','CS',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Course']?>');
getChosenData('subject','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Subject']?>',true);
getChosenData('package_ID','APG',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['package_ID']?>',true);

getChosenData('Mentor','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Mentor']?>');
getChosenData('Admin','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Admin']?>');
getChosenData('Welfare1','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Welfare1']?>');
getChosenData('Welfare2','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Welfare2']?>');
getChosenData('Branch_manager','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['admissionDetail']['Branch_manager']?>');

    </script>