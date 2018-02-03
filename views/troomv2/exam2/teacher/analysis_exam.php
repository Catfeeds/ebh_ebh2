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
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css<?=$v?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/global.css<?=$v?>" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wussyu.css<?=$v?>"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/layout.css<?=$v?>"/>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>"/>
    
    <script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js<?=$v?>"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js<?=$v?>"></script>
	<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-more.js<?=$v?>"></script>
   	
    <title>统计分析</title>
	<style>
	html{width: 100%; height: 100%;}
	body {
		min-height: 100%;
		background: #f3f3f3;
		font-family: 微软雅黑!important;
	}
	.workdata{min-height: 400px;}
	.imgyuan {
		width: 50px;
	}
	.Havepay {
		width: 410px;
		position: relative;
		height: 55px;
		float: left;
		line-height: 25px;
	}
	.Havepay div img {
		margin: 0 3px;
	}
	.Havepay .offR,
	.Havepay .onR {
		position: absolute;
		top: 0;
		left: 0;
	}
	.onTxt {
		position: absolute;
		left: 320px;
	}
	.dsiters {
		margin-top: 90px;
		width: 600px;
	}
	.Havepay .onR img {
		display: none;
	}
	.averageTime {
		width: 180px;
		height: 55px;
		background: url(http://static.ebanhui.com/exam/images/Alarm.jpg) no-repeat;
		padding-left: 56px;
		float: left;
		margin-left: 10px;
	}
	.soulico {
		float: left;
		background: url(http://static.ebanhui.com/ebh/tpl/2014/images/newsolico.jpg) no-repeat;
		height: 24px;
		width: 26px;
		border: none;
		cursor: pointer;
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
	
	a.revise {
		float: left;
		background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/xiugai.png) no-repeat;
		width: 26px;
		height: 27px;
		margin-left: 12px;
	}
	
	a.shansge {
		margin-left: 25px;
	}
	
	.lefrig {
		float: none;
		margin: 0 auto;
	}
	
	a.waskes {
		margin-left: 70px;
	}
	
	a.remind {
		margin-left: 10px;
		color: cornflowerblue;
	}
	
	div.work_mes,
	div.workdata {
		position: relative;
	}
	
	div.work_mes {
		height: auto;
		float: none!important;
	}
	
	.extendul {
		height: 42px;
		border-bottom: solid 1px #e3e3e3;
	}
	
	.mk_j_num,
	.mk_y_time {
		color: #ed5468;
		font-size: 30px;
		font-weight: 500;
		line-height: 30px;
	}
	
	.ui-tabs-hide {
		display: none;
	}
	
	.completetimebP i {
		background-position: 0px -8px;
	}
	/*分页*/
	
	.pages {
		height: 50px;
		padding-top: 15px;
		padding-right: 20px;
		float: right;
	}
	
	.listPage {
		height: 30px;
		text-align: center;
		margin: 0 auto;
	}
	
	.listPage a {
		background: #f9f9f9;
		border: 1px solid #f9f9f9;
		display: inline-block;
		font-weight: bold;
		height: 26px;
		line-height: 26px;
		margin: 0 2px;
		text-align: center;
		width: 30px;
		color: #767676!important;
		text-decoration: none;
	}
	
	.listPage a:visited {
		background: #f9f9f9;
		border: 1px solid #f9f9f9;
		display: block;
		float: left;
		height: 26px;
		line-height: 26px;
		margin: 0 2px;
		text-align: center;
		width: 30px;
		color: #323232;
		text-decoration: none;
	}
	
	.listPage a:Hover {
		border: 1px solid #0CA6DF;
		text-decoration: none;
	}
	
	.listPage .none {
		border: 1px solid #23a1f2;
		background: #23a1f2;
		color: #FFFFFF!important;
		font-weight: bold;
	}
	
	#next {
		width: 66px;
		height: 26px;
	}
	
	#gopage {
		width: 26px;
		padding: 3px 2px;
		border: 1px solid #CCCCCC;
		font-size: 12px;
		text-align: center;
		float: left;
	}
	
	#page_go {
		width: 45px;
		height: 20px;
	}
	
	.lishnrt1 {
		padding: 10px 20px;
		position: relative;
		height: 35px;
		width: 1000px;
		font-size: 13px;
		float: left;
	}
	
	table.table {
		font-size: 11px;
		color: #333333;
		border-width: 1px;
		border-color: #666666;
		border-collapse: collapse;
		margin-left: 20px;
	}
	
	table.table th {
		border-width: 1px;
		border-style: solid;
		border-color: #c2d3f1;
		background-color: #e4ebf5;
		text-align: center;
	}
	table.table tr{
		height: 45px;
	}
	table.table td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #c2d3f1;
		background-color: #ffffff;
		text-align: center;
	}
	
	.boxF {
		padding-top: 30px;
		padding-bottom: 50px;
	}
	
	.boxF h1 {
		display: block;
		width: 100%;
		height: 18px;
		font-size: 18px;
		line-height: 18px;
		margin-bottom: 10px;
		padding-left: 10px;
	}
	
	.boxF h1 i {
		display: inline-block;
		width: 3px;
		height: 15px;
		background: #5c96f7;
		margin: 2px 10px 0 10px;
	}
	
	.workdata1 {
		width: 100%;
	}
	
	.PressT,
	.PressZ {
		display: block;
		width: 100%;
		height: 18px;
		font-size: 18px;
		line-height: 18px;
		margin-top: 10px;
		padding: 10px;
	}
	
	.PressT i,
	.PressZ i {
		display: inline-block;
		width: 3px;
		height: 15px;
		background: #5c96f7;
		margin: 2px 10px 0 10px;
	}
	.ksrdgae{
		margin: 0 20px;
		float: none;
	}
	.datatab td{
		border-bottom: none;
		border: none;
		    border-bottom: 1px solid #f5f5f5;
	    border-top: none;
	    color: #666;
	    font-size: 13px;
	    padding: 10px 10px 10px 20px;
	}
	.datatab a{
	    color: #fff;
	}
	.datatab tr{
		border-bottom: 1px solid #EFEFEF;
	}
	.datatab tr.first{
		border-bottom:none;
	}
	.datatab tr:last-child{
		border-bottom:none;
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
	.stulist{
		margin-top: 10px;
	}
	.stulist .stuLists {
	    width: 180px;
	    height: 54px;
	    margin: 0px 10px 10px 10px;
	    display: inline-block;
	}
	.stulist .ghjut {
	    width: 118px;
	    margin: 3px 0 0 10px;
	    line-height: 24px;
	}
	.que{
		padding: 0px 10px;
		margin: 10px 0px;
		float: left;
	}
	.que .left{
		width: 550px;
		float: left;
	}
	.que:first-child{
		border: none;
	}
	.chart{
		width: 415px;
	    float: left;
	    height: 350px;
	}
	.progress{
		width: 415px;
	    float: left;
	    height: 150px;
	}
	.progress .progressalert{
		height: 50px;
   	 	margin-top: 20px;
   	 	margin-left: 10px;
	}
	.progress .progresscont{
		width: 300px;
		height: 24px;
		border-radius: 10px;
		background: #cccccc;
		overflow: hidden;
		margin-left: 10px;
		position: relative;
		
	}
	.progress .progresscont .progresstrue{
		position: absolute;
		height: 24px;
		width: 200px;
		background: #5e96f5;
		border-radius: 10px;
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
		<div class="fl" style="width: 100%;">
			<div>
				<p class="kishre" style="width: 100%; text-align: center;"><span class="ksrdgae pusTime">布置时间：</span><span class="ksrdgae scorelab">总分：</span><span class="ksrdgae limittime">计时：分钟</span></p>
				<div style="width: 100%;" class='classlist'>
				
				</div>
				<div class="clear"></div>
			</div>
			<div class="fl" style="height: 100%; width: 400px; overflow: hidden;">
				<div id='container1' class="fl" style="height: 250px;width:380px;">

				</div>
			</div>
			<div style="width: 600px;height: 100%;background: #fff;" class="fl">
				
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
							已交 <span class="mk_y_num">20</span>/<span class="mk_q_num">---</span><br />
							<p class="mk_j_num">---</p>
						</div>

					</div>
					<div class="averageTime">
						<div>
							平均答题时间<br />
							<p class="mk_y_time">---</p>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="work_mes">
			<ul class="extendul ui-tabs-nav">
				<li type="quetype" onclick="getfenxi('quetype',1)" class="workcurrent">
					<a href="javascript:;">得分情况</a>
				</li>
				<li type="que" onclick="getfenxi('que',1)">
					<a href="#">每题分析</a>
				</li>
				<li  type="getexam" onclick="getElist()">
					<a href="#">学生成绩单</a>
				</li>
				<li  type="" onclick="getnoElist()">
					<a href="#">未交学生</a>
				</li>
			</ul>
			<div class="fl ui-tabs-panel">
				<div class="lishnrt">
					<a href="javascript:void(0);" value='0' class="hietse xhusre" onclick="getfenxi('quetype',1)">按题型</a>
					<a href="javascript:void(0);" value='1' class="hietse " onclick="getfenxi('relationship',1)">按知识点</a>
					<a href="javascript:void(0);" value='2' class="hietse " onclick="getfenxi('level',1)">学生优秀率</a>
				</div>
				<div class="workdata quetype fl" style="margin-top:0;">

				</div>

			</div>
			<div class="fl ui-tabs-panel ui-tabs-hide">
				<div class="lishnrt1">
					<a href="javascript:void(0);" value='0' onclick="getfenxi('que',1)" class="hietse xhusre">表格分析</a>
					<a href="javascript:void(0);" value='1' onclick="getfenxi('que',2)" class="hietse ">雷达图分析</a>
					<a href="javascript:void(0);" value='2' onclick="getanswerCount()" class="hietse ">饼图分析</a>
				</div>
				<div class="workdata quenew fl" style="margin-top:0;">

				</div>
			</div>
			<div class="fl ui-tabs-panel ui-tabs-hide">
				<div class="workdata fl" style="margin-top:0;">

					<table class="datatab" width="100%" cellspacing="0" cellpadding="0" style="border:none;">
						<tr class="first">
							<td width="25%">个人信息</td>
							<td width="20%" style="text-align: center;">提交时间</td>
							<td width="20%" style="text-align: center;">答题时间</td>
							<td width="10%" class="totalscore completetimebP" style="text-align: center;cursor:pointer;">得分<i></i></td>
							<td width="25%" style="text-align: center;">操作</td>
						</tr>
					</table>
					<div id="mpage"></div>
					<div class="nodatacont"></div>
				</div>
			</div>
			<div class="fl ui-tabs-panel ui-tabs-hide">
				<div class="workdata fl" style="margin-top:0;">
					<div class="stulist">
						
					</div>
					<div id="npage"></div>
				</div>
			</div>
		</div>

	</div>
</div>
<script type="text/html" id="t:answerpie">
	<%if(queType == 'A'){%>
		<div class="que singleContainer singleContainerFocused">
			<div class="left">
				<div class="subjectPane">
					<span class="stIndex" style="float:left;"><%=index+1%>. </span>
					<span class="inputBox" style="float:left; width:500px;"><%=#subject%>（<span class="userAnsLabel" id="txtanswer" style="color:blue;font-weight:bold;padding:0 8px;"></span>）<em class="sorceLabel">[<%=score%>分]</em><span style="color: #5e96f5;">[单选题]</span></span>
					<span class="clearing"></span>
				</div>
				<div class="radioPane">
					<ul style="overflow: hidden;">
						<% for(var i=0;i< options.length;i++){%>
						<li class="radioBox" style="width: 100%;">
							<p class="radioWrapper" style="display:block; float:left;width:25px;">
							<span class="jqTransformRadioWrapper">
								<label style="cursor:pointer;" bid="<%=keycode+i%>"></label>
							</p>
							<span class="optionContent" style="display: block; margin-left: 26px;    width: 470px; word-break: break-all;"><%=#options[i]%></span>
							<span class="clearing"></span>
						</li>
						<%}%>						
					</ul>
				</div>
		       <!-- <div class="answerBar">正确答案：<span class="answerLabel"><%=answers%></span></div>-->
			</div>
			<div id="containers<%=qid%>" class="chart"></div>
		</div>
		
	<%}else if(queType == 'D'){%>
		<div class="que singleContainer singleContainerFocused">
			<div class="left">
				<div class="questionContainer">
		            <div class="subjectPane">
			            <span class="stIndex" style="float:left;"><%=index+1%>. </span>
			            <span class="inputBox" style="float:left; width:500px;">
			            <%=#subject%>
			            <em class="sorceLabel">[<%=score%>分]</em><span style="color: #5e96f5;">[判断题]</span></span>
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
		       <!-- <div class="answerBar">正确答案：<span class="answerLabel"><%=answers=='1'?'对':'错'%></span></div>-->
	        </div> 
	       <!-- <div id="progress<%=qid%>" class="progress">
	        	<div class="progressalert">
	     			<p><span style="float: left;">对 ： <%=truebf%>%</span><span style="    float: right; margin-right: 108px;">错 ： <%=falsebf%>%</span></p>
	        	</div>
	        	<div class="progresscont">
	     			<div class="progresstrue"></div>
	        	</div>
	        </div> -->
	        <div id="containers<%=qid%>" class="chart"></div>
	    </div>
	<%}%>
</script>
<script type="text/html" id="t:answer">
	 <tr class="">
        <td style="word-break: break-all; word-wrap:break-word;">
            <a title="" href="javascript:;" style="float:left;">
            	<% if(face == ''){%>
            		<% if(sex == '0'){ %>
	                <img class="imgyuan" src="http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg">
	                <%}else if(sex == '1'){%>
	                <img class="imgyuan" src="http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg">
	                <%}%>
            	<%}else{%>
            		<img class="imgyuan" src="<%=face%>">	
            	<%}%>
            	
                
            </a>
            <p class="ghjut" style="width:160px">
            	<%=realname%>
            	
            	<% if(sex == '0'){ %>
		            	<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png">
		            <%}else if(sex == '1'){%>
		            	<img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png">	
		            <%}%>
            	
            </p>
            <p class="ghjut" style="width:160px;color:#999;"><%=username%></p>
        </td>
        <td>
            <p><%=ansdateline%></p>
            <p style="color:#999;" title=""></p>
        </td>
        <td style="text-align: center;"><%=usedtime%>分钟</td>
        <td style="text-align: center;"><%=anstotalscore%>分</td>
        <td>
      
             <a class="waskes" href="/troomv2/examv2/eview/<%=userAnswer%>.html?eid=<%=eid%>" target="_blank">查看</a>
			
        </td>
    </tr>
</script>
<script type="text/html" id="t:que">
	<%if(bolALL == 1){ %>
	<% if(bolA == 1){%>
		<div class="boxF">
	    	<h1><i></i>选择题</h1>
	    	<table  class="table">
				<tr>
					<th width="50">序号</th>
					<th width="80">题号</th>
					<th width="80">答案</th>
					<th width="50">分值</th>
					<th width="80">平均得分</th>
					<th width="80">总人数</th>
					<th width="80">正答数</th>
					<th width="80">正答率</th>
					<th width="60">选A</th>
					<th width="60">选B</th>
					<th width="60">选C</th>
					<th width="60">选D</th>
					<th width="60">选E</th>
					<th width="60">选F</th>
				</tr>
		    <%for(var i=0;i<efenxiA.length;i++){%>
			    <% if(efenxiA[i].qtype == 'A' || efenxiA[i].qtype == 'B'){%>		
				<tr>
					<td><%=i +1%></td> 
					<td><%=efenxiA[i].quecount%></td> 
					<td><%=efenxiA[i].rightchoice%></td> 
					<td><%=efenxiA[i].quescore%></td> 
					<td><%=efenxiA[i].avgscore%></td> 
					<td><%=efenxiA[i].usercount%></td> 
					<td><%=efenxiA[i].rightcount%></td> 
					<td><%=subPercentage(efenxiA[i].rightrat)%></td> 
					<td><%=efenxiA[i].choicemap.A%></td> 
					<td><%=efenxiA[i].choicemap.B%></td> 
					<td><%=efenxiA[i].choicemap.C%></td> 
					<td><%=efenxiA[i].choicemap.D%></td> 
					<td><%=efenxiA[i].choicemap.E%></td> 
					<td><%=efenxiA[i].choicemap.F%></td> 
					
				</tr>
				<%}%>
			<%}%>
				<tr>
					<td></td> 
					<td>选择题小计</td> 
					<td></td> 
					<td><%=BgsorceA%></td> 
					<td><%=BgavgscoreA%></td> 
					<td></td> 
					<td></td> 
					<td></td> 
					<td></td> 
					<td></td> 
					<td></td> 
					<td></td> 
					<td></td> 
					<td></td> 
				</tr>
			</table>
		</div>
	<%}%>
	<% if(bolD == 1){%>
		<div class="boxF">
	    	<h1><i></i>判断题</h1>
	    	<table class="table">
				<tr >
					<th width="50">序号</th>
					<th width="80">题号</th>
					<th width="80">答案</th>
					<th width="50">分值</th>
					<th width="80">平均得分</th>
					<th width="80">总人数</th>
					<th width="80">选对</th>
					<th width="80">选错</th>
					<th width="80">正确数</th>
				</tr>
			<%for(var i=0;i<efenxiD.length;i++){%>
			    <% if(efenxiD[i].qtype == 'D'){%>	
			    <tr>
			    	<td><%=i+1%></td>
			    	<td><%=efenxiD[i].quecount%></td>
			    	<%if(efenxiD[i].rightchoice == 'A'){%>
			    		<td>√</td>
			    	<%}else{%>
			    		<td>×</td>
			    	<%}%>	
			    	
			    	<td><%=efenxiD[i].quescore%></td>
			    	<td><%=efenxiD[i].avgscore%></td>
			    	<td><%=efenxiD[i].usercount%></td>
			    	<td><%=efenxiD[i].choicemap.A%></td>
			    	<td><%=efenxiD[i].choicemap.B%></td>
			    	<td><%=efenxiD[i].rightcount%></td>
			    </tr>
			    <%}%>
			<%}%>
				<tr>
					<td></td> 
					<td>判断题小计</td> 
					<td></td> 
					<td><%=BgsorceD%></td> 
					<td><%=BgavgscoreD%></td> 
					<td></td> 
					<td></td> 
					<td></td> 
					<td></td>
					
				</tr>	
			</table>
		</div>
	<%}%>
	<% if(bolH == 1){%>
		<div class="boxF">
	    	<h1><i></i>主观题</h1>
	    	<table class="table">
				<tr>
					<th width="50">序号</th>
					<th width="80">题号</th>
					<th width="80">分值</th>
					<th width="80">平均得分</th>
					<th width="80">得分率</th>
				</tr>
			<%for(var i=0;i<efenxiH.length;i++){%>
			    <% if(efenxiH[i].qtype == 'H'){%>	
			    <tr>
			    	<td><%=i+1%></td>
			    	<td><%=efenxiH[i].quecount%></td>
			    	<td><%=efenxiH[i].quescore%></td>
			    	<td><%=efenxiH[i].avgscore%></td>
			    	<td><%=subPercentage(efenxiH[i].avgscore/efenxiH[i].quescore)%></td>
			    </tr>
			    <%}%>
			<%}%>	
				<tr>
			    	<td><%=%></td>
			    	<td>主观题小计</td>
			    	<td><%=BgsorceH%></td> 
					<td><%= BgavgscoreH%></td> 
			    	<td><%=Bgtrat%></td>
			    	
			    </tr>
			</table>
		</div>
	<%}%>
	<%}else{%>
		<div class="cmain_bottom " style="width: 100%; min-height: 400px;">
			<div class="study" style="margin: 0 auto; width: 205px;">
				<div class="nodata"></div>
				<p class="zwktrykc" style="text-align: center;"></p>
			</div>
		</div>
	<%}%>
</script>
<script type="text/javascript">
	var classids = $.parseJSON(GetQueryString('classids')) || [];
	var classid = [];
	var manNum = 0;
	function getanswerCount(){  //试题内容数据请求
		  $.ajax({
			url:'/troomv2/examv2/answerCount.html',
			method:'post',
			dataType:'json',
			data : {
				eid : eid ,
				quetype : ['A','D'],
				classid:classid
			}
		}).done(function(res){
			var answercounts = res.datas.answerMapList;
			if(answercounts.length){
				answerparse(res);
			}else{
				var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
						'<div class="study" style="margin: 0 auto; width: 205px;">' +
							'<div class="nodata"></div>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
		        	$('.quenew').empty().append(cmain_bottom);
			}
			
			
		}).fail(function(){
		});
		 
	}
		function answerparse(res){   //试题内容解析
			var answercounts =  res.datas.answerMapList;
			$(".quenew").empty();
			for(var i=0;i<answercounts.length;i++){
				var quetype = answercounts[i].simpleQue.quetype;
				var answerDetaillist =  answercounts[i].answerDetaillist;
				if(!answerDetaillist.length){
					var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
						'<div class="study" style="margin: 0 auto; width: 205px;">' +
							'<div class="nodata"></div>'+
							'<p class="zwktrykc" style="text-align: center;"></p>'+
						'</div>'+
		        	'</div>';
		        	$('.quenew').empty().append(cmain_bottom);
		        	return false;
				}
				
				var qid = answercounts[i].simpleQue.qid;
				for(var j=0;j<answerDetaillist.length;j++){
					if(quetype == 'A'){
						answerDetaillist[j].choiceStrs =  numtostr(answerDetaillist[j].choiceStr,1)==''?'未填':numtostr(answerDetaillist[j].choiceStr,1);
					}else if(quetype == 'D'){
						answerDetaillist[j].choiceStrs =  numtostr(answerDetaillist[j].choiceStr,0)== ''?'未填':numtostr(answerDetaillist[j].choiceStr,0);
					}	
				}
				var qsubject = answercounts[i].simpleQue.qsubject;
				if(quetype == 'A'){
					var choicestr = numtostr(answercounts[i].simpleQue.choicestr,1);
				}else if(quetype == 'D'){
					var choicestr = numtostr(answercounts[i].simpleQue.choicestr,0);
				}
				var extdata = jQuery.parseJSON(answercounts[i].simpleQue.extdata);
				var truebf = 0;
				var falsebf = 0;
				var nobf = 0;
				/*if(quetype == 'D'){
					var allcount = 0;
					var truecount = 0;
					var falsecount = 0;
					for(var j=0;j<answerDetaillist.length;j++){
						allcount += answerDetaillist[j].count;
						if(answerDetaillist[j].choiceStr == "10"){
							truecount =  answerDetaillist[j].count;
						}else if(answerDetaillist[j].choiceStr == "01"){
							falsecount += answerDetaillist[j].count;
						}else{
							nobf += answerDetaillist[j].count;
						}
					}
					truebf =  truecount?parseFloat((truecount/allcount),1)*100:0;
					falsebf =  falsecount?parseFloat((falsecount/allcount),1)*100:0; 
					
				}*/
				var data = {
					index : i,
					keycode : 65,
					qid : qid,
					queType : answercounts[i].simpleQue.quetype,
					answers : choicestr,
					quetypename : answercounts[i].simpleQue.quetypename,
					options : extdata.options,
					fenxi : extdata.fenxi,  //分析
					resolve : extdata.resolve, //解答
					dianpin : extdata.dianpin, //点评
					source :extdata.source,   //课件解析
					subject : qsubject,
					score : answercounts[i].simpleQue.quescore,
					answerDetaillist : answerDetaillist,
					truebf :truebf,
					falsebf : falsebf
				};
				var $dom = $(template('t:answerpie',data));
				$(".quenew").append($dom);
				//if(quetype == 'A'){
					highchartpie(answerDetaillist,qid)
				//}else{
				//	var truewidth = truebf?(3*truebf):0;
				//	$('#progress'+qid+' .progresstrue').css('width',truewidth+'px')
				//}
				
			}
			$('.radioBox label ').each(function(){
				$(this).text(String.fromCharCode($(this).attr('bid')) + ':');
			})
			
			
			
		
	}
	function highchartpie(answerDetaillist,qid){
		var data = [];
		for(var i=0;i<answerDetaillist.length;i++){
			data.push([answerDetaillist[i].choiceStrs,answerDetaillist[i].count])
		}
		
		$('#containers'+qid).highcharts({
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,
		            plotShadow: false
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		        	 headerFormat: '',
		            pointFormat: '<b>{point.name} : {point.y}人 {point.percentage:.1f} % </b>'
		        },
		 		plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                size : 180,
		                dataLabels: {
		                	//{point.y}人
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
   	function getfenxi(bytype,type,url){
   		if(typeof url == "undefined") {
			url = '/troomv2/examv2/efenxiAjax.html';
		}
		$.ajax({	
			url:url,
			method:'post',
			dataType:'json',
			data:{
				'eid' : eid,
				'bytype' : bytype,
				'classid':classid
			}
		}).done(function(res){
			parseT(res,bytype,type)
		}).fail(function(){});
		
	}
	
	function parseT(res,bytype,type){
		if(bytype == 'que'){
			var efenxi = res.datas.efenxi;
			if(efenxi.length){
				if(type == 1){
					var bolALL = 0;
					var bolA = 0;
					var bolD = 0;
					var bolH = 0;
					var BgsorceA = 0;var BgsorceD = 0;var BgsorceH = 0;
					var BgavgscoreA = 0;var BgavgscoreD = 0;var BgavgscoreH = 0;
					var Bgtrat = 0;
					var efenxiA = [];var efenxiD = [];var efenxiH = [];
					for(var i=0;i<efenxi.length;i++){
						if(efenxi[i].qtype == 'A' || efenxi[i].qtype == 'B'){
							bolA = 1;
							BgsorceA += efenxi[i].quescore;
							BgavgscoreA += efenxi[i].avgscore;
							efenxiA.push(efenxi[i])
						}else if(efenxi[i].qtype == 'D'){
							bolD = 1;
							BgsorceD += efenxi[i].quescore;
							BgavgscoreD += efenxi[i].avgscore;
							efenxiD.push(efenxi[i])
						}else if(efenxi[i].qtype == 'H'){
							bolH = 1;
							BgsorceH += efenxi[i].quescore;
							BgavgscoreH += efenxi[i].avgscore;
							efenxiH.push(efenxi[i])
							Bgtrat =Math.round((BgavgscoreH/BgsorceH)*100) + '%';
						}
						if(efenxi[i].qtype == 'A' || efenxi[i].qtype == 'B' || efenxi[i].qtype == 'D' ||efenxi[i].qtype == 'H'){
							bolALL = 1;
						}
					}
					template.helper("subPercentage", function(a){
						var a = a == 'NaN'?0:a;
						return Math.round(a*100) + '%';
			       });  
					var data = {
						'bolALL' : bolALL,
						'efenxi' : efenxi,
						'bolA': bolA,
						'bolD': bolD,
						'bolH': bolH,
						'efenxiA': efenxiA,
						'efenxiD': efenxiD,
						'efenxiH':efenxiH,
						'Bgtrat':Bgtrat,
						'BgsorceA': (Math.round(BgsorceA*10))/10,
						'BgavgscoreA' :(Math.round(BgavgscoreA*10))/10,
						'BgsorceD': (Math.round(BgsorceD*10))/10,
						'BgavgscoreD' :(Math.round(BgavgscoreD*10))/10,
						'BgsorceH': (Math.round(BgsorceH*10))/10,
						'BgavgscoreH' :(Math.round(BgavgscoreH*10))/10
					}
					var $dom = $(template('t:que',data));
					$('.quenew').empty().append($dom);
				}else if(type == 2){
				var $dom =	'<h1 class="PressT"><i></i>按题号</h1>' +
					'<div id="containerT" style="min-width: 400px; width: 1000px; height: 600px; margin: 0 auto"></div>'+
					'<h1 class="PressZ"><i></i>按知识点</h1>' +
					'<div id="containerZ" style="min-width: 400px; width: 1000px; height: 600px; margin: 0 auto"></div>';
					
					$('.quenew').empty().append($dom);
					var  categoriesT =[];
					var  categoriesZ =[];
					var  dataF = [];
					var  dataP = [];
					for(var i=0;i<efenxi.length;i++){
						var dataFstr = efenxi[i].quescore;
						var dataPstr = efenxi[i].avgscore;
						if(efenxi[i].qtype == 'A'||efenxi[i].qtype == 'B'){
							var categories = '选择题'+ parseFloat(i+1);
						}else if(efenxi[i].qtype == 'D'){
							var categories = '判断题'+ parseFloat(i+1);
						}else if(efenxi[i].qtype == 'C'){
							var categories = '填空题'+ parseFloat(i+1);
						}else if(efenxi[i].qtype == 'H'){
							var categories = '主观题'+ parseFloat(i+1);
						}else if(efenxi[i].qtype == 'E'){
					   		var categories = '文字题'+ parseFloat(i+1);
			   			}else if(efenxi[i].qtype == 'XWX'){
			   				var categories = '完型填空'+ parseFloat(i+1);
			   			}else if(efenxi[i].qtype == 'XTL'){
			   				var categories = '听力题'+ parseFloat(i+1);
			   			}else if(efenxi[i].qtype == 'XYD'){
			   				var categories = '阅读理解'+ parseFloat(i+1);
		   				}else if(efenxi[i].qtype == 'XZH'){
		   					var categories = '组合题'+ parseFloat(i+1);
		   					
						}
						categoriesT.push(categories);
						dataF.push(dataFstr);
						dataP.push(dataPstr)
					}
					$('#containerT').highcharts({
				        chart: {
				            polar: true,
				            type: 'line'
				        },
				        title: {
				            text: '',
				            x: -80
				        },
				        pane: {
				            size: '80%'
				        },
				        xAxis: {
				            categories: categoriesT,
				            tickmarkPlacement: 'on',
				            lineWidth: 0
				        },
				        yAxis: {
				            gridLineInterpolation: 'polygon',
				            lineWidth: 0,
				            min: 0
				        },
				        credits:{
				            enabled:false
				        },
				        tooltip: {
				            shared: true,
				            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.1f}</b><br/>'
				        },
				        legend: {
				            align: 'right',
				            verticalAlign: 'top',
				            y: 70,
				            layout: 'vertical'
				        },
				        series: [{
				            name: '分值',
				            data: dataF,
				            pointPlacement: 'on'
				        }, {
				            name: '平均得分',
				            data: dataP,
				            pointPlacement: 'on'
				        }]
				    });
				    
				    $.ajax({	
						url:'/troomv2/examv2/efenxiAjax.html',
						method:'post',
						dataType:'json',
						data:{
							'eid' : eid,
							'bytype' : 'relationship',
							'classid':classid
						}
					}).done(function(res){
						var efenxi = res.datas.efenxi;
						if(efenxi.length <=0){
							var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
								'<div class="study" style="margin: 0 auto; width: 205px;">' +
									'<div class="nodata"></div>'+
									'<p class="zwktrykc" style="text-align: center;"></p>'+
								'</div>'+
				        	'</div>';
				        	$('#containerZ').empty().append(cmain_bottom);
						}else{
						var quescore = [];
						var avgscore = [];
						var relationname = [];
						for(var i=0;i<efenxi.length;i++){
							var dataqstr = efenxi[i].quescore;
							var dataastr = efenxi[i].avgscore;
							var relation= efenxi[i].relationname;
							relationname.push(relation);
							quescore.push(dataqstr);
							avgscore.push(dataastr)
						}
						$('#containerZ').highcharts({
				        chart: {
				            polar: true,
				            type: 'line'
				        },
				        title: {
				            text: '',
				            x: -80
				        },
				        pane: {
				            size: '80%'
				        },
				        xAxis: {
				            categories: relationname,
				            tickmarkPlacement: 'on',
				            lineWidth: 0
				        },
				        yAxis: {
				            gridLineInterpolation: 'polygon',
				            lineWidth: 0,
				            min: 0
				        },
				        credits:{
				            enabled:false
				        },
				        tooltip: {
				            shared: true,
				            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.1f}</b><br/>'
				        },
				        legend: {
				            align: 'right',
				            verticalAlign: 'top',
				            y: 70,
				            layout: 'vertical'
				        },
				        series: [{
				            name: '分值',
				            data: quescore,
				            pointPlacement: 'on'
				        }, {
				            name: '平均得分',
				            data: avgscore,
				            pointPlacement: 'on'
				        }]
				    });
						}
						
					}).fail(function(){});
				   }
			}else{
				var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
					'<div class="study" style="margin: 0 auto; width: 205px;">' +
						'<div class="nodata"></div>'+
						'<p class="zwktrykc" style="text-align: center;"></p>'+
					'</div>'+
	        	'</div>';
	        	$('.quenew').empty().append(cmain_bottom);
			}
				
				
				  }else if(bytype == 'quetype'){
				   	var efenxi = res.datas.efenxi;
				   	if(!efenxi.length){
				   		var error = '<div class="nodata"></div>'
				   		$('.quetype').empty().append(error);
				   	}else{
				   		var quetypeTx =  '<div id="containerTx" style="min-width: 400px; width: 1000px; height: 250px; margin: 0 auto;  margin-top: 20px;"></div><div class="boxF"><table class="table" style="margin: 0 auto;" width="50%"><tr><td></td><th>分值</th><th>平均分</th><th>得分率</th></tr>';
			   		var vallScorce = 0;
			   		var vaverageScore = 0;
			   		for(var i=0;i<efenxi.length;i++){
				   		if(efenxi[i].queType != undefined){
				   			vallScorce += parseFloat(efenxi[i].allScorce);
			   				vaverageScore += parseFloat(efenxi[i].averageScore);
				   			quetypeTx +='<tr>' ;
							if(efenxi[i].queType == 'A'){
					   			quetypeTx +='<th>单选题</th>';
					   		}else if(efenxi[i].queType == 'B'){
					   			quetypeTx +='<th>多选题</th>';
					   		}else if(efenxi[i].queType == 'C'){
					   			quetypeTx +='<th>填空题</th>';
					   		}else if(efenxi[i].queType == 'D'){
					   			quetypeTx +='<th>判断题</th>';
					   		}else if(efenxi[i].queType == 'E'){
					   			quetypeTx +='<th>文字题</th>';
					   		}else if(efenxi[i].queType == 'H'){
					   			quetypeTx +='<th>主观题</th>';
					   		}else if(efenxi[i].queType == 'X'){
				   				quetypeTx +='<th>答题卡</th>';
				   			}else if(efenxi[i].queType == 'XWX'){
				   				quetypeTx +='<th>完型填空</th>';
				   			}else if(efenxi[i].queType == 'XTL'){
				   				quetypeTx +='<th>听力题</th>';
				   			}else if(efenxi[i].queType == 'XYD'){
				   				quetypeTx +='<th>阅读理解</th>';
			   				}else if(efenxi[i].queType == 'XZH'){
			   					quetypeTx +='<th>组合题</th>';
					   		};
		    				quetypeTx += '<td>'+(efenxi[i].allScorce || 0) +'</td>'+
		    				'<td>'+(efenxi[i].averageScore || 0) +'</td>'+
		    				'<td>'+ (Math.round((efenxi[i].scoreRate)*100)) +'%</td>'+
		    			'</tr>';
				   		}
				   	}
				  	quetypeTx +='<tr>'+
			    				'<th>总分</th>'+
			    				'<td>'+(vallScorce || 0) +'</td>'+
			    				'<td>'+((vaverageScore.toFixed(1)) || 0) +'</td>'+
			    				'<td>'+(Math.round((vaverageScore/vallScorce)*100)) +'%</td>'+
			    			'</tr>';
				    quetypeTx +=	'</table></div>';
				   		$('.quetype').empty().append(quetypeTx);
				   		var categories = [];
				   		var data = [];
				   		for(var i=0;i<efenxi.length;i++){	
				   			if(efenxi[i].queType == 'A'){
					   			efenxi[i].queType = '单选题';
					   		}else if(efenxi[i].queType == 'B'){
					   			efenxi[i].queType = '多选题';
					   		}else if(efenxi[i].queType == 'C'){
					   			efenxi[i].queType = '填空题';
					   		}else if(efenxi[i].queType == 'D'){
					   			efenxi[i].queType = '判断题';
					   		}else if(efenxi[i].queType == 'E'){
					   			efenxi[i].queType = '文字题';
					   		}else if(efenxi[i].queType == 'H'){
					   			efenxi[i].queType = '主观题';
					   		}else if(efenxi[i].queType == 'X'){
				   				efenxi[i].queType = '答题卡';
				   			}else if(efenxi[i].queType == 'XWX'){
				   				efenxi[i].queType = '完型填空';
				   			}else if(efenxi[i].queType == 'XTL'){
				   				efenxi[i].queType = '听力题';
				   			}else if(efenxi[i].queType == 'XYD'){
				   				efenxi[i].queType = '阅读理解';
			   				}else if(efenxi[i].queType == 'XZH'){
			   					efenxi[i].queType = '组合题';
					   		}else if(efenxi[i].queType == undefined){
					   			efenxi[i].queType = '总分';
					   		}
				   			categories.push(efenxi[i].queType);
				   			data.push(Math.round((efenxi[i].scoreRate)*100));
					   		$('#containerTx').highcharts({
						        chart: {
						            type: 'column'
						        },
						        
						        title: {
						            text: ''
						        },
						        xAxis: {
						            categories: categories
						        },
						        yAxis: {
						            min: 0,
						            title: {
						                text: '得<br>分<br>率<br>︵<br>%<br>︶',
						                rotation:0,
						                style:{
						                	fontSize: '15px',
						                	fontFamily:'微软雅黑',
						                	color:'#000'
						                }
						            },
						            tickPositions: [0, 25, 50,75, 100]
						        },
						        credits:{
								     enabled:false // 禁用版权信息
								},
						        tooltip: {
						            pointFormat: '<span style="">得分率</span>: <b>{point.y}%</b><br/>',
						            shared: true
						        },
						        plotOptions: {
									column: {
										ursor: 'pointer',
										point: {
											events: {
												click: function() {
												}
											}
										},
										stacking: 'percent'
									}
								},
						        legend:{
						        	enabled  : false
						        },
						        credits: {
								    // enabled:true,                    // 默认值，如果想去掉版权信息，设置为false即可
								    text: '题型',             // 显示的文字
								    href: 'javascript:void(0)',      // 链接地址
								    position: {                         // 位置设置 
								        align: 'right',
								        x: 0,
								        verticalAlign: 'bottom',
								        y: -20,
								        fontSize:'13px',
								        fontFamily:'微软雅黑'
								    },
								    style: {                            // 样式设置
								        cursor: 'pointer',
								        color: 'black',
								        fontSize: '12px'
								    }
								},
						        plotOptions: {
						                    series: {
						                        borderWidth: 0,
						                        dataLabels: {
						                            enabled: true,
						                            format: '{point.y}%'
						                        }
						                    }
						                },
						         series: [{
						            data: data
						        }]
						    });
				   		}
				   	} 		
				   }else if(bytype == 'level'){
				   	var efenxi = res.datas.efenxi;
				   	if(efenxi.length){
				   		var data = [];
		   			data.push(parseInt((efenxi[0].excellent/efenxi[0].totalcount)*100),parseInt((efenxi[0].good/efenxi[0].totalcount)*100),parseInt((efenxi[0].pass/efenxi[0].totalcount)*100),{
		   					y : parseInt((efenxi[0].fail/efenxi[0].totalcount)*100),
		   					color:"#ff0000"
		   				
		   				});
				   	for(var i=0;i<efenxi.length;i++){
			   			var excellent =  '<tr>'+
			    				'<th>优秀</th>'+
			    				'<td>'+efenxi[i].excellent +'</td>'+
			    				'<td>'+(efenxi[i].excellent/efenxi[i].totalcount || 0).toPercent() +'</td>'+
			    				'<td>'+efenxi[i].excellent  +'</td>'+
			    				'<td>'+  (efenxi[i].excellent/efenxi[i].totalcount || 0).toPercent() +'</td>'+
			    			'</tr>';
			   			var good =	'<tr>'+
			    				'<th>良好</th>'+
			    				'<td>'+efenxi[i].good +'</td>'+
			    				'<td>'+(efenxi[i].good/efenxi[i].totalcount || 0).toPercent() +'</td>'+
			    				'<td>'+(efenxi[i].excellent +efenxi[i].good ) +'</td>'+
			    				'<td>'+  ((efenxi[i].excellent +efenxi[i].good )/efenxi[i].totalcount || 0).toPercent() +'</td>'+
			    			'</tr>';
			   			var pass ='<tr>'+
			    				'<th>及格</th>'+
			    				'<td>'+efenxi[i].pass +'</td>'+
			    				'<td>'+(efenxi[i].pass/efenxi[i].totalcount || 0).toPercent()+'</td>'+
			    				'<td>'+(efenxi[i].excellent +efenxi[i].good + efenxi[i].pass) +'</td>'+
			    				'<td>'+  ((efenxi[i].excellent +efenxi[i].good + efenxi[i].pass)/efenxi[i].totalcount || 0).toPercent() +'</td>'+
			    			'</tr>';
			   			var  Fail ='<tr>'+
			    				'<th>不及格</th>'+
			    				'<td>'+efenxi[i].fail +'</td>'+
			    				'<td>'+(efenxi[i].fail/efenxi[i].totalcount|| 0).toPercent() +'</td>'+
			    				'<td>'+(efenxi[i].excellent +efenxi[i].good + efenxi[i].pass +efenxi[i].fail) +'</td>'+
			    				'<td>'+  ((efenxi[i].excellent +efenxi[i].good + efenxi[i].pass +efenxi[i].fail)/efenxi[i].totalcount || 0).toPercent() +'</td>'+
			    			'</tr>';
				  
				   	}
				   		var quetypeYx =  '<div id="containerYx" style="min-width: 400px; width: 1000px; height: 250px; margin: 0 auto;  margin-top: 20px;"></div><div class="boxF"><table class="table" style="margin: 0 auto;" width="60%"><tr><td></td><th>人数</th><th>比例</th><th>累计人数</th><th>累计比例</th></tr>'+ excellent + good +  pass+  Fail +'</table><p style="text-align:center;padding: 10px 0 30px 0;"><span style="color:red;">注：</span>后台判定得分90%以上为优秀;80%~90%为良好；60%~79%为及格；60%以下为不及格。</p></div>';
				   		$('.quetype').empty().append(quetypeYx);
				   		$('#containerYx').highcharts({
						        chart: {
						            type: 'column'
						        },
						        
						        title: {
						            text: ''
						        },
						        xAxis: {
						            categories: ['优秀','良好','及格','不及格']
						        },
						       
						        yAxis: {
						            min: 0,
						            title: {
						                text: '人<br>数<br>比<br>例<br>︵<br>%<br>︶',
						                rotation:0,
						                style:{
						                	fontSize: '15px',
						                	fontFamily:'微软雅黑',
						                	color:'#000'
						                }
						            },
						            tickPositions: [0, 25, 50,75, 100]
						        },
						        credits:{
								     enabled:false // 禁用版权信息
								},
						        tooltip: {
						            pointFormat: '<span>比例</span>: <b>{point.y}%</b><br/>',
						            shared: true
						        },
						        plotOptions: {
									column: {
										ursor: 'pointer',
										point: {
											events: {
												click: function() {
												}
											}
										}
									}
								},
						        legend:{
						        	enabled  : false
						        },
						        credits: {
								    // enabled:true,                    // 默认值，如果想去掉版权信息，设置为false即可
								    text: '优秀率',             // 显示的文字
								    href: 'javascript:void(0)',      // 链接地址
								    position: {                         // 位置设置 
								        align: 'right',
								        x: 0,
								        verticalAlign: 'bottom',
								        y: -20
								    },
								    style: {                            // 样式设置
								        cursor: 'pointer',
								        color: 'black',
								        fontSize: '12px'
								    }
								},
						        plotOptions: {
						                    series: {
						                        borderWidth: 0,
						                        dataLabels: {
						                            enabled: true,
						                            format: '{point.y}%'
						                        }
						                    }
						                },
						         series: [{
						            name: 'John',
						            data: data
						        }]
						    });
				   	}else{
				   		var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
							'<div class="study" style="margin: 0 auto; width: 205px;">' +
								'<div class="nodata"></div>'+
								'<p class="zwktrykc" style="text-align: center;"></p>'+
							'</div>'+
			        	'</div>';
			        	$('.quetype').empty().append(cmain_bottom);
				   	}
				   	
				   	
				   		
				   }else if(bytype == 'relationship'){
				   	var efenxi = res.datas.efenxi;
				  	if(efenxi.length <= 0  ){
				  		var cmain_bottom = '<div class="cmain_bottom " style="width: 100%; min-height: 400px;">' +
							'<div class="study" style="margin: 0 auto; width: 205px;">' +
								'<div class="nodata"></div>'+
								'<p class="zwktrykc" style="text-align: center;"></p>'+
							'</div>'+
			        	'</div>';
			        	$('.quetype').empty().append(cmain_bottom);
				  	}else{
					  	var categories = [];
					   	var data = [];
			   			var relationship = '';
			   			var totalavgscore = 0;
			   			var totalquescore = 0;
					   	for(var i=0;i<efenxi.length;i++){
					   		categories.push(efenxi[i].relationname);
			   				data.push(subPercentage((efenxi[i].avgscore/efenxi[i].quescore).toPercent(),false));
			   				totalavgscore +=efenxi[i].avgscore;
			   				totalquescore +=efenxi[i].quescore;
					   			var excellent =  '<tr>'+
					    				'<th>'+efenxi[i].relationname+'</th>'+
					    				'<td>'+((Math.round(efenxi[i].quescore*10))/10) +'</td>'+
					    				'<td>'+ ((Math.round(efenxi[i].avgscore*10))/10) +'</td>'+
					    				'<td>'+  (efenxi[i].avgscore/efenxi[i].quescore).toPercent() +'</td>'+
					    			'</tr>';
					    		var totalscore = '<tr>'+
					    				'<th>总分</th>'+
					    				'<td>'+((Math.round(totalquescore*10))/10) +'</td>'+
					    				'<td>'+ ((Math.round(totalavgscore*10))/10) +'</td>'+
					    				'<td>'+  (totalavgscore/totalquescore).toPercent() +'</td>'+
					    			'</tr>';
					    			relationship +=  excellent;
					   	}
					   	if(!relationship){
					   		relationship = '';
					   	}
					   	if(!totalscore){
					   		totalscore = '';
					   	}
				   		var quetypeSd =  '<div id="containerSd" style="min-width: 400px; width: 1000px; height: 250px; margin: 0 auto;  margin-top: 20px;"></div><div class="boxF"><table class="table" style="margin: 0 auto;" width="60%"><tr><td></td><th>分值</th><th>平均分</th><th>得分率</th></tr>'+ relationship + totalscore +'</table></div>';
				   		$('.quetype').empty().append(quetypeSd);
				   		$('#containerSd').highcharts({
					        chart: {
					            type: 'column'
					        },
					        
					        title: {
					            text: ''
					        },
					        xAxis: {
					            categories: categories
					        },
					        yAxis: {
					            min: 0,
					            title: {
					                text: '得<br>分<br>率<br>︵<br>%<br>︶',
					                rotation:0,
					                style:{
					                	fontSize: '15px',
					                	fontFamily:'微软雅黑',
					                	color:'#000'
					                }
					            },
					            tickPositions: [0, 25, 50,75, 100]
					        },
					        credits:{
							     enabled:false // 禁用版权信息
							},
					        tooltip: {
					            pointFormat: '<span style="color:{series.color}">得分率</span>: <b>{point.y}%</b><br/>',
					            shared: true
					        },
					        plotOptions: {
								column: {
									ursor: 'pointer',
									point: {
										events: {
											click: function() {
											}
										}
									}
								}
							},
					        legend:{
					        	enabled  : false
					        },
					        credits: {
							    // enabled:true,                    // 默认值，如果想去掉版权信息，设置为false即可
							    text: '知识点',             // 显示的文字
							    href: 'javascript:void(0)',      // 链接地址
							    position: {                         // 位置设置 
							        align: 'right',
							        x: 0,
							        verticalAlign: 'bottom',
							        y: -20
							    },
							    style: {                            // 样式设置
							        cursor: 'pointer',
							        color: 'black',
							        fontSize: '12px'
							    }
							},
							
					        plotOptions: {
					                    series: {
					                        borderWidth: 0,
					                        dataLabels: {
					                            enabled: true,
					                            format: '{point.y}%'
					                        }
					                    }
					                },
					         series: [{
					            name: 'John',
					            data: data
					        }]
					    });	
				  	}
				   	
				   }
	}
	function getElist(order,url){
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/alistAjax.html';
		}
		$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				'order' : order,
				'eid' : eid,
				'sstatus': 1,
				'classid':classid
			}
		}).done(function(res){
			var $pagedom = $(res.datas.pagestr);
			var error = '<div class="nodata"></div>'
			$pagedom.find('.listPage a').bind('click',function(){
				var url = $(this).attr('data');
				var estype = $('.curr').attr('data');
				if(!!url) {
					getElist(estype,url);
				}
			});
			$('.nodatacont').empty()
			$('.datatab tr.first').nextAll().remove();
			$("#mpage").empty().append($pagedom);
			if(!res.datas.userAnswerList.length){
				$('.nodatacont').append(error)
			}
			for(var i = 0,len = res.datas.userAnswerList.length;i<len;i++) {
				var userAnswer = res.datas.userAnswerList[i];
				var data = {
					eid : eid,
					userAnswer : userAnswer.aid,
					anstotalscore : userAnswer.anstotalscore,
					correctrat : userAnswer.correctrat,
					ansdateline : getLocalTime(userAnswer.ansdateline),
					datelineStr : userAnswer.datelineStr,
					face : userAnswer.face,
					sex : userAnswer.sex,
					realname : userAnswer.realname,
					status : userAnswer.status,
					usedtime : Math.ceil(userAnswer.usedtime/60),
					status : userAnswer.status,
					username: userAnswer.username
				}
				var $dom = $(template('t:answer',data));
				$(".datatab tbody").append($dom);
			}
		}).fail(function(){
			console.log('req err');
		});
	}
	function getnoElist(order,url){
		if(typeof url == "undefined") {
			url = '/troomv2/examv2/alistAjax.html';
		}
		$.ajax({
			url:url,
			method:'post',
			dataType:'json',
			data : {
				'order' : order,
				'eid' : eid,
				'sstatus': 2,
				'classid':classid
			}
		}).done(function(res){
			var $pagedom = $(res.datas.pagestr);
			var error = '<div class="nodata"></div>'
			$pagedom.find('.listPage a').bind('click',function(){
				var url = $(this).attr('data');
				var estype = $('.curr').attr('data');
				if(!!url) {
					getnoElist(estype,url);
				}
			});
			$('.stulist').empty();
			$("#npage").empty().append($pagedom);
			if(!res.datas.userAnswerList.length){
				$('.stulist').append(error)
			}
			for(var i = 0,len = res.datas.userAnswerList.length;i<len;i++) {
				var face = res.datas.userAnswerList[i].face;
				var sex =   res.datas.userAnswerList[i].sex;
				var sexicon = '';
				if(face == ''){
					if(sex == '0'){
						face = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man_50_50.jpg';
					}else{
						face = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman_50_50.jpg';
					}
				}
				if(sex == '0'){
					sexicon = 'http://static.ebanhui.com/ebh/tpl/troomv2/images/man.png';
				}else{
					sexicon = 'http://static.ebanhui.com/ebh/tpl/troomv2/images/women.png';
				}
				var $dom = '<div class="stuLists">'
					+'<a title="" href="javascript:;" style="float:left;">'
					+	'<img class="imgyuan" src="'+face+'">'	
					+'</a>'
					+'<p class="ghjut">'
					+	'<span title="'+res.datas.userAnswerList[i].realname+'" style="font-family:Microsoft YaHei;    display: inline-block;max-width: 70px;overflow: hidden;height: 20px;white-space: nowrap;text-overflow: ellipsis;">'+res.datas.userAnswerList[i].realname+'</span>'
					+	'  <img src="'+sexicon+'">'
					+	'<br>'
					+	'<span title="'+res.datas.userAnswerList[i].username+'" style="display: inline-block;width: 70px;overflow: hidden;height: 20px;white-space: nowrap;text-overflow: ellipsis;color: #999;">'+res.datas.userAnswerList[i].username+'</span>'
					+'</p>'
				+'</div>';
				
				$('.stulist').append($dom);
			}
		}).fail(function(){
			console.log('req err');
		});
	}
	function getclass(url) {
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
		    		classid.push(res.datas.efenxisummary.class[i].classid)
		    	}
		  }
		    classid = classid.join();
		    classcheckbut = '关联班级:  <a classid="'+classid+'" class="active">全部</a>'+ classcheckbut;
		    $('.classlist').empty().append(classcheckbut);
		    classlistonclick();
		    $('.onR img').hide()
			$('.mk_y_time').text(Math.ceil(res.datas.efenxisummary.avgusedtime/60) + '分钟');
			manNum = res.datas.efenxisummary.answercounts;
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
			for(var i=0;i<=(mkNumb-1);i++){
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
	function getExamSummaryAjax(url) {
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
			manNum = res.datas.efenxisummary.answercounts;
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
			for(var i=0;i<=(mkNumb-1);i++){
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
	function getLocalTime(nS) {     
	    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
	}
	Number.prototype.toPercent = function(){
		return (Math.round(this * 10000)/100).toFixed(0) + '%';
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
		var  Percent = Math.round(parseFloat(Percentage));
		if(!Percent){
			Percent = 0;
		}
		if(bol){
			return  Percent + '%';
		}else{
			return  Percent;
		}
	}
	function inittab(){
		getExamSummaryAjax();
		var type = $('.ui-tabs-nav li.workcurrent').attr('type');
		if(type == ''){
			getnoElist();
		}else if(type == 'getexam'){
			getElist();
		}else if(type == 'quetype'){
			var value = $('.lishnrt a.xhusre').attr('value');
			if(value == '0'){
				getfenxi('quetype',1);
			}else if(value == '1'){
				getfenxi('relationship',1);
			}else if(value == '2'){
				getfenxi('level',1);
			}
		}else if(type == 'que'){
			var value = $('.lishnrt1 a.xhusre').attr('value');
			if(value == '0'){
				getfenxi('que',1)
			}else if(value == '1'){
				getfenxi('que',2)
			}else if(value == '2'){
				getanswerCount()
			}
		}
	};
	function classlistonclick(){
		getfenxi('quetype') //que  按题型    level  优秀率   relationship  知识点
		$('.classlist a').each(function(){
			$(this).click(function(){
				$('.classlist a').removeClass('active');
				$(this).addClass('active');
				classid = $(this).attr('classid');
				inittab();
			})
		})
	}
	function tabs(cls,ind,active){
    	$(cls).click(function(){
	        $(cls).eq($(this).index()).addClass(active).siblings().removeClass(active);
			$(ind).hide().eq($(this).index()).show();
			$('.lishnrt a').removeClass('xhusre').eq(0).addClass('xhusre');
			$('.lishnrt1 a').removeClass('xhusre').eq(0).addClass('xhusre');
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
	 function GetQueryString(name) {
	    var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
	    var r = window.location.search.substr(1).match(reg);
	    if (r != null) {
	        return unescape(r[2]);
	    }
	    return null;
	}
	$(function(){
		clearInterval(timer);
		//判断实时作业进入
		var urlSign = top.location.search;
		if(urlSign == "?soft=true"){
			$(".lefrig").css("margin",0);
			$("#header").hide();
		}
		getclass();
	    tab('.lishnrt a','xhusre');
	    tab('.lishnrt1 a','xhusre');
	    $('.datatab tr:last td').css('border-bottom','none');
	    tabs(".ui-tabs-nav li",".ui-tabs-panel","workcurrent");
	    tabs(".ui-tabs-nav li",".ui-tabs-panel","workcurrent");
		$('.totalscore').on('click',function(){
			$(this).toggleClass('completetimebP');
			if($(this).hasClass('totalscore')){	
				if($(this).hasClass('completetimebP')){
						getElist(4);
				}else{
						getElist(1);
				}
			}
		});
		var getUrl = "/im/exam/count.html?eid=" + eid;
		if(urlSign == "?soft=true"){
			var timer = setInterval(function(){
				$.ajax({
					type:"GET",
					type:"GET",
					url:getUrl,
					dataType:"json",
					success:function(data){
						var num = data.datas.count;
						if(num != manNum){
							manNum = num;
							$(".ui-tabs-panel").hide();
							$(".ui-tabs-panel").eq(0).show();
							$(".workcurrent").removeClass("workcurrent");
							$(".ui-tabs-nav").find("li").eq(0).addClass("workcurrent");
							$(".xhusre").removeClass("xhusre");
							$(".hietse").eq(0).addClass("xhusre");
							classlistonclick();
						}
					}
				});
			},5000)
		}
	})
</script>
</body>
</html>