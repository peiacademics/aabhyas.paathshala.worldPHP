<link href="<?php echo base_url('css/multi-select.css'); ?>" media="screen" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('js/jquery.quicksearch.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.multi-select.js'); ?>"></script>


<div class="ibox">
  <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Assignment')); ?></h5>
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
                    	
                    <form class="form-horizontal" role="form" action="<?php echo base_url('report/add'); ?>" method="post" id="assignment_add">

                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                        <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo (@$View['branch_ID'] == NULL) ? $this->uri->segment(3, 0) : $View['branch_ID']; ?>">

                        <div class="form-group">
                          <label  class="col-sm-3 control-label">To Time : </label>
                          <div class="col-sm-6">
                            <input type="text" class="datepicker form-control" id="to" placeholder="To Time" name="to" value="<?php echo @$View['to']; ?>" required>
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-3 control-label">From Time : </label>
                          <div class="col-sm-6">
                            <input type="text" class="datepicker form-control" id="from" placeholder="From Time" name="from" value="<?php echo @$View['from']; ?>" required>
                          </div>
                          <span id="chapter"></span>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-3 control-label">Task Details : </label>
                          <div class="col-sm-6">
                            <textarea rows="10" class="form-control" id="description" placeholder="Task Details" name="description"><?php echo @$View['description']; ?></textarea>
                          </div>
                          <span id="topic"></span>
                        </div>

         					</div>
                           
                	<div class="form_footer">
                  	<div class="row">
                    	<div class="col-md-6 text-center col-md-offset-3 ">
                        <button id="save" type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>
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

<?php if(!empty(@$View['ID'])){ ?>
  get_students();
<?php } ?>

  // $('#student_ID').multiSelect();

  $(document).ready(function() {

    var br_id = $('#branch_ID').val();
    $.validator.setDefaults({ ignore: ":hidden:not(select)" });  
    var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";

    $('.datepicker').datetimepicker();

    $("#assignment_add").postAjaxData(function(result){
      if(result == true)
      {
        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully '+type+'.');
        setTimeout(function (){
          window.location.reload();
        }, 500);
      }
      else
      {
        toastr.error("Something went wrong!");
      }
    });
    $("#assignment_add").validate();
  });
</script>