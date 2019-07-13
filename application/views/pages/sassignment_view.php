<link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
<form class="form-horizontal" role="form" action="<?php echo base_url('sassignment/submit_assignment/'.$this->uri->segment(3)); ?>" method="post" id="submit_test">
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2><?php echo $data['package']; ?> - Assignment</h2>
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
  </div>
   <div class="row wrapper white-bg">
      <div class="col-lg-12" id="test_detail"></div>
    </div>
  <div class="">
    <div class="row">
      <!-- <div class="col-sm-12 text-center"> -->
        

          <div class="" id="show_result">
          </div>
          <div class="" id="show_test">
            <div class="row">

              <div class="col-md-12">
                <div class="ibox-content">
                  <div class="row">
                    <div class="col-lg-12">
                        
                        <button type="button" id="start_test_btn" onclick="start_test()" class="button-group-addon btn-block btn btn-lg btn-success"> <i class="fa fa-play"> </i> START ASSIGNMENT</button>
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
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/nestable/jquery.nestable.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/validate/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('js/formSerialize.js'); ?>"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
      method:'POST',
      data:{'url_data':'<?php echo $this->uri->segment(3); ?>'},
      url:base_url+'sassignment/start_assignment',
      error:function(err){
        bootbox.alert('Something Went Wrong');
      },
      success:function(res)
      {
        res = JSON.parse(res);
        if(res != '0')
        {
          var test_detail = '';
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
              data += '<h5>(Correct : '+qv.correct_marks+' Marks | Leave : '+qv.blank_marks+' Marks | Incorrect : '+qv.wrong_marks+' Marks)</h5></div>';
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
                  data += '<p class="col-sm-12"><b>Drag &amp; Drop options to arrange in most correct order.</b></p><br>';
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
          }
        }
        else{
          bootbox.alert('No Test Available');
        }
      }
    });
    
    $('#submit_test').validate();
    $("#submit_test").postAjaxData(function(result){
      if(typeof result === 'string')
      {
        window.location.href = '<?php echo base_url(); ?>'+'sassignment/get_student_assignment/'+result;
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