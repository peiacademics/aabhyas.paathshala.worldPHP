<div class="row">
  <div class="ibox">
    <div class="ibox-title font-bold">
        <span class="h1 text-success">Package : <?php echo $data['name']; ?></span><span class="h3 text-danger"> (Price : <i class="fa fa-inr"></i> <?php echo $data['price']; ?>)</span>
    </div>
    <div class="ibox-content">
      <div class="row">
        <div id="tabs" class="col-sm-12">
          <ul class="nav nav-pills">
              <li class="tab-mcq active"><a data-toggle="tab" href="#test-tab"><i class="fa fa-star"></i> Test</a></li>
              <li class="tab-assignment"><a data-toggle="tab" href="#assignment-tab"><i class="fa fa-star"></i> Assignment</a></li>
              <li class="tab-pdf"><a data-toggle="tab" href="#pdf-tab"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
              <li class="tab-video"><a data-toggle="tab" href="#video-tab"><i class="fa fa-video-camera"></i> Video</a></li>
          </ul>
          <div class="tab-content">
  <?php if(array_key_exists('lists',$data)){
          $i = 0;
          foreach ($data['lists'] as $key => $value) {
            $active = ($key=='test') ? 'active' : ''; ?>
            <div id="<?php echo $key; ?>-tab" class="tab-<?php echo $key.' '.$active; ?> tab-pane ">
              <div class="table-responsive">
              <table class="table table-bordered" width="100%">
                <tr>
                  <td colspan="6">
                    <button class="pull-right btn btn-success dim" type="button" onclick="add('<?php echo $key; ?>','<?php echo $this->uri->segment(3); ?>')"> <i class="fa fa-plus"></i> Add <?php echo $key; ?></button>
                  </td>
                </tr>
                <tr>
  <?php           if($key == 'test'){ ?>
                    <td width="19%" class="font-bold">Subject</td>  
                    <td width="19%" class="font-bold">Lesson</td>  
                    <td width="19%" class="font-bold">Topic</td>  
                    <td width="19%" class="font-bold">Name</td>
                    <td width="19%" class="font-bold">Date And Time</td>
                    <td width="5%" class="font-bold">Action</td>
  <?php           }
                  else{ ?>
                    <td width="24%" class="font-bold">Subject</td>  
                    <td width="24%" class="font-bold">Lesson</td>  
                    <td width="24%" class="font-bold">Topic</td>  
                    <td width="24%" class="font-bold">Name</td>
                    <td width="4%" class="font-bold">Action</td>
  <?php           } ?>  
                </tr>
                <tbody id="<?php echo $key; ?>">
  <?php           foreach($value as $k=>$v){ ?>
                    <tr id="tr-<?php echo @$v['ID']; ?>">
                      <td><?php echo @$v['subject']; ?></td>
                      <td><?php echo @$v['lesson']; ?></td>
                      <td><?php echo @$v['topic']; ?></td>
                      <td><?php echo @$v['reference']; ?></td>
  <?php             if($key == 'test'){ ?>
                      <td><div class="input-group"><input type="datetime-local" id="datetime-<?php echo @$v['ID']; ?>" value="<?php echo @$v['dt']; ?>" class="form-control"><a class="input-group-addon" type="button" title="Set Date & Time" class="btn btn-success" id="set_date-<?php echo @$v['ID']; ?>" onclick="set_date('<?php echo @$v['ID']; ?>')"> <i class="fa fa-calendar"> </i> Change </a></div></td>
                      <td><button type="button" title="Remove" class="btn btn-danger" id="remove_data-<?php echo @$v['ID']; ?>" onclick="remove_data('<?php echo @$v['ID']; ?>')"> <i class="fa fa-remove"> </i></button></td>
  <?php             }
                    else{ ?>
                      <td><button type="button" title="Remove" class="btn btn-danger" id="<?php echo @$v['ID']; ?>" onclick="remove_data('<?php echo @$v['ID']; ?>')"> <i class="fa fa-remove"> </i></button></td>
  <?php             } ?>

                    </tr>
  <?php           } ?>
                </tbody>
                <tfoot id="tfoot-<?php echo $key; ?>">
                  
                </tfoot>
              </table>
              </div>
            </div>
  <?php     $i++;

          }
          if(!array_key_exists('test', $data['lists']))
          { ?>
            <div id="test-tab" class="tab-test tab-pane active">
              <table class="table table-bordered" width="100%">
                <tr>
                  <td colspan="6"><button class="btn pull-right btn-success dim" type="button" onclick="add('test','<?php echo $this->uri->segment(3); ?>')"> <i class="fa fa-plus"></i> Add Test</button></td>
                </tr>
                <tr>
                  <td width="19%" class="font-bold">Subject</td>  
                  <td width="19%" class="font-bold">Lesson</td>  
                  <td width="19%" class="font-bold">Topic</td>  
                  <td width="19%" class="font-bold">Name</td>
                  <td width="19%" class="font-bold">Date And Time</td>
                  <td width="5%" class="font-bold">Action</td>
                </tr>
                <tfoot id="tfoot-test">
                  <!-- <tr>
                    <td width="50%" class="font-bold">No Test Available</td>
                  </tr> -->
                </tfoot>
              </table>  
            </div>
  <?php   }
          if(!array_key_exists('assignment', $data['lists']))
          { ?>
            <div id="assignment-tab" class="tab-assignment tab-pane ">
              <table class="table table-bordered" width="100%">
                <tr>
                  <td colspan="6"><button class="btn pull-right btn-success dim" type="button" onclick="add('assignment','<?php echo $this->uri->segment(3); ?>')"> <i class="fa fa-plus"></i> Add Assignment</button></td>
                </tr>
                <tr>
                  <td width="24%" class="font-bold">Subject</td>  
                  <td width="24%" class="font-bold">Lesson</td>  
                  <td width="24%" class="font-bold">Topic</td>  
                  <td width="24%" class="font-bold">Name</td>
                  <td width="4%" class="font-bold">Action</td>
                </tr>
                <tfoot id="tfoot-assignment">
                  <!-- <tr>
                    <td width="50%" class="font-bold">No Assignment Available</td>
                  </tr> -->
                </tfoot>
              </table>  
            </div>
  <?php   }
          if(!array_key_exists('pdf', $data['lists']))
          { ?>
            <div id="pdf-tab" class="tab-pdf tab-pane ">
              <table class="table table-bordered" width="100%">
                <tr>
                  <td colspan="6"><button class="btn pull-right btn-success dim" type="button" onclick="add('pdf','<?php echo $this->uri->segment(3); ?>')"> <i class="fa fa-plus"></i> Add PDF</button></td>
                </tr>
                <tr>
                  <td width="24%" class="font-bold">Subject</td>  
                  <td width="24%" class="font-bold">Lesson</td>  
                  <td width="24%" class="font-bold">Topic</td>  
                  <td width="24%" class="font-bold">Name</td>
                  <td width="4%" class="font-bold">Action</td>
                </tr>
                <tfoot id="tfoot-pdf">
                  <!-- <tr>
                    <td width="50%" class="font-bold">No PDF Available</td>
                  </tr> -->
                </tfoot>
              </table>  
            </div>
  <?php   }
          if(!array_key_exists('video', $data['lists']))
          { ?>
            <div id="video-tab" class="tab-video tab-pane ">
              <table class="table table-bordered" width="100%">
                <tr>
                  <td colspan="6"><button class="btn pull-right btn-success dim" type="button" onclick="add('video','<?php echo $this->uri->segment(3); ?>')"> <i class="fa fa-plus"></i> Add Video</button></td>
                </tr>
                <tr>
                  <td width="24%" class="font-bold">Subject</td>  
                  <td width="24%" class="font-bold">Lesson</td>  
                  <td width="24%" class="font-bold">Topic</td>  
                  <td width="24%" class="font-bold">Name</td>
                  <td width="4%" class="font-bold">Action</td>
                </tr>
                <tfoot id="tfoot-video">
                  <!-- <tr>
                    <td width="50%" class="font-bold">No Video Available</td>
                  </tr> -->
                </tfoot>
              </table>  
            </div>
  <?php   }
        } ?>
              <!-- <pre><?php //print_r($data); ?></pre> -->
          </div>
        </div>
        <div class="col-sm-6">

        </div>
      </div>
    </div>
  </div>
</div>
<div id="package_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form  id="package_form" class="form-horizontal">
          <input type="hidden" name="package_ID" id="package_ID">
          <input type="hidden" name="type" id="type">
          <div class="form-group">
              <label  class="col-sm-3 control-label">Subject: </label>
              <div class="col-sm-9">
                <select class="form-control select-chosen" onChange="get_lesson()" id="subject_ID" name="subject_ID"  placeholder="Subject" required>
                </select>
              </div>
                <span id="sub_ID"></span>
          </div>
          <div class="form-group">
              <label  class="col-sm-3 control-label">Lesson : </label>
              <div class="col-sm-9">
                <select class="form-control select-chosen" id="lesson_ID" name="lesson_ID" onChange="get_topic()" placeholder="Lesson" required>
                  <option selected disabled>Select</option>
                </select>
              </div>
                <span id="les_ID"></span>
          </div>
          <div class="form-group">
              <label  class="col-sm-3 control-label">Topic : </label>
              <div class="col-sm-9">
                <select class="form-control select-chosen" id="topic_ID" name="topic_ID" onChange="get_data()" placeholder="Topic" required>
                  <option selected disabled>Select</option>
                </select>
              </div>
                <span id="tp_ID"></span>
          </div>
          <div id="data">

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  $(document).ready(function(){
    getChosenData('subject_ID','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['subject_ID']?>');
  });

  function get_lesson()
  {
    var subject_ID = $('#subject_ID').val();
    getChosenData('lesson_ID','LS',[{'label':'name','value':'ID'}],[{'Status':'A','subject_ID':subject_ID}],'<?php echo @$View['lesson_ID']?>');
  }

  function get_topic()
  {
    var subject_ID = $('#subject_ID').val();
    var lesson_ID = $('#lesson_ID').val();
    getChosenData('topic_ID','TP',[{'label':'name','value':'ID'}],[{'Status':'A','lesson_ID':lesson_ID,'subject_ID':subject_ID}],'<?php echo @$View['topic_ID']?>');
  }

  function add(type,package_ID)
  {
    $('#data').html('');
    $('select').val('');
    $('#package_ID').val(package_ID);
    $('#type').val(type);

    $('.modal-title').text('ADD '+type.toUpperCase());
    $('#package_modal').modal('show');
  }

  function get_data()
  {
    var package_ID = $('#package_ID').val();
    var type = $('#type').val();
    $.ajax({
      method:'POST',
      type:'JSON',
      data:$('#package_form').serialize(),
      url:base_url+'package/get_data',
      error:function(err){
        $('#data').html('<b>Something Went Wrong : </b><b class="text-danger">Status Code : '+err.status+' Error : '+err.statusText+'</b>');
      },
      success:function(res){
        res = JSON.parse(res);
        console.log(res);
        var data = '<table class="table table-bordered" width="100%">';
        if(res.length != 0)
        {
          $.each(res,function(k,v){
            data += '<tr><td width="80%">'+v.text+'</td><td width="20%"><button type="button" class="btn btn-xs btn-success btn-block" id="'+v.ID+'" onclick="addtopackage(\''+v.value+'\',\''+v.ID+'\')"> <i class="fa fa-check"> Add </i></button></td></tr>';
          });
          data += '</table>';
          $('#data').html(data);
        }
        else{
          $('#data').html('<table><tr><td>No Data Available</td></tr></table>');
        }
      }
    })
  }

  function addtopackage(data,id)
  {
    $('#'+id).removeAttr('onclick').html('<i class="fa fa-spinner fa-spin"></i> Adding').addClass('disabled');
    $.ajax({
      method:'POST',
      type:'JSON',
      data:{'data':data},
      url:base_url+'package/addtopackage',
      error:function(err){
        toastr.error('<b>Something Went Wrong</b><br><b>Status Code : '+err.status+' <br>Error : '+err.statusText+'</b>');
        $('#'+id).attr('onclick','addtopackage(\''+data+'\',\''+id+'\')').html('<i class="fa fa-check"> Add </i>').removeClass('disabled');
      },
      success:function(res){
        res = JSON.parse(res);
        console.log(res);
        if(typeof res == 'string')
        {
          $('#'+id).html('Added');
          update_data('<?php echo $this->uri->segment(3); ?>',res);
        }
        else{
           $('#'+id).attr('onclick','addtopackage(\''+data+'\',\''+id+'\')').html('<i class="fa fa-check"> Add </i>').removeClass('disabled');
        }
      }
    });
  }

  function set_date(id)
  {
    var datetime = $('#datetime-'+id).val();
    $('#set_date-'+id).removeAttr('onclick').html('<i class="fa fa-spinner fa-spin"></i> Changing').addClass('disabled');
    $.ajax({
      method:'POST',
      type:'JSON',
      data:{'datetime':datetime,'ID':id},
      url:base_url+'package/set_date',
      error:function(err){
        toastr.error('<b>Something Went Wrong</b><br><b>Status Code : '+err.status+' <br>Error : '+err.statusText+'</b>');
        $('#set_date-'+id).attr('onclick','set_date(\''+id+'\')').html('<i class="fa fa-calendar"> </i> Change').removeClass('disabled');
      },
      success:function(res){
        res = JSON.parse(res);
        console.log(res);
        if(res == true)
        {
          toastr.success('<b>Successfully Changed</b>');
        }
        else{
          toastr.error('<b>Something Went Wrong</b>');
        }
        $('#set_date-'+id).attr('onclick','set_date(\''+id+'\')').html('<i class="fa fa-calendar"> </i> Change').removeClass('disabled');
      }
    });
  }

  function remove_data(id)
  {
    $('#remove_data-'+id).removeAttr('onclick').html('<i class="fa fa-spinner fa-spin"></i>').addClass('disabled');
    $.ajax({
      method:'POST',
      type:'JSON',
      data:{'ID':id},
      url:base_url+'package/remove_data',
      error:function(err){
        toastr.error('<b>Something Went Wrong</b><br><b>Status Code : '+err.status+' <br>Error : '+err.statusText+'</b>');
        $('#remove_data-'+id).attr('onclick','remove_data(\''+id+'\')').html('<i class="fa fa-remove"> </i>').removeClass('disabled');
      },
      success:function(res){
        res = JSON.parse(res);
        console.log(res);
        if(res == true)
        {
          toastr.success('<b>Successfully Removed</b>');
          $('#tr-'+id).remove();
        }
        else{
          toastr.error('<b>Something Went Wrong</b>');
          $('#remove_data-'+id).attr('onclick','remove_data(\''+id+'\')').html('<i class="fa fa-remove"> </i>').removeClass('disabled');
        }
      }
    });
  }

  function update_data(id,type)
  {
    $.ajax({
      method:'POST',
      type:'JSON',
      data:{'package_ID':id,'type':type},
      url:base_url+'package/update_data',
      error:function(err){
        toastr.error('<b>Something Went Wrong</b><br><b>Status Code : '+err.status+' <br>Error : '+err.statusText+'</b>');
      },
      success:function(res){
        res = JSON.parse(res);
        console.log(res);
        if(type == 'test')
        {
          $('#tfoot-'+type).append('<tr id="tr-'+res.ID+'"><td>'+res.subject+'</td><td>'+res.lesson+'</td><td>'+res.topic+'</td><td>'+res.reference+'</td><td><div class="input-group"><input type="datetime-local" id="datetime-'+res.ID+'" value="" class="form-control"><a class="input-group-addon" type="button" title="Set Date & Time" class="btn btn-success" id="set_date-'+res.ID+'" onclick="set_date(\''+res.ID+'\')"> <i class="fa fa-calendar"> </i> Change </a></div></td><td><button type="button" title="Remove" class="btn btn-danger" id="remove_data-'+res.ID+'" onclick="remove_data(\''+res.ID+'\')"> <i class="fa fa-remove"> </i></button></td></tr>');
        }
        else{
          $('#tfoot-'+type).append('<tr id="tr-'+res.ID+'"><td>'+res.subject+'</td><td>'+res.lesson+'</td><td>'+res.topic+'</td><td>'+res.reference+'</td><td><button type="button" title="Remove" class="btn btn-danger" id="remove_data-'+res.ID+'" onclick="remove_data(\''+res.ID+'\')"> <i class="fa fa-remove"> </i></button></td></tr>');
        }
      }
    });
  }
</script>