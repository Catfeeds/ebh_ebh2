<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>查看作业页面(准备单题批改)</title>
<link href="http://static.ebanhui.com/exam/css/base.css"<?=$v?> rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css"<?=$v?>>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css"<?=$v?>>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css"<?=$v?>>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/drtu.css"<?=$v?>>
<script type="text/javascript">
	var mao = '<?=$_GET["m"]?>';
</script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js"<?=$v?>></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/common.js"<?=$v?>></script>

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quebase.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/sinchoiceque.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/mulchoice.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/truefalseque.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textque.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textline.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/fillque.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/audio.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/subjective.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/tremark.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/exam.js"<?=$v?>></script>

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/render.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/wordque.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quefix.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/jquery.base64.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/achor.js"<?=$v?>></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=getv()?>"></script>
<script src="http://static.ebanhui.com/ebh/js/JSON.js"<?=$v?>></script>
<script src="http://static.ebanhui.com/exam/newjs/json2.js"<?=$v?>></script>
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
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var eid = <?php echo $eid;?>;
var crid = "<?=$crid?>";
var tremarkobj = new Tremark();
var examobj= new Exam();
$(function(){
	examobj.initExam()
	$(".que").hover(function(){
		$(this).addClass("light");
		},function(){
			$(this).removeClass("light");
		});

	$(".que").live("mouseover", function(){
		$(this).addClass("light");
	});
	$(".que").live("mouseout", function(){
		$(this).removeClass("light");
	});
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
	//objhtml +='<img src="/static/images/get_flash_player.gif" alt="Get Adobe Flash Player" />'
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
		objhtml += '<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/exam//flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" width="250" height="65">';
		objhtml +='<param name="wmode" value="transparent" />';
		objhtml +='<param name="movie" value="http://static.ebanhui.com/exam/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" />';
		objhtml +='</object>';
	}
	objhtml +='<!--end audio-->'
	return objhtml;	
}
</script>
<style>
	#viewcontent{
		margin: 0;
	}
	a.waskes{
	background: #5e96f5 none repeat scroll 0 0;
    border: medium none;
    border-radius: 4px;
    color: #ffffff;
    display: block;
    float: left;
    height: 25px;
    line-height: 25px;
    margin-right: 20px;
    text-align: center;
    text-decoration: none;
    width: 108px;
    font-weight: 500;
	}
	.answerBar,.userAnswerBar,.scoreBar,.linkBar,.textScoreBar,.textAnswerBar{
		padding: 0;
	}
	#container{
		padding: 0;
	}
	.layoutContainer{
		width: auto;
	}
	#center{
		padding: 0;
	}
</style>
</head>
<body>

<div class="sheet-con" id="container">
<div id="desk" class="layoutContainer" style=" position:relative;">
    <div id="center">
		<div id="webEditor" class="font12px fontSimsum">
            <div id="infoPane" style="padding:8px 5px 0px">
            	
        	</div>  
            <div id="viewcontent" class="viewcontent jqtransformdone">
            	
            </div>
            
        </div>
    </div>
    <div id="bottomBar">
    </div>
</div>
</div>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js"<?=$v?> type="text/javascript"></script>
 <div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
 </div>
  <iframe name="iframe_data" style="display:none;"></iframe>
 <form id="download_form" name="download_form" target="iframe_data" method="POST"></form>
<!--------播放器代码------------>
<script type="text/javascript" defer="defer">

var ver = 10;

function checkUpdate() {
	return true;
}

$(function(){
    $(".adderrorbook").live("mouseover", function(){
        $(this).addClass("adderrorbookb");
    });
    $(".adderrorbook").live("mouseout", function(){
        $(this).removeClass("adderrorbookb");
    });
});
</script>

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/play.js<?=getv()?>"></script>
<!--------播放器代码------------>
<script>
	$(function(){
		window.flash = HTools.pFlash({
			'id':"piceditor",
			'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf",
			'vars':{'showsubmit':0}
		});
		var button = new xButton();
		button.add({
            value: '提交批阅',
            callback: function () {
               H.remove('quespanel');
               HTools.getFlash(flash.getId()).swf.uploadAnswer();
               return false;
            },
            autofocus: true
		});
		button.add({
            value: '取消',
            callback: function () {
            	H.remove('quespanel');
              	H.get('piceditor').exec('close');
               	return false;
            }
		});
		H.create(new P({
			'id':"piceditor",
			'title':'在线批阅',
			'flash':flash,
			'easy':true,
			'button':button
		},{'onclose':function(){
			H.remove('quespanel');
		}}),'common');

		setTimeout(function(){
			tremarkobj.fixWpos();
		},1000);
	});
	

	function pplay(path){
		H.get('piceditor').exec('show');
		loadSource(path);
	}

	function loadSource(path){
		HTools.callFlash(flash.getId(),'loadSource',function(){
			this.loadSource(path);
		});
	}
	function uploadAnswerOver(){
		H.remove('quespanel');
		H.get('piceditor').exec('close');
	}
	function uploadAnswerBefore(){
		H.remove('quespanel');
	}
	
	function renderHtml(html){
		html = '<div style="width:600px;min-height:100px;overflow-y:auto;">'+html+'</div>';
		H.create(new P({
			title:'原题',
			id:'quespanel',
			width:600,
			showcancel:false,
			content:html
		}),'common').exec('show');
	}
</script>
</body>
</html>