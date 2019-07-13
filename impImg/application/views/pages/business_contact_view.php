 <div class="row text-right">
      <a href="<?php echo base_url('Business_contact/add')?>"><button class=" btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i></button></a>   
 </div>
<div class="row">
    <div class="ibox-content">
        <div class="row">
            <?php
              if(!is_null($Branch))
              {
                foreach($Branch as $row)
                {
            ?>
                    <div class="col-sm-2 col-xs-4 text-center">
                        <button class="btn btn-primary dim btn-large-dim" type="button" onclick="submit('<?php echo $row['ID']; ?>')">
                          <i class="fa fa-book" aria-hidden="true"></i>
                          <h5 class=""><?php echo @$row['name']; ?></h5>
                        </button>
                    </div>
            <?php
                }
              }
              else
              {
                  echo '<li>No Branch Available.</li>';
              }
            ?>      

        <!-- <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">Last modification: <i class="fa fa-clock-o"></i> 2:10 pm - 12.06.2014</span>
                    <h2>Students</h2>
                  
                    <div class="input-group">
                        <input type="text" placeholder="Search Student" id="search" class="input-sm form-control"> 
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search</button> 
                        </span>
                    </div>

                    <div class="clients-list">
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="table">
                                        <tbody>
                                        <tr>
                                            <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td>
                                            <td><a data-toggle="tab" href="#contact-1" class="client-link">Anthony Jackson</a></td>
                                            <td> Tellus Institute</td>
                                            <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                            <td> gravida@rbisit.com</td>
                                            <td class="client-status"><span class="label label-primary">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td class="client-avatar"><img alt="image" src="img/a3.jpg"> </td>
                                            <td><a data-toggle="tab" href="#contact-2" class="client-link">Rooney Lindsay</a></td>
                                            <td>Proin Limited</td>
                                            <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                            <td> rooney@proin.com</td>
                                            <td class="client-status"><span class="label label-primary">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td class="client-avatar"><img alt="image" src="img/a4.jpg"> </td>
                                            <td><a data-toggle="tab" href="#contact-3" class="client-link">Lionel Mcmillan</a></td>
                                            <td>Et Industries</td>
                                            <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                            <td> +432 955 908</td>
                                            <td class="client-status"></td>
                                        </tr>
                                        <tr>
                                            <td class="client-avatar"><a href=""><img alt="image" src="img/a5.jpg"></a> </td>
                                            <td><a data-toggle="tab" href="#contact-4" class="client-link">Edan Randall</a></td>
                                            <td>Integer Sem Corp.</td>
                                            <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                            <td> +422 600 213</td>
                                            <td class="client-status"><span class="label label-warning">Waiting</span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div> -->
        </div>
    </div>
</div>

        <script type="text/javascript">
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

          function submit(id)
          {
            window.location.href =  '<?php echo base_url(); ?>'+'Business_contact/transfer/'+id
            // $.ajax({
            //   type:'POST',
            //   dataType:'json',
            //   url: '<?php echo base_url(); ?>'+'Business_contact/transfer/'+id,
            //   success:function(response){
            //     if(response === true)
            //     {
            //       window.location.href = "<?php echo base_url('Business_contact/list_view/'); ?>"
            //     }
            //     else
            //     {
            //       swal({
            //           title: '',
            //           text: 'There is no any business contact.',
            //           type: "error"               
            //         },
            //           function()
            //           {
            //              window.location.href = "<?php echo base_url('Business_contact'); ?>"
            //           }
            //       );
            //     }
            //   }
            // });
          }
        </script>