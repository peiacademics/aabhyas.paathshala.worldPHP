<div class="row">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Student's Doubts</h2>
                  
                    <div class="input-group">
                        <input type="text" placeholder="Search Student" id="search" class="input-sm form-control"> 
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> 
                        </span>
                    </div>
              
                    <div class="clients-list">
                      <div class="tab-content">
                              <div class="full-height-scroll">
                                  <div class="table-responsive">
                                      <table class="table table-striped table-hover" id="table">
                                          <tbody>
                                          <?php if (@$Team) {
                                             $i = 0;
                                             foreach ($Team as $key => $value) {
                                              $i++;
                                          ?>
                                          <tr id="row-<?php echo $key; ?>">
                                              <td class="client-avatar"><img alt="image" src="<?php echo base_url().$value['path']; ?>"> </td>
                                              <td><a class="client-link"><?php echo ucfirst(@$value['name']); ?></a></td>
                                              <td><span class="label label-danger-light pull-right"><?php echo $this->str_function_library->call('fr>SB>name:ID=`'.@$value['subject_ID'].'`'); ?></span></td>
                                              <td class="text-info"><strong class="text-muted pull-right"><i class='fa fa-clock-o'></i> <?php echo date('l, F d h:i a', strtotime($value['Added_on_og']));?></strong></td>
                                              <td><span class="label label-danger"><?php echo $value['doubt_status'];?></span></td>
                                              <td ><button class="btn <?php echo ($value['doubt_status'] === 'raised')? 'btn-warning' :'btn-primary' ;?> bbd" onClick="resolve_doubt('<?php echo $value['ID']; ?>','<?php echo $key; ?>')"><i class="fa fa-check ffc ddd"></i></button></td>
                                          </tr>
                                          <?php } }else{ ?>
                                          <tr>
                                              <td class="client-avatar"><img alt="image" src="img/user.jpg"> </td>
                                              <td colspan="5">No Doubts Pending</td>
                                          </tr>
                                          <?php } ?>
                                          <input type="hidden" id="count" value="<?php echo @$i; ?>">
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    var cnt = 0;
  $("#search").keyup(function(){
    _this = this;
      // Show only matching TR, hide rest of them
      $.each($("#table tbody tr"), function() {
          if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
             $(this).hide();
          else
             $(this).show();                
      });
  });

  function resolve_doubt(id,key)
  {
    var count = $('#count').val();
    var data = '';
    bootbox.confirm('Are you sure, you want to make it asked ?', function(result) {
      if(result == true)
      {
        $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
        $("#Login_screen").fadeIn('fast');
        $.ajax({
          type:'POST',
          data:{'ID':id},
          dataType:'json',
          url: '<?php echo base_url(); ?>'+'team/resolve_doubt',
          success:function(response)
          {
            $("#Login_screen").fadeOut(2000);
            if(response == true)
            {
                $('#row-'+key).addClass('hidden');
                swal("! Done !", "Doubt resolved Successfully.", "success");
                cnt++;
                if(cnt == count)
                {
                    data = '<tr><td class="client-avatar"><img alt="image" src="img/user.jpg"> </td><td colspan="5">No Doubts Pending</td></tr>';
                    $('#table').append(data);
                }
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
<script src="<?php //echo base_url('js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
<script src="<?php echo base_url('js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>