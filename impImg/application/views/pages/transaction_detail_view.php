 <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
  <div class="col-md-10">
    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Transaction Details </h5>
                    </div>
                    <div class="ibox-content">
                      <?php
                        $detail = @$DETAIL['View'][0]['other_details'];
                          //$bank = @$DETAIL['View'][0]['bank_ID'];
                          $bank = ($DETAIL['View'][0]['bank_ID'] == 'BASK10000001') ? '' : $DETAIL['View'][0]['bank_ID'];
                          $payment = @$DETAIL['View'][0]['payment_mode_ID'];
                          $expence = @$DETAIL['View'][0]['expence_category_ID'];
                          $date2 = @$DETAIL['View'][0]['date'];
                            $ref = @$DETAIL['View'][0]['referance_Name'];
                        $b = $this->str_function_library->call('fr>BA>bank_name:ID=`'.$bank.'`').' ('.$this->str_function_library->call('fr>BA>branch_name:ID=`'.$bank.'`').')';
                         $p = $this->str_function_library->call('fr>PM>title:ID=`'.$payment.'`');
                         $e = $this->str_function_library->call('fr>EC>title:ID=`'.$expence.'`');
                          $d = $this->str_function_library->call('fn>library>date_library:db2date(`'.$date2.'`)');
                          if (strpos($ref, 'US') !== false) 
                          {
                            $r = $this->str_function_library->call('fr>US>Name:ID=`'.@$ref.'`');  
                          }
                          else if (strpos($ref, 'ST') !== false) 
                          {
                            $r = $this->str_function_library->call('fr>ST>Name:ID=`'.@$ref.'`');  
                          }
                          else if (strpos($ref, 'BA') !== false) 
                          {
                            $r = $this->str_function_library->call('fr>BA>bank_name:ID=`'.@$ref.'`');  
                          }
                          else
                          {
                            $r = '-NA-';
                          } 
                      ?>
                        <table class="table table-striped">
                            <thead>
                            
                            </thead>
                            <tbody>
                              <tr>
                                <th>Transaction Type</th>
                                <td><?php echo @$DETAIL['View'][0]['transaction_type']; ?></td>
                            </tr>
                            <tr>    
                                <th>Amount</th>
                                <td><?php echo @$DETAIL['View'][0]['amount']; ?></td>
                            </tr>
                             <?php
                                if (!empty($detail)) {?>
                            <tr>
                                <th>Other Details</th>
                                <td><?php echo $detail; ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th>Date</th>
                                <td><?php echo $d; ?></td>
                            </tr>
                            <tr>
                                <th>Payment Mode</th>
                                <td><?php echo $p; ?></td>
                            </tr>
                             <?php
                            if (!empty($bank)) {?>
                            <tr>
                                <th>Bank</th>
                                <td><?php echo $b; ?></td>
                            </tr> 
                            <?php } ?>
                            <tr>       
                                <th>Expence Category</th>
                                <td><?php echo $e; ?></td>
                            </tr>
                            <tr>       
                                <th>Reference</th>
                                <td><?php echo $r; ?></td>
                            </tr>
                           </tbody>
                        </table>
                    </div>
                </div>
                 <div class="user-button">
                  <div class="row">
                        <div class="col-md-6">
                          <a href="<?php echo base_url('transaction/add/'.@$DETAIL['View'][0]['ID']); ?>" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i> Edit Details</a>
                      </div>
                      <div class="col-md-6">
                          <a href="<?php echo base_url('transaction/delete/'.@$DETAIL['View'][0]['ID']); ?>" class="btn btn-danger btn-sm btn-block" id="delete"><i class="fa fa-trash"></i> Delete</a>
                      </div>
                  </div>
                </div>
   </div> 
 </div>
</div>

<script type="text/javascript">

$(document).ready(function() {
 $('#A255ef9db8487b82a24f6031d1fd4e4fc').addClass('active');
            $("#A255ef9db8487b82a24f6031d1fd4e4fc").parent().parent().addClass("active");
            $("#A255ef9db8487b82a24f6031d1fd4e4fc").parent().addClass("in");
    $('#delete').on('click',function(e){
      e.preventDefault();
    var href = $('#delete').attr('href');
    bootbox.confirm('Are you sure you want to delete?', function(result) {
    if (result == true) {
        $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
          $("#Login_screen").fadeIn('fast');
          $.ajax({
        url:href,
        method:'POST',
        datatype:'JSON',
        success:function(response){
          response = JSON.parse(response);
          if(typeof response === 'object')
          {
            window.location.href = "<?php echo base_url('transaction'); ?>";
          }
          else
          {
            if(response === true)
            {
              toastr.success('Successfully deleted.');
              setTimeout(function(){
                window.location.href = "<?php echo base_url('transaction'); ?>";
              }, 3000);
            }
            else
            {
              toastr.error('Something went wrong!');
              setTimeout(function(){
                window.location.href = "<?php echo base_url('transaction'); ?>";
              }, 3000);
            }
          }
        }
      });
    }
    else
    {
      e.preventDefault();
    }
  });
});
});


$("#send").on("click",function(e){
      e.preventDefault();
      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');
      $("#Login_screen").fadeIn('fast');
      var formdata=$("#smail").serialize();
      $.ajax({
        data:formdata,
        type:'POST',
        url: '<?php echo base_url(); ?>'+'transaction/sendMailToUser',
        success:function(result)
        {
          $("#Login_screen").fadeOut(200);
          if (typeof result==='object')
          {
              $.each(result, function(key,value){
                $("#"+key).html(value);
              });
          }
          else if (result){
            toastr.success('Mail sent Successfully.');
            setTimeout(function(){
              $("#sendMail").modal("hide");
              return false;
            }, 3000);
          }
          else
          {
            toastr.error("Something went wrong!");
          }
        }
      });
    });
</script>