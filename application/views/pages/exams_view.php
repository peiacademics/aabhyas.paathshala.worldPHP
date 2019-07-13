<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/jquery.dataTables.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/responsive.dataTables.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script src="<?php echo base_url('js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('js/buttons.flash.min.js'); ?>"></script>
<script src="<?php echo base_url('js/jszip.min.js'); ?>"></script>
<script src="<?php echo base_url('js/pdfmake.min.js'); ?>"></script>
<script src="<?php echo base_url('js/vfs_fonts.js'); ?>"></script>
<script src="<?php echo base_url('js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('js/buttons.print.min.js'); ?>"></script>

<div class="col-xs-12 white-bg shadow">
    <h2 class="text-center"><?php echo @$breadcrumb['heading']; ?> </h2>
    <ol class="breadcrumb text-center">
        <?php
        if(isset($breadcrumb['route']))
        { 
            foreach ($breadcrumb['route'] as $route)
            {
                if(is_array($route))
                {
                    echo "<li><a href=".base_url($route['path']).">".$route['title']."</a></li>";
                }
                else
                {
                    echo "<li class='active'><strong>".$route."</strong></li>";
                }
            }
        }
        ?>

        </li>
    </ol>
    <hr>
    <a href="<?php echo base_url('exams/add'); ?>"><button class="btn btn-block btn-lg dim btn-outline btn-primary">Add Exam</button></a>
    <div class="float-e-margins">
            <div id="data_table" class="row">
            <table id="example" class="display responsive" cellspacing="0" >
              <thead>
                <tr>
                  <th>Name</th>
                  <th>No. of Questions in Exams</th>
                  <th>Marks per Question in Exams</th>
                  <th>Exam Duration (in Minutes)</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
    </div>
</div>

<!-- Sweet alert -->
<script src="<?php echo base_url('js/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

<script type="text/javascript">

$(document).ready(function() {
    oTable = $('#example').DataTable({
        "responsive": true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url('exams/get_show_data'); ?>",
         "dom": 'lBftip',
        "buttons": [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
    });
    $('.dt-buttons').css({'float':'right'});

});



function deletef(id,href)
{
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if(result == true)
    {
      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
      $("#Login_screen").fadeIn('fast');
      console.log(id);
      $.ajax({
        url:href,
        method:'POST',
        datatype:'JSON',
        error: function(jqXHR, exception) {
                $("#Login_screen").fadeOut(2000);
                //Remove Loader
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
          console.log(response);
          response = JSON.parse(response);
          console.log(response);
          if(response === true)
          {
            swal({
              title: 'Done',
              text: 'Successfully Deleted.',
              type: "success"               
              },
              function(){
                oTable.ajax.reload();
              }
            );
          }
          else
          {
            swal("Oops...", "Something went wrong!", "error");
          }
        }
      });
    }
  });
}
</script>