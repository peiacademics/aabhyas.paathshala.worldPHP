 <div class="row text-right">
    <?php if($this->session_library->get_session_data('Login_as') != 'DSSK10000009') { ?>
    <a href="<?php echo base_url('external_student/add')?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>   
    <?php } ?>
 </div>
        <div class="">
            <div class="row">
                <div class="ibox">
                        <div class="ibox-content">
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
                                                        <th>Student</th>
                                                        <th>Birthday</th>
                                                        <th>Contact No.</th>
                                                        <th>Email</th>
                                                        <th>Package/s</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (@$Team) {
                                                   foreach ($Team as $key => $value) {
                                                ?>
                                                <tr>
                                                    <?php if($this->session_library->get_session_data('Login_as') == 'DSSK10000001') { ?>
                                                    <td><a href="<?php echo base_url('external_student/add/'.$value['ID']);?>" class="client-link"><?php echo ucfirst(@$value['Name']).' '.ucfirst(@$value['Middle_name'][0]).' '.ucfirst(@$value['Last_name']); ?></a></td>
                                                    <?php } else { ?>
                                                    <td><?php echo ucfirst(@$value['Name']).' '.ucfirst(@$value['Middle_name'][0]).' '.ucfirst(@$value['Last_name']); ?></td>
                                                    <?php } ?>
                                                    <td><?php $date = @$value['DOB'];
                                                        $date = date('d-m-Y', strtotime($date));
                                                        $date = str_replace('-', '|', $date);
                                                        echo $date; ?></td>
                                                    <td><?php echo @$value['phone']; ?></td>
                                                    <td><?php echo @$value['Email']; ?></td>
                                                    <td><?php if($value['package_ID'] != NULL) {
                                                    if (strpos($value['package_ID'], ',') !== fALSE)
                                                    {
                                                        $packs = explode(',', $value['package_ID']);
                                                        $packes = '';
                                                        foreach ($packs as $keys => $values) {
                                                            $packes .= @$this->str_function_library->call('fr>APG>name:ID=`'.@$values.'`').',';
                                                        }
                                                        $packes = rtrim($packes,',');
                                                    }
                                                    else{
                                                        $packes = @$this->str_function_library->call('fr>APG>name:ID=`'.@$value['package_ID'].'`');
                                                        }
                                                    }
                                                    echo $packes; ?></td>
                                                    <td class="client-status"><span class="label <?php echo ($value['admStatus']==='Inprocess')? 'label-warning' :'label-primary' ;?>"><?php echo $value['admStatus'];?></span></td>
                                                    <td>
                                                        <a class="label label-primary" href="<?php echo base_url('external_student/add/'.@$value['ID']); ?>"><i class="fa fa-pencil"></i></a> 
                                                        <span class="label label-danger red" id="item<?php echo @$value['ID']; ?>" onClick="deletef('<?php echo @$value['ID']; ?>','<?php echo base_url('external_student/delete/'.@$value['ID']); ?>')"><i class="fa fa-trash-o"></i></span>
                                                    </td>
                                                </tr>
                                               
                                                <?php } }else{ ?>
                                                <tr>
                                                    <td class="client-avatar"><img alt="image" src="<?php echo base_url('img/user.jpg'); ?>"> </td>
                                                    <td colspan="7">No Student Present</td>
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

            function deletef(id,href)
            {
                bootbox.confirm('Are you sure you want to delete?', function(result) {
                    if(result == true)
                    {
                        $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
                        $("#Login_screen").fadeIn('fast');
                        $.ajax({
                            url:href,
                            method:'POST',
                            datatype:'JSON',
                            error: function(jqXHR, exception) {
                                $("#Login_screen").fadeOut(2000);
                                if (jqXHR.status === 0) {
                                    alert('Not connect.\n Verify Network.');
                                } else if (jqXHR.status == 404) {
                                    alert('Requested page not found. [404]');
                                } else if (jqXHR.status == 500) {
                                    alert('Internal Server Error [500].');
                                } else if (exception === 'parsererror') {
                                    alert('Requested JSON parse failed.');
                                } else if (exception === 'timeout') {
                                    alert('Time out error.');
                                } else if (exception === 'abort') {
                                    alert('Ajax request aborted.');
                                } else {
                                    alert('Uncaught Error.\n' + jqXHR.responseText);
                                }
                            },
                            success:function(response){
                                $("#Login_screen").fadeOut(2000);
                                response = JSON.parse(response);
                                if(response === true)
                                {
                                    toastr.success('Successfully deleted.');
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 2000);
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
        <script src="<?php //echo base_url('js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
        <script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>