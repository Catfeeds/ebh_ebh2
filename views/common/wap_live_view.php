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
    <?php if (!empty($flag) && !empty($isliverun)) { ?>
    <script>

    	var ws;
    	var auth = '';
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
    <?php } ?>
	<script src="http://static.ebanhui.com/chatroom/wap/js/waplive_app.js?v=20180113001"></script>
	<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
</head>
<body>
<!--直播未开始-->
<?php if (empty($isliverun) && (empty($course['endat']) || SYSTIME <= $course['endat'])) { ?>
    <div style="height:560px;background:white;text-align:center;margin:50px auto;color:#f00">
        <div style="font-size:2em;margin-top:50px">课程将于 <?=Date('Y-m-d H:i',$course['submitat'])?> 开始</div>
        <div style="font-size:2em;margin-top:30px">倒计时：<span id="countdown" data="<?=($course['submitat'] - SYSTIME)?>"><?=secondToStr($course['submitat']-SYSTIME)?></span></div>
        <div style="font-size:2em;margin-top:30px">请耐心等候...</div>
    </div>
<?php } ?>
<!--直播结束-->
<?php if (SYSTIME > $course['endat']) { ?>
    <!--支持回放-->
    <?php if($liveinfo['review'] == 1) { ?>
        <?php if ($course['ism3u8'] == 1){ ?>
            <div style="height:560px;background:white;text-align:center;margin:50px auto;">
                <div style="font-size:20px;font-weight:bold;margin-top:100px;color:#000;">直播结束</div>
                <div style="font-size:50px;margin-top:10px">
								<a id="notebtn" class="lanbtn liaskt" name="notes" href="/course/<?= $course['cwid'] ?>.html?review=1" style="font-family: 微软雅黑;font-weight:normal;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#18a8f7;padding:10px 50px;border-radius:5px;color:#fff;text-decoration:none;">进入回看</a>
							</div>
            </div>
        <?php }else{ ?>
            <div style="height:560px;background:white;text-align:center;margin:50px auto;">
                <div style="font-size:20px;font-weight:bold;margin-top:100px;color:#000;">直播已结束，视频正在转码中，请稍后...</div>
                <div style="font-size:50px;margin-top:10px">
								<a id="notebtn" class="lanbtn liaskt" name="notes" href="javascript:;" style="font-family: 微软雅黑;font-weight:normal;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#999;padding:10px 50px;border-radius:5px;color:#fff;text-decoration:none;">进入回看</a>
							</div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div style="height:560px;background:white;text-align:center;margin:50px auto;">
            <div style="font-size:2em;margin-top:100px;color:#f00;">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</div>
        </div>
    <?php } ?>
<?php } ?>
<!--直播开始，资料准备中-->
<?php if (!empty($isliverun) && empty($flag)) { ?>
    <div style="height:558px;background:white;text-align:center;margin:50px auto;">
        <div style="font-size:2em;color:#f00">上课进行中...</div>
        <div style="font-size:3em;margin-top:1em"><a id="notebtn" class="lanbtn liaskt" name="notes" href="/course/<?=$course['cwid']?>.html?flag=1" style="font-family: 微软雅黑;font-weight:normal;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;background:#18a8f7;padding:10px 50px;border-radius:5px;color:#fff;text-decoration:none;">进入学习</a></div>
    </div>
<?php } ?>
<?php if (!empty($flag) && !empty($isliverun)) { ?>
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
<?php } ?>
<!--倒计时脚本-->
<?php if (empty($isliverun) && (empty($course['endat']) || SYSTIME <= $course['endat'])) { ?>
    <script type="text/javascript">
        function PrefixInteger(num, n) {
            return (Array(n).join(0) + num).slice(-n);
        }
        (function($) {//1天4小时8分44秒
            var clock = $('#countdown');
            var c = clock.attr('data');
            var countDownTimer = setInterval(function() {
                c--;
                var data = parseInt(c / 86400);
                var h = parseInt((c % 86400) / 3600);
                var m = parseInt((c % 3600) / 60);
                var strs = [];
                if (data > 0) {
                    strs.push(data + '天');
                }
                if (h > 0) {
                    strs.push(h + '小时');
                }
                if (m > 0) {
                    strs.push(PrefixInteger(m, 2) + '分');
                }
                strs.push(PrefixInteger(parseInt(c % 60), 2) + '秒');
                var clockStr = strs.join('');
                clock.html(clockStr);
                if (c <= 0) {
                    clearInterval(countDownTimer);
                    location.reload();
                }
            }, 1000);
        })(jQuery);
    </script>
<?php } ?>
<?php
if (!empty($system_setting['analytics']) && !IS_DEBUG) {
    echo $system_setting['analytics'];
} else {
    EBH::app()->lib('Analytics')->get('baidu');
}
?>
</body>
</html>