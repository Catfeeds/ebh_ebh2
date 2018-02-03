<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<title>教师聊天室</title>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/reconnecting-websocket.min.js"></script>
	<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/iconfont.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/demo.css"/>
	<style>
		.camrem_list_box{position: absolute;right:-100%;top:45px;width: 100%;z-index: 1000;}
		.slide-button{width: 84px;height: 10px;position:absolute;left:50%;bottom:-10px;margin-left:-42px;display:none;}
	</style>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/font/iconfont.js"></script>

	
	<link rel="stylesheet" href="http://static.ebanhui.com/chatroom/layui/css/layui.css">
	
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/swfobject.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/web_socket.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/reconnecting-websocket.min.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/common.css?v=2017021001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/tlive.css?v=20180131001"/>
	<script type="text/javascript" src="http://www.ebh.net/im/js.html?cwid=<?=$course['cwid']?>&rand=<?=time()?>"></script>
	<script type="text/javascript">
	  	if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
	    WEB_SOCKET_SWF_LOCATION = "/static/flash/WebSocketMain.swf";
	    WEB_SOCKET_DEBUG = true;
	    var ws;
		var auth = '<?=$key?>';
		var room_id = <?=$cwid?>;
		var liveid = '<?=$course['liveid']?>';
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('websocket');	
		?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';
		
		

		var course = {
			uid:<?=$course['uid']?>,
			realname:'<?=$course['realname']?>',
			starttime:<?=$course['submitat']?>,
			endtime:<?=$course['endat']?>,
			duration:<?=$course['cwlength']?>,
			systime:<?php echo time();?>,
			title:'<?=$course['title']?>'
		};
	</script>
	<script src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
	<script src="http://static.ebanhui.com/chatroom/js/tlive.js?v=20180131002"></script>
	<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
</head>
<body>
<div class="camrem_list_box">
	<div class="slide-button slide_down" title="点击展开">
							
	</div>
	<div class="" id="camrem_list">		
				
	</div>
</div>
	<!--<div class="empty"></div>-->
<div id="tall_all">
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<ul class="layui-tab-title">
				<li class="layui-unselect layui-this tab_li iconfont" style="font-size: 25px;">&#xe6ae;</li>
				<li class="layui-unselect  tab_li iconfont online_tab" style="font-size: 25px;position:relative;">&#xe601;<span class="online_count">(0)</span><span class="red_radius"></span></li>
				<li class="layui-unselect  tab_li iconfont" style="font-size: 25px;">&#xe636;</li>
				<li class="layui-unselect tab_li iconfont list_btn" style="font-size: 25px;"><span></span></li>
			</ul>
			<!--内容区-->		  
			<div class="layui-tab-content">
				<div class="layui-tab-item layui-show" style="background: #fff;">

					<div class="notice_min"  <?php if($course['notice'] == ''){?> style="display:none;" <?php } ?> ></div>
					<div class="notice_max"  <?php if($course['notice'] == ''){?> style="display:none;" <?php } ?> >
						<div class="notice_top">
							<p class="title"><span class="title_img"></span><span class="title_txt">【公告】</span></p>
							<p class="close"><span></span></p>
						</div>
						<div class="notice_content">
							<?=$course['notice']?>
						</div>
					</div>
					<!--老师发言-->	
					<div class="tall_one" id="content-list">

					</div>
					<!--用户输入-->		
					<div class="tall_text">
						<div class="tall_text_top">
							<ul class="text_function">
								<li class="layui-this layui-icon tab_li layui-unselect" id="qqface" title="表情" chatroom-event="qqface"></li>
								<li class="layui-icon layim-tool-image tab_li layui-unselect" title="上传图片" chatroom-event="group_chat_img" style="position: relative;"><input type="file" id="group_chat_img" name="Filedata"/></li>
								<li class="layui-icon layim-tool-image tab_li layui-unselect screen" title="截图 (按Ctrl键可显示当前窗口)
" chatroom-event="group_chat_img" style="position: relative;"><input type="file" id="group_chat_img" name="Filedata" accept=".copyscreen"></li>
							</ul>
							<ul class="toolbar">
								<li class="raise raise_back_on"></li>
								<li class="gag gag_back_on" title="开启禁言" ></li>
								<li class="lock lock_back_statr" title="开启锁屏"></li>
							</ul>
						</div>
						<textarea id="group-msg-input" style="height:34px"></textarea>
						<div class="tall_text_bottom">
							<p>按Enter键发送消息</p>

							<input type="button" value="发送" chatroom-event="sendGroup" />
							<div class="text_font_num"><span>0</span>/100</div>
						</div>
					</div>
					
				</div>
				<!--在线列表-->			 
				<div class="layui-tab-item tall_content_two" style="background: #fff;">
					<div class="tall_list" id="online-list">


					</div>
					<div class="list_search">
						<input type="text" />
						<div class="search_img layui-icon" style="font-size: 18px; color: #ccc;">&#xe615;</div>
					</div>
				</div>
				<!--私聊列表-->
				<div class="layui-tab-item tall_content_three">
					<div class="privatecha_list" id="recent-list">
						
					</div>


				</div>
				<!--flash区域-->
				<div class="layui-tab-item tall_content_four" style="position: relative;">
					
				</div>	
			</div>

			<!--新消息提示-->	
			<div class="tall_news" id="new_message_tips"></div>
			<!--右键菜单-->
			<div class="click_list">
				<ul>
					<li class="private_chat">私聊</li>
					<li class="open_audio">开启语音</li>
					<li class="open_video">开启视频</li>
					<li class="close_video">关闭视频/语音</li>
					<li class="shot_off">请出教室</li>
				</ul>
			</div>
		</div>
	</div>

		<!--聊天室结束-->
</body>
<script>
	//标记flash加载完成
	var initdone = false;
		//保存为打开的摄像头
	var userOnline = [];
	//学生摄像头列表回调
	function userflashcallback(){
		//layui.chatroom.connect();
		setTimeout(function(){
			layui.chatroom.automaticOpen();	
		},500)	
		
	}
	//关闭学生摄像头推流
	function closecamera(uid){
		var data = {type:'close_camera',uid:uid};
		console.log(data);
		ws.send(JSON.stringify(data));
	}	
	
	
function initfun(arg){
		initdone = true;
		hardware_info = arg;
		//console.log(arg);
		
		//重设下flash高度
		$('#camrem_list').css('height','30%');
		
}


			
	
</script>


</html>