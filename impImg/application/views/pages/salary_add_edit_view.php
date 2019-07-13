<div class="page-content">

            <div class="wrap">

              <h4 id="success" style="text-align:center;"></h4>

                <div class="ibox-content">

                    <form class="form-horizontal" role="form" action="<?php echo base_url('designation/add'); ?>" method="post" id="expense_add">



                        <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">



                        <div class="form-group">

                              <label  class="col-sm-2 control-label">Designation : </label>

                              <div class="col-sm-10">

                              <input type="text" class="form-control" id="post" placeholder="Designation" name="post" value="<?php echo @$View['post']; ?>">

                                

                              </div>

                                <span id="title"></span>

                          </div>



                          <!-- <div class="form-group">

                            <div class="row">

                          <div class="col-sm-12">

                                  <div class="col-sm-2 control-label">

                                    <label>Perticulars:</label> 

                                  </div>

                                  <div class="col-sm-3">

                                    <label>Perticulars</label> 

                                  </div>

                                  <div class="col-sm-2">

                                    <label>Price</label> 

                                  </div>

                                  <div class="col-sm-2">

                                    <label>Status</label> 

                                  </div>

                                  <div class="col-sm-2">

                                    <label>Type</label> 

                                  </div>

                                </div>

                            </div>                           

                          </div> -->



                                                    <!-- <?php if(isset($List))

                              {

                                $i = 0;

                                foreach(@$List as $col_val)

                                {

                                  $i++;

                        ?>    



                          <div class="form-group" id="product_div-<?php echo $i; ?>">

                            <input type="hidden" name="PP-ID-<?php echo $i; ?>" value="<?php echo @$col_val['ID'];?>">



                                <div class="col-sm-2 control-label">

                                </div>



                                <div class="col-sm-3">

                                  <input type="text" class="form-control" id="PP-perticular-<?php echo $i; ?>" name="PP-perticular-<?php echo $i; ?>" placeholder="Perticular" value="<?php echo @$col_val['perticular']?>" required>

                                </div>

                                <div class="col-sm-2">

                                  <input type="number" class="form-control" id="PP-amount-<?php echo $i; ?>" name="PP-amount-<?php echo $i; ?>" placeholder="Amount" value="<?php echo @$col_val['amount']?>" min="<?php echo $i; ?>" required>

                                </div>

                                <div class="col-sm-2">

                                  <select name="PP-payStatus-<?php echo $i; ?>" class="form-control chosen-select" required >

                                    <option value="">Select Status</option>

                                    <option value="Static" <?php echo ($col_val['payStatus']==='Static') ? 'selected' :''; ?> >Static</option>

                                    <option value="Dynamic" <?php echo ($col_val['payStatus']==='Dynamic') ? 'selected' :''; ?>>Dynamic</option>

                                  </select>

                                </div>

                                <div class="col-sm-2">

                                  <select name="PP-amountType-<?php echo $i; ?>" class="form-control chosen-select" required >

                                    <option value="">Select Type</option>

                                    <option value="E" <?php echo ($col_val['amountType']==='E') ? 'selected' :''; ?> >Earning</option>

                                    <option value="D" <?php echo ($col_val['amountType']==='D') ? 'selected' :''; ?>>Deduction</option>

                                  </select>

                                </div>

                              

                              <div class="col-sm-1">

                        <?php if($i === 1)

                              {

                        ?>

                                <button type="button" class="btn btn-white btn-bitbucket add_product">

                                    <i class="fa fa-plus"></i>

                                </button>

                        <?php }

                              else

                              {

                        ?>

                                <button type="button" class="btn btn-danger btn-bitbucket remove_product" onclick="remove_perticular('<?php echo @$col_val['ID']?>','product_div-<?php echo $i;?>');"><i class="fa fa-trash"></i></button>

                        <?php }   

                        ?>

                              </div>

                                <span id="product"></span>

                          </div>

                           <?php } ?>

                      <div id="add-product">

                      </div>

                      <input type="hidden" id="row_count1" value="<?php echo count(@$List); ?>">

                      <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']); ?>">



              <?php }



              else

                  {

              ?>        <div class="form-group" >

                              <div class="col-sm-2 control-label">

                              </div>

                              <div class="col-sm-3">

                                <input type="text" class="form-control" id="PP-perticular-1" name="PP-perticular-1" placeholder="Perticular" value="" required>

                              </div>

                              <div class="col-sm-2">

                                <input type="number" class="form-control" id="PP-amount-1" name="PP-amount-1" placeholder="Amount" value="" min="1" required>

                              </div>

                              <div class="col-sm-2">

                                <select name="PP-payStatus-1" class="form-control chosen-select" required >

                                  <option value="">Select Status</option>

                                  <option value="Static">Static</option>

                                  <option value="Dynamic">Dynamic</option>

                                </select>

                              </div>

                               <div class="col-sm-2">

                                <select name="PP-amountType-1" class="form-control chosen-select" required >

                                  <option value="">Select Type</option>

                                  <option value="E">Earning</option>

                                  <option value="D">Deduction</option>

                                </select>

                              </div>

                              <div class="col-sm-1">

                                <button type="button" class="btn btn-white btn-bitbucket add_product">

                                    <i class="fa fa-plus"></i>

                                </button>

                              </div>

                                <span id="cst"></span>

                          </div>

                          <div id="add-product">

                          </div>

                          <input type="hidden" id="row_count1" value="1">

                          <input type="hidden" name="num_row1" id="num_row1" value="<?php echo count(@$DETAIL['List']); ?>">

            <?php 

                  }

            ?> -->



                          

                          <div class="form-group">

                              <label for="price" class="col-sm-2 control-label">Description : </label>

                              <div class="col-sm-10">

                                <textarea type="text" class="form-control" name="description" placeholder="Description"><?php echo @$View['description']; ?></textarea>

                              </div>

                                <span id="description"></span>

                          </div>

                        

                         

                           

                        	<div class="form_footer">

                        	<div class="row">

                            	<div class="col-md-6 text-center col-md-offset-3 ">

                                        <button type="submit" class="btn btn-primary"><?php echo isset($What) ? 'Update' : 'Add'; ?></button>

                                    </div>

                            	</div>



                            </form> 

                        </div>

                    </div>    

            </div>

        </div>





<!-- <select name="designation_ID" class="form-control chosen-select" required="required">

                                  <option value="">Select designation</option>

                                  <?php if (isset($designation)) { 

                                    foreach ($designation as $key => $value) { ?>

                                    <option value="<?php echo $value['ID']; ?>"><?php echo $value['post']; ?></option>

                                  <?php  }

                                   }

                                  else{

                                    ?>

                                    <option value="">Data not Found</option>

                                    <?php } ?>

                                </select> -->

<!-- Custom and plugin javascript -->

<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>

<!-- Jquery Validate -->

<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<link href="<?php echo base_url("css/plugins/switchery/switchery.css"); ?>" rel="stylesheet">
<!-- Switchery -->
<script src="<?php echo base_url("js/plugins/switchery/switchery.js"); ?>"></script>

<script type="text/javascript">

$.validator.setDefaults({ ignore: ":hidden:not(select)" });

  $(".chosen-select").chosen();

  $(document).ready(function() {
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    $("#expense_add").validate();

    $("#expense_add").postAjaxData(function(result){

      //alert(result);

       if(result === 1)

      {

        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";

        toastr.success('Successfully '+type+'.');
        setTimeout(function(){
          window.location.href = "<?php echo current_url(); ?>";
        }, 3000);
      }

      else

      {

        if(typeof result === 'object')

        {

          mess = "";

          $.each(result,function(dom,err)

          {

            mess = mess+err+"\n";

            toastr.error(mess);

          });

        }

        else

        {

          toastr.error("Something went wrong!");

        }

      }

    });





// $('.add_product').on('click',function()

//     {

//       var c = $("#row_count1").val();

//       console.log(c);

//       ++c;

//       $('<div class="form-group" id="product_div-'+c+'"><div class="col-sm-2 control-label"></div><div class="col-sm-3"><input type="text" class="form-control" id="PP-perticular-'+c+'" name="PP-perticular-'+c+'" placeholder="Perticular" value="" required></div><div class="col-sm-2"><input type="number" class="form-control" id="PP-amount-'+c+'" name="PP-amount-'+c+'" placeholder="Amount" value="" min="1" required></div><div class="col-sm-2"><select name="PP-payStatus-'+c+'" class="form-control chosen-select" required ><option value="">Select Status</option><option value="Static">Static</option><option value="Dynamic">Dynamic</option></select></div><div class="col-sm-2"><select name="PP-amountType-'+c+'" class="form-control chosen-select" required ><option value="">Select Type</option><option value="E">Earning</option><option value="D">Deduction</option></select></div><div class="col-sm-1"><button type="button" class="btn btn-white btn-bitbucket remove_product" onclick="remove_product(\'product_div-'+c+'\');"><i class="fa fa-close"></i></button></div><span id="cst"></span></div>').appendTo('#add-product');

//       /*$("#row_count1").val(c);*/

//         $(".chosen-select").chosen();

//     $("#row_count1").val(c);



//     });

  });



 //  function remove_product(product_div,n)

 //  {

 //    if(n == 'yes')

 //    {

 //      var d = $("#num_row1").val();

 //      var k = --d;

 //      console.log(k);

 //      $("#num_row1").val(k);

 //    }

 //    else

 //    {

 //      var c = $("#row_count1").val();

 //      console.log(product_div);

 //      var j = --c;
 // console.log(j);

 //      $("#row_count1").val(j);

 //    }

 //    $('#'+product_div).remove();

 //  }
     



  // function remove_perticular(id,product_div) {

  //   bootbox.confirm('Are you sure you want to delete?', function(result) {

  //   if(result == true)

  //   {

  //     $.ajax({

  //       type:'POST',

  //       url: '<?php echo base_url(); ?>'+'designation/removePerticular/'+id,

  //       success:function(response)

  //       {

  //         var d = $("#num_row1").val();

  //         var k = --d;

  //         console.log(k);

  //         $("#num_row1").val(k);

  //         $('#'+product_div).remove();

  //         $.gritter.add({

  //             text: '<h4>Perticular Remove Successfully</h4>',                   

  //             class_name: 'gritter-warning gritter-center'

  //         });

  //       }

  //     });

  //     }

  //   });

  //   }  

</script>