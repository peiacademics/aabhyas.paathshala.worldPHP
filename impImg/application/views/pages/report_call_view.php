<div class="page-content">

  <div class="row">

    <div class="ibox">

      <!-- <div class="ibox-title">

      <h5><?php echo ucfirst($this->lang_library->translate('Reports')); ?></h5>

      </div> -->





  <!-- <div class="ibox-content"> -->

    <div class="row">

      <div class="col-sm-12">

      <div class="ibox float-e-margins">

          <div class="ibox-title">

              <h5><i class="fa fa-newspaper-o"></i> Call Status </h5>

              <div class="ibox-tools">

                  <a class="collapse-link">

                      <i class="fa fa-chevron-up"></i>

                  </a>

                  <a class="close-link">

                      <i class="fa fa-times"></i>

                  </a>

              </div>

          </div>

          <div class="ibox-content">

              <div class="container-fluid">

                    <br>

                  <div class="row">

                    <form method='post' action='#' id="sellData">

                      <!-- <div class="col-sm-1 col-xs-6 ">

                        Select

                      </div> -->

                      <div class="col-sm-4 col-xs-12">
                        <label>Select Date Range</label>
                        <input class="form-control daterange" name="date" placeholder="Date">
                        <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo $branch_ID; ?>">
                      </div>
                      <div class="col-sm-1">&nbsp;</div>
                      <div class="col-sm-4 col-xs-12">
                        <label>Select Call Status</label>
                        <select class="country form-control chosen-select" name="Status" id="select1">
                          <option value="" disabled="disabled" selected="selected">Call Status</option>
                          <option value="">All</option>
                          <option value="recall">Recall</option>
                          <option value="customer">Customer</option>
                          <option value="noResponce">No Response</option>
                          <option value="called">Called</option>
                          <option value="lead">Leads</option>
                          <option value="abort">Not Intrested</option>
                        </select>
                      </div>
                      </form> 
                      <div class="col-sm-1">&nbsp;</div>
                      <div class="col-sm-2 col-xs-12">
                        <label>&nbsp;</label>
                        <button id="getSell" class="btn btn-block btn-primary input-md" >Go!</button>
                      </div>
                  </div>
                  </div>
            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
        </div>





        <div class="ibox float-e-margins border-bottom">

          <div class="ibox-title">
              <h5><i class="fa fa-newspaper-o"></i> Call Status Table </h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-down"></i>
                  </a>
              </div>
          </div>

          <div class="row">

            <div class="col-sm-12">

              <div class="ibox-content table-responsive">

              <div id="data_table">

                <table id="exampleSell" class="table table-striped table-bordered" cellspacing="0" >

                </table> 

                </div>

              </div>

            </div>

          </div>

        </div>



      </div>

    </div>

  <!-- </div> -->

</div>





  </div>

</div>

</div>



    <link href="<?php echo base_url("css/plugins/morris/morris-0.4.3.min.css"); ?>" rel="stylesheet">

    <link href="<?php //echo base_url("css/AdminLTE.css"); ?>" rel="stylesheet">

<!-- Sweet alert -->

    <script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>        



<!-- Date -->

<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>

<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>

<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>   



<!-- Custom and plugin javascript -->

<script src="<?php echo base_url("js/plugins/morris/morris.js"); ?>"></script>

<script src="<?php echo base_url("js/plugins/morris/raphael-2.1.0.min.js"); ?>"></script>

<!-- datatables -->

    <script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>

    <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>

    <script src="<?php //echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>

    <script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>

    <script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.min.js"); ?>"></script>

  <script src="<?php echo base_url("js/plugins/dataTables/responsive.bootstrap.min.js"); ?>"></script>

<link href="<?php echo base_url("css/plugins/dataTables/buttons.dataTables.min.css"); ?>" rel="stylesheet">

    <script src="<?php echo base_url("js/plugins/dataTables/dataTables.buttons.min.js"); ?>"></script>

    <script src="<?php echo base_url("js/plugins/dataTables/buttons.print.min.js"); ?>"></script>

    <!-- main js -->

<script src="<?php echo base_url("js/sellsReport.js"); ?>"></script>

 <!-- ChartJS-->

    <script src="<?php //echo base_url("js/plugins/chartJs/Chart.min.js"); ?>"></script>

    <script src="<?php //echo base_url("js/demo/chartjs-demo.js"); ?>"></script>

<script type="text/javascript">
  $('.chosen-select').chosen();
</script>

