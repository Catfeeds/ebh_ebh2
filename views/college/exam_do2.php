<!DOCTYPE HTML>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线作业</title>
<!--<link href="http://static.ebanhui.com/examv2/css/base.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/examv2/css/public.bak.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/examv2/css/done.css<?=getv()?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/examv2/css/jqtransform.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/examv2/css/drtu.css<?=getv()?>" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>">-->
	
<link href="http://static.ebanhui.com/exam/css/base.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/exam/css/public.bak.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/drtu.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/pageztree.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/js/xztree/css/zTreeStyle/zTreeStyle.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/js/jquery/showmessage/css/default/showmessage.css" />  
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/tikutop.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/zujuan.css"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/done.css"/>

<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/common.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quebase.js<?=getv()?>"></script>

<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/quefix.js<?=getv()?>"></script>

<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/sinchoiceque.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/mulchoice.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/truefalseque.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/textque.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/textline.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/fillque.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/audio.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/subjective.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/answer.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/formulav2.js<?=getv()?>"></script>
<!--<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/exam.js<?=getv()?>"></script>-->
<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/imgeditorv3.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/render.js<?=getv()?>"></script>
<?=ckeditor()?>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/jquery.base64.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/wordque.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=getv()?>"></script>
<script src="http://static.ebanhui.com/ebh/js/JSON.js"></script>
<script type="text/javascript">
<?php

function ckeditor(){
	console.log(1);
	$str = '';
	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 7.0") || strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 6.0")){
		$str .= '<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/ckeditorfix/ckeditor.js"></script>';
		$str .= '<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/ckeditorfix/adapters/jquery.js"></script>';
	}else{
		$str .= '<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/ckeditor/ckeditor.js"></script>';
		$str .= '<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/ckeditor/adapters/jquery.js"></script>';
	}
	return $str;
}

function checkbrowser(){
	global $_SGLOBAL;
	$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
//	if( stripos($agent,'Chrome') !== false ) {//测试使用
//		return true;
//	}
	/**
	 * Determine if the user is using a BlackBerry (last updated 1.7)
	 * @return boolean True if the browser is the BlackBerry browser otherwise false
	 */
	if( stripos($agent,'blackberry') !== false ) {
		$_SGLOBAL['browser']='blackberry';
		return true;
	}
	/**
	 * Determine if the browser is Pocket IE or not (last updated 1.7)
	 * @return boolean True if the browser is Internet Explorer otherwise false
	 */
	if( stripos($agent,'mspie') !== false || stripos($agent,'pocket') !== false ) {
		$_SGLOBAL['browser']='mspie';
		return true;
	}
	/**
	 * Determine if the browser is Opera or not (last updated 1.7)
	 * @return boolean True if the browser is Opera otherwise false
	 */
	if( stripos($agent,'opera mini') !== false ) {
		$_SGLOBAL['browser']='opera mini';
		return true;
	}
	/**
	 * Determine if the browser is Nokia or not (last updated 1.7)
	 * @return boolean True if the browser is Nokia otherwise false
	 */
	if( preg_match("/Nokia([^\/]+)\/([^ SP]+)/i",$agent,$matches) ) {
		$_SGLOBAL['browser']='Nokia';
		return true;
	}
	/**
	 * Determine if the browser is iPhone or not (last updated 1.7)
	 * @return boolean True if the browser is iPhone otherwise false
	 */
	if( stripos($agent,'iPhone') !== false ) {
		$_SGLOBAL['browser']='iPhone';
		return true;
	}
	/**
	 * Determine if the browser is iPod or not (last updated 1.7)
	 * @return boolean True if the browser is iPod otherwise false
	 */
	if( stripos($agent,'iPad') !== false ) {
		$_SGLOBAL['browser']='iPad';
		return true;
	}
	/**
	 * Determine if the browser is iPod or not (last updated 1.7)
	 * @return boolean True if the browser is iPod otherwise false
	 */
	if( stripos($agent,'iPod') !== false ) {
		$_SGLOBAL['browser']='iPod';
		return true;
	}
	/**
	 * Determine if the browser is Android or not (last updated 1.7)
	 * @return boolean True if the browser is Android otherwise false
	 */
	if( stripos($agent,'Android') !== false ) {
		$_SGLOBAL['browser']='Android';
		return true;
	}
	return false;
}

if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
$showtaobao = FALSE;
$sflag = $_COOKIE['flag'];
if(empty($sflag)) {
	$showtaobao = TRUE;
}
$showtaobao = FALSE;
?>
var isMobile = <?php echo $isMobile; ?>;
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var returnurl = "<?=$_GET['returnurl']?>";
var answerobj = new Answer();
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
$(function(){
	hashWatcher.register(function(hash) {
		if(hash){
			hash = hash.replace('#','');
			var stIndex = $('.stIndex:contains('+hash+'.)')[0];
			var p = getPosition(stIndex);
			$(".que").css("border",'');
			// $(".que[qsval='"+hash+"']").css('border','1px solid red');
			$('.stIndex:contains('+hash+'.)').parent().parent().css('border','1px solid red');
			if(p!=null){
				$('body,html').stop().animate({ 'scrollTop': p.y },1000);
			}
		}
	});
	answerobj.eid = <?=$eid?> ;
	answerobj.init({eid:<?=$eid?>});
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
	$(".que .answersubbtn").live("mouseover", function(){
		$(this).addClass("curbg");
	});
	$(".que .answersubbtn").live("mouseout", function(){
		$(this).removeClass("curbg");
	});
	H.create(new P({
		id:'warmtip',
		padding:0,
		title:'温馨提醒',
		width:335,
		height:180,
		content:$('#timeoverdialog')[0],
		modal:true,
		cancel: false,
		cancelDisplay:false
	}),'common');

	$(".gbi").click(function(){
		$(".yichuad").hide("slow");
		setcookie("flag",1,7);
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
	//objhtml +='<img src="http://static.ebanhui.com/examv2/images/get_flash_player.gif" alt="Get Adobe Flash Player" />'
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
		objhtml += '<object type="application/x-shockwave-flash" data="http://static.ebanhui.com/examv2/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" width="250" height="65">';
		objhtml +='<param name="wmode" value="transparent" />';
		objhtml +='<param name="movie" value="http://static.ebanhui.com/examv2/flash/dewplayer-bubble.swf?mp3='+encodeURIComponent(url)+'" />';
		objhtml +='</object>';
	}
	objhtml +='<!--end audio-->'
	return objhtml;	
}


//主观题答题---改变图片显示的大小
function changesize(img){
	var MaxWidth=720;//设置图片宽度界限
	var MaxHeight=400;//设置图片高度界限
	if(img.offsetHeight>MaxHeight && img.offsetWidth>MaxWidth){
		$(img).css({"width":"720px","height":"400px"});
		$(img).parent().css({"width":"720px","height":"400px"});
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
function getcookie(name){   
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));    
    if(arr != null){   
        return unescape(arr[2]);   
    }else{   
        return "";   
    }   
}
function setcookie(name,value,days){   
    var exp  = new Date();   
    exp.setTime(exp.getTime() + days*24*60*60*1000);   
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();   
}
function delcookie(name){   
    var exp = new Date();    
    exp.setTime(exp.getTime() - 1);   
    var cval=getCookie(name);   
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();   
}   
</script>
<style type="text/css">
body { background-color:#E5F5F6;}
.quickMenu li { background:url(http://static.ebanhui.com/examv2/images/operate.png) no-repeat right -88px; float:left; margin-left:-1px; width:78px; text-align:center; color:#768898; font-size:12px; font-family:"宋体";}
.quickMenu li.last { background:none}
.quickMenu li a { color:#768898; text-decoration:none}
.aClick { width:67px; height:19px; padding-top:3px; background-position:0 -59px; font-size:12px; font-family:Tahoma; color:#FFF; text-decoration:none}
.light{ border:solid 1px #6EB3EA;}
.yichuad {background: url("http://static.ebanhui.com/examv2/images/edo_ad.jpg") no-repeat;
    color: #555555;
    height: 148px;
    position: fixed;
	_position:absolute;
    left: 50%;
	margin-left:500px;
    top:250px;
    width: 115px;
    z-index: 9;
}
.yichuad a.gbi {
	width:16px;
	height:16px;
	display:block;
	right:0px;
	top:0px;
	position: absolute;
}
.yichuad a.xiangoubtn {
	width:80px;
	height:27px;
	display:block;
	right:5px;
	bottom:5px;
	position: absolute;
}
.retbtn{
	text-decoration: none;
}
#center{
	padding-bottom: 60px;
}
.rykhje{
	width: 100%;
}
.ryjwrt{
	margin-left: 42px;
}
.rtykwr{
	margin-left: 319px;
}
a{
	text-decoration: none;
}
.countstr {
    padding: 0px 10px 0 5px;
    background-color: #fff;
    color:#f00;
    font-size: 14px;
    height: 16px;
    line-height: 16px;
    text-align: center;
    position:relative;
    top:7px;
}
.paperName {
    padding: 35px 0 20px 0;
	font-size:24px;
	font-family:微软雅黑;
}
.tanstys{
	height:auto;
}
.retbtn{
	margin: 20px 0 32px 300px;
}
</style>
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/examv2/ljs/dd_belatedpng.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.quickMenu li');   
</script>  
<![endif]-->
</head>
<body>
<!--<div style="width:auto; min-width:960px; height:150px; overflow:hidden;">
	<div style="width:960px; margin:0 auto; position:relative">
    </div>
</div>-->
 <div id="header">
	<div class="adAuto">
		<div class="magAuto top">
			<p>您好，<?=$username?></p>
		</div>
	</div>
	<div class="Ad">
		<div class="magAuto">
			<img src="http://static.ebanhui.com/exam/images/banner/stu_head_pic.jpg" />
		</div>
	</div>
</div>
<div  id="container" class="sheet-con">
<div id="desk" class="center magAuto layoutContainer" style=" position:relative;">
    <div id="center">
		<div id="webEditor" class="font12px fontSimsum">
            <div id="infoPane" style="padding:8px 5px 0px">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="paperName" ><label id="examtitle"></label><span style="color:#999">[共<em style="color:#f37f00">60</em>题]</span></td>
                  </tr>
                  <tr>
                    <td class="listere" >试题共<span id="qcountlab">0</span>题，满分<span id="stotalscore">0</span>分   时间：<span id="showlimitedtime">不限时</span></td>
                  </tr> 
                  <tr>
                    <td class="listere">出题时间：<span class="createTime"><label id="datelab"></label></span>作业编号：<span class="paperId">10010</span></td>
                  </tr>
                </table>
  
				<?php if($showtaobao) { ?>
				<div class="yichuad">
				<div style="position: relative;height:148px;width: 115px;">
					<a href="javascript:void(0)" class="gbi"></a>
					<a target="_blank" href="http://shop109884666.taobao.com/" class="xiangoubtn"></a>
				</div>
				</div>
				<? } ?>
        	</div>  
            <div id="viewcontent" class="viewcontent jqtransformdone">
            	  <div id="loadimg" style="width:100px;height:100px;margin:0 auto;"><img style="margin:0 auto;" title="加载中..." src="http://static.ebanhui.com/examv2/images/loading.gif"/></div>
            </div>
           
        </div>
    </div>
    <div id="bottomBar">
    </div>
</div>
</div>
<div id="timeoverdialog" style="display:none">
	<div style="float: left;margin-top: 20px;height:60px"><img src="http://static.ebanhui.com/examv2/images/naozhong.gif"></div>
	<div style="float: left;margin-top: 20px;font-size: 14px;line-height: 25px;margin-left: 20px;height:60px;width:240px;"><p>亲爱的同学，考试时间到了！试卷已经自动提交，请点击“确认”查看试卷</p></div>
	<div style="float:left;width: 135px;height: 29px;margin-left: 90px;_margin-left: 45px;cursor: pointer;"><a href="javascript:answerobj.showlevel();"><div style="width:80px;height:29px;line-height:29px;background:url('http://static.ebanhui.com/examv2/images/TestImageNoText_135x29.png');display:block;font-size:14px;padding-left: 55px;text-decoration: none;">确认</div></a></div>

</div>
<div id="showfenxiwrap" style="display:none;height:auto;width:100%;"></div>
<div id="showshitiliebiaowrap" style="display:none;padding-left: 15px;padding-right: 15px;"></div>
<div class="rykhje">
	<div class="rtykwr">
    	<span class="rykbact"><span id="limitedhour">0</span>:<span id="limitedminute">0</span>:<span id="limitedsecond">0</span></span>
		<span class="ryercdrt">
			<?php if(empty($_GET['f'])){?>
			<a href="javascript:void(0)" onclick="answerobj.uploadData(0);" class="cuncaog">保存</a>
			<a href="javascript:void(0)" onclick="answerobj.uploadData(1,true);"class="taishant">提交</a>
			 <?php }?>
		</span>
        <a href="javascript:void(0)" onclick="$('html, body').animate({scrollTop:0}, 'slow');" class="jetytu">返回顶部</a>
        <a id="showshitiliebiao" href="javascript:void(0);" class="ryjsr">试题列表</a>
    </div>
</div>
<!--------播放器代码------------>
<script type="text/javascript" defer="defer">

function checkUpdate() {return true;}
setInterval(function(){
	$(".schcwid[value!='']").each(function(){
		var obj = this;
		var schcwid = $(this).val();
		// $.ajax({
			// type: "post",
			// url: "/site/lexam.php?op=getsanswer&math="+Math.random(),
			// data: "eid=<?php echo $_SGET['eid'];?>&schcwid="+schcwid,
			// success: function(msg){
				// if($(".upsanswer").attr("img")==msg){
					// return;
				// }
				// if (msg!="") {
					// var arr = msg.split(',');
					// var str = '';
					// for (var i = 0; i < arr.length; i++) {
						// str += '<span style="margin-left:40px;display:block;position:relative;width:720px;height:400px;"><img class="newku" src="'+arr[i]+'" name="'+schcwid+'" onload="changesize(this)" />';
						// str += '<img onclick="_self.delanswer({obj:this})" title="删除此上传的答案" src="http://static.ebanhui.com/examv2/images/delanswer.png" style="position:absolute;right:10px;top:10px;cursor:pointer;" /></span>';
					// };
					// if ($(obj).parent().find(".upsanswer").size()>0) {
						// $(obj).parent().find(".upsanswer").remove();
					// };
					// $("#course"+$(obj).parent().attr("qsval")).before('<div class="upsanswer" img="'+msg+'" style="z-index:9;">'+str+'</div>');
				// };
			// }
		// });
	});
	
},10000);

</script>

<script type="text/javascript" src="http://static.ebanhui.com/examv2/js/play.js<?=getv()?>"></script>
<!--------播放器代码------------>

<script>
	$(function(){
		var a = '{"mime":{"quesurl":null,"quesurltype":"text","type":"XWX","audiourl":""},"data":{"0":{"detail":{"0":{"u":{"r":["0"],"idx":0}},"1":{"u":{"r":["3"],"idx":1}}}}},"type":"XWX","questionid":0}';
		console.log(eval('('+a+')'));
		window.flash = HTools.pFlash({
			'id':"piceditor",
			'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf"
		});
		var button = new xButton();
		button.add({
            value: '提交答案',
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
			'title':'在线答题',
			'flash':flash,
			'easy':true,
			'button':button
		},{'onclose':function(){
			H.remove('quespanel');
		}}),'common');
		setTimeout(function(){
			answerobj.fixWpos();
		},1000);
		$("#showshitiliebiao").bind('click',function(){
			H.create(new P({
			title:'试题列表',
			id:'showshitiliebiaowrap',
			content:$("#showshitiliebiaowrap")[0],
			easy:true,
			padding:'5px'
		})).exec('show');});
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
	$("#viewcontent").on('click','li.radioBox',function(){
		$(this).siblings('li').find('.optionContent').css({'color':'#000'});
		$(this).find('.optionContent').css({'color':'#f00'});
		$(this).find('.jqTransformRadio').triggerHandler('click');
	});
	$("#viewcontent").on('click','li.checkBox',function(e){
		var target = e.srcElement || e.target;
		if(!$(target).is('a.jqTransformCheckbox')){
			$(this).find('.jqTransformCheckbox').triggerHandler('click');
		}
		$(this).parent('ul').children('li').each(function(){
			if($(this).find('.jqTransformChecked').length > 0){
				$(this).find('.optionContent').css({'color':'#f00'});
			}else{
				$(this).find('.optionContent').css({'color':'#000'});
			}
		});
	});


	// 禁止复制粘贴开始
	document.oncontextmenu=function(){
		return false;
	};

	document.onkeydown = function(e){ 
		var theEvent = window.event || e;
		if (theEvent.ctrlKey && (theEvent.keyCode==67 || theEvent.keyCode==86) ){
			return false; 
		} 
	} 
	document.body.oncopy = function (){ 
		return false; 
	}
	// 禁止复制粘贴结束
</script>
</body>
</html>
