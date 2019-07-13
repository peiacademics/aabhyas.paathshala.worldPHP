<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2><?php echo $data['package']; ?> - Video Tutorial</h2>
    <ol class="breadcrumb">
      <li>
        <?php echo $data['subject']; ?>
      </li>
      <li>
        <?php echo $data['lesson']; ?>
      </li>
      <li class="font-bold">
        <a href="<?php echo base_url('dashboard/topic/'.@$data['link']); ?>"><?php echo $data['topic']; ?></a>
      </li>
      <li class="active">
        <?php echo $data['list']; ?>
      </li>
    </ol>
  </div>
  <div class="col-lg-2">

  </div>
</div>
<div class="">
  <div class="row">
    <div class="text-center">
      <div class="input-group">
        <select class="form-control input-lg" id="speed" placeholder="Select Speed" onChange="change_speed()">
          <option value="0.25">0.25</option>
          <option value="0.5">0.5</option>
          <option value="0.75">0.75</option>
          <option value="1" selected>Normal Speed</option>
          <option value="1.25">1.25</option>
          <option value="1.5">1.5</option>
          <option value="1.75">1.75</option>
          <option value="2">2</option>
        </select>
        <span class="input-group-addon input-lg" onClick="backward()">
          <i class="fa fa-backward"></i>
        </span>
        <span class="input-group-addon input-lg" onClick="forward()">
        <i class="fa fa-forward"></i>
        </span>
      </div>
      <video width="420" id="frame_ID" controls controlsList="nodownload">
      </video>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
      method:'POST',
      data:{'url_data':'<?php echo $this->uri->segment(3); ?>'},
      url:base_url+'svideo/get_video',
      error:function(err){
        bootbox.alert('Something Went Wrong');
      },
      success:function(res)
      {
        res = JSON.parse(res);
        if(res != '0')
        {
          $.ajax({
            method:'POST',
            url:'<?php echo base_url(); ?>svideo/'+res,
            success:function(url_l)
            {
              var url_l = JSON.parse(url_l);
              $('#frame_ID').attr('src',get_u(url_l));
              $('#frame_ID').bind('contextmenu',function() {
                return false;
              });
            }
          });
        }
        else{
          bootbox.alert('No Video Available');
        }
      }
    });

    setInterval(function(){
      $('#frame_ID').attr('controlslist','nodownload');
    },100);

  });

  function get_u(url_l)
  {
    return url_l;
  }

  function change_speed()
  {
    var vid = document.getElementById("frame_ID");
    var rate = $('#speed').val();
    vid.playbackRate = rate;
  }

  function backward()
  {
    var vid = document.getElementById("frame_ID");
    var time = vid.currentTime;
    time = time - 15;
    vid.currentTime = time;
  }

  function forward()
  {
    var vid = document.getElementById("frame_ID");
    var time = vid.currentTime;
    time = time + 15;
    vid.currentTime = time;
  }
</script>