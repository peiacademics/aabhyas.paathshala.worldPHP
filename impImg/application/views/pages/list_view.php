    <script src="<?php echo base_url("js/countdown.js"); ?>"></script>

<div class="wrapper wrapper-content">
  <div class="row animated fadeInRight">
    <div class="row m-b-lg m-t-lg">
      <div class="col-md-6">
          <div class="profile-image">
              <img src="<?php echo base_url('impImg/call.jpg');?>" class="img-circle circle-border m-b-md" alt="profile">
          </div>
          <div class="profile-info">
              <div class="">
                  <div>
                      <h2 class="no-margins">
                          <?php echo empty($lists['list']) ? 'No list is available' : $lists['list'][0]['list_Name'];?>
                      </h2>
                      <h4><?php if (!empty($lists['list'][0]['uploadedFileName'])) { ?>
                           <span class="label label-warning">Imported</span>
                          <?php }else{ ?>
                          <span class="label label-primary">Inserted</span>
                          <?php } ?>
                      </h4>
                      <small>
                          There are many variations of passages of Lorem Ipsum available, but the majority
                          have suffered alteration in some form Ipsum available.
                      </small>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <table class="table small m-b-xs">
              <tbody>
              <tr>
                  <td>
                      <strong><?php echo count($lists['list']);?></strong> Contacts
                  </td>
                  <td>
                      <strong id="noResponce">0</strong> No responce
                  </td>

              </tr>
              <tr>
                  <td>
                      <strong id="reject">0</strong> Rejected
                  </td>
                  <td>
                      <strong id="abort">0</strong> Closed
                  </td>
              </tr>
              <tr>
                  <td>
                      <strong id="customer">0</strong> Added as Customer
                  </td>
                  <td>
                      <strong id="leads">0</strong> Added as Lead
                  </td>
              </tr>
              </tbody>
          </table>
      </div>
      <div class="col-md-3">
          <small>Total Added as Customer</small>
          <h2 class="no-margins" id="totlCust">0</h2>
          <div id="sparkline1"></div>
      </div>
    </div>

    <div class="ibox-content table-responsive">
      <div class="row">
        <!-- <div class="col-sm-3"> -->
          <a class="btn" id="showAll"> <i class="fa fa-globe"></i> All</sub></a>
        <!-- </div> -->
        <!-- <div class="col-sm-3"> -->
          <a class="btn" id="sortrecall"> <i class="fa fa-repeat"></i> Calls</a>
        <!-- </div> -->
        <!-- <div class="col-sm-3"> -->
          <a class="btn" id="sortabort"> <i class="fa fa-ban"></i> Not Inrested</a>
        <!-- </div> -->
        <!-- <div class="col-sm-3"> -->
          <a class="btn" id="sortnoResponce"> <i class="fa fa-phone"></i> No Responce</sub></a>
        <!-- </div> -->
      </div>


       <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search " onkeyup="doSearch()" id="searchTerm">
                  <span class="input-group-addon" >
                    <i class="fa fa-search fa2"></i>
                  </span>
                </div>
                </div>
              </div>
      <div id="data_table table-responsive" class="">
        <br>
        <table id='dataTable' class="table someclass" cellspacing="0" >
          <thead>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </thead>
          <?php foreach ($lists['list'] as $key => $value) { 
            // var_dump($value['call_Status']);
            ?>
          <tr class="sort<?php echo $value['call_Status'];?>">
            <td class="feed-element">
              <?php if ($value['call_Status']==='blank') { ?>
              <h1 id="icn<?php echo $value['ID'];?>">
                <i class="fa fa-circle-thin"></i>
              </h1>
              <?php }else if($value['call_Status']==='called'){ ?>
              <h1 id="icn<?php echo $value['ID'];?>" class="text-danger">
                <i class="fa fa-spinner fa-pulse"></i>
              </h1>
              <?php }else if($value['call_Status']==='accept'){ ?>
              <h1 id="icn<?php echo $value['ID'];?>" class="text-warning">
                <i class="fa fa-check-circle-o"></i>
              </h1>
              <?php }else if($value['call_Status']==='noResponce' || $value['call_Status']==='reject'){ ?>
               <h1 id="icn<?php echo $value['ID'];?>" class="text-warning">
                <i class="fa fa-circle-o-notch"></i>
              </h1>
              <?php }else if($value['call_Status']==='abort'){ ?>
               <h1 id="icn<?php echo $value['ID'];?>" class="text-danger">
                <i class="fa fa-times-circle"></i>
              </h1>
              <?php }else if($value['call_Status']==='lead' || $value['call_Status']==='customer'){ ?>
                <h1 id="icn<?php echo $value['ID'];?>" class="text-success">
                <i class="fa fa-check-circle"></i>
              </h1>
              <?php }else if($value['call_Status']==='recall'){ ?>
                <h1 id="icn<?php echo $value['ID'];?>" class="text-warning">
                <i class="fa fa-repeat"></i>
              </h1>
              <?php } ?>

            </td>
            <td class="issue-info">
              <h3>
                <a onclick="addIcons('<?php echo $value['ID']; ?>','called','<?php echo "no".$key; ?>','<?php echo $key; ?>')" href="<?php echo ($value['call_Status']==='blank') ? 'tel:'.$value['contact_No'] : '#';?>" id="no<?php echo $value['ID'];?>" class="hidden-xs"><?php if ($value['call_Status']==='abort') { 
                     echo "<strike><i class='fa fa-phone'></i></strike>";
                     // echo "<strike>".$value['contact_No']."</strike>"; 
                   }else{ 
                    // echo "string";
                    ?>

                     <!-- <a onclick="showno('<?php echo "no".$key; ?>','<?php echo $key; ?>')"><i class='fa fa-phone'></i></a> -->
                     <i class='fa fa-phone'></i>
                     <span id="<?php echo "no".$key; ?>" class="hidden"><?php echo $value['contact_No']; ?></span> 
                  <?php   
                   }?>
                </a>
                <a onclick="addIcons('<?php echo $value['ID']; ?>','called')"  href="tel:<?php echo $value['contact_No'];?>" id="no<?php echo $value['ID'];?>" class="hidden-sm hidden-md hidden-lg visible-xs"><?php if ($value['call_Status']==='abort') { 
                     // echo "<strike>".$value['contact_No']."</strike>"; 
                   }
                   else
                   { ?>
                      <i class='fa fa-phone'></i>
                      <!-- <a href="tel: <?php echo $value['contact_No']; ?>"><i class='fa fa-phone'></i></a> -->
                      <!-- echo "<i class='fa fa-phone'></i>"; -->
                     <!-- echo $value['contact_No'];  -->
                 <?php  }?>
                </a>
              </h3>
                <small>
                   <?php echo $value['f_Name']." , ".$value['l_Name']; ?>
                   <br>
                   <?php echo $value['city']; ?><br>
                   <a class="btn btn-primary btn-circle btn-outline" onclick="getDetails('<?php echo $value['ID']; ?>')"> <i class="fa fa-pencil"></i></a>
                   <a class="btn btn-success btn-circle btn-outline" onClick="call_recs('<?php echo $value['ID']; ?>')"> <i class="fa fa-eye"></i></a>
                   <a class="btn btn-warning btn-circle btn-outline" onclick="send_sms('<?php echo $value['ID']; ?>')"> <i class="fa fa-comment"></i></a>
                </small>
                <br>
                <!-- <div class="smlBtn"> -->
                <div class="smlBtn visible-sm visible-xs">
                  <div id="time<?php echo $value['ID']; ?>"></div>
                    <?php if ($value['call_Status']==='recall') {
                      $alertTime = $this->str_function_library->call('fr>R>alertTime:ID=`'.$value['recall_ID'].'`');
                      //echo "<span class='label label-success'>".$alertTime."</span>";
                   ?>

                    <script type="text/javascript">
                    var idd = "<?php echo $value['ID']; ?>";
                    var endDate = "<?php echo date('Y-m-d H:i:s');?>";
                    var startDate = "<?php echo $alertTime;?>";
                    console.log(startDate);
                    new Countdown();
                    if(startDate < endDate)
                    {
                      var countdown = new Countdown({
                          selector: '#time'+idd,
                          selector: '#times'+idd,
                          msgBefore: "Recall",
                          msgAfter: "<i class='text-danger'><b>Recall!</b></i>",
                          msgPattern: "<i class='text-danger'>Not called</i> Remaining For <b>Recall</b>!",
                          dateStart: new Date(endDate),
                          dateEnd: new Date(startDate)
                      });
                    }
                    else
                    {
                      var countdown = new Countdown({
                          selector: '#time'+idd,
                          selector: '#times'+idd,
                          msgBefore: "Recall",
                          msgAfter: "<i class='text-danger'><b>Recall!</b></i>",
                          msgPattern: "<i class='text-danger'>{days} days, {hours}:{minutes}:{seconds} </i>Remaining For <b>Recall</b>!",
                          dateStart: new Date(endDate),
                          dateEnd: new Date(startDate)
                      });
                    }
                    </script>
                 <?php    } ?>
                  <!-- </td>
                  <td class="text-right"> -->
                    <?php if ($value['call_Status']==='blank') { ?>
                    <div id="<?php echo $value['ID'];?>">
                      <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','called')"> <i class="fa fa-phone"></i> Call</a>
                    </div>
                    <?php }else if($value['call_Status']==='called'){ ?>
                    <div id="<?php echo $value['ID'];?>">
                      <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','accept')"> <i class="fa fa-phone"></i> Accept</a>
                      <a class="btn btn-danger" onclick="addIcons('<?php echo $value['ID']; ?>','reject')"> <i class="fa fa-phone fa-rotate-90"></i> Reject</a>
                      <a class="btn btn-warning" onclick="addIcons('<?php echo $value['ID']; ?>','noResponce')"> <i class="fa fa-phone"></i> No Responce</a>
                    </div>
                    <?php }else if($value['call_Status']==='accept'){ ?>
                    <div id="<?php echo $value['ID'];?>">
                      <a class="btn btn-primary" onclick="Recall('<?php echo $value['ID']; ?>','recall','<?php echo $value['contact_No']; ?>')"> <i class="fa fa-phone"></i> Recall</a>
                      <a class="btn btn-success" onclick="addIcons('<?php echo $value['ID']; ?>','lead')"> <i class="fa fa-plus"></i> Lead</a>
                      <a class="btn btn-default" onclick="addIcons('<?php echo $value['ID']; ?>','customer')"> <i class="fa fa-user"></i> Customer</a>
                      <a class="btn btn-danger" onclick="addIcons('<?php echo $value['ID']; ?>','abort')"> <i class="fa fa-ban"></i> Not Interested</a>
                    </div>
                    <?php }else if($value['call_Status']==='noResponce' || $value['call_Status']==='reject'){ ?>
                     <div id="<?php echo $value['ID'];?>">
                      <!-- <a class="btn btn-primary" onclick="Recall('<?php //echo $value['ID']; ?>','recall','<?php //echo $value['contact_No']; ?>')"> <i class="fa fa-phone"></i> Recall</a> -->
                      <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','called')"> <i class="fa fa-phone"></i> Call</a>
                      <a class="btn btn-danger" onclick="addIcons('<?php echo $value['ID']; ?>','abort')"> <i class="fa fa-ban"></i> Not Interested</a>
                    </div>
                    <?php }else if($value['call_Status']==='abort'){ ?>
                     <!-- <div id="<?php //echo $value['ID'];?>">
                      <a class="btn btn-warning" readonly > <i class="fa fa-times"></i> Close</a>
                    </div> -->
                    <?php }else if($value['call_Status']==='lead' || $value['call_Status']==='customer'){ ?>
                      <div id="<?php echo $value['ID'];?>">
                        <a class="btn btn-success" readonly > <i class="fa fa-check"></i> Added in <?php echo ($value['call_Status']==='lead' ?'Lead' : 'Customer'); ?></a>
                    </div>
                    <?php }else if($value['call_Status']==='recall'){ ?>
                      <div id="<?php echo $value['ID'];?>">
                        <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','called')"> <i class="fa fa-repeat"></i> Calls</a>
                      </div>
                    <?php } ?> 
                </div>
            </td>
            <div class="hidden-sm hidden-xs">
            <td  class="text-right hidden-sm hidden-xs">
              <div id="times<?php echo $value['ID']; ?>"></div>
              <?php if ($value['call_Status'] === 'recall') {
                $alertTime = $this->str_function_library->call('fr>R>alertTime:ID=`'.$value['recall_ID'].'`');
                //echo "<span class='label label-success'>".$alertTime."</span>";
             ?>

              <script type="text/javascript">
              var idd = "<?php echo $value['ID']; ?>";
              var endDate = "<?php echo date('Y-m-d H:i:s');?>";
              var startDate = "<?php echo $alertTime;?>";
              new Countdown();
              if(startDate < endDate)
              {
                var countdown = new Countdown({
                    selector: '#time'+idd,
                    selector: '#times'+idd,
                    msgBefore: "Recall",
                    msgAfter: "<i class='text-danger'><b>Recall!</b></i>",
                    msgPattern: "<i class='text-danger'>Not called</i> Remaining For <b>Recall</b>!",
                    dateStart: new Date(endDate),
                    dateEnd: new Date(startDate)
                });
              }
              else
              {
                var countdown = new Countdown({
                    selector: '#time'+idd,
                    selector: '#times'+idd,
                    msgBefore: "Recall",
                    msgAfter: "<i class='text-danger'><b>Recall!</b></i>",
                    msgPattern: "<i class='text-danger'>{days} days, {hours}:{minutes}:{seconds} </i>Remaining For <b>Recall</b>!",
                    dateStart: new Date(endDate),
                    dateEnd: new Date(startDate)
                });
              }
              </script>
           <?php    } ?>
            <!-- </td>
            <td class="text-right"> -->
              <?php if ($value['call_Status']==='blank') { ?>
              <div id="c-<?php echo $value['ID'];?>">
                <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','called')"> <i class="fa fa-phone"></i> Call</a>
              </div>
              <?php }else if($value['call_Status']==='called'){ ?>
              <div id="c-<?php echo $value['ID'];?>">
                <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','accept')"> <i class="fa fa-phone"></i> Accept</a>
                <a class="btn btn-danger" onclick="addIcons('<?php echo $value['ID']; ?>','reject')"> <i class="fa fa-phone fa-rotate-90"></i> Reject</a>
                <a class="btn btn-warning" onclick="addIcons('<?php echo $value['ID']; ?>','noResponce')"> <i class="fa fa-phone"></i> No Responce</a>
              </div>
              <?php }else if($value['call_Status']==='accept'){ ?>
              <div id="c-<?php echo $value['ID'];?>">
                <a class="btn btn-primary" onclick="Recall('<?php echo $value['ID']; ?>','recall','<?php echo $value['contact_No']; ?>')"> <i class="fa fa-phone"></i> Recall</a>
                <a class="btn btn-success" onclick="addIcons('<?php echo $value['ID']; ?>','lead')"> <i class="fa fa-plus"></i> Lead</a>
                <a class="btn btn-default" onclick="addIcons('<?php echo $value['ID']; ?>','customer')"> <i class="fa fa-user"></i> Customer</a>
                <a class="btn btn-danger" onclick="addIcons('<?php echo $value['ID']; ?>','abort')"> <i class="fa fa-ban"></i> Not Interested</a>
              </div>
              <?php }else if($value['call_Status']==='noResponce' || $value['call_Status']==='reject'){ ?>
               <div id="c-<?php echo $value['ID'];?>">
               <!--  <a class="btn btn-primary" onclick="Recall('<?php //echo $value['ID']; ?>','recall','<?php //echo $value['contact_No']; ?>')"> <i class="fa fa-phone"></i> Recall</a> -->
                <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','called')"> <i class="fa fa-phone"></i> Call</a>
                <a class="btn btn-danger" onclick="addIcons('<?php echo $value['ID']; ?>','abort')"> <i class="fa fa-ban"></i> Not Interested</a>
              </div>
              <?php }else if($value['call_Status']==='abort'){ ?>
               <!-- <div id="<?php //echo $value['ID'];?>">
                <a class="btn btn-warning" readonly > <i class="fa fa-times"></i> Close</a>
              </div> -->
              <?php }else if($value['call_Status']==='lead' || $value['call_Status']==='customer'){ ?>
                <div id="c-<?php echo $value['ID'];?>">
                  <a class="btn btn-success" readonly > <i class="fa fa-check"></i> Added in <?php echo ($value['call_Status']==='lead' ?'Lead' : 'Customer'); ?></a>
              </div>
              <?php }else if($value['call_Status']==='recall'){ ?>
                <div id="c-<?php echo $value['ID'];?>">
                  <a class="btn btn-primary" onclick="addIcons('<?php echo $value['ID']; ?>','called')"> <i class="fa fa-repeat"></i> Calls</a>
              </div>
              <?php } ?> 
            </td>
             </div>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>


<!-- recall -->
<!-- modal to add info -->
<div class="modal inmodal" id="recall" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-phone modal-icon text-primary"></i>
              <h4 class="modal-title" id="phNoRecall"></h4>
              <small class="font-bold">Recall contact with details.</small>
          </div>
          <div class="modal-body">
          <div class="tabs-container">
            <!-- <div class="tabs-left"> -->
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-6" aria-expanded="false"> Add</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-7" aria-expanded="true">Details</a></li>
                </ul>
                <div class="tab-content ">
                    <div id="tab-6" class="tab-pane active">
                        <div class="panel-body">
                          <form method="post" id="recallData" action="#">
                            <div class="form-group" id="reference">
                              <label>Assign To</label>
                              <select class="form-control chosen-select" name="assign_to" id="assign_to">
                                <option value="">----------Select----------</option>
                                <?php
                                foreach ($lists['seniority'] as $key => $value) 
                                { ?>
                                  <option value="<?php echo $value['ID']; ?>"><?php echo $value['Name']; ?></option>
                                <?php }
                                ?>
                              </select>
                            </div>
                              <div class="form-group"><label>Description</label>
                                <textarea name="description" placeholder="Description" class="form-control"></textarea>
                                <span class="text-danger" id="description"></span>
                              </div>
                              <div class="form-group" id="time"><label>Time Interval</label>
                                <div class="input-group date">
                                  <input type='text' name="Interval" placeholder="Choose Date & time" class="form-control datetimepicker1" id="interval" required>
                                  <div class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                </div>
                                <span class="text-danger" id="Interval"></span>
                              </div>
                            <input type='hidden' name="contactID" id="id1"  placeholder="Enter your Contact No" class="form-control">
                            <input type='hidden' name="call_Status" id="cStatus"  placeholder="Enter your Contact No" class="form-control">
                            <br>
                            <br>
                             <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="button" id="addRecall" class="btn btn-primary">Save changes</button>
                            </div>
                             </form>

                        </div>
                    </div>
                    <div id="tab-7" class="tab-pane">
                        <div class="panel-body">
                             <div class="feed-activity-list" id="callrecsPPREcall">
                              </div>
                              <div class="feed-activity-list" id="callrecsREcall">
                              </div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </div>
         
      </div>
  </div>
</div>

<!-- modal to add info -->
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-phone modal-icon text-primary"></i>
              <h4 class="modal-title" id="phNo"></h4>
              <small class="font-bold">Constact details of the record.</small>
          </div>
          <div class="modal-body">
            <center><span class="text-danger"><i>Mandatory fields marked by (*) mark !</i></span></center>
            <form method="post" id="updateData" action="<?php echo base_url('lists/updateInfo');?>">
              <div class="form-group"><label><span class="text-danger text-right"><i>*</i></span> First Name</label>
                <input type='text' name="f_Name" id="name" placeholder="Enter your First Name" class="form-control" required>
              </div>
              <div class="form-group"><label>Father Name</label>
                <input type='text' name="fa_Name" id="faname" placeholder="Enter your Father Name" class="form-control">
              </div>
              <div class="form-group"><label>Mother Name</label>
                <input type='text' name="mo_Name" id="moname" placeholder="Enter your Mother Name" class="form-control">
              </div>
              <div class="form-group"><label>Last Name</label>
                <input type='text' name="l_Name" id="lname" placeholder="Enter your Last Name" class="form-control">
              </div>
              <div class="form-group"><label>City</label>
                <input type='text' name="city"  id="city" placeholder="Enter your City" class="form-control">
              </div>
              <div class="form-group"><label><span class="text-danger text-right"><i>*</i></span> Contact No</label>
                <input type='text' name="contact_No" id="cNo" placeholder="Enter your Contact No" class="form-control" required>
              </div>
              <div class="form-group"><label>Contact No 2</label>
                <input type='text' name="contact_No2" id="cNo2" placeholder="Enter your Contact No 2" class="form-control">
              </div>
              <div class="form-group"><label>Contact No 3</label>
                <input type='text' name="contact_No3" id="cNo3" placeholder="Enter your Contact No 3" class="form-control">
              </div>
              <div class="form-group text-danger" id="addTime" hidden><label>Time Interval</label>
              </div>
                <input type='hidden' name="ID" id="id"  placeholder="Enter your Contact No" class="form-control">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
           </form>
      </div>
  </div>
</div>

<!-- modal to abort records -->
<div class="modal inmodal" id="abortModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true"><!--  -->
  <div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
              <i class="fa fa-phone modal-icon text-primary"></i>
              <h4 class="modal-title" id="phNo"></h4>
              <small class="font-bold">Constact details of the record.</small>
          </div>
          <div class="modal-body">
            <center><span class="text-danger"><i>Mandatory fields marked by (*) mark !</i></span></center>
            <form method="post" id="abortContact" action="#">
              <div class="form-group">
                <label><span class="text-danger text-right"><i>*</i></span> Reason</label>
                <input type='hidden' name="contact_ID" id="contact_ID" class="form-control">
                <select class="form-control chosen-select" name="reason" id="reason" onChange="get_reason()" required>
                </select>
              </div>
              <div class="form-group hidden" id="mention">
                <label> Description</label>
                <textarea class="form-control" name="det" id="det" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> -->
              <button type="button" class="btn btn-primary" id="btn_abort" data-dismiss="modal">Save</button>
          </div>
            </form>
      </div>
  </div>
</div>

<!-- modal to sms records -->
<div class="modal inmodal" id="smsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-phone modal-icon text-primary"></i>
              <h4 class="modal-title" id="phNosms"></h4>
              <input type="hidden" id="contact_ID" value="">
              <small class="font-bold">Facility to send SMS.</small>
          </div>
          <div class="modal-body">
            <center><span class="text-danger"><i>Mandatory fields marked by (*) mark and please change message from here only !</i></span></center>
            <form method="post" id="smsContact" action="#">
              <div class="form-group">
                <label><span class="text-danger text-right"><i>*</i></span> SMS</label>
                <select class="form-control chosen-select" name="sms" id="sms" onChange="get_smsbody()" required>
                </select>
              </div>
              <div class="form-group hidden" id="type">
                <label> Description</label>
                <textarea class="form-control" name="other" id="other" onKeyup="get_smstext()" required></textarea><!-- onBlur="get_smstext()" onChange="get_smstext()"  -->
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <a type="button" class="btn btn-primary" id="btn_sms" disabled>Send</a>
          </div>
            </form>
      </div>
  </div>
</div>

<!-- modal to abort records -->
<div class="modal inmodal" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content animated bounceInRight">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <i class="fa fa-phone modal-icon text-primary"></i>
              <h4 class="modal-title" id="phNoDet"></h4>
              <small class="font-bold">Call details of contact number.</small>
          </div>
          <div class="modal-body">
              <div class="feed-activity-list ibox-content" id="callrecsPP">
              </div>
              <div class="feed-activity-list ibox-content" id="callrecs">
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Okay</button>
          </div>
      </div>
  </div>
</div>
<script src="<?php echo base_url("js/jquery.mCustomScrollbar.js"); ?>"></script>
<link rel="stylesheet" src="<?php echo base_url("css/jquery.mCustomScrollbar.css"); ?>">
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";
  var listID = "<?php echo $lists['list'][0]['list_ID'];?>";
  getCount(listID);
  $(document).ready(function() {
    $(".customscrollbar").mCustomScrollbar({
      axis:"y",
      theme:"dark",
      scrollbarPosition: "inside",
      setHeight: "10%"
    });
    $('.chosen-select').chosen();
    $("#reference_to_chosen").css('width','100%');
    $("#reason_chosen").css('width','100%');
    $("#sms_chosen").css('width','100%');
    $("#assign_to_chosen").css('width','100%');
    $('.datetimepicker1').datetimepicker({ minDate:new Date() });
    add_abort_reasons();
  });

  function add_abort_reasons()
  {
    $.ajax({
      type:'POST',
      dataType: "json",
      url: '<?php echo base_url(); ?>'+'lists/get_abort_reasons/',
      success:function(result)
      {
        $('#reason').html('');
        var data = '<option value="" disabled>----------Select----------</option>';
        if (typeof result === 'object')
        {
          if(result.length != 0)
          {
            $.each(result, function(key,value){
              data += '<option value="'+value.ID+'">'+value.reason+'</option>';
            });
          }
          data += '<option value="More">Other Reason.</option>';
          $('#reason').html(data);
          $('#reason').trigger("chosen:updated");
          data = '';
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  }

  function doSearch()
  {
    var searchText = document.getElementById('searchTerm').value;
    var targetTable = document.getElementById('dataTable');
    var targetTableColCount;
    for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++)
    {
        var rowData = '';
        if (rowIndex == 0)
        {
           targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
           continue; 
        }
        for (var colIndex = 0; colIndex < targetTableColCount; colIndex++)
        {
          rowData += targetTable.rows.item(rowIndex).cells.item(colIndex).textContent;
        }
        if (rowData.indexOf(searchText) == -1)
            targetTable.rows.item(rowIndex).style.display = 'none';
        else
            targetTable.rows.item(rowIndex).style.display = 'table-row';
    }
  }

function addIcons(id,status,id1,k){
  // showno(id1,k);
  $('#'+id).html('');
  $('#c-'+id).html('');
  $('#'+id).append('<h3><i class="fa fa-spinner fa-pulse"></i> Loading</h3>');
  $('#c-'+id).append('<h3><i class="fa fa-spinner fa-pulse"></i> Loading</h3>');
  /*if(status === 'abort')
  {
    $('#abortModal').modal('show');
    return;
  }*/
  $.ajax({
    type:'POST',
    data:{'id':id,'status':status},
     dataType: "json",
    url: '<?php echo base_url();?>Lists/chnageStatus',
    success:function(response)
    {
     // response=JSON.parse(response);
      if (status==='called'){
        if (typeof response==='object'){
          $('#'+id).html('');
          $('#c-'+id).html('');
          $('#time'+id).html('');
          $('#times'+id).html('');
          $('#time'+id).addClass('hidden');
          $('#times'+id).addClass('hidden');
          $('#icn'+id).addClass('text-danger').html('<i class="fa fa-spinner fa-pulse"></i>');
          $('#'+id).append('<a class="btn btn-primary" onclick="addIcons(\''+response.ID+'\',\'accept\')"> <i class="fa fa-phone"></i> Accept</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'reject\')"> <i class="fa fa-phone fa-rotate-90"></i> Reject</a>&nbsp;<a class="btn btn-warning" onclick="addIcons(\''+response.ID+'\',\'noResponce\')"> <i class="fa fa-phone"></i> No Responce</a>');
          $('#c-'+id).append('<a class="btn btn-primary" onclick="addIcons(\''+response.ID+'\',\'accept\')"> <i class="fa fa-phone"></i> Accept</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'reject\')"> <i class="fa fa-phone fa-rotate-90"></i> Reject</a>&nbsp;<a class="btn btn-warning" onclick="addIcons(\''+response.ID+'\',\'noResponce\')"> <i class="fa fa-phone"></i> No Responce</a>');
          $('#no'+id).removeAttr('href');
          $('#no'+id).removeAttr('onclick');
        }else
        {
          toastr.error("Something went wrong!");
        }
      }else if (status==='accept') {
        if (typeof response==='object'){
          $('#'+id).html('');
          $('#c-'+id).html('');
          $('#icn'+id).addClass('text-warning').html('<i class="fa fa-check-circle-o"></i>');
          $('#'+id).append('<a class="btn btn-primary" onclick="Recall(\''+response.ID+'\',\'recall\',\''+response.contact_No+'\')"> <i class="fa fa-phone"></i> Recall</a>&nbsp;<a class="btn btn-success" onclick="addIcons(\''+response.ID+'\',\'lead\')"> <i class="fa fa-plus"></i> Lead</a>&nbsp;<a class="btn btn-default" onclick="addIcons(\''+response.ID+'\',\'customer\')"> <i class="fa fa-user"></i> Customer</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'abort\')"> <i class="fa fa-ban"></i> Not Interested</a>');
          $('#c-'+id).append('<a class="btn btn-primary" onclick="Recall(\''+response.ID+'\',\'recall\',\''+response.contact_No+'\')"> <i class="fa fa-phone"></i> Recall</a>&nbsp;<a class="btn btn-success" onclick="addIcons(\''+response.ID+'\',\'lead\')"> <i class="fa fa-plus"></i> Lead</a>&nbsp;<a class="btn btn-default" onclick="addIcons(\''+response.ID+'\',\'customer\')"> <i class="fa fa-user"></i> Customer</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'abort\')"> <i class="fa fa-ban"></i> Not Interested</a>');
          $('#no'+id).removeAttr('href');
          $('#no'+id).removeAttr('onclick');
        }else
        {
          swal("Oops...", "Something went wrong!", "error");
        }
      }else if (status==='noResponce' || status==='reject') {
        if (typeof response==='object'){
          $.ajax({
            type:'POST',
            data: {'contact_ID':response.ID, 'reason':status},
            dataType: "json",
            url: '<?php echo base_url(); ?>'+'lists/call_record/',
            success:function(result)
            {
              if (result === true)
              {
                $('#'+id).html('');
                $('#c-'+id).html('');
                $('#icn'+id).addClass('text-warning').html('<i class="fa fa-circle-o-notch"></i>');

                $('#'+id).append('<a class="btn btn-primary" onclick="addIcons(\''+response.ID+'\',\'called\')"> <i class="fa fa-phone"></i> Call</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'abort\')"> <i class="fa fa-ban"></i> Not Interested</a>');
                $('#c-'+id).append('<a class="btn btn-primary" onclick="addIcons(\''+response.ID+'\',\'called\')"> <i class="fa fa-phone"></i> Call</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'abort\')"> <i class="fa fa-ban"></i> Not Interested</a>');
                // $('#'+id).append('<a class="btn btn-primary" onclick="Recall(\''+response.ID+'\',\'recall\',\''+response.contact_No+'\')"> <i class="fa fa-phone"></i> Recall</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'abort\')"> <i class="fa fa-ban"></i> Not Interested</a>');
                // $('#c-'+id).append('<a class="btn btn-primary" onclick="Recall(\''+response.ID+'\',\'recall\',\''+response.contact_No+'\')"> <i class="fa fa-phone"></i> Recall</a>&nbsp;<a class="btn btn-danger" onclick="addIcons(\''+response.ID+'\',\'abort\')"> <i class="fa fa-ban"></i> Not Interested</a>');
              }
              else
              {
                toastr.error("Something went wrong!");
              }
            }
          });
        }else
        {
          toastr.error("Something went wrong!");
        }
      }else if (status === 'abort') {
        if (typeof response === 'object'){
          $('#abortModal').modal('show');
          $("#btn_abort").on("click", function() {
            var reason = $('#reason').val();
            var det = $('#det').val();
            $.ajax({
              type:'POST',
              data: {'contact_ID':response.ID, 'reason':reason, 'det':det},
              dataType: "json",
              url: '<?php echo base_url(); ?>'+'lists/abort_contacts/',
              success:function(resultc)
              {
                if (resultc === true)
                {
                  $('#'+id).html('');
                  $('#c-'+id).html('');
                  $('#icn'+id).addClass('text-danger').html('<i class="fa fa-times-circle"></i>');
                }
                $('#no'+id).removeAttr('href');
                $('#no'+id).removeAttr('onclick');
              }
            });
          });
        }else
        {
          toastr.error("Something went wrong!");
        }
      }else if (status==='lead' || status==='customer') {
        if (typeof response==='object'){
          $('#'+id).html('');
          $('#c-'+id).html('');
          $('#icn'+id).addClass('text-success').html('<i class="fa fa-check-circle"></i>');
          if (status === 'lead') 
          {
            $('#reference').removeClass('hidden');
            $('#time').addClass('hidden');
            // $('#times').addClass('hidden');
            // interval
          }
          else
          {
            $('#reference').addClass('hidden'); 
            $('#time').addClass('hidden');
            // $('#times').addClass('hidden');
          }
           // $('#recall').modal('show');
           $('#id1').val(id);
           $('#cStatus').val(status);
           $('#'+id).append('<a class="btn btn-success" readonly > <i class="fa fa-check"></i> Added in '+status+'</a>');
           $('#c-'+id).append('<a class="btn btn-success" readonly > <i class="fa fa-check"></i> Added in '+status+'</a>');
           $('#no'+id).removeAttr('href');
           $('#no'+id).removeAttr('onclick');
        }else
        {
          toastr.error("Something went wrong!");
        }
      }
      getCount(listID);
    }
  });
}

/*$("#abortContact").postAjaxData(function(res_abort){
  return res_abort;
});*/

$("#updateData").postAjaxData(function(result){
  if (result===true){
    toastr.success('Successfully Updated.');
    setTimeout(function(){
      window.location.href = "<?php echo current_url(); ?>";
    }, 3000);
  }else
  {
    toastr.error("Something went wrong!");
  }
});
$('#smsContact').validate();
$('#recallData').validate();
$('#abortContact').validate();
$('#updateData').validate();
$('#addRecall').on('click',function(e) {
  $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
  $("#Login_screen").fadeIn('fast');
  var idd = $("#id1").val();
  var status = $('#cStatus').val();
  var formdata = $('#recallData').serialize();
  $.ajax({
    type:'POST',
    data:formdata,
     dataType: "json",
    url: '<?php echo base_url(); ?>'+'lists/recall/',
    success:function(response)
    {
      $("#Login_screen").fadeOut(2000);
      if (typeof response === 'object'){
          $.each(response, function(key,value){
            $("#"+key).text(value);
          });
        }
        else if (response === true)
        {
          toastr.success('Successfully Updated.');
          setTimeout(function(){
            window.location.href = "<?php echo current_url(); ?>";
          }, 3000);
        }
        else
        {
          toastr.error("Something went wrong!");
        }
    }
  });
});


$('#recall').on('hidden.bs.modal', function (e) {
  $(this).find('input').val('');
  $(this).find('textarea').val('');
});

$("#recall").on("shown.bs.modal",function(){
   //will be executed everytime #item_modal is shown
   $(this).hide().show(); //hide first and then show here
});

function getDetails(id){
  $.ajax({
    type:'POST',
     dataType: "json",
    url: '<?php echo base_url(); ?>'+'lists/getDetails/'+id,
    success:function(response)
    {
      if (typeof response === 'object'){
           $('#myModal').modal('show');
           if (status === 'lead') {
              $('#addTime').removeAttr('hidden');
              $('#addTime').append('<input type="text" name="timeInterval" placeholder="Enter time Interval in MINUTES" class="form-control" required>');
            }
           $('#phNo').html(response.contact_No);
           $('#name').val(response.f_Name);
           $('#faname').val(response.fa_Name);
           $('#moname').val(response.mo_Name);
           $('#lname').val(response.l_Name);
           $('#city').val(response.city);
           $('#cNo').val(response.contact_No);
           $('#cNo2').val(response.contact_No2);
           $('#cNo3').val(response.contact_No3);
           $('#stat').val(status);
           $('#id').val(id);
        }
        else
        {
          toastr.error("Something went wrong!");
        }
    }
  });
}

function call_recs(id){
  $('#callrecs').html('');
  $('#calls').html('');
  $.ajax({
    type:'POST',
    dataType: "json",
    url: '<?php echo base_url(); ?>'+'lists/call_recs/'+id,
    success:function(response)
    {
      if (typeof response === 'object'){
        $('#detailModal').modal('show');
        // $(".customscrollbar").mCustomScrollbar({
        //   axis:"y",
        //   scrollbarPosition: "inside",
        //   setHeight: 10,
        //           onInit:function(){
        //       console.log("Scrollbars initialized");
        //     }
        // });
        $('#phNoDet').html(response.contact_No);
        data ='';
        var data_calls = '';
        var reason = '';
        var tot_rej = 0;
        var tot_no = 0;
        var tot_received = 0;
        var tot_recall = 0;
        var tot_sms = 0;
        if(response.recs.length != 0)
        {
          $.each(response.meargeArray, function(key,value){
            if (value.ID[0] === 'C') {
              if(value.reason == 'reject')
              {
                reason = 'Rejected';
                tot_rej++;
              }
              else
              {
                reason = 'Not responded';
                tot_no++;
              }
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> called <strong class="text-warning">'+response.contact_No+'</strong>, Person <code>'+reason+'</code> call <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small></div></div>';
              tot_received++;
            }
            else if (value.ID[0] === 'R')
            {
              tot_recall++;
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> called <strong class="text-success">'+response.contact_No+'</strong> Person requested To <code>Call Back</code> at '+moment(value.alertTime).format('MMMM Do YYYY dddd h:mm a')+'. <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small><div class="well">'+value.description+'</div></div></div>';
              tot_received++;
            }
            else
            {
              tot_sms++;
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> sent SMS <strong class="text-success">'+response.contact_No+'</strong> at '+moment(value.date).format('MMMM Do YYYY dddd h:mm a')+'. <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small><div class="well">'+value.message+'</div></div></div>';
            }
          });
        }
        else{
          data += '<tr><td colspan="2" class="text-center">No records found.</td></tr>';
        }

       
        if (response.mainData[0].call_Status==='customer' || response.mainData[0].call_Status==='lead') {
          var mClass='text-navy';
          var mainData='<h4><strong>'+response.mainData[0].Added_Name+'</strong> Added '+response.contact_No+' as a '+response.mainData[0].call_Status+'</h4>';
            tot_received++;
        }
        else if (response.mainData[0].call_Status==='abort') {
          var mClass='text-danger';
           var mainData='<h4><strong>'+response.abortCntct[0].Added_Name+'</strong> Added '+response.contact_No+' as a Not Intrested</h4><div class="well">'+response.abortCntct[0].reasons+'</div>';
        }
        else
        {
           var mClass='';
           var mainData='';
        }
        $('#callrecs').html(data);

        $('#callrecsPP').html('<span class="text-center '+mClass+'">'+mainData+'</span><div class="feed-element ibox-content ibox-heading"><div class="media-body "><div class="col-xs-2"><h5 class="m-b-xs text-danger">Rejected</h5><h1 class="no-margins">'+tot_rej+'</h1></div><div class="col-xs-3"><h5 class="m-b-xs text-warning">No Response</h5><h1 class="no-margins">'+tot_no+'</h1></div><div class="col-xs-2"><h5 class="m-b-xs text-success">Recall</h5><h1 class="no-margins" >'+tot_recall+'</h1></div><div class="col-xs-2"><h5 class="m-b-xs text-primary">SMS</h5><h1 class="no-margins" >'+tot_sms+'</h1></div><div class="col-xs-3"><h4 class="m-b-xs">Total Calls</h4><h1 class="no-margins" ><strong>'+tot_received+'</strong></h1></div></div></div>');
      }
      else
      {
        toastr.error("Something went wrong!");
      }
    }
  });
}

function getCount(listID) {
   $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'lists/getCount/'+listID,
    success:function(response)
    {
        response = JSON.parse(response);
        $.each(response, function(key,value){
          $("#"+key).text(value);
        });
    }
  });
}

function Recall(id,status,no)
{
  $('#total_recalls').html('');
  $('#prev_calls').html('');
  $.ajax({
    type:'POST',
    dataType: "json",
    url: '<?php echo base_url(); ?>'+'lists/call_recs/'+id,
    success:function(response)
    {
      if (typeof response === 'object'){
        // $(".customscrollbar").mCustomScrollbar({
        //   axis:"y",
        //   scrollbarPosition: "inside",
        //   setHeight: 10,
        //           onInit:function(){
        //       console.log("Scrollbars initialized");
        //     }
        // });
        data ='';
        var data_calls = '';
        var reason = '';
        var tot_rej = 0;
        var tot_no = 0;
        var tot_received = 0;
        var tot_recall=0;
        var tot_sms = 0;
        if(response.recs.length != 0)
        {
          $('#no'+id).removeAttr('href');
          $('#no'+id).removeAttr('onclick');
          $.each(response.meargeArray, function(key,value){
            if (value.ID[0] === 'C') {
              if(value.reason == 'reject')
              {
                reason = 'Rejected';
                tot_rej++;
              }
              else
              {
                reason = 'Not responded';
                tot_no++;
              }
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> called <strong class="text-warning">'+response.contact_No+'</strong>, Person <code>'+reason+'</code> call <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small></div></div>';
              tot_received++;
            }
            else if (value.ID[0] === 'R')
            {
              tot_recall++;
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> called <strong class="text-success">'+response.contact_No+'</strong> Person requested To <code>Call Back</code> at '+moment(value.alertTime).format('MMMM Do YYYY dddd h:mm a')+'. <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small><div class="well">'+value.description+'</div></div></div>';
              tot_received++;
            }
            else
            {
              tot_sms++;
              data +='<div class="feed-element"><div class="media-body "><small class="pull-right">'+moment(value.date).fromNow()+'</small><strong>'+value.Added_Name+'</strong> sent SMS <strong class="text-success">'+response.contact_No+'</strong> at '+moment(value.date).format('MMMM Do YYYY dddd h:mm a')+'. <br><small class="text-muted">'+moment(value.date).format('dddd h:mm a')+' - '+moment(value.date).format('MMMM Do YYYY')+'</small><div class="well">'+value.message+'</div></div></div>';
              // tot_received--;
            }
          });
        }
        else{
          data += '<tr><td colspan="2" class="text-center">No records found.</td></tr>';
        }
        // $('#total_calls').html('Total Calls : '+tot_received);
        $('#callrecsREcall').html(data);
        $('#callrecsPPREcall').html('<div class="feed-element ibox-content ibox-heading"><div class="media-body "><div class="col-xs-2"><h5 class="m-b-xs text-danger">Rejected</h5><h1 class="no-margins">'+tot_rej+'</h1></div><div class="col-xs-3"><h5 class="m-b-xs text-warning">No Response</h5><h1 class="no-margins">'+tot_no+'</h1></div><div class="col-xs-2"><h5 class="m-b-xs text-success">Recall</h5><h1 class="no-margins" >'+tot_recall+'</h1></div><div class="col-xs-2"><h5 class="m-b-xs text-primary">SMS</h5><h1 class="no-margins" >'+tot_sms+'</h1></div><div class="col-xs-3"><h4 class="m-b-xs">Total Calls</h4><h1 class="no-margins" ><strong>'+tot_received+'</strong></h1></div></div></div>');
      }
    }
  });

  jQuery(this).data('modal', null);
  $('#recall').modal('show');
  $(".customscrollbar").mCustomScrollbar({
    axis:"y",
    scrollbarPosition: "inside",
    setHeight: 10,
    onInit:function(){
      console.log("Scrollbars initialized");
    }
  });
  $('#id1').val(id);
  $('#phNoRecall').html(no);
  $('#cStatus').val(status);
  $('#assign_to').trigger("chosen:updated");
}


// table show row
var rows = $('table.someclass tr');
$('#sortrecall').click(function() {
    var black = rows.filter('.sortrecall').show();
    rows.not(black).hide();
});
$('#sortnoResponce').click(function() {
    var white = rows.filter('.sortnoResponce').show();
    rows.not(white).hide();
});
$('#sortabort').click(function() {
   var white = rows.filter('.sortabort').show();
    rows.not(white).hide();
});
$('#showAll').click(function() {
    rows.show();
});


function showno(id,c)
{
  var cnt = '<?php echo count($lists['list']); ?>';
  var i;
  for (var i = 0; i < cnt; i++) 
  {
    if (i == c) 
    {
      if( $('#'+id).hasClass('hidden') )
      {
        $("#"+id).removeClass("hidden");
      }
      else
      {
        $("#"+id).addClass("hidden");
      }
      
    }
    else
    {
      $("#no"+i).addClass("hidden");
    }
  }
}

function abort_contacts()
{
  $('#abortModal').modal('show');
}

function get_reason()
{
  var reason = $('#reason').val();
  if(reason == 'More')
  {
    $('#mention').removeClass('hidden');
  }
  else
  {
    $('#mention').addClass('hidden');
  }
}
// getChosenData('reference_to','US',[{'label':'Name','value':'ID'}],[{'Status':'A'}]);

// new Countdown();
// var countdown = new Countdown({
//     selector: '#timer',
//     msgBefore: "Will start at Christmas!",
//     msgAfter: "Happy new year folks!",
//     msgPattern: "{days} days, {hours} hours and {minutes} minutes {seconds}before new year!",
//     dateStart: new Date('2013/12/25 12:00'),
//     dateEnd: new Date('Jan 1, 2017 12:00')
// });
function send_sms(id)
{
  $('#sms').html('');
  $('#phNosms').html('');
  $("#other").val('');
  $("#type").addClass('hidden');
  $("#btn_sms").attr('disabled',true);
  $("#btn_sms").removeAttr('href');
  $.ajax({
    type:'POST',
    url: '<?php echo base_url(); ?>'+'lists/get_sms_list/'+id,
    success:function(response_sms)
    {
      var data_calls = '<option disabled selected>-------Select SMS---------</option>';
      response_sms = JSON.parse(response_sms);
      $('#smsModal').modal('show');
      $('#contact_ID').val(id);
      if(response_sms.sms.length != 0)
      {
        $.each(response_sms.sms, function(key,valuesm){
          data_calls += '<option value="'+valuesm.ID+'">'+valuesm.sms+'</option>';
        });
      }
      data_calls += '<option value="Other">Other</option>';
      $('#phNosms').html(response_sms.no)
      $('#sms').html(data_calls);
      $('#sms').trigger("chosen:updated");
    }
  });
}

function get_smsbody()
{
  var id = $('#contact_ID').val();
  var message = $("#sms option:selected").text();
  var ph_no = $('#phNosms').html();
  var link = '';
  if(message === 'Other')
  {
    $('#type').removeClass('hidden');
  }
  else
  {
    $('#type').addClass('hidden');
    link += 'sms:+91'+ph_no;
    link += '?;&body='+message;
    $('#btn_sms').removeAttr('disabled');
    $('#btn_sms').attr('href',link);
    $('#btn_sms').attr("onClick","save_sms('"+id+"','"+message+"')");
  }
}

/*$('#other').on('change', function(){
  if($('#other').val() != null)
  {
    $('#btn_sms').removeAttr('disabled');
  }
  else
  {
    $('#btn_sms').attr('disabled',true);
  }
});*/

function save_sms(id, message)
{
  $.ajax({
    type:'POST',
    data: {'contact_ID':id, 'message':message},
    url: '<?php echo base_url(); ?>'+'lists/save_sms/',
    success:function(sent)
    {
      $('#smsModal').modal('hide');
    }
  });
}

function get_smstext()
{
  var id = $('#contact_ID').val();
  var message = $("#other").val();
  if(message != '')
  {
    var ph_no = $('#phNosms').html();
    var link = '';
    link += 'sms:+91'+ph_no;
    link += '?;&body='+message;
    $('#btn_sms').removeAttr('disabled');
    $('#btn_sms').attr("onClick","save_sms('"+id+"','"+message+"')");
    $('#btn_sms').attr('href',link);
  }
  else
  {
    $('#btn_sms').attr('disabled',true);
  }
}
</script>