<?php
if (! defined ( 'IN_EBH' )) {
	exit ( 'Access Denied' );
}
?>
<!DOCTYPE HTML>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport" />
<title>试题解析</title>
<?php $v=getv();?>
<link href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/drtu.css<?=$v?>">
<link type="text/css" href="http://static.ebanhui.com/exam/css/wavplayer.css<?=$v?>" rel="stylesheet" />

<script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quebase.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/wordque.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/sinchoiceque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/mulchoice.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/truefalseque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/textque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/textline.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/fillque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/audio.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/subjective.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/render.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/view2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quefix.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/swfobject.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/wavplayer.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<link rel="stylesheet" href="http://static.ebanhui.com/js/mi/css/mui.min.css">
<script src="http://static.ebanhui.com/js/mi/js/mui.min.js"></script>
<script type="text/javascript" charset="utf-8">
//mui初始化
mui.init({
	swipeBack: true //启用右滑关闭功能
});

			
		</script>

<style>
	.ui-dialog .ui-dialog-content{
		padding: 0;
	}
	.ui-dialog-title{
		padding:10px;
	}
	.adderrorbookf{
		background:url(/static/images/adderrorbookf.jpg) no-repeat;
		width:104px;
		height:25px;
		float:right;
		cursor:pointer;
		margin-bottom:5px
	}
</style>
<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
global $_SGLOBAL;
?>
var isMobile = <?php echo $isMobile; ?>;
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var apptype = '<?php echo !empty($_SERVER["HTTP_APPCLIENT"])?$_SERVER["HTTP_APPCLIENT"]:''; ?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var uid=<?=$uid?>;
emark = true;
hashWatcher = function() {
    var timer, last;
    return {
        register: function(fn, thisObj) {
            if(typeof fn !== 'function') return;
            timer = window.setInterval(function() {
                if(location.hash !== last) {
                    last = location.hash;
                    fn.call(thisObj || window, last);
                }
            }, 100);
        },
        stop: function() {
            timer && window.clearInterval(timer);
        },
        set: function(newHash) {
            last = newHash;
            location.hash = newHash;
        }
    };
}();

function getPosition(e){
	if(e){
		var t=e.offsetTop;  
		var l=e.offsetLeft;  
		while(e=e.offsetParent){  
			t+=e.offsetTop;  
			l+=e.offsetLeft;  
			if(e.offsetParent == undefined || e.offsetParent.className == undefined || e.offsetParent.className=='container'  ){
				break;
			}
		}
		return {x:l, y:t}; 
	}
	return null;
}

var answerobj = new View();
$(function(){
	answerobj.initque(<?=$eid?>,<?=$qid?>);

	$(".adderrorbook").live("mouseover", function(){
		$(this).addClass("adderrorbookb");
	});
	$(".adderrorbook").live("mouseout", function(){
		$(this).removeClass("adderrorbookb");
	});
	$(".operateBar").attr("style","position:absolute;right:200px;");;
});

var parseflash = function(url,param){
	var	objhtml ='<!--begin flash-->'
	objhtml +='<!--url:'+url+'-->'
	objhtml +='<!--width:'+param.width+'-->'
	objhtml +='<!--height:'+param.height+'-->'
	objhtml +='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+param.width+'px" height="'+param.height+'px" id="Main">'
	objhtml +='<param name="wmode" value="transparent" />';
	objhtml +='<param name="movie" value="'+url+'" />'
	objhtml +='<param name="quality" value="high" />'
	objhtml +='<param name="bgcolor" value="#869ca7" />'
	objhtml +='<param name="allowScriptAccess" value="sameDomain" />'
	objhtml +='<param name="allowFullScreen" value="true" />'
	objhtml +='<!--[if !IE]>-->'
	objhtml +='<object type="application/x-shockwave-flash" data="'+url+'" width="'+param.width+'px" height="'+param.height+'px">'
	objhtml +='<param name="quality" value="high" />'
	objhtml +='<param name="bgcolor" value="#869ca7" />'
	objhtml +='<param name="allowScriptAccess" value="sameDomain" />'
	objhtml +='<param name="allowFullScreen" value="true" />'
	objhtml +='<!--<![endif]-->'
	objhtml +='<!--[if gte IE 6]>-->'
	objhtml +='<p>' 
	objhtml +='Either scripts and active content are not permitted to run or Adobe Flash Player version'
	objhtml +='10.0.0 or greater is not installed.'
	objhtml +='</p>'
	objhtml +='<!--<![endif]-->'
	objhtml +='<a href="http://www.adobe.com/go/getflashplayer">'
	//objhtml +='<img src="http://static.ebanhui.com/exam/images/get_flash_player.gif" alt="Get Adobe Flash Player" />'
	objhtml +='</a>'
	objhtml +='<!--[if !IE]>-->'
	objhtml +='</object>'
	objhtml +='<!--<![endif]-->'
	objhtml +='</object><!--end flash-->'

	return objhtml;	
}
var parseaudio = function(url){
	var	objhtml ='<!--begin audio-->'
	objhtml +='<!--url:'+url+'-->'
	if(window.isMobile){
		var style = (browser=='iPad' || browser=='iPhone'|| browser=='iPod')?'style="height:40px"':'';
		objhtml +='<audio src="'+url+'" controls="controls" preload="preload" '+style+'>您的浏览器不支持,请您尝试升级到最新版本。</audio>';
	}else{
		objhtml += '<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/exam/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" width="250" height="65">';
		objhtml +='<param name="wmode" value="transparent" />';
		objhtml +='<param name="movie" value="http://static.ebanhui.com/exam/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" />';
		objhtml +='</object>';
	}
	objhtml +='<!--end audio-->'
	return objhtml;	
}

//主观题答题---改变图片显示的大小
function changesize(img){
	var MaxWidth=180;//设置图片宽度界限
	var MaxHeight=100;//设置图片高度界限
	if(img.offsetHeight>MaxHeight && img.offsetWidth>MaxWidth){
		$(img).css({"width":"180px","height":"100px"});
		$(img).parent().css({"width":"180px","height":"100px"});
	}else if(img.offsetHeight>MaxHeight && img.offsetWidth<MaxWidth){
		$(img).css({"height":((img.offsetWidth/9)*5)+"px","width":img.offsetWidth+"px"});
		$(img).parent().css({"width":img.offsetWidth+"px","height":((img.offsetWidth/9)*5)+"px"});
	}else if(img.offsetHeight<MaxHeight && img.offsetWidth>MaxWidth){
		$(img).css({"width":((img.offsetHeight/5)*9)+"px","height":img.offsetHeight+"px"});
		$(img).parent().css({"width":((img.offsetHeight/5)*9)+"px","height":img.offsetHeight+"px"});
	}else{
		$(img).parent().css({"width":img.offsetWidth+"px","height":img.offsetHeight+"px"});
	}
}
</script>
<style type="text/css">


#recurPane { background:#fff; border-top:1px solid #ccc; border-bottom:1px solid #ccc; color:#333; letter-spacing:1px; cursor:default}
#markPane { background-color:#DCF0E3;}

.answerBar, .userAnswerBar, .scoreBar, .linkBar, .textPointBar, .textAnswerBar { padding:2px 0 0 30px; vertical-align:baseline}
.refJudgeA { background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -34px}
.refJudgeB { background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -18px}
.markFalse { padding-left:15px; background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -50px;}
.markTrue { padding-left:15px; background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -82px}
.answerBar, .answerLabel, .scoreLabel { color:#999}
#recurPane .textAnswer { border:1px solid #fff}
#recurPane .textAnswerBar .textAnswer { color:#0020a0}
#recurPane .blankAnswer{ color:#0020c0}
.blankIndex { color:#333}
.sumscore { color:blue; font-weight:bold}

#markLabel { text-align:center; font-weight:bold; font-size:15px; margin:2px}
.totalScore{ color:red; font-weight:bold; font-size:16px}
#markPaneTop { padding:5px 0 5px 5px}
#markPaneTop table { padding:2px 0 2px 2px}
#markPaneTop table tr { height:14px; line-height:14px}
#markPaneClient { border-top:1px solid #ccc; border-bottom:1px solid #ccc; padding:5px 0 5px 5px}
#markPaneClient ul{ overflow:auto; zoom:1; padding-bottom:12px;}
#markPaneClient li{ float:left; width:39px; white-space:nowrap; overflow:hidden;}
#markPaneClient a { color:black; text-decoration:none}
.markError { color:red}
.markCorrect{color:#0acb0a;font-size: 12px;font-weight: bold;}
.scoreError {color:red; font-size:11px}
.scoreCorrect { color:#0acb0a; font-size:11px}
.scoreCorrect { color:#0acb0a; font-size:11px}
.partBar { margin:0 0 3px}
.markerInfo { color:#666}
.markerInfo p { line-height:18px}
.markerInfo textarea { border:1px solid #9c9; margin:0 0 2px 0; height:65px; width:178px; font-size:12px; overflow:auto; color:#000; background:#f1f8f1}

.adderrorbook{background:url(http://static.ebanhui.com/exam/images/adderrorbooka.png) no-repeat;width:104px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.adderrorbooka{background:url(http://static.ebanhui.com/exam/images/adderrorbooka.jpg) no-repeat;width:104px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
.adderrorbookb{background:url(http://static.ebanhui.com/exam/images/adderrorbookb.png) no-repeat;width:104px;height:25px;float:right;cursor:pointer;margin-bottom:5px}
#recurPane img{
	max-width:658px;
}
.que {
	font-size: 14px;
	line-height: 18px;
	padding: 5px 0 30px 0;
	width:100%;
}
img{
	width: auto;
	-ms-interpolation-mode: bicubic;
}
object{
#	max-width: 320px;
}
.topdt {
  height: 45px;
  line-height: 45px;
  background: #00b6ef;
  text-align: center;
  color: #fff;
  font-size: 18px;
  text-shadow: 0 1px 0 rgba(0, 0, 0, 0.35);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px #41c9f3 inset;
  position: fixed;
  width: 100%;
  z-index: 99;
 }

.topdt a.leftetu {
  float: left;
  margin-top: 4px;
  margin-left: 20px;
}
.topdt .right {
  float: right;
  margin-top: 4px;
  margin-right: 20px;
}
#blank{
	width: 100%;
	height: 45px;
	overflow: hidden;
}
</style>
</head>
<body>
<div id="desk" class="layoutContainer" style="width:100%; position:relative;">
    <div id="center" style="padding:0;">
		<div id="webEditor" class="font12px fontSimsum">
            <div id="viewcontent" class="viewcontent jqtransformdone">
            	
            </div>
            <!-- <div id="editControlPane" class="controlBar">
               <input type="button" name="" class="btnClose" onclick="window.close();" value="" />
            </div> -->
        </div>
    </div>
    <div id="bottomBar">
    </div>
</div>
<iframe name="iframe_data" style="display:none;"></iframe>
<form id="download_form" name="download_form" target="iframe_data" method="POST"></form>
<!--------播放器代码------------>
<script type="text/javascript" defer="defer">

function goback(){
	history.back(-2);
}
$(document).on('click','img',function(){
	var src = $(this).attr('src');
	src = src.replace(/_.*\./,'.');
	window.open(src);
})
</script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/play.js<?=$v?>"></script>
<!--------播放器代码------------>
</body>
</html>
