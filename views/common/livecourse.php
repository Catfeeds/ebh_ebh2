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
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/chatroom.css?v=2017022101"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/live.css?v=20171220001"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/layim/layim.css"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/chatroom/css/ebhdialog.css?v=20170815001"/>
	<style>
	html{height: 100%;overflow: hidden;}
		.live-box{width: 100%;height:100%;box-sizing:border-box;position: relative;}
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
	  	if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
	    WEB_SOCKET_SWF_LOCATION = "/static/flash/WebSocketMain.swf";
	    WEB_SOCKET_DEBUG = true;
	    var ws;
		var auth = '';
		var room_id = <?=$course['cwid']?>;
		var liveid = '<?=$course['liveid']?>';
		<?php 
			$websocket_config = Ebh::app()->getConfig()->load('websocket');	
		?>
		var WebSocketAddr = '<?=$websocket_config[0]?>';

        var user={
            username:'',
            name:'',
            uid:0
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
	<script src="http://static.ebanhui.com/chatroom/js/live.js?v=20180111002"></script>
	<script src="http://static.ebanhui.com/chatroom/js/json2/json2.js?v=2016122101"></script>
	<script src="http://static.ebanhui.com/chatroom/js/ebhdialog.js?v=20171128002"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/playlive.js?v=20171219002"></script>
</head>
<body>
<!--直播未开始-->
<?php if (empty($isliverun) && (empty($course['endat']) || SYSTIME <= $course['endat'])) { ?>
    <div style="width:980px;height:560px;background:white;text-align:center;margin:50px auto;color:#f00">
        <span style="font-size:50px;width:970px;float:left;margin-top:110px">课程将于 <?=Date('Y-m-d H:i',$course['submitat'])?> 开始</span>
        <span style="font-size:50px;width:970px;float:left;margin-top:50px">倒计时：<span id="countdown" data="<?=($course['submitat'] - SYSTIME)?>"><?=secondToStr($course['submitat']-SYSTIME)?></span></span>
        <span style="font-size:50px;width:970px;float:left;margin-top:50px">请耐心等候...</span>
    </div>
<?php } ?>
<!--直播结束-->
<?php if (SYSTIME > $course['endat']) { ?>
    <!--支持回放-->
    <?php if($liveinfo['review'] == 1) { ?>
        <?php if ($course['ism3u8'] == 1){ ?>
            <div style="width:980px;height:560px;background:white;text-align:center;margin:50px auto;">
                <span style="font-size:20px;font-weight:bold;width:970px;float:left;margin-top:200px;color:#000;">直播结束</span>
                <span style="font-size:50px;width:970px;float:left;margin-top:10px">
								<a id="notebtn" class="lanbtn liaskt" name="notes" href="/course/<?= $course['cwid'] ?>.html?review=1" style="font-family: 微软雅黑;font-weight:normal;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#18a8f7;padding:10px 50px;border-radius:5px;color:#fff;text-decoration:none;">进入回看</a>
							</span>
            </div>
        <?php }else{ ?>
            <div style="width:980px;height:560px;background:white;text-align:center;margin:50px auto;">
                <span style="font-size:20px;font-weight:bold;width:970px;float:left;margin-top:200px;color:#000;">直播已结束，视频正在转码中，请稍后...</span>
                <span style="font-size:50px;width:970px;float:left;margin-top:10px">
								<a id="notebtn" class="lanbtn liaskt" name="notes" href="javascript:;" style="font-family: 微软雅黑;font-weight:normal;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:25px;width:300px;background:#999;padding:10px 50px;border-radius:5px;color:#fff;text-decoration:none;">进入回看</a>
							</span>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div style="width:980px;height:560px;background:white;text-align:center;margin:50px auto;">
            <span style="font-size:50px;width:970px;float:left;margin-top:200px;color:#f00;">已于 <?=Date('Y-m-d H:i',$course['endat'])?> 结束</span>
        </div>
    <?php } ?>
<?php } ?>
<!--直播开始，资料准备中-->
<?php if (!empty($isliverun) && empty($flag)) { ?>
<div style="width:980px;height:558px;background:white;text-align:center;margin:50px auto;">
    <span style="font-size:36px;width:970px;float:left;margin-top:200px;color:#f00">上课进行中...</span>
    <span style="font-size:50px;width:970px;float:left;margin-top:10px"><a id="notebtn" class="lanbtn liaskt" name="notes" href="/course/<?=$course['cwid']?>.html?flag=1" style="font-family: 微软雅黑;font-weight:normal;height:65px;line-height:65px; margin-top:15px;margin-bottom:10px;font-size:36px;width:300px;background:#18a8f7;padding:10px 50px;border-radius:5px;color:#fff;text-decoration:none;">进入学习</a></span>
</div>
<?php } ?>
<?php if (!empty($flag) && !empty($isliverun)) { ?>
<div class="default_diagram" style="width:100%;height:100%;"></div>	
<div class="live-box">
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
		dolivedetect();
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
			layui.chatroom.newMsgTips({type:'tips',content:'未检测到您的摄像头/麦克风'});
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
	//学习记录
	var timer = null;
	var flow = false;
	var hlsdocplay = course.hlsdocplay;
	var ctime = course.duration + "";
	var cwid = room_id + "";
	var ltime = "0";
	var lid = "0";
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