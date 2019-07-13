<div class="row" id="home_cnt">
</div>
<script type="text/javascript">
	$(document).ready(function (){
		branch_wise_data();	
	});
	
	function branch_wise_data()
	{
		var login_as = '<?php echo $this->session_library->get_session_data('Login_as'); ?>';
		$.ajax({
	        url:'<?php echo base_url(); ?>'+'Dashboard/branch_wise_data/',
	        method:'POST',
	        datatype:'JSON',
	        success:function(response){
	        	var data = '';
	        	if(login_as == 'DSSK10000001')
	        	{
		        	$.each(response, function(key,value){
		        		data += '<div class="col-sm-4"><div class="widget blue-bg no-padding"><div class="p-m"><h1 class="font-bold no-margins"><i class="fa fa-building" aria-hidden="true"></i> '+value.name+' Branch</h1><small><br></small><div class="row"><div class="col-sm-12 black-cl"><h2 class="h2">Total Batches : <strong class="text-danger">'+value.batches+'</strong></h2><h2 class="h2">Total Students : <strong class="text-danger">'+value.students+'</strong></h2><h2 class="h2">Total Employees : <strong class="text-danger">'+value.employees+'</strong></h2></div></div></div></div></div>';
		        	});
		        }
		        else
		        {
		        	data = '<h1>Welcome to Paathshala.</h1>';
		        }
	        	$('#home_cnt').html(data);
	        }
	    });
	}
</script>