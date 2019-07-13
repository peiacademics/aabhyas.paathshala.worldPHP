<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Topic')); ?></h5>
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
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('Topic/add'); ?>" method="post" id="bank_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                        <div class="form-group">
                              <label  class="col-sm-3 control-label">Subject: </label>
                              <div class="col-sm-6">
                                <select class="form-control select-chosen" onchange="get_lesson()" id="subject_ID" name="subject_ID">  
                                </select>
                              </div>
                                <span id="bank_name"></span>
                          </div>
                           <div class="form-group">
                              <label  class="col-sm-3 control-label">Lesson : </label>
                              <div class="col-sm-6">
                                <select class="form-control select-chosen" id="lesson_ID" name="lesson_ID">  
                                </select>
                              </div>
                                <span id="bank_name"></span>
                          </div>

                          <div class="form-group">
                              <label  class="col-sm-3 control-label">Topic No : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="topic_no" placeholder="Topic No" name="topic_no">
                              </div>
                                <span id="bank_name"></span>
                          </div>

                         <div class="form-group">
                              <label  class="col-sm-3 control-label">Topic Name : </label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="Name" placeholder="Topic Name" name="name">
                              </div>
                                <span id="bank_name"></span>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-3 control-label">Description : </label>
                              <div class="col-sm-6">
                                 <textarea type="text" class="form-control" name="description" placeholder="Description"><?php echo @$View['description']; ?></textarea>
                              </div>
                                <span id="description"></span>
                          </div>
         					</div>
                           
                        	<div class="form_footer">
                        	<div class="row">
                            	<div class="col-md-6 text-center col-md-offset-3 ">
                                <button type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?>
                                </button>
                                    </div>
                            	</div>

                            </form> 
                        

            </div>
        </div>
      </div>
    </div>    

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
  getChosenData('subject_ID','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['subject_ID']?>');
  
  function get_lesson(){
    var subject_ID= $('#subject_ID').val();
    getChosenData('lesson_ID','LS',[{'label':'name','value':'ID'}],[{'Status':'A','subject_ID':subject_ID}],'<?php echo @$View['lesson_ID']?>');
  }
</script>