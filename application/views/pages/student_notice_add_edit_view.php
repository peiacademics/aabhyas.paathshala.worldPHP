<link href="<?php echo base_url('css/multi-select.css'); ?>" media="screen" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('js/jquery.quicksearch.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.multi-select.js'); ?>"></script>

<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Student Notice')); ?></h5>
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
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('student_notice/add'); ?>" method="post" id="notice_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                        <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo (@$View['branch_ID'] == NULL) ? $this->uri->segment(3, 0) : $View['branch_ID']; ?>">

                        <div class="form-group">
                          <label  class="col-sm-3 control-label">Notice Title : </label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="Name" placeholder="Title" name="title" value="<?php echo @$View['title']; ?>" required>
                          </div>
                          <span id="title"></span>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Date : </label>
                          <div class="col-sm-6">
                            <input type="text" class="datepicker form-control" name="date" placeholder="Date" value="<?php echo (@$View['date'] != NULL) ? date('m/d/Y H:i a', strtotime(@$View['date'])) : date('m/d/Y H:i a'); ?>" required>
                          </div>
                          <span id="account_opening_date"></span>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Select Students : </label>
                          <div class="col-sm-6">
                            <select class="form-control chosen-select" id="batch_ID" placeholder="Batch" name="batch_ID[]" onChange="get_students()" value="<?php @$View['batch_ID']; ?>" multiple required>
                            </select>
                          </div>
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
                            <select class="form-control" multiple id="student_ID" name="student_ID[]" value="<?php echo @$View['student_ID']; ?>" required>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3">Notice : </label>
                          <div class="ibox float-e-margins">
                            <div class="ibox-content no-padding">
                              <textarea class="summernote" name="description" rows="18"><?php echo @$View['description']; ?></textarea>
                            </div>
                          </div>
                          <span id="description"></span>
                        </div>
         					</div>
                           
                	<div class="form_footer">
                	<div class="row">
                  	<div class="col-md-6 text-center col-md-offset-3 ">
                        <button id="save" type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>
                        <button id="cmt" type="button" class="btn btn-success hidden">Communicate</button>
                    </div>
                  </div>

                </form> 
                        

            </div>
        </div>
      </div>
    </div>    

<!-- SUMMERNOTE -->
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/plugins/summernote/summernote.min.js')?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<style type="text/css">
  #ms-student_ID{
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
  <?php if(!empty(@$View['ID'])){ ?>
    get_students();
  <?php } ?>

  $(document).ready(function() {

    $('#student_ID').multiSelect({
      selectableHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Search Student'>",
      selectionHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Search Student'>",
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

    $('.summernote').summernote({
      height: "500px"
    });
    var br_id = $('#branch_ID').val();
    getChosenData('subject_ID','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['subject_ID']; ?>');
    getChosenData('batch_ID','BT',[{'label':'name','value':'ID'}],[{'Status':'A','branch_ID':br_id}],'<?php echo @$View['batch_ID']; ?>',true);
    $("#batch_ID option:disabled").attr('hidden',true);
    $('#batch_ID').append('<option value="all">All</option>');
    $.validator.setDefaults({ ignore: ":hidden:not(select)" });  
    var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
    $('.datepicker').datetimepicker();

    $("#notice_add").postAjaxData(function(result){
     if(typeof result === 'object')
      {
        if(result.stat == true)
        {
          var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
          $('#cmt').attr('onclick','commun("'+result.id+'")');
          $('#cmt').removeClass('hidden');
          $('#save').addClass('hidden');
          toastr.success('Successfully '+type+'.');
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
      else
      {
        toastr.error("Something went wrong!");
      }
    });
    $("#notice_add").validate();
  });

  function get_students()
  {
    var branch_ID = $('#branch_ID').val();
    var batch_ID = $('#batch_ID').val();
    var data = '';
    $.ajax({
      type:'POST',
      data:{'branch_ID':branch_ID,'batch_ID':batch_ID},
      url: '<?php echo base_url(); ?>'+'assignment/get_students/',
      dataType:'json',
      success:function(response)
      {
        if (response.students!==undefined) {
          $.each(response.students, function(key,value){
            data += '<option value="'+value.ID+'">'+value.Name+' '+value.Middle_name+' '+value.Last_name+'</option>';
          });
          if (response.batchWise!=='All') {
            var btns='';
             $.each(response.batchWise, function(key,value){
              var BatchName='';
              $.each(response.batches,function(k,v) {
                if (key===v.key) {
                  BatchName=v.value;
                }
              });
              btns +='<button type="button" class="btn btn-primary" onclick="selectFunctn(\'selected\',\''+key+'\')"><i class="fa fa-check" aria-hidden="true"></i> '+BatchName+'</button><span hidden id="STIDS-'+key+'">'+JSON.stringify(value)+'</span>&nbsp;';
              btns +='<button type="button" class="btn btn-warning" onclick="selectFunctn(\'deselect\',\''+key+'\')"><i class="fa fa-times" aria-hidden="true"></i> '+BatchName+'</button><span hidden id="STIDS-'+key+'">'+JSON.stringify(value)+'</span>&nbsp;';
            });
            $('#btnss').html(btns);
          }
        }
        else
        {
          data='';
          $('#btnss').html('');
        }

        var selectedoptns=$("#student_ID").val();
        $("#student_ID").html(data);
        $('#student_ID').multiSelect('refresh');
        if (selectedoptns!==null) {
          $('#student_ID').multiSelect('select', selectedoptns);  
        }

        if (response.batchWise!=='All') {
          $("#batch_ID option[value='all']").prop('disabled',true).trigger("chosen:updated");
        }
        else
        {
          $("#batch_ID option[value='all']").siblings().attr('disabled',true).trigger("chosen:updated");
        }

         if(batch_ID.length===0){
            $("#batch_ID option[value='all']").prop('disabled',false).trigger("chosen:updated");
            $("#batch_ID option[value='all']").siblings().attr('disabled',false).trigger("chosen:updated");
            $("#batch_ID option[value='']").attr('disabled',true).trigger("chosen:updated");
          }
      }
    });
  }

  function selectFunctn(val,batch_ID) {
    if (val==='select-all') {
      $('#student_ID').multiSelect('select_all');
    }
    else
      if (val==='deselect-all')
      {
        $('#student_ID').multiSelect('deselect_all');
      }
      else if (val==='deselect') {
        var data=$('#STIDS-'+batch_ID).text();
        $('#student_ID').multiSelect('deselect', JSON.parse(data));
      }
      else
      {
        var data=$('#STIDS-'+batch_ID).text();
        $('#student_ID').multiSelect('select', JSON.parse(data));
      }
  }

  function commun(id)
  {
    $.ajax({
      url:'<?php echo base_url("communicate/get_record"); ?>',
      method:'POST',
      data:{ID:id,rec_id:'CMSSK10000008',tbl:'SN'},
      datatype:'JSON',
      success:function(response){
        response = JSON.parse(response);
        $('#branch_added select option[value="'+response.rec.branch_ID+'"]').prop('selected', true).trigger("chosen:updated");
        $('#typeCom option[value="'+response.setting.type+'"]').prop('selected', true).trigger("chosen:updated");
        getTypeList(response.setting.type);
        setTimeout(function() {
          if (response.rec.batch_ID.indexOf(',') > -1){
            var batches2 = [];
            $.each(response.rec.batch_ID.split(','), function(i,e) {
              batches2.push(e);
            });
            $('#listsOfperson').val(batches2).trigger('chosen:updated');
            $.each(response.rec.batch_ID.split(','), function(i,e2) {
              personsToSendMsg(e2);
            });
          }
          else
          {
            $('#listsOfperson').val(response.rec.batch_ID).trigger('chosen:updated');
            personsToSendMsg(response.rec.batch_ID);
          }
          setTimeout(function() {
            if (response.rec.student_ID.indexOf(',') > -1){
              var stuff = [];
              $.each(response.rec.student_ID.split(','), function(i1,e1) {
                stuff.push(e1);
              });
              $('#listsOfpersonS').val(stuff).trigger('chosen:updated');
            }
            else
            {
              $('#listsOfpersonS').val(response.rec.student_ID).trigger('chosen:updated');
            }
            if(response.setting.self == 'Y')
            {
              $('.icheckbox_square-green input[name="student"]').iCheck('check');
            }
            if(response.setting.guardian1 == 'Y')
            {
              $('.icheckbox_square-green input[name="guardian1"]').iCheck('check');
            }
            if(response.setting.guardian2 == 'Y')
            {
              $('.icheckbox_square-green input[name="guardian2"]').iCheck('check');
            }
            setTimeout(function() {
              $('#smsMobile select option[value="Manual"]').prop('selected', true).trigger('chosen:updated');
              getTypeMEssages('Manual');
              $('#smsMobile textarea[name="message"]').val(response.setting.sms_mobile);
              setTimeout(function() {
                $('#smsGateway select option[value="Manual"]').prop('selected', true).trigger('chosen:updated');
                $('#messagess1').html('<div class="col-sm-12"><div class="form-group"><label class="font-noraml">Message</label><div><textarea class="form-control" placeholder="Message" name="message">'+response.setting.sms_gateway+'</textarea></div></div></div><div class="col-sm-12 text-center"><a class="btn btn-primary btn-lg btn-outline" onclick="sendMsg(\'gateway\',\'gateway\')" ><i class="fa fa-mobile" aria-hidden="true"></i> Send</a></div>');
                $('#EmailCommunicate textarea[name="message"]').val(response.setting.email);
              }, 500);
            }, 500);
          }, 500);
        }, 500);
      }
    });
    $('#comunicationModal').modal('show');
  }
</script>