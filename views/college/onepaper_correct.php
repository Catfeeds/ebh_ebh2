<?php
if (! defined ( 'IN_EBH' )) {
	exit ( 'Access Denied' );
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta content="width=1000, user-scalable=no" name="viewport"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线作业</title>
<?php $v=getv();?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css<?=$v?>"  />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/drtu.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/done.css<?=$v?>"/>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/common.js<?=$v?>"></script>

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quebase.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/sinchoiceque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/mulchoice.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/truefalseque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/textline.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/fillque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/audio.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/subjective.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/tremark.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/render.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/wordque.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/quefix.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/jquery.base64.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/achor.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/JSON.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/json2.js<?=$v?>"></script>
<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
$isMobile = 'false';
global $_SGLOBAL;
?>
var mao = '<?php echo empty($_GET["m"])?0:$_GET["m"]; ?>';
var stucancorrect = 1;
var isMobile = <?php echo $isMobile; ?>;
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var papaercorrect = 1;
var uid = "<?=$uid?>";
var suid = "<?=$uid?>";
var eid = <?php echo $eid;?>;
var tremarkobj = new Tremark();
$(function(){
	tremarkobj.initstudent({aid:<?php echo $aid;?>});
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
</script>
<style type="text/css">
body { background-color:#E5F5F6;}

#recurPane { background:#fff;  border-bottom:1px solid #ccc; color:#333; letter-spacing:1px; cursor:default}
#markPane { background-color:#DCF0E3;}

.answerBar, .userAnswerBar, .scoreBar, .linkBar, .textPointBar, .textAnswerBar { padding:2px 0 0 30px; vertical-align:baseline}
.refJudgeA { background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -34px}
.refJudgeB { background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -18px}
.markFalse { padding-left:15px; background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -48px;}
.markTrue { padding-left:15px; background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -83px}
.answerBar, .answerLabel, .scoreLabel { color:#999}
#recurPane .textAnswer { border:1px solid #fff}
#recurPane .textAnswerBar .textAnswer { color:#0020a0}
#recurPane .blankAnswer{ color:#0020c0}
#recurPane img{
	max-width:658px;
}
.blankIndex { color:#333}
.sumscore { color:blue; font-weight:bold}

#markLabel { text-align:center; font-weight:bold; font-size:15px; margin:2px}
.totalScore{ color:red; font-weight:bold; font-size:16px}
#markPaneTop { padding:5px 0 5px 5px}
#markPaneTop table { padding:2px 0 2px 2px}
#markPaneTop table tr { height:14px; line-height:14px}
#markPaneClient { border-top:1px solid #ccc; border-bottom:1px solid #ccc; padding:5px 0 5px 5px}
#markPaneClient ul{ overflow:auto; zoom:1; padding-bottom:12px;}
#markPaneClient li{ float:left; width:39px; white-space:nowrap; overflow:hidden;height: 19px;}
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
.light{ border:solid 1px #6EB3EA;}
.controlBar .btnSubmit{background-position: -792px 0;width: 98px;}
#container .right{
	    left: 1260px;
}
.paperName {
    padding: 35px 0 20px 0;
    font-size: 24px;
    font-family: 微软雅黑;
}
</style>
</head>
<body>
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
<div class="sheet-con" id="container">
<div id="desk" class="layoutContainer" style=" position:relative;">
    <div id="center">
		<div id="webEditor" class="font12px fontSimsum">
            <div id="infoPane" style="padding:8px 5px 0px">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="paperName"></td>
                  </tr>
                  <tr>
                    <td width="16%">作业编号：<span id="paperId" class="paperId"></span></td>
                  </tr>
                  
                  <tr>
                    <td>作业总分：<span class="totalScore"><label id="scorecount"></label></span></td>
                  </tr>
                  <tr>
                    <td>出题时间：<span class="createTime"><label id="datelab"></label></span></td>
                  </tr>
                </table>
        	</div>  
            <div id="viewcontent" class="viewcontent jqtransformdone">
            	
            </div>
            
        </div>
    </div>
    <div id="bottomBar">
    </div>
</div>
</div>
<div class="rykhje">
	<div class="rtykwr" style="margin: 0 auto;">
		<div class="left" style="height: 55px;">
			<div><p><span></span><span class="author"></span></p></div>
			<div><p><span></span><span class="gradeS totalScore"></span></p></div>
		</div>
		<div class="center">
			<a href="javascript:void(0);"  class="rtyiok active" onclick="tremarkobj.sendRemarkstu();">试卷批阅</a>
			 <a href="javascript:void(0);"  class="rtyiok"  onclick="closeWindows();">关闭</a>
		</div>
		<div class="righ">
			<a href="javascript:void(0);" id="goTop" class="jetytu" style="height: 55px;line-height: 55px;">返回顶部</a>
		</div>
        
    </div>
</div>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js" type="text/javascript"></script>
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
   $(window).scroll(function () {
        if ($(this).scrollTop() > 91) {
            $('#markPane').css({'position':'absolute','right':'0'});
            $('#markPane').stop().animate({top:$(this).scrollTop()},1000);
        }else{
            $('#markPane').css({'position':'absolute','right':'0'});
            $('#markPane').stop().animate({top:91},1000);
        }
    });
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
	
	$("#goTop").on('click',function(){
	  	$("html,body").animate({scrollTop:0}, 500);
	}); 
</script>
</body>
</html>