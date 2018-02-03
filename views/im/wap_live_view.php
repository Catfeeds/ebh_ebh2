<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title><?=$course['title']?></title>
    <script src="http://static.ebanhui.com/chatroom/wap/mui/js/mui.min.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/iconfont.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/font/demo.css"/>
    <link href="http://static.ebanhui.com/chatroom/wap/mui/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="http://static.ebanhui.com/chatroom/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/wap/css/common.css?v=20161229001"/>
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/wap/css/courselive.css?v=20170317001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/wap/css/waptlive.css?v=20170321001"/>
    <script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/swfobject.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/chatroom/js/web_socket.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/chatroom/font/iconfont.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://www.ebh.net/im/js.html?cwid=<?=$course['cwid']?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/chatroom/layui/layui.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/chatroom/layui/lay/dest/layui.all.js"></script>
    <script>

    	var ws;
    	var auth = '<?=$auth?>';
    	var room_id = <?=$course['cwid']?>;
		var liveid = '<?=$course['liveid']?>';
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('websocket');	
			$liveInfoModel = $this->model('Liveinfo');
        	$liveInfo = $liveInfoModel->getLiveInfoByCwid($course['cwid']);
			$liveconfig = Ebh::app()->getConfig()->load('live');
			if(!$liveInfo){
				$hlsurl = $liveconfig['Sata']['hlsPurllUrl'];
			}else{
				$hlsurl = $liveInfo['hlspullurl'];
			}
		?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';
		var hlsplayurl = '<?=$hlsurl?>';
   </script>
	<script src="http://static.ebanhui.com/chatroom/wap/js/waplive_app.js?v=20180113001"></script>
	<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
</head>
<body>
	<div id="course_video">
		<!--内容-->
		<div class="mui-content">
			<!--视频区-->
			<?php
				$starttime = SYSTIME - $course['submitat'];
				if($starttime < 0){
					$starttime = 0;
				}
			?>
			
			<div class="video" <?php if($course['live_type'] != 4){ ?>
				style="display:none;"<?php } else { ?>
					<?php if($courseSource['filelength'] > 0 && $starttime < $courseSource['filelength']){ ?>
						style="display:block;"
					<?php } else { ?>
						style="display:none;"
					<?php } ?>	
				<?php } ?>>
			<?php if($course['live_type'] == 4){ ?>
					<input type="hidden" name="starttime" id="starttime" value="1" />
					<input type="hidden" name="olded" id="olded" value="1" />
					<div class="pseudo_box">
					<img class="playbtn" src="http://static.ebanhui.com/chatroom/wap/img/play.png" alt=""/>
					<img src="<?= $course['thumb'] ?>" alt="" style="width:100%;height:100%;"/>
					</div>
					<video id="_video" width="100%"  height="200px" src="<?=$course['m3u8url']?>" style="z-index:2000;display:none;" x5-playsinline="" playsinline="" webkit-playsinline="" playsinline=""></video>	
				
			<?php } else { ?>
				<input type="hidden" name="starttime" id="starttime" value="0" />
				<input type="hidden" name="olded" id="olded" value="0" />
				<video id="_video" width="100%"  height="200px" src="<?=$course['purl']?>" controls="controls" autoplay="autoplay" style="z-index:2000;" x5-playsinline="" playsinline="" webkit-playsinline="" playsinline=""></video>
			<?php } ?>
			</div>	
			
			<div class="loading" id="loading" <?php if($course['live_type'] == 4){ ?>
				<?php if($courseSource['filelength'] > 0 && $starttime < $courseSource['filelength']){ ?>
					style="display:none;"
				<?php } else { ?>
					style="display:block;"
				<?php } ?>	
				<?php } ?>>
				<?php if(!empty($course['submitat']) && ($course['submitat'] > SYSTIME)){ ?>
				<img src="http://static.ebanhui.com/chatroom/wap/img/wait.jpg" alt="" />
				<?php }else if(!empty($course['endat']) && ($course['endat'] < SYSTIME) ){ ?>
				<img src="http://static.ebanhui.com/chatroom/wap/img/end.jpg" alt="" />
				<?php }else{ ?>
				<img class="loadingImg" src="http://static.ebanhui.com/chatroom/wap/img/loading.jpg" alt="" />
				<?php } ?>
			</div>
			<!--视频列表-->
			
						
			
		</div>
	</div>
	<!--聊天区域-->
	<div id="tall_all">
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<ul class="layui-tab-title">
				<li class="layui-unselect layui-this tab_li iconfont" style="font-size: 25px;">&#xe6ae;</li>
				<li class="layui-unselect  tab_li iconfont online_tab" style="font-size: 25px;position:relative;">&#xe601;<span class="online_count">(0)</span><span class="red_radius"></span></li>
				<li class="layui-unselect  tab_li iconfont" style="font-size: 25px;">&#xe636;</li>
			</ul>
			<div class="videolist" style="font-size: 25px;"><a href="javascript:;" class="video_once teacher_video clicked" hlsurl="<?=$course['purl']?>"  cameraurl="<?=$course['cameraurl']?>" nowurl='hlsurl'></a></div>
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


<script type="text/javascript" charset="utf-8" src="http://static.ebanhui.com/chatroom/wap/js/courselive.js?v=20170317001"></script>
<script>
	//学习记录
		var timer = null;
    	var playUrl = "<?=$course['purl']?>";                //推流地址
    	var id = "<?=$course['cwid']?>";                                    //课件id
    	var lid = "0";                                       
    	var ltime = "0";                                     //持续播放时间
    	var ctime = "<?=$course['cwlength']?>";              //总时长
    	clearInterval(timer);
    	<?php if($course['live_type'] != 4){ ?>
    	$("#_video")[0].addEventListener("pause",function(){
			if(!$("#_video")[0].ended){
				$("#_video")[0].play();
			}
		});	
    	var flow = false;                                    //判断流
    	var dolive = function(){
    		$.ajax({
	    		type:"GET",
	    		url:playUrl,
	    		dataType:"jsonp",
	    		timeout: 3000,
	    		async:true,
	    	}).fail(function(d) {
				if(d.status == 200){
					flow = true;
				}else{
					flow = false;
				}
				setTimeout(dolive,3000);
			});
    	}
	var upDate= function(time){
		time = time + "";
		var obj = {
		 	id:id,
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
    dolive();
    timer = setInterval(function(){
		if(flow){
			ltime = Number(ltime) + 1;
			if(ltime%6 == 0){
				upDate(ltime);
			}
		}
	},1000);
	<?php } ?>	
	//伪直播
	<?php if($course['live_type'] == 4){ ?>
	var num = 1;
	$(".playbtn").on("click",function(){
			$(".pseudo_box").hide();
			$("#_video").show();
			$("#_video")[0].play();
			$("#_video")[0].pause();
			$("#_video")[0].play();
	});
	$("#_video")[0].addEventListener("play",function(){
		timer = setInterval(function(){
			ltime = Number(ltime) + 1;
			if(ltime == 1){
				$("#_video")[0].currentTime = <?=$starttime?>;
				$("#_video")[0].play();
			}
			if(ltime%6 == 0){
				upDates(ltime);
			}
		},1000);
	});
	$("#_video")[0].addEventListener("pause",function(){
		if(!$("#_video")[0].ended){
			$("#_video")[0].play();
		}
	});
	$("#_video")[0].addEventListener("ended",function(){
		clearInterval(timer);
		endFun();
	});
	//结束显示
	function endFun(){
		$(".loading").find("img").hide();
		$(".video").hide();
		$(".loading").show();
		$(".loadingImg").show();
	};
	//学习记录提交
	function upDates(time){
		time = time + "";
		var obj = {
		 	id:id,
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
	};
	<?php } ?>
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