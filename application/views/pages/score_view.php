<div class="" >
    <div class="row">
        <div class="">
            <div class="">
                <!-- <div class="ibox-title">
                    <h5>Score Card</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div> -->
                <div class="ibox-content table-responsive">
                    <div class="project-list">
                        <table class="table table-bordered display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Assigned To</th>
                                    <th>Ratings</th>
                                    <th>Avg. Rating</th>
                                </tr>
                            </thead>
                            <tbody id="score_card">
                                <tr>
                                    <td class="project-title">
                                        <a href="project_detail.html">Contract with Zender Company</a>
                                        <br>
                                        <small>Created 14.08.2014</small>
                                    </td>
                                    <td class="project-status">
                                    </td>
                                    <td class="project-status">
                                    </td>
                                    <td class="project-people">
                                        <a title="" href=""><img alt="image" class="img-circle" src="img/a3.jpg"></a>
                                    </td>
                                    <td class="project-people">
                                        <a title="" href=""><img alt="image" class="img-circle" src="img/a3.jpg"></a> 7 points.<br>
                                        <a title="" href=""><img alt="image" class="img-circle" src="img/a3.jpg"></a> 7 points.
                                    </td>
                                    <td class="project-completion">
                                        <small>Completion with: 48%</small>
                                        <div class="progress progress-mini">
                                            <div style="width: 48%;" class="progress-bar"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    <select class="chosen-select"></select>

<!-- Mainly scripts -->
<script src="<?php echo base_url('js/jquery-2.1.1.js'); ?>"></script>
<script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url('js/inspinia.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/pace/pace.min.js'); ?>"></script>
<!-- Chosen -->
<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.chosen-container').hide();
        get_scorecard();
    });

    function get_scorecard()
    {
        $('#score_card').html('<tr><td colspan="6"> <i class="fa fa-spinner fa-spin fa-3x"></i></td></tr>');
        $.ajax({
            datatype:'json',
            type:'POST',
            url: '<?php echo base_url("report/get_scorecard").'/'.$this->uri->segment(3);?>',
            success:function(response)
            {
                var response = JSON.parse(response);
                if (typeof response==='object')
                {
                    var data = '';
                    $.each(response,function(k,v){
                        data += '<tr><td class="project-title"> <a href="#">'+v.title+'</a> <br><small>'+v.description+'</small> </td><td class="project-status">'+v.start_time+'</td><td class="project-status">'+v.end_time+'</td><td class="project-people"> <a title="" href="">'+v.assignTo+' </td><td class="project-completion">'+v.ratings+'</td><td class="project-completion"><strong>'+v.tStatus+' with: '+v.avg_rating+' points</strong><div class="progress progress-mini"><div style="width: '+v.avg_rating*10+'%;" class="progress-bar"></div></div></td></tr>';
                    });
                    $('#score_card').html(data);
                    $('.table').DataTable({
                        "pageLength": response.length,
                        dom: '',
                    });
                }
                else
                {
                    $('#score_card').html('<tr><td colspan="6"> No Data Available </td></tr>');
                    toastr.error("Something Went Wrong");
                }
            }
        })
    }
</script>

