<div class="page-content">
  <div class="wrap">
    <h4 id="success" style="text-align:center;"></h4>
    <form class="form-horizontal" role="form" action="<?php echo base_url('settings/add_help'); ?>" method="post" id="help_add">
      <div class="body_text_text">                        
        <div class="form-group">
          <label for="Question" class="col-sm-3 control-label">Question</label>
          <div class="col-sm-6">
              <textarea class="form-control" rows="2" name="Question" palceholder="Question"></textarea>
          </div>
           <span id="Question"></span>
        </div>

        <div class="form-group">
          <label for="Answer" class="col-sm-3 control-label">Answer</label>
          <div class="col-sm-6">
              <textarea class="form-control" rows="3" name="Answer" palceholder="Answer"></textarea>
          </div>
           <span id="Answer"></span>
        </div>

        <div class="form-group">
          <label for="Category_ID" class="col-sm-3 control-label">Category</label>
          <div class="col-sm-6">
            <select class="form-control chosen-select" id="Category_ID" name="Category_ID">
              <option value="">----------Select----------</option>
           <?php 
           if($category_array != FALSE) {
                  foreach ($category_array as $key => $value) {
           ?>
                        <option value="<?php echo $value['ID']; ?>"><?php echo $value['Title']; ?></option>
                   
           <?php    }   } 
           else { ?>

               <option value="">Data Not Found.</option>

           <?php } ?>
         
                                   
            </select>                           
          </div>
          <span id="Category_ID"></span>
        </div>                                                              

				<div class="form-group">
          <label for="Level" class="col-sm-3 control-label">Level</label>
          <div class="col-sm-6">
            <select class="form-control chosen-select" name="Level">
             <option value="">----------Select----------</option>
               <option value="1">1</option>
               <option value="2">2</option>                                               
            </select>                           
          </div>
          <span id="Level"></span>
        </div>

        <div class="form-group" style="display:none" id="ParentID">
          <label for="Parent_ID" class="col-sm-3 control-label">Parent</label>
          <div class="col-sm-6">
            <select class="form-control chosen-select" id="Parent_ID" name="Parent_ID">
            </select>                           
          </div>
          <span id="Parent_ID"></span>                         
        </div>

        <div class="form-group">
					<label for="Icon" class="col-sm-3 control-label">Icon</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="Icon" name="Icon" placeholder="Icon">
					</div>
          <span id="Icon"></span>
				</div>

			</div>
           
     	<div class="form_footer">
      	<div class="row">
         	<div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">Add Help</button>
          </div>
       	</div>
      </div>
    </form> 
  </div>
</div>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>
<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<!-- Datatable -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.flash.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/jszip.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/pdfmake.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/vfs_fonts.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.html5.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.print.min.js'); ?>">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>">
</script>
<!-- Chosen -->
<script src="<?php echo base_url("js/plugins/chosen/chosen.jquery.js"); ?>"></script>
            
<script type="text/javascript">
  $(document).ready(function() {
    $('.chosen-select').chosen({width: "100%"});
    $("#help_add").validate({
                 rules: {
                     Question: {
                         required: true,
                     },
                     Answer: {
                         required: true,
                     },
                     Level: {
                         required: true,
                     },
                     Category_ID: {
                         required: true,
                     }
                 }
             });

    $("#help_add").postAjaxData(function(result){
      if(result === 1)
      {
          //alert(result);
          $("#success").html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>New FAQ Added Successfully.</div>');
      }
      else {
        if(typeof result === 'object')
        {
          // alert(result);
          console.log(result);
          $.each(result,function(dom,err){
            $("#"+dom).text(err);
          });
        }
        else
        {
          alert('something went wrong.');
        }
      }
    });


    $('select[name="Level"]').change(function() {
        //alert('Hello');
        
         var level = $(this).val();
         if(level == "1")
          {
            $('#ParentID').hide();            
          }
          else
          {            
            $('#ParentID').show();            
          }
          
          options1 = $("select[name='Parent_ID'] >  option");
          options1.remove();
          options1.removeAttr("disabled");
          //var ref_id = $('#Level').val();
          //alert(ref_id);
          var config = {
            base : "<?php echo base_url(); ?>",
          };
             var optnn = $('<option />'); 
              optnn.val('');
              optnn.text('----Select----');
              $('select[name="Parent_ID"]').append(optnn);
          var category_id = $('#Category_ID').val();    
          $.ajax({
          type:'POST',
          url: config.base+'settings/find_help_parent_id/'+category_id,
          success: function(divs) 
           {  
             //alert(divs); 
              $.each(divs,function(id,div) 
              {
                //alert('hi');
                  var opt = $('<option />'); 
                  opt.val(div.ID);
                  opt.text(div.Question);
                  $('select[name="Parent_ID"]').append(opt);
                  console.log(div.Category_ID);
                  $('select[name="Parent_ID"]').trigger("chosen:updated");
          });           
                  
        }
       });
    });

    $('select[name="Parent_ID"]').change(function() {

    });


  });    
</script>