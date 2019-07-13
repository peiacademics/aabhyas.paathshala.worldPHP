<div class="page-content">
	<div class="pull-right">
     <a href="<?php echo base_url('assignment/add/'.$branch_ID); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add Employee Award</button></a>
    </div>
    <div class="row">
	    <div class="ibox">
	        <!-- <div class="ibox-title">
	            <h5><?php echo ucfirst($this->lang_library->translate('Add Employee Award')); ?></h5>
	            <div class="ibox-tools">
	            	<a class="collapse-link">
	                    <i class="fa fa-chevron-up"></i>
	                </a>
	            </div>
	        </div> -->
	        <div class="ibox-content table-responsive">
	        	<!-- <div>
            		<a href="<?php echo base_url('team/add_employee_award/'.$branch_ID); ?>" class="btn btn-w-m btn-primary">Add Employee Award</a>
            		<input type="hidden" id="branch_ID" value="<?php echo $branch_ID; ?>">
        		</div>
        		<hr> -->
        		<div id="data_table" class="">
 	        		<table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
		            	<thead>
		                	<tr>
				                <th>Date</th>
		        	            <th>Employee</th>
		                        <th>Award</th>
				                <th>Actions</th>
		                	</tr>
			        	</thead>
		            	<tbody>
		            	</tbody>
            		</table>
        		</div>
    		</div>
    	</div>
	</div>
</div>

<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script> -->
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
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

<script type="text/javascript">
	$(document).ready(function() {
		var branch_ID = $('#branch_ID').val();
	    oTable = $('#example').DataTable( {
	        "processing": true,
	        "serverSide": true,
	        "ajax": "<?php echo base_url('team/get_show_data2'); ?>"+"/"+branch_ID,
	        dom: 'lBfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ]
	    } );
    	$('.dt-buttons').css({'float':'right'});
	});
	
	function view(id)
	{ 
	    $.ajax({
		    type:'POST',
		    url: '<?php echo base_url(); ?>'+'team/view/'+id,
		    success:function(response)
		    {
		    	$.each(response, function(key,value){
		        	$("#"+key).text(value);
		    	});
	      		$("#myModal").modal('show');    
	    	}
	  	});
	}

	function deletef(id,href)
	{
		bootbox.confirm('Are you sure you want to delete?', function(result) {
		    if(result == true)
		    {
			    $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
			    $("#Login_screen").fadeIn('fast');
			    $.ajax({
			        url:href,
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
				            toastr.success('Successfully deleted.');
							setTimeout(function(){
								oTable.ajax.reload();
							}, 3000);
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
</script>