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
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/chatroom.css?v=20180308001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/live.css?v=201800310001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/ebhdialog.css?v=20180202001"/>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/js/dialog/css/dialog.css?v=20170531141918"/>
	<style>
	html{height: 100%;overflow: hidden;}
		.live-box{width: 100%;height:100%;box-sizing:border-box;position: relative;}
		.right-box{position: absolute;right: -320px;top:0px;width: 320px;z-index: 200;}
		#live_content{width: 100%;z-index:99;}
		.camrem_list_box{position: absolute;right: 0px;top:0px;z-index: 100;width: 300px;height: 100%;right:-300px;}
		.slide-button{width: 18px;height: 84px;position: absolute;left:-17px;top:0;display:none;}
		<?php if($course['live_type'] == 4){ ?>
			.layim-chat-tool .layim-tool-face{
    			display: none;
  			}
		<?php } ?>
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
		var room_id = <?=$course['cwid']?>;
		var liveid = '<?=$course['liveid']?>';
		var folderid = '<?=$course['folderid']?>';
		var live_type = <?=$course['live_type']?>; //判断直播类型
		var tid = '<?=empty($course['askto'])?$course['uid']:$course['askto']?>';
		var cwname = '<?=$course['title']?>';
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('websocket');	
			$websocket_fail = Ebh::app()->getConfig()->load('websocketfail');	
		?>
		<?php if(in_array($user['uid'],$websocket_fail['uid'])){?>
		var WebSocketAddr = '<?=$websocket_fail['address']?>'; 
		<?php }else{ ?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';
		<?php } ?>
		//WS链接不上转为wss地址
		var connectTimer = setTimeout(function(){
			if(ws.readyState != 1){
				ws.close();
				WebSocketAddr = '<?=$websocket_fail['address']?>';
				layui.chatroom.connect();
			}
			clearTimeout(connectTimer);
		},30000);
		
		
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
			title:'<?=$course['title']?>',
			hlsdocplay:'<?=$course['purl']?>'
		};
	</script>
	<script src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
	<script src="http://static.ebanhui.com/chatroom/js/live.js?v=20180003120001"></script>
	<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
	<script src="http://static.ebanhui.com/chatroom/js/ebhdialog.js?v=20180202001"></script>
	<script src="http://static.ebanhui.com/chatroom/js/open_attachment.js?v=20180202001"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/playlive.js?v=20171219002"></script>
</head>
<body>
<div class="default_diagram" style="width:100%;height:100%;"></div>
<div class="live-box live_border">
	<div id="live_content">
		
			
	</div>
	<?php if($course['ism3u8'] == 1 && $course['live_type'] == 4){?>
	<div class="pseudo_live">
		<div class="pseudo_box">
			<div id="flvcontrol"></div>
		</div>
		<div class="live_bottom"></div>
	</div>
	<?php } ?>
	<div class="camrem_list_box">
		<div class="slide-button slide_down">
			
		</div>
		<div class="" id="camrem_list">
		

		</div>
	</div>
	<div class="right-box">
	<?php if($course['live_type'] == 4){?>
	<div id="answer">
		<ul class="answer_content">
			
		</ul>
		<div class="ask_add">提问</div>
	</div>	
	<?php } else { ?>			
	<div class="transition_btn" title="点击切换"></div>	
	<div class="teacher-camera-box">
		
		<div id="teacher_camera">
			
		</div>
	</div>
	<div class="th_switch_top" style="position:absolute;left:0; top:0;" title="点击展开"></div>
	<div class="th_switch" style="position:absolute; left:50%; top:222px;margin-left:-42px;" title="点击收起"></div>
	<?php } ?>	
	
		<!--聊天室开始-->
	<div id="tall_all" style="position: absolute;z-index:999;top:240px; box-shadow: 0 0 50px 4px rgba(0, 0, 0, 0.2);">
		<!--作业-->
		<div class="attachment"><img src="http://static.ebanhui.com/chatroom/img/attachment.png?v=20180131001" title="附件"></div>
		<div class="homeWork"><img src="http://static.ebanhui.com/chatroom/img/homework.png?v=20180131001" title="作业"><div class="work_tip"></div></div>
		<div class="checkin"><img src="http://static.ebanhui.com/chatroom/img/checkin.png?v=20180131001" title="签到"></div>
		<div class="crosswise_switch crosswise_switch_in" title="点击收起"></div>
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<ul class="layui-tab-title">
				<li class="layui-unselect layui-this tab_li iconfont" style="font-size: 25px;">&#xe6ae;</li>
				<li class="layui-unselect  tab_li iconfont" style="font-size: 25px;">&#xe601;<span class="online_count">(0)</span></li>
				<li class="layui-unselect  tab_li iconfont" style="font-size: 25px;">&#xe636;</li>
			</ul>
			<!--内容区-->		  
			<div class="layui-tab-content">
				<div class="layui-tab-item layui-show" style="background: #fff;">
					
					<div class="notice_min" <?php if($course['notice'] == ''){?> style="display:none;" <?php } ?>></div>
					<div class="notice_max" <?php if($course['notice'] == ''){?> style="display:none;" <?php } ?>>
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
								<li class="shield shieldopen" title="接受群消息"></li>
								<li class="scraise scraise_back_on" title="点击举手后可与老师进行视频互动"></li>
							</ul>
							<div class="text_font_num"><span>0</span>/100</div>
						</div>
						<textarea id="group-msg-input" style="width:310px;height:34px"></textarea>
						<div class="tall_text_bottom">
							<p>按Enter键发送消息</p>
							<input type="button" value="发送" chatroom-event="sendGroup" />
						</div>
					</div>
					
				</div>
				<!--在线列表-->			 
				<div class="layui-tab-item tall_content_two" style="background: #fff;">
					<div class="tall_list" id="online-list">


					</div>
					<!--<div class="list_search">
						<input type="text" />
						<div class="search_img layui-icon" style="font-size: 18px; color: #ccc;">&#xe615;</div>
					</div>-->
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

		<!--聊天室结束-->

	</div>	

</div>
<script type="text/javascript">
	var timer = null;
	var timerFlash = null;
	
	
	//学习记录
	var flow = false;
	var hlsdocplay = course.hlsdocplay;
	var ctime = course.duration + "";
	var cwid = room_id + "";
	var ltime = "0";
	var lid = "0";
	
	var checkstream = function(){
		flow = document.online.checkstream();
	};
	var dolivedetect = function(){
    	$.ajax({
    		type:"GET",
    		url:hlsdocplay,
    		dataType:"jsonp",
    		timeout: 3000,
    		async:true,
    	}).fail(function(d) {
			if(d.status == 200){
				flow = true;
			}else{
				flow = false;
			}
			//setTimeout(dolivedetect,3000);
		});
	}	
	
	var upDate= function(time){
		time = time + "";
		var obj = {
		 	id:cwid,
		 	lid:lid,
		 	ctime:ctime,
		 	ltime:time,
		 	curtime:time
		}
		$.ajax({
			type:"POST",
			url:"/studyfinish.html",
			data:obj,
			async:true,
			success:function(data){
				var data = JSON.parse(data);
				lid = data.status + "";
			}
		}); 
	}
	

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
	//flash错误显示
	function errorflashcallback(rs){
		console.log(rs);
	}
	//画板flash完成加载后回调
	function screenflashcallback(){
		$(".default_diagram").hide();
		clearInterval(timer);
		clearInterval(timerFlash);
		timerFlash = setInterval(function(){
			try{
				checkstream();
			}catch(e){
				dolivedetect();
			}
		},3000)
		timer = setInterval(function(){
			if(flow){
				ltime = Number(ltime) + 1;
				if(ltime%6 == 0){
					upDate(ltime);
				}
			}
		},1000);
	//标准浏览器中的执行加载	
	//伪直播
	<?php if($course['ism3u8'] == 1 && $course['live_type'] == 4){?>
		setPlayer();
	<?php } ?>
	}
	//推流完成回调
	function uploadcallback(rs){
		console.log(rs);
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
	
	
	//伪直播
	var setPlayer = function(){
		<?php
			$starttime = SYSTIME - $course['submitat'];
			if($starttime < 0){
				$starttime = 0;
			}
		?>
		
		<?php
			if($courseSource['filelength'] > 0 && $starttime < $courseSource['filelength']){	
		?>
		playmu('<?=$course['m3u8url']?>',<?=$course['cwid']?>,'',0,1,'580','980',1,'<?= $course['thumb'] ?>',<?= $course['cwsize']?>,null,0,1,<?=$starttime?>,1,'','');
		<?php } ?>
	}
	<?php
		$roominfo = Ebh::app()->room->getcurroom();
	?>
	var _plid = 0;
	function messfun(ctime,ltime,finished,plid,curtime){
		var cwid = <?= $course['cwid'] ?>;
		var crid = <?=$roominfo['crid']?>;
		var res = studyfinish(cwid,ctime,ltime,finished,plid,curtime,crid);
		_plid = res;
		return res;
	}
	//直播浏览器关闭学生摄像头
	function _DelUser(rs){
		var index = layer.confirm('是否退出视频互动?', {icon: 7, title:'提示'}, function(index){
  			var data = {type:'close_camera',uid:user.uid};
			ws.send(JSON.stringify(data));
			$(".scraise").attr("title","点击举手后可与老师进行视频互动");
	    	$(".scraise").attr("data-status",'close_camera');
  			layer.close(index);
		});
		
	}
	var viewsObj = {};    //提问浏览保存对象
	function addView(id){
		var obj = $("#qid_" + id).find(".answer_see");
		var viewNum = Number(obj.attr("title"));
		viewNum ++;
		if(viewsObj.hasOwnProperty(id)){
			viewsObj[id] ++;
		}else{
			viewsObj[id] = 1;
		}
		if(viewNum > 999){
			obj.html("999+");
		}else{
			obj.html(viewNum);
		}
		obj.attr("title",viewNum);
	}
</script>
</body>
</html>