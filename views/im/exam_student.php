<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="width=1000, user-scalable=no" name="viewport"/>
<?php $systemsetting = Ebh::app()->room->getSystemSetting(); ?>
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<title><?= empty($subtitle) ? $this->get_title() : $subtitle.'-'. $this->get_title() ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico');
</script>
<![endif]-->

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/aroomv2/css/style.css<?=getv()?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css<?=getv()?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css?version=20160224001" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?version=20160224001" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/troomv2/css/wussyu.css<?=getv()?>"/>

<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common2.js?version=20160606001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/teacher.js?version=20150825001"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/table.js"></script>

<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/showmessage/jquery.showmessage.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/showmessage/css/default/showmessage.css" media="screen" />

</head>
<body>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xDialog/xloader.auto.js?v=20150731"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
<?php $v=getv();?>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=$v?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
<style type="text/css">
body{
	background: #fff;
}
#icategory{
	background:#fff;
	 padding: 0px 5px;
}
.category_cont1 div{
	height:40px;
	line-height:40px;
	
}
.fbsjkc .kkjssj{
	width:auto;
	float:left;
}
.fbsjkc .cyrss{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renqi.png) no-repeat left center;
	padding-left: 15px;
}
.fbsjkc .cyrus{
	background: url(http://static.ebanhui.com/ebh/tpl/troomv2/images/renyuan.png) no-repeat left center;
	padding-left: 15px;
}
.bzzytitle a{
    font-family: 微软雅黑;
    font-weight: bold;
    color: #333;
    font-size: 16px;
}
.cuotiji{
	margin-right:11px !important;
}
.workcurrent a{
	border-bottom: none;
}

.TjFx{display: inline;height: 30px; position: absolute;right: 115px; top: 3px; width: 185px;}
.TjFx a{display: block;width: 100px;height: 25px; background: #6e8eb5; border-radius: 3px; color: #fff; text-align: center;line-height: 25px;}
.diles{top:12px!important;}
a.hrelh {
    display: block;
    margin: 1px 0 0 8px;
    background: url(http://static.ebanhui.com/ebh/tpl/2014/images/xiudty_s.jpg) no-repeat left center;
    color: #2796f0;
    cursor: pointer;
    float: left;
    height: 14px;
    line-height: 24px;
    text-align: center;
    text-decoration: none;
    padding-left: 20px;
}
.kkjssj{
	width: 96%;
}
.datatab td{
	border-bottom: none;
}
tr.kettshe{
	border-bottom: 1px solid #efefef;
	display: block;
}
a.bjcgs {
   position: absolute;
   right: 40px;
   }
i.TSicon,i.PTicon,i.homeicon,i.classicon,i.examinicon{
	display: inline-block;
	width:20px;
	height: 20px;
	background: #19a6f8;
	color:#fff;
	border-radius: 2px;
	margin: 0 5px;
	font-style:normal;
	text-align: center;
	line-height: 20px;
	font-weight: 400;
	font-size: 11px;
	
}
a.errorbjsgs{
	background: #DEDEDE!important;
	color: #9F9F9F!important;
	height: 26px!important;
	width: 86px;
	border-radius: 3px;
	line-height: 26px!important;
	
}
a.errorbjsgs:hover{
	text-decoration:none;
}
.kkjssj{
	width: auto!important;
	float: left!important;
}
.work_menu ul li{
	padding: 11px 0 0 0;
}
.work_menu ul li a{
	color:#666;
	font-size: 16px;
}
.filterT{
	display:block;
}
.waitite{
	font-family: 微软雅黑;
}
.category_cont1 div a{
	padding: 3px 10px;
    font-size: 14px;
    font-family: 微软雅黑;
}
.workcurrent a span{
	padding: 0px 0px 2px 12px;
}
#icategory dd{width: 990px;}
.datatab a{
	color: #5e96f5;
}
.datatab a:hover{
	color: #5e96f5;
}
.datatab a.jxzzy{
	background: url('http://static.ebanhui.com/ebh/tpl/2016/images/jxzzy.png') left center no-repeat;
}
a:hover{text-decoration: none}
.zwktrykc {
    font-family: 微软雅黑;
    font-size: 20px;
    color: #666;
    text-align: center;
}
.datatab a.qltbtn {
    width: 127px;
    height: 34px;
    line-height: 34px;
    color: #fff;
    font-family: 微软雅黑;
    text-align: center;
    background: #5e96f5;
    border-radius: 3px;
    display: block;
    margin: 0 auto;
    margin-top: 30px;
    margin-bottom: 55px;
    font-size: 14px;
}
a.qltbtn:hover{
	color: #fff;
}
.lefrig{
	margin:0 auto;
	float:none!important;
}
.study{
	position:relative;
}
.nodata{
	position: absolute;
	left:0;
	top:0;
	min-height: 420px!important;
	width:970px!important;
}

</style>
<?
if(!empty($folder)){
	$this->assign('selidx',2);
	$this->display('college/course_nav');
}?>
<div class="lefrig">

	<div class="workol" style="margin-top:0">
		<div class="lefrig" style="background: rgb(255, 255, 255); float: left; width: 1000px; margin-top: 0px;">
			<div class="workdata" style="width:1000px;margin-top: 0px;">
				<table width="100%" id="exams" class="datatab" style="border:none;">

				</table>
			</div>
		</div>
	</div>
	<div id="mpage" style="height:40px;clear:both;"></div>
	<script type="text/html" id="t:list">
		<tr class="kettshe">
			<td style="border-top:none;">
				<div style="float:left;width:960px;font-family:微软雅黑; height:55px;">
					<div class="bzzytitle">
						<%if(notanswered){
							if(examstarttime > nowtime){%>
								<a title="<%=esubject%>" href="javascript:void(0)"><%=sesubject%></a>
							<%}else if(examendtime && examendtime < nowtime){%>
								<a title="<%=esubject%>" href="javascript:void(0)"><%=sesubject%></a>
							<%}else{%>
							<a target="_self"  title="<%=esubject%>" href="/college/examv2/doexam/<%=eid%>.html"><%=sesubject%></a>
							<%}%>
						<% }else{%>
							<%if(userAnswer.status == 0){%>
							<a target="_self"  title="<%=esubject%>" href="/college/examv2/doexam/<%=eid%>.html"><%=sesubject%></a>
							<%}else{%>
							<a target="_self"  title="<%=esubject%>" href="/college/examv2/doneexam/<%=eid%>.html"><%=sesubject%></a>
							<%}%>
						<%}%>
						<%if(etype == 'COMMON'){%>
								<i class="PTicon">普</i>
								<%if(estype == ''){%>
								<%}else{%>
									<i class="homeicon"><%=estype%></i>
								<%}%>
								
						<%}else if(etype == 'TSMART'){%>
								<i class="TSicon">智</i>
								<%if(estype == ''){%>
								<%}else{%>
									<i class="homeicon"><%=estype%></i>
								<%}%>
						<%}%>
					</div>
					<span style="float:right;width:90px;margin-top:-10px;">
						<%if(notanswered){
							if(examstarttime>nowtime){%>
								<a  class="bjcgs errorbjsgs" href="javascript:void(0)">等待开放</a>
							<%}else if(examendtime && examendtime<nowtime){%>
								<a  class="bjcgs errorbjsgs" href="javascript:void(0)">已过期</a>
							<%}else{%>
							<a  class="bjcgs" target="_self" href="/college/examv2/doexam/<%=eid%>.html">打开</a>
							<%}%>
						<% }else{%>
							<%if(userAnswer.status == 0){%>
								<a  class="bjcgs jxzzy" target="_self" href="/college/examv2/doexam/<%=eid%>.html">继续做</a>
							<%}else{%>
								<% var canclass = '';
									var ahref = '/college/examv2/doneexam/'+eid+'.html';
									%>
								<%if(userAnswer.correctrat == 100){%>
									<a  class="bjcgs" style="" target="_self" href="<%=ahref%>">查看结果</a>
								<% }else{ %>
									<%if(stucancorrect == 1){ %>
									<a  class="bjcgs jxzzy" style="right: 120px;" target="_self" href="/college/examv2/papercorrect/<%=userAnswer.aid%>.html?eid=<%=eid%>">自主批阅</a>
									<a  class="bjcgs" style="right: 25px;" target="_self" href="<%=ahref%>">查看结果</a>
									<%}else{ %>
									<a  class="bjcgs" style="" target="_self" href="<%=ahref%>">查看结果</a>	
									<% }%>
								<%}%>
							<%}%>	
						<%}%>
					</span>
					<div style="float:left;width:800px;<!--padding-left:25px;-->">
						<div class="fbsjkc fl ml25">
							<p class="fl" style="width:125px; color:#000;"><%=datelineStr%></p>
							<p class="fl" style=""><span class="fl" style="color:#999;">出题者：</span><a href="javascript:void(0)" title="<%=realnametitle%>" class="filterT" teacherid=<%=uid%> style="float:left;"><%=realname%></a>
							<!--<a class="hrelh" href="javascript:;" style="height:34px;background:url(http://static.ebanhui.com/ebh/tpl/2016/images/fsxico.png) no-repeat left center;" tid="<%=uid%>" tname="<%=realnametitle%>" title="给他发私信"></a>--> </p>
							<p class="fl" style="color:#999;"><span style="padding:0 10px;"></span>总分：<%=examtotalscore%>分<span style="padding:0 10px;"></span></p>
							<p class="kkjssj">
								<%if(limittime == 0){ %>
									不限时
								<%}else{%>
									<%=limittime%>分钟
								<%}%>
								</p>
							<%if(ansstarttime){%>
							<p class="fl" style="color:#999;"><span style="padding:0 10px;"></span>
								答案开放时间：<%=ansstartday%>
							</p>
							<%}%>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<!--<p style="padding-left: 25px;">关联课程：
					<a class="filterF" title="<%=#relationname%>" folderid="<%=folderid%>" href="javascript:void(0)"><%=substrinreal(FOLDER)%>
						<%if(COURSE != ''){%>  > <%=substrinreal(COURSE)%>
					<%}%>
					</a>
					
					
					<%if(examstarttime){%>
					<span style="padding:0 10px;color:#999;">作业开放时间：<%=examstartday%> 至 <%=examendday%></span>
					<%}%>
				</p>-->
				
				<%if(!notanswered && userAnswer.status != 0){%>
					
					<!--<div class="hsidts1s ml25" style="float:left;display:inline;width: 100%;"><a href="/college/examv2/errsituation/<%=eid%>.html" class="lasrnwe">错题情况</a><a class="lasrnwe" target="_blank" href="/college/examv2/efenxi/<%=eid%>.html">统计分析</a>
					<%if(etype == 'TSMART' && canreexam && status == 1){%>
					<a href="/college/examv2/exercise/<%=eid%>.html" class="lasrnwe">巩固练习</a>-->
					<%}%>
					</div>
				<%}%>
				
			</td>
		</tr>
	</script>
	<script type="text/javascript">
		var crid = "<?=$crid?>";
		var eids = [];
		//获取教师布置的作业列表
		function getElist(url){
			if(typeof url == "undefined") {
				url = '/im/exam/examAjax.html';
			}
			$(".loading").show();
			eids = top.exam_student;
			$.ajax({
				url:url,
				method:'post',
				dataType:'json',
				data : {
					eids:eids
				},
				beforeSend:function(XMLHttpRequest){
             	 var loading = '<div style="text-align:center;width:100%;"><img style="width:32px;margin:0 482px;" src="http://static.ebanhui.com/exam/images/loading-2.gif"></div>';
             	 $('#exams').empty().append(loading);
        	 }
			}).done(function(res){
				$("#mpage").empty();
				if(res.errCode == '11111'){
					var cmain_bottom = '<tr><td><div class="cmain_bottom " style="width: 970px; min-height: 400px;">' +
						'<div class="study" style="width:100%;margin: 0 auto; border-bottom:none;">' +
							'<div class="nodata"></div>'+
							'<p class="zwktrykc" style="text-align: center;">暂未开通任何课程</p>'+
							'<a href="/myroom/college/study.html" target="mainFrame" class="qltbtn">去开通</a>'+
						'</div>'+
		        	'</div></td></tr>';
		        	$("#exams").empty().append(cmain_bottom);
				}else{
					if(res.datas.examList.length <=0){
						var cmain_bottom = '<tr><td><div class="cmain_bottom " style="width: 970px; min-height: 400px;">' +
							'<div class="study" style="width:100%;margin: 0 auto; border-bottom:none;">' +
								'<div class="nodata"></div>'+
								'<p class="zwktrykc" style="text-align: center;"></p>'+
							'</div>'+
			        	'</div></td></tr>';
			        	$("#exams").empty().append(cmain_bottom);
						
					}else{
						renderExamList(res.datas.examList);
					}
				}
				
				/*var $pagedom = $(res.datas.pagestr);
				$pagedom.find('.listPage a').bind('click',function(){
					var url = $(this).attr('data');
					if(!!url) {
						getElist(url);
					}
				});
				$("#mpage").empty().append($pagedom);*/
				$(".loading").hide();
			}).fail(function(){
				console.log('req err');
			});
		}
		
		$(function(){
			getElist();
		});
		//渲染教师布置的作业
		function renderExamList(examList){
			$("#exams").empty();
			for(var i = 0,len = examList.length; i<len; i++) {
				var exam = examList[i].exam;
				var userAnswer = examList[i].userAnswer;
				var  FOLDER = '' ;
				var  COURSE = '' ;
				var folderid = '';
	    		if(exam.relationSet.length >=2 && exam.relationSet[0].ttype == 'FOLDER'){
					if(exam.relationSet[1].ttype == 'COURSE'){
		    			FOLDER = exam.relationSet[0].relationname;
		    			COURSE = exam.relationSet[1].relationname?exam.relationSet[1].relationname:'';
		    			folderid = exam.relationSet[0].tid;
		    		}else{
		    			FOLDER = exam.relationSet[0].relationname;
    					folderid = exam.relationSet[0].tid;
		    		}
		    	}else{
		    		if(exam.relationSet[0].ttype == 'FOLDER'){
		    			FOLDER = exam.relationSet[0].relationname;
    					folderid = exam.relationSet[0].tid;
		    		}else{
		    			FOLDER = '';
	    				folderid = '';
		    		}
		    		
		    	};
		    	
		    	if(exam.esubject.length>40){
				 	var  sesubject = exam.esubject.substring(0,40)+"...";
				}else{
					var sesubject = exam.esubject;
				};
				
				var data = {
					stucancorrect : exam.stucancorrect,
					canreexam : exam.canreexam,
					answercount : exam.answercount,
					dateline :  getLocalTime(exam.dateline),
					datelineStr : exam.datelineStr,
					nowtime : exam.nowtime,
					eid : exam.eid,
					estype : exam.estype.substr(0,1),
					esubject : exam.esubject,
					sesubject : sesubject || '',
					etype :exam.etype,
					examtotalscore : exam.examtotalscore,
					limittime : exam.limittime,
					uid : exam.uid,
					realname : exam.realname?exam.realname:'管理员',
					realnametitle : exam.realnametitle,
					FOLDER : FOLDER,
					COURSE : COURSE,
					userAnswer : userAnswer || '',
					status : userAnswer.status || 0,
					notanswered : $.isEmptyObject(userAnswer),
					examstarttime:exam.examstarttime,
					examendtime:exam.examendtime,
					ansstarttime:exam.ansstarttime,
					ansendtime:exam.ansendtime,
					folderid:folderid,
					examstartday : exam.examstarttime?getLocalTime(exam.examstarttime):0,
					examendday : exam.examendtime?getLocalTime(exam.examendtime):0,
					ansstartday : exam.ansstarttime?getLocalTime(exam.ansstarttime):0
					// ansendday : exam.ansendtime?getDateDay(exam.ansendtime):0
				}
				template.helper("substrinreal", function(a){
					if(a.length > 25){
						a = a.substring(0,25) + '...';
					}else{
						a =a;
					}
					return a;
				});
				if (data.datelineStr == null)
		    		data.datelineStr = '刚刚';
				var $dom = $(template('t:list',data));
				$("#exams").append($dom);
			}
			var kettsheL  = $('#exams tr.kettshe').length;
			$('#exams tr.kettshe').eq(kettsheL-1).css('border-bottom','none');
		};
	</script>
</div>
<script type="text/javascript">
	function getLocalTime(nS) {
		var d = new Date(parseInt(nS) * 1000);
		var hours = d.getHours();
		var minutes = d.getMinutes();
		var seconds = d.getSeconds()
		var timeValue = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+" "; 
		timeValue += hours;
		timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
	    return timeValue;      
	    // return new Date(parseInt(nS) * 1000).toLocaleString().replace(/\//g, "-").replace(/日/g, " ");      
	}
	function getDateDay(d){
		var date = new Date(parseInt(d) * 1000);
		var y = date.getFullYear();  
	    var m = date.getMonth() + 1;  
	    m = m < 10 ? '0' + m : m;  
	    var d = date.getDate();  
	    d = d < 10 ? ('0' + d) : d;  
	    return y + '-' + m + '-' + d;  
	}
	Number.prototype.toPercent = function(){
		return (Math.round(this * 10000)/100).toFixed(0) + '%';
	}   
</script>
<div style="clear:both;"></div>
<div style="text-align:center;">
<?php
debug_info();
?>
</div>
</body>
</html>