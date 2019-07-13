<div class="row">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1"> Mobile</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2"> Gateway</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">

                    <div class="fh-breadcrumb">
                        <div class="fh-column">
                            <div class="full-height-scroll">
                                <ul class="list-group elements-list">
                                    <li class="list-group-item">
                                        <a data-toggle="tab" href="#tab-mobile">
                                            <strong><?php echo ($student != NULL) ? $student['Name'].' '.$student['Middle_name'].' '.$student['Last_name'] : 'Branch Messages'; ?></strong>
                                            <div class="small m-t-xs">
                                                <p class="m-b-none">
                                                    <i class="fa fa-envelope-o"></i> <?php echo ($student != NULL) ? 'Messages received.' : 'Messages sent.'; ?>
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
                                        <div id="tab-mobile" class="tab-pane active">
                                            <?php if(($mobile != NULL) && ($mobile != FALSE) && !empty($mobile)) {
                                                foreach ($mobile as $key => $value) {
                                                     $student_rec = ''; ?>
                                                <h3><?php echo date('d M Y H:i A',strtotime($value['Added_on'])); ?></h3>
                                                <p><?php echo $value['message']; ?></p>
                                                <p class="small">
                                                <?php if($this->data['Login']['Login_as'] != 'DSSK10000011') { ?>
                                                    <?php if($value['msgto'] != NULL) {
                                                        if(strpos($value['msgto'], ',') != FALSE) {
                                                            $mails_to = explode(',', $value['msgto']);
                                                            foreach ($mails_to as $key_m => $value_m) {
                                                                if($value_m != NULL) { 
                                                                    $student_rec .= @$this->str_function_library->call('fr>ST>Name:ID=`'.$value_m.'`').' '.@$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_m.'`').' '.@$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_m.'`').', ';
                                                                }
                                                            }
                                                            $student_rec = rtrim($student_rec, ', ');
                                                            ?>
                                                            <strong><?php echo $student_rec; ?></strong>
                                                        <?php } else { ?>
                                                            <strong><?php echo @$this->str_function_library->call('fr>ST>Name:ID=`'.@$value['msgto'].'`').' '.@$this->str_function_library->call('fr>ST>Middle_name:ID=`'.@$value['msgto'].'`').' '.@$this->str_function_library->call('fr>ST>Last_name:ID=`'.@$value['msgto'].'`'); ?></strong>
                                                        <?php } } else { ?>
                                                            <strong>No recepient.</strong>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <strong><?php echo "from : ".@$this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`'); ?></strong>
                                                    <?php } ?>
                                                </p>
                                                    <div class="clearfix"></div>
                                                </div>
                                            <?php  } } else { ?>
                                                <h1>No Messages found.</h1>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            
            <div id="tab-2" class="tab-pane">
                <div class="panel-body">

                    <div class="fh-breadcrumb">
                        <div class="fh-column">
                            <div class="full-height-scroll">
                                <ul class="list-group elements-list">
                                    <li class="list-group-item">
                                        <a data-toggle="tab" href="#tab-gateway">
                                            <strong><?php echo ($student != NULL) ? $student['Name'].' '.$student['Middle_name'].' '.$student['Last_name'] : 'Branch Messages'; ?></strong>
                                            <div class="small m-t-xs">
                                                <p class="m-b-none">
                                                    <i class="fa fa-envelope-o"></i> <?php echo ($student != NULL) ? 'Messages received.' : 'Messages sent.'; ?>
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
                                        <div id="tab-gateway" class="tab-pane active">
                                            <?php if(($gateway != NULL) && ($gateway != FALSE) && !empty($gateway)) {
                                                foreach ($gateway as $key => $value) {
                                                     $student_rec2 = ''; ?>
                                                <h3><?php echo date('d M Y H:i A',strtotime($value['Added_on'])); ?></h3>
                                                <p><?php echo $value['message']; ?></p>
                                                <p class="small">
                                        <?php   if($this->data['Login']['Login_as'] != 'DSSK10000011') { ?>
                                        <?php       if($value['msgto'] != NULL) {
                                                        if(strpos($value['msgto'], ',') != FALSE) {
                                                            $mails_to = explode(',', $value['msgto']);
                                                            foreach ($mails_to as $key_m => $value_m) {
                                                                if($value_m != NULL) { 
                                                                    $student_rec2 .= $this->str_function_library->call('fr>ST>Name:ID=`'.$value_m.'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_m.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_m.'`').', ';
                                                                }
                                                            }
                                                            $student_rec2 = rtrim($student_rec2, ', ');
                                                            ?>
                                <strong><?php               echo $student_rec2; ?></strong>
                                        <?php           } 
                                                        else { ?>
                                <strong><?php                echo $this->str_function_library->call('fr>ST>Name:ID=`'.$value['msgto'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value['msgto'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value['msgto'].'`');?></strong>
                                        <?php           }
                                                    }
                                                    else { ?>
                                                        <strong>No recepient.</strong>
                                        <?php       } ?>
                                        <?php   }
                                                else { ?>
                                <strong><?php        echo "from : ".$this->str_function_library->call('fr>US>Name:ID=`'.$value['Added_by'].'`'); ?></strong>
                                        <?php   } ?>
                                                </p>
                                                    <div class="clearfix"></div>
                                                </div>
                                            <?php } } else { ?>
                                                <h1>No messages found.</h1>
                                            <?php } ?>
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