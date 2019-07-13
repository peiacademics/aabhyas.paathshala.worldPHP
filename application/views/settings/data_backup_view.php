<div class="page-content">
<div class="page-content" text-center>
  <div class="wrap" id="wrap">
        <div class="ibox">
          <div class="ibox-title">
              <h5>Data Backup</h5>
              <div class="ibox-tools">
                  <a class="collapse-link">
                      <i class="fa fa-chevron-up"></i>
                  </a>
              </div>
          </div>
          <div class="ibox-content ">
            <div class="row">
            <div class="col-lg-12">
              <div class="col-lg-6 col-lg-offset-3">     
                  <div class="widget navy-bg text-center">
                    <div class="m-b-md">
                      <i class="fa fa-folder-open fa-4x"></i>
                      <h5 class="m-xs">- - - - - - - - - - - -</h5>
                      <h3 class="font-bold no-margins">
                        <a href="" id="backup_now">   
                        Backup Now
                        </a>
                      </h3>
                      <h5 class="m-xs">- - - - - - - - - - - -</h5>
                      <select style="background-color:#74A01E;border-radius: 5px;" class="form-control input-lg" id="Backup_ID" name="Backup_ID" >
                                 <option  disabled="disabled" selected="selected">----------select----------</option>                 
                              </select>
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
<script type="text/javascript">
  $(document).ready(function() {
    
    $('#backup_now').click(function() {
       // alert('Hello');
         var config = {
            base : "<?php echo base_url(); ?>",
          };

          $.ajax({
          type:'POST',
          url: config.base+'Settings/db_backup',
          success: function(divs) 
           {  
             // alert('divs');
             //console.log(divs);
             $("#success").text('Backup Done successfully.');             
             //return true;          
           }
          });
      });  
        
      options1 = $("#Backup_ID >  option");
      options1.remove();
      options1.removeAttr("disabled");
      //var ref_id = $('#Level').val();
      //alert(ref_id);
      var config = {
        base : "<?php echo base_url(); ?>",
      };
         var optnn = $('<option />'); 
          optnn.val('');
          optnn.text('---------Select File To Download---------');
          $('#Backup_ID').append(optnn);
          
      $.ajax({
      type:'POST',
      url: config.base+'xyz/test',
      success: function(divs) 
       {  
         //alert(divs); 
          $.each(divs,function(id,div) 
          {
            //alert('hi');
              var opt = $('<option />'); 
              opt.val(div);
              opt.text(div);
              $('#Backup_ID').append(opt); 
          });           
        }
       });

       $('#Backup_ID').change(function() {
        // alert('Hello');
         var config = {
            base : "<?php echo base_url(); ?>",
          };
          var path = $('#Backup_ID').val();
          //alert(path);
          console.log(path);
          window.open(config.base+'settings/download_file/'+path);

          // $.ajax({
          // type:'POST',
          // data:{'path' : path},
          // url: config.base+'settings/download_file',
          // success: function(divs) 
          //  {  
          //   //alert(divs);
          //   // console.log(divs);
          //    $("#success").text('Backup File Downloaded successfully.');             
          //    //return true;          
          //  }
          // });
        });


  });  

   
  
</script>