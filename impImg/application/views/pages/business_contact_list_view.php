 <div class="row text-right">
      <a href="<?php echo base_url('Business_contact/add')?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>   
 </div>
        <div class="row">
          <div class="ibox">
            <!-- <div class="ibox-title">
                <h5>Business Contact</h5>
                <div class="ibox-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
                  <a class="close-link">
                    <i class="fa fa-times"></i>
                  </a>
                </div>
            </div> -->
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                    <?php
                    $i =0;
                    $j =0;
                      if(!is_null($DETAIL['Category']))
                      { ?>
                        <div class='tabs-container'>
                        <ul class='nav nav-pills nav-justified'>
                        <?php foreach($DETAIL['Category'] as $row)
                        {
                          $i++;
                            // $title = $this->lang_library->translate($row['Title']);
                    ?>
                            
                              <li class="<?php echo $i==1 ? 'active' : '' ?>"><a data-toggle="tab" href="#tab-<?php echo $i; ?>" aria-expanded="true"><i class="fa fa-phone"></i> <?php echo $row['name']; ?></a></li>
                            
                    <?php
                        } ?>
                        </ul>
                        <div class="project-list">
                        <div class='tab-content'>
                        <?php foreach($DETAIL['Category'] as $value)
                        {
                          $j++;
                            // $title = $this->lang_library->translate($row['Title']);
                    ?>
                            <div id="tab-<?php echo $j; ?>" class="tab-pane <?php echo $j==1 ? 'active' : ''; ?>">
                              <div class="panel-body">
                                <div id="" class="">
                                  <div class="input-group">
                                      <input type="text" placeholder="Search <?php echo $value['name']; ?>" id="search<?php echo $j; ?>" class="input-sm form-control"> 
                                      <span class="input-group-btn">
                                      <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> 
                                      </span>
                                  </div>
                                  <!-- <div class="clients-list"> -->
                                    <!-- <div class="full-height-scroll">
                                      <div class="table-responsive"> -->
                                        <!-- <table id="table" class="table table-striped table-bordered" cellspacing="0" > -->
                                        <table id="table<?php echo $j; ?>" class="table table-hover" cellspacing="0" >
                                        <?php
                                        
                                          if (!is_null($value['Contact'])) 
                                          {
                                            $l =0;
                                            foreach ($value['Contact'] as $k => $v) 
                                            {
                                              $l++;
                                              if ($l==1) 
                                              { ?>
                                                <!-- <thead>
                                                  <tr>
                                                    <th>Name</th>
                                                    <th>No.</th>
                                                    <th>Actions</th>
                                                  </tr>
                                                
                                                </thead> -->
                                                <?php }
                                              ?>
                                            <tbody>
                                            <tr>
                                              <td class="project-status">
                                                  <span class=""><a href="tel:<?php echo $v['phone'];?>"><i class="fa fa-phone" aria-hidden="true"></i></a></span>
                                              </td>
                                              <td class="project-title"><a><?php echo $v['name']; ?></a></td>
                                              <td class="project-title"><a><?php echo $v['phone']; ?></a></td>
                                              <td><button class='btn btn-primary' onclick="open_modal('<?php echo $v["ID"]; ?>')"><i class="fa fa-eye" aria-hidden="true"></i></button></td>
                                            </tr>
                                            </tbody>
                                              
                                            <?php }
                                          }
                                          else
                                          {
                                        ?>
                                          <!-- <thead>
                                            <tr>
                                              <th>Name</th>
                                              <th>No.</th>
                                              <th>Actions</th>
                                            </tr>
                                          
                                          </thead> -->
                                          <tbody>
                                            <tr>
                                              <td colspan="4">No data available</td>
                                            </tr>
                                          </tbody>
                                          <?php } ?>
                                        </table>

                                      <!-- </div>
                                    </div> -->

                                  <!-- </div> -->
                                </div>
                              </div>
                            </div>  
                    <?php
                        } ?>
                        </div>
                        </div>
                        </div>

                      <?php }
                      else
                      {
                          echo '<li>No Business Contact Available.</li>';
                      }
                    ?>      
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Details</h4>
      </div>
      <div class="modal-body">
        <span class="loading" style="display:none;"><i class="fa fa-spinner fa-4 fa-spin"></i></span>
        <form class="form-horizontal" role="form" action="<?php echo base_url('billing/send/'); ?>" method="post" id="mail">
          <input type="hidden" id="b_id">
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <label>Name : </label>
                  <span id="name"></span>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <label>Business Name : </label>
                  <span id="b_name"></span>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <label>Email : </label>
                  <span id="email"></span>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <p><i class="fa fa-phone"></i><b> Contact :</b></p>
                  <div id="phone" class="col-md-11 col-md-offset-1"></div>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <p><i class="fa fa-map-marker"></i><b> Address :</b></p>
                  <div id="address" class="col-md-11 col-md-offset-1"></div>
              </div> 
            </div>                         
          </div>
          
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <label>Reference : </label>
                  <span id="reference"></span>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <label>Website : </label>
                  <span id="website"></span>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <label>Category : </label>
                  <span id="category"></span>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  <label>Branch : </label>
                  <span id="branch"></span>
              </div> 
            </div>                         
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                <button type="button" class="btn btn-primary" onClick="editdata()">Edit</button>
                <!-- <a href="<?php echo base_url('Customer/delete/'.@$DETAIL['View'][0]['ID']); ?>" class="btn btn-danger btn-sm btn-block" id="delete"><i class="fa fa-trash"></i> Delete</a> -->
                <button type="button" class="btn btn-danger" id="delete">Delete</button> 
                <!-- <button type="button" class="btn btn-danger" onClick="deletedata()">Delete</button>  -->
              </div> 
            </div>                         
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary" onClick="senddata()">Send</button> -->
      </div>
                </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>



        <script type="text/javascript">
          // $("#search").keyup(function(){
          //   _this = this;
          //     // Show only matching TR, hide rest of them
          //     $.each($("#table tbody tr"), function() {
          //         if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          //            $(this).hide();
          //         else
          //            $(this).show();                
          //     });
          // });

          function open_modal(id)
          {
            $.ajax({
              type:'POST',
              dataType:'json',
              url: '<?php echo base_url(); ?>'+'Business_contact/get_contact/'+id,
              success:function(response){
                if(typeof response === 'object')
                {
                  console.log(response[0].name);
                  $('#b_id').val('');
                  $('#name').html("");
                  $('#b_name').html("");
                  $('#email').html("");
                  $('#reference').html("");
                  $('#website').html("");
                  $('#category').html("");
                  $('#branch').html("");
                  $('#phone').html("");
                  $('#address').html("");

                  $('#b_id').val(response[0]['ID']);
                  document.getElementById('name').innerHTML = response[0].name;
                  document.getElementById('b_name').innerHTML = response[0].business_name;
                  document.getElementById('email').innerHTML = response[0].email;
                  document.getElementById('reference').innerHTML = response[0].reference;
                  document.getElementById('website').innerHTML = response[0].website;
                  document.getElementById('category').innerHTML = response[0].category;
                  document.getElementById('branch').innerHTML = response[0].branch;
                  // $('#name').val(response[0].name);

                  if (response['List']['Phone'] == null || response['List']['Phone'] == '')
                  {
                    $('<p><b>No Cotacts</b></p>').appendTo('#phone');
                  }
                  else 
                  {
                    $.each(response['List']['Phone'], function(key, v){                    
                      $('<p><b>'+v.phone_type+' :</b>'+v.phone_number+'</p>').appendTo('#phone');
                    });
                  }

                  if (response['List']['Address'] == null || response['List']['Address'] == '')
                  {
                    $('<p><b>No Address</b></p>').appendTo('#address');
                  }
                  else 
                  {
                    $.each(response['List']['Address'], function(key, v){                    
                      $('<p><b>'+v.address_type+' :</b>'+v.address+'</p>').appendTo('#address');
                    });
                  }
                    
                  $('#myModal').modal('show');
                  //window.location.href = "<?php echo base_url('Business_contact/list_view/'); ?>"
                }
                else
                {
                  setTimeout(function(){
                    window.location.href = "<?php echo base_url('Business_contact'); ?>";
                  }, 3000);
                }
              }
            });
          }

          function editdata()
          {
            var id = $('#b_id').val();
            window.location.href = "<?php echo base_url(); ?>"+"Business_contact/add/"+id
          }

          $('#delete').on('click',function(e){
            var id = $('#b_id').val();
              e.preventDefault();
            // var href = $('#delete').attr('href');
            bootbox.confirm('Are you sure you want to delete?', function(result) {
              if (result == true) {
                window.location.href = "<?php echo base_url(); ?>"+"Business_contact/delete/"+id
            }
            else
            {
              e.preventDefault();
            }
          });
        });


          <?php
          $c = 0;
          foreach ($DETAIL['Category'] as $key => $value) 
          {
            $c++; ?>      
            $("#search<?php echo $c;?>").keyup(function(){
            _this = this;
              // Show only matching TR, hide rest of them
              $.each($("#table<?php echo $c;?> tbody tr"), function() {
                  if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                     $(this).hide();
                  else
                     $(this).show();                
              });

          });

             <?php }
          ?>
          

        </script>