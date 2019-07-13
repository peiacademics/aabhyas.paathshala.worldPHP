<link href="<?php echo base_url('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>" rel="stylesheet">
<div class="col-xs-12 white-bg shadow">
    <h2 class="text-center"><?php echo @$breadcrumb['heading']; ?> </h2>
    <ol class="breadcrumb text-center">
        <?php
        if(isset($breadcrumb['route']))
        { 
            foreach ($breadcrumb['route'] as $route)
            {
                if(is_array($route))
                {
                    echo "<li><a href=".base_url($route['path']).">".$route['title']."</a></li>";
                }
                else
                {
                    echo "<li class='active'><strong>".$route."</strong></li>";
                }
            }
        }
        ?>

        </li>
    </ol>
    <hr>
    <div class="float-e-margins">
              <h4 id="success" style="text-align:center;"></h4>
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('exams/add'); ?>" method="post" id="exam_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">

                        <div class="form-group">
                            <label  class="col-sm-3 control-label">Name : </label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control required" id="Name" placeholder="Name" name="name" value="<?php echo @$View['name']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label">No. of Questions in Exams: </label>
                            <div class="col-sm-6">
                              <input type="number" class="form-control required" id="noq" placeholder="Enter no. of questions in exams" name="no_of_questions" value="<?php echo @$View['no_of_questions']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label">Marks per Question in Exams: </label>
                            <div class="col-sm-6">
                              <input type="number" class="form-control required" id="mpq" placeholder="Enter Marks per Question in Exams" name="marks_per_question" value="<?php echo @$View['marks_per_question']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-sm-3 control-label">Exam Duration (in Minutes): </label>
                            <div class="col-sm-6">
                              <input type="number" class="form-control required" id="ed" placeholder="Enter Exam Duration (in Minutes)" name="exam_time" value="<?php echo @$View['exam_time']; ?>">
                            </div>
                        </div>
                        <div class="panel-group col-sm-12" id="accordion1">
              <?php //echo "<pre>";print_r($View);echo "</pre>";
                    if(!empty(@$View['qa']))
                    {
                      $i = 0;
                      foreach(@$View['qa'] as $key=>$value){
                        ++$i;
              ?>
                        <div class="panel panel-primary" id="div-<?php echo $value['ID']; ?>">
                          <div class="panel-heading">
                              <input type="hidden" name="QA-ID-<?php echo $i; ?>" value="<?php echo $value['ID']; ?>">
                              <h4 class="text-white">Question <?php echo $i; ?> </h4><div class="pull-right"><button type="button" onclick="remove_div('<?php echo $value['ID']; ?>','<?php echo $i; ?>')" class="btn btn-primary btn-xs"> <i class="fa fa-remove"></i> Remove</button>&nbsp;&nbsp;&nbsp; <button data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $i; ?>" class="collapsed btn btn-primary btn-xs" aria-expanded="false"> <i class="fa fa-plus"></i> Add Answers </button></div>
                              
                              <textarea name="QA-question-<?php echo $i; ?>" class="blck-bg form-control required"><?php echo $value['question']; ?></textarea>
                          </div>
                          <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
                            <div class="panel-body blck-bg">
                                <ul class="todo-list m-t small-list ui-sortable">
                                    <li>
                                        <div class="radio">
                                            <input type="radio" name="QA-answer-<?php echo $i; ?>" id="answer-<?php echo $i; ?>" value="a" required <?php echo ($value['answer'] == 'a') ? 'checked':''; ?>>
                                            <label class="lbl" for="radio<?php echo $i; ?>">
                                                <input type="text" class="form-control required" name="QA-a-<?php echo $i; ?>" value="<?php echo $value['a']; ?>"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio">
                                            <input type="radio" name="QA-answer-<?php echo $i; ?>" id="answer-<?php echo $i; ?>" value="b" <?php echo ($value['answer'] == 'b') ? 'checked':''; ?>> 
                                            <label class="lbl" for="radio<?php echo $i; ?>">
                                                <input type="text" class="form-control required" name="QA-b-<?php echo $i; ?>" value="<?php echo $value['b']; ?>"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio">
                                            <input type="radio" name="QA-answer-<?php echo $i; ?>" id="answer-<?php echo $i; ?>" value="c" <?php echo ($value['answer'] == 'c') ? 'checked':''; ?>>
                                            <label class="lbl" for="radio<?php echo $i; ?>">
                                                <input type="text" class="form-control required" name="QA-c-<?php echo $i; ?>" value="<?php echo $value['c']; ?>"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio">
                                            <input type="radio" name="QA-answer-<?php echo $i; ?>" id="answer-<?php echo $i; ?>" value="d" <?php echo ($value['answer'] == 'd') ? 'checked':''; ?>>
                                            <label class="lbl" for="radio<?php echo $i; ?>">
                                                <input type="text" class="form-control required" name="QA-d-<?php echo $i; ?>" value="<?php echo $value['d']; ?>"> </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                          </div>
                        </div>
              <?php   }
                    }
              ?>        
                        </div>
                        <div id="mcq_div" class="panel-group col-sm-12" id="accordion">
                              <!-- <div class="ibox float-e-margins">
                                <div class="ibox-title blck-bg">
                                  <h4 class="text-white">Question '+c+'</h4>
                                  <textarea name="question-'+c+'" class="form-control"></textarea>
                                </div>
                                <div class="ibox-content blck-bg">
                                  <ul class="todo-list m-t">
                                    <li>
                                      <div class="radio">
                                        <input type="radio" name="answer-'+c+'" id="answer-'+c+'" value="a" required>
                                        <label class="lbl" for="radio'+c+'">
                                          <input type="text" class="form-control" name="a-'+c+'">
                                        </label>
                                      </div>
                                    </li>
                                    <li>
                                      <div class="radio">
                                        <input type="radio" name="answer-'+c+'" id="answer-'+c+'" value="b" required>
                                        <label class="lbl" for="radio'+c+'">
                                          <input type="text" class="form-control" name="b-'+c+'">
                                        </label>
                                      </div>
                                    </li>
                                    <li>
                                      <div class="radio">
                                        <input type="radio" name="answer-'+c+'" id="answer-'+c+'" value="c" required>
                                        <label class="lbl" for="radio'+c+'">
                                          <input type="text" class="form-control" name="c-'+c+'">
                                        </label>
                                      </div>
                                    </li>
                                    <li>
                                      <div class="radio">
                                        <input type="radio" name="answer-'+c+'" id="answer-'+c+'" value="d" required>
                                        <label class="lbl" for="radio'+c+'">
                                          <input type="text" class="form-control" name="d-'+c+'">
                                        </label>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div> -->
                        </div>
                        <div class="col-sm-offset-3 col-sm-6">
                          <button type="button" id="add_questions" class="btn btn-info font-bold btn-block"> <i class="fa fa-plus"></i> Add Multiple Choice Questions</button>
                        </div>
                        <!-- <br> -->
                        <input type="hidden" id="count" value="<?php echo !empty(@$View['qa']) ? count($View['qa']) : 0; ?>">
                        <input type="hidden" name="num_rows" value="<?php echo !empty(@$View['qa']) ? count($View['qa']) : 0; ?>">
                        <div class="form_footer">
                        	<div class="row">
                            	<div class="col-md-6 text-center col-md-offset-3 ">
                                  <br>
                                  <button type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update Exam' : 'Add Exam'; ?></button>
                              </div>
                      	  </div>
                        </div>
                    </form> 
            </div>
</div>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Chosen -->
<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
<!-- Date -->
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

<script type="text/javascript">
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    $('.lbl').attr('style','width:100% !important');
    $("#exam_add").postAjaxData(function(result){
      console.log(result);
      if(typeof result == 'string')
      {
        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
        swal({
            title: 'Done',
            text: 'Successfully '+type+'.',
            type: "success"               
          },
            function()
            {
              window.location.href = "<?php echo base_url('exams/add'); ?>/"+result;
            }
        );
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


    $("#exam_add").validate();

    $('#add_questions').on('click',function(){
      var c = $('#count').val();
      ++c;
      $('#mcq_div').append('<div class="panel panel-primary" id="div-'+c+'"><div class="panel-heading"> <h4 class="">Question '+c+' </h4> <div class=" pull-right"><button type="button" onclick="remove_d('+c+')" class="btn btn-primary btn-xs"> <i class="fa fa-remove"></i> Remove</button>&nbsp;&nbsp;&nbsp;<button data-toggle="collapse" data-parent="#accordion" href="#collapse'+c+'" class="collapsed btn btn-primary btn-xs" aria-expanded="false"> <i class="fa fa-plus"></i> Add Answers </button></div> <textarea name="QA-question-'+c+'" class="blck-bg form-control required"></textarea> </div></a><div id="collapse'+c+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"><div class="panel-body"><ul class="todo-list m-t small-list ui-sortable"> <li> <div class="radio"> <input type="radio" name="QA-answer-'+c+'" id="answer-'+c+'" value="a"> <label class="lbl" for="radio'+c+'"> <input type="text" class="form-control required" name="QA-a-'+c+'"> </label> </div></li><li> <div class="radio"> <input type="radio" name="QA-answer-'+c+'" id="answer-'+c+'" value="b"> <label class="lbl" for="radio'+c+'"> <input type="text" class="form-control required" name="QA-b-'+c+'"> </label> </div></li><li> <div class="radio"> <input type="radio" name="QA-answer-'+c+'" id="answer-'+c+'" value="c"> <label class="lbl" for="radio'+c+'"> <input type="text" class="form-control required" name="QA-c-'+c+'"> </label> </div></li><li> <div class="radio"> <input type="radio" name="QA-answer-'+c+'" id="answer-'+c+'" value="d"> <label class="lbl" for="radio'+c+'"> <input type="text" class="form-control required" name="QA-d-'+c+'"> </label> </div></li></ul> </div></div></div></div>');
      $('#count').val(c);
      $('.lbl').attr('style','width:100% !important');
    });
  });

  function remove_div(id,i)
  {
    $('#div-'+id).addClass('hidden').append('<input type="hidden" name="QA-Status-'+i+'" value="D">');
  }

  function remove_d(i)
  {
    $('#div-'+i).remove();
  }  
</script>