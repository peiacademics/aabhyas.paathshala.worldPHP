<link href="<?php echo base_url('css/multi-select.css'); ?>" media="screen" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('js/jquery.quicksearch.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.multi-select.js'); ?>"></script>
<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Abhyas Assignment')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div>
  <div class="ibox-content">
    <div class="page-content">
        <div class="wrap">
          <h4 id="success" style="text-align:center;"></h4>
                <form class="form-horizontal" role="form" action="<?php echo base_url('Abhyas_mcq_assignment/add'); ?>" method="post" id="bank_add">
                    <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Name : </label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo @$View['name']; ?>" required>
                        </div>
                        <span id="name_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Description : </label>
                        <div class="col-sm-6">
                          <textarea class="form-control" id="description" name="description" placeholder="Description" rows="5"><?php echo @$View['description']; ?></textarea>
                        </div>
                        <span id="desc_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Subject: </label>
                        <div class="col-sm-6">
                          <select class="form-control chosen-select" onChange="get_lesson()" id="subject_ID" name="subject_ID" placeholder="Subject" required>
                          </select>
                        </div>
                          <span id="sub_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Lesson : </label>
                        <div class="col-sm-6">
                          <select class="form-control chosen-select" id="lesson_ID" name="lesson_ID" onChange="get_topic()" placeholder="Lesson" required>
                            <option selected disabled>Select</option>
                          </select>
                        </div>
                          <span id="les_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Topic : </label>
                        <div class="col-sm-6">
                          <select class="form-control chosen-select" id="topic_ID" name="topic_ID" placeholder="Topic" onChange="get_questions()" required>
                            <option selected disabled>Select</option>
                          </select>
                        </div>
                          <span id="tp_ID"></span>
                    </div>

                    <div class="form-group ibox-content">
                      <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-4">
                          <button type="button" class="btn btn-primary" onclick='selectFunctn("select-all")'><i class="fa fa-check" aria-hidden="true"></i> All</button>
                          <button type="button" class="btn btn-warning" onclick='selectFunctn("deselect-all")'><i class="fa fa-times" aria-hidden="true"></i> All</button>
                        </div>
                        <div class="col-sm-8" id="btnss">
                        </div>
                      </div>
                     <br>
                        <?php if(@$View['question_bank_ID'] != NULL) { ?>
                        <select class="form-control" multiple id="question_bank_ID" name="question_bank_ID[]" value="" required>
                          <?php foreach ($questions as $keyq => $valueq) { ?>
                            <option value="<?php echo $valueq['ID']; ?>" <?php echo (strpos(@$View['question_bank_ID'], $valueq['ID']) !== FALSE) ? "selected" : "" ?>><?php echo $valueq['question']; ?></option>
                          <?php } ?>
                        </select>
                      <?php } else { ?>
                        <select class="form-control" multiple id="question_bank_ID" name="question_bank_ID[]" value="<?php echo @$View['question_bank_ID']; ?>" required>
                        </select>
                      <?php } ?>
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

<style type="text/css">
  #ms-question_bank_ID{
    width: 100%;
  }
  .ms-selectable .ms-list{
    height: 500px;
  }
  .ms-selection .ms-list{
    height: 500px;
  }
</style>

<script type="text/javascript">
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    
    var subject_ID = '<?php echo @$View['subject_ID']; ?>';
    if(subject_ID != '')
    {
      var lesson_ID = '<?php echo @$View['lesson_ID']; ?>';
      getChosenData('lesson_ID','LS',[{'label':'name','value':'ID'}],[{'Status':'A','subject_ID':subject_ID}],'<?php echo @$View['lesson_ID']?>');
      getChosenData('topic_ID','TP',[{'label':'name','value':'ID'}],[{'Status':'A','lesson_ID':lesson_ID,'subject_ID':subject_ID}],'<?php echo @$View['topic_ID']?>');
    }
    getChosenData('subject_ID','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['subject_ID']?>');

    $('#question_bank_ID').multiSelect({
      selectableHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Search Question'>",
      selectionHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Search Question'>",
      afterInit: function(ms){
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        .on('keydown', function(e){
          if (e.which === 40){
            that.$selectableUl.focus();
            return false;
          }
        });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        .on('keydown', function(e){
          if (e.which == 40){
            that.$selectionUl.focus();
            return false;
          }
        });
      },
      afterSelect: function(){
        this.qs1.cache();
        this.qs2.cache();
      },
      afterDeselect: function(){
        this.qs1.cache();
        this.qs2.cache();
      }
    });

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

  function get_questions()
  {
    var subject_ID = $('#subject_ID').val();
    var lesson_ID = $('#lesson_ID').val();
    var topic_ID = $('#topic_ID').val();
    var data = '';
    $.ajax({
      type:'POST',
      data:{'subject_ID':subject_ID,'lesson_ID':lesson_ID,'topic_ID':topic_ID},
      url: '<?php echo base_url(); ?>'+'abhyas_mcq_assignment/get_questions/',
      dataType:'json',
      success:function(response)
      {
        if (response.students!==undefined) {
          $.each(response.students, function(key,value){
            data += '<option value="'+value.ID+'">'+value.question+'</option>';
          });
        }
        else
        {
          data = '';
          $('#btnss').html('');
          toastr.error('Please select all Subject, Lesson & Topic.');
        }

        var selectedoptns=$("#question_bank_ID").val();
        $("#question_bank_ID").html(data);
        $('#question_bank_ID').multiSelect('refresh');
        if (selectedoptns!==null) {
          $('#question_bank_ID').multiSelect('select', selectedoptns);  
        }

      }
    });
  }


  function selectFunctn(val,batch_ID) {
    if (val==='select-all') {
      $('#question_bank_ID').multiSelect('select_all');
    }
    else
      if (val==='deselect-all')
      {
        $('#question_bank_ID').multiSelect('deselect_all');
      }
      else if (val==='deselect') {
        var data=$('#STIDS-'+batch_ID).text();
        $('#question_bank_ID').multiSelect('deselect', JSON.parse(data));
      }
      else
      {
        var data=$('#STIDS-'+batch_ID).text();
        $('#question_bank_ID').multiSelect('select', JSON.parse(data));
      }
  }
</script>