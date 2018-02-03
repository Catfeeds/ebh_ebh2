<?php $this->display('troomv2/exam2/teacher/teacher_header'); ?>
<?php $v=getv();?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wavplayer.css<?=$v?>"  />
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/eview.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js<?=$v?>" ></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/wavplayer.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/play.js<?=getv()?>"></script>
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
var eid = "<?=$eid?>";
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var uid = "<?=$uid?>";
var eviewobj = new Eview();
$(function(){
	eviewobj.init({aid:<?php echo $aid;?>});
});
</script>
<style type="text/css">
#recurPane { background:#fff; color:#333; letter-spacing:1px; cursor:default}
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
.partBar { margin:0 0 3px}
.markerInfo { color:#666}
.markerInfo p { line-height:18px}
.markerInfo textarea { border:1px solid #9c9; margin:0 0 2px 0; height:65px; width:178px; font-size:12px; overflow:auto; color:#000; background:#f1f8f1}
.light{ border:solid 1px #6EB3EA;}
#recurPane img{
	max-width:658px;
	_width:658px;
}
#container .right{
	    left: 1260px;
}
.inputBox div{
	display: inline-block;
}
#viewcontent{
	min-height: 600px;
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
			<p>您好，<?php echo !empty($user['realname']) ? $user['realname'] : $user['username'] ;?></p>
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
	    <div id="center" style="border:none;">
			<div id="webEditor" class="font12px">
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
	<div style="height:16px;">
	<div id="playercontainer"></div>
	</div>
<div class="rykhje">
	<div class="rtykwr" style="margin: 0 auto;">
		<div class="left" style="height: 55px;">
			<div><p><span></span><span class="author"></span></p></div>
			<div><p><span></span><span class="gradeS totalScore"></span></p></div>
		</div>
		<div class="center">
			<a href="javascript:void(0);" id="agianwaskes"  class="rtyiok active" >重新批阅</a>
			 <a href="javascript:void(0);"  class="rtyiok"  onclick="closeWindows();">关闭</a>
		</div>
		<div class="righ">
			<a href="javascript:void(0);" id="goTop" class="jetytu" style="height: 55px;line-height: 55px;">返回顶部</a>
		</div>
        
    </div>
</div>
<script src="http://static.ebanhui.com/ebh/js/swfobject.js<?=$v?>" type="text/javascript"></script>
	 <div id="flvwrap" style="display:none;">
	     <div id="flvcontrol"></div>
	 </div>
</div>
  <iframe name="iframe_data" style="display:none;"></iframe>
 <form id="download_form" name="download_form" target="iframe_data" method="POST"></form>
<!--------播放器代码------------>
<script type="text/javascript" defer="defer">
var ver = 10;
function checkUpdate() {
	return true;
}
</script>
<!--------播放器代码------------>
<script>
	$(function(){
		$("#goTop").on('click',function(){
	  		$("html,body").animate({scrollTop:0}, 500);
		}); 
		window.flash = HTools.pFlash({
			'id':"piceditor",
			'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf",
			'vars':{'showsubmit':0,'showscorepanel':0}
		});
		var button = new xButton();
		
		button.add({
            value: '关闭',
            callback: function () {
            	H.remove('quespanel');
              	H.get('piceditor').exec('close');
               	return false;
            }
		});
		H.create(new P({
			'id':"piceditor",
			'title':'查看批阅',
			'flash':flash,
			'easy':true,
			'button':button
		},{'onclose':function(){
			H.remove('quespanel');
		}}),'common');
		setTimeout(function(){
			eviewobj.fixWpos();
		},1000);
	});
</script>
</body>
</html>