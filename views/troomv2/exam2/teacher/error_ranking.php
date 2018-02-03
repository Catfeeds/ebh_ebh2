<!DOCTYPE HTML>
<html>
<head>
<meta content="width=1000, user-scalable=no" name="viewport"/> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php $v=getv();?>
    <?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
	<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
	<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
	<?php }?>
    <link href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>">
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>">
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wussyu.css<?=$v?>"/>		
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/common.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/exam/newjs/play.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/swfobject.js<?=$v?>" ></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js<?=$v?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-more.js<?=$v?>"></script>
    <title>错题排名</title>
	<style>
	body{
		min-height: 100%;
		background: #f3f3f3;
		font-family: 微软雅黑!important;
	}
	.imgyuan{
		width:40px;
		height: 40px;
		margin: 7px 0 0 12px;
	}
	.Havepay{
		width: 410px;
		position: relative;
		height: 55px;
		float: left;
	}
	.Havepay div img{
		margin: 0 3px;
	}
	.Havepay .offR,.Havepay .onR{
		position: absolute;
		top: 0;
		left: 0;
	}
	.onTxt{
		position: absolute;
		left: 320px;
	}
	.dsiters{
		margin-top: 90px;
	}
	.Havepay .onR img{
		display: none;
	}
	.averageTime{
		width: 180px;
		height: 55px;
		background: url(http://static.ebanhui.com/exam/images/Alarm.jpg) no-repeat;
		padding-left: 56px;
		float: left;
		margin-left: 10px;
	}
	.soulico {
		float:left;
		background:url(http://static.ebanhui.com/ebh/tpl/2014/images/newsolico.jpg) no-repeat;
		height:24px;
		width:26px;
		border:none;
		cursor:pointer;
	}
	.newsou {
	    width: 150px;
	    height: 22px;
	    line-height: 22px;
	    border: solid 1px #d9d9d9;
	    border-right: none;
	    color: #d2d2d2;
	    padding-left: 5px;
	    float: left;
	}
	.diles {
	    display: inline;
	    height: 30px;
	    position: absolute;
	    right: 8px;
	    top: -30px;
	    width: 185px;
	    
	}
	a.revise{
		float: left;
	    background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png) no-repeat;
	    width: 26px;
	    height: 27px;
	    margin-left: 12px;
	}
	a.shansge{
		margin-left: 25px;
	}
	.lefrig{
		float: none;
		margin: 0 auto;
	}
	a.waskes{ margin-left: 70px;}
	a.remind{margin-left:10px ;color:cornflowerblue;}
	
	div.work_mes{
		position: relative;
		padding:  0 50px;
	}
	div.workdata{
		position: relative;
		margin-top: 20px;
		width: 950px;
		padding-bottom: 50px;
	}
	div.work_mes{
		height: auto;
		float: none!important;
	}
	.extendul{
		height: 42px;
	    border-bottom: solid 1px #e3e3e3;
	}
	.mk_j_num,.mk_y_time{
		color:#ed5468;font-size: 30px; font-weight: 500; line-height: 30px;
	}
	.ui-tabs-hide
		{
		    display: none;
		}
	/*分页*/
	.pages{ height:50px; padding-top:15px; padding-right:20px;}
	.listPage{height: 30px; text-align: center; margin: 0 auto;}
	.listPage a {background:#f9f9f9;border: 1px solid #f9f9f9;display: inline-block;font-weight:bold;height: 26px;line-height:26px;margin: 0 2px;text-align: center;width: 30px;color:#767676!important;text-decoration:none;}
	.listPage a:visited {background:#f9f9f9;border: 1px solid #f9f9f9; display: block;  float: left;  height: 26px;line-height:26px; margin: 0 2px; text-align: center; width: 30px;color:#323232;text-decoration:none;}
	.listPage a:Hover {	border:1px solid #0CA6DF;text-decoration: none;}
	.listPage .none{border:1px solid #23a1f2;background:#23a1f2;color:#FFFFFF!important;font-weight:bold;}
	#next{ width:66px; height:26px; }
	#gopage{ width:26px;padding:3px 2px;  border:1px solid #CCCCCC; font-size:12px; text-align:center; float:left;}
	#page_go{ width:45px; height:20px;}
	.boxF{
		padding-top: 30px;
	}
	.boxF h1{
		display: block;
		width: 100%;
		height: 18px;
		font-size: 18px;
		line-height: 18px;
		margin-bottom: 10px;
		padding-left: 10px;
	}
	.boxF h1 i{
		display: inline-block;
		width: 3px;
		height: 15px;
		background: #5c96f7;
		margin: 2px 10px 0 10px;
	}
	.PressT,.PressZ{
		display: block;
		width: 100%;
		height: 18px;
		font-family: 微软雅黑;
		font-size: 18px;
		line-height: 18px;
		margin-top: 10px;
		padding: 10px 0;
		float: left;
	}
	.PressT i,.PressZ i{
		display: inline-block;
		width: 3px;
		height: 15px;
		background: #5c96f7;
		margin: 2px 8px 0 2px;
	}
	.work_mes ul li a{
		padding: 0;
	}
	.work_mes ul li.radioBox{
		line-height: 16px;
	}
	.singleContainerFocused {
	    border-top: none;
	}
	.stuList{
		width: 134px;
		height: 54px;
		margin: 0px 40px 10px 10px;
		float: left;
		cursor: pointer;
	}
	.stuListhover{
	    border: 1px solid #eee;
	    border-radius: 2px;
	    box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.3);
	}
	.stuanswer{
		width:50px;display:inline-block;height:100%;color:#666;font-size: 30px; line-height: 50px; text-align: center;font-family: 微软雅黑;
	}
	.studentBox{
		border-bottom: solid 1px #e3e3e3;height: 62px; width: 100%;
	}
	div.studentBox:last-child{
		border-bottom:none;
	}
	.work_mes ul.ui-tabs-nav li{
		    margin: 0 12px !important;
	}
	.ksrdgae{
		margin: 0 20px;
		float: none;
	}
	.hietse {
		border: 1px solid #eee;
		border-radius:3px;
	}
	.lishnrt{
		padding: 10px 0px;
		width: 900px;
	}
	.ghjut{
		width: 68px;
	    margin: 3px 0 0 10px;
	    line-height: 24px;
	   
	}
		.classlist{
		text-align: center;
		margin-top: 10px;
		line-height: 24px;
	}
	.classlist a{
		padding: 0px 10px;
	    display: inline-block;
	    height: 24px;
	    border-radius: 3px;
	    margin: 2px 3px;
	    cursor: pointer;
	}
	.classlist a.active{
		color: #fff;
		background: #5e96f5;
	}
	.classlist span{
		margin: 2px 3px;
	}
	.jisret{
	/*	height: 45px;*/
	}
	.h6css1{
		text-align: right;font-family: '微软雅黑';font-size: 13px;display: block; width: 100%;color:#ffaf28
	}
	.h2css1{
		text-align: right;font-family: '微软雅黑';font-size: 22px;display: block;height: 50px;width: 100%;line-height: 50px;
	}
	</style>
	<script>
	var eid = "<?=$eid?>";
	var k = "<?=$k?>";	  
	</script>
</head>

<body>
<div id="header">
	<div class="adAuto">
		<div class="magAuto top">
			<p>您好,<?php echo !empty($user['realname']) ? $user['realname'] : $user['username'] ;?></p>
		</div>
	</div>
	<div class="Ad">
		<div class="magAuto">
			<img src="http://static.ebanhui.com/exam/images/banner/stu_head_pic.jpg" />
		</div>
	</div>
</div>
<div id="container">
<div class="lefrig">
    <h2 class="jisret"></h2>
	<div class="fl" style="width: 100%;border-bottom: 1px solid #efefef;">
		<div>
			<p class="kishre" style="width: 100%;text-align: center;"><span class="ksrdgae pusTime">布置时间：</span><span class="ksrdgae scorelab">总分：</span><span class="ksrdgae limittime">计时：分钟</span></p>
			<div style="width: 100%;" class='classlist'>
				
			</div>
			<div class="clear"></div>
		</div>
		<div class="fl" style="height: 100%; width: 380px; overflow: hidden;">
			<div id='container1' class="fl" style="height: 250px;width:380px;">
				
			</div>
		</div>
		<div style="width: 620px;height: 100%;background: #fff;" class="fl">
			
			<div class="dsiters">
			    <div class="Havepay">
			    	<div class="offR">
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    		<img src="http://static.ebanhui.com/exam/images/offR.jpg" />
			    	</div>
			    	<div class="onR">
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						<img src="http://static.ebanhui.com/exam/images/onR.jpg" />
						
			    	</div>
			    	<div class="onTxt">
			    		已交 <span class="mk_y_num">0</span>/<span class="mk_q_num">---</span><br />
			    		<p class="mk_j_num">---</p>
			    	</div>
			    	
			    </div>
			    <div class="averageTime">
			    	<div>
			    		平均答题时间<br />
			    		<p class="mk_y_time" >---</p>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
	<div style="width: 1000px; padding: 0 50px;" class="fl" id="errorRank">
	</div>
	<div class="fontSimsum work_mes">

	</div>
</div>
</div>
<script type="text/html" id="t:answer">
	<%if(queType == 'A'){%>
	<h1 class="PressT"><i></i>试题内容</h1>
	<div class="fl ui-tabs-panel">
		<div class="que singleContainer singleContainerFocused">
			<div class="subjectPane">
				<span class="stIndex" style="float:left;">1. </span>
				<span class="inputBox" style="float:left; width:850px;"><%=#subject%>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<%=score%>分]</em></span>
				<span class="clearing"></span>
			</div>
			<div class="radioPane">
				<ul style="overflow: hidden;">
					<% for(var i=0;i< options.length;i++){%>
					<li class="radioBox" style="width: 100%;">
						<p class="radioWrapper" style="display:block; float:left;width:35px;">
						<span class="jqTransformRadioWrapper">
							<a rel="question" class="jqTransformRadio" href="javascript:void(0);"></a>
							<input type="radio" value="" name="question" class="jqTransformHidden"></span>
							<label style="cursor:pointer;" bid="<%=keycode+i%>"></label>
						</p>
						<span class="optionContent" style="display: block; margin-left: 36px;    width: 610px; word-break: break-all;"><%=#options[i]%></span>
						<span class="clearing"></span>
					</li>
					<%}%>						
				</ul>
			</div>
	        <div class="answerBar">正确答案：<span class="answerLabel"><%=answers%></span></div>
			<%if(fenxi !=''){%>
			<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#fenxi%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(resolve !=''){%>
			<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#resolve%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(dianpin !=''){%>
			<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#dianpin%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(source !=''){%>
			<div class="title answerBar">
	    		<span style="float:left;">课件解析：</span>
	    		<div style="width:85%;float:left;" class="resolve inputBox">
	    			<a href="javascript:void(0);" onclick="userplay('<%=source%>','<%=cwid%>');return false;">
	    				<img src="http://exam.ebanhui.com/static/images/playcourseware.jpg">	
	    			</a>
	    		</div>
	    		<div class="clearing"></div>
	    	</div>
			<%}%>
	        <div id='containerDx' class='fl' style='width: 100%;'></div>
		</div>
	</div>
	    <h1 class="PressT"><i></i>学生列表</h1>
	    <div class="lishnrt">
		<%for(var i=0;i<answerDetaillist.length;i++){%>
			<%if(answerDetaillist[i].choiceStr != ''){%>
				<a href="javascript:void(0);" value="0" class="hietse <%=i==0?'xhusre':''%>" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>','<%=answerDetaillist[i].choiceOriStr%>')">选<%=answerDetaillist[i].choiceStr%></a>
			<%}else{%>
				<a href="javascript:void(0);" value="0" class="hietse <%=i==0?'xhusre':''%>" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>','<%=answerDetaillist[i].choiceOriStr%>')">没填</a>
			<%}%>
			
	    <%}%>
	    </div>
	    <div class="workdata quetype fl">
	    </div>
	<%}else if(queType == 'B'){%>
	<h1 class="PressT"><i></i>试题内容</h1>
	<div class="fl ui-tabs-panel">
		<div class="que singleContainer singleContainerFocused">
			<div class="subjectPane">
				<span class="stIndex" style="float:left;">1. </span>
				<span class="inputBox" style="float:left; width:850px;"><%=#subject%>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<%=score%>分]</em></span>
				<span class="clearing"></span>
			</div>
			<div class="checkBoxPane">
				<ul style="overflow: hidden;">
					<% for(var i=0;i< options.length;i++){%>
					<li class="checkBox" style="width: 100%;">
						<p class="checkBoxWrapper" style="display:block; float:left;width:35px;">
						<span class="jqTransformCheckboxWrapper">
							<a rel="question" class="jqTransformCheckbox" href="javascript:void(0);"></a>
							<input type="checkbox" value="" name="question" class="jqTransformHidden"></span>
							<label style="cursor:pointer;" bid="<%=keycode+i%>"></label>
						</p>
						<span class="optionContent" style="display: block; margin-left: 36px;width: 610px; word-break: break-all;"><%=#options[i]%></span>
						<span class="clearing"></span>
					</li>
					<%}%>						
				</ul>
			</div>
	        <div class="answerBar">正确答案：<span class="answerLabel"><%=answers%></span></div>
	        <%if(fenxi !=''){%>
			<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#fenxi%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(resolve !=''){%>
			<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#resolve%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(dianpin !=''){%>
			<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#dianpin%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(source !=''){%>
			<div class="title answerBar">
	    		<span style="float:left;">课件解析：</span>
	    		<div style="width:85%;float:left;" class="resolve inputBox">
	    			<a href="javascript:void(0);" onclick="userplay('<%=source%>','<%=cwid%>');return false;">
	    				<img src="http://exam.ebanhui.com/static/images/playcourseware.jpg">	
	    			</a>
	    		</div>
	    		<div class="clearing"></div>
	    	</div>
			<%}%>
		</div>
	</div>
	<div class="fl ui-tabs-panel ui-tabs-hide">
		<div class="lishnrt">
			<a href="javascript:void(0);" value="0" class="hietse xhusre" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>')">全部学生</a>
		<%for(var i=0;i<answerDetaillist[0].choiceStr.length;i++){%>
			<%if(answerDetaillist[0].choiceStr[i] == ''){%>
				<a href="javascript:void(0);" value="0" class="hietse" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>','<%=answerDetaillist[0].choiceStr[i]%>')">没填</a>
			<%}else{%>
				<a href="javascript:void(0);" value="0" class="hietse" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>','<%=answerDetaillist[0].choiceStr[i]%>')">选<%=answerDetaillist[0].choiceStr[i]%></a>
			<%}%>
			
	    <%}%>
	    </div>
	    <div class="workdata quetype fl">
	    </div>
	</div>
	<%}else if(queType == 'C'){%>
	<h1 class="PressT"><i></i>试题内容</h1>
	<div class="fl ui-tabs-panel">
		<div class="que singleContainer singleContainerFocused">
			<div class="blankSubject subjectPane">
	            <span class="stIndex" style="float:left;">1 .</span>
	            <span class="inputBox" style="float:left; width:850px;"><%=#subject%>
	            <span class="pointLabel sorceLabel">[<%=score%>分]</span></span>
	            <span class="clearing"></span>
	        </div>
	        <div class="answerBar">正确答案：
	            <span class="answerLabel"><%=#answers%></span>
	        </div>
	        <%if(fenxi !=''){%>
			<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#fenxi%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(resolve !=''){%>
			<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#resolve%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(dianpin !=''){%>
			<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#dianpin%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(source !=''){%>
			<div class="title answerBar">
	    		<span style="float:left;">课件解析：</span>
	    		<div style="width:85%;float:left;" class="resolve inputBox">
	    			<a href="javascript:void(0);" onclick="userplay('<%=source%>','<%=cwid%>');return false;">
	    				<img src="http://exam.ebanhui.com/static/images/playcourseware.jpg">	
	    			</a>
	    		</div>
	    		<div class="clearing"></div>
	    	</div>
			<%}%>
	    </div>
    </div>
    <div class="fl ui-tabs-panel ui-tabs-hide">
	</div>	
	<%}else if(queType == 'D'){%>
	<h1 class="PressT"><i></i>试题内容</h1>
	<div class="fl ui-tabs-panel">
		<div class="que singleContainer singleContainerFocused">
			<div class="questionContainer">
	            <div class="subjectPane">
		            <span class="stIndex" style="float:left;">1. </span>
		            <span class="inputBox" style="float:left; width:850px;">
		            <%=#subject%>
		            <em class="sorceLabel">[<%=score%>分]</em></span>
		            <span class="clearing"></span>
	            </div>
	            <div class="userAnswerBar">
		            <div style="float:left;"><span>对错选项：</span></div>
			            <div style="float:left;">
				            <span class="jqTransformRadioWrapper">
				            <a class="jqTransformRadio" href="javascript:void(0);"></a>
				            <input type="radio" value="true" name="" class="jqTransformHidden"></span>
				            <label for="" style="cursor:pointer;float:left;margin-right:10px;">对</label>
	
				            <span class="jqTransformRadioWrapper">
				            <a class="jqTransformRadio" href="javascript:void(0);"></a>
				            <input type="radio" value="false" name="" class="jqTransformHidden"></span>
				            <label for="" style="cursor:pointer;">错</label>
			        	</div>
			            <div class="clearing"></div>
		            </div>
		        </div>
	            <div class="answerBar">正确答案：<span class="answerLabel"><%=answers=='1'?'对':'错'%></span></div>
	            <%if(fenxi !=''){%>
				<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#fenxi%><br></p></div><div class="clearing"></div></div>
				<%}%>
				<%if(resolve !=''){%>
				<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#resolve%><br></p></div><div class="clearing"></div></div>
				<%}%>
				<%if(dianpin !=''){%>
				<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#dianpin%><br></p></div><div class="clearing"></div></div>
				<%}%>
				<%if(source !=''){%>
				<div class="title answerBar">
	    		<span style="float:left;">课件解析：</span>
	    		<div style="width:85%;float:left;" class="resolve inputBox">
	    			<a href="javascript:void(0);" onclick="userplay('<%=source%>','<%=cwid%>');return false;">
	    				<img src="http://exam.ebanhui.com/static/images/playcourseware.jpg">	
	    			</a>
	    		</div>
	    		<div class="clearing"></div>
	    	</div>
				<%}%>
	            <div id='containerDx' class='fl' style='width:100%;'></div>
	    </div>
    </div>
    <h1 class="PressT"><i></i>学生列表</h1>
	<div class="lishnrt">
    <%for(var i=0;i<answerDetaillist.length;i++){%>
		<%if(answerDetaillist[i].choiceStr == '10'){%>
			<a href="javascript:void(0);" value="0" class="hietse <%=i==0?'xhusre':''%>" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>','<%=answerDetaillist[i].choiceStr%>')">选对</a>
		<%}else if(answerDetaillist[i].choiceStr == '01'){%>
			<a href="javascript:void(0);" value="0" class="hietse <%=i==0?'xhusre':''%>" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>','<%=answerDetaillist[i].choiceStr%>')">选错</a>
		<%}else if(answerDetaillist[i].choiceStr == '00'){%>
			<a href="javascript:void(0);" value="0" class="hietse <%=i==0?'xhusre':''%>" onclick="getanswersbyChoice('<%=qid%>','<%=queType%>','<%=answerDetaillist[i].choiceStr%>')">没填</a>
			
		<%}%>
		
    <%}%>
    </div>
    <div class="workdata quetype fl">
    </div>
	<%}else if(queType == 'E'){%>
	<h1 class="PressT"><i></i>试题内容</h1>
	<div class="fl ui-tabs-panel">
		<div class="que singleContainer singleContainerFocused">  
			 <div class="subjectPane">
	            <span class="stIndex" style="float:left;">1. </span>
	            <span class="inputBox" style="float:left; width:850px;">
	            <%=#subject%>	            <em class="sorceLabel">[<%=score%>分]</em></span>
	            <span class="clearing"></span>
	        </div>
	        <div class="answerBar">正确答案：<span class="answerLabel"><%=answers%></span></div>
	        <%if(fenxi !=''){%>
			<div class="title answerBar"><span style="float:left;">分析：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#fenxi%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(resolve !=''){%>
			<div class="title answerBar"><span style="float:left;">解答：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#resolve%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(dianpin !=''){%>
			<div class="title answerBar"><span style="float:left;">点评：</span><div class="resolve inputBox" style="width:620px;float:left;"><p><%=#dianpin%><br></p></div><div class="clearing"></div></div>
			<%}%>
			<%if(source !=''){%>
	    	<div class="title answerBar">
	    		<span style="float:left;">课件解析：</span>
	    		<div style="width:85%;float:left;" class="resolve inputBox">
	    			<a href="javascript:void(0);" onclick="userplay('<%=source%>','<%=cwid%>');return false;">
	    				<img src="http://exam.ebanhui.com/static/images/playcourseware.jpg">	
	    			</a>
	    		</div>
	    		<div class="clearing"></div>
	    	</div>
			<%}%>
	    </div>
	</div>
	<div class="fl ui-tabs-panel ui-tabs-hide">
	</div>	
	<%}%>
</script>
<script id="t:tab" type="text/html">
	<div class="studentBox">
		<% for(var i=0;i<result.length;i++){%>
		<div class="stuList"  onclick="window.open('/troomv2/examv2/eview/<%=result[i].aid%>.html?eid=<%=eid%>')">
			<a title="" href="javascript:;" style="float:left;">
				<%if(result[i].face == ''){%>
					<%if(result[i].sex == '0'){%>
						<img class="imgyuan" src="http://static.ebanhui.com/ebh/tpl/default/images/m_man_40_40.jpg">
					<%}else{%>
						<img class="imgyuan" src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman_40_40.jpg">
					<%}%>		
					
				<%}else{%>
					<img class="imgyuan" src="<%=result[i].face%>">
				<%}%>	
			</a>
			<p class="ghjut">
				
				<span title="<%=result[i].realname%>" style="font-family: '微软雅黑';"><%=substrinreal(result[i].realname)%></span>
				
				<%if(result[i].sex == '0'){%>
						<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">
					<%}else{%>
						<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">
					<%}%>	
				
				<br>
					<span title="<%=result[i].username%>" style="display: inline-block;width: 70px;overflow: hidden;height: 20px;white-space: nowrap;text-overflow: ellipsis;color: #999;"><%=result[i].username%></span>
				
			</p>
		</div>
		<%}%>
	</div>

</script>
<div id="flvwrap" style="display:none;">
     <div id="flvcontrol"></div>
</div>
<iframe name="iframe_data" style="display:none;"></iframe>
<form id="download_form" name="download_form" target="iframe_data" method="POST"></form>
<script type="text/javascript">
	var classids = $.parseJSON(GetQueryString('classids')) || [];
	var classid = []
	function getclass(url) {   //试卷信息解析
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/getExamSummaryAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				
				'eid':eid,
				'k':k,
				'classid':classids.join()
			}
		}).done(function(res){
		    var classcheckbut = '';
			if(res.datas.efenxisummary.class){
		    	for(var i=0;i<res.datas.efenxisummary.class.length;i++){
		    		classcheckbut+='<a classid="'+res.datas.efenxisummary.class[i].classid+'">'+res.datas.efenxisummary.class[i].classname+'</a>';
		    	}
		    }
		    classcheckbut = '关联班级:  <a classid="'+classids+'" class="active">全部</a>'+ classcheckbut;
		    $('.classlist').empty().append(classcheckbut);
		    $('.onR img').hide()
			$('.mk_y_time').text(Math.ceil(res.datas.efenxisummary.avgusedtime/60) + '分钟');
			$('.mk_y_num').text(res.datas.efenxisummary.answercounts);
			if(res.datas.efenxisummary.answercounts >= res.datas.alluserscount){
				$('.mk_q_num').text(res.datas.efenxisummary.answercounts);
				if(res.datas.efenxisummary.answercounts == 0){
						var mk_j_num = '0%';
				}else{
						var mk_j_num = Math.round((res.datas.efenxisummary.answercounts/res.datas.efenxisummary.answercounts)*100)+'%';
				}	
				
			}else{
				$('.mk_q_num').text(res.datas.alluserscount);
				var mk_j_num =  Math.round((res.datas.efenxisummary.answercounts/res.datas.alluserscount)*100)+'%';
			}
			var mkNumb = Math.round(((parseFloat(mk_j_num))/10));
			$('.mk_j_num').text(mk_j_num);
			$('.jisret').text(res.datas.efenxisummary.esubject);
			$('.pusTime').text('布置时间：' +res.datas.efenxisummary.dateline)
			$('.limittime').text('计时：' + res.datas.efenxisummary.limittime + '分钟')
			$('.scorelab').text('总分 ：' + res.datas.efenxisummary.totalscore + '分')
			for(var i= 0;i<=(mkNumb-1);i++){
		    	var onR = $('.onR img');
		    	$(onR[i]).show();
		   }
		    var  fenxiA = [];
		    for(var i=0;i<res.datas.efenxisummary.fenxi.length;i++){
		    	var fenxi = res.datas.efenxisummary.fenxi[i];
		    	switch(fenxi.quetype)
				{
				case 'A':
				  	fenxi.quetype = '单选题';
				break;
				case 'B':
					fenxi.quetype = '多选题';
				break;
				case 'C':
					fenxi.quetype = '填空题';
				break;
				case 'D':
					fenxi.quetype = '判断题';
				break;
				case 'E':
					fenxi.quetype = '文字题';
				break;
				case 'H':
					fenxi.quetype = '主观题';
				break;
				case 'Z':
					fenxi.quetype = '文本行';
				break;
				case 'G':
					fenxi.quetype = '音频';
				break;
				case 'X':
					fenxi.quetype = '答题卡';
				break;
				case 'XTL':
					fenxi.quetype = '听力题';
				break;
				case 'XWX':
					fenxi.quetype = '完形填空';
				break;
				case 'XYD':
					fenxi.quetype = '阅读理解';
				break;
				case 'XZH':
					fenxi.quetype = '组合题';
				break;
				}
				fenxiA.push([fenxi.quetype,fenxi.count]);
		    }
		    $('#container1').highcharts({
		        chart: {
		            type: 'pie',
		            options3d: {
		                enabled: true,
		                alpha: 45,
		                beta: 0
		            },
		            style : {
					    fontFamily:"",
					    fontSize:'12px',
					    fontWeight:'bold',
					    color:'#006cee'
					  }
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		            pointFormat: '{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                depth: 18,
		                size : 190,
		                dataLabels: {
		                    enabled: true,
		                    format: '{point.name}'
		                }
		            }
		        },
		        credits:{
				     enabled:false // 禁用版权信息
				},
		        series: [{
		            type: 'pie',
		            name: '',
		            data: fenxiA
		        }]
		    });
		    classlistonclick()
		}).fail(function(){});
	}
	function getExamSummaryAjax(url) {   //试卷信息解析
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/getExamSummaryAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				
				'eid':eid,
				'k':k,
				'classid':classid
			}
		}).done(function(res){
			$('.onR img').hide()
			$('.mk_y_time').text(Math.ceil(res.datas.efenxisummary.avgusedtime/60) + '分钟');
			$('.mk_y_num').text(res.datas.efenxisummary.answercounts);
			if(res.datas.efenxisummary.answercounts >= res.datas.alluserscount){
				$('.mk_q_num').text(res.datas.efenxisummary.answercounts);
				if(res.datas.efenxisummary.answercounts == 0){
						var mk_j_num = '0%';
				}else{
						var mk_j_num = Math.round((res.datas.efenxisummary.answercounts/res.datas.efenxisummary.answercounts)*100)+'%';
				}	
				
			}else{
				$('.mk_q_num').text(res.datas.alluserscount);
				var mk_j_num =  Math.round((res.datas.efenxisummary.answercounts/res.datas.alluserscount)*100)+'%';
			}
			var mkNumb = Math.round(((parseFloat(mk_j_num))/10));
			$('.mk_j_num').text(mk_j_num);
			$('.jisret').text(res.datas.efenxisummary.esubject);
			$('.pusTime').text('布置时间：' +res.datas.efenxisummary.dateline)
			$('.limittime').text('计时：' + res.datas.efenxisummary.limittime + '分钟')
			$('.scorelab').text('总分 ：' + res.datas.efenxisummary.totalscore + '分')
			for(var i= 0;i<=(mkNumb-1);i++){
		    	var onR = $('.onR img');
		    	$(onR[i]).show();
		   }
		    var  fenxiA = [];
		    for(var i=0;i<res.datas.efenxisummary.fenxi.length;i++){
		    	var fenxi = res.datas.efenxisummary.fenxi[i];
		    	switch(fenxi.quetype)
				{
				case 'A':
				  	fenxi.quetype = '单选题';
				break;
				case 'B':
					fenxi.quetype = '多选题';
				break;
				case 'C':
					fenxi.quetype = '填空题';
				break;
				case 'D':
					fenxi.quetype = '判断题';
				break;
				case 'E':
					fenxi.quetype = '文字题';
				break;
				case 'H':
					fenxi.quetype = '主观题';
				break;
				case 'Z':
					fenxi.quetype = '文本行';
				break;
				case 'G':
					fenxi.quetype = '音频';
				break;
				case 'X':
					fenxi.quetype = '答题卡';
				break;
				case 'XTL':
					fenxi.quetype = '听力题';
				break;
				case 'XWX':
					fenxi.quetype = '完形填空';
				break;
				case 'XYD':
					fenxi.quetype = '阅读理解';
				break;
				case 'XZH':
					fenxi.quetype = '组合题';
				break;
				}
				fenxiA.push([fenxi.quetype,fenxi.count]);
		    }
		    $('#container1').highcharts({
		        chart: {
		            type: 'pie',
		            options3d: {
		                enabled: true,
		                alpha: 45,
		                beta: 0
		            },
		            style : {
					    fontFamily:"",
					    fontSize:'12px',
					    fontWeight:'bold',
					    color:'#006cee'
					  }
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		            pointFormat: '{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                depth: 18,
		                size : 190,
		                dataLabels: {
		                    enabled: true,
		                    format: '{point.name}'
		                }
		            }
		        },
		        credits:{
				     enabled:false // 禁用版权信息
				},
		        series: [{
		            type: 'pie',
		            name: '',
		            data: fenxiA
		        }]
		    });
		}).fail(function(){});
	}
	function geterror_rank(eid){  //错题排行柱状图解析
		
		$.ajax({
			url:'/troomv2/examv2/errlistAjax.html',
			method:'post',
			dataType:'json',
			data : {
				eid : eid,
				style: 0,
				classid:classid
			}
		}).done(function(res){
		var data = [];
		var dataColor = [];
		var errList = 	res.datas.errList;
		if(errList.length){
			var containerCT = '<h2 class="h2css1"  class="fl" >作业错题排名</h2><div id="containerCT" class="fl" style="height: 400px;width: 100%"></div><h6 class="h6css1"  class="fl">注：单击柱状图显示试题内容</h6>'
			$('#errorRank').empty().append(containerCT);
			for(var i=0;i<errList.length;i++){
				dataColor.push(i);
				data.push({name :'题目'+(i+1),y :parseInt((errList[i].errorCount/res.datas.answercounts).toPercent().replace('%','')),qid : errList[i].question.qid,quetype : errList[i].question.queType,color:i=='0'?'#ffaf28':'#7cb5ec'})
			}
			var CT =$('#containerCT').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: ''
		        },
		        subtitle: {
		            text: ''
		        },
		        xAxis: {
		            type: 'category',
		            labels: {
		                rotation: -45,
		                style: {
		                    fontSize: '13px',
		                    fontFamily: 'Verdana, sans-serif'
		                }
		            }
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: '错<br>误<br>率<br>︵<br>百<br>分<br>比<br>%<br>︶',
		                rotation:0,
		                style:{
		                	fontSize: '15px',
		                	fontFamily:'微软雅黑',
		                	color:'#000'
		                }
		            }
		        },
		        legend: {
		            enabled: false
		        },
		        credits:{
		     		enabled:false // 禁用版权信息
				},
		        plotOptions: {  
		            series: { 
		                cursor: 'pointer',
		                events: {  
		                    click: function(e) {
		                    	showAlertY(e.point.qid,e.point.quetype);
		                    	for (var i = 0; i < e.point.series.data.length; i++) {
					　　　　　　　　var temp = e.point.series.data[i];
				　　　　　　　　　　e.point.series.data[i].color = '#7cb5ec';//去掉已点击的颜色
				　　　　　　　　　　e.point.series.data[i].update(e.point.series.data[i]);
					　　　　　　}
								e.point.color = '#ffaf28';
		                    	e.point.update(e.point);
		                    }
			            }
		            }  
		        }, 
		        tooltip: {
		            pointFormat: '' //{point.y:.1f}{point.y:.1f} 
		        },
		        series: [{
		            name: 'Population',
		            data:data,
		            dataLabels: {
		                enabled: true,
		                rotation: -90,
		                color: '#FFFFFF',
		                align: 'right',
		                format: '', // one decimal
		                y: 10, // 10 pixels down from the top
		                style: {
		                    fontSize: '13px',
		                    fontFamily: 'Verdana, sans-serif'
		                }
		            }
		        }]
		    });
		    showAlertY(data[0].qid,data[0].quetype);
		}else{
			var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
							'<div class="study" style="margin: 0 auto; width: 900px;">' +
								'<div class="nodata"></div>'+
								'<p class="zwktrykc" style="text-align: center;"></p>'+
							'</div>'+
			        	'</div>';
			
			$('#errorRank').empty().append(cmain_bottom);
			$('.work_mes').empty();
		}
		
			
		}).fail(function(){
			console.log('req err');
		});
	}
	
	function showAlertY(qid,quetype){  //试题内容数据请求
	
		  $.ajax({
			url:'/troomv2/examv2/answerCount.html',
			method:'post',
			dataType:'json',
			data : {
				qid : qid ,
				quetype :quetype,
				classid:classid
			}
		}).done(function(res){
			answerparse(res);
			
		}).fail(function(){
		});
		 
	}
	function answerparse(res){   //试题内容解析
		if(res.datas.quetype == 'C'){
			var qsubject =	res.datas.simpleQue.subject.replace(/#input#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
			qsubject =	qsubject.replace(/#img#/g,'<input type="text" readonly="readonly" maxlength="2147483647" size="20" value="">');
		}else{
			var qsubject = res.datas.simpleQue.subject;
		}
		if(res.datas.quetype == 'C'){
			var choicestr = [];
			for(var j=0;j<res.datas.simpleQue.options.length;j++){
				if(/ebh_1_data-latexebh_2_/.test(res.datas.simpleQue.options[j])){
				  var bsubjecthtml = unescape(res.datas.simpleQue.options[j].replace(/ebh_1_/g,' ').replace(/ebh_2_/g,'='));
				  bsubjecthtml = '<img '+ bsubjecthtml +' />';
				   choicestr.push(bsubjecthtml);
				}else{
					choicestr.push(res.datas.simpleQue.options[j]);
				}
				
				
			}
			var  choicestr = choicestr.join(';&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); 
		}else{
			var choicestr = res.datas.simpleQue.answers;
		}
		var data = {
			keycode : 65,
			qid : res.datas.simpleQue.questionid,
			queType : res.datas.quetype,
			answers : choicestr,
			cwid: res.datas.simpleQue.cwid,
			options : res.datas.simpleQue.options,
			fenxi : res.datas.simpleQue.fenxi,  //分析
			resolve : res.datas.simpleQue.resolve, //解答
			dianpin : res.datas.simpleQue.dianpin, //点评
			source :res.datas.simpleQue.source,   //课件解析
			subject : qsubject,
			score : res.datas.simpleQue.score,
			answerDetaillist : res.datas.answerDetaillist
		};
		var $dom = $(template('t:answer',data));
		$(".work_mes").empty().append($dom);
		$('.work_mes br').remove()
		$('.radioBox label ').each(function(){
			$(this).text(String.fromCharCode($(this).attr('bid')));
		})
		$('.checkBox label ').each(function(){
			$(this).text(String.fromCharCode($(this).attr('bid')));
		})
		tabs(".ui-tabs-nav li",".ui-tabs-panel","workcurrent");
		tab('.lishnrt a','xhusre');
		var answerDetaillist = res.datas.answerDetaillist;
		var data = [];
		for(var i=0;i<answerDetaillist.length;i++){
			if(res.datas.quetype == 'A'){
				if(answerDetaillist[i].choiceStr == ''){
					answerDetaillist[i].choiceStr = '没填';	
				}
			}else if(res.datas.quetype == 'D'){
				if(answerDetaillist[i].choiceStr == '10'){
					answerDetaillist[i].choiceStr = '对';
					answerDetaillist[i].choiceOriStr = '10';
				}else if(answerDetaillist[i].choiceStr == '01'){
					answerDetaillist[i].choiceStr = '错';
					answerDetaillist[i].choiceOriStr = '01';
				}else{
					answerDetaillist[i].choiceStr = '没填';
					answerDetaillist[i].choiceOriStr = '00';
				}
			}
			data.push([answerDetaillist[i].choiceStr,answerDetaillist[i].count])
		}
		for(var i=0;i<1;i++){
			getanswersbyChoice(res.datas.simpleQue.questionid,res.datas.quetype,answerDetaillist[i].choiceOriStr);
		}
		$('#containerDx').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: ''
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	 		plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                    style: {
	                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                    }
	                }
	            }
	        },
	        credits:{
			     enabled:false // 禁用版权信息
			},
	        series: [{
	            type: 'pie',
	            name: '学生答案',
	            data:data
	        }]
	    });
	}
	
	function getanswersbyChoice(qid,quetype,choicestr){  //学生列表数据请求
		$.ajax({
			url:'/troomv2/examv2/getanswersbyChoice.html',
			method:'post',
			dataType:'json',
			data : {
				qid : qid,
				choicestr :choicestr,
				classid:classid
			}
		}).done(function(res){
			stutantListparse(res,quetype);
		}).fail(function(){
			console.log('req err');
		});
		
	}
	function stutantListparse(res,quetype){ //错题排行学生列表答案转换
		$('.workdata').empty();
		var answerList = res.answerList;
		for(var i=0;i<answerList.length;i++){
			if(quetype == 'A'){
				if(answerList[i].choicestr ==''){
					answerList[i].choicestr = '<span style="font-size:25px!important;">没填</span>';
				}
			}else if(quetype == 'D'){
				if(answerList[i].choicestr =='A'){
					answerList[i].choicestr = '对';
				}else if(answerList[i].choicestr =='B'){
					answerList[i].choicestr = '错';
				}else{
					answerList[i].choicestr = '<span style="font-size:25px!important;">没填</span>';
				}
			}
		}
		template.helper("substrinreal", function(a){
			if(a.length > 4){
				a = a.substring(0,3) + '...';
			}else{
				a =a;
			}
			return a;
		});
		if(quetype == 'A' ||quetype == 'D'){
			var result = [];
			
			var data = {
			   		quetype:quetype,
					result : answerList,
					eid:eid
			}
			var $dom = $(template('t:tab',data));
			$(".workdata").append($dom);
			$('.workdata').append(res.pagestr)
			$('.studentBox:last').css('border-bottom','none');
		}else{
			for(var i=0,len=answerList.length;i<len;i+=10){
				var result = [];
			   	result.push(answerList.slice(i,i+10)[0]);
			   	var data = {
			   		quetype:quetype,
					result : result
				}
				var $dom = $(template('t:tab',data));
				$(".workdata").append($dom);
				$('.workdata').append(res.pagestr)
				$('.studentBox:last').css('border-bottom','none');
			}
		}
		
	
	}
	function getLocalTime(nS) {     
	    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
	}
	Number.prototype.toPercent = function(){
		return (Math.round(this * 10000)/100).toFixed(1) + '%';
	}   
	function inpfocus(inp){
		var inpf = $(inp);
		if(inpf.val() == '请输入学生姓名'){
			inpf.attr('value','');
		}
	}
	function tab(tobj,cls){
		$(tobj).each(function(){
		 	$(this).on('click',function(){
		 		$(tobj).removeClass(cls);
				$(this).addClass(cls);
		 	})
		 	
		})
		} 
	function subPercentage(Percentage,bol){
		if(!Percentage){
			Percentage = 0;
		}
		var  Percent = parseInt(Percentage);
		if(!Percent){
			Percent = 0;
		}
		if(bol){
			return  Percent + '%';
		}else{
			return  Percent;
		}
	}
	function tabs(cls,ind,active){
	    $(cls).click(function(){
	        $(cls).eq($(this).index()).addClass(active).siblings().removeClass(active);
			$(ind).hide().eq($(this).index()).show();
		})
	}
	
	function numtostr(num,bol) {
		var nums = [];
		var sstr = [];
		if(bol){
			var str = 'ABCDEFGHIJKLMNOPQ';
		}else{
			var str = '对错';	
		}
		for(var i=0;i<num.length;i++){
				nums.push(num[i]);
				if(num[i] == '1'){
				  sstr.push(str[i]);
				}
			}
		var sstr = sstr.join(',');
		return sstr;
	  }
	function classlistonclick(){
		geterror_rank(eid);
		$('.classlist a').each(function(){
			$(this).click(function(){
				$('.classlist a').removeClass('active');
				$(this).addClass('active');
				classid = $(this).attr('classid');
				geterror_rank(eid);
				getExamSummaryAjax();
			})
		})
	}
	function GetQueryString(name) {
	    var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
	    var r = window.location.search.substr(1).match(reg);
	    if (r != null) {
	        return unescape(r[2]);
	    }
	    return null;
	}
	$('.stuList').live('hover',function(){
		$(this).toggleClass('stuListhover');
	})
	$(function(){
		//判断实时作业进入
		var urlSign = top.location.search;
		if(urlSign == "?soft=true"){
			$(".lefrig").css("margin",0);
			$("#header").hide();
		}
		getclass();
		$('.datatab tr:last td').css('border-bottom','none');
	})
</script>
</body>
</html>
