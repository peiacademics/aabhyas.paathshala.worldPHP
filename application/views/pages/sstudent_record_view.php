<div class="page-content">
  <div class="row">
    <div class="ibox">
      <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Test Record')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">
        <input type="hidden" id="student_ID" value="<?php echo $student_ID; ?>">
        <div id="data_table" class="">
          <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Date</th>
                <th>Subject</th>
                <th>Lesson</th>
                <th>Topic</th>
                <th>Test</th>
                <th>Passing Marks</th>
                <th>Obtained Marks</th>
                <th>Maximum Marks</th>
                <th>Result</th>
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

<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script> -->
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script> -->
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
<script src="<?php echo base_url("js/plugins/pdfjs/pdf.js"); ?>"></script>

<script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var student_ID = $('#student_ID').val();
    var login_as = '<?php echo $this->data['Login']['Login_as']; ?>';
    oTable = $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      responsive:true,
      "dom": 'lBftipB',
      "ajax": "<?php echo base_url('Atest/get_show_data'); ?>"+'/'+student_ID,
      "buttons": [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
    $('.dt-buttons').css({'float':'right'});
    setInterval(function(){
      if(login_as == 'DSSK10000011')
      {
        $('.label-danger').addClass('hidden');
      }
    }, 100);
  });
</script>