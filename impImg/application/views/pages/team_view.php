<div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">

                            <div class="row">

        <?php if ($Team) {

            foreach ($Team as $key => $value) {

                $a = $key + 1;

                if ($key == 0) 

                {

                    $key = 1;

                }

                if ($key%4 == 0) 

                { 

                    ?>

                    </div>

                    <div class="row">

               <?php } ?>

            <div class="col-lg-3" id="remove<?php echo $value['employee_ID'];?>">

                <div class="contact-box center-version">

                    <a href="<?php echo base_url('Team/View/'.$value["employee_ID"]);?>">

                        <img alt="image" class="img-circle" src="<?php echo $this->str_function_library->call('fr>SS>path:ID=`'.$value['img_ID'].'`'); ?>">

                        <h3 class="m-b-xs"><strong><?php echo ucfirst($value['Name']); ?></strong></h3>

                        <div class="font-bold"><?php echo $this->str_function_library->call('fr>DS>post:ID=`'.$value['Position_ID'].'`'); ?></div>

                        <address class="m-t-md">

                            <strong>Twitter, Inc.</strong><br>

                            <?php $addr = explode(',', $value['address_ID']);

                            echo $this->str_function_library->call('fr>AD>address:ID=`'.rtrim($addr[0],',').'`'); ?><br>

                            <abbr title="Phone">P:</abbr><?php $phone = explode(',', $value['phone_no_ID']);  echo $this->str_function_library->call('fr>PH>phone_number:ID=`'.$phone[0].'`'); ?>

                        </address>

                    </a>

                    <div class="contact-box-footer">

                        <div class="m-t-xs btn-group">

                            <a href="<?php echo base_url('Team/View/'.$value["employee_ID"]);?>" class="btn btn-xs btn-white"><i class="fa fa-eye"></i> View </a>

                            <a href="<?php echo base_url('Team/edit/'.$value["employee_ID"]);?>" class="btn btn-xs btn-white"><i class="fa fa-pencil"></i> Edit</a>

                            <button onClick="del1('<?php echo $value["employee_ID"]; ?>');" class="btn btn-xs btn-white"><i class="fa fa-trash"></i> Delete</button>

                        </div>

                    </div>



                </div>

            </div>

            <?php if (count($Team) == $a) 

               {

                   if (count($Team)%4 !== 0) 

                   { 

                    ?>

                        </div>       

            <?php  }

               }

            ?>

            <?php }

        }

            else{

                echo "No Team members";

                }?>

        </div>

        </div>

<script type="text/javascript">

function del1(id)

{

    bootbox.confirm('Are you sure you want to delete?', function(result) {

    if(result == true)

    {

      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader.gif"></div>');

      $("#Login_screen").fadeIn('fast');

      $.ajax({

        url:'<?php echo base_url(); ?>'+'Team/delete/'+id,

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

          response = JSON.parse(response);

          if(response === true)

          {

            toastr.success('Successfully deleted.');
            setTimeout(function(){
              $("#remove"+id).fadeOut(1500);
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

</script>