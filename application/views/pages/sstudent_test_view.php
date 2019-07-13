<div class="page-content">
  <div class="row">
    <div class="ibox">
      <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Student Test Record')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">
        <input type="hidden" id="student_ID" value="<?php echo $student_ID; ?>">
        <div id="stud_table" class="">
        </div>
      </div>
    </div>
  </div>
</div>

<link href="<?php echo base_url("css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css"); ?>" rel="stylesheet">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/jszip.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/pdfmake.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/vfs_fonts.js'); ?>">
</script>
<script src="<?php echo base_url("js/plugins/pdfjs/pdf.js"); ?>"></script>

<script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var student_ID = $('#student_ID').val();
    $.ajax({
      url:'<?php echo base_url('Stest/score_details'); ?>'+'/'+student_ID,
      method:'POST',
      datatype:'JSON',
      success:function(response){
        response = JSON.parse(response);
        var i = 1;
        var data = '<table id="example" class="table table-bordered" width="100%"><thead><tr><th width="33%" class="h4"> Subject : '+response.subject+'</th><th width="33%" class="h4"> Lesson : '+response.lesson+'</th></tr><tr><th width="33%" class="h4"> Topic : '+response.topic+'</th><th width="33%" class="h4"> Assignment : '+response.name+'</th></tr><tr><th width="33%" class="h4" colspan="2">Date : '+response.date+'</th></tr><tr><th width="33%" class="h4">Obtained Marks : '+response.marks_obtained+'</th><th width="33%" class="h4">Maximum Marks : '+response.total_marks+'</th></tr><tr><th colspan="2" width="33%" class="h4">Details : '+response.description+'</th></tr></thead><tbody>';
        $.each(response.z_scores,function(key,val){
          data += '<tr><td colspan="3">';
          if(val.qn_correct == true)
          {
            data += '<span style="margin-top:0px !important" class="pull-right h1 text-primary"><i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i></span>';
          }
          else
          {
            data += '<span style="margin-top:0px !important" class="pull-right h1 text-danger"><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i></span>';
          }
          data += '<div class="panel panel-success" id="div-'+i+'" style="display:block"> <div class="panel-heading"> <h3 class="text-white">Question '+i+' : ';
          data += (val.qn_name == null) ? '' : val.qn_name;
          data += '</h3>';
          if(val.qn_path != '')
          {
            data += '<img class="img img-responsive" width="100px" src="'+base_url+val.qn_path+'">';
          }
          data += '<h5>(Your Marks : '+val.marks_obtained+')</h5></div>';
          if(val.qn_type == 'most_correct')
          {
            data += '<div class="dd" id="nestable'+val.qn_ID+'"><ol class="dd-list">';
            $.each(val.z_answer,function(key1,val1){
              data += '<li class="dd-item" data-id="'+val1.ID+'"><div class="dd-handle"> '+val1.order_seq+') '+val1.answer+' ';
              if(val1.ans_path != '')
              {
                data += '<img class="img img-responsive" width="100px" src="'+base_url+val1.ans_path+'">';
              }
              data += '</div></li>';
            });
            data += '</ol></div>';
          }
          else
          { 
            data += '<ul class="todo-list m-t">';
            var j = 1;
            $.each(val.z_answer,function(key1,val1){
              data += '<li> <label class="lbl" for="a_answer-'+val1.ID+'"> '+j+') '+val1.answer+' </label> ';
              if(val1.ans_path != '')
              {
                data += '<img class="img img-responsive" width="100px" src="'+base_url+val1.ans_path+'">';
              }
              data += (val1.correct == 'yes') ? ' <i class="fa fa-check-circle fa-2x" aria-hidden="true"></i>' : '';
              data += '</li>';
              j++;
            });
            data += '</ul>';
          }
          data += '<div class="ibox-title"><div class="row"><h3 class="col-sm-12"> Your Answer : '+val.your_answer+'</h3><div class="col-sm-12"><h5> Explanation : ';
          data += (val.qn_explain == null) ? 'Not given' : val.qn_explain;
          data += ' </h5></div></div></div></div></td></tr>';
          i++;
        });
        data += '</tbody></table>';
        $('#stud_table').html(data);
      }
    });
  });
</script>