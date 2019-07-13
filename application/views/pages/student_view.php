 <div class="row text-right">
    <?php if($this->session_library->get_session_data('Login_as') != 'DSSK10000009') { ?>
    <a href="<?php echo base_url('student/add')?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>   
    <?php } ?>
 </div>
        <div class="">
            <div class="row">
                <div class="ibox">
                        <div class="ibox-content">
                            <!-- <h2>Students</h2> -->
                          
                            <div class="input-group">
                                <input type="text" placeholder="Search Student" id="search" class="input-sm form-control"> 
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> 
                                </span>
                            </div>

                            <div class="clients-list">
                                <div class="tab-content">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="table">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                    <th></th>
                                                    <th>Student</th>
                                                    <th>Batch</th>
                                                    <th></th>
                                                    <th>School Name</th>
                                                    <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (@$Team) {
                                                   foreach ($Team as $key => $value) {
                                                    $path=$this->str_function_library->call('fr>SS>path:ID=`'.$value['img_ID'].'`');
                                                ?>
                                                <tr>
                                                    <a href="<?php echo base_url('view/'.$value['ID']);?>">
                                                    <td><strong><?php echo $value['ID']; ?></strong></td>
                                                    <td class="client-avatar"><img alt="image" src="<?php echo base_url().$path; ?>"> </td>
                                                    <?php if($this->session_library->get_session_data('Login_as') == 'DSSK10000001') { ?>
                                                    <td><a href="<?php echo base_url('student/view/'.$value['ID']);?>" class="client-link"><?php echo ucfirst(@$value['Name']).' '.ucfirst(@$value['Middle_name'][0]).' '.ucfirst(@$value['Last_name']); ?></a></td>
                                                    <?php } else { ?>
                                                    <td><?php echo ucfirst(@$value['Name']).' '.ucfirst(@$value['Middle_name'][0]).' '.ucfirst(@$value['Last_name']); ?></td>
                                                    <?php } ?>
                                                    <td> <?php $batch_id = $this->str_function_library->call('fr>ADT>Batch:Student_ID=`'.@($value['ID']).'`');echo (($batch = $this->str_function_library->call('fr>BT>name:ID=`'.@($batch_id).'`'))=='-NA-' ) ? 'Private' : $batch;?></td>
                                                    <td class="contact-type"><i class="fa fa-graduation-cap"></i> </td>
                                                    <td> <?php echo $this->str_function_library->call('fr>CI>School:student_ID=`'.$value['ID'].'`'); ?></td>
                                                    <td class="client-status"><span class="label <?php echo ($value['admStatus']==='Inprocess')? 'label-warning' :'label-primary' ;?>"><?php echo $value['admStatus'];?></span></td>
                                                    <!-- <td> <i class="fa fa-pencil"></i></td> -->
                                                     </a>
                                                </tr>
                                               
                                                <?php } }else{ ?>
                                                <tr>
                                                    <td class="client-avatar"><img alt="image" src="<?php echo base_url('img/user.jpg'); ?>"> </td>
                                                    <td colspan="5">No Student Present</td>
                                                </tr>
                                                <?php } ?>
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

        <script type="text/javascript">
          $("#search").keyup(function(){
            _this = this;
              $.each($("#table tbody tr"), function() {
                  if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                     $(this).hide();
                  else
                     $(this).show();
              });
          });

        </script>
        <script src="<?php //echo base_url('js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
        <script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>