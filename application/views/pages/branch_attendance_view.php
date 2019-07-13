<div class="row">
    <div class="ibox-content">
        <div class="page-content">
            <div class="wrap">
                <h1 class="h1 text-center text-success" style="text-align:center;"><?php echo $this->str_function_library->call('fr>BR>name:ID=`'.$branch_ID.'`'); ?> Atteandance</h1>
                <br><br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-5 col-xs-push-left">
                            <a type="submit" href="<?php echo base_url('student/show/'.$branch_ID); ?>" class="btn btn-lg btn-block btn-primary dim"><i class="fa fa-graduation-cap fa-3x"></i><br><h4>Student Attendance</h4></a>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5 col-xs-push-right">
                            <a type="submit" href="<?php echo base_url('team/lists/'.$branch_ID); ?>" class="btn btn-lg btn-block btn-primary dim"><i class="fa fa-users fa-3x"></i><br><h4>Employee Attendance</h4></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>