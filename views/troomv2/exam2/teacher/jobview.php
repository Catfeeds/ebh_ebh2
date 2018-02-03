<?php $this->display('troomv2/exam2/teacher/teacher_header'); ?>
<?php $v=getv();?>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/answer2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/formulav2.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/imgeditorv3.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
<?=ckeditor()?>
<script type="text/javascript">
<?php
if(checkbrowser()){
	$isMobile = 'true';
}else{
	$isMobile = 'false';
}
global $_SGLOBAL;
?>
var isMobile = '<?php echo $isMobile; ?>';
var browser = '<?php echo $_SGLOBAL["browser"];?>';
var qnumber=1;//【超级全局变量】 题目总数  变量名不可变
var qid=1;///【超级全局变量 】题目ID号，    变量名不重复
var uid = "<?=$uid?>";
var answerobj = new Answer();
var k = "<?=$k?>";
var eid = "<?=$eid?>";
$(function(){
	answerobj.jobinit({});

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
});
var lastScrollY=0;
function heartBeat(){ 
	if(document.body){
		diffY=document.body.scrollTop || document.documentElement.scrollTop || 0; 
		percent=0.1*(diffY-lastScrollY); 
		if(percent>0)percent=Math.ceil(percent); 
		else percent=Math.floor(percent); 
		if(document.getElementById("limitedtime")){
			document.getElementById("limitedtime").style.top=parseInt(document.getElementById("limitedtime").style.top)+percent+"px";
		}
		lastScrollY=lastScrollY+percent; 
	}
}
window.setInterval("heartBeat()",1);
</script>
<style type="text/css">
body { background-color:#E5F5F6;}
.light{ border:solid 1px #6EB3EA;}
#viewcontent{
	min-height: 600px;
}
.paperName{
	font-size: 24px;
	font-family: 微软雅黑;
	line-height: 35px;
}
</style>
</head>
<body>
<div id="limitedtime" class="limitedtime" style="top:16px;display:none;">
	<p class="yujisj">本试卷答题时间：<span class="dengcu" id="showlimitedtime">3分钟</span></p>
	<div class="fotshij">
		<div id="limitedhour" class="neidku">02</div>
		<span class="lsies">时</span>
		<div id="limitedminute" class="neidku">02</div>
		<span class="lsies">分</span>
		<div id="limitedsecond" class="neidku">02</div>
		<span class="lsies">秒</span>
	</div>
</div>
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
	<div id="desk" class="layoutContainer" style="">
	    <div id="center">
			<div id="webEditor" class="font12px fontSimsum">
	            <div id="infoPane" style="padding:8px 5px 0px">
	            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	                  <tr>
	                    <td class="paperName"><label id="examtitle"></label><span style="color:#999">[共<em style="color:#f37f00">60</em>题]</span></td>
	                  </tr>
	                  <tr>
	                    <td width="16%">作业编号：<span class="paperId">10010</span></td>
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
	            <div id="editControlPane" class="controlBar">
	            	<input type="button" name="" class="btnClose" onclick="closeWindows();" value="">
	      <!--           <input type="button" name="" class="btnSave" onclick="answerobj.uploadData(0);" value="" />
	                <input type="button" name="" class="btnSubmit" onclick="answerobj.uploadData(1,true);"/> -->
	            </div>
	        </div>
	    </div>
	    <div id="bottomBar">
	    </div>
	</div>
</div>
<div id="timeoverdialog" style="display:none">
	<div style="float: left;margin-top: 20px;height:60px"><img src="http://static.ebanhui.com/exam/images/naozhong.gif"></div>
	<div style="float: left;margin-top: 20px;font-size: 14px;line-height: 25px;margin-left: 20px;height:60px;width:240px;"><p>亲爱的同学，考试时间到了！试卷已经自动提交，请点击“确认”查看试卷</p></div>
	<div style="float:left;width: 135px;height: 29px;margin-left: 90px;_margin-left: 45px;cursor: pointer;"><a href="javascript:answerobj.showlevel();"><div style="width:80px;height:29px;line-height:29px;background:url('/static/images/TestImageNoText_135x29.png');display:block;font-size:14px;padding-left: 55px;text-decoration: none;">确认</div></a></div>

</div>
<!--------播放器代码------------>
<script type="text/javascript" defer="defer">

function checkUpdate() {return true;}
</script>

<script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/play.js<?=getv()?>"></script>
<!--------播放器代码------------>

<script>
	$(function(){
		window.flash = HTools.pFlash({
			'id':"piceditor",
			'uri':"http://static.ebanhui.com/exam/flash/couseEditor.swf",
			'vars':{'showsubmit':0,'showscorepanel':0,'showopen':0}
		});
		var button = new xButton();
		button.add({
            value: '提交答案',
            callback: function () {
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
	});
</script>
</body>
</html>
