<link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
<form class="form-horizontal" role="form" action="<?php echo base_url('test/submit_test/'.$this->uri->segment(3)); ?>" method="post" id="submit_test">
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2><?php echo $data['package']; ?> - Test</h2>
      <ol class="breadcrumb">
        <li>
          <?php echo $data['subject']; ?>
        </li>
        <li>
          <?php echo $data['lesson']; ?>
        </li>
        <li class="font-bold">
          <a href="<?php echo base_url('dashboard/topic/'.@$data['link']); ?>"><?php echo $data['topic']; ?></a>
        </li>
        <li class="active">
          <?php echo $data['list']; ?>
        </li>
      </ol>
    </div>
    <div class="col-lg-4 hidden" id="timer">
      <div class="widget style1 red-bg">
        <div class="row">
          <div class="col-xs-4"> 
            <i class="fa fa-clock-o fa-4x"> </i> 
          </div>
          <div class="col-xs-8 text-right"> 
            <span> Time Left </span>
            <h2 class="font-bold">
              <span id="time"></span>
            </h2>
          </div>
        </div>
      </div>
    </div>
   
  </div>
   <div class="row wrapper white-bg">
      <div class="col-lg-12" id="test_detail"></div>
    </div>
  <div class="">
    <div class="row">
        <div class="col-sm-12 text-center">
          <div class="widget navy-bg" id="timer_view">
            <div class="" id="show_timer">
            </div>
          </div>
        </div>
          <div class="" id="show_result">
          </div>
          <div class="" id="show_test">
            <div class="row">

              <div class="col-md-12">
                <div class="ibox-content">
                  <div class="row">
                    <div class="col-lg-12 hidden" id="test_btn">
                        
                        <button type="button" id="start_test_btn" onclick="start_test()" class="button-group-addon btn-block btn-lg btn btn-success"> <i class="fa fa-play"> </i> Start Test</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
          </div>

          <div class="col-md-12 divider" id="test" style="display:none;">
          </div>
          <input type="hidden" id="count" value="0">
      <!-- </div> -->
    </div>
  </div>
</form>

<!-- Sweet Alert -->
<link href="<?php echo base_url('css/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/nestable/jquery.nestable.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/validate/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('js/formSerialize.js'); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    
    $.ajax({
      method:'POST',
      data:{'url_data':'<?php echo $this->uri->segment(3); ?>'},
      url:base_url+'test/get_test_time',
      error:function(err){
        bootbox.alert('Something Went Wrong');
      },
      success:function(res)
      {
        res = JSON.parse(res);
        // console.log(res);
        var eventTime= res; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
        var currentTime = Math.floor(Date.now() / 1000); // Timestamp - Sun, 21 Apr 2013 12:30:00 GMT
        var diffTime = eventTime - currentTime;
        var duration = moment.duration(diffTime*1000, 'milliseconds');
        var interval = 1000;
        var d = parseInt(diffTime);
        var y = setInterval(function(){
          d = d - (interval/1000);
          duration = moment.duration(duration - interval, 'milliseconds');
          if(d <= 0)
          {
            clearInterval(y);
            get_test_data();
          }
          else{
            // console.log(d);
              $('#show_timer').html("<span class='h3'>Time left for test : </span><span class='h1'>" + duration.months() + "</span> Month(s) <span class='h1'>" + duration.days() + "</span> Day(s) <span class='h1'>" + duration.hours() + "</span> Hour(s) <span class='h1'>" + duration.minutes() + "</span> Minute(s) <span class='h1'>" + duration.seconds() + "</span> Second(s)");
          }
        }, interval);
      }
    });

    $('#submit_test').validate();
    $("#submit_test").postAjaxData(function(result){
      if(typeof result === 'string')
      {
        window.location.href = '<?php echo base_url(); ?>'+'test/get_student_test/'+result;
      }
      else
      {
        swal({
          title: "Something Went Wrong",
          type: "error"
        });
      }
    });
  });

  
  function get_test_data()
  {
    $('#timer_view').addClass('hidden');
    $.ajax({
      method:'POST',
      data:{'url_data':'<?php echo $this->uri->segment(3); ?>'},
      url:base_url+'test/start_test',
      error:function(err){
        bootbox.alert('Something Went Wrong');
      },
      success:function(res)
      {
        res = JSON.parse(res);
        if(res != '0')
        {
          var test_detail = '<table class="table table-bordered"><tr><th>Exam Duration</th><td><span id="stime">'+res[0].exam_time+'</span> minutes</td><th>Total Marks</th><td>'+res[0].total_marks+' marks</td><th>Total No. of Questions </th><td>'+res[0].no_of_questions+' questions</td></tr></table>';
          $('#test_detail').html(test_detail);
          if(res[0].qn != undefined)
          {
            var i = 0;
            var data = '';
            $.each(res[0].qn,function(qk,qv){
              ++i;
              if(i == 1 && i != res[0].qn.length)
              {
                var display = 'block';
                var previous = 'disabled';
                var next = '';
                var finish = 'disabled';
                var previous_btn = '';
                var next_btn = 'onclick="next('+i+')"';
                var finish_btn = '';
              }
              else if(i > 1 && i == res[0].qn.length){
                var display = 'none';
                var previous = '';
                var next = 'disabled';
                var finish = '';
                var previous_btn = 'onclick="previous('+i+')"';
                var next_btn = '';
                var finish_btn = 'onclick="submit_test()"';
              }
              else if(i > 1 && i != res[0].qn.length){
                var display = 'none';
                var previous = '';
                var next = '';
                var finish = 'disabled';
                var previous_btn = 'onclick="previous('+i+')"';
                var next_btn = 'onclick="next('+i+')"';
                var finish_btn = '';
              }
              else if(i == 1 && i == res[0].qn.length)
              {
                var display = 'block';
                var previous = 'disabled';
                var next = 'disabled';
                var finish = '';
                var previous_btn = '';
                var next_btn = '';
                var finish_btn = 'onclick="submit_test()"';
              }
              data += '<div class="panel panel-success" id="div-'+i+'" style="display:'+display+'"> <div class="panel-heading"> <h3 class="text-white">Question '+i+' : '+qv.question+'</h3>';
              if(qv.question_path != '')
              {
                data += '<img width="100" class="img-responsive center-block" src="<?php echo PAATHSHALA_PATH; ?>'+qv.question_path+'">';
              }
              data += '<h5>(Correct : '+qv.correct_marks+' Marks | Leave : '+qv.blank_marks+' Marks | Incorrect : '+qv.wrong_marks+' Marks)</h5> </div>';
              if(qv.ans != undefined)
              {
                if(qv.type == 'single')
                {
                  data += '<p class="col-sm-12"><b>Choose only one correct answer.</b></p>';
                }
                if(qv.type == 'multiple')
                {
                  data += '<p class="col-sm-12"><b>Choose multiple correct answer.</b></p>';
                }
                if(qv.type == 'most_correct')
                {
                  data += '<p class="col-sm-12"><b>Drag &amp; Drop options to arrange in correct order.</b></p><br>';
                }

                if(qv.type == 'most_correct')
                {
                  data += '<div class="dd" id="nestable'+qv.ID+'"><ol class="dd-list">';
                }
                else{
                  data += '<ul class="todo-list m-t">';
                }
                var j = 1;
                $.each(qv.ans,function(ak,av){
                  if(qv.type == 'single')
                  {
                    data += '<li> <div class="radio"> <input type="radio" name="'+qv.ID+'" id="a_answer-'+av.ID+'" value="'+av.ID+'"> <label class="lbl" for="a_answer-'+av.ID+'"> '+j+') '+av.answer+' </label> ';
                    if(av.ans_path != '')
                    {
                      data += '<img width="100" class="img-responsive center-block" src="<?php echo PAATHSHALA_PATH; ?>'+av.ans_path+'">';
                    }
                    data += '</div></li>';
                  }
                  if(qv.type == 'multiple')
                  {
                    data += '<li><div class="checkbox"><input id="'+av.ID+'" type="checkbox" name="'+qv.ID+'[]" value="'+av.ID+'"><label class="lbl" for="'+av.ID+'"> '+j+') '+av.answer+' </label>';
                    if(av.ans_path != '')
                    {
                      data += '<img width="100" class="img-responsive center-block" src="<?php echo PAATHSHALA_PATH; ?>'+av.ans_path+'">';
                    }
                    data +='</div></li>';
                  }
                  if(qv.type == 'most_correct')
                  {
                    data += '<li class="dd-item" data-id="'+av.ID+'"><div class="dd-handle"> '+j+') '+av.answer+' ';
                    if(av.ans_path != '')
                    {
                      data += '<img width="100" class="img-responsive center-block" src="<?php echo PAATHSHALA_PATH; ?>'+av.ans_path+'">';
                    }
                    data +='</div></li>';
                  }
                  j++;
                });
                if(qv.type == 'most_correct')
                {
                  data += '</ol></div><textarea name="'+qv.ID+'" id="nestable-output'+qv.ID+'" class="form-control hidden"></textarea>';
                }
                else{
                  data += '</ul>';
                }
              }
              data += '<div class="ibox-title"><div class="row"> <div class="col-sm-4"><button type="button" '+previous+' '+previous_btn+' class="btn btn-block btn-success dim" > <i class="fa fa-backward"></i> Previous</button></div><div class="col-sm-4"><button type="button" '+next+' '+next_btn+' class="btn btn-block btn-success dim"> <i class="fa fa-forward"></i> Next</button></div><div class="col-sm-4"><button type="button" '+finish+' '+finish_btn+' class="btn btn-block btn-success dim"> <i class="fa fa-stop"></i> Finish</button></div></div></div></div>';

            });
            $('#test').html(data);
            $('#count').val(res[0].qn.length);
            $.each(res[0].qn,function(qk,qv){
              if(qv.type == 'most_correct'){
                $('#nestable'+qv.ID).nestable({
                   group: 1,
                   maxDepth:1
                }).on('change', updateOutput);
                updateOutput($('#nestable'+qv.ID).data('output', $('#nestable-output'+qv.ID)));
              }
            });
            start_test();
          }
        }
        else{
          bootbox.alert('No Test Available');
        }
      }
    });
  }
  function next(c)
  {
    var count = $('#count').val();
    ++c;
    for(var i = 1;i<=count;i++)
    {
      $('#div-'+i).hide();
    }
    $('#div-'+c).show();
  }

  function previous(c)
  {
    var count = $('#count').val();
    --c;
    for(var i = 1;i<=count;i++)
    {
      $('#div-'+i).hide();
    }
    $('#div-'+c).show();
  }

  function start_test()
  {
    $('#test').show();
    $('#show_test').hide();
    set_timer($('#stime').text());
    $('#timer').removeClass('hidden');
  }

  function set_timer(time)
  {
    var countDownDate = new Date().getTime() + time*60*1000;
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        document.getElementById("time").innerHTML = hours + ":"
        + minutes + ":" + seconds + "";
        
        // distance = distance - (60*1000);
        // If the count down is over, write some text 
        if(distance < 300*1000 && distance > 299*1000)
        {
          bootbox.alert('Hurry Up! Last 5 minutes left.');
        }
        if (distance < 0) {
            clearInterval(x);
            submit_test();
            document.getElementById("time").innerHTML = '00:00:00';
        }
    }, 1000);
  }

  var updateOutput = function (e) {
       var list = e.length ? e : $(e.target),
               output = list.data('output');
       if (window.JSON) {
           output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
       } else {
           output.val('JSON browser support required for this demo.');
       }
  };

  function submit_test()
  {
    $('#submit_test').submit();
  }
</script>