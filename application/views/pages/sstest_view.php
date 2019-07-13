<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang_library->translate('Navy MCQ\'s'); ?></title>
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/animate.css'); ?>" rel="stylesheet">
    
    <link href="<?php echo base_url('css/plugins/datapicker/datepicker3.css'); ?>" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="<?php echo base_url('css/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet">
    
    <!-- Mainly scripts -->

    <link href="<?php echo base_url('css/invoq.css'); ?>" rel="stylesheet">
    <!-- Chosen -->
    <link href="<?php echo base_url('css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/style.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('js/jquery-2.1.1.js'); ?>"></script>
    <!-- <link rel="stylesheet" href="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="<?php echo base_url('js/jquery.mobile-1.4.5.min.js'); ?>"></script> -->
        <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url('css/owl.carousel.css'); ?>">
 
    <!-- Default Theme -->
    <link rel="stylesheet" href="<?php echo base_url('css/owl.theme.css'); ?>">
    <link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
    <script type="text/javascript">
        base_url = '<?php echo base_url(); ?>';
    </script>     
  </head>
  <body id="fix-height" class="gray-bg fixed-sidebar mini-navbar">
    <div class="col-xs-12 white-bg shadow" id="timer">
      <div class="font-bold" id="exam_det"></div>
    </div>
    <form class="form-horizontal" role="form" action="<?php echo base_url('stest/submit_test'); ?>" method="post" id="submit_test">

      <div class="passwordBox animated fadeInDown" id="show_result">
          
      </div>
      <!-- <div class="passwordBox animated fadeInDown" id="show_test">
        <div class="row">

          <div class="col-md-12">
            <div class="ibox-content">

              <h2 class="font-bold">NAVY MCQ's</h2>

              <p>
                Please Select the Exam and Start Test.
              </p>

              <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                      <select class="form-control select-chosen input-lg" id="exam_ID" name="exam_ID" placeholder="Exam" required>
                        <option value=""> Please Select Exam</option>
                <?php //foreach($exam as $key=>$value){ ?>
                        <option value="<?php //echo $value['ID']; ?>"> <?php //echo $value['name']; ?> </option>
                <?php //} ?>
                      </select>
                    </div>
                    <div class="text-danger font-bold" id="error"></div>
                    <button type="button" id="start_test_btn" onclick="start_test()" class="button-group-addon btn-block btn btn-success"> <i class="fa fa-play"> </i> Start Test</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
      </div> -->

      <div class="col-md-12 divider" id="test">
      </div>
    </form>
    <input type="hidden" id="count" value="0">
  </body>
  <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
  <!-- Jquery Validate -->
  <script src="<?php echo base_url('js/plugins/validate/jquery.validate.min.js'); ?>"></script>
  <script src="<?php echo base_url('js/formSerialize.js'); ?>"></script>

  <!-- Chosen -->
  <script src="<?php echo base_url('js/plugins/chosen/chosen.jquery.js'); ?>"></script>

  <script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
  <script src="<?php echo base_url("js/plugins/slimscroll/jquery.slimscroll.min.js"); ?>"></script>
  <script src="<?php echo base_url("js/plugins/metisMenu/jquery.metisMenu.js"); ?>"></script>
  <!-- Custom and plugin javascript -->
  <script src="<?php echo base_url("js/inspinia.js"); ?>"></script>
  <script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>

  <script src="<?php echo base_url("js/owl.carousel.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("js/moment.min.js"); ?>"></script>
  <!-- Include Date Range Picker -->
  <script type="text/javascript" src="<?php echo base_url("js/daterangepicker.js"); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/daterangepicker.css"); ?>" />
  <script type="text/javascript">
    $(document).ready(function(){
      $('.select-chosen').chosen({width:'100%'});
      $('#submit_test').validate();
      $("#submit_test").postAjaxData(function(result){
        console.log(result);
        console.log(typeof result);
        if(typeof result == 'number')
        {
          var count = $('#count').val();
          var data = '<div class="row"> <div class="col-md-12"> <div class="ibox-content"><h2 class="font-bold">Your Result</h2><table class="table table-bordered"><tr><th>Total Marks  </th><td> '+$('#total_marks').text()+' </td></tr><tr><th>Marks Obtained  </th><td> '+parseInt($('#marks_qn').text())*parseInt(result)+'</td></tr></table></div></div></div>';
          $('#show_result').show().html(data);
          for(var i = 1;i<=count;i++)
          {
            $('#div-'+i).hide();
          }
          $('#show_test').hide();
          $('#exam_det').hide();
        }
        else
        {
          if(typeof result === 'object')
          {
            mess = "";
            $.each(result,function(dom,err)
            {
              mess = mess+err+"\n";
              swal("", mess, "error");
            });
            console.log(result);
          }
        }
      });
    });

    function start_test()
    {
      $.ajax({
        method:'POST',
        datatype:'JSON',
        data: {'ID':$('#exam_ID').val()},
        url: base_url+'/stest/start_test',
        error:function(err,status)
        {
          $('#error').html(err.responseText);
        },
        success:function(res)
        {
          var res = JSON.parse(res);
          if(typeof res == 'string')
          {
            $('#error').html(res);
          }
          else if(typeof res == 'object'){
            console.log(res);
            $('#show_test').hide();
            var data = '';
            var i = 0;
            $.each(res.mcq,function(k,v){
              ++i;
              if(i == 1 && i != res.mcq.length)
              {
                var display = 'block';
                var previous = 'disabled';
                var next = '';
                var finish = 'disabled';
                var previous_btn = '';
                var next_btn = 'onclick="next('+i+')"';
                var finish_btn = '';
              }
              else if(i > 1 && i == res.mcq.length){
                var display = 'none';
                var previous = '';
                var next = 'disabled';
                var finish = '';
                var previous_btn = 'onclick="previous('+i+')"';
                var next_btn = '';
                var finish_btn = 'onclick="submit_test()"';
              }
              else if(i > 1 && i != res.mcq.length){
                var display = 'none';
                var previous = '';
                var next = '';
                var finish = 'disabled';
                var previous_btn = 'onclick="previous('+i+')"';
                var next_btn = 'onclick="next('+i+')"';
                var finish_btn = '';
              }
              else if(i == 1 && i == res.mcq.length)
              {
                var display = 'block';
                var previous = 'disabled';
                var next = 'disabled';
                var finish = '';
                var previous_btn = '';
                var next_btn = '';
                var finish_btn = 'onclick="submit_test()"';
              }
              data += '<div class="panel panel-success" id="div-'+i+'" style="display:'+display+'"> <div class="panel-heading"> <h3 class="text-white">Question '+i+' : '+v.question+'</h3> </div><div class="panel-body"> <ul class="todo-list m-t"> <li> <div class="radio"> <input type="radio" name="'+v.ID+'" id="a_answer-'+v.ID+'" value="a"> <label class="lbl" for="a_answer-'+v.ID+'"> A) '+v.a+' </label> </div></li><li> <div class="radio"> <input type="radio" name="'+v.ID+'" id="b_answer-'+v.ID+'" value="b"> <label class="lbl" for="b_answer-'+v.ID+'"> B) '+v.b+' </label> </div></li><li> <div class="radio"> <input type="radio" name="'+v.ID+'" id="c_answer-'+v.ID+'" value="c"> <label class="lbl" for="c_answer-'+v.ID+'"> C) '+v.c+' </label> </div></li><li> <div class="radio"> <input type="radio" name="'+v.ID+'" id="d_answer-'+v.ID+'" value="d"> <label class="lbl" for="d_answer-'+v.ID+'"> D) '+v.d+' </label> </div></li></ul> </div><div class="ibox-title"><div class="row"> <div class="col-sm-4"><button type="button" '+previous+' '+previous_btn+' class="btn btn-block btn-success dim" > <i class="fa fa-backward"></i> Previous</button></div><div class="col-sm-4"><button type="button" '+next+' '+next_btn+' class="btn btn-block btn-success dim"> <i class="fa fa-forward"></i> Next</button></div><div class="col-sm-4"><button type="button" '+finish+' '+finish_btn+' class="btn btn-block btn-success dim"> <i class="fa fa-stop"></i> Finish</button></div></div></div></div>';
            });
            $('#test').html(data);
            $('#exam_det').html('<div class="row"><div class="col-sm-12 text-center h3"><u>'+res.data.name+'</u></div></div><div class="row"><div class="col-sm-8 h4"><table class="table table-bordered"><tr><th>No. of Questions </th><td>'+res.data.no_of_questions+'</td><th>Marks Per Question </th><td> <span id="marks_qn">'+res.data.marks_per_question+'</span> marks</td></tr><tr><th>Total Marks </th><td><span id="total_marks">'+(res.data.no_of_questions*res.data.marks_per_question)+'</span> marks</td><th>Duration</th><td>'+res.data.exam_time+' minutes</td></tr></table></div><div class="col-sm-4"><div class="widget style1 red-bg"> <div class="row"> <div class="col-xs-4"> <i class="fa fa-clock-o fa-5x"> </i></i> </div><div class="col-xs-8 text-right"> <span> Time Left </span> <h2 class="font-bold"><span id="time"></span></h2> </div></div></div>');
            $('#timer').show();
            set_timer(res.data.exam_time);
            $('#count').val(res.mcq.length);
          }
        }
      });
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

    function submit_test()
    {
      $('#submit_test').submit();
    }
  </script>
</html>