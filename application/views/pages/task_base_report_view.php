<div class="">
    <div class="row">
        <div class="">
            <div class="ibox float-e-margins">
               <!--  <div class="ibox-title">
                    <h5>Task Reports</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div> -->
                <div class="">
                    <div class="tabs-container white-bg">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Inprocess</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Pending for Approval</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">Approved</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4">Completed</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body table-responsive">
                                    <table id="ttb1" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                                        <tr>
                                            <th> Task</th>
                                            <th> Start Time</th>
                                            <th> Expected End Time</th>
                                            <th> Assign To</th>
                                            <!-- <th> </th> -->
                                        </tr>
                                        <tbody id="tb1"> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <table id="ttb2" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                                        <tr>
                                            <th> Task</th>
                                            <th> Start Time</th>
                                            <th> End Time</th>
                                            <th> Assign To</th>
                                        </tr>
                                        <tbody id="tb2"> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <table id="ttb3" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                                        <tr>
                                            <th> Task</th>
                                            <th> Start Time</th>
                                            <th> End Time</th>
                                            <th> Assign To</th>
                                            <th> Ratings</th>
                                        </tr>
                                        <tbody id="tb3"> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <table id="ttb4" class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                                        <tr>
                                            <th> Task</th>
                                            <th> Start Time</th>
                                            <th> End Time</th>
                                            <th> Assign To</th>
                                            <th> Avg. Ratings</th>
                                        </tr>
                                        <tbody id="tb4"> 
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
<!-- Chosen -->
<!-- <select class="chosen-select"></select> -->
<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        // $('.chosen-container').hide();
        get_task_reports();
    });

    function get_task_reports()
    {
        $('#score_card').html('<tr><td colspan="6"> <i class="fa fa-spinner fa-spin fa-3x"></i></td></tr>');
        $.ajax({
            datatype:'json',
            type:'POST',
            url: '<?php echo base_url("report/get_task_reports").'/'.$this->uri->segment(3);?>',
            success:function(response)
            {
                var response = JSON.parse(response);
                if (typeof response==='object')
                {
                    $.each(response,function(k,v){
                        var data = '';
                        $.each(v,function(ky,vl){
                            data += '<tr><td class="project-title"> <a href="#">'+vl.title+'</a> <br><small>'+vl.description+'</small> </td><td class="project-status">'+vl.start_time+'</td><td class="project-status">'+vl.end_time+'</td><td class="project-status"> <a title="" href="">'+vl.assignTo+' </td>';
                            if(k == 'tb3')
                            {
                                data += '<td class="project-completion">'+vl.ratings+'</td>';
                            }
                            else if(k == 'tb4'){
                                data += '<td class="project-completion"><strong>'+vl.tStatus+' with: '+vl.avg_rating+' points</strong><div class="progress progress-mini"><div style="width: '+vl.avg_rating*10+'%;" class="progress-bar"></div></div></td>';
                            }
                            data += '</tr>';
                        });
                        $('#'+k).html(data);

                    });
                }
                else
                {
                    // $('#tb1').html('<tr></tr>');
                    // $('#tb2').html('<tr></tr>');
                    // $('#tb3').html('<tr></tr>');
                    // $('#tb4').html('<tr></tr>');
                    $('#ttb1').DataTable({
                        dom: '',
                    });
                    $('#ttb2').DataTable({
                        dom: '',
                    });
                    $('#ttb3').DataTable({
                        dom: '',
                    });
                    $('#ttb4').DataTable({
                        dom: '',
                    });
                    toastr.error("Something Went Wrong");
                }
            }
        });
    }
</script>