<div class="page-content">
  <div class="row">
    <div class="pull-right">
     <a href="<?php echo base_url('Abhyas_video/add'); ?>"><button typer="button" class="btn btn-w-m btn-primary dim btn-outline"><i class="fa fa-plus"></i> Add VIDEO</button></a>
    </div>
    <div class="ibox">
      <!-- <div class="ibox-title">
        <h5><?php echo ucfirst($this->lang_library->translate('Abhyas Video')); ?></h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div> -->
      <div class="ibox-content">
        <div id="data_table" class="row">
        <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Subject</th>
              <th>Lesson</th>
              <th>Topic</th>
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

<div class="modal inmodal in" id="Abhyas_video_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated flipInX">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Video</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 form-group">
            <label class="col-sm-3 control-label">Select Speed : </label>
            <div class="col-sm-3 form-group">
              <select class="form-control" id="speed" placeholder="Select Speed" onChange="change_speed()">
                <option value="0.25">0.25</option>
                <option value="0.5">0.5</option>
                <option value="0.75">0.75</option>
                <option value="1" selected>Normal</option>
                <option value="1.25">1.25</option>
                <option value="1.5">1.5</option>
                <option value="1.75">1.75</option>
                <option value="2">2</option>
              </select>
            </div>
            <div class="col-sm-6">
              <button class="btn btn-default" onClick="backward()"><i class="fa fa-minus"></i></button>
              <label class="control-label"> Backward / Forward </label>
              <button class="btn btn-default" onClick="forward()"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 text-center">
            <video width="420" id="frame_ID" controls controlsList="nodownload"></video>
          </div>
        </div>
      </div><!-- /.modal-content -->
      <div class="modal-footer">
        <div class="row text-center">
          <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true"> Close</button>
        </div>
      </div>
    </div><!-- /.modal-dialog -->
  </div>
</div>

<!-- Data Tables -->
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<!-- <script src="<?php echo base_url("js/plugins/dataTables/dataTables.bootstrap.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.responsive.js"); ?>"></script>
 --><script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
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
    oTable = $('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?php echo base_url('Abhyas_video/get_show_data'); ?>",
      dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('.dt-buttons').css({'float':'right'});
  });
  
  function view_video(id)
  { 
    var base_url = '<?php echo base_url(); ?>';
    $.ajax({
      type:'POST',
      url: '<?php echo base_url(); ?>'+'Abhyas_video/view_video/'+id,
      success:function(response)
      {
        response = JSON.parse(response);
        $('#frame_ID').attr('src',base_url+response);
        $('#frame_ID').bind('contextmenu',function() {
          return false;
        });
        $('#Abhyas_video_view').modal('show');
      }
    })
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

  function change_speed()
  {
    var vid = document.getElementById("frame_ID");
    var rate = $('#speed').val();
    vid.playbackRate = rate;
  }

  function backward()
  {
    var vid = document.getElementById("frame_ID");
    var time = vid.currentTime;
    time = time - 15;
    vid.currentTime = time;
  }

  function forward()
  {
    var vid = document.getElementById("frame_ID");
    var time = vid.currentTime;
    time = time + 15;
    vid.currentTime = time;
  }
</script>