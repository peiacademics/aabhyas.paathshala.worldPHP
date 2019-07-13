<script src="<?php echo base_url('js/plugins/iCheck/icheck.min.js');?>"></script>
<div class="ibox">
  <!-- <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Abhyas MCQ')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div> -->
  <div class="ibox-content">
    <div class="page-content">
        <div class="wrap">
          <h4 id="success" style="text-align:center;"></h4>
                <form class="form-horizontal" role="form" action="<?php echo base_url('Abhyas_mcq/add'); ?>" method="post" id="bank_add">
                    <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Subject: </label>
                        <div class="col-sm-6">
                          <select class="form-control select-chosen" onChange="get_lesson()" id="subject_ID" name="subject_ID"  placeholder="Subject" required>
                          </select>
                        </div>
                          <span id="sub_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Lesson : </label>
                        <div class="col-sm-6">
                          <select class="form-control select-chosen" id="lesson_ID" name="lesson_ID" onChange="get_topic()" placeholder="Lesson" required>
                            <option selected disabled>Select</option>
                          </select>
                        </div>
                          <span id="les_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Topic : </label>
                        <div class="col-sm-6">
                          <select class="form-control select-chosen" id="topic_ID" name="topic_ID" placeholder="Topic" required>
                            <option selected disabled>Select</option>
                          </select>
                        </div>
                          <span id="tp_ID"></span>
                    </div>

                     <div class="form-group">
                          <label class="col-sm-3 control-label">Name : </label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo @$View['name']; ?>" required>
                          </div>
                            <span id="Name"></span>
                      </div>

                      <div class="form-group">
                          <label class="col-sm-3 control-label">Description : </label>
                          <div class="col-sm-6">
                             <textarea class="form-control" name="description" placeholder="Description"><?php echo @$View['description']; ?></textarea>
                          </div>
                            <span id="description"></span>
                      </div>

                      <!-- <div class="form-group">
                          <label  class="col-sm-3 control-label">Number of Questions : </label>
                          <div class="col-sm-3">
                            <input type="number" class="form-control" id="no_of_questions" placeholder="Number of Questions" name="no_of_questions" value="<?php //echo @$View['no_of_questions']; ?>" min="0" required>
                          </div>
                          <label  class="col-sm-3 control-label">Time for examination : </label>
                          <div class="col-sm-3">
                            <input type="number" class="form-control" id="exam_time" placeholder="Enter minutes" name="exam_time" value="<?php //echo @$View['exam_time']; ?>" min="0" required>
                          </div>
                      </div>

                      <div class="form-group">
                          <label  class="col-sm-3 control-label">Maximum Marks : </label>
                          <div class="col-sm-3">
                            <input type="number" class="form-control" id="max_marks" placeholder="Max Marks" name="max_marks" value="<?php //echo @$View['max_marks']; ?>" min="0" required>
                          </div>
                          <label  class="col-sm-3 control-label">Passing Marks : </label>
                          <div class="col-sm-3">
                            <input type="number" class="form-control" id="min_marks" placeholder="Passing Marks" name="min_marks" value="<?php //echo @$View['min_marks']; ?>" min="0" required>
                          </div>
                      </div> -->

                      <!-- <pre><?php //var_dump($View); ?></pre> -->

                      <input type="hidden" id="question_no" value="<?php echo (count(@$View['question']) > '0') ? count(@$View['question']) : '0' ?>">
                      <div id="questions" class="form-group">
                        <?php if(count(@$View['question']) > '0') {
                          $i = 1;
                          foreach (@$View['question'] as $keyq => $valueq) { ?>
                            <div id="question_div-<?php echo $i; ?>" class="panel-body" style="border: 1px solid #e7eaec;background-color: #ecf0f1 !important">
                              <br>
                              <div class="form-group col-sm-12">
                                <label class="control-label  col-sm-2">Question - <?php echo $i; ?> : </label>
                                <input type="hidden" name="ID-<?php echo $i; ?>" value="<?php echo @$valueq['ID']; ?>">
                                <div class="col-sm-10 form-group">
                                  <textarea class="form-control bg-white" name="question-<?php echo $i; ?>" placeholder="Enter Question" rows="5"><?php echo @$valueq['question']; ?></textarea>
                                </div>
                              </div>
                              <div class="form-group col-sm-12">
                                <label class="control-label  col-sm-2">Question Type : </label>
                                <div class="form-group col-sm-2">
                                  <select class="form-control select-chosen" id="type-<?php echo $i; ?>" name="type-<?php echo $i; ?>" placeholder="Type" onChange="change_type('<?php echo $i; ?>');">
                                    <option selected disabled value="null"  <?php echo (@$valueq['type'] == 'null') ? 'selected' :''; ?>>Type</option>
                                    <option value="single" <?php echo (@$valueq['type'] == 'single') ? 'selected' :''; ?>>Single</option>
                                    <option value="multiple" <?php echo (@$valueq['type'] == 'multiple') ? 'selected' :''; ?>>Multiple</option>
                                    <option value="most_correct" <?php echo (@$valueq['type'] == 'most_correct') ? 'selected' :''; ?>>Most Correct</option>
                                  </select>
                                </div>
                                <div class="col-sm-5 fileinput fileinput-new" data-provides="fileinput">
                                  <span class="btn btn-success btn-rounded btn-file" data-toggle="tooltip" title="Upload Question Image">
                                    <span class="fileinput-new">Path</span>
                                    <span class="fileinput-exists">Upload</span>
                                    <input type="file" value="deepak" name=".." onChange="uploadQ(this,'<?php echo $i; ?>')"/>
                                  </span>
                                  <label class="control-label fileinput-filename text-danger" id="question_img-<?php echo $i; ?>"><?php echo (@$valueq['question_path'] != NULL) ? @$valueq['question_path'] :'Path'; ?></label>
                                  <input type="hidden" id="question_path-<?php echo $i; ?>" name="question_path-<?php echo $i; ?>" value="<?php echo @$valueq['question_path']; ?>">
                                </div>
                                <div class="col-sm-3">
                                  <button type="button" class="btn btn-sm btn-warning" onClick="add_answer('<?php echo $i; ?>')" data-toggle="tooltip" title="Add Answers">Add Answer</button> 
                                  <button type="button" class="btn btn-sm btn-danger" onClick="delete_question('<?php echo @$valueq['ID']; ?>','<?php echo $i; ?>')" data-toggle="tooltip" title="Remove Question">Remove Question</button>
                                </div>
                              </div>
                              <div class="form-group col-sm-12">
                                <label class="control-label  col-sm-2">Explanation - <?php echo $i; ?> : </label>
                                <div class="col-sm-10 form-group">
                                  <textarea class="form-control bg-white" name="explanation-<?php echo $i; ?>" placeholder="Enter Explanation" rows="5"><?php echo @$valueq['explanation']; ?></textarea>
                                </div>
                              </div>
                              <div class="form-group col-sm-12">
                                <label class="control-label  col-sm-2">Correct Marks : </label>
                                <div class="col-sm-2 form-group">
                                  <input type="number" class="form-control bg-white" name="correct_marks-<?php echo $i; ?>" placeholder="Correct Marks" min="0" value="<?php echo @$valueq['correct_marks'] ?>">
                                </div>
                                <label class="control-label  col-sm-2">Blank Marks : </label>
                                <div class="col-sm-2 form-group">
                                  <input type="number" class="form-control bg-white" name="blank_marks-<?php echo $i; ?>" placeholder="Blank Marks" min="0" value="<?php echo @$valueq['blank_marks'] ?>">
                                </div>
                                <label class="control-label  col-sm-2">Incorrect Marks : </label>
                                <div class="col-sm-2 form-group">
                                  <input type="number" class="form-control bg-white" name="wrong_marks-<?php echo $i; ?>" placeholder="Incorrect Marks" min="-10" value="<?php echo @$valueq['wrong_marks'] ?>">
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div id="answer_div-<?php echo $i; ?>" class="row">
                                  <?php if(count(@$valueq['answer']) > '0') {
                                    $j = 1;
                                    foreach(@$valueq['answer'] as $keya => $valuea) { ?>
                                      <div id="answerSK<?php echo $j; ?>-<?php echo $i; ?>" class="row">
                                        <label class="control-label  i-checks col-sm-2">  Answer-<?php echo $j; ?> : 
                                          <input type="checkbox" name="correctSK<?php echo $j; ?>-<?php echo $i; ?>" id="correctSK<?php echo $j; ?>-<?php echo $i; ?>" value="Completed" <?php echo ($valuea['correct'] == 'yes') ? 'checked' :''; ?>> Correct
                                        </label>
                                        <input type="hidden" name="IDSK<?php echo $j; ?>-<?php echo $i; ?>" value="<?php echo $valuea['ID']; ?>">
                                        <div class="form-group col-sm-2">
                                          <select class="form-control" id="order_seqSK<?php echo $j; ?>-<?php echo $i; ?>" name="order_seqSK<?php echo $j; ?>-<?php echo $i; ?>" placeholder="Order">
                                            <option <?php echo ($valuea['order_seq'] == 'null') ? 'selected' :''; ?>>Correct Order</option>
                                            <option value="1" <?php echo ($valuea['order_seq'] == '1') ? 'selected' :''; ?>>1</option>
                                            <option value="2" <?php echo ($valuea['order_seq'] == '2') ? 'selected' :''; ?>>2</option>
                                            <option value="3" <?php echo ($valuea['order_seq'] == '3') ? 'selected' :''; ?>>3</option>
                                            <option value="4" <?php echo ($valuea['order_seq'] == '4') ? 'selected' :''; ?>>4</option>
                                            <option value="5" <?php echo ($valuea['order_seq'] == '5') ? 'selected' :''; ?>>5</option>
                                            <option value="6" <?php echo ($valuea['order_seq'] == '6') ? 'selected' :''; ?>>6</option>
                                            <option value="7" <?php echo ($valuea['order_seq'] == '7') ? 'selected' :''; ?>>7</option>
                                            <option value="8" <?php echo ($valuea['order_seq'] == '8') ? 'selected' :''; ?>>8</option>
                                            <option value="9" <?php echo ($valuea['order_seq'] == '9') ? 'selected' :''; ?>>9</option>
                                            <option value="10" <?php echo ($valuea['order_seq'] == '10') ? 'selected' :''; ?>>10</option>
                                          </select>
                                        </div>
                                        <!-- <label class="control-label col-sm-1 ">Text</label> -->
                                        <div class="col-sm-4 form-group">
                                          <textarea class="form-control bg-white" name="answerSK<?php echo $j; ?>-<?php echo $i; ?>" placeholder="Enter Answer"><?php echo $valuea['answer']; ?></textarea>
                                        </div>
                                        <div class="col-sm-3 fileinput fileinput-new" data-provides="fileinput">
                                          <span class="btn btn-success btn-rounded btn-file" data-toggle="tooltip" title="Upload Answer Image">
                                            <span class="fileinput-new">Path</span>
                                            <span class="fileinput-exists">Upload</span>
                                            <input type="file" value="deepak" name=".." onChange="uploadA(this,'<?php echo $j; ?>','<?php echo $i; ?>')"/>
                                          </span>
                                          <label class="control-label fileinput-filename text-danger" id="answer_imgSK<?php echo $j; ?>-<?php echo $i; ?>"><?php echo @$valuea['ans_path']; ?></label>
                                          <input type="hidden" id="ans_pathSK<?php echo $j; ?>-<?php echo $i; ?>" name="ans_pathSK<?php echo $j; ?>-<?php echo $i; ?>" value="<?php echo @$valuea['ans_path']; ?>">
                                        </div>
                                        <div class="form-group col-sm-1">
                                          <button type="button" class="btn btn-circle btn-sm btn-default" onClick="delete_answer('<?php echo $valuea['ID']; ?>','<?php echo $i; ?>','<?php echo $j; ?>')" data-toggle="tooltip" title="Remove Answers"><i class="fa fa-minus"></i></button>
                                        </div>
                                      </div>
                                  <?php $j++; } } ?>
                                </div>
                              </div>
                            </div>
                            <input type="hidden" id="ans_no-<?php echo $i; ?>" value="<?php echo (count(@$valueq['answer']) > '0') ? count(@$valueq['answer']) : '0' ?>">
                          <script type="text/javascript">
                            $('.i-checks').iCheck({
                              checkboxClass: 'icheckbox_square-green',
                              radioClass: 'iradio_square-green',
                            });
                          </script>
                        <?php $i++; } } ?>
                      </div>

                      <div class="form_group">
                        <div class="row">
                          <div class="col-md-6 text-center col-md-offset-3 ">
                            <button type="button" class="btn btn-success" onClick="add_question();">Add Question</button>
                          </div>
                        </div>
                      </div>
     					</div>
                      <br>
                    	<div class="form_footer">
                    	<div class="row">
                        	<div class="col-md-6 text-center col-md-offset-3 ">
                                    <button type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>
                                </div>
                        	</div>

                        </form> 
                    

        </div>
    </div>
  </div>
</div>

<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    
    $("#bank_add").postAjaxData(function(result){
      if(result === 1)
      {
        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully '+type+'.');
        setTimeout(function(){
          window.location.href = "<?php echo current_url(); ?>";
        }, 3000);
      }
      else
      {
        if(typeof result === 'object')
        {
          mess = "";
          $.each(result,function(dom,err)
          {
            mess = mess+err+"\n";
            toastr.error(mess);
          });
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
    $("#bank_add").validate();
  });

  var subject_ID = '<?php echo @$View['subject_ID']; ?>';
  if(subject_ID != '')
  {
    var lesson_ID = '<?php echo @$View['lesson_ID']; ?>';
    getChosenData('lesson_ID','LS',[{'label':'name','value':'ID'}],[{'Status':'A','subject_ID':subject_ID}],'<?php echo @$View['lesson_ID']?>');
    getChosenData('topic_ID','TP',[{'label':'name','value':'ID'}],[{'Status':'A','lesson_ID':lesson_ID,'subject_ID':subject_ID}],'<?php echo @$View['topic_ID']?>');
  }
  getChosenData('subject_ID','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['subject_ID']?>');
  function get_lesson()
  {
    var subject_ID = $('#subject_ID').val();
    getChosenData('lesson_ID','LS',[{'label':'name','value':'ID'}],[{'Status':'A','subject_ID':subject_ID}],'<?php echo @$View['lesson_ID']?>');
  }

  function get_topic()
  {
    var subject_ID = $('#subject_ID').val();
    var lesson_ID = $('#lesson_ID').val();
    getChosenData('topic_ID','TP',[{'label':'name','value':'ID'}],[{'Status':'A','lesson_ID':lesson_ID,'subject_ID':subject_ID}],'<?php echo @$View['topic_ID']?>');
  }

  function add_question()
  {
    var q_data = '';
    var q_cnt = $('#question_no').val();
    q_cnt++;
    q_data += '<div id="question_div-'+q_cnt+'" class="panel-body" style="border: 1px solid #e7eaec;background-color: #ecf0f1 !important"><br><div class="form-group col-sm-12"><label class="control-label  col-sm-2">Question - '+q_cnt+' : </label><input type="hidden" name="ID-'+q_cnt+'" value=""><div class="col-sm-10 form-group"><textarea class="form-control bg-white" name="question-'+q_cnt+'" placeholder="Enter Question" rows="5"></textarea></div></div><div class="form-group col-sm-12"><label class="control-label  col-sm-2">Question Type : </label><div class="form-group col-sm-2"><select class="form-control select-chosen" id="type-'+q_cnt+'" name="type-'+q_cnt+'" placeholder="Type" onChange="change_type('+q_cnt+');" required><option selected disabled value="NULL">Type</option><option value="single">Single</option><option value="multiple">Multiple</option><option value="most_correct">Most Correct</option></select></div><div class="col-sm-5 fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-success btn-rounded btn-file" data-toggle="tooltip" title="Upload Question Image"><span class="fileinput-new">Image</span><span class="fileinput-exists">Upload</span><input type="file" value="deepak" name=".." onChange="uploadQ(this,'+q_cnt+')"/></span><label class="control-label fileinput-filename text-danger" id="question_img-'+q_cnt+'">Path</label><input type="hidden" id="question_path-'+q_cnt+'" name="question_path-'+q_cnt+'"></div><div class="col-sm-3"><button type="button" class="btn btn-sm btn-warning" onClick="add_answer('+q_cnt+')" data-toggle="tooltip" title="Add Answers">Add Answer</button>  <button type="button" class="btn btn-sm btn-danger" onClick="delete_q('+q_cnt+')" data-toggle="tooltip" title="Remove Question">Remove Question</button></div></div><div class="form-group col-sm-12"><label class="control-label  col-sm-2">Explanation : </label><div class="col-sm-10 form-group"><textarea class="form-control bg-white" name="explanation-'+q_cnt+'" placeholder="Enter Explanation" rows="5"></textarea></div></div><div class="form-group col-sm-12"><label class="control-label  col-sm-2">Correct Marks : </label><div class="col-sm-2 form-group"><input type="number" class="form-control bg-white" name="correct_marks-'+q_cnt+'" placeholder="Correct Marks" min="0" value="4"></div><label class="control-label  col-sm-2">Blank Marks : </label><div class="col-sm-2 form-group"><input type="number" class="form-control bg-white" name="blank_marks-'+q_cnt+'" placeholder="Blank Marks" min="-10" value="0"></div><label class="control-label  col-sm-2">Incorrect Marks : </label><div class="col-sm-2 form-group"><input type="number" class="form-control bg-white" name="wrong_marks-'+q_cnt+'" placeholder="Incorrect Marks" min="-10" value="-1"></div></div><div class="col-sm-12"><div id="answer_div-'+q_cnt+'" class="row"></div></div></div><input type="hidden" id="ans_no-'+q_cnt+'" value="0"></div></div>';
    $('#question_no').val(q_cnt);
    $('#questions').append(q_data);
    $('[data-toggle="tooltip"]').tooltip(); 
  }

  function add_answer(cnt)
  {
    var a_data = '';
    var a_cnt = $('#ans_no-'+cnt).val();
    console.log(a_cnt);
    a_cnt++;
    console.log(a_cnt);
    a_data += '<div id="answerSK'+a_cnt+'-'+cnt+'" class="row"><label class="control-label  i-checks col-sm-3">Answer-'+a_cnt+' : <input type="checkbox" name="correctSK'+a_cnt+'-'+cnt+'" id="correctSK'+a_cnt+'-'+cnt+'"> Correct</label><input type="hidden" name="IDSK'+a_cnt+'-'+cnt+'" value=""><div class="form-group col-sm-2"><select class="form-control" id="order_seqSK'+a_cnt+'-'+cnt+'" name="order_seqSK'+a_cnt+'-'+cnt+'" placeholder="Order" disabled><option selected value="NULL">Correct Order</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></div><!-- <label class="control-label col-sm-1 ">Text</label> --><div class="col-sm-4 form-group"><textarea class="form-control bg-white" name="answerSK'+a_cnt+'-'+cnt+'" placeholder="Enter Answer"></textarea></div><div class="col-sm-3 fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-success btn-rounded btn-file" data-toggle="tooltip" title="Upload Answer Image"><span class="fileinput-new">Image</span><span class="fileinput-exists">Upload</span><input type="file" value="deepak" name=".." onChange="uploadA(this,'+a_cnt+','+cnt+')"/></span><label class="control-label fileinput-filename text-danger" id="answer_imgSK'+a_cnt+'-'+cnt+'">Path</label><input type="hidden" id="ans_pathSK'+a_cnt+'-'+cnt+'" name="ans_pathSK'+a_cnt+'-'+cnt+'"></div><div class="form-group col-sm-1"><button type="button" class="btn btn-circle btn-sm btn-default" onClick="delete_a('+cnt+','+a_cnt+')" data-toggle="tooltip" title="Remove Answers"><i class="fa fa-minus"></i></button></div></div>';
    $('#ans_no-'+cnt).val(a_cnt);
    console.log(a_cnt);
    $('#answer_div-'+cnt).append(a_data);
    change_type(cnt);
    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
    });

    var ans_cnts = $('#ans_no-'+cnt).val();
    $('#answer_div-'+cnt).find('input[type="checkbox"]').iCheck('uncheck');
    for(var ids=1; ids<=ans_cnts; ids++)
    {
      $('#correctSK'+ids+'-'+cnt).on('ifChecked', function (event) {
        var type1 = $("#type-"+cnt).val();
        if((type1 == 'single') || (type1 == 'most_correct'))
        {
          toastr.error("Please select one option for this Question type !");
        }
      });
    }
    $('[data-toggle="tooltip"]').tooltip(); 
  }

  function delete_q(q_no)
  {
    var d = $("#question_no").val();
    var k = --d;
    $("#question_no").val(k);
    $('#question_div-'+q_no).remove();
    $('#question_div-'+q_no).html('');
  }

  function delete_a(q_no,a_no)
  {
    var e = $("#ans_no-"+q_no).val();
    var l = --e;
    $("#ans_no-"+q_no).val(l);
    $('#answer-'+q_no+'-'+a_no).remove();
    $('#answer-'+q_no+'-'+a_no).html('');
  }

  function uploadQ(f,q_cnt)
  {
    toastr.options = {
      timeOut:0,
    };
    toastr.warning('<i class="fa fa-spinner fa-spin"></i> UPLOADING...',{timeOut: 0});
    var file_data = $(f).prop('files')[0]; 
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
      datatype:'text',
      data:form_data,
      type:'POST',
      cache: false,
      contentType: false,
      processData: false,
      url: '<?php echo base_url("Abhyas_mcq/upload_Q");?>',
      success:function(response)
      {
        if (typeof response === 'string')
        {
          if(response != '')
          {
            response = JSON.parse(response);
            $('#question_path-'+q_cnt).val(response);
            toastr.clear();
            toastr.options = {
              "closeButton": true,
              positionClass:'toast-bottom-right',
              showMethod: 'slideDown',
              "progressBar": true,
              tapToDismiss : true,
              timeOut: 5000
            };
            toastr.success('File Uploaded');
          }
          else
          {
            toastr.error("Please upload PDF only!");
          }
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  }

  function uploadA(f,a_cnt,q_cnt)
  {
    toastr.options = {
      timeOut:0,
    };
    toastr.warning('<i class="fa fa-spinner fa-spin"></i> UPLOADING...',{timeOut: 0});
    var file_data = $(f).prop('files')[0]; 
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
      datatype:'text',
      data:form_data,
      type:'POST',
      cache: false,
      contentType: false,
      processData: false,
      url: '<?php echo base_url("Abhyas_mcq/upload_A");?>',
      success:function(response)
      {
        if (typeof response === 'string')
        {
          if(response != '')
          {
            response = JSON.parse(response);
            $('#ans_pathSK'+a_cnt+'-'+q_cnt).val(response);
            toastr.clear();
            toastr.options = {
              "closeButton": true,
              positionClass:'toast-bottom-right',
              showMethod: 'slideDown',
              "progressBar": true,
              tapToDismiss : true,
              timeOut: 5000
            };
            toastr.success('File Uploaded');
          }
          else
          {
            toastr.error("Please upload PDF only!");
          }
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  }

  function change_type(q_cnt)
  {
    type = $("#type-"+q_cnt).val();
    if(type == 'most_correct')
    {
      $('#answer_div-'+q_cnt+' select').removeAttr('disabled');
    }
    else
    {
      $('#answer_div-'+q_cnt+' select').attr('disabled',true);
      $('#answer_div-'+q_cnt+' select').val('NULL');
    }
  }

  function delete_question(id,q_no)
  {
    bootbox.confirm('Are you sure you want to delete Question ?', function(result) {
      if(result == true)
      {
        $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
        $("#Login_screen").fadeIn('fast');
        $.ajax({
          url:'<?php echo base_url("Abhyas_mcq/delete_question");?>'+'/'+id,
          method:'POST',
          datatype:'JSON',
          error: function(jqXHR, exception) {
            $("#Login_screen").fadeOut(2000);
            if (jqXHR.status === 0) {
              alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
              alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
              alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
              alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
              alert('Time out error.');
            } else if (exception === 'abort') {
              alert('Ajax request aborted.');
            } else {
              alert('Uncaught Error.\n' + jqXHR.responseText);
            }
          },
          success:function(response){
            $("#Login_screen").fadeOut(2000);
            response = JSON.parse(response);
            if(response === true)
            {
              toastr.success('Question Successfully deleted.');
              var d = $("#question_no").val();
              var k = --d;
              $("#question_no").val(k);
              $('#question_div-'+q_no).remove();
              $('#question_div-'+q_no).html('');
              /*setTimeout(function(){
                window.location.reload();
              }, 3000);*/
            }
            else
            {
              toastr.error("Something went wrong!");
            }
          }
        });
      }
    });
  }

  function delete_answer(id,q_no,a_no)
  {
    bootbox.confirm('Are you sure you want to delete Answer ?', function(result) {
      if(result == true)
      {
        $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
        $("#Login_screen").fadeIn('fast');
        $.ajax({
          url:'<?php echo base_url("Abhyas_mcq/delete_answer");?>'+'/'+id,
          method:'POST',
          datatype:'JSON',
          error: function(jqXHR, exception) {
            $("#Login_screen").fadeOut(2000);
            if (jqXHR.status === 0) {
              alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
              alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
              alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
              alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
              alert('Time out error.');
            } else if (exception === 'abort') {
              alert('Ajax request aborted.');
            } else {
              alert('Uncaught Error.\n' + jqXHR.responseText);
            }
          },
          success:function(response){
            $("#Login_screen").fadeOut(2000);
            response = JSON.parse(response);
            if(response === true)
            {
              toastr.success('Answer Successfully deleted.');
              var e = $("#ans_no-"+q_no).val();
              var l = --e;
              $("#ans_no-"+q_no).val(l);
              $('#answerSK'+a_no+'-'+q_no).remove();
              $('#answerSK'+a_no+'-'+q_no).html('');
              /*setTimeout(function(){
                window.location.reload();
              }, 3000);*/
            }
            else
            {
              toastr.error("Something went wrong!");
            }
          }
        });
      }
    });
  }

  function rem_stat(self,q_cnt,a_cnt)
  {
    $(self).on('ifChecked', function (event) {
      var type1 = $("#type-"+q_cnt).val();
      var ans_cnt = $('#ans_no-'+q_cnt).val();
      var id = 0;
      if((type1 == 'single') || (type1 == 'most_correct'))
      {
        for(id=1; id<=ans_cnt; id++)
        {
          if(id != a_cnt)
          {
            console.log(id);
            $('#correctSK'+id+'-'+q_cnt).iCheck('uncheck');
          }
        }
      }
    });
  }
</script>