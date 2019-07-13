 <div class="page-content">

            <div class="wrap">

        <div class="ibox">

          <div class="ibox-title">

              <h5><?php echo ucfirst($this->lang_library->translate('Transaction')); ?></h5>

              <div class="ibox-tools">

                  <a class="collapse-link">

                      <i class="fa fa-chevron-up"></i>

                  </a>

              </div>

          </div>

          <div class="ibox-content">

          	<form method="post" action="<?php echo base_url('transaction');?>">

	          	<div class="row">

	          		<div class="col-md-6">

	          			<div class="input-group">

	          				<div class="input-group-addon">

	          					 <i class="fa fa-calendar"></i>

	          				</div>

				            <input type="text" id="" class="reportrange form-control input-lg" placeholder="Date Range" name="dateRange"> 

				            <!-- <b class="caret"></b> -->

				        </div>

	          		</div>

	          		<div class="col-md-6">

	          			<div class="input-group">

	          				<div class="input-group-addon">

                                <i class="fa fa-exchange"></i>

	          					 <!-- Transaction Type -->

	          				</div>

	          				<!--  chosen-select -->

		          			 <select class="form-control input-lg" name="transaction_type">

		                      <option value="Debit">Debit</option>

		                      <option value="Credit">Credit</option>

		                      <option value="" selected>All</option>                           

		                    </select>

	                	</div>

	          		</div>

	          	</div>

	          	<br>

	          	<div class="row">

	          		<div class="form-group">

	                  <div class="col-sm-12">

                        <div class="input-group">

                            <div class="input-group-addon">

                                 <i class="fa fa-search"></i>

                            </div>

	                    <input type="text" class="form-control input-lg" placeholder="Search by Remark" name="Search" value="">

	                    </div>

                      </div>

	                    <span id="Name"></span>

	              	</div>

	          	</div>

	          	<br>

	          	<div class="row">

	          		 <div class="col-md-6 col-md-offset-6">

		                  <button type="submit" class="btn btn-primary ">Show</button>

		              </div>

	          	</div>

            </form>

        </div>

      </div>

</div>

</div>



<!-- datpicker -->

<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>

<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>

<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>

<script type="text/javascript">

$('.reportrange span').html(moment().format('MMMM D, YYYY') + ' - ' + moment().add(30, 'days').format('MMMM D, YYYY'));
        $('.reportrange').daterangepicker({
            format: 'MM/DD/YYYY',
            startDate: moment(),
            endDate: moment().add(30, 'days'),
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Next 7 Days': [moment(), moment().add(6, 'days')],
                'Next 30 Days': [ moment(),moment().add(29, 'days')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'right',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-default',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        }, function(start, end, label) {

  $('#reportrange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

});



</script>