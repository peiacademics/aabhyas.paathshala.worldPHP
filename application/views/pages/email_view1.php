<div class="fh-breadcrumb">
    <!-- <div class="fh-column">
        <div class="full-height-scroll">
            <ul class="list-group elements-list">
                <li class="list-group-item">
                    <a data-toggle="tab" href="#tab-1">
                        <strong>Message Detail</strong>
                        <div class="small m-t-xs">
                            <p class="m-b-none">
                                <i class="fa fa-envelope-o"></i> <?php //echo $message['message_type'] ; ?>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div> -->
    <div class="full-height">
        <div class="full-height-scroll white-bg border-left">
            <div class="element-detail-box">
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <?php if(($message != NULL) && ($message != FALSE) && !empty($message)) {
                                $student = 'To : '; ?>
                            <h3 class="text-success"><?php echo date('d M Y H:i A',strtotime($message['Added_on'])); ?></h3>
                            <p class="small" style="color: #008000;">
                            <?php if($this->data['Login']['Login_as'] != 'DSSK10000011') { ?>
                                <?php if($message['msgto'] != NULL) {
                                    if(strpos($message['msgto'], ',') != FALSE) {
                                        $mails_to = explode(',', $message['msgto']);
                                        foreach ($mails_to as $key_m => $value_m) {
                                            if($value_m != NULL) { 
                                                $student .= @$this->str_function_library->call('fr>ST>Name:ID=`'.$value_m.'`').' '.@$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_m.'`').' '.@$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_m.'`').', ';
                                            }
                                        }
                                        $student = rtrim($student, ', ');
                                        ?>
                                        <strong><?php echo $student; ?></strong>
                                    <?php } else { ?>
                                        <strong><?php echo "from : ".@$this->str_function_library->call('fr>US>Name:ID=`'.$message['Added_by'].'`'); ?></strong>
                                    <?php } } else { ?>
                                        <strong>No recepient.</strong>
                                    <?php } ?>
                                <?php } else { ?>
                                    <strong><?php echo "From : ".$this->str_function_library->call('fr>US>Name:ID=`'.$message['Added_by'].'`'); ?></strong>
                                <?php } ?>
                            </p>
                            <p><?php echo $message['message']; ?></p>
                        <?php if(($message['attachments'] != NULL) && ($message['message_type'] == 'email')) { ?>
                            <div class="m-t-lg">
                            <?php if(strpos($message['attachments'], ',') != FALSE) {
                                $attach = explode(',', $message['attachments']);
                                    foreach ($attach as $key_a => $value_a) {
                                        if($value_a != NULL) { ?>
                                        <div class="attachment">
                                            <div class="file-box">
                                                <div class="file">
                                                    <a href="#">
                                                        <span class="corner"></span>
                                                        <div class="icon">
                                                            <img src="<?php echo base_url($this->str_function_library->call('fr>SS>path:ID=`'.$value_a.'`')); ?>">
                                                        </div>
                                                        <div class="file-name">
                                                            <?php $img_name = @$this->str_function_library->call('fr>SS>path:ID=`'.$value_a.'`');
                                                            $img_nm = explode('/', $img_name);
                                                            echo $img_nm[1];
                                                            ?>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                <?php } } } else { ?>
                                    <div class="attachment">
                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>
                                                    <div class="icon">
                                                        <img src="<?php echo base_url($this->str_function_library->call('fr>SS>path:ID=`'.$message['attachments'].'`')); ?>">
                                                    </div>
                                                    <div class="file-name">
                                                        <?php $img_name = @$this->str_function_library->call('fr>SS>path:ID=`'.@$message['attachments'].'`');
                                                        $img_nm = explode('/', $img_name);
                                                        echo $img_nm[1];
                                                        ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="clearfix"></div>
                        <?php } } else { ?>
                            <h1>No message found.</h1>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>