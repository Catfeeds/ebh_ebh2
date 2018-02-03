<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>IMdemo</title>
<script src="http://static.ebanhui.com/im/js/jquery.min.js"></script>
<link rel="stylesheet" href="http://static.ebanhui.com/im/build/css/layui.css" media="all">
</head>
<body>
<script src="http://static.ebanhui.com/im/build/layui.js"></script>
<script>
layui.use('layim', function(layim){
	layim.config({
		init: {
	      	url: '/im/ajax/iminit.html', //接口地址（返回的数据格式见下文）
	      	type: 'get', //默认get，一般可不填
	      	data: {} //额外参数
	    },
	    members:{
	    	url:'/im/ajax/group_member.html',
	    	type:'get',
	    	data:{}
	    },
	    brief: false, //是否简约模式（默认false，如果只用到在线客服，且不想显示主面板，可以设置 true）
		title: '我的LayIM', //主面板最小化后显示的名称
		maxLength: 3000, //最长发送的字符长度，默认3000
		isfriend: true, //是否开启好友（默认true，即开启）
		isgroup: true, //是否开启群组（默认true，即开启）
		right: '0px' //默认0px，用于设定主面板右偏移量。该参数可避免遮盖你页面右下角已经的bar。
	});
	var socket = new WebSocket('ws://192.168.0.206:7272');


	//连接成功时触发
	socket.onopen = function(){
		var connect = {
	      type: 'connect',
	      content: {
			auth:'<?=$auth?>'
	      }
	    }
	    socket.send(JSON.stringify(connect));

	};

	socket.onmessage = function(event) {
		console.log(event);
      	var e = JSON.parse(event.data);
      	console.log(e);
      	switch (e.type) {
      		case 'getMessage':
				if(e.from_uid != <?=$user['uid']?>){
					layim.getMessage(e.content);
				}
	        	
	        break;
			case 'ping':
				socket.send(JSON.stringify({type:'pong'}));
			break;

      	}
    }


	layim.on('sendMessage', function(data) {
      var To = data.to;
      //发送消息Socket服务
      console.log(data);
      socket.send(JSON.stringify({
        type: 'chatMessage',
        content: data
      }));

    });

});
</script>
</body>
</html>