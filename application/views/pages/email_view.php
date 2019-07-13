<div class="">
    <div class="row">
        <div class="ibox">
            <div class="ibox-content">
                <div class="input-group">
                    <input type="text" placeholder="Search Email" id="search" class="input-sm form-control"> 
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
                                            <th><?php echo ($this->data['Login']['Login_as'] != 'DSSK10000011') ? 'To' : 'From'; ?></th>
                                            <th>Batch</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (($emails != NULL) && ($emails != FALSE) && !empty($emails)) {
                                        $i = 0;
                                        // print_r($emails);
                                        foreach ($emails as $key => $value) {
                                            $i++;
                                    ?>
                                    <tr>
                                        <td><strong><?php echo $i; ?></strong></td>
                                        <td>
                                        <a href="<?php echo base_url('student/message_detail/'.$value['ID']) ?>">
                                        <?php if($this->data['Login']['Login_as'] != 'DSSK10000011') {
                                                if($value['msgto'] != NULL) {
                                                $student = '';
                                                if(strpos($value['msgto'], ',') != FALSE) {
                                                    $mails_to = explode(',', $value['msgto']);
                                                    foreach ($mails_to as $key_m => $value_m) {
                                                        if($value_m != NULL) { 
                                                            $student .= @$this->str_function_library->call('fr>ST>Name:ID=`'.$value_m.'`').' '.@$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_m.'`').' '.@$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_m.'`').', ';
                                                        }
                                                    }
                                                    $student = rtrim($student, ', ');
                                                    ?>
                                                    <strong><?php echo $student; ?></strong>
                                                <?php } else { ?>
                                                    <strong><?php echo @$this->str_function_library->call('fr>ST>Name:ID=`'.$value['msgto'].'`').' '.@$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value['msgto'].'`').' '.@$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value['msgto'].'`'); ?></strong>
                                                <?php } } else { 

                                                    ?>
                                                    <strong>No recepient.</strong>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <strong><?php echo @$this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`'); ?></strong>
                                            <?php } ?>
                                        </a>
                                        </td>
                                        <td>
                                            <?php if($value['msgto'] != NULL) {
                                                
                                                if(strpos($value['msgto'], ',') != FALSE) {
                                                    $batches='';
                                                $batch='';
                                                $batch_name='';
                                                $batch_name2='';
                                                    $mails_to = explode(',', $value['msgto']);
                                                    foreach ($mails_to as $key_m => $value_m) {
                                                        if($value_m != NULL) { 
                                                            $batch = @$this->str_function_library->call('fr>ADT>Batch:Student_ID=`'.$value_m.'`');
                                                            $batch_name = @$this->str_function_library->call('fr>BT>name:ID=`'.$batch.'`');
                                                            
                                                            if($key_m== 0)
                                                                {
                                                                    $batches=$batch_name;
                                                                }
                                                                else
                                                                {
                                                                    $batches .=','.$batch_name;
                                                                }

                                                            if(strpos($batches, $batch_name) !== FALSE)
                                                            {
                                                                
                                                                if($key_m== 0)
                                                                {
                                                                    $batch_name2=$batch_name;
                                                                }
                                                                else
                                                                {
                                                                    if(strpos($batch_name2, $batch_name) !== FALSE) 
                                                                    {
                                                                        $batch_name2 = $batch_name2;
                                                                    }
                                                                    else
                                                                    {
                                                                        $batch_name2 .=','.$batch_name; 
                                                                    
                                                                    }
                                                                }
                                                               

                                                            }
                                                        }
                                                    }
                                                    
                                                    if(strpos($batch_name2, '-NA-') !== FALSE) 
                                                    {
                                                        $batch_name2 = str_replace("-NA-","ALL",$batch_name2);
                                                    }
                                                    $batch_name = rtrim($batch_name, ',');
                                                    if($batch_name == '-NA-')
                                                    {
                                                        $batch_name = 'All';
                                                    }
                                                    ?>
                                                    <strong><?php echo $batch_name2; ?></strong>
                                                <?php } else { 
                                                $batches='';
                                                $batch='';
                                                $batch_name='';
                                                    ?>
                                                    <strong><?php $batches = @$this->str_function_library->call('fr>ADT>Batch:Student_ID=`'.$value['msgto'].'`');
                                                    $batch = @$this->str_function_library->call('fr>BT>name:ID=`'.$batches.'`');
                                                    if($batch == '-NA-')
                                                    {
                                                        $batch = 'All';
                                                    }
                                                    echo $batch;
                                                    ?></strong>
                                                <?php } } else { ?>
                                                    <strong>No Batch.</strong>
                                                <?php } ?>
                                        </td>
                                        <td><p><?php echo $value['Subject']; ?></p></td>
                                        <td><p><?php echo $value['message']; ?></p></td>
                                        <td><strong><?php echo date('d M Y H:i A',strtotime($value['Added_on'])); ?></strong></td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr>
                                        <td colspan="5">No Email Present</td>
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

    $('.close').on('click', function(){
        $('#email_modal').hide();
    });

    function open_message(no)
    {
        $('#to_msg').html('<b>To : </b>'+$('#msg_to-'+no).val());
        $('#from_msg').html('<b>From : </b>'+$('#msg_from-'+no).val());
        $('#act_msg').html('<b>Message : </b>'+$('#sub-'+no).val());
        $('#date_msg').html('<b>Date : </b>'+$('#msg_date-'+no).val());
        $('#email_modal').show();
    }
</script>
<script src="<?php //echo base_url('js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>