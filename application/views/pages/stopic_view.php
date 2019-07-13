<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2><?php echo $data['package']; ?> - Topic</h2>
    <ol class="breadcrumb">
      <li>
        <?php echo $data['subject']; ?>
      </li>
      <li>
        <?php echo $data['lesson']; ?>
      </li>
      <li class="active">
        <?php echo $data['topic']; ?>
      </li>
    </ol>
  </div>
  <div class="col-lg-2">
  </div>
</div>
<!-- <div class="row"> -->
  <div id="tab" class="tabs-container row">
    <div id="tabs" class="tabs">
      <ul class="nav nav-pills nav-justified"><!-- nav-tabs -->
          <li class="tab-test active"><a class="text-center" data-toggle="tab" href="#test-tab"><i class="fa fa-star"></i> Test</a></li>
          <li class="tab-assignment"><a class="text-center" data-toggle="tab" href="#assignment-tab"><i class="fa fa-book"></i> Assgn.</a></li>
          <li class="tab-pdf"><a class="text-center" data-toggle="tab" href="#pdf-tab"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
          <li class="tab-video"><a class="text-center" data-toggle="tab" href="#video-tab"><i class="fa fa-video-camera"></i> Video</a></li>
          <li class="tab-test-app"><a class="text-center" data-toggle="tab" href="#test_history-tab"><i class="fa fa-star"></i> Test History</a></li>
          <li class="tab-assignment-sub"><a class="text-center" data-toggle="tab" href="#assignment_history-tab"><i class="fa fa-book"></i> Assgn. History</a></li>
      </ul>
      <div class="tab-content">
        <div id="test-tab" class="tab-test tab-pane active">
          <div class="panel-body">
            <h3>Test</h3>
            <table class="col-lg-12 table text-left table-bordered" id="test">
            </table>
          </div>
        </div>
        <div id="assignment-tab" class="tab-test tab-pane">
          <div class="panel-body">
            <h3>Assignment</h3>
            <table class="col-lg-12 table text-left table-bordered" id="assignment">
            </table>
          </div>
        </div>
        <div id="pdf-tab" class="tab-pdf tab-pane">
          <div class="panel-body">
            <h3>PDF</h3>
            <table class="col-lg-12 table text-left table-bordered" id="pdf">
            </table>
          </div>
        </div>
        <div id="video-tab" class="tab-video tab-pane">
          <div class="panel-body">
            <h3>Video</h3>
            <table class="col-lg-12 table text-left table-bordered" id="video">
            </table>
          </div>
        </div>
        <div id="test_history-tab" class="tab-test_history tab-pane">
          <div class="panel-body">
            <h3>Test History</h3>
            <!-- <div class="table-responsive"> -->
              <table class="col-lg-12 table text-left table-bordered" id="test_history">
              </table>
            <!-- </div> -->
          </div>
        </div>
        <div id="assignment_history-tab" class="tab-assignment_history tab-pane">
          <div class="panel-body">
            <h3>Assignment History</h3>
            <!-- <div class="table-responsive"> -->
              <table class="col-lg-12 table text-left table-bordered" id="assignment_history">
              </table>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- </div> -->
<script type="text/javascript" src="<?php echo base_url('js/moment.min.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
      method:'POST',
      data:{'url_data':'<?php echo $this->uri->segment(3); ?>'},
      url:base_url+'dashboard/get_topic_details',
      error:function(err){
        bootbox.alert('Something Went Wrong');
      },
      success:function(res)
      {
        res = JSON.parse(res);
        if(res != '0')
        {
          //Test
          if(res.test != undefined)
          {
            tdata = '';
            $.each(res.test,function(tk,tv){
              if(tv.datetime == null)
              {
                tdata += '<tr><td><span class="m-l-xs"><i class="fa fa-film"></i> '+tv.title+' <span class="pull-right">(Test yet not scheduled)</span></span></td></tr>';
              }
              else if(moment().format('YYYY-MM-DD HH:mm:ss') > tv.datetime){
                tdata += '';
              }
              else{
                tdata += '<tr><td><span class="m-l-xs"><a href="'+base_url+'stest/view/'+tv.href+'"><i class="fa fa-film"></i> '+tv.title+' <span class="pull-right">'+moment(tv.datetime,"YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY h:mm:ss a')+' (Test will start '+moment(tv.datetime,"YYYY-MM-DD HH:mm:ss").fromNow()+')</span></a></span></td></tr>';
              }
            });
            $('#test').html(tdata);
          }
          else{
            $('#test').html('<tr><td>No Test Avaliable</td></tr>');
          }
          /*--*/

          //Assignment
          if(res.assignment != undefined)
          {
            tdata = '';
            $.each(res.assignment,function(ak,av){
              tdata += '<tr><td><span class="m-l-xs"><a href="'+base_url+'sassignment/view/'+av.href+'"><i class="fa fa-film"></i> '+av.title+'</a></span></td></tr>';
            });
            $('#assignment').html(tdata);
          }
          else{
            $('#assignment').html('<tr><td>No Assignment Avaliable</td></tr>');
          }
          /*--*/

          //PDF
          if(res.pdf != undefined)
          {
            tdata = '';
            $.each(res.pdf,function(pk,pv){
              tdata += '<tr><td><span class="m-l-xs"><a href="'+base_url+'spdf/view/'+pv.href+'"><i class="fa fa-film"></i> '+pv.title+'</a></span></td></tr>';
            });
            $('#pdf').html(tdata);
          }
          else{
            $('#pdf').html('<tr><td>No PDF Avaliable</td></tr>');
          }
          /*--*/

          //VIDEO
          if(res.video != undefined)
          {
            tdata = '';
            $.each(res.video,function(vk,vv){
              tdata += '<tr><td><span class="m-l-xs"><a href="'+base_url+'svideo/view/'+vv.href+'"><i class="fa fa-film"></i> '+vv.title+'</a></span></td></tr>';
            });
            $('#video').html(tdata);
          }
          else{
            $('#video').html('<tr><td>No Video Avaliable</td></tr>');
          }

          //TEST APPEARED
          if(res.test_history != undefined && res.test_history != false)
          {
            tdata = '<tr><td>Date & Time</td><td>Name</td><td>Total Marks</td><td>Marks Obtained</td></tr>';
            tdata = '';
            $.each(res.test_history,function(tak,tav){
              tdata += '<tr><td><a href="'+base_url+'stest/get_student_test/'+tav.ID+'">Name : <span class="m-l-xs">'+tav.name+'</span><br>Date : '+moment(tav.datetime,"YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY h:mm:ss a')+'<br>Marks Obtained : '+tav.marks_obtained+'<br>Total Marks : '+tav.total_marks+'</a></td></tr>';
              // tdata += '<tr><td>'+moment(tav.datetime,"YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY h:mm:ss a')+'</td><td><span class="m-l-xs"><a href="'+base_url+'test/get_student_test/'+tav.ID+'">'+tav.name+'</a></span></td></td><td>'+tav.total_marks+'</td><td>'+tav.marks_obtained+'</td></tr>';
            });
            $('#test_history').html(tdata);
          }
          else{
            $('#test_history').html('<tr><td>No Test History Avaliable</td></tr>');
          }

           //ASSIGNMENTS SUMITTED
          if(res.assignment_history != undefined && res.assignment_history != false)
          {
            tdata = '<tr><td>Date & Time</td><td>Name</td><td>Total Marks</td><td>Marks Obtained</td></tr>';
            tdata = '';
            $.each(res.assignment_history,function(tbk,tbv){
              tdata += '<tr><td><a href="'+base_url+'sassignment/get_student_assignment/'+tbv.ID+'">Name : <span class="m-l-xs">'+tbv.name+'</span><br>Date : '+moment(tbv.datetime,"YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY h:mm:ss a')+'<br>Marks Obtained : '+tbv.marks_obtained+'<br>Total Marks : '+tbv.total_marks+'</a></td></tr>';
              // tdata += '<tr><td>'+moment(tbv.datetime,"YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY h:mm:ss a')+'</td><td><span class="m-l-xs"><a href="'+base_url+'assignment/get_student_assignment/'+tbv.ID+'">'+tbv.name+'</a></span></td></td><td>'+tbv.total_marks+'</td><td>'+tbv.marks_obtained+'</td></tr>';
            });
            $('#assignment_history').html(tdata);
          }
          else{
            $('#assignment_history').html('<tr><td>No Assignment History Avaliable</td></tr>');
          }

          $('.file-box').each(function() {
              animationHover(this, 'pulse');
          });
        }
        else{
          bootbox.alert('Not Available');
        }
      }
    });
  });

</script>

