<?php $this->display('troomv2/exam2/teacher/teacher_header'); ?>
<?php $v=getv();?>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/tremark.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=getv()?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/imgMask.js<?=getv()?>"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/imgMask.css<?=getv()?>"/>
<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
global $_SGLOBAL;
?>
var mao = '<?php echo isset($m) ? $m : ''; ?>';
var isMobile = <?php echo $isMobile; ?>;
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var uid = "<?=$uid?>";
var eid = <?php echo $eid;?>;
var aid = <?php echo $aid;?>;
var tremarkobj = new Tremark();
$(function(){
	tremarkobj.init({aid:<?php echo $aid;?>});
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
.markTrue { padding-left:15px; background:url(http://static.ebanhui.com/exam/images/v1_6q.gif) no-repeat center -83px;}
.answerBar, .answerLabel, .scoreLabel { color:#999}
#recurPane .textAnswer { border:1px solid #fff}
#recurPane .textAnswerBar .textAnswer { color:#0020a0}
#recurPane .blankAnswer{ color:#0020c0}
#recurPane img{max-width: 658px;}
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
.inputBox div{
	display: inline-block;
}
.paperName {
    padding: 35px 0 20px 0;
    font-size: 24px;
    font-family: 微软雅黑;
}

.repetition{
	width: 320px;
	height: 180px;
	display: none;
	padding: 20px;
	font-family: 微软雅黑;
}
.repeatClose{
	width: 100%;
	height: 20px;
}
.closebtn{
	float: right;
	height: 18px;
	font-size: 18px;
	line-height: 18px;
	font-weight: bold;
	color: #000;
	text-shadow: 0 1px 0 #FFF;
	cursor: pointer;
	background: transparent;
	border: 0;
	-webkit-appearance: none;
	opacity: .3;
}
.repeatcon{
	width: 100%;
	height: 80px;
	text-align: center;
	line-height: 60px;
	color: #333;
	font-size: 16px;
	font-weight: bold;
}
.repeatbtn{
	width: 100%;
	height: 80px;
}
.confirmrepeat,.cancelrepeat{
	float: left;
	width: 88px;
	height: 36px;
	text-align: center;
	line-height: 36px;
	font-size: 14px;
	border-radius: 5px;
	cursor: pointer;
}
.confirmrepeat{
	background: #169BD5;
	color: #FFFFFF;
	margin: 0 10px 0 50px;
}
.cancelrepeat{
	width: 86px;
	height: 34px;
	border: 1px solid #797979;
	color: #333;
}
.ui-dialog-button{position: relative;}
.ui-dialog-button .ui-dialog-autofocus[i-id=原题]{
	position: absolute;
	top:0;
	left:-645px;
}	
.ui-dialog-button .ui-dialog-autofocus[i-id=全景图]{
	position: absolute;
	top:0;
	left:-710px;
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
    <div id="center">
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
</div>
<div class="rykhje">
	<div class="rtykwr" style="margin: 0 auto;">
		<div class="left" style="height: 55px;">
			<div><p><span></span><span class="author"></span></p></div>
			<div><p><span></span><span class="gradeS totalScore"></span></p></div>
		</div>
		<div class="center">
			<a href="javascript:void(0);"  class="rtyiok active" onclick="checkRepetition()">试卷批阅</a>
			 <a href="javascript:void(0);"  class="rtyiok"  onclick="closeWindows();">关闭</a>
		</div>
		<div class="righ">
			<a href="javascript:void(0);" id="goTop" class="jetytu" style="height: 55px;line-height: 55px;">返回顶部</a>
		</div>
        
    </div>
</div>

<div id="repetition" class="repetition">
	<div class="repeatClose"><span class="closebtn" onclick="closerepeat()">x</span></div>
	<p class="repeatcon">该作业已有批阅记录，是否覆盖？</p>
	<div class="repeatbtn">
		<span class="confirmrepeat" onclick="tremarkobj.sendRemark();">是</span>
		<span class="cancelrepeat" onclick="closerepeat()">否</span>
	</div>
</div>


<script src="http://static.ebanhui.com/ebh/js/swfobject.js<?=$v?>" type="text/javascript"></script>
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
            value: '全景图',
            callback: function () {
            	HTools.getFlash(flash.getId()).swf.togglePanorama();
               return false;
            },
            autofocus: true
		});	
		button.add({
            value: '原题',
            callback: function () {
            	var quespanel = H.get('quespanel')
            	var param = quespanel.param
            	var node = quespanel.dialog.d.node
            	if(node) {
            		if (node.style.display == 'none') {
            			quespanel.exec('show');
            		} else {
            			quespanel.exec('close');
            		}            		
            	} else {
            		H.create(new P({
						title: param.title,
						id: param.id,
						width: param.width,
						content: param.content
					}),'common').exec('show');
            	}
               return false;
            },
            autofocus: true
		});
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
		$('.ui-dialog-button button[i-id=原题]').hide()
		setTimeout(function(){
			tremarkobj.fixWpos();
		},1000);
	});
	//  ---------------- 覆盖 common.js 中的方法 -----------------------
		window.pplay = function (path) {
		console.log()		
			if (path.indexOf('d') == 0) { // 判断是否显示原题
				$('.ui-dialog-button button[i-id=原题]').show()
			} else {
				$('.ui-dialog-button button[i-id=原题]').hide()
			}
			H.get('piceditor').exec('show');
			loadSource(path);
		}
		window.renderHtml = function (html) {
			html = '<div style="width:600px;min-height:100px;overflow-y:auto;">'+html+'</div>';
			H.create(new P({
				title:'原题',
				id:'quespanel',
				width:600,
				// showcancel: false,
				content:html
			}),'common').exec('close');
		}
	//  ---------------- 覆盖 common.js 中的方法 -----------------------
	$("#goTop").on('click',function(){
	  	$("html,body").animate({scrollTop:0}, 500);
	}); 
	
	function checkRepetition(){
		$.ajax({
			type:"post",
			url:"/troomv2/examv2/paperCorrectAjax.html",
			data:{aid:aid,eid:eid},
			dataType:"json",
			success:function(res){
				if(res.correctrat == 100){
					H.create(new P({
				        id:'repetition',
				        easy:true,
				        content:$("#repetition")[0]
				    }),'common').exec('show');
				}else{
					tremarkobj.sendRemark();
				}
			}
		});
	}
	function closerepeat(){
		H.get('repetition').exec('close');
	}
</script>
</body>
</html>