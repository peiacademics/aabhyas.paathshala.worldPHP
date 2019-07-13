<div class="">
    <div class="row">
        <div class="ibox">
            <div class="ibox-content">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"><i class="fa fa-newspaper-o"></i> Mobile</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false"><i class="fa fa-briefcase"></i> Gateway</a></li>
                </ul>
                <div class="clients-list">
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="input-group">
                                <input type="text" placeholder="Search Message" id="search" class="input-sm form-control"> 
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> 
                                </span>
                            </div>
                            <div class="panel-body">
                                <div class="full-height-scroll">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo ($this->data['Login']['Login_as'] != 'DSSK10000011') ? 'To' : 'From'; ?></th>
                                                    <th>Subject</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (($mobile != NULL) && ($mobile != FALSE) && !empty($mobile)) {
                                                @$i = 0;
                                                foreach ($mobile as $key => $value) {
                                                    @$i++;
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
                                                        <?php } } else { ?>
                                                            <strong>No recepient.</strong>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <strong><?php echo @$this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`'); ?></strong>
                                                    <?php } ?>
                                                </a>
                                                </td>
                                                <td><p><?php echo $value['message']; ?></p></td>
                                                <td><strong><?php echo date('d M Y H:i A',strtotime($value['Added_on'])); ?></strong></td>
                                            </tr>
                                            <?php } }else{ ?>
                                            <tr>
                                                <td colspan="4">No Message Present</td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tab-2" class="tab-pane">
                            <div class="input-group">
                                <input type="text" placeholder="Search Message" id="search1" class="input-sm form-control"> 
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> 
                                </span>
                            </div>
                            <div class="panel-body">
                                <div class="full-height-scroll">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo ($this->data['Login']['Login_as'] != 'DSSK10000011') ? 'To' : 'From'; ?></th>
                                                    <th>Subject</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (($gateway != NULL) && ($gateway != FALSE) && !empty($gateway)) {
                                                @$j = 0;
                                                foreach ($gateway as $key => $value) {
                                                    @$j++;
                                            ?>
                                            <tr>
                                                <td><strong><?php echo @$j; ?></strong></td>
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
                                                        <?php } } else { ?>
                                                            <strong>No recepient.</strong>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <strong><?php echo @$this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`'); ?></strong>
                                                    <?php } ?>
                                                </a>
                                                </td>
                                                <td><p><?php echo $value['message']; ?></p></td>
                                                <td><strong><?php echo date('d M Y H:i A',strtotime($value['Added_on'])); ?></strong></td>
                                            </tr>
                                            <?php } }else{ ?>
                                            <tr>
                                                <td colspan="4">No Message Present</td>
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
    $("#search1").keyup(function(){
        _this = this;
        $.each($("#table1 tbody tr"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });
</script>
<script src="<?php //echo base_url('js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>