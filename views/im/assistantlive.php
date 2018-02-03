<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<title><?=$course['title']?></title>
	<?php 
		$systemsetting = Ebh::app()->room->getSystemSetting();
	?>
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/iconfont.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/demo.css"/>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/font/iconfont.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	
	<link rel="stylesheet" href="http://static.ebanhui.com/chatroom/layui/css/layui.css">
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/chatroom.css?v=20180131001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/assistantlive.css?v=20180131001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/ebhdialog.css?v=20180202001"/>
	<style>
		html{height: 100%;overflow: hidden;}
		.live-box{width: 100%;box-sizing:border-box;position: relative;}
		.right-box{position: absolute;right: -320px;top:0px;width: 320px;z-index: 200;}
		#live_content{width: 100%;z-index:99;}
		.camrem_list_box{position: absolute;right: 0px;top:0px;z-index: 100;width: 300px;height: 100%;right:-300px;}
		.slide-button{width: 18px;height: 84px;position: absolute;left:-17px;top:0;display:none;}
	</style>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/swfobject.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/web_socket.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/reconnecting-websocket.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="http://www.ebh.net/im/js.html?cwid=<?=$course['cwid']?>&rand=<?=time()?>"></script>

	  		
	<script type="text/javascript">
		var isebhbrowser = typeof(cef) != 'undefined';
	  	if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
	    WEB_SOCKET_SWF_LOCATION = "/static/flash/WebSocketMain.swf";
	    WEB_SOCKET_DEBUG = true;
	    var ws;
		var auth = '<?=$auth?>';
		var key = '<?php echo base64_encode($auth);?>'
		var room_id = <?=$course['cwid']?>;
		var liveid = '<?=$course['liveid']?>';
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('websocket');	
		?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';
		
		var user={
			username:'<?=$user['username']?>',
			name:'<?php echo $user['realname']!=''?$user['realname']:$user['username'] ?>',
			uid:<?=$user['uid']?>
		};
		var course = {
			realname:'<?=$course['realname']?>',
			starttime:<?=$course['submitat']?>,
			endtime:<?=$course['endat']?>,
			duration:<?=$course['cwlength']?>,
			systime:<?php echo time();?>,
			title:'<?=$course['title']?>'
		};
	</script>
	<script src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
	<script src="http://static.ebanhui.com/chatroom/js/assistantlive.js?v=20180131003"></script>
	<script src="http://static.ebanhui.com/chatroom/js/open_attachment.js?v=20180202001"></script>
	<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
	<script src="http://static.ebanhui.com/chatroom/js/ebhdialog.js?v=20180202001"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/playlive.js?v=20171222001"></script>
</head>
<body>
<div class="default_diagram" style="width:100%;height:100%;"></div>

<div class="live-box live_border">
	<?php if($course['ism3u8'] == 1 && $course['live_type'] == 4){?>
	<div class="pseudo_live">
		<div class="pseudo_box">
			<div id="flvcontrol"></div>
		</div>
		<div class="live_bottom"></div>
	</div>
	<?php } ?>	
	<div id="live_content">
		
			
	</div>
	
		
	<div class="camrem_list_box">
		<div class="slide-button slide_down">
			
		</div>
		<div class="" id="camrem_list">
		

		</div>
	</div>
	
	
	
	
	<div class="right-box">	
	<div class="transition_btn" title="点击切换"></div>	
	<div class="teacher-camera-box">
		
		<div id="teacher_camera">
			
		</div>
	</div>
	<div class="th_switch_top" style="position:absolute;left:0; top:0;" title="点击展开"></div>
	<div class="th_switch" style="position:absolute; left:50%; top:222px;margin-left:-42px;" title="点击收起">
	</div>
		<!--聊天室开始-->
	<div id="tall_all" style="position: absolute;z-index:999;top:240px; box-shadow: 0 0 50px 4px rgba(0, 0, 0, 0.2);">
		<!--作业-->
		<div class="attachment"><img src="http://static.ebanhui.com/chatroom/img/attachment.png?v=20180131001" title="附件"></div>
		<div class="homeWork"><img src="http://static.ebanhui.com/chatroom/img/homework.png?v=20180131001" title="作业"></div>
		<div class="checkin"><img src="http://static.ebanhui.com/chatroom/img/checkin.png?v=20180131001" title="签到"></div>
		<div class="crosswise_switch crosswise_switch_in" title="点击收起"></div>
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<ul class="layui-tab-title">
				<li class="layui-unselect layui-this tab_li iconfont" style="font-size: 25px;">&#xe6ae;</li>
				<li class="layui-unselect  tab_li iconfont online_tab" style="font-size: 25px;">&#xe601;<span class="online_count">(0)</span><span class="red_radius"></span></li>
				<li class="layui-unselect  tab_li iconfont" style="font-size: 25px;">&#xe636;</li>
				<li class="layui-unselect  tab_li iconfont blacklist_tab" style="font-size: 25px;"><span></span></li>
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
								<?php if($course['live_type'] != 4){ ?>
								<li class="scraise scraise_back_on" title="点击举手后可与老师进行视频互动"></li>
								<?php } ?>
								
							</ul>
							<ul class="toolbar">
								<li class="raise raise_back_on"></li>
								<li class="gag gag_back_on" title="开启禁言" ></li>
								<li title="开启锁屏" class="lock lock_back_statr"/>
							</ul>
						</div>
						<textarea id="group-msg-input" style="width:310px;height:34px"></textarea>
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
				<!--黑名单-->
				<div class="layui-tab-item tall_content_four">
					<div class="blacklist" id="black-list">
		
					</div>
				</div>	
			</div>

			<!--新消息提示-->	
			<div class="tall_news" id="new_message_tips"></div>
			<!--在线列表页点击菜单-->
			<div class="click_list">
				<ul>
					<li class="private_chat">私聊</li>
					<li class="open_audio">开启语音</li>
					<li class="open_video">开启视频</li>
					<li class="close_video">关闭视频/语音</li>
					<li class="black_list">禁言</li>
					<li class="shot_off">请出教室</li>
				</ul>
			</div>
			<!--黑名单页点击菜单-->
			<div class="show_list">
				<ul>
					<li class="black_chat">私聊</li>
					<li class="out_blacklist">取消禁言</li>
				</ul>
			</div>
		</div>
	</div>

		<!--聊天室结束-->

	</div>	


</div>

<script type="text/javascript">
	//标记flash加载完成
	var initdone = false;
	//存放硬件信息
	var hardware_info = {};
	//白板窗口是否最小化
	var is_min = false;
	//摄像头权限标记
	var cameraAccess = false;
	//保存为打开的摄像头
	var userOnline = [];
	//保存flash转换按钮变量
	var transition_btn = false;
	
	function streamcallback(){
		transition_btn = true;
	}
	
	
	//学生摄像头列表回调
	function userflashcallback(){
		setTimeout(function(){
			layui.chatroom.openCamera();
		},500);
	}
	//摄像头权限修改回调
	function changecallback(rs){
		if(rs == 'true' && typeof(rs) != 'undefined'){
			cameraAccess = true;
		}else{
			cameraAccess = false;
		}
	}
	
	function initfun(arg){
		initdone = true;
		hardware_info = arg;
		//console.log(arg);
		
		//重设下flash高度
		var allH = $(window).height();
		$('#live_content').css('height',allH+'px');
		
	}
	//画板flash完成加载后回调
	function screenflashcallback(){
		$(".default_diagram").hide();
		//标准浏览器中的执行加载	
		//伪直播
		<?php if($course['ism3u8'] == 1 && $course['live_type'] == 4){?>
			setPlayer();
		<?php } ?>
		
	}
	//推流完成回调.
	function uploadcallback(rs){
		console.log(rs);
	}
	//关闭学生摄像头推流
	function closecamera(uid){
		var data = {type:'close_camera',uid:uid};
		console.log(data);
		ws.send(JSON.stringify(data));
	}	
		
	//摄像头权限回调
	function speakcallback(rs){
		if(rs == 'true' && typeof(rs) != 'undefined'){
			cameraAccess = true;
			
		}else{
			cameraAccess = false;
		}
		
		if(cameraAccess){
			layui.chatroom.handup();
		}else{
			layui.chatroom.newMsgTips({type:'tips',content:'未检测到您的麦克风'});
		}
		
	}
	
	//点击切换flash
		
		$(".transition_btn").on("click",function(){
			if(transition_btn){
				transition_btn = false;
				document.online.changestream();
				document.onlineCamera.changestream();	
			}
			
		});
	var setPlayer = function(){
		<?php
			$starttime = SYSTIME - $course['submitat'];
			if($starttime < 0){
				$starttime = 0;
			}
			if($courseSource['filelength'] > 0 && $starttime > $courseSource['filelength']){
				$starttime = 0;
			}
		?>
		playmu('<?=$course['m3u8url']?>',<?=$course['cwid']?>,'',0,1,'580','980',1,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>,null,0,1,<?=$starttime?>,1,'','');
	};
	//直播浏览器关闭学生摄像头
	function _DelUser(rs){
		var index = layer.confirm('是否退出视频互动?', {icon: 7, title:'提示'}, function(index){
			var data = {type:'close_camera',uid:user.uid};
			ws.send(JSON.stringify(data));
			$(".scraise").attr("title","点击举手后可与老师进行视频互动");
		    $(".scraise").attr("data-status",'close_camera');
		    layer.close(index);
		})    
	}
</script> 
</body>
</html>