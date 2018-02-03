<!DOCTYPE HTML>
<html>
<head>
	<meta content="width=1000, user-scalable=no" name="viewport"/> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>巩固练习</title>
	<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
	<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
	<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
	<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
	<?php }?>
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css"  />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wussyu.css" />
    <script type="text/javascript" src="http://static.ebanhui.com/exam/js/jquery/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/exam/js/jquery/jquery-migrate-1.2.1.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/wap/js/common.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/js/dialog/dialog-plus.js"></script>
	<style type="text/css">
	.waitite{
		text-align: center;
	}
	.teaexam{
		padding: 0 30px;
		float: left;
		line-height: 45px;
		font-family: 微软雅黑;
	}
	.teaexam .tea_header,.teaexam .tea_cont,.teaexam .tea_bottm{
		width: 100%;
		height: auto;
		float: left;
		
	}
	.tea_bottm{
		min-height: 100px;
	}
	.teaexam .tea_header{
		font-weight: 600;
	}
	.teaexam ul{
		display: block;
		float: left;
	}
	.teaexam ul li{
		display: block;
		height: 100%;
		float: left;
	}
	.teaexam .tea_cont .tea_pointList{
		float: left;
		height: auto;
		border-bottom: solid 1px #e3e3e3;
	}
	.teaexam .tea_cont{
		border-bottom: solid 1px #e3e3e3;
	}
	.teaexam .tea_cont .tea_pointList:nth-last-child(1){
		border-bottom:none;
	}
	.teaexam .tea_cont .tea_ann{
		height: 70px;
		float: left;
		padding: 0 30px;
		width: 100%;
		position: relative;
	}
	.teaexam .tea_cont .tea_ann a.onact{
		right: 115px;
	    top: 20px;
	}
	.teaexam .tea_cont .tea_ann a.back{
		right: 10px;
	    top: 20px;
	}
	a.onact{
		background: none repeat scroll 0 0 #5e96f5;
	    color: #FFFFFF;
	    text-decoration: none;
	    border-radius: 2px;
	    width: 90px;
	    height: 30px;
	    text-align: center;
	    line-height: 30px;
	    position: absolute;
	    font-size: 14px;
	   
	}
	.teaexam .tea_cont .tea_pointList .tea_question{
		float: left;
	}
	.teaexam .tea_cont .tea_pointList .tea_point{
		width: 810px;
		float: left;
		
	}
	.teaexam .tea_cont .tea_pointList .tea_point input{
		width: 40px;
		height: 26px;
		clear: none;
	    resize: none;
	    overflow-y: hidden;
	    text-align: center;
	    border: 0px;
	    border: 1px solid #cecece;
	    margin-top: 10px;
	}
	.teaexam .tea_cont .tea_pointList .tea_point ul{
		border-bottom: solid 1px #e3e3e3;
	}
	.teaexam .tea_cont .tea_pointList .tea_point ul:last-child{
		border-bottom: none;
	}
	.tea_w130{
		width: 130px;
		text-align:center;
	}
	.tea_w380{
		width: 380px;
	}
	.tea_w100{
		width: 100px;
		text-align:center;
	}
	.tea_w235{
		width: 205px;
		padding-left:20px ;
		background: url(http://static.ebanhui.com/exam/images/icon/ggSj.jpg) left 14px no-repeat;
	}
	.tea_w170{
		width: 170px;
	}
	.tea_w125{
		width: 125px;
	}
	.tea_w260{
		width: 260px;
	}
	.tea_w150{
		width: 150px;
		position: relative;
	}
	.tea_w150 a.onact{
		top: 10px;
	}
	.txtcenter{
		text-align:center;
		
	}
	.Knowledge_point{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.clear {
	    clear: both;
	    display: block;
	    font-size: 1px;
	    height: 0;
	    line-height: 0;
	    overflow: hidden;
	}
	</style>
</head>
<body>
<div class="lefrig">
	<div class="waitite">
		<span class="jnisrso"><?=$examinfo->esubject?></span>
	</div>
	<div class="teaexam">
		<div class="tea_header">
			<ul>
				<li class="tea_w130">题型</li>
				<li class="tea_w380 txtcenter">知识点</li>
				<li class="tea_w100">原题数</li>
				<li class="tea_w100">正确题数</li>
				<li class="tea_w100">正确率</li>
				<li class="tea_w130">出题数</li>
			</ul>
		</div>
		<div class="tea_cont">
		
		<?php 
		$type_title_map = array(
			"A"=>"单选题",
			"B"=>"多选题",
			"C"=>"填空题",
			"D"=>"判断题",
			"E"=>"文字题",
			"H"=>"主观题",
			"X"=>"答题卡",
			"XTL"=>"听力题",
			"XWX"=>"完形填空",
			"XYD"=>"阅读理解",
			"XZH"=>"组合题"
		);
		// var_dump($typelist);
		foreach($typelist as $type=>$relationlist){?>
			<div class="tea_pointList">
				<div class="tea_question tea_w130">
					<?=$type_title_map[$type]?>
				</div>
				<div class="tea_point">
					<?php foreach($relationlist as $path=>$count){?>
					<ul >
						<li class="tea_w380 Knowledge_point" title="<?=$count['chapterstr']?>"><?=empty($count['chapterstr'])?$count['relationname']:$count['chapterstr']?></li>
						<li class="tea_w100"><?=$count['allcount']?></li>
						<li class="tea_w100"><?=$count['rightcount']?></li>
						<li class="tea_w100"><?=round($count['rightcount']/$count['allcount'],2)*100?>%</li>
						<li class="tea_w130"><input maxcount="<?=$count['allcount']?>" class="quecount" type="text" value="1" quetype="<?=$type?>" path="<?=$path?>" relationname="<?=$count['relationname']?>" chapterstr="<?=$count['chapterstr']?>"></li>
					</ul>
					<?php }?>
					
				</div>
				<div class="clear"></div>
			</div>
		<?php }?>
			
			<div class="tea_ann">
				<a class="onact" id="genexer" href="javascript:void(0)" title="做完才能生成新的试卷哦">生成试卷</a>
				<a class="onact back" id="" href="/college/examv2.html?action=hasdo">返回</a>
			</div>
		</div>
		<div class="tea_bottm">
		<?php 
		if(!empty($exelist)){
				foreach($exelist as $k=>$exe){
			?>
			<ul>
				<li class="tea_w235"><?=$exe->esubject?></li>
				<li class="tea_w170"><?=Date('Y-m-d H:i',$exe->dateline)?></li>
				<li class="tea_w125">知识点：<?=$exe->chapterstrcount?>个</li>
				<li class="tea_w260">总题数：<?=$exe->quecount?>题</li>
				<li class="tea_w150">
				<?php if($exe->status == -1){//未作?>
				<a class="onact" id="" target="_blank" href="/college/examv2/doexam/<?=$exe->eid?>.html">开始练习</a>
				<?php }elseif($exe->status == 1){//已做?>
				<a class="onact" id="" target="_blank" href="/college/examv2/doneexam/<?=$exe->eid?>.html">查看结果</a>
				<?php }elseif($exe->status == 0){//未做完?>
				<a class="onact" id="" target="_blank" href="/college/examv2/doexam/<?=$exe->eid?>.html">继续练习</a>
				<?php }?>
				<a style="top: 12px; left: 105px; position: absolute;" eid="<?=$exe->eid?>" class="dele" href="javascript:void(0)"><img src="http://static.ebanhui.com/ebh/tpl/troomv2/images/shanchu.png"></a>
				</li>
			</ul>
			<?php }
			}?>
		</div>
		
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function(){
	$('.tea_pointList').each(function(){
		var pointHt = $(this).outerHeight(true);
		$(this).find('.tea_question').css('height',pointHt+'px').css('line-height',pointHt+'px');
	})
});
$('#genexer').click(function(){
	var cobj = [];
	$.each($('.quecount'),function(k,v){
		tidarr = $(v).attr('path').split('/');
		tid = tidarr[tidarr.length-1];
		
		var tobj = {quetype:$(v).attr('quetype'),path:$(v).attr('path'),quecount:v.value,tid:tid,ttype:'CHAPTER',level:0,chapterstr:$(v).attr('chapterstr'),quescore:1,relationname:$(v).attr('relationname')};
		cobj.push(tobj);
	});
	
	$.ajax({
		type:"POST",
		url:'/college/examv2/generateExercise.html?t='+Math.random(),
		data:{'eid':<?=$this->uri->itemid?>,'conditionlist':cobj},
		dataType:'json',
		success:function(data){
			if (data.errCode && data.errCode==100004) {
				alert("作业答题时间结束");
			} else {
				location.reload(true);
			}
		}
	});
	
});
$('.quecount').keyup(function(){
	$(this).val($(this).val().replace(/[^\d.]/g,''));
	if($(this).val()>20) 
		$(this).val(20);
});
$('.dele').click(function(){
	var eid = $(this).attr('eid');
	
	top.dialog({
		title: '删除确认',
		content: '您确定要删除该练习吗？',
		width:370,
		okValue: '确定',
		ok: function () {
			$.ajax({
				type:"POST",
				url:'/college/examv2/delexe.html?t='+Math.random(),
				data:{'eid':eid},
				dataType:'json',
				success:function(data){
					location.reload(true);
				}
			});
		},
		cancelValue: '取消',
			cancel: function () {}
		}).showModal();
	
});
</script>
</body>
</html>