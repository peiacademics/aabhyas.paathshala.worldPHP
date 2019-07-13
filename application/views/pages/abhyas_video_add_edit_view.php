<div class="row">
  <!-- <div class="ibox-title">
      <h5><?php echo ucfirst($this->lang_library->translate('Add Abhyas Video')); ?></h5>
      <div class="ibox-tools">
          <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
          </a>
     </div>
  </div> -->
  <div class="ibox-content">
    <div class="page-content">
        <div class="wrap">
          <h4 id="success" style="text-align:center;"></h4>
                <form class="form-horizontal" role="form" action="<?php echo base_url('Abhyas_video/add'); ?>" method="post" id="bank_add">
                    <input type="hidden" name="ID" value="<?php echo @$View['ID'];?>">
                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Subject: </label>
                        <div class="col-sm-6">
                          <select class="form-control select-chosen" onChange="get_lesson()" id="subject_ID" name="subject_ID"  placeholder="Subject" required>
                          </select>
                        </div>
                          <span id="sub_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Lesson : </label>
                        <div class="col-sm-6">
                          <select class="form-control select-chosen" id="lesson_ID" name="lesson_ID" onChange="get_topic()" placeholder="Lesson" required>
                            <option selected disabled>Select</option>
                          </select>
                        </div>
                          <span id="les_ID"></span>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Topic : </label>
                        <div class="col-sm-6">
                          <select class="form-control select-chosen" id="topic_ID" name="topic_ID" placeholder="Topic" required>
                            <option selected disabled>Select</option>
                          </select>
                        </div>
                          <span id="tp_ID"></span>
                    </div>

                     <div class="form-group">
                          <label  class="col-sm-3 control-label">Name : </label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo @$View['name']; ?>" required>
                          </div>
                            <span id="Name"></span>
                      </div>

                      <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Upload Video</label>
                        <div class="col-sm-6">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-success btn-file"><span class="fileinput-new">Select file</span>
                            <span class="fileinput-exists">Change</span><input type="file" value="deepak" name=".." onChange="uploadFile(this)" <?php echo (!empty(@$View['video_ID']) ? '' :''); ?> /></span>
                            <span class="fileinput-filename" id="file_name"><?php echo @$View['video_ID']; ?></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                          </div>
                          <div class="progress progress-striped active hidden">
                              <div id="percent" style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar progress-bar-success">
                              </div>
                          </div>
                          <span id="percent_text" class=""></span>

                        </div>
                        <input type="hidden" name="video_ID" id="video_ID" value="<?php echo @$View['video_ID']; ?>">
                      </div>

                      <div class="form-group">
                          <label class="col-sm-3 control-label">Description : </label>
                          <div class="col-sm-6">
                             <textarea type="text" class="form-control" name="description" placeholder="Description"><?php echo @$View['description']; ?></textarea>
                          </div>
                            <span id="description"></span>
                      </div>
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

<link href="<?php echo base_url("css/plugins/jasny/jasny-bootstrap.min.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("js/plugins/jasny/jasny-bootstrap.min.js"); ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url("js/formSerialize.js"); ?>"></script>
<!-- Jquery Validate -->
<script src="<?php echo base_url("js/plugins/validate/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
  $.validator.setDefaults({ ignore: ":hidden:not(select)" });
  
  $(document).ready(function() {
    
    var js_date_format = "<?php echo $this->date_library->dateformat_PHP_to_javascript($Date_format)?>";
 
    $("#bank_add").postAjaxData(function(result){
      if(result === 1)
      {
        var type = "<?php echo isset($What) ? 'Updated' : 'Added'; ?>";
        toastr.success('Successfully '+type+'.');
        setTimeout(function(){
          window.location.href = "<?php echo current_url(); ?>";
        }, 3000);
      }
      else if(result === 2)
      {
        toastr.error("Please upload Video first!");
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
    $("#bank_add").validate();
  });

  var subject_ID = '<?php echo @$View['subject_ID']; ?>';
  if(subject_ID != '')
  {
    var lesson_ID = '<?php echo @$View['lesson_ID']; ?>';
    getChosenData('lesson_ID','LS',[{'label':'name','value':'ID'}],[{'Status':'A','subject_ID':subject_ID}],'<?php echo @$View['lesson_ID']?>');
    getChosenData('topic_ID','TP',[{'label':'name','value':'ID'}],[{'Status':'A','lesson_ID':lesson_ID,'subject_ID':subject_ID}],'<?php echo @$View['topic_ID']?>');
  }

  getChosenData('subject_ID','SB',[{'label':'name','value':'ID'}],[{'Status':'A'}],'<?php echo @$View['subject_ID']?>');
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

  function uploadFile(f) {
    $('#percent').css('width','0%');
    $('#percent_text').html('0% Complete');
    toastr.options = {
      timeOut:0,
    };
    toastr.warning('<i class="fa fa-spinner fa-spin"></i>UPLOADING...',{timeOut: 0});
    var file_data = $(f).prop('files')[0]; 
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
      datatype:'text',
      data:form_data,
      type:'POST',
      cache: false,
      contentType: false,
      processData: false,
      url: '<?php echo base_url("Abhyas_video/upload_video");?>',
      xhr: function()
      {
        var xhr = new window.XMLHttpRequest();
        //Upload progress
        xhr.upload.addEventListener("progress", function(evt){
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            // console.log(percentComplete);
            // console.log(percentComplete.toFixed(2));
           var d=percentComplete.toFixed(2);
           // var d=Math.round(percentComplete).toFixed(2);
           if (d!=='1.00') {
             d=d.split('.');
             d=d[1];
           }
           else
           {
            d=100;
           }
            var p = formatBytes(evt.loaded);
            var t = formatBytes(evt.total);
            $('.progress').removeClass('hidden');
            $('#percent').css('width',d+'%');
            $('#percent_text').html(d+'% Complete ('+p+' / '+t+')');
          }
        }, false);
        //Download progress
        xhr.addEventListener("progress", function(evt){
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            // console.log((percentComplete.indexOf('.').length).length > 2);
          }
        }, false);
        return xhr;
      },
      success:function(response)
      {
        if (typeof response === 'string')
        {
          console.log(response);
          if(response != '')
          {
            $('#video_ID').val(response);
            toastr.clear();
            toastr.options = {
              "closeButton": true,
              positionClass:'toast-bottom-right',
              showMethod: 'slideDown',
              "progressBar": true,
              tapToDismiss : true,
              timeOut: 5000
            };
            toastr.success('File Uploaded');
          }
          else
          {
            toastr.error("Please upload Video only!");
          }
        }
        else
        {
          toastr.error("Something went wrong!");
        }
      }
    });
  }

function formatBytes(bytes,decimals) {
   if(bytes == 0) return '0 Bytes';
   var k = 1000,
       dm = decimals || 2,
       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

</script>