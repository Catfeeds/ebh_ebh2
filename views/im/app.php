<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/iconfont.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/demo.css"/>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/font/iconfont.js"></script>

	
	<link rel="stylesheet" href="http://static.ebanhui.com/chatroom/layui/css/layui.css">
	
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/swfobject.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/web_socket.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/common.css?v=2017021001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/wap/css/tliveapp.css?v=20170601003"/>
	<script type="text/javascript" src="http://www.ebh.net/im/js.html?cwid=<?=$course['cwid']?>"></script>
    
    <script type="text/javascript">
	  	var ws;
    	var auth = '<?=$key?>';
    	var room_id = <?=$course['cwid']?>;
		var liveid = '<?=$course['liveid']?>';
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('websocket');	
			
		?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';
	</script>
	<script src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
	<script src="http://static.ebanhui.com/chatroom/wap/js/liveapp.js?v=20170614001"></script>
	<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
</head>
	<!--<div class="empty"></div>-->
<div id="tall_all">
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<ul class="layui-tab-title">
				<li class="layui-unselect layui-this tab_li iconfont" style="font-size: 25px;">&#xe6ae;</li>
				<li class="layui-unselect  tab_li iconfont online_tab" style="font-size: 25px;position:relative;">&#xe601;<span class="online_count">(0)</span><span class="red_radius"></span></li>
				<li class="layui-unselect  tab_li iconfont" style="font-size: 25px;">&#xe636;</li>
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
							<?php if(isset($course['notice'])){?>
								<?=$course['notice']?>
							<?php } ?>
							
						</div>
					</div>
					<!--老师发言-->	
					<div class="tall_one" id="content-list">

					</div>
					<!--用户输入-->		
					<div class="tall_text">
						<div class="operate">
							<ul class="text_function">
								<li class="layui-icon tab_li layui-unselect" id="qqface" title="表情" chatroom-event="qqface"></li>
								<li class="layui-icon layim-tool-image tab_li layui-unselect" title="上传图片" chatroom-event="group_chat_img" style="position: relative;"><input type="file" id="group_chat_img" name="Filedata"/></li>
							</ul>
						</div>
						<div class="_input">
							<textarea placeholder="请输入内容" id="group-msg-input"/></textarea>
							<span class="send_btn chat_send" chatroom-event="sendGroup"></span>
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
			</div>

			<!--新消息提示-->	
			<div class="tall_news" id="new_message_tips"></div>
		</div>
	</div>
</body>
</html>