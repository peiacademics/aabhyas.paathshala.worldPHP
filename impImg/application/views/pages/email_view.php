<div class="fh-breadcrumb">
    <div class="fh-column">
        <div class="full-height-scroll">
            <ul class="list-group elements-list">
                <li class="list-group-item">
                    <a data-toggle="tab" href="#tab-1">
                        <strong><?php echo ($student != NULL) ? $student['Name'].' '.$student['Middle_name'].' '.$student['Last_name'] : 'Branch Emails'; ?></strong>
                        <div class="small m-t-xs">
                            <p class="m-b-none">
                                <i class="fa fa-envelope-o"></i> <?php echo ($student != NULL) ? 'Emails received.' : 'Emails sent.'; ?>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="full-height">
        <div class="full-height-scroll white-bg border-left">
            <div class="element-detail-box">
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <?php if(($emails != NULL) && ($emails != FALSE) && !empty($emails)) {
                            foreach ($emails as $key => $value) {
                                 $student = ''; ?>
                            <h3><?php echo date('d M Y H:i A',strtotime($value['Added_on'])); ?></h3>
                            <p><?php echo $value['message']; ?></p>
                            <p class="small">
                            <?php if($this->data['Login']['Login_as'] != 'DSSK10000011') { ?>
                                <?php if($value['msgto'] != NULL) {
                                    if(strpos($value['msgto'], ',') != FALSE) {
                                        $mails_to = explode(',', $value['msgto']);
                                        foreach ($mails_to as $key_m => $value_m) {
                                            if($value_m != NULL) { 
                                                $student .= $this->str_function_library->call('fr>ST>Name:ID=`'.$value_m.'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_m.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_m.'`').', ';
                                            }
                                        }
                                        $student = rtrim($student, ', ');
                                        ?>
                                        <strong><?php echo $student; ?></strong>
                                    <?php } else { ?>
                                        <strong><?php echo "from : ".$this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`'); ?></strong>
                                    <?php } } else { ?>
                                        <strong>No recepient.</strong>
                                    <?php } ?>
                                <?php } else { ?>
                                    <strong><?php echo $this->str_function_library->call('fr>ST>Name:ID=`'.$value['msgto'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value['msgto'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value['msgto'].'`'); ?></strong>
                                <?php } ?>
                            </p>
                        <?php if($value['attachments'] != NULL) { ?>
                            <div class="m-t-lg">
                            <?php if(strpos($value['attachments'], ',') != FALSE) {
                                $attach = explode(',', $value['attachments']);
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
                                                            <?php $img_name = $this->str_function_library->call('fr>SS>path:ID=`'.$value_a.'`');
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
                                                        <img src="<?php echo base_url($this->str_function_library->call('fr>SS>path:ID=`'.$value['attachments'].'`')); ?>">
                                                    </div>
                                                    <div class="file-name">
                                                        <?php $img_name = $this->str_function_library->call('fr>SS>path:ID=`'.$value['attachments'].'`');
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
                            </div>
                        <?php } } } else { ?>
                            <h1>No emails found.</h1>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>