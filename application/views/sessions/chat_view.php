<html>
<head>
  <title> Chat Exmaples! </title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script> 
    var to_id = '<?php echo $to_id; ?>';
    var time = 0;
  
    var updateTime = function (cb) {
      $.getJSON("<?php echo base_url(); ?>chat_cont/time", function (data) {
          cb(~~data);
      });
    };
    
    var sendChat = function (message, cb) {
      $.getJSON("<?php echo base_url(); ?>chat_cont/insert_chat/" + message +"/" + to_id, function (data){
        cb();
      });
    }
    
    var addDataToReceived = function (arrayOfData) {
      arrayOfData.forEach(function (data) {
        $("#received").val($("#received").val() + "\n" + data[0]);
      });
    }
    
    var getNewChats = function () {
      $.getJSON("<?php echo base_url(); ?>chat_cont/get_chats/" + time +"/" + to_id, function (data){
       console.log(data);
        addDataToReceived(data);
        // reset scroll height
        setTimeout(function(){
           $('#received').scrollTop($('#received')[0].scrollHeight);
        }, 0);
        time = data[data.length-1][1];
      });      
    }
  
    // using JQUERY's ready method to know when all dom elements are rendered
    $( document ).ready ( function () {
      // set an on click on the button
      $("form").submit(function (evt) {
        evt.preventDefault();
        var data = $("#text").val();
        //alert(data);
        $("#text").val('');
        // get the time if clicked via a ajax get queury
        sendChat(data, function (){
          alert("done");
        });
      });
      setInterval(function (){
        getNewChats(0);
      },1500);
    });
    
  </script>
</head>
<body>
  <div style="margin:auto;">
    <h1> Chat Example on Codeigniter </h1>
    
    <textarea id="received" rows="10" cols="50">
    </textarea>
    <form>
      <input id="text" type="text" name="user">
      <input type="submit" value="Send">
    </form>
  </div>
</body>
</html>
