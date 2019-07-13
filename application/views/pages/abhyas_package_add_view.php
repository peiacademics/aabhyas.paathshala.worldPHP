<div class="ibox">
  <div class="ibox-content">
    <div class="page-content">
      <div class="wrap">
        <h4 id="success" style="text-align:center;"></h4>
        <form class="form-horizontal" role="form" action="<?php echo base_url('package/add'); ?>" method="post" id="package_add">
          <input type="hidden" name="ID" value="<?php echo @$View['ID']; ?>">
          <div class="form-group">
              
              <div class="col-sm-6">
                <label class="control-label">Package Name  </label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo @$View['name']; ?>" required>
              </div>
                <span id="Name"></span>
          <!-- </div>
          <div class="form-group"> -->
              
              <div class="col-sm-6">
                <label class="control-label">Package Price  </label>
                <div class="input-group">
                  <span class="input-group-addon"> <i class="fa fa-inr"></i></span>
                  <input type="number" class="form-control" id="price" placeholder="Price" name="price" value="<?php echo @$View['price']; ?>" min="0" required>
                </div>
              </div>
              <span id="Price"></span>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <div id="treeview12" class="">
                <i class="fa fa-spin fa-spinner fa-5x"></i><h2> Loading ... </h2>
              </div>
            </div>

            <div id="tabs" class="col-sm-9 text-center">
              <ul class="nav nav-pills nav-justified">
                  <li class="tab-test active"><a data-toggle="tab" href="#test-tab"><i class="fa fa-star"></i> TEST</a></li>
                  <li class="tab-assignment"><a data-toggle="tab" href="#assignment-tab"><i class="fa fa-book"></i> ASSIGNMENT</a></li>
                  <li class="tab-pdf"><a data-toggle="tab" href="#pdf-tab"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                  <li class="tab-video"><a data-toggle="tab" href="#video-tab"><i class="fa fa-video-camera"></i> Video</a></li>
              </ul>
              <div class="tab-content">
                <div id="test-tab" class="tab-test tab-pane active">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td class="font-bold">Subject</td>  
                        <td class="font-bold">Lesson</td>  
                        <td class="font-bold">Topic</td>  
                        <td class="font-bold">Name</td>  
                        <td class="font-bold">Date &amp; Time </td>  
                      </tr>
                    </thead>
                    <tbody id="test">
                      
                    </tbody>
                  </table>
                </div>
                <div id="assignment-tab" class="tab-assignment tab-pane">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td class="font-bold">Subject</td>  
                        <td class="font-bold">Lesson</td>  
                        <td class="font-bold">Topic</td>  
                        <td class="font-bold">Name</td>  
                      </tr>
                    </thead>
                    <tbody id="assignment">
                    </tbody>
                  </table>
                </div>
                <div id="pdf-tab" class="tab-pdf tab-pane">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td class="font-bold">Subject</td>  
                        <td class="font-bold">Lesson</td>  
                        <td class="font-bold">Topic</td>  
                        <td class="font-bold">Name</td>  
                      </tr>
                    </thead>
                    <tbody id="pdf">
                      
                    </tbody>
                  </table>
                </div>
                <div id="video-tab" class="tab-video tab-pane">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td class="font-bold">Subject</td>  
                        <td class="font-bold">Lesson</td>  
                        <td class="font-bold">Topic</td>  
                        <td class="font-bold">Name</td>  
                      </tr>
                    </thead>
                    <tbody id="video">
                      
                    </tbody>
                  </table>
                </div>
              </div>
<!--             </div>
            <div class="col-md-6 text-center"> -->
                <button type="submit" class="btn btn-block btn-primary"><?php echo isset($What) ? 'Update' : 'Create Package'; ?></button>
            </div>
          </div>
          <!-- <div class="form-group">
            
          </div> -->
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<link href="<?php echo base_url("css/pf-bootstrap-treeview.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/pf-bootstrap-treeview.js"); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    
    $("#package_add").validate();
    $("#package_add").postAjaxData(function(result){
      if(result == 1)
      {
        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully Created.');
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

    $.ajax({
      method: 'POST',
      type: 'JSON',
      url: base_url+'package/get_abhyas_details',
      error:function(err){
        toastr.error("Something went wrong!");
      },
      success:function(res){
        res = JSON.parse(res);
        console.log(res);
        $('#treeview12').html('');
        var $tree = $('#treeview12').treeview({
          levels: 7,
          data: res,
          showCheckbox:true,
          checkable: true,
          state: {
            checked: true,
            disabled: true,
            expanded: true,
            selected: true
          },
          highlightSelected:false,
          onNodeChecked: function(event, node) {
            console.log(node.ID);
            console.log(node.type);
            if(node.type == 'test')
            {
              $('#'+node.type).append('<tr id="li-'+node.ID+'-'+node.type+'"><td>'+node.subject+'</td><td>'+node.lesson+'</td><td>'+node.topic+'</td><td>'+node.text+'</td><input type="hidden" name="'+node.ID+'" id="'+node.ID+'" value="'+node.value+'"><td><input type="datetime-local" class="form-control" name="'+node.ID+'-datetime" id="datetimepicker-'+node.ID+'" /></td></tr>');
              //$('#datetimepicker-'+node.ID).datetimepicker();
            }
            else{
              $('#'+node.type).append('<tr id="li-'+node.ID+'-'+node.type+'"><td>'+node.subject+'</td><td>'+node.lesson+'</td><td>'+node.topic+'</td><td>'+node.text+'</td><input type="hidden" name="'+node.ID+'" id="'+node.ID+'" value="'+node.value+'"></tr>');
            }
            tabactive(node.type);
          },
          onNodeUnchecked: function (event, node) {
            console.log(node.ID);
            $('#li-'+node.ID+'-'+node.type+'').remove();
            tabactive(node.type);
          }

        });
        // $('#get_details').html(data);
      }
    })    
  });

  function tabactive(type)
  {
    $('.tab-'+type).addClass('active');
    if(type == 'test')
    {
      $('.tab-assignment').removeClass('active');
      $('.tab-pdf').removeClass('active');
      $('.tab-video').removeClass('active');
    }
    if(type == 'assignment')
    {
      $('.tab-test').removeClass('active');
      $('.tab-pdf').removeClass('active');
      $('.tab-video').removeClass('active');
    }
    if(type == 'pdf')
    {
      $('.tab-test').removeClass('active');
      $('.tab-assignment').removeClass('active');
      $('.tab-video').removeClass('active');
    }
    if(type == 'video')
    {
      $('.tab-test').removeClass('active');
      $('.tab-assignment').removeClass('active');
      $('.tab-pdf').removeClass('active');
    }
  }
</script>
