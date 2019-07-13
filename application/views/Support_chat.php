
<?php //ob_start(); ?>
<div class="page-content">
  <div class="wrap" id="wrap">
    <!--<ol class="back_menu">
        <li><a href="#">Dashboard </a> / </li>
          <li><a href="#">Dashboard </a> / </li>
          <li><a href="#">Panel </a> </li>
      </ol>-->
  <h1 align="center">Chat</h1>
    <div class="container">
      
        <div class="row">
          <div class="col-md-12">
          	<div class="panel panel-primary widget-chat">
              <div class="body_header">
                <span class="icon padding-right5">
                  <i class="fa fa-comment"></i>
                </span>
                <h4 class="margin-top5">Support chat</h4>
              </div>
              <div class="body_text_text">
                <div class="chat-content">
                  <div class="chat-messages">
                    <div id="chat-messages-inner" class="chat-messages-inner"></div>
                  </div>
                  <div class="chat-message well"> 
                    <span class="input-box input-group">
                      <input placeholder="Enter message here..." type="text" class="form-control input-small" name="msg-box" id="msg-box" />
                      <span class="input-group-btn">
                        <button class="btn btn-success btn-small" type="button">Send</button>
                      </span>
                    </span> 
                  </div>
                </div>
              </div>
            </div>
        </div>
     </div>

   </div>
  </div> 
  </div>  
  <script src="<?php echo base_url("js/jquery.nicescroll.min.js"); ?>"></script>  
  <!--<script src="<?php echo base_url("js/unicorn.chat.js"); ?>"></script>-->
  <script type='text/javascript'>
    var data = $('.chat-messages-inner').val();
    //alert(data);
$(document).ready(function(){
  
  var msg_template = '<p><span class="msg-block"><strong></strong><span class="time"></span><span class="msg"></span></span></p>';
  var widget_chat = $('.widget-chat');
  var messages = $('#chat-messages');
  var message_box = $('.chat-message');
  var message_box_input = $('.chat-message input');
  var messages_inner = $('#chat-messages-inner');


  $('.chat-message button').click(function(){
   // alert('hi');
    var input = $(this).parent().siblings('input[type=text]');    
    if(input.val() != ''){
      add_message('You','img/demo/av1.jpg',input.val(),true);
    } else {
      $('.input-box').addClass('has-error');
    }
  });


    var i = 0;
  function add_message(name,img,msg,clear) {

    i = i + 1;
    
    var time = new Date();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var sess_id = '<?php echo $this->data['Login']['id']; ?>';
    //alert(minutes);
    if(hours < 10) hours = '0' + hours;
    if(minutes < 10) minutes = '0' + minutes;
    var id = 'msg-'+i;
        var idname = name.replace(' ','-').toLowerCase();
        //alert(msg;)
  
    var partner_id = '<?php echo $partner_id; ?>';
    //alert(msg);
    var datagiven = {'partner_id':partner_id,'conversat':msg}
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>Chat/add_chat_data',
        data:datagiven,
        success:function(response)
        {
          console.log(response);
         /* $.each(response,function(key,val)
           { */
               messages_inner.append('<p id="'+id+'" class="user-'+idname+'"><img src="'+img+'" alt="" />'
                    +'<span class="msg-block"><strong>'+name+'</strong> <span class="time">- '+hours+':'+minutes+'</span>'
                   +'<span class="msg">'+response.Conversation+'</span></span></p>');
         /*  });*/
        }
    })

    $('#'+id).fadeOut(0).addClass('show');
    if(clear) {
      $('.input-box').removeClass('has-error');
      message_box_input.val('').focus();

    }
    messages.animate({ scrollTop: messages_inner.height() },1000);
    
    messages.getNiceScroll().resize();
  }

});
  </script>