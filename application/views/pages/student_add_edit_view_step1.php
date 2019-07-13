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
                              <li class="pad-rgt"><a class="btn btn-primary text-left" href="<?php echo base_url('Student/add/step/'.$id.'');?>"><span class="hidden-xs">Personal Details</span> <span class="visible-xs">1.Personal</span></a></li>
                            <li class="pad-rgt">
                              <a class="btn btn-primary text-left active"><span class="hidden-xs">Guardian Details</span><span class="visible-xs">2.Guardian</span></a>
                            </li>
                            <li class="pad-rgt"> 
                              <a class="btn <?php
                              if (!empty(@$DETAIL['admissionDetail'])) { 
                                echo "btn-primary";
                              }
                              else
                              {
                                echo "btn-default";
                              }
                              ?>"
                              <?php
                              if (!empty(@$DETAIL['admissionDetail']))
                              { ?>
                                href="<?php echo base_url('student/add/step2/'.$id.''); ?>"
                             <?php  }?>><span class="hidden-xs">Admission Details</span><span class="visible-xs">3.Admission</span>
                             </a>
                             </li>
                            <li class="pad-rgt"><a class="btn <?php
                                if (!empty(@$DETAIL['fees'])) { 
                                  echo "btn-primary";
                                }
                                else
                                {
                                  echo "btn-default";
                                }
                                ?>" <?php
                              if (!empty(@$DETAIL['fees']))
                              { ?>
                                href="<?php echo base_url('student/add/step3/'.$id.''); ?>"
                             <?php  }?>><span class="hidden-xs">Fees & Receipt</span><span class="visible-xs">4.receipt</span></a></li>
                           </ul> 
                          </div>
                          <div class="row"><br></div>
                          <div class="well">
                            <?php //echo $id;?>
                            <form id="form" action="<?php echo base_url('student/add/step1/'.$id.'');?>" class="wizard-big" method="post">
                            <div class="row">
                              <h2 class="col-sm-2">Parents Info</h2>
                              <span class="text-danger text-right col-sm-offset-4 col-sm-6"><i>Mandatory fields marked by (*) mark !</i></span>
                            </div>
                                <!-- <fieldset> -->
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="ibox">
                                        <div class="ibox-title">
                                            <h1>Father/Guardian1</h1>
                                        </div>
                                        <div class="ibox-content">
                                          <div class="row">
                                            <div class="form-group">
                                              <label for="Name" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Name :</label>
                                              <div class="col-sm-9">
                                                <input type="text" class="form-control" name="GD-Name-1" placeholder="Name" value="<?php echo @$DETAIL['parentDetail'][0]['Name']?>" required>
                                                <input type="hidden" class="form-control" name="GD-ID-1" placeholder="Name" value="<?php echo @$DETAIL['parentDetail'][0]['ID']?>">
                                              </div>
                                              <span id="Name"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Relation" class="col-sm-3 control-label">Relation :</label>
                                              <div class="col-sm-9">
                                                <input type="text" class="form-control" name="GD-Relation-1" placeholder="Relation" value="<?php echo @$DETAIL['parentDetail'][0]['Relation']?>">
                                              </div>
                                              <span id="Relation"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Relation" class="col-sm-3 control-label">Address :</label>
                                              <div class="col-sm-9">
                                              <?php
                                              if(@$DETAIL['List']['Address'] != NULL) {
                                              if (empty(@$DETAIL['parentDetail'][0]['Address'])) { ?>
                                              <div id="btns">
                                                <a class="btn btn-primary btn-rounded" onclick="newAddress('1')">New</a>
                                                 <a class="btn btn-warning btn-rounded" onclick="oldAddress('1')">Same As Student</a>
                                              </div>
                                               <?php } } ?>
                                             <div id="tarea" <?php echo (empty(@$DETAIL['parentDetail'][0]['Address']) && (@$DETAIL['List']['Address'] != NULL)) ? 'hidden' : ''; ?>>
                                               <textarea class="form-control" id="adress1" name="GD-Address-1" placeholder="Address"><?php echo @$DETAIL['parentDetail'][0]['Address']?></textarea>
                                             </div>
                                                
                                              </div>
                                              <span id="Relation"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Email" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Email :</label>
                                              <div class="col-sm-9">
                                                <input type="email" class="form-control" name="GD-Email-1" placeholder="Email" value="<?php echo @$DETAIL['parentDetail'][0]['Email']?>" required>
                                              </div>
                                              <span id="Email"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br> 
                                             <div class="form-group">
                                              <label for="Contact" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Contact :</label>
                                               <div class="col-sm-3">
                                                  <select class="form-control" name="PH-phone_type-1" >
                                                    <option value="Work" <?php echo (@$DETAIL['parentDetail'][0]['phone_type']==="Work")? 'selected' : ''; ?>>Work</option>
                                                    <option value="Home" <?php echo (@$DETAIL['parentDetail'][0]['phone_type']==="Home")? 'selected' : ''; ?>>Home</option>
                                                    <option value="Mobile" <?php echo (@$DETAIL['parentDetail'][0]['phone_type']==="Mobile")? 'selected' : ''; ?>>Mobile</option>
                                                    <option value="Personal" <?php echo (@$DETAIL['parentDetail'][0]['phone_type']==="Personal")? 'selected' : ''; ?>>Personal</option>
                                                  </select>
                                                </div>
                                                <div class="col-sm-6">
                                                  <input type="number" class="form-control" name="PH-phone_number-1" placeholder="Phone no." value="<?php echo @$DETAIL['parentDetail'][0]['phone_number']?>"  min="100000" minlength="6" maxlength="12" required>
                                                  <input type="hidden" class="form-control" name="PH-phnID-1" placeholder="Name" value="<?php echo @$DETAIL['parentDetail'][0]['phnID']?>">
                                                </div>
                                              <span id="phone_no_ID"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Occupation" class="col-sm-3 control-label"> Occupation :</label>
                                              <div class="col-sm-9">
                                                <input type="text" class="form-control" name="GD-Occupation-1" placeholder="Occupation" value="<?php echo @$DETAIL['parentDetail'][0]['Occupation']?>">
                                              </div>
                                              <span id="Occupation"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Income" class="col-sm-3 control-label">Income :</label>
                                              <div class="col-sm-9">
                                                <input type="number" class="form-control" name="GD-Income-1" placeholder="Income" value="<?php echo @$DETAIL['parentDetail'][0]['Income']?>">
                                              </div>
                                              <span id="Income"></span>
                                            </div>
                                          </div>
                                        </div>  
                                      </div>  
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="ibox">
                                        <div class="ibox-title">
                                            <h1>Mother/Guardian2</h1>
                                        </div>
                                        <div class="ibox-content">
                                          <div class="row">
                                            <div class="form-group">
                                              <label for="Name" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Name :</label>
                                              <div class="col-sm-9">
                                                <input type="text" class="form-control" name="GD-Name-2" placeholder="Name" value="<?php echo @$DETAIL['parentDetail'][1]['Name']?>" required>
                                                <input type="hidden" class="form-control" name="GD-ID-2" placeholder="Name" value="<?php echo @$DETAIL['parentDetail'][1]['ID']?>">
                                              </div>
                                              <span id="Name"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Relation" class="col-sm-3 control-label">Relation :</label>
                                              <div class="col-sm-9">
                                                <input type="text" class="form-control" name="GD-Relation-2" placeholder="Relation" value="<?php echo @$DETAIL['parentDetail'][1]['Relation']?>">
                                              </div>
                                              <span id="Relation"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Relation" class="col-sm-3 control-label">Address :</label>
                                              <div class="col-sm-9">
                                              <?php if(@$DETAIL['List']['Address'] != NULL) {
                                              if (empty(@$DETAIL['parentDetail'][1]['Address'])) { ?>
                                              <div id="btns1">
                                                <a class="btn btn-primary btn-rounded" onclick="newAddress('2')">New</a>
                                                 <a class="btn btn-warning btn-rounded" onclick="oldAddress('2')">Same As Student</a>
                                              </div>
                                              <?php } } ?>
                                             <div <?php echo (empty(@$DETAIL['parentDetail'][1]['Address']) && (@$DETAIL['List']['Address'] != NULL)) ? 'hidden' : ''; ?> id="tarea1">
                                               <textarea class="form-control" id="adress2" name="GD-Address-2" placeholder="Address"><?php echo @$DETAIL['parentDetail'][1]['Address']?></textarea>
                                             </div>
                                                
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Email" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Email :</label>
                                              <div class="col-sm-9">
                                                <input type="email" class="form-control" name="GD-Email-2" placeholder="Email" value="<?php echo @$DETAIL['parentDetail'][1]['Email']?>" required>
                                              </div>
                                              <span id="Email"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                             <div class="form-group">
                                              <label for="Contact" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> Contact :</label>
                                               <div class="col-sm-3">
                                                  <select class="form-control" name="PH-phone_type-2" >
                                                    <option value="Work" <?php echo (@$DETAIL['parentDetail'][1]['phone_type']==="Work")? 'selected' : ''; ?>>Work</option>
                                                    <option value="Home" <?php echo (@$DETAIL['parentDetail'][1]['phone_type']==="Home")? 'selected' : ''; ?>>Home</option>
                                                    <option value="Mobile" <?php echo (@$DETAIL['parentDetail'][1]['phone_type']==="Mobile")? 'selected' : ''; ?>>Mobile</option>
                                                    <option value="Personal" <?php echo (@$DETAIL['parentDetail'][1]['phone_type']==="Personal")? 'selected' : ''; ?>>Personal</option>
                                                  </select>
                                                </div>
                                                <div class="col-sm-6">
                                                  <input type="number" class="form-control" name="PH-phone_number-2" placeholder="Phone no." value="<?php echo @$DETAIL['parentDetail'][1]['phone_number']?>"  min="100000" minlength="6" maxlength="12" required>
                                                  <input type="hidden" class="form-control" name="PH-phnID-2" placeholder="Name" value="<?php echo @$DETAIL['parentDetail'][1]['phnID']?>">
                                                </div>
                                              <span id="phone_no_ID"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Occupation" class="col-sm-3 control-label"> Occupation :</label>
                                              <div class="col-sm-9">
                                                <input type="text" class="form-control" name="GD-Occupation-2" placeholder="Occupation" value="<?php echo @$DETAIL['parentDetail'][1]['Occupation']?>">
                                              </div>
                                              <span id="Occupation"></span>
                                            </div>
                                          </div>

                                          <div class="row">
                                          <br>
                                            <div class="form-group">
                                              <label for="Income" class="col-sm-3 control-label">Income :</label>
                                              <div class="col-sm-9">
                                                <input type="number" class="form-control" name="GD-Income-2" placeholder="Income" value="<?php echo @$DETAIL['parentDetail'][1]['Income']?>">
                                              </div>
                                              <span id="Income"></span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>    
                                    </div>
                                  </div>

                          </div>
                          <div>

                            <div class="row col-sm-offset-8">
                            <ul>
                              <li class="dsp-inln">
                                <a class="btn btn-primary" href="<?php echo base_url('Student/add/step/'.$id.'');?>">Prev</a>
                                </li>

                              <li class="dsp-inln">
                                <button class="btn btn-primary">Next</button>
                              </li>

                            </div>

                          <!-- </div> -->

                           </form>

                          </div>

                        </div>

                    </div>

                    </div>

                </div>

<?php //print_r($DETAIL); ?>



<!-- Address Modal -->
<div class="modal inmodal" id="AddressModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-map-marker modal-icon"></i>
              <h4 class="modal-title">Address Book</h4>
          </div>
          <div class="modal-body">

          <?php if (!empty(@$DETAIL['List']['Address'])) {
            foreach (@$DETAIL['List']['Address'] as $key => $value) { ?>

            <button type="button" class="btn btn-lg btn-block btn-white" onclick="placeAddress('<?php echo $value["address"];?>')"><?php echo wordwrap($value['address'],15,"<br>\n");?></button>

              <?php //echo $value['address'];?>
         <?php   }
          }?>
          </div>
          <input type="hidden" id="counter">
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

 <link href="<?php echo base_url('css/plugins/steps/jquery.steps.css'); ?>" rel="stylesheet">

<!-- Custom and plugin javascript -->

<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>

<!-- Jquery Validate -->

<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<!-- SUMMERNOTE -->

<script type="text/javascript" language="javascript" src="<?php echo base_url('js/plugins/summernote/summernote.min.js')?>"></script>

<!-- Date -->

<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>

<script>
function placeAddress(d) {
  if ($('#counter').val()==='1') {
    $('#btns').hide();
    $('#AddressModal').modal('hide');
    $('#adress1').val(d);
    $('#tarea').show();
  }
  else
  {
    $('#btns1').hide();
    $('#AddressModal').modal('hide');
    $('#adress2').val(d);
    $('#tarea1').show();
  }
  
}

function oldAddress(count) {
  $('#counter').val(count);
  $('#AddressModal').modal('show');
}

function newAddress(count) {
  if (count==='1') {
    $('#btns').hide();
    $('#tarea').show();
  }
  else
  {
    $('#btns1').hide();
    $('#tarea1').show();
  }
  
}

$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });

var base_url="<?php echo base_url(); ?>";

id="<?php echo @$id; ?>";



  var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";

$('.datepicker').datepicker({

  format: js_date_format,

  keyboardNavigation: false,

  forceParse: false,

  autoclose: true

});

$("#form").validate();

$("#form").postAjaxData(function(result){

  if(result === 1){

     window.location.href = "<?php echo base_url('student/add/step2/"+id+"'); ?>";

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

    else 

    {

      window.location.href = "<?php echo current_url(); ?>"

    }

  }

});


    </script>