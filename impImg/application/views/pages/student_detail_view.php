 <script type="text/javascript">
  function caldisabledtotl(config) {
    var sum = 0;
    $('#mydiv'+config).find('input[name^=IN-amount-][class*=paid]').each(function(){
        sum += parseInt($(this).val())
    });
    $('#mydiv'+config).find('input[name=total]').val(sum);
    ++config;
    $('#mydiv'+config).find('input[name^=IN-amount-1]').val(sum);
    $('#mydiv'+config).find('b[id^=prevp]').text(sum);
  }
</script>

        <?php //print_r($DETAIL); 
          $path=$this->str_function_library->call('fr>SS>path:ID=`'.$DETAIL['studentDetail'][0]['img_ID'].'`'); ?>
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Detail</h5>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right">
                                <img alt="image" class="img-responsive" src="<?php echo base_url().$path; ?>">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong><?php echo ucfirst(@$DETAIL['studentDetail'][0]['Name']).' '.ucfirst(@$DETAIL['studentDetail'][0]['Middle_name'][0]).' '.ucfirst(@$DETAIL['studentDetail'][0]['Last_name']); ?></strong></h4>
                                <p><i class="fa fa-phone"></i><b> Contact :</b></p>
                                <div class="row">
                                  <?php if(isset($DETAIL['List']['Phone'])) 
                                          {
                                            $i = 0;

                                            foreach(@$DETAIL['List']['Phone'] as $col_val)
                                            {
                                              $i++;
                                  ?>
                                              <?php
                                                  switch ($col_val['phone_type']) {
                                                    case 'Work':
                                                      $icon = 'building';
                                                      break;
                                                    
                                                    case 'Home':
                                                      $icon = 'home';
                                                      break;
                                                    
                                                    case 'Mobile':
                                                      $icon = 'mobile';
                                                      break;
                                                    
                                                    case 'Personal':
                                                      $icon = 'user-secret';
                                                      break;
                                                    
                                                    case 'Fax':
                                                      $icon = 'fax';
                                                      break;
                                                    
                                                    default:
                                                      $icon = 'black-tie';
                                                      break;
                                                  }
                                                 
                                              ?> 
                                              <div class="col-md-11 col-md-offset-1">
                                                <p><i class="fa fa-<?php echo $icon; ?>"></i><b> <?php echo $col_val['phone_type']; ?> :</b> 
                                                <?php echo @$col_val['phone_number']; ?></p>
                                              </div>
                                  <?php     }
                                          }
                                  ?>
                                              </div>
                                                    <p><i class="fa fa-map-marker"></i><b> Address :</b></p>
                                                    <div class="row">
                                  <?php if(isset($DETAIL['List']['Address'])) 
                                          {
                                            $i = 0;

                                            foreach(@$DETAIL['List']['Address'] as $col_val)
                                            {
                                              $i++;
                                  ?>
                                              <?php
                                                  switch ($col_val['address_type']) {
                                                    case 'Work':
                                                      $icon = 'building';
                                                      break;
                                                    
                                                    case 'Home':
                                                      $icon = 'home';
                                                      break;

                                                    default:
                                                      $icon = 'black-tie';
                                                      break;
                                                  }
                                                 
                                              ?> 
                                              <div class="col-md-11 col-md-offset-1">
                                                <p><i class="fa fa-<?php echo $icon; ?>"></i><b> <?php echo $col_val['address_type']; ?> :</b> 
                                                <?php echo @$col_val['address']; ?></p>
                                              </div>
                                  <?php     }
                                          }
                                  ?>
                                  </div>
                                <div class="user-button">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-success btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default btn-sm btn-block"><i class="fa fa-archive"></i> Archive</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-button">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="<?php echo base_url('student/add/step/'.$DETAIL['studentDetail'][0]['ID']); ?>" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i> Edit</a>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger btn-sm btn-block"><i class="fa fa-trash"></i> Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                    </div>
                <div class="col-md-8">
                    <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Profile</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Admission Details</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">Doubts</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4">Attendance</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                  <h3><strong><?php echo ucfirst(@$DETAIL['studentDetail'][0]['Name']).' '.ucfirst(@$DETAIL['studentDetail'][0]['Middle_name'][0]).' '.ucfirst(@$DETAIL['studentDetail'][0]['Last_name']); ?></strong></h3>
                                  <p><i class="fa fa-birthday-cake"></i> <?php echo $this->date_library->db2date(@$DETAIL['studentDetail'][0]['DOB'],$this->date_library->get_date_format());?></p>
                                  <p><i class="fa fa-transgender-alt"></i> <?php echo $DETAIL['studentDetail'][0]['Gender'];?> &nbsp; &nbsp; &nbsp; &nbsp;<i class="fa fa-language" aria-hidden="true"></i> <?php $lang=explode(',', trim($DETAIL['studentDetail'][0]['language'],','));
                                  $langgg='';
                                  foreach ($lang as $key => $value) {
                                     $langgg .=$this->str_function_library->call('fr>LANG>name:ID=`'.$value.'`').',';
                                   } 
                                   echo trim($langgg,',');?></p>
                                  <p><i class="fa fa-envelope"></i> <b><?php echo @$DETAIL['studentDetail'][0]['Email'];?></b></p>
                                  <?php //print_r($DETAIL); ?>
                                </div>
                                <br>
                                <div class="panel-body">
                                  <div class="row">
                                  <?php if (!empty($DETAIL['parentDetail'])) { ?>
                                    <div class="col-sm-6 panel-body">
                                      <h3><strong><?php echo ucfirst(@$DETAIL['parentDetail'][0]['Name']); ?></strong></h3>
                                      <p><i class="fa fa-child" aria-hidden="true"></i> <?php echo @$DETAIL['parentDetail'][0]['Relation'];?></p>
                                      <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo @$DETAIL['parentDetail'][0]['Address'];?></p>
                                      <p><i class="fa fa-envelope" aria-hidden="true"></i> <b><?php echo $DETAIL['parentDetail'][0]['Email'];?></b></p>
                                      <?php
                                                  switch (@$DETAIL['parentDetail'][0]['phone_type']) {
                                                    case 'Work':
                                                      $icon = 'building';
                                                      break;
                                                    
                                                    case 'Home':
                                                      $icon = 'home';
                                                      break;
                                                    
                                                    case 'Mobile':
                                                      $icon = 'mobile';
                                                      break;
                                                    
                                                    case 'Personal':
                                                      $icon = 'user-secret';
                                                      break;
                                                    
                                                    case 'Fax':
                                                      $icon = 'fax';
                                                      break;
                                                    
                                                    default:
                                                      $icon = 'black-tie';
                                                      break;
                                                  }
                                                 
                                              ?>
                                              <p><i class="fa fa-<?php echo $icon;?>" aria-hidden="true"></i> <?php echo @$DETAIL['parentDetail'][0]['phone_number'];?></p>
                                              <p><b>Occuption:- </b><?php echo $DETAIL['parentDetail'][0]['Occupation'];?> &nbsp;&nbsp;&nbsp;&nbsp;<b>Income:- </b><?php echo $DETAIL['parentDetail'][0]['Income'];?></p>
                                    </div>
                                    <div class="col-sm-6 panel-body">
                                      <h3><strong><?php echo ucfirst(@$DETAIL['parentDetail'][0]['Name']); ?></strong></h3>
                                      <p><i class="fa fa-child" aria-hidden="true"></i> <?php echo @$DETAIL['parentDetail'][1]['Relation'];?></p>
                                      <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo @$DETAIL['parentDetail'][1]['Address'];?></p>
                                      <p><i class="fa fa-envelope" aria-hidden="true"></i> <b><?php echo @$DETAIL['parentDetail'][1]['Email'];?></b></p>
                                      <?php
                                          switch (@$DETAIL['parentDetail'][1]['phone_type']) {
                                            case 'Work':
                                              $icon = 'building';
                                              break;
                                            
                                            case 'Home':
                                              $icon = 'home';
                                              break;
                                            
                                            case 'Mobile':
                                              $icon = 'mobile';
                                              break;
                                            
                                            case 'Personal':
                                              $icon = 'user-secret';
                                              break;
                                            
                                            case 'Fax':
                                              $icon = 'fax';
                                              break;
                                            
                                            default:
                                              $icon = 'black-tie';
                                              break;
                                          }
                                         
                                      ?>
                                      <p><i class="fa fa-<?php echo $icon;?>" aria-hidden="true"></i> <?php echo @$DETAIL['parentDetail'][1]['phone_number'];?></p>
                                      <p><b>Occuption:- </b><?php echo @$DETAIL['parentDetail'][1]['Occupation'];?> &nbsp; &nbsp; &nbsp; &nbsp;<b>Income:- </b><?php echo @$DETAIL['parentDetail'][1]['Income'];?></p>
                                    </div>
                                    <?php }else{ ?>
                                    <h2 class="text-danger">NO Parent Information </h2>
                                    <?php } ?>
                                  </div>
                                </div>
                                <br>
                                <div class="panel-body">
                                  <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#att1"> Profile Pic</a></li>
                                        <li class=""><a data-toggle="tab" href="#att2">Leaving Certificate</a></li>
                                        <li class=""><a data-toggle="tab" href="#att3">Prev Marksheet</a></li>
                                        <li class=""><a data-toggle="tab" href="#att4">Terms & Conditions</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="att1" class="tab-pane active">
                                            <div class="panel-body">
                                                <div class="col-lg-12">
                                                  <div class="file-box">
                                                      <?php
                                                      if (!empty(@$DETAIL['studentDetail'][0]['img_ID'])) 
                                                      {
                                                        $img = $this->str_function_library->call('fr>SS>path:ID=`'.@$DETAIL['studentDetail'][0]['img_ID'].'`'); 
                                                      }
                                                      ?>
                                                      <div class="file">
                                                          <a href="#">
                                                              <span class="corner"></span>
                                                              <?php  if (!empty($img)) {
                                                               ?>
                                                                <div class="image">
                                                                    <img alt="image" class="img-responsive" src="<?php echo base_url().$img;?>">
                                                                </div>
                                                             <?php } else { ?>
                                                                <div class="icon"><i class="img-responsive fa fa-film"></i></div>
                                                              <?php } ?>
                                                              <div class="file-name">
                                                                  <?php echo 'Profile Photo';?>
                                                                  <span class="text-right"><a href="<?php echo base_url('bank/downloadFile/'.$img);?>"><h3><i class="fa fa-download" aria-hidden="true"></i></h3></a></span>
                                                              </div>
                                                          </a>

                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                        </div>
                                        <div id="att2" class="tab-pane">
                                            <div class="panel-body">
                                                <div class="col-lg-12">
                                                  <?php
                                                  if (@$DETAIL['lc'] != NULL)
                                                  { ?>
                                                  <div class="file-box">
                                                      <?php
                                                      if (!empty(@$DETAIL['lc'])) 
                                                      {
                                                        $img = 'upload/'.@$DETAIL['lc']; 
                                                        $ext = pathinfo( $img, PATHINFO_EXTENSION);
                                                      }
                                                      else{
                                                        $img = NULL;
                                                        $ext = NULL;
                                                      }
                                                      ?>
                                                      <div class="file">
                                                          <a href="#">
                                                              <span class="corner"></span>
                                                              <?php  if ($ext==='jpg' || $ext==='png' || $ext==='JPG' || $ext==='PNG') {
                                                               ?>
                                                                <div class="image">
                                                                    <img alt="image" class="img-responsive" src="<?php echo base_url().$img;?>">
                                                                </div>
                                                             <?php } else { ?>
                                                                <div class="icon"><i class="img-responsive fa fa-film"></i></div>
                                                                <div class="file-name">
                                                                  <?php echo 'Leaving Certificate';?>
                                                                  <span class="text-right"><a href="<?php echo ($img == NULL) ? '#' : base_url('bank/downloadFile/'.$img);?>"><h3><i class="fa fa-download" aria-hidden="true"></i></h3></a></span>
                                                              </div>
                                                              <?php } ?>
                                                              <div class="file-name">
                                                                  <?php echo 'Leaving Certificate';?>
                                                                  <span class="text-right"><a href="<?php echo ($img == NULL) ? '#' : base_url('bank/downloadFile/'.$img);?>"><h3><i class="fa fa-download" aria-hidden="true"></i></h3></a></span>
                                                              </div>
                                                          </a>
                                                      </div>
                                                  </div>
                                                  <?php } else { ?>
                                                    <h3 class="text-danger"><i class="fa fa-times"></i> NO Attachments Found</h3>
                                                  <?php } ?>
                                              </div>
                                            </div>
                                        </div>

                                        <div id="att3" class="tab-pane">
                                            <div class="panel-body">
                                              <div class="col-lg-12">
                                                 <?php 
                                                 if (!empty($DETAIL['doc'])) { 
                                                  foreach ($DETAIL['doc'] as $key => $value) {
                                                  $ext = pathinfo($value['path'], PATHINFO_EXTENSION); 
                                                  ?>
                                                  <div class="file-box">
                                                      <div class="file">
                                                          <a href="#">
                                                              <span class="corner"></span>
                                                              <?php  if ($ext==='jpg' || $ext==='png' || $ext==='JPG' || $ext==='PNG') {
                                                               ?>
                                                                <div class="image">
                                                                    <img alt="image" class="img-responsive" src="<?php echo base_url().$value['path'];?>">
                                                                </div>
                                                             <?php } else { ?>
                                                                <div class="icon"><i class="img-responsive fa fa-film"></i></div>
                                                              <?php } ?>
                                                              <div class="file-name">
                                                                  <?php echo '..'.substr($value['path'], -7);?>
                                                                  
                                                                  <span class="text-right"><a href="<?php echo base_url('bank/downloadFile/'.$value['path']);?>"><h3><i class="fa fa-download" aria-hidden="true"></i></h3></a></span>
                                                              </div>
                                                          </a>

                                                      </div>
                                                  </div>
                                                 <?php }
                                               }
                                                 else
                                                 { ?>
                                                      <h3 class="text-danger"><i class="fa fa-times"></i> NO Attachments Found</h3>
                                                  <?php }
                                                 ?>
                                              </div>
                                            </div>
                                        </div>

                                        <div id="att4" class="tab-pane">
                                            <div class="panel-body">
                                              <div class="col-lg-12">
                                                 <?php 
                                                 if (!empty($DETAIL['AdmissionDoc'])) { 
                                                  foreach ($DETAIL['AdmissionDoc'] as $key => $value) {
                                                  $ext = pathinfo($value['path'], PATHINFO_EXTENSION); 
                                                  ?>
                                                  <div class="file-box">
                                                      <div class="file">
                                                          <a href="#">
                                                              <span class="corner"></span>
                                                              <?php  if ($ext==='jpg' || $ext==='png' || $ext==='JPG' || $ext==='PNG') {
                                                               ?>
                                                                <div class="image">
                                                                    <img alt="image" class="img-responsive" src="<?php echo base_url().$value['path'];?>">
                                                                </div>
                                                             <?php } else { ?>
                                                                <div class="icon"><i class="img-responsive fa fa-film"></i></div>
                                                              <?php } ?>
                                                              <div class="file-name">
                                                                  <?php echo '..'.substr($value['path'], -7);?>
                                                                  
                                                                  <span class="text-right"><a href="<?php echo base_url('bank/downloadFile/'.$value['path']);?>"><h3><i class="fa fa-download" aria-hidden="true"></i></h3></a></span>
                                                              </div>
                                                          </a>

                                                      </div>
                                                  </div>
                                                 <?php }
                                               }
                                                 else
                                                 { ?>
                                                      <h3 class="text-danger"><i class="fa fa-times"></i> NO Attachments Found</h3>
                                                  <?php }
                                                 ?>
                                              </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                               </div>
                               <br>
                               <div class="panel-body">
                                <div class="well">
                                  <h3 class="text-success">Current Year Information</h3>
                                  <hr>
                                  <br>
                                  <div class="row">
                                    <div class="col-sm-6"><b>School:-</b><?php echo $DETAIL['curDetail']['School'];?></div>
                                    <div class="col-sm-6"><b>Standared:-</b><?php echo $DETAIL['curDetail']['Standared'];?></div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-sm-6"><b>Board:-</b><?php echo $path=$this->str_function_library->call('fr>BO>name:ID=`'.$DETAIL['curDetail']['Board'].'`');?></div>
                                    <div class="col-sm-6"><b>Medium:-</b><?php echo $DETAIL['curDetail']['Medium'];?></div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Marks</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Maths</td>
                                            <td><?php echo $DETAIL['curDetail']['Maths'];?></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Science</td>
                                            <td><?php echo $DETAIL['curDetail']['Science'];?></td>
                                        </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <h4>Percentage:- <code><?php echo $DETAIL['curDetail']['Per'];?> %</code></h4>
                                    </div>
                                  </div>
                                </div>
                                <div class="panel panel-success">
                                  <div class="panel-heading">
                                      <h5 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Previous Year Information</a>
                                      </h5>
                                  </div>
                                  <div id="collapseOne" class="panel-collapse collapse">
                                      <div class="panel-body">
                                        <div class="row">
                                          <div class="col-sm-6"><b>School:-</b><?php echo $DETAIL['prevDetail']['School'];?></div>
                                          <div class="col-sm-6"><b>Standared:-</b><?php echo $DETAIL['prevDetail']['Standared'];?></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                          <div class="col-sm-6"><b>Board:-</b><?php echo $path=$this->str_function_library->call('fr>BO>name:ID=`'.$DETAIL['prevDetail']['Board'].'`');?></div>
                                          <div class="col-sm-6"><b>Medium:-</b><?php echo $DETAIL['prevDetail']['Medium'];?></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                          <div class="col-lg-12">
                                            <table class="table">
                                              <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Subject</th>
                                                  <th>Marks</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <tr>
                                                  <td>1</td>
                                                  <td>Maths</td>
                                                  <td><?php echo $DETAIL['prevDetail']['Maths'];?></td>
                                              </tr>
                                              <tr>
                                                  <td>2</td>
                                                  <td>Science</td>
                                                  <td><?php echo $DETAIL['prevDetail']['Science'];?></td>
                                              </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                          <div class="col-lg-12">
                                            <h4>Percentage:- <code><?php echo $DETAIL['prevDetail']['Per'];?> %</code></h4>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                               </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                    <?php if (!empty($DETAIL['admissionDetail'])) { ?>
                                      <h2><b>Login Id:-</b> <?php echo $DETAIL['admissionDetail']['Login'];?>
                                    <?php } ?></h2>
                                    <p>&nbsp; &nbsp;<?php echo $DETAIL['admissionDetail']['Aim'];?></p>
                                    <p><b>Year of Admission :- </b><?php echo $DETAIL['admissionDetail']['Year'];?> &nbsp; &nbsp; &nbsp; &nbsp; <b>Timing :- </b><?php echo $DETAIL['admissionDetail']['Timings'];?></p>
                                    <p><b>Previous/Current Coaching Class :- </b><?php echo $DETAIL['admissionDetail']['Coaching_class'];?></p>
                                    <p><b>Reasons for which additional help is required? :- </b><?php echo $DETAIL['admissionDetail']['Reason'];?></p>
                                    </div>
                                  </div>
                                </div>
                                 <br>
                                <div class="panel-body">
                                  <div class="row">
                                    <div class="row">
                                      <div class="col-sm-6"><b>Batch :- </b><?php echo $this->str_function_library->call('fr>BT>name:ID=`'.$DETAIL['admissionDetail']['Batch'].'`');?></div>
                                      <div class="col-sm-6"><b>Course :- </b><?php echo $this->str_function_library->call('fr>CS>name:ID=`'.$DETAIL['admissionDetail']['Course'].'`');?></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-lg-12">
                                      <b>Subjects :- </b><?php $lang=explode(',', trim($DETAIL['admissionDetail']['Subject'],','));
                                  $langgg='';
                                  foreach ($lang as $key => $value) {
                                     $langgg .=$this->str_function_library->call('fr>SB>name:ID=`'.$value.'`').',';
                                   } 
                                   echo trim($langgg,',');?>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-sm-6"><b>Mentor Faculty :- </b><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$DETAIL['admissionDetail']['Mentor'].'`');?></div>
                                      <div class="col-sm-6"><b>Admin  :- </b><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$DETAIL['admissionDetail']['Admin'].'`');?></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-sm-6"><b>Student Welfare Cousellor 1 :- </b><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$DETAIL['admissionDetail']['Welfare1'].'`');?></div>
                                      <div class="col-sm-6"><b>Student Welfare Cousellor 2  :- </b><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$DETAIL['admissionDetail']['Welfare2'].'`');?></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <b>Branch Manager :- </b><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$DETAIL['admissionDetail']['Branch_manager'].'`');?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <div class="panel-body">
                                  <div class="panel panel-warning">
                                  <div class="panel-heading">
                                      <h3 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1">Installments</a>
                                      </h3>
                                  </div>
                                  <div id="collapseOne1" class="panel-collapse collapse">
                                      <div class="panel-body">
                                          <?php 
                                if (!empty(@$DETAIL['fees']['installments'])) {
                                  $y=0;
                                  foreach ($DETAIL['fees']['installments'] as $key => $value) {
                                    $y++;?>
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
                                        <br><div class="row"><div class="col-sm-1"><button type="button" class="btn btn-primary bbd b" disabled><i class="fa fa-check ffc ddd"></i></button></div><div class="col-sm-2">Installment<b>1</b></div><div class="col-sm-7 text-center"><div class="label label-primary col-sm-11 col-sm-offset-1"><h3 class="m-b-xs"><strong>Previous Payment</strong></h3></div></div><div class="col-sm-2"><b id="prevp"></b><input type="hidden" class="form-control paid" placeholder="Amount" name="IN-amount-1" value="" id="prevPaid<?php echo $y; ?>"></div></div>
                                                        <?php 
                                                         $x++;
                                                      }
                                                      ?>
                                        <br>
                                        <div class="row" >
                                          <div class="col-sm-1">
                                            <button type="button" class="btn <?php echo (empty(@$v['isTransaction']) ? 'btn-default' :'btn-primary' );?>  bbd b" onclick="payInstallment(this)" <?php echo (empty(@$v['isTransaction']) ? '' :'disabled' );?>><i class="fa fa-check ffc ddd"></i></button>
                                          </div>
                                          <div class="col-sm-2">
                                            Installment<b><?php echo $x; ?></b>
                                          </div>
                                          <div class="col-sm-5">
                                            <div class="<?php echo (empty(@$v['bank']) ? 'col-sm-12' : 'col-sm-6');?>" id="paymode<?php echo $x; ?>">
                                              <b><?php echo $this->str_function_library->call('fr>PM>title:ID=`'.@$v['paymentmode'].'`');?></b>
                                            </div>
                                            <div class="<?php echo (empty(@$v['bank']) ? '' : 'col-sm-6');?>" id="bankID<?php echo $x; ?>">
                                              <?php if (!empty(@$v['bank'])) { ?>
                                               <b><b>Bank:-</b> <?php echo $this->str_function_library->call('fr>BA>bank_name:ID=`'.@$v['bank'].'`');?></b>
                                              <?php } ?>
                                              
                                            </div>

                                              <div class="col-sm-12">
                                                <br>
                                                <b>Description:-</b> <?php echo $v['Description']; ?>
                                              </div>
                                          </div>
                                          
                                          <div class="col-sm-2">
                                            <?php echo $this->date_library->db2date(@$v['date'],$this->date_library->get_date_format());?>
                                          </div>
                                          <div class="col-sm-2">
                                            <?php echo $v['amount']; ?>
                                            <input type="hidden" class="form-control <?php echo (empty(@$v['isTransaction']) ? '' :'paid' );?>" name="IN-amount-<?php echo $x; ?>" placeholder="Amount" value="<?php echo $v['amount']; ?>" required <?php echo (empty(@$v['isTransaction']) ? '' :'onkeyup="calcamt(),make_total()"' );?>>
                                          </div>
                                        </div>
                                    <?php
                                    } ?>
                                        <div class="row">
                                          <div class="col-sm-9 text-right">
                                            <h3>Total Paid</h3>
                                          </div>
                                          <div class="col-sm-2">
                                            <input type="text" class="form-control" name="total" placeholder="Total" required value="<?php 
                                            if (count(@$DETAIL['fees']['installments'])===$y) {
                                              echo @$DETAIL['fees']['total'];
                                            }?>" id="paidAmt" readonly>
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
                                      }?>


                                      </div>
                                  </div>
                                </div>
                                </div>
                            </div>

                            <div id="tab-3" class="tab-pane">
                              <div class="panel-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <ul class="nav nav-tabs">
                                        <?php 
                                         $activeCount=0;
                                          foreach ($DETAIL['doubts'] as $key_s => $value_s) { ?>
                                            <li class="<?php echo ($activeCount === 0) ? 'active' : ''; ?>">
                                              <a data-toggle="tab" href="#sub-<?php echo $key_s; ?>"> <?php echo $this->str_function_library->call('fr>SB>name:ID=`'.$key_s.'`'); ?></a>
                                            </li>
                                        <?php $activeCount++; } ?>
                                      </ul>

                                        <div class="tab-content">
                                        <?php //print_r($DETAIL['doubts']); ?>
                                          <?php 
                                          $tabActive=0;
                                          foreach ($DETAIL['doubts'] as $key_sb => $value_sb) { ?>
                                            <div id="sub-<?php echo $key_sb?>" class="tab-pane <?php echo ($tabActive === 0) ? 'active' : ''; ?>">

                                              <?php 
                                              $doubtsBuyTimes=0;
                                                foreach ($value_sb as $kd => $vd) { ?>
                                                <?php $remaining=$vd['doubts']-$vd['raised_doubts']; ?>
                                               <div class="panel-body">
                                                <div class="row">
                                                
                                                <?php if($vd['where_from']==='admission'){ ?>
                                                <div class="container">
                                                  <span class="h2 col-sm-4"><b>Free Doubts</b></span>
                                                  <div class="small m-b-xs"><strong><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$vd['Added_by_og'].'`'); ?></strong>   <span class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date('l, F d h:i a', strtotime($vd['Added_on_og']));?></span></div>
                                                </div>
                                                <?php }else{ ?>
                                                <div class="container">
                                                  <span class="h2 col-sm-4"><b>Bought Doubts <?php ?></b></span>
                                                  <div class="small m-b-xs"><strong><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$vd['Added_by_og'].'`'); ?></strong>   <span class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date('l, F d h:i a', strtotime($vd['Added_on_og']));?></span></div>
                                                </div>
                                                <?php } ?>
                                                <div class="col-sm-12">
                                                  <div class="col-sm-4">
                                                    <strong class="text-danger">Total Doubts:-</strong>   <b><?php echo ($vd['doubts']); ?></b>
                                                  </div>
                                                  <div class="col-sm-4">
                                                    <strong class="text-warning">Raised Doubts:-</strong>   <b id="reisedCnt-<?php echo $vd['ID']; ?>"><?php echo ($vd['raised_doubts']); ?></b>
                                                  </div>
                                                  <div class="col-sm-4">
                                                     <strong class="text-info">Solved Doubts:-</strong>   <b><?php echo ($vd['solved_doubts']); ?></b>
                                                  </div>
                                                </div>
                                                  <hr>
                                                  <div class="col-lg-12">
                                                  <?php if (!empty($vd['Raised'])) {
                                                    foreach ($vd['Raised'] as $kr => $vr) { 
                                                      if($vr['doubt_status']==='raised'){  ?>
                                                    <button type="button" class="btn btn-warning bbd" data-toggle="tooltip" title="<b><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$vr['Added_by_og'].'`');?> </b> Raised this doubt at <b class='text-info'><i class='fa fa-clock-o'></i> <?php echo date('l, F d h:i a', strtotime($vr['Added_on_og']));?></b>" data-placement="top" data-html="true" ><i class="fa fa-check ffc ddd"></i></button>
                                                    <?php }else{  //echo $vr['doubt_status'];?>
                                                     <button type="button" class="btn btn-primary bbd" data-toggle="tooltip"  title="<b><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$vr['Added_by_og'].'`');?> </b> Raised this doubt at <b class='text-info'><i class='fa fa-clock-o'></i> <?php echo date('l, F d h:i a', strtotime($vr['Added_on_og']));?></b><hr>Resolved by<br><strong class='text-warning'><?php echo $this->str_function_library->call('fr>US>Name:ID=`'.$vr['solved_by_ID'].'`');?> </strong><br><span class='text-muted text-info'><i class='fa fa-clock-o'></i> <?php echo date('l, F d h:i a', strtotime($vr['solved_on']));?></span>" data-placement="top" data-html="true" ><i class="fa fa-check ffc ddd"></i></button>
                                                  <?php }
                                                  }} ?>
                                                  <?php //var_dump(!empty($vd['Raised']));
                                                  //echo $vd['doubts']-$vd['raised_doubts'];
                                                  for ($i=0; $i <$vd['doubts']-$vd['raised_doubts'] ; $i++) { ?>
                                                      <button type="button" onclick="make_solved_doubt('<?php echo $key_sb; ?>','<?php echo $vd['ID']; ?>',this)" class="btn btn-default b bbd" data-toggle="tooltip" data-placement="top" data-html="true" ><i class="fa fa-check ffc ddd"></i></button>
                                                  <?php } ?>
                                                  </div>
                                                 </div>
                                                </div>
                                                <br>
                                                <hr>
                                                <?php 
                                                $doubtsBuyTimes++;
                                                if (count($value_sb)===$doubtsBuyTimes) { ?>
                                                  <button <?php echo ($vd['doubts']===$vd['raised_doubts'])? '':'disabled'; ?> id="btn_add_doubts_<?php echo $key_sb; ?>" type="button" class="btn btn-lg btn-success" onClick="add_doubts('<?php echo $DETAIL['studentDetail'][0]['ID']; ?>','<?php echo $key_sb; ?>')"><i class="fa fa-question-circle" aria-hidden="true"></i> Add Doubts</button>
                                                <?php }
                                                ?>
                                                
                                            <?php } ?>
                                             <input type="hidden" id="mainRemaining_<?php echo $key_sb; ?>" value="<?php echo $remaining; ?>">
                                            </div>
                                          <?php  $tabActive++; } ?>
                                        </div>
                                        
                                    <!-- <div id="new_panel"></div> -->
                                  </div>
                                </div>
                              </div>
                          </div>

                          <div id="tab-4" class="tab-pane">
                            <div class="panel-body">
                              <div class="ibox-content">
                                <h2>Statistics</h2>
                                  <small>This is total Statistics of this month</small>
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <dl class="dl-horizontal">
                                          <dt>Attendance:</dt>
                                            <dd>
                                            <div class="progress progress-striped active m-b-sm">
                                              <div style="width: 60%;" class="progress-bar"></div>
                                            </div>
                                            <small>You were <strong id="percent"></strong>%. present is this month.</small>
                                              </dd>
                                        </dl>
                                      </div>
                                    </div>
                                    <div class="todo-list m-t row">
                                      <div class="col-sm-4">
                                        <span class="m-l-xs">Holidays</span>
                                          <small class="btn btn-success m-r-sm" id="holidays"> </small>
                                      </div>
                                      <div class="col-sm-4">
                                        <span class="m-l-xs">Present Days</span>
                                          <small class="btn btn-primary m-r-sm" id="presentDay"></small>
                                      </div>
                                      <div class="col-sm-4">
                                        <span class="m-l-xs">Absent Days</span>
                                          <small class="btn btn-danger m-r-sm" id="absentDay"> </small>
                                      </div>
                                    </div>
                              </div>
                              <div class="row">
                                <br>
                                  <div class="col-sm-7">
                                    <div class="ibox float-e-margins">
                                      <div class="ibox-title">
                                        <h5>Attendance </h5>
                                      </div>
                                        <div class="ibox-content">
                                          <div id="calendar">
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-5">
                                    <div class="ibox float-e-margins">
                                      <div class="ibox-title">
                                        <h5>Monthy Attendance Table</h5>
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
                                        <table class="table table-hover">
                                          <thead>
                                            <tr>
                                              <th>#</th>
                                              <th>Date</th>
                                              <th>Hours</th>
                                              <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="dataTable1">
                                           <tr>
                                            <td>1</td>
                                              <td><span class="pie">0.52,1.041</span></td>
                                              <td>Samantha</td>
                                              <td class="text-navy"><i class="fa fa-level-up"></i> 40% </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>

                                   </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

<div class="modal inmodal" id="add_doubts" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-plus modal-icon"></i>
              <h4 class="modal-title">Add Doubts</h4>
          </div>
          <div class="modal-body">
          <form id="nos_doubts" method="post" action="<?php echo base_url('student/add_doubts');?>">
            <div class="form-group">
              <label for="completed_time" class="col-sm-6">Number of Doubts : </label>
              <div class="col-sm-6">
                <input type="number" class="form-control" id="doubt_nos" name="doubts" placeholder="Enter Number" min="1" required>
                <input type="hidden" id="student_ID" name="student_ID">
                <input type="hidden" id="solved_doubts" name="solved_doubts" value="0">
                <input type="hidden" id="where_from" name="where_from" value="buy">
                <!-- <input type="hidden" id="buy" name="buy"> -->
                <input type="hidden" id="subID" name="subject_ID">
                <input type="hidden" id="Added_by_og" name="Added_by_og" value="<?php echo $this->session_library->get_session_data('ID'); ?>">
              </div>
              <span id="completed_at"></span>
            </div>
            <input type="hidden" name="branch_ID_modal" id="branch_ID_modal" value="<?php echo $DETAIL['studentDetail'][0]['branch_ID']; ?>">
            <br><br>
            <div class="form-group">
              <label for="amount" class="col-sm-6">Enter Amount : </label>
              <div class="col-sm-6">
                <input type="number" class="form-control" id="price" name="price" placeholder="Amount" min="0" required>
              </div>
              <span id="amount"></span>
            </div>
            <br>
            <div class="form-group">
              <label for="completed_time" class="col-sm-6">Description : </label>
              <div class="col-sm-6">
                <textarea class="form-control" id="desc" name="description" placeholder="Description"></textarea>
              </div>
              <span id="Description"></span>
            </div>
          </div>
          <br><br>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
          </div>
          </form>
      </div>
  </div>
</div>

<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<script src="<?php echo base_url("js/attendance.js"); ?>"></script>

<script type="text/javascript">
  var base_url="<?php echo base_url(); ?>";
  function make_solved_doubt(sub,doubt_ID,d)
  {
    remaining=$('#mainRemaining_'+sub).val();
    var studentID='<?php echo @$DETAIL['studentDetail'][0]['ID']; ?>';
    var branch_ID = $('#branch_ID_modal').val();
    bootbox.confirm('Are you sure, you want to make it asked ?', function(result) {
      if(result == true)
      {
        $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader1.gif"></div>');
        $("#Login_screen").fadeIn('fast');
        $.ajax({
          type:'POST',
          data:{'subject_ID':sub,'branch_ID':branch_ID,'doubt_ID':doubt_ID,'studentID':studentID},
          dataType:'json',
          url: '<?php echo base_url(); ?>'+'student/make_solved_doubt',
          success:function(response)
          {
            $("#Login_screen").fadeOut(2000);
            if(response == true)
            {
              // $(d).removeClass('btn-default b').addClass('btn-warning').removeAttr('onclick').attr({'data-toggle':'tooltip','data-placement':'top','data-html':'true','title':'<b>You</b> Raised this doubt <b class="text-info">Just Now</b>',"rel":"tooltip"}).tooltip();
              $(d).removeClass('btn-default b').addClass('btn-warning').removeAttr('onclick').attr({'data-toggle':'tooltip','data-placement':'top','data-html':'true','title':'You Raised this doubt Just Now',"rel":"tooltip"}).tooltip();
              toastr.success('Doubt raised successfully.');
              remaining--;
              $('#mainRemaining_'+sub).val(remaining);
              if (remaining===0) {
                $('#btn_add_doubts_'+sub).removeAttr('disabled');
              }
              var raisedCnt=$('#reisedCnt-'+doubt_ID).html();
              $('#reisedCnt-'+doubt_ID).html(parseInt(raisedCnt)+1);
            }
            else
            {
              toastr.error('Something went wrong.');
            }
          }
        });
      }
    });
  }

  $('#nos_doubts').validate();
  function add_doubts(student_ID,subject_ID)
  {
      var branch_ID = $('#branch_ID_modal').val();
      $('#branch_ID_modal').val(branch_ID);
      // $('#buy').val(buy);
      $('#subID').val(subject_ID);
      $('#student_ID').val(student_ID);
      $('#add_doubts').modal('show');
  }

  $("#nos_doubts").postAjaxData(function(result)
  {
      if(typeof result == 'object')
      {
        var buy = 'result.buy';
        buy++;
        var data = '<br><div class="panel-body"><div class="row"><div class="col-lg-12"><div class="container"><span class="h2 col-sm-4"><b>Bought Doubts</b></span>';
        var tot_doubts_b = result.doubts;
        var solved_doubts_b = result.solved_doubts;
        var raised_doubts_b = result.raised_doubts;
        var rem_doubts_b = tot_doubts_b - solved_doubts_b;
        rem_doubts_b = rem_doubts_b - raised_doubts_b;
        data+=' <div class="small m-b-xs"><strong>'+result.buy+'</strong>   <span class="text-muted text-danger"><i class="fa fa-clock-o"></i> Just Now</span></div></div>';

        data+='<div class="col-sm-12"><div class="col-sm-4"><strong class="text-danger">Total Doubts:-</strong>   <b>'+result.doubts+'</b></div><div class="col-sm-4"><strong class="text-warning">Raised Doubts:-</strong>   <b id="reisedCnt-'+result.ID+'">0</b></div><div class="col-sm-4"><strong class="text-info">Solved Doubts:-</strong>   <b>0</b></div></div>';

        data += '<hr>';
        for(var i = 1; i <= solved_doubts_b; i++)
        {
          data += '<button id="done-'+buy+'-'+i+'" type="button" class="btn btn-primary bbd" disabled><i class="fa fa-check ffc ddd"></i></button>';
        }
        for(var k = 1; k <= raised_doubts_b; k++)
        {
          data += "<button id='raised-"+buy+"-"+k+"' type='button' class='btn btn-danger bbd'><i class='fa fa-check ffc ddd'></i></button>";
        }
        for(var j = 1; j <= rem_doubts_b; j++)
        {
          data += "<button onClick='make_solved_doubt(\""+result.subject_ID+"\",\""+result.ID+"\",this);' type='button' class='btn btn-default b bbd'><i class='fa fa-check ffc ddd'></i></button>";
        }
        buy--;
        data += '</div></div></div><br>';

        $('#mainRemaining_'+result.subject_ID).val(rem_doubts_b);
        $('#sub-'+result.subject_ID).append(data).append($('#btn_add_doubts_'+result.subject_ID));
        $('#btn_add_doubts_'+result.subject_ID).attr('disabled',true);
        $('#add_doubts').modal('hide');
        $('#doubt_nos').val('');
        $('#price').val('');
        $('#desc').val('');
        toastr.success('Doubts saved Successfully.');
      }
      else
      {
        toastr.error("Something went wrong!");
      }
  });

  $(document).ready(function() {
    id = "<?php echo $DETAIL['studentDetail'][0]['ID']; ?>";
    attendance(id);
    date = '<?php echo date('Y-m'); ?>';
    getAtData(id,date);
    $('[data-toggle="tooltip"]').tooltip(); 
  });
</script>











        