 <div class="page-content">
  <div class="wrap">
    <h4 id="success" style="text-align:center;"></h4>
      <div class="row">               
        <div class="col-md-6">
<div class="widget red-bg p-xl text-center" id="backup_now">
  <div class="m-b-md">
    <i class="fa fa-folder fa-4x"></i>
    <h1 class="m-xs"></h1>
    <h1 class="font-bold no-margins">
      Backup Now <small class="red-bg">(Folder)</small>
    </h1>
  </div>
</div>
     <!--      <button type="submit" class="btn btn-success btn-lg btn-block" id="backup_now"><i class="fa fa-folder"></i>Backup Now</button>  
      -->   </div>
        <div class="col-md-6">
<div class="widget yellow-bg p-xl text-center"  id="synch">
  <div class="m-b-md">
    <i class="fa fa-exchange fa-4x"></i>
    <h1 class="m-xs"></h1>
    <h1 class="font-bold no-margins">
      Synchronize <small class="yellow-bg">(Database)</small>
    </h1>
  </div>
</div>
     <!--      <button type="submit" class="btn btn-warning btn-lg btn-block" id="synch"><i class="fa fa-exchange"></i>Synchronize</button>  
      -->   </div>
      </div>  
		</div>	
  </div>  
</div>  
            
<script type="text/javascript">
  $(document).ready(function() {

      $('#backup_now').click(function() {
     // alert('Hello');
       var config = {
          base : "<?php echo base_url(); ?>",
        };
         window.open(config.base+'settings/backup');

        // $.ajax({
        // type:'POST',
        // url: config.base+'settings/backup',
        // success: function(divs) 
        //  {  
        //    // alert('divs');
        //    //console.log(divs);
        //    $("#success").text('Backup Done successfully.');             
        //    //return true;          
        //  }
        // });
    });

     $('#synch').click(function() {
       // alert('Hello');
         var config = {
            base : "<?php echo base_url(); ?>",
          };

          $.ajax({
          type:'POST',
          url: config.base+'Settings/sync_db',
          success: function(divs) 
           {  
             // alert('divs');
             //console.log(divs);
             $("#success").text('Synchronization Done successfully.');             
             //return true;          
           }
          });
      });

    $('#Level').change(function() {
        //alert('Hello');
        
         var level = $(this).val();
         if(level == "1")
          {
            $('#ParentID').hide();            
          }
          else
          {            
            $('#ParentID').show();            
          }
          
          options1 = $("#Parent_ID >  option");
          options1.remove();
          options1.removeAttr("disabled");
          //var ref_id = $('#Level').val();
          //alert(ref_id);
          var config = {
            base : "<?php echo base_url(); ?>",
          };
             var optnn = $('<option />'); 
              optnn.val('');
              optnn.text('----Select----');
              $('#Parent_ID').append(optnn);
              
          $.ajax({
          type:'POST',
          url: config.base+'settings/find_help_parent_id',
          success: function(divs) 
           {  
             //alert(divs); 
              $.each(divs,function(id,div) 
              {
                //alert('hi');
                  var opt = $('<option />'); 
                  opt.val(div.ID);
                  opt.text(div.Question);
                  $('#Parent_ID').append(opt);
              });           
            }
           });
      });

  }); 

</script>