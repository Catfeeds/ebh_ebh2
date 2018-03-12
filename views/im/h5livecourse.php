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
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/chatroom.css?v=20180117001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/live.css?v=20171228001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/ebhdialog.css?v=20180113001"/>
	<style>
	html{height: 100%;overflow: hidden;}
		.live-box{width: 100%;height:100%;box-sizing:border-box;position: relative;}
		.right-box{position: absolute;right: -320px;top:0px;width: 320px;z-index: 200;}
		#live_content{width: 100%!important;height:100%!important;z-index:99;}
		.camrem_list_box{position: absolute;right: 0px;top:0px;z-index: 100;width: 300px;height: 100%;right:-300px;}
		.slide-button{width: 18px;height: 84px;position: absolute;left:-17px;top:0;display:none;}
		video::-webkit-media-controls,
		video::-moz-media-controls,
		video::-webkit-media-controls-enclosure{
		    display:none !important;
		}
		
		video::-webkit-media-controls-panel,
		video::-webkit-media-controls-panel-container,
		video::-webkit-media-controls-start-playback-button {
		    display:none !important;
		    -webkit-appearance: none;
		}
	</style>
	<!--[if lt IE 10]> 
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/typedarray.js"></script>
	<![endif]-->
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/reconnecting-websocket.min.js"></script>
	<script type="text/javascript" src="http://www.ebh.net/im/js.html?cwid=<?=$course['cwid']?>"></script> 
	<script type="text/javascript">
	  	if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
	    WEB_SOCKET_SWF_LOCATION = "/static/flash/WebSocketMain.swf";
	    WEB_SOCKET_DEBUG = true;
	    var ws;
		var auth = '<?=$auth?>';
		var room_id = <?=$course['cwid']?>;
		var liveid = '<?=$course['liveid']?>';
		var live_type = <?=$course['live_type']?>; //判断直播类型
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('websocket');	
		?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';
		
		
		var user={
			username:'<?=$user['username']?>',
			name:'<?php echo $user['realname']!=''?$user['realname']:$user['username'] ?>',
			uid:<?=$user['uid']?>
		};
		<?php
			$starttime = SYSTIME - $course['submitat'];
			if($starttime < 0){
				$starttime = 0;
			}
		?>
		var course = {
			realname:'<?=$course['realname']?>',
			starttime:<?=$course['submitat']?>,
			endtime:<?=$course['endat']?>,
			duration:<?=$course['cwlength']?>,
			systime:<?php echo time();?>,
			title:'<?=$course['title']?>',
			httpdocplay:'<?=$course['purl']?>',
			cameraurl:'<?=$course['cameraurl']?>',
			m3u8url:'<?=$course['m3u8url']?>',
			videostatr:<?=$starttime?>
		};
	</script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/flv.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/hls.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/h5live.js?v=20180309001"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/ebhdialog.js?v=20171128002"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/playlive.js?v=20171225002"></script>
</head>
<body>
<div class="default_diagram" style="width:100%;height:100%;"></div>
<?php if($course['live_type'] == 4){?>
<input type="hidden" name="ispseudo" id="ispseudo" value="1"/>	
<?php } else { ?>
<input type="hidden" name="ispseudo" id="ispseudo" value="0"/>
<?php } ?>
<?php
	if($courseSource['filelength'] > 0 && $starttime < $courseSource['filelength']){	
?>
<input type="hidden" name="isended" id="isended" value="0"/>
<?php } else { ?>
<input type="hidden" name="isended" id="isended" value="1"/>	
<?php } ?>					
<div class="live-box live_border">
	<div class="pseudo_live">
		<div class="live_top">
			<span><?=$course['title']?></span><span>课程已进行 : <span class="surplus">00 : 00 : 00</span></span>
		</div>
		<div class="tips">
			<p class="tip_text">资料准备中  请稍候~</p>
		</div>
		<div class="pseudo_box" style="display:none;">
				<video id="live_content"></video>
		</div>
		<div class="live_bottom">
			<?php if($course['live_type'] != 4){ ?><div class="cyberFull" title="全屏"></div><?php } ?>
		</div>
	</div>
	<div class="right-box">
	<!--		
	<div class="transition_btn" title="点击切换"></div>
	-->	
	<div class="teacher-camera-box">
		<p class="camera_title"><?=$course['realname']?></p>
		<div class="teacher_camera_bak"></div>
		<div class="camera_box" style="display:none">
			<video id="teacher_camera" width="320" height="240">
			
			</video>
		</div>
		
	</div>
	<div class="th_switch_top" style="position:absolute;left:0; top:0;" title="点击展开"></div>
	<div class="th_switch" style="position:absolute; left:50%; top:222px;margin-left:-42px;" title="点击收起">
	</div>
		<!--聊天室开始-->
	<div id="tall_all" style="position: absolute;z-index:999;top:240px; box-shadow: 0 0 50px 4px rgba(0, 0, 0, 0.2);">
		<!--作业-->
		<div class="homeWork"><img src="http://static.ebanhui.com/chatroom/img/homework.png" title="作业"><div class="work_tip"></div></div>
		<div class="checkin"><img src="http://static.ebanhui.com/chatroom/img/checkin.png" title="签到"></div>
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
 	//课件进行时间
    var timer = null;
    var nowTime = new Date();                                    //本地时间
	var startTime = new Date(course.starttime * 1000);           //开始时间
	var systime = new Date(course.systime * 1000);               //系统时间
    var poor = parseInt((nowTime - systime) / 1000);
    clearInterval(timer);
    timer = setInterval(function(){
    	setStarttime();
    },1000);
    //设置进行时间
	function setStarttime(){
		var newTimes = new Date();
		if(newTimes > startTime){
			var num = parseInt((newTimes - startTime + poor) / 1000);
			var h = Math.floor(num / 3600);
			var h1 = num % 3600;
			var m = Math.floor(h1 / 60);
			var s = h1 % 60;
			var timeStr = d(h) + " : " + d(m) + " : " + d(s);
			$(".surplus").html(timeStr);
		}
	}
	//时间格式处理
	function d(num){
		var time = null;
		num >= 10? time = num : time = "0" + num; 
		return time; 
	}
	//学习记录
	var timer = null;
	var cwid = room_id + ""; 
	var ctime = course.duration + ""; 
	var ltime = "0";
	var lid = "0";
	<?php if($course['live_type'] != 4){?> 
	var flow = false;
	var hlsdocplay = course.hlsdocplay;
	var cwid = room_id + "";
	var dolivedetect = function(){
    	$.ajax({
    		type:"GET",
    		url:httpdocplay,
    		dataType:"jsonp",
    		timeout: 3000,
    		async:true,
    	}).fail(function(d) {
			if(d.status == 200){
				flow = true;
			}else{
				flow = false;
			}
			setTimeout(dolivedetect,3000);
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
	<?php } else { ?>
		$("#live_content")[0].addEventListener("play",function(){
			timer = setInterval(function(){
				ltime = Number(ltime) + 1;
				if(ltime%6 == 0){
					upDate(ltime);
				}
			},1000);
		});
		$("#live_content")[0].addEventListener("ended",function(){
			clearInterval(timer);
		});
	<?php } ?>
	
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
	
	
	
	
	
	
	
	
</script>
<!-- 统计代码开始 -->
<?php
if (!empty($systemsetting['analytics']) && !IS_DEBUG) {
	echo $systemsetting['analytics'];
} else {
	EBH::app()->lib('Analytics')->get('baidu');
}
?>
<!-- 统计代码结束 -->    
</body>
</html>