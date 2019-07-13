<script src="<?php echo base_url('js/plugins/iCheck/icheck.min.js');?>"></script>
<div class="row chat-view">
  <div class="ibox-title">
    <!-- <small class="pull-right text-muted">Last message:  Mon Jan 26 2015 - 18:39:23</small> -->
    <span id="chat_name"><h2>Recent Chats</h2></span>
  </div>


  <div class="ibox-content">

    <div class="row">

      <div class="col-md-9 ">
        
        <div class="chat-discussion">
          <div id="old_msg" class="hidden">
            <button class="btn btn-block btn-default btn-xs" type="button" onclick="get_chats_old()"> Load Older Messages </button>
          </div>
          <div id="old_chats">
          </div>
          <hr style="border-top: 1px solid #fff;">
          <div id="chat-discussion">
            <div class="well">
              <img class="message-avatar" src="<?php echo base_url('img/at.png'); ?>" alt="">
              <div class="message h1">Welcome To Chat Room</div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-md-3">
        <div class="chat-users">


          <div class="users-list">
            <div class="chat-user">
              <div class="chat-user-name">
                <div id="chat_mute"></div>
                <label>Select Batch</label>
                <select class="form-control chosen-select" id="batch" placeholder="Select Batch" name="batch" onChange="get_students()" required>
                </select>
              </div>
            </div>

            <div id="chat_studs"></div>

          </div>

        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="chat-message-form hidden">
          <div class="form-group input-group">
            <form id="msg_form" class="">
              <textarea class="form-control message-input" id="message" name="message" placeholder="Enter message text" autocomplete="off"></textarea>
              <input type="hidden" id="student_ID" value="<?php echo @$student_ID; ?>">
              <input type="hidden" name="group_IDs" id="group_IDs">
              <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo $this->uri->segment(3); ?>">
            </form>
            <a onclick="send_msg()" class="lazur-bg input-group-addon btn btn-primary"><b> Send </b><i class="fa fa-paper-plane-o"></i> </a>
          </div>

        </div>
      </div>
    </div>


  </div>

<!-- </div> -->
<script type="text/javascript" src="<?php echo base_url('js/moment.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    getChosenData('batch','BT',[{'label':'name','value':'ID'}],[{'Status':'A','branch_ID':'<?php echo $this->uri->segment(3); ?>'}],'<?php echo @$View['batch']; ?>');
    $("#batch option:disabled").attr('hidden',true);
    $('#batch').append('<option value="other">Others</option>');
    var stud_ID = '<?php echo @$student_ID; ?>';
    if(stud_ID != '')
    {
      get_students();
      get_chat_student(stud_ID);
      get_chats();
    }
  });

  function get_students()
  {
    var batch = $('#batch').val()
    var base_url = '<?php echo base_url(); ?>';
    $.ajax({
      type:'POST',
      data :{'batch_ID':batch},
      url: '<?php echo base_url(); ?>'+'student/get_branchwise_students/'+'<?php echo $this->uri->segment(3); ?>',
      success:function(response)
      {
        var data = '';
        if(response != 'null')
        {
          response = JSON.parse(response);
          $.each(response, function(key,val){
            data += '<div class="chat-user" id="chat_name-'+val.ID+'" onclick="start_chat(\''+val.ID+'\',\''+val.group_IDs+'\');"><a><img class="chat-avatar" src="'+base_url+val.path+'" alt="Student"><div class="chat-user-name">'+val.Name+' '+val.Middle_name+' '+val.Last_name+'</a><label class="pull-right lbl_mute-'+val.ID+'">';
            data += val.chat_mute == "yes" ? 'Muted' : '';
            data += '</label></div></div>';
          });
        }
        else
        {
          data += '<div class="chat-user"><div class="chat-user-name"><strong class="text-danger">No records found.</strong></div></div>';
        }
        $('#chat_studs').html(data);
      }
    });
  }

  function start_chat(id,group_IDs)
  {
    var stud = $('#chat_name-'+id).html();
    var chat = '';
    $.ajax({
      method:'POST',
      datatype:'JSON',
      data : {'student_ID':id},
      url : base_url+'student/get_chat_status',
      success:function(res){
        console.log(typeof res);
        if(typeof res != 'string')
        {
          res = JSON.parse(res);
        }
        chat += '<label class="i-checks"><input type="checkbox" name="mute" id="mute" ';
        chat += res == "yes" ? "checked" :"";
        chat += '> Mute Chat</label>';
        $('#chat_mute').html(chat);
        $('#group_IDs').val(group_IDs);
        $('#student_ID').val(id);
        $('#chat_name').html('<b>'+stud+'</b>');
        $('.chat-message-form').removeClass('hidden');
        $('#old_msg').removeClass('hidden');
        $('.i-checks').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
        });
        $('#mute').on('ifChecked',function(event){
          change_mute(id,'checked');
        });
        $('#mute').on('ifUnchecked',function(event){
          change_mute(id,'unchecked');
        });
      }
    });
  }

  start = 0;
  whole_data = '';

  setInterval(function(){
    get_chats();
  },500);

  function get_chats_old()
  {
    var branch_ID = $('#branch_ID').val();
    var student_ID = $('#student_ID').val();
    var data = '';
    $.ajax({
      method:'POST',
      datatype:'JSON',
      data : {'branch_ID':branch_ID,'student_ID':student_ID,'start':start,'len':10},
      url : base_url+'student/get_chats',
      error:function(err){
        $('#old_chats').prepend(data);
      },  
      success:function(res){
        res = JSON.parse(res);
          start = start+10;
          if(typeof res == 'object')
          {
            var data = '';
            if(res.length == 0)
            {
              data += '<div class="text-center"><br><span class="label pull-center">No Older Messages</span></div>';
            }
            else{
              $.each(res,function(k,v){
                data += '<div class="chat-message '+v.position+'"><img class="message-avatar" src="<?php echo base_url(); ?>'+v.image+'" alt=""><div class="message">  <a class="message-author" href="#"> '+v.who+' </a>  <span class="message-date">  '+moment(v.Added_on,'YYYY-MM-DD h:mm:ss').fromNow()+' </span>  <span class="message-content"> '+v.message+' </span></div></div>';
              });
            }
          }
          $('#old_chats').prepend(data);
          $('.chat-discussion').scrollTop(($('.chat-discussion')[0].scrollHeight)/start*(res.length-1));
      }
    });
  }

  function get_chats()
  {
    var branch_ID = $('#branch_ID').val();
    var student_ID = $('#student_ID').val();
    var data = '<div class="well"><img class="message-avatar" src="<?php echo base_url('img/at.png'); ?>" alt=""><div class="message h1">Welcome To Chat Room</div></div>';
    $.ajax({
      method:'POST',
      datatype:'JSON',
      data : {'branch_ID':branch_ID,'student_ID':student_ID,'start':0,'len':10},
      url : base_url+'student/get_chats',
      error:function(err){
        $('.chat-discussion').html(data);
      },  
      success:function(res){
        res = JSON.parse(res);
        var rres = JSON.stringify(res);
        if(whole_data != rres)
        {
          whole_data = rres;
          start = res.length;
          if(typeof res == 'object')
          {
            var data = '';
            if(res.length == 0)
            {
              data += '<div class="well"><img class="message-avatar" src="<?php echo base_url('img/at.png'); ?>" alt=""><div class="message h1">Welcome To Chat Room</div></div>';
            }
            else{
              $.each(res,function(k,v){
                data += '<div class="chat-message '+v.position+'"><img class="message-avatar" src="<?php echo base_url(); ?>'+v.image+'" alt=""><div class="message">  <a class="message-author" href="#"> '+v.who+' </a>  <span class="message-date">  '+moment(v.Added_on,'YYYY-MM-DD h:mm:ss').fromNow()+' </span>  <span class="message-content"> '+v.message+' </span></div></div>';
              });
            }
          }
          $('#chat-discussion').html(data);
          $('.chat-discussion').scrollTop($('.chat-discussion')[0].scrollHeight);
          $('#old_chats').html('');
        }
      }
    });
  }

  function send_msg()
  {
    $.ajax({
      method:'POST',
      datatype:'JSON',
      data : $('#msg_form').serialize(),
      url : base_url+'student/send_msg',
      error:function(err){
        $('.chat-discussion').html('');
      },  
      success:function(res){
        res = JSON.parse(res);
        if(res==true)
        {
          $('textarea[name="message"]').val('');
        }
      }
    });
  }

  function get_chat_student(stud_ID)
  {
    $.ajax({
      method:'POST',
      datatype:'JSON',
      data:{'student_ID':stud_ID},
      url : base_url+'student/get_chat_student',
      success:function(res){
        res = JSON.parse(res);
        $('#group_IDs').val(res.group_IDs.group_IDs);
        $("#batch option[value='"+res.batch_ID+"']").prop('selected', true).trigger("chosen:updated");
        $('#chat_name').html('<b>'+res.student_name+'</b>');
        $('.chat-message-form').removeClass('hidden');
      }
    });
  }

  function change_mute(id,str)
  {
    $.ajax({
      method:'POST',
      datatype:'JSON',
      data:{'student_ID':id,'status':str},
      url : base_url+'student/change_mute',
      success:function(res){
        res = JSON.parse(res);
        if(res == true)
        {
          if(str == 'checked')
          {
            toastr.success("Chat muted successfully !");
            $('.lbl_mute-'+id).html('Muted');
          }
          else
          {
            toastr.success("Chat unmuted successfully !");
            $('.lbl_mute-'+id).html('');
          }
        }
        else
        {
          toastr.error("Something went wrong !");
        }
      }
    });
  }
</script>