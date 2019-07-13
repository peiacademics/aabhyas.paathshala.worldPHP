<?php 
/*$cntrlr = $this->uri->segment(1);
$curyear = date('Y');
$curmonth = date('m');*/
?>
<html>
<head>
<!-- page specific plugin styles -->

		<link rel="stylesheet" href="<?php echo base_url();?>css/fullcalendar.css" />

		<!-- fonts -->
</head>
<div class="row">
	<div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <?php //echo @$msg;  
         if($this->session->flashdata('msg') != FALSE) echo $this->session->flashdata('msg'); ?>
        <div class="page-content">
						<div class="page-header">
							<h1>
								Full Calendar
								<small>
									<i class="icon-double-angle-right"></i>
									with draggable and editable events
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-sm-12">
										<div class="space"></div>

										<div id="calendar"></div>
									</div>

									<div class="col-sm-3">
										<div class="widget-box transparent">
											<div class="widget-header">
												<!--<h4>Events</h4>-->
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">

												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div> 
<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo base_url();?>js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<!--<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>-->
		<!--<script src="<?php echo base_url();?>js/typeahead-bs2.min.js"></script>-->

		<!-- page specific plugin scripts -->

		<script src="<?php echo base_url();?>js/jquery-2.0.3.min.js"></script>
		<script src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="<?php echo base_url();?>js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>js/fullcalendar.min.js"></script>
		<script src="<?php echo base_url();?>js/bootbox.min.js"></script>

		<!-- ace scripts -->

		<script src="<?php echo base_url();?>js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				/*$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
	*/
    /* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events div.external-event').each(function() {

		// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
		// it doesn't need to have a start or end
		var eventObject = {
			title: $.trim($(this).text()) // use the element's text as the event title
		};

		// store the Event Object in the DOM element so we can get to it later
		$(this).data('eventObject', eventObject);

		// make the event draggable using jQuery UI
		$(this).draggable({
			zIndex: 999,
			revert: true,      // will cause the event to go back to its
			revertDuration: 0  //  original position after the drag
		});
		
	});




	/* initialize the calendar
	-----------------------------------------------------------------*/

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth() + 1;
	var y = date.getFullYear();
	//alert(date);
//alert(d+" "+m+"  "+y);

 /* Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
  };

d = new Date();
//var dt=d.getDate();
d.yyyymmdd();*/

	//alert(date);
	var calendar = $('#calendar').fullCalendar({
		//var event_url = '<?php echo base_url(); ?>calender/events/'+m+'/'+y;
		 buttonText: {
			prev: '<i class="icon-chevron-left"></i>',
			next: '<i class="icon-chevron-right"></i>'
		},
	
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		events: {
			url:'<?php echo base_url('calender/event'); ?>',
			cache:true,
		},
		eventRender: function(event, element, view) {
  		  if (event.allDay === 'true') {
   		  event.allDay = true;
    	} else {
    	 event.allDay = false;
   		 }
   	},
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar !!!
		drop: function(date,allDay) { // this function is called when something is dropped
		/*if($(this).attr('id')=='')
		return;*/
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			//var copiedEventObject = $.extend({},originalEventObject);
			var $extraEventClass = $(this).attr('data-class');
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date; //d.yyyymmdd(); date;
			copiedEventObject.allDay = allDay;
			
			if($extraEventClass) copiedEventObject['className'] = [$extraEventClass];
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
			
		}
		,
		selectable: true,
		selectHelper: true,	
		editable: true,	
		/*timeFormat: {
    agenda: 'H(:mm)' //h:mm{ - h:mm}'
    },*/
		 eventAfterRender: function(event, $el, view ) {
		 	//console.log(event);
      /*  var formattedTime = $.fullCalendar.formatDates(event.start, event.end, "HH:mm { - HH:mm}");
        console.log(formattedTime);
        // If FullCalendar has removed the title div, then add the title to the time div like FullCalendar would do
        if($el.find(".fc-event-title").length === 0) {
            $el.find(".fc-event-time").text(formattedTime + " - " + event.title);
        }
        else {
            $el.find(".fc-event-time").text(formattedTime);
        }*/
    },
    select: function(start, end,allDay){
			
			/*var title =prompt('Event Title:');
		var config1 ={ base:"<?php echo base_url();?>calender/add_events"};
			console.log(config1);
		if (title) {
   var start =  $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
   //var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: config1.base,
   data: 'title='+ title+'&start='+ start,
   type: "POST",
  success: function(json){
  alert('Added successfully');
  console.log(json);
   }
   }); */
   			/*var config1 ={ base:"<?php echo base_url('calender/add_events');?>"};
			var start_time = start;
			var end_time = end;
			var all_day = allDay;
			/*bootbox.prompt("New Event Title:", function(title) {
				if (title !== null) {
					// add entry to database
					 var start =  $.fullCalendar.formatDate(start_time, "yyyy-MM-dd HH:mm:ss");
					 var end = $.fullCalendar.formatDate(end_time, "yyyy-MM-dd HH:mm:ss");
					   $.ajax({
					   url: config1.base,
					   data: 'title='+ title+'&start='+ start,
					   type: "POST",
					  success: function(json){
					 	 //alert('Added successfully');
					 	 console.log(json);
					   }
					 });
					
					  --------------
					  calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start_time,
							end: end_time,
							allDay: all_day
						},
						true, // make the event "stick"*/	
			bootbox.dialog({
                title: "Add Event",
                message: '<div class="form-horizontal" id="sample-form"><div class="form-group table-responsive"> <div class="col-xs-12" aria-discribedby="sample-table-2_info"> <input type="hidden" name="Status" value="A"><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Meeting type :</label><div class="col-xs-12 col-sm-5"><input type="radio" name="Meeting_type" value="Team">Team<div class="space-4"></div><input type="radio" name="Meeting_type" value="Client">Client <span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Client name :</label><div class="col-xs-12 col-sm-5"><select class="width-100" name="Client_name" id="Client_name"><option value="">Please Select</option><option value="CLSK10000001" set_select(\'client_name\',="" \'clsk10000001\',="" true);="">rtq</option><option value="CLSK10000002" set_select(\'client_name\',="" \'clsk10000002\',="" true);="">aditi</option></select></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Team members :</label><div class="col-xs-12 col-sm-5"><select class="width-95 chosen-selectm tag-input-style" name="Team_members[]" id="Team_members" multiple="" style="display: none;"><option value="TSK10000001">rohan</option><option value="TSK10000002">nikita</option><option value="TSK10000003">sumeet</option><option value="TSK10000004">sumedha</option></select></div></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Project :</label><div class="col-xs-12 col-sm-5"><select class="width-100" name="Project_ID" id="Project_ID"><option value="">Please Select</option><option value="PRSK10000001" set_select(\'project_id\',="" \'prsk10000001\',="" true);="">lklknsdsd</option><option value="PRSK10000002" set_select(\'project_id\',="" \'prsk10000002\',="" true);="">Myorganic</option><option value="PRSK10000003" set_select(\'project_id\',="" \'prsk10000003\',="" true);="">myorg</option></select></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">End :</label><div class="col-xs-12 col-sm-5"><div class="row"> <div class="col-xs-12"> <div class="input-group input-group-sm"> <input name="End" class="form-control datepicker2" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd"> <span class="input-group-addon"> <i class="icon-calendar"></i> </span> </div></div></div></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Start time :</label><div class="col-xs-12 col-sm-5"><div class="row"><div class="col-xs-12"><div class="input-group bootstrap-timepicker" style="width:200px;"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td><a href="#" data-action="incrementMinute"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td><a href="#" data-action="incrementSecond"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="icon-chevron-up"></i></a></td></tr><tr><td><input type="text" name="hour" class="bootstrap-timepicker-hour" maxlength="2"></td><td class="separator">:</td><td><input type="text" name="minute" class="bootstrap-timepicker-minute" maxlength="2"></td><td class="separator">:</td><td><input type="text" name="second" class="bootstrap-timepicker-second" maxlength="2"></td><td class="separator"> </td><td><input type="text" name="meridian" class="bootstrap-timepicker-meridian" maxlength="2"></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="icon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="icon-chevron-down"></i></a></td><td class="separator"> </td><td><a href="#" data-action="decrementSecond"><i class="icon-chevron-down"></i></a></td><td class="separator"> </td><td><a href="#" data-action="toggleMeridian"><i class="icon-chevron-down"></i></a></td></tr></tbody></table></div><input id="timepicker1" type="text" class="form-control" name="Start_time"> <span class="input-group-addon"> <i class="icon-time bigger-110"></i> </span> </div></div></div></div><div class="space-4"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Subject :</label><div class="col-xs-12 col-sm-5"><select name="Subject" class="width-100 meeting_sub" id="form-field-select-3" data-placeholder="Choose..."><option value="Weekly">Weekly</option><option value="Monthly">Monthly</option><option value="Occasionally">Occasionally</option><option value="Project_report">Project_report</option></select><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Topics :</label><div class="col-xs-12 col-sm-5"><textarea id="form-field-1" class="form-control width-100" name="Topics" cols="20" rows="4" style="width:70%" value=""></textarea></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><input type="hidden" name="End_time" value=""><input type="hidden" name="t" value="M"></div><div class="skyq_clr"></div></div></div>',
                buttons: {
                    success: {
                        label: "Save",
                        className: "btn-success",
                        callback: function () {
							//console.log(event);
							var data_post={};
							 data_post.start = $.fullCalendar.formatDate(start_time, "yyyy-MM-dd HH:mm:ss");
					         data_post.end = $("input[name='End']").val();
							 data_post.project_id = $("#Project_ID").val();
							 data_post.subject = $(".meeting_sub").val();
							 data_post.title = $("input[name=Meeting_type]:checked").val();
							 team_members = $('#Team_members').val();
							 data_post.team_members = team_members.join();
							 data_post.client_name = $('#Client_name').val();
							 data_post.Start_time = $('#timepicker1').val();
							 data_post.topic = $('.topicsdom').val();
							 //data_post.client_name = $("input[name='Client_name']").val();
							 console.log(data_post);
								$.ajax({
								   url:"<?php echo base_url('calender/add_events');?>" ,
								   data: data_post,
								   type: "POST",
								   success: function(response){
									 if(response)
									 {
										alert('Added successfully');
										$('#calendar').fullCalendar('renderEvent');
									 }
									 else {
										alert("Failed!"); 
									 }
								   }
								 });
                            //Ajax function to add meeting data
                        }
                    }
                }
            }
        );
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: true
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		$('.datepicker1').datepicker({autoclose:true}).next().on(ace.click_event, function(){	$(this).prev().focus();	});
		$('.datepicker2').datepicker({autoclose:true}).next().on(ace.click_event, function(){	$(this).prev().focus();	});
		$(".chosen-selectm").chosen({width:"188px"}); 
		},	
		
		//eventDrop: function(event,deltas) {
		eventDrop: function (event, dayDelta, revertFunc, jsEvent, ui, view) {
		console.log(event);
		 var start =  $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
		 var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
		// console.log(start);
		 //console.log(end);

			$.ajax({
				url: '<?php echo base_url('calender/update_events');?>',
				data: 'title='+ event.title+'&start='+ start +'&id='+event.id +'&end='+end+'&start_time='+start+'&end_time='+end,
				type: "POST",
				success: function(responce){
					alert("Updated Successfully");
					//$('#calendar').fullCalendar('refetchEvents');
					console.log(responce);
				}
			});
			
		},
		eventResize: function(event)
		 {
   			var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm");
   			var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm");
   				$.ajax({
   							 url: '<?php echo base_url('calender/update_events1');?>',
    						 data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+'&start_time='+start+'&end_time='+end,
    						 type: "POST",
    						 success: function(responce)
							  {
                                 alert("Updated Successfully");
	                             console.log(responce);
    						  }
   					   });
	     },
		eventClick: function(calEvent, jsEvent, view) {
			/*var form = $("<form class='form-inline'><label>Change event name &nbsp;</label></form>");
			form.append("<input class='middle' autocomplete=off type=text value='" + calEvent.title + "' /> ");
			form.append("<button type='submit' class='btn btn-sm btn-success'><i class='icon-ok'></i> Save</button>");
			form.append("<a href='<?php echo base_url();?>s/V/M'><button type='button' class='btn btn-sm btn-purple'><i class='icon-long-arrow-right'></i> Show Details</button></a>");*/
			
			bootbox.dialog({
                title: "Edit Event",
                message: '<center><h1>Loading....</h1></center>',
				buttons: {
				"delete" : {
						"label" : "<i class='icon-trash'></i> Delete Event",
						"className" : "btn-danger",
						"callback": function(event) {
							event.id= calEvent.id;
							
							var decision = confirm("Do you really want to do that?"); 
								if (decision) {
								$.ajax({

								url: '<?php echo base_url('calender/delete_events');?>',
								data: '&id=' + event.id,
								type: "POST"
								});
								console.log(event.id);
								
							}
							calendar.fullCalendar('removeEvents',event.id);
						}
					},
                    success: {
                        label: "<i class='icon-save'></i> Save",
                        className: "btn-success",
                        callback: function () {
							var data_post={};
							 //data_post.start = $.fullCalendar.formatDate(start_time, "yyyy-MM-dd HH:mm:ss");
					        // data_post.end = $("input[name='End']").val();
							 data_post.project_id = $("#Project_ID").val();
							 data_post.subject = $(".meeting_sub").val();
							 data_post.title = $("input[name=Meeting_type]:checked").val();
							 data_post.topic = $('.topicsdom').val();
							 //data_post.team_members = $("input[name='Team_members[]']").val();
							 team_members = $('#Team_members').val();
							 data_post.team_members = team_members.join();
							 data_post.client_name = $('#Client_name').val();
							 data_post.Start_time = $('#timepicker1').val();
							 data_post.id = calEvent.id;
							 console.log(data_post);
							$.ajax({
								url: '<?php echo base_url('calender/update_event');?>', 
								type: "POST",
								data: data_post,
								success: function(response)
							 	 {
									console.log(response); 
                                 alert("Updated Successfully");
							
								$('#calendar').fullCalendar('updateEvent',calEvent)
	                             console.log(response);
    						 	 }
								});
							//alert('test');	
							//alert('updated successfully');
						}
                    }
				
			}
            });
		console.log(calEvent.id);
		$.ajax({
//			data : { ids :  },
			url : '<?php echo base_url('calender/update_event_load_data');?>/'+calEvent.id+'',
			data_type : "POST",
			success : function(response){
				console.log(response);
				preVals = JSON.parse(response);
				console.log(response.Team_members);
				formHtml = '<div class="form-horizontal" id="sample-form"><div class="form-group table-responsive"> <div class="col-xs-12" aria-discribedby="sample-table-2_info"> <input type="hidden" name="Status" value="A"><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Meeting type :</label><div class="col-xs-12 col-sm-5"><input type="radio" name="Meeting_type" value="Team"> Team<div class="space-4"></div><input type="radio" name="Meeting_type" value="Client"> Client <span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Client name :</label><div class="col-xs-12 col-sm-5"><select class="width-100" name="Client_name" id="Client_name"><option value="">Please Select</option><option value="CLSK10000001" set_select(\'client_name\',="" \'clsk10000001\',="" true);="">rtq</option><option value="CLSK10000002" set_select(\'client_name\',="" \'clsk10000002\',="" true);="">aditi</option></select></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Team members :</label><div class="col-xs-12 col-sm-5"><select class="width-95 chosen-selectm tag-input-style" name="Team_members[]" id="Team_members" multiple="" style="display: none;"><option value="TSK10000001">rohan</option><option value="TSK10000002">nikita</option><option value="TSK10000003">sumeet</option><option value="TSK10000004">sumedha</option></select></div></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Project :</label><div class="col-xs-12 col-sm-5"><select class="width-100" name="Project_ID" id="Project_ID"><option value="">Please Select</option><option value="PRSK10000001" set_select(\'project_id\',="" \'prsk10000001\',="" true);="">lklknsdsd</option><option value="PRSK10000002" set_select(\'project_id\',="" \'prsk10000002\',="" true);="">Myorganic</option><option value="PRSK10000003" set_select(\'project_id\',="" \'prsk10000003\',="" true);="">myorg</option></select></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Start time :</label><div class="col-xs-12 col-sm-5"><div class="row"><div class="col-xs-12"><div class="input-group bootstrap-timepicker" style="width:200px;"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td><a href="#" data-action="incrementMinute"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td><a href="#" data-action="incrementSecond"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="icon-chevron-up"></i></a></td></tr><tr><td><input type="text" name="hour" class="bootstrap-timepicker-hour" maxlength="2"></td><td class="separator">:</td><td><input type="text" name="minute" class="bootstrap-timepicker-minute" maxlength="2"></td><td class="separator">:</td><td><input type="text" name="second" class="bootstrap-timepicker-second" maxlength="2"></td><td class="separator"> </td><td><input type="text" name="meridian" class="bootstrap-timepicker-meridian" maxlength="2"></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="icon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="icon-chevron-down"></i></a></td><td class="separator"> </td><td><a href="#" data-action="decrementSecond"><i class="icon-chevron-down"></i></a></td><td class="separator"> </td><td><a href="#" data-action="toggleMeridian"><i class="icon-chevron-down"></i></a></td></tr></tbody></table></div><input id="timepicker1" type="text" class="form-control" name="Start_time"> <span class="input-group-addon"> <i class="icon-time bigger-110"></i> </span> </div></div></div></div><div class="space-4"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Subject :</label><div class="col-xs-12 col-sm-5"><select name="Subject" class="width-100 meeting_sub" id="form-field-select-3" data-placeholder="Choose..."><option value="Weekly">Weekly</option><option value="Monthly">Monthly</option><option value="Occasionally">Occasionally</option><option value="Project_report">Project_report</option></select><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Topics :</label><div class="col-xs-12 col-sm-5"><textarea id="form-field-1" class="topicsdom form-control width-100" name="Topics" cols="20" rows="4" style="width:70%" value=""></textarea></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><input type="hidden" name="End_time" value=""><input type="hidden" name="t" value="M"></div><div class="skyq_clr"></div></div></div>';
				$(".bootbox-body").html(formHtml);
				
				$("input[name=Meeting_type][value=" + preVals.Meeting_type + "]").attr('checked', 'checked');
				$('#Client_name').val(preVals.Client_name);
				$.each(preVals.Team_members.split(","), function(i,e){
					$("#Team_members option[value='" + e + "']").prop("selected", true);
				});
				$('#Project_ID').val(preVals.Project_ID);
				$('.meeting_sub').val(preVals.Subject);
				$('.topicsdom').val(preVals.Topics);
				$('#timepicker1').val(preVals.Start_time);
				
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: true
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				$(".chosen-selectm").chosen({width:"188px"});
			},
		});
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: true
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		$('.datepicker1').datepicker({autoclose:true}).next().on(ace.click_event, function(){$(this).prev().focus();});
		$('.datepicker2').datepicker({autoclose:true}).next().on(ace.click_event, function(){$(this).prev().focus();});
		$(".chosen-selectm").chosen({width:"188px"}); 
		/*eventClick: function(calEvent, jsEvent, view)
		{
		bootbox.dialog({
                title: "Edit Event",
                message: '<div class="form-horizontal" id="sample-form"><div class="form-group table-responsive"> <div class="col-xs-12" aria-discribedby="sample-table-2_info"> <input type="hidden" name="Status" value="A"><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Meeting type :</label><div class="col-xs-12 col-sm-5"><input type="radio" name="Meeting_type" value="Team">Team<div class="space-4"></div><input type="radio" name="Meeting_type" value="Client">Client <span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Client name :</label><div class="col-xs-12 col-sm-5"><select class="width-100" name="Client_name" id="Client_name"><option value="">Please Select</option><option value="CLSK10000001" set_select(\'client_name\',="" \'clsk10000001\',="" true);="">rtq</option><option value="CLSK10000002" set_select(\'client_name\',="" \'clsk10000002\',="" true);="">aditi</option></select></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Team members :</label><div class="col-xs-12 col-sm-5"><select class="width-95 chosen-selectm tag-input-style" name="Team_members[]" id="Team_members" multiple="" style="display: none;"><option value="TSK10000001">rohan</option><option value="TSK10000002">nikita</option><option value="TSK10000003">sumeet</option><option value="TSK10000004">sumedha</option></select></div></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="row"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Project :</label><div class="col-xs-12 col-sm-5"><select class="width-100" name="Project_ID" id="Project_ID"><option value="">Please Select</option><option value="PRSK10000001" set_select(\'project_id\',="" \'prsk10000001\',="" true);="">lklknsdsd</option><option value="PRSK10000002" set_select(\'project_id\',="" \'prsk10000002\',="" true);="">Myorganic</option><option value="PRSK10000003" set_select(\'project_id\',="" \'prsk10000003\',="" true);="">myorg</option></select></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">End :</label><div class="col-xs-12 col-sm-5"><div class="row"> <div class="col-xs-12"> <div class="input-group input-group-sm"> <input name="End" class="form-control datepicker2" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd"> <span class="input-group-addon"> <i class="icon-calendar"></i> </span> </div></div></div></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Start time :</label><div class="col-xs-12 col-sm-5"><div class="row"><div class="col-xs-12"><div class="input-group bootstrap-timepicker" style="width:200px;"><div class="bootstrap-timepicker-widget dropdown-menu"><table><tbody><tr><td><a href="#" data-action="incrementHour"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td><a href="#" data-action="incrementMinute"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td><a href="#" data-action="incrementSecond"><i class="icon-chevron-up"></i></a></td><td class="separator"> </td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><i class="icon-chevron-up"></i></a></td></tr><tr><td><input type="text" name="hour" class="bootstrap-timepicker-hour" maxlength="2"></td><td class="separator">:</td><td><input type="text" name="minute" class="bootstrap-timepicker-minute" maxlength="2"></td><td class="separator">:</td><td><input type="text" name="second" class="bootstrap-timepicker-second" maxlength="2"></td><td class="separator"> </td><td><input type="text" name="meridian" class="bootstrap-timepicker-meridian" maxlength="2"></td></tr><tr><td><a href="#" data-action="decrementHour"><i class="icon-chevron-down"></i></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><i class="icon-chevron-down"></i></a></td><td class="separator"> </td><td><a href="#" data-action="decrementSecond"><i class="icon-chevron-down"></i></a></td><td class="separator"> </td><td><a href="#" data-action="toggleMeridian"><i class="icon-chevron-down"></i></a></td></tr></tbody></table></div><input id="timepicker1" type="text" class="form-control" name="Start_time"> <span class="input-group-addon"> <i class="icon-time bigger-110"></i> </span> </div></div></div></div><div class="space-4"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Subject :</label><div class="col-xs-12 col-sm-5"><select name="Subject" class="width-100 meeting_sub" id="form-field-select-3" data-placeholder="Choose..."><option value="Weekly">Weekly</option><option value="Monthly">Monthly</option><option value="Occasionally">Occasionally</option><option value="Project_report">Project_report</option></select><span style="color:#FF0000"></span></div></div><div class="space-4"></div><div class="form-group"><label class="col-xs-12 col-sm-3 control-label no-padding-right">Topics :</label><div class="col-xs-12 col-sm-5"><textarea id="form-field-1" class="form-control width-100" name="Topics" cols="20" rows="4" style="width:70%" value=""></textarea></div><div class="help-block col-xs-12 col-sm-reset inline"><span style="color:#FF0000"></span></div></div><input type="hidden" name="End_time" value=""><input type="hidden" name="t" value="M"></div><div class="skyq_clr"></div></div></div>',
			buttons: {
					"delete" : {
						"label" : "<i class='icon-trash'></i> Delete Event",
						"className" : "btn-sm btn-danger",
						"callback": function(event) {
							event.id= calEvent.id;
							
							var decision = confirm("Do you really want to do that?"); 
								if (decision) {
								$.ajax({

								url: '<?php echo base_url('calender/delete_events');?>',
								data: '&id=' + event.id,
								type: "POST"
								});
								console.log(event.id);
								
							}
							calendar.fullCalendar('removeEvents',event.id);
						}
					} ,
					"close" : {
						"label" : "<i class='icon-remove'></i> Close",
						"className" : "btn-sm"
					} 
				}
			});
			*/
			/*var div = bootbox.dialog({
				message: form,
			
				buttons: {
					"delete" : {
						"label" : "<i class='icon-trash'></i> Delete Event",
						"className" : "btn-sm btn-danger",
						"callback": function(event) {
							event.id= calEvent.id;
							
							var decision = confirm("Do you really want to do that?"); 
								if (decision) {
								$.ajax({

								url: '<?php echo base_url('calender/delete_events');?>',
								data: '&id=' + event.id,
								type: "POST"
								});
								console.log(event.id);
								
							}
							calendar.fullCalendar('removeEvents',event.id);
						}
					} ,
					"close" : {
						"label" : "<i class='icon-remove'></i> Close",
						"className" : "btn-sm"
					} 
				}

			});
			/*form.on('submit', function(){
				calEvent.title = form.find("input[type=text]").val();
				calendar.fullCalendar('updateEvent', calEvent);
				//calendar.fullCalendar('removeEvents',event.id);
				div.modal("hide");
				return false;
			});
			*/
			//console.log(calEvent.id);
			//console.log(jsEvent);
			//console.log(view);
			// change the border color just for fun
			//$(this).css('border-color', 'red');
		}
		
	});
		});
		</script>

</html>