<div class="ibox chat-view">
  <div class="ibox-title">
    <!-- <small class="pull-right text-muted">Last message:  Mon Jan 26 2015 - 18:39:23</small> -->
    <span id="chat_name"><h2>Recent Chats</h2></span>
  </div>


  <div class="ibox-content">

    <div class="row">

      <div class="col-md-12">
        
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
          <!-- <div class="chat-message left">
            <img class="message-avatar" src="img/a1.jpg" alt="">
            <div class="message">
              <a class="message-author" href="#"> Michael Smith </a>
              <span class="message-date"> Mon Jan 26 2015 - 18:39:23 </span>
              <span class="message-content">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
              </span>
            </div>
          </div>
          <div class="chat-message right">
            <img class="message-avatar" src="img/a4.jpg" alt="">
            <div class="message">
              <a class="message-author" href="#"> Karl Jordan </a>
              <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
              <span class="message-content">
                Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover.
              </span>
            </div>
          </div> -->
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="chat-message-form hidden">
          <div class="form-group input-group">
            <form id="msg_form" class="">
              <textarea class="form-control message-input" id="message" name="message" placeholder="Enter message text" autocomplete="off"></textarea>
              <input type="hidden" id="student_ID">
              <input type="hidden" name="group_IDs" id="group_IDs">
              <input type="hidden" name="branch_ID" id="branch_ID" value="<?php echo $this->uri->segment(3); ?>">
            </form>
            <a onclick="send_msg()" class="lazur-bg input-group-addon btn btn-primary"><b> Send </b><i class="fa fa-paper-plane-o"></i> </a>
          </div>

        </div>
      </div>
    </div>


  </div>

</div>
<script type="text/javascript" src="<?php echo base_url('js/moment.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    get_students_details();
  });


  function get_students_details()
  {
    var base_url = '<?php echo base_url(); ?>';
    $.ajax({
      type:'POST',
      url: '<?php echo base_url(); ?>'+'student/get_branchwise_students/'+'<?php echo $this->uri->segment(3); ?>',
      success:function(response)
      {
        var data = '';
        if(response != 'null')
        {
          response = JSON.parse(response);
          start_chat(response[0].ID,response[0].group_IDs);
        }
      }
    });
  }

  function start_chat(id,group_IDs)
  {
    $('#group_IDs').val(group_IDs);
    $('#student_ID').val(id);
    $('.chat-message-form').removeClass('hidden');
    $('#old_msg').removeClass('hidden');
  }

  start = 0;
  whole_data = '';//{};

  setInterval(function(){
    get_chats();
  },500);

  function get_chats_old()
  {
    var branch_ID = $('#branch_ID').val();
    var student_ID = $('#student_ID').val();
    var data = '';
    //alert(start);
    $.ajax({
      method:'POST',
      datatype:'JSON',
      data : {'branch_ID':branch_ID,'student_ID':student_ID,'start':start,'len':10},
      url : base_url+'student/get_chats',
      error:function(err){
        // toastr.error('Something Went Wrong');
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
              // console.log(res);
              $.each(res,function(k,v){
                data += '<div class="chat-message '+v.position+'"><img class="message-avatar" src="<?php echo base_url(); ?>'+v.image+'" alt=""><div class="message">  <a class="message-author" href="#"> '+v.who+' </a>  <span class="message-date">  '+moment(v.Added_on,'YYYY-MM-DD h:mm:ss').fromNow()+' </span>  <span class="message-content"> '+v.message+' </span></div></div>';
              });
            }
          }
          $('#old_chats').prepend(data);
          // $('#old_chats').scrollTop($('#old_msg')[0].scrollHeight);
          console.log($('.chat-discussion'));
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
        // toastr.error('Something Went Wrong');
        $('.chat-discussion').html(data);
      },  
      success:function(res){
        res = JSON.parse(res);
        // console.log(whole_data);
        // console.log(res);
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
              // console.log(res);
              $.each(res,function(k,v){
                data += '<div class="chat-message '+v.position+'"><img class="message-avatar" src="<?php echo base_url(); ?>'+v.image+'" alt=""><div class="message">  <a class="message-author" href="#"> '+v.who+' </a>  <span class="message-date">  '+moment(v.Added_on,'YYYY-MM-DD h:mm:ss').fromNow()+' </span>  <span class="message-content"> '+v.message+' </span></div></div>';
              });
            }
          }
          $('#chat-discussion').html(data);
          $('.chat-discussion').scrollTop($('.chat-discussion')[0].scrollHeight);
          $('#old_chats').html('');
        }
        // else{
        //   whole_data = '';
        // }
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
        // toastr.error('Something Went Wrong');
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
</script>