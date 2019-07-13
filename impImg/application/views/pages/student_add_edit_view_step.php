<style type="text/css">
  
.flt-left{float: left;}

.pad-rgt{padding-right: 10px;
         display: inline;
         }

.mgr-left{margin-left: -22px}

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
      <!--     <div class="col-sm-2"> -->
           <li class="pad-rgt"><a class="btn btn-primary active text-left">
          <span class="hidden-xs">Personal Details</span> <span class="visible-xs">1.Personal</span></a></li>
         <!--  </div> -->
          <!-- <div class="col-sm-2"> -->
            <li class="pad-rgt"><a class="btn <?php
            if (!empty(@$DETAIL['parentDetail'])) { 
              echo "btn-primary";
            }
            else
            {
              echo "btn-default";
            }
            ?>"
            <?php
            if (!empty(@$DETAIL['parentDetail']))
            { ?>
              href="<?php echo base_url('student/add/step1/'.$id.''); ?>"
           <?php  }?>
            ><span class="hidden-xs">Guardian Details</span> <span class="visible-xs">2.Guardian</span></a></li>
        <!--   </div> -->
          <!-- <div class="col-sm-2"> -->
            <li class="pad-rgt"><a class="btn <?php
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
           <?php  }?>><span class="hidden-xs">Admission Details</span><span class="visible-xs">3.Admission</span></a>
          <!-- </div> --></li>
          <!-- <div class="col-sm-2"> -->
          <li class="pad-rgt"><a  class="btn <?php
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
                             <?php  }?> ><span class="hidden-xs">Fees & Receipt</span><span class="visible-xs">4.receipt</span></a></li>
          <!-- </div> -->
          </ul>
        </div>
      <br>
        <div class="well">
          <form id="form" action="<?php echo base_url('Student/add/step/'.@$id.''); ?>" class="wizard-big" method="post">
              <h2>Student Info</h2>
              <div class="row text-center">
                <div class="col-sm-4">
                <div class="row  text-left">
                  <div class="col-sm-offset-1">
                  <?php
                    if (!empty($DETAIL['studentDetail'][0]['img_ID'])) 
                    {
                      $img_path = $this->str_function_library->call('fr>SS>path:ID=`'.$DETAIL['studentDetail'][0]['img_ID'].'`'); 
                    }
                    else
                    {
                      $img_path = 'img/user.jpg';
                    }
                   ?>
                    <img alt="image" width="300" id="pImg" class="img-circle1 img-responsive" src="<?php echo base_url($img_path);?>">
                     <input type="hidden" id="imgID" name="img_ID" value="<?php echo (@$DETAIL['studentDetail'][0]['img_ID'] != NULL) ? $DETAIL['studentDetail'][0]['img_ID'] : 'SSSK10000002' ?>">
                    </div>
                </div>
              <div class="row text-center">
              <br>
                <a data-toggle="modal" class="btn btn-primary btn-lg btn-outline" href="#imgUploadBx"><i class="fa fa-upload"></i> Upload</a>
              </div>
              </div>
              <span class="text-danger text-right"><i>Mandatory fields marked by (*) mark !</i></span><br><br>
              <div class="col-sm-8 text-right" border="1">
              <?php $user_type = $this->session_library->get_session_data('Login_as');
                if($user_type === 'DSSK10000001') {
                //var_dump($user_type); ?>
                <div class="row">
                  <div class="form-group">
                    <label for="Branch" class="col-sm-3 control-label flt-left"><span class="text-danger text-right"><i>*</i></span> Branch :</label>
                    <div class="col-sm-9 text-left">
                      <select class="form-control chosen-select" id="branch_ID" name="branch_ID" placeholder="Select Branch..." required>
                      </select>
                    </div>
                    <span id="Branch"></span>
                  </div>
                </div>
              <?php } else { ?>
                <input type="hidden" name="branch_ID" value="<?php echo $this->session_library->get_session_data('branch_ID'); ?>">
              <?php } ?>
                <div class="row">
                <?php echo ($user_type === 'DSSK10000001') ? '<br>' : ''; ?>
                  <div class="form-group">
                    <label for="Name" class="col-sm-3 control-label flt-left"><span class="text-danger text-right"><i>*</i></span> Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Name" placeholder="Name" value="<?php echo @$DETAIL['studentDetail'][0]['Name']?>" required>
                    </div>
                    <span id="Name"></span>
                  </div>
                </div>
                <div class="row">
                  <br>
                   <div class="form-group">
                    <label for="Middle_Name" class="col-sm-3 control-label flt-left">Middle Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Middle_name" placeholder="Middle Name" value="<?php echo @$DETAIL['studentDetail'][0]['Middle_name']?>">
                    </div>
                    <span id="Middle_Name"></span>
                  </div>
                </div>
                <div class="row">
                  <br>
                   <div class="form-group">
                    <label for="Last_Name" class="col-sm-3 control-label flt-left">Last Name :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Last_name" placeholder="Last Name" value="<?php echo @$DETAIL['studentDetail'][0]['Last_name']?>">
                    </div>
                    <span id="Last_Name"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                  <div class="form-group">
                    <label for="Email" class="col-sm-3 control-label flt-left"><span class="text-danger text-right"><i>*</i></span> Email :</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" name="Email" placeholder="Email" value="<?php echo @$DETAIL['studentDetail'][0]['Email']?>" required>
                    </div>
                    <span id="Email"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                  <div class="form-group">
                    <label for="Password" class="col-sm-3 control-label flt-left"><span class="text-danger text-right"><i>*</i></span> Login Password :</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="Password" placeholder="Password" value="<?php echo @$DETAIL['studentDetail'][0]['Password']?>" required>
                    </div>
                    <span id="Password"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label flt-left">DOB :</label>
                    <div class="col-sm-9">
                      <input type="text" id="" class="datepicker form-control" name="DOB" placeholder="Date of Birth" value="<?php echo (@$DETAIL['studentDetail'][0]['DOB'] == NULL) ? '' : $this->date_library->db2date(@$DETAIL['studentDetail'][0]['DOB'],$this->date_library->get_date_format()); ?>">
                    </div>
                    <span id="DOB"></span>
                  </div>
                </div>
                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label flt-left">Gender :</label>
                    <div class="col-sm-9 text-left">
                      <span class="i-checks"><label>
                        <input type="radio" value="male" name="Gender" <?php if(!empty(@$DETAIL['studentDetail'][0]['Gender'])){echo (@$DETAIL['studentDetail'][0]['Gender']==='male'?'checked':''); }else{echo 'checked';} ?> > <i></i> Male</label>
                      </span>
                      <span class="i-checks"><label>
                        <input type="radio" value="female" name="Gender" <?php echo (@$DETAIL['studentDetail'][0]['Gender']==='female'?'checked':'')?>> <i></i> Female</label>
                      </span>
                    </div>
                    <span id="Gender"></span>
                  </div>
                </div>

                <div class="row">
                <br>
                   <div class="form-group">
                    <label for="DOB" class="col-sm-3 control-label flt-left">Languages :</label>
                    <div class="col-sm-9 text-left">
                      <select class="form-control chosen-select" name="language[]" id="lang" multiple>
                      </select>
                    </div>
                    <span id="Gender"></span>
                  </div>
                </div>

                <div class="row">
                <br>
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
                              <label for="" class="col-sm-3 control-label"><span class="text-danger text-right"><i>*</i></span> <?php echo ($i === 1) ? 'Phone no : ': ''; ?></label>
                              <div class="col-sm-3">
                                <select class="form-control" name="PH-phone_type-<?php echo $i; ?>">
                                  <option value="Work" <?php echo ($col_val['phone_type']) === 'Work' ? 'selected':''; ?>>Work</option>
                                  <option value="Home" <?php echo ($col_val['phone_type']) === 'Home' ? 'selected':''; ?>>Home</option>
                                  <option value="Mobile" <?php echo ($col_val['phone_type']) === 'Mobile' ? 'selected':''; ?>>Mobile</option>
                                  <option value="Personal" <?php echo ($col_val['phone_type']) === 'Personal' ? 'selected':''; ?>>Personal</option>
                                  <option value="Fax" <?php echo ($col_val['phone_type']) === 'Fax' ? 'selected':''; ?>>Fax</option>
                                  <option value="Main" <?php echo ($col_val['phone_type']) === 'Main' ? 'selected':''; ?>>Main</option>
                                </select>
                              </div>
                              <div class="col-sm-5">
                                <input type="number" class="form-control" name="PH-phone_number-<?php echo $i; ?>" placeholder="Phone no." value="<?php echo @$col_val['phone_number']; ?>" min="100000" minlength="6" maxlength="12">
                              </div>
                              <div class="col-sm-1">
                        <?php if($i === 1)
                              {
                        ?>
                                <button type="button" class="btn btn-white btn-bitbucket add_phone">
                                    <i class="fa fa-plus"></i>
                                </button>
                        <?php }
                              else
                              {
                        ?>
                                <button type="button" class="btn btn-danger btn-bitbucket remove_phone" onclick="delete_phone('phone-div-<?php echo $i; ?>','yes','<?php echo $col_val['ID']; ?>');"><i class="fa fa-trash"></i></button>
                        <?php }   
                        ?>
                              </div>
                              <br><br>
                                <span id="cst"></span>
                          </div>
                          
                <?php } ?>
                      <div id="add-phone">

                      </div>
                      <input type="hidden" id="row_count1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
                      <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">

              <?php }
                  else
                  {
              ?>  
                   <div class="form-group">
                    <label for="Contact" class="col-sm-3 control-label flt-left"><span class="text-danger text-right"><i>*</i></span> Contact :</label>
                     <div class="col-sm-3">
                        <select class="form-control" name="PH-phone_type-1" >
                          <option value="Work">Work</option>
                          <option value="Home">Home</option>
                          <option value="Mobile">Mobile</option>
                          <option value="Personal">Personal</option>
                          <option value="Fax">Fax</option>
                          <option value="Main">Main</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <input type="number" class="form-control" name="PH-phone_number-1" placeholder="Phone no." value=""  min="100000" minlength="6" maxlength="12" required>
                      </div>
                      <div class="col-sm-1">
                        <button type="button" class="btn btn-white btn-bitbucket add_phone">
                            <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    <span id="phone_no_ID"></span>
                  </div>
                  <?php } ?>
                  <input type="hidden" id="row_count1" value="1">
                  <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
                </div>
                <div class="row" id="add-phone">
                </div>

                <div class="row">
                <br>
                <?php if(isset($DETAIL['List']['Address']) && !empty($DETAIL['List']['Address'])) 
                    {
                      $i = 0;

                      foreach(@$DETAIL['List']['Address'] as $col_val)
                      {
                        $i++;
            ?>
                          <div class="form-group" id="<?php echo ($i !== 1) ? 'address-div-'.$i : '';?>">
                              <input type="hidden" name="AD-ID-<?php echo $i; ?>" value="<?php echo @$col_val['ID'];?>">
                              <label for="cst_tin_no" class="col-sm-3 control-label"><?php echo ($i === 1) ? 'Address : ': ''; ?></label>
                              <div class="col-sm-3">
                                <select class="form-control" name="AD-address_type-<?php echo $i; ?>">
                                  <option value="Work" <?php echo ($col_val['address_type']) === 'Work' ? 'selected':''; ?>>Work</option>
                                  <option value="Home" <?php echo ($col_val['address_type']) === 'Home' ? 'selected':''; ?>>Home</option>
                                </select>
                              </div>
                              <div class="col-sm-5">
                                <textarea type="text" class="form-control" name="AD-address-<?php echo $i; ?>" placeholder="Address"><?php echo @$col_val['address']; ?></textarea>
                              </div>
                              <div class="col-sm-1">
                      <?php if($i === 1)
                            {
                      ?>
                              <button type="button" class="btn btn-white btn-bitbucket add_address">
                                  <i class="fa fa-plus"></i>
                              </button>
                      <?php }
                            else
                            {
                      ?>
                              <button type="button" class="btn btn-danger btn-bitbucket" onclick="delete_adr('address-div-<?php echo $i; ?>','yes','<?php echo $col_val['ID']; ?>');"><i class="fa fa-trash"></i></button>
                      <?php }   
                      ?>
                              </div>
                              <br><br><br>
                                <span id="cst"></span>
                          </div>
                <?php } ?>
                          <div id="add-address">
                          </div>
                          <input type="hidden" id="row_count2" value="<?php echo count(@$DETAIL['List']['Address']); ?>">
                          <input type="hidden" name="num_row2" id="num_row2" value="<?php echo (!empty($DETAIL['List']['Address'])) ? count(@$DETAIL['List']['Address']) : 0; ?>">
              <?php }
                  else
                  {
              ?>
                   <div class="form-group">
                    <label for="Contact" class="col-sm-3 control-label flt-left">Address :</label>
                     <div class="col-sm-3">
                        <select class="form-control" name="AD-address_type-1" >
                          <option value="Work">Work</option>
                          <option value="Home">Home</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <textarea type="text" class="form-control" name="AD-address-1" placeholder="Address"></textarea>
                      </div>
                      <div class="col-sm-1">
                        <button type="button" class="btn btn-white btn-bitbucket add_address">
                            <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    <span id="address_ID"></span>
                  </div>
                  <?php } ?>
                  <input type="hidden" id="row_count2" value="1">
                  <input type="hidden" name="num_row2" id="num_row2" value="<?php echo count(@$DETAIL['List']['Phone']); ?>">
                </div>
                <div class="row" id="add-address">
                </div>

              </div>
            </div>
              <br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Previous Year Information</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-4">

                                    <p class="font-bold">
                                        School Name :
                                    </p>
                                    <input type="hidden" value="<?php echo @$DETAIL['prevDetail']['ID']?>" name="PR-ID">
                                    <input type="text" class="form-control" value="<?php echo @$DETAIL['prevDetail']['School']?>" name="PR-School">
                                </div>
                                <div class="col-md-4">
                                    <p class="font-bold">
                                        Standared :
                                    </p>
                                    <select class="form-control chosen-select" name="PR-Standared">
                                      <option value="" selected disabled>Select Standared</option>
                                      <option value="10" <?php echo (@$DETAIL['prevDetail']['Standared']==='10' ? 'selected' :'' ) ?>>10th</option>
                                      <option value="11" <?php echo (@$DETAIL['prevDetail']['Standared']==='11' ? 'selected' :'' ) ?>>11th</option>
                                      <option value="12" <?php echo (@$DETAIL['prevDetail']['Standared']==='12' ? 'selected' :'' ) ?>>12th</option>
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <p class="font-bold">
                                        Board :
                                    </p>
                                    <select class="form-control chosen-select" name="PR-Board" id="board">

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="number" class="col-sm-3 control-label">Maths Marks :</label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="PR-Maths" placeholder="Maths Marks" value="<?php echo @$DETAIL['prevDetail']['Maths']?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="Science" class="col-sm-3 control-label">Science Marks :</label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="PR-Science" placeholder="Science Marks" value="<?php echo @$DETAIL['prevDetail']['Science']?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="Percentage" class="col-sm-3 control-label">Total % of Previous Year :</label>
                                <div class="col-sm-9">
                                  <input type="number" max="100" class="form-control" name="PR-Per" placeholder="Total % of Previous Year" value="<?php echo @$DETAIL['prevDetail']['Per']?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="Medium" class="col-sm-3 control-label">Medium :</label>
                                <div class="col-sm-9">
                                  <select class="form-control chosen-select" name="PR-Medium">
                                    <option value="" selected disabled>Select Medium</option>
                                    <option value="Marathi" <?php echo (@$DETAIL['prevDetail']['Medium']==='Marathi' ? 'selected' :'' ) ?> >Marathi</option>
                                    <option value="English" <?php echo (@$DETAIL['prevDetail']['Medium']==='English' ? 'selected' :'' ) ?> >English</option>
                                    <option value="Hindi" <?php echo (@$DETAIL['prevDetail']['Medium']==='Hindi' ? 'selected' :'' ) ?>>Hindi</option>
                                  </select>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <br>
                              <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="col-sm-6 control-label">School leaving certificate</label>
                                    <div class="col-sm-6">
                                      <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                                        <span class="fileinput-exists">Change</span><input type="file" value="deepak" name=".." onchange="uploadFile(this,'lc_ID')" <?php echo (!empty(@$DETAIL['studentDetail'][0]['lc_ID']) ? '' :''); ?> /></span>

                                        <span class="fileinput-filename"><?php echo @$DETAIL['lc']; ?></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                    </div> 
                                    </div>
                                    <input type="hidden" name="lc_ID" id="lc_ID" value="<?php echo @$DETAIL['studentDetail'][0]['lc_ID']?>">
                                </div>
                              </div>
                              
                            </div>

                            <?php if (empty(@$DETAIL['studentDetail'][0]['document_ID'])) { ?>
                            <div class="row">
                              <br>
                                <div class="col-sm-6">
                                  <div class="form-group" id="doc-div-1">
                                      <label for="" class="col-sm-6 control-label">Scanned copy JPG or PDF of Previous years marksheet</label>
                                      <div class="col-sm-5">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                          <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                                          <span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,'document_ID1')" /></span>
                                          <span class="fileinput-filename"><?php echo @$DETAIL['doc'][0]['path']; ?></span>
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
                                foreach ($DETAIL['doc'] as $key => $value) { 
                                  ++$x; ?>
                              <div class="row">
                                <br>
                                  <div class="col-sm-6">
                                    <div class="form-group" id="doc-div-<?php echo $x; ?>">
                                        <label for="" class="col-sm-6 control-label">
                                         <?php if ($x===1) { ?>Scanned copy JPG or PDF of Previous years marksheet
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
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Current Year Information</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-4">

                                    <p class="font-bold">
                                        School Name :
                                    </p>
                                    <input type="hidden" value="<?php echo @$DETAIL['curDetail']['ID']?>" name="CR-ID">
                                    <input type="text" class="form-control" value="<?php echo @$DETAIL['curDetail']['School']?>" name="CR-School">
                                </div>
                                <div class="col-md-4">
                                    <p class="font-bold">
                                        Standared :
                                    </p>
                                    <select class="form-control chosen-select" name="CR-Standared">
                                      <option value="" selected disabled>Select Standared</option>
                                      <option value="10" <?php echo (@$DETAIL['curDetail']['Standared']==='10' ? 'selected' :'' ) ?>>10th</option>
                                      <option value="11" <?php echo (@$DETAIL['curDetail']['Standared']==='11' ? 'selected' :'' ) ?>>11th</option>
                                      <option value="12" <?php echo (@$DETAIL['curDetail']['Standared']==='12' ? 'selected' :'' ) ?>>12th</option>
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <p class="font-bold">
                                        Board :
                                    </p>
                                    <select class="form-control chosen-select" name="CR-Board" id="board1">

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="Last_Name" class="col-sm-3 control-label">Maths Marks <code>(Latest)</code> :</label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="CR-Maths" placeholder="Maths Marks" value="<?php echo @$DETAIL['curDetail']['Maths']?>" >
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="Science" class="col-sm-3 control-label">Science Marks <code>(Latest)</code>:</label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="CR-Science" placeholder="Science Marks" value="<?php echo @$DETAIL['curDetail']['Science']?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="Percentage" class="col-sm-3 control-label">Total % of <code>Latest</code> Year :</label>
                                <div class="col-sm-9">
                                  <input type="number" max="100" class="form-control" name="CR-Per" placeholder="Total % of Current Year" value="<?php echo @$DETAIL['curDetail']['Per']?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <br>
                               <div class="form-group">
                                <label for="Medium" class="col-sm-3 control-label">Medium :</label>
                                <div class="col-sm-9">
                                  <select class="form-control chosen-select" name="CR-Medium">
                                    <option value="" selected disabled>Select Medium</option>
                                    <option value="Marathi" <?php echo (@$DETAIL['curDetail']['Medium']==='Marathi' ? 'selected' :'' ) ?>>Marathi</option>
                                    <option value="English" <?php echo (@$DETAIL['curDetail']['Medium']==='English' ? 'selected' :'' ) ?> >English</option>
                                    <option value="Hindi" <?php echo (@$DETAIL['curDetail']['Medium']==='Hindi' ? 'selected' :'' ) ?>>Hindi</option>
                                  </select>
                                </div>
                              </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end of well -->


          <div class="row">
          <div class="col-sm-2 col-sm-offset-8">
            <button type="submit" class="btn btn-primary" >Next</button>
            </form>
          </div>
        </div>
      </div>
  </div>
  </div>
</div>






<div id="imgUploadBx" class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content animated flipInY">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="starter-template">
                      <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="image-crop">
                                    <img src="<?php echo @base_url($img_path); ?>">
                                </div> 
                            </div>
                            <form id="iUpload" action="#" method="post">
                            <div class="col-md-6">
                                <h4>Preview image</h4>
                                <div class="img-preview img-preview-sm hidden"></div>
                                <div class="btn-group">
                                    <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                        <input type="file"  accept="image/*" name="file" id="inputImage" class="hide">
                                        <i class="fa fa-upload"></i>Upload new image
                                    </label>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-warning" id="setConfirm" type="button">Done</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
            </div>
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
<!-- SUMMERNOTE -->
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<!-- Date -->
<script src="<?php echo base_url("js/plugins/iCheck/icheck.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/cropper/cropper.min.js"); ?>"></script>
<script>
$.validator.setDefaults({ 
    ignore: [],
    // any other default options and/or rules
});

$('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
  });
// $.validator.setDefaults({ ignore: ":hidden:not(select)" });
$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })
var base_url="<?php echo base_url(); ?>"
id="<?php echo @$id; ?>";
$("#form").validate();


$("#form").postAjaxData(function(result)
    {
      if(result === 1)
      {
        window.location.href = "<?php echo base_url('Student/add/step1/"+id+"'); ?>"
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
          window.location.href = "<?php echo base_url('Student/add/step1/"+result+"'); ?>"
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
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


var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
$('.datepicker').datepicker({
  format: js_date_format,
  keyboardNavigation: false,
  forceParse: false,
  startDate: '-20y',
  endDate: '-15y',
  autoclose: true
});


    $('#setConfirm').on('click',function(){
    $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
      $("#Login_screen").fadeIn('fast');
        var data1=$($image).cropper('getData');
        var file_data = $('#inputImage').prop('files')[0]; 
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('cropdata', JSON.stringify(data1));
      $.ajax({
        datatype:'text',
        data:form_data,
        type:'POST',
        cache: false,
        contentType: false,
        processData: false,
        url: '<?php echo base_url("Settings/image_upload");?>',
        success:function(response)
        {
        $("#Login_screen").fadeOut(2000);
          if (typeof response==='object')
          {
            $('#imgID').val(response['ID']);
            $('#imgUploadBx').modal('hide');
            path="<?php echo base_url(); ?>"+response['path'];
            $("#pImg").fadeOut(1500,function(){
              $('#pImg').attr("src",path);
              $("#pImg").fadeIn(1500);
            });
          }
          else
          {
             toastr.error("Something went wrong!");
          }
            // console.log(response['ID']); 
        }
      });
    });

    var $image = $(".image-crop > img")
    $($image).cropper({
        aspectRatio: 1.618,
        preview: ".img-preview",
        done: function(data) {

            // Output the result data for cropping image.
        }
    });

    setTimeout(function(){
     $(".cropper-dragger").remove();
     $(".cropper-canvas").removeClass('cropper-modal');
     $(".cropper-canvas").removeClass('cropper-canvas');
    },100);
    var $inputImage = $("#inputImage");
    if (window.FileReader) {
        $inputImage.change(function() {
              // $("div").removeClass("cropper-dragger");

            var fileReader = new FileReader(),
                    files = this.files,
                    file;
            if (!files.length) {
                return;
            }
            file = files[0];
             //console.log(file);
            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $image.cropper("reset", true).cropper("replace", this.result);
                    setTimeout(function(){
                     $(".cropper-dragger").remove();
                     $(".cropper-canvas").removeClass('cropper-modal');
                     $(".cropper-canvas").removeClass('cropper-canvas');
                    },100);

                };
            } else {
                showMessage("Please choose an image file.");
            }
        });
    } else {
        $inputImage.addClass("hide");
    }


$('.add_phone').on('click',function(){
  var c = $("#row_count1").val();
  ++c;
  $('<div class="form-group" id="phone-div-'+c+'"><br><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="PH-phone_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option><option value="Mobile">Mobile</option><option value="Personal">Personal</option><option value="Fax">Fax</option><option value="Main">Main</option></select></div><div class="col-sm-5"><input type="number" class="form-control" name="PH-phone_number-'+c+'" placeholder="Phone no." value="" min="100000" minlength="6" maxlength="12" required></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_phone" onclick="remove_phone(\'phone-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br></div>').appendTo('#add-phone');
  $("#row_count1").val(c);
});

$('.add_address').on('click',function(){
  var c = $("#row_count2").val();
  ++c;
  $('<div class="form-group" id="address-div-'+c+'"><br><label for="" class="col-sm-3 control-label"></label><div class="col-sm-3"><select class="form-control" name="AD-address_type-'+c+'"><option value="Work">Work</option><option value="Home">Home</option></select></div><div class="col-sm-5"><textarea class="form-control" name="AD-address-'+c+'" placeholder="Address" required></textarea></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_address" onclick="remove_address(\'address-div-'+c+'\');"><i class="fa fa-close"></i></button></div><br><br></div>').appendTo('#add-address');
  $("#row_count2").val(c);
});

$('.add_doc').on('click',function(){
  var c = $("#row_count3").val();
  ++c;
  $('<div class="row"><div class="col-sm-6"><div class="form-group" id="doc-div-'+c+'"><label for="" class="col-sm-6 control-label"></label><div class="col-sm-5"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="..."/ onchange="uploadFile(this,\'document_ID'+c+'\')"/ required></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a></div></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket add_doc" onclick="remove_doc(\'doc-div-'+c+'\');"><i class="fa fa-times"></i></button></div><input type="hidden" name="DC-document_ID-'+c+'" id="document_ID'+c+'"></div></div></div>').appendTo('#add-doc');
  $("#row_count3").val(c);
});

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

  function remove_address(phone_div,n)
  {
    if(n == 'yes')
    {
      var d = $("#num_row2").val();
      var k = --d;
      $("#num_row2").val(k);
    }
    else
    {
      var c = $("#row_count2").val();
      var j = --c;
      $("#row_count2").val(j);
    }
      $('#'+phone_div).remove();
  }

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
function delete_phone(prod_div,e,id)
{
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Student/delete_Field/'+id,
        success:function(response){
          if(response === true)
          {
            var d = $("#row_count2").val();
            var k = --d;
            $("#row_count2").val(k);
            $('#'+prod_div).remove();
            toastr.success('Phone No deleted');
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

function delete_adr(prod_div,e,id) {
    bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
      $.ajax({
        type:'POST',
        dataType:'json',
        url: '<?php echo base_url(); ?>'+'Student/delete_Field/'+id,
        success:function(response){
          if(response === true)
          {
            var d = $("#num_row1").val();
            var k = --d;
            $("#num_row1").val(k);
            $('#'+prod_div).remove();
            toastr.success('Address Deleted');
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

// where
// [{'description':'des','name':'SSC'}] branch_ID
getChosenData('board','BO',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['prevDetail']['Board']?>');
getChosenData('branch_ID','BR',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['studentDetail'][0]['branch_ID']?>');
getChosenData('board1','BO',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['curDetail']['Board']?>');
getChosenData('lang','LANG',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$DETAIL['studentDetail'][0]['language']?>',true);
</script>