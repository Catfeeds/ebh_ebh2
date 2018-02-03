<html><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>聊天室demo</title>
  <script type="text/javascript">
  //WebSocket = null;
  </script>
  <link href="http://static.ebanhui.com/im/chat/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://static.ebanhui.com/im/chat/css/style.css" rel="stylesheet">
  <!-- Include these three JS files: -->
  <script type="text/javascript" src="http://static.ebanhui.com/im/chat/js/swfobject.js"></script>
  <script type="text/javascript" src="http://static.ebanhui.com/im/chat/js/web_socket.js"></script>
  <script type="text/javascript" src="http://static.ebanhui.com/im/chat/js/jquery.min.js"></script>

  <script type="text/javascript">
    if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
    WEB_SOCKET_SWF_LOCATION = "http://static.ebanhui.com/im/chat/swf/WebSocketMain.swf";
    WEB_SOCKET_DEBUG = true;
    var ws, name, client_list={};

    // 连接服务端
    function connect() {
       // 创建websocket
       ws = new WebSocket("ws://192.168.0.206:7272");
       ws.onopen = onopen;
       // 当有消息时根据消息类型显示不同信息
       ws.onmessage = onmessage; 
       ws.onclose = function() {
    	  console.log("连接关闭，定时重连");
          connect();
       };
       ws.onerror = function() {
     	  console.log("出现错误");
       };
    }

    // 连接建立时发送登录信息
    function onopen()
    {
        var login_data = {
        	type : 	'login',
        	auth : 	'<?=$auth?>',
        	room_id:'<?php echo isset($_GET['room_id']) ? $_GET['room_id'] : 1?>'
        }
        console.log("websocket握手成功，发送登录数据:"+JSON.stringify(login_data));
        ws.send(JSON.stringify(login_data));
        flush_client_list();
    }
    // 服务端发来消息时
    function onmessage(e){
    	var data = eval("("+e.data+")");
    	console.log(data);
    	switch(data['type']){
    		case 'ping':
                ws.send('{"type":"pong"}');
                break;
            case 'login':
            	say(data['client_id'],data['name'],data['avatar'],data['name']+' 加入了聊天室',data['time']);

            	client_list = data['client_list'];

            	flush_client_list();
            	break;
            case 'flush_client':
            	client_list = data['client_list'];
            	flush_client_list();
            	break;
            case 'say':
            	say(data['from_client_id'], data['from_client_name'],data['from_client_avatar'], data['content'], data['time']);
            	break;
    	}
    }


    // 刷新用户列表框
    function flush_client_list(){
    	var userlist_window = $("#userlist");
    	var client_list_slelect = $("#client_list");
    	userlist_window.empty();
    	client_list_slelect.empty();
    	userlist_window.append('<h4>在线用户</h4><ul>');
    	client_list_slelect.append('<option value="all" id="cli_all">所有人</option>');
    	for(var p in client_list){
            userlist_window.append('<li id="'+p+'">'+client_list[p]+'</li>');
            client_list_slelect.append('<option value="'+p+'">'+client_list[p]+'</option>');
        }
    	$("#client_list").val(select_client_id);
    	userlist_window.append('</ul>');
    }

    // 提交对话
    function onSubmit() {
      var input = document.getElementById("textarea");
      var to_client_id = $("#client_list option:selected").attr("value");
      var to_client_name = $("#client_list option:selected").text();
      var say_data = {
      	type : 	'say',
      	to_client_id:to_client_id,
      	to_client_name:to_client_name,
      	content:input.value.replace(/"/g, '\\"').replace(/\n/g,'\\n').replace(/\r/g, '\\r')
      };
      ws.send(JSON.stringify(say_data));
      input.value = "";
      input.focus();
    }

    //发言
    function say(from_client_id, from_client_name, avatar,content, time){
    	$("#dialog").append('<div class="speech_item"><img width="38px" src="'+avatar+'" class="user_icon" /> '+from_client_name+' <br> '+time+'<div style="clear:both;"></div><p class="triangle-isosceles top">'+content+'</p> </div>');
    }

    $(function(){
    	select_client_id = 'all';
	    $("#client_list").change(function(){
	         select_client_id = $("#client_list option:selected").attr("value");
	    });
    });
  </script>
</head>
<body onload="connect();">
    <div class="container">
	    <div class="row clearfix">
	        <div class="col-md-1 column">
	        </div>
	        <div class="col-md-6 column">
	           <div class="thumbnail">
	               <div class="caption" id="dialog"></div>
	           </div>
	           <form onsubmit="onSubmit(); return false;">
	                <select style="margin-bottom:8px" id="client_list">
                        <option value="all">所有人</option>
                    </select>
                    <textarea class="textarea thumbnail" id="textarea"></textarea>
                    <div class="say-btn"><input type="submit" class="btn btn-default" value="发表" /></div>
               </form>
               
	        </div>
	        <div class="col-md-3 column">
	           <div class="thumbnail">
                   <div class="caption" id="userlist"></div>
               </div>
               
	        </div>
	    </div>
    </div>
    
</body>
</html>
