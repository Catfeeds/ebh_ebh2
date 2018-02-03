<?php
$this->display('myroom/page_header');
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/analy.css" />
<script language="JavaScript" src="http://static.ebanhui.com/ebh/js/AnalysisCharts/JSClass/FusionCharts.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/date/WdatePicker.js"></script>
<style>
.charts a.darklanbtn {
	float:left;
	background:#0d9be9;
	border:solid 1px #108ed4;
	width:49px;
	height:25px;
	line-height:25px;
	display:block;
	color:#fff;
	text-align:center;
	font-weight:normal;
	text-decoration:none;
	margin-right:10px;
}
.charts a.lightlanbtn {
	float:left;
	background:#4ec0fe;
	border:solid 1px #1791d5;
	width:49px;
	height:25px;
	line-height:25px;
	display:block;
	color:#fff;
	text-align:center;
	font-weight:normal;
	text-decoration:none;
	margin-right:10px;
}
.charts a.lightlanbtn:hover {
	background:#0d9be9;
}
</style>

<body>
<div class="ter_tit"> 当前位置 > <a href="/myroom/analysis.html" >学习分析表</a> > 活跃指数</div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;">
<div class="annotate" style="height:30px;">
<span class="lemare">日期：</span>
<a style="cursor:pointer" onclick="changeday(1)" class="<?=$daystate==1?'darklanbtn':'lightlanbtn'?>">今 天</a>
<a style="cursor:pointer" onclick="changeday(2)" class="<?=$daystate==2?'darklanbtn':'lightlanbtn'?>">昨 天</a>
<a style="cursor:pointer" onclick="changeday(3)" class="<?=$daystate==3?'darklanbtn':'lightlanbtn'?>">本 周</a>
<a style="cursor:pointer" onclick="changeday(4)" class="<?=$daystate==4?'darklanbtn':'lightlanbtn'?>">本 月</a>
<a style="cursor:pointer" onclick="changeday(0)" class="<?=$daystate==0?'darklanbtn':'lightlanbtn'?>">全 部</a>
<span class="lemare">从&nbsp;</span>
<input class="calendar" id="dfrom" type="text" value="<?=empty($dayfrom)?'':$dayfrom?>" onclick="WdatePicker()" readonly="readonly"/>
<span class="lemare">&nbsp;至&nbsp;</span>
<input class="calendar" id="dto" type="text" value="<?=empty($dayto)?'':$dayto?>" onclick="WdatePicker()" readonly="readonly"/>
<a style="cursor:pointer;margin-left:10px;margin-right:0px;" onclick="changeday(5)" class="lightlanbtn">确 定</a>
</div>
<div class="analysis">
<div class="biaoxian">
<img class="futu" src="http://static.ebanhui.com/ebh/tpl/default/images/dalefico.jpg" />
<?php if(!empty($myclass)){?>
<span class="tongping">这段时间里，你的活跃度情况</span><img style="float:left;margin-top:5px;" src="http://static.ebanhui.com/ebh/tpl/default/images/<?=$judgement['img']?>.jpg" />
<?php }?>
</div>
<?php $daydescription = array('从所有数据来看','今天1天内','昨天1天内','本周内','本月内','所选的这段时间内');?>
<?php if(!empty($myclass)){?>
<div class="lefping">
<p class="tixiang"><?=$daydescription[$daystate]?>，您的活跃度表现 <?=$judgement['des']?></p>
<p class="tixiang">与同班同学比，位于 <?=$judgement['level']?> 水平</p>
</div>
<?php }?>
<div class="rigping" style="padding-left:20px;width:350px">
<p class="tixiang"><?=$daydescription[$daystate].','?>您总共提问了 <?=$myaskcount?> 次,回答了 <?=$myanswercount?> 次,评论了<?=$myreviewcount?>次</p>
<?php if(!empty($myclass)){?>
<p class="tixiang">同班同学总共提问了 <?=$classaskcount?> 次，回答了 <?=$classanswercount?> 次，评论了<?=$classreviewcount?>次</p>
<?php }?>
<p class="tixiang">全校同学总共提问了 <?=$allaskcount?> 次，回答了 <?=$allanswercount?> 次，评论了<?=$allreviewcount?>次</p>
</div>
</div>
<?php
if(!empty($dataarr['datas']['我的'])){
?>
<div class="fenxitu" style="position:relative;">
<h2 class="tittu">(以下图表中,全校同学与同班同学的数值为平均值)</h2>
<div style="position:absolute;top:150px;left:18px;font-size:14px;width:15px;font-weight:bold;">活跃指数</div>

<div class="charts">
<?php
$chart->chart($dataarr,'Pie2D');?>
	
	<div style="width:740px;height:50px;">
		<a id="expand1" style="cursor:pointer;width:70px" class="lightlanbtn" onclick="showother(1)">提问分析图</a>
		<a id="expand2" style="cursor:pointer;width:70px" class="lightlanbtn" onclick="showother(2)">解答分析图</a>
		<a id="expand3" style="cursor:pointer;width:70px" class="lightlanbtn" onclick="showother(3)">评论分析图</a>
	</div>
	
	<div class="subchart">
	
		<div id="subchart1" style="display:none">
		<?php $chart->chart($dataarrask,'Column3D','chartask');?>
		</div>
		
		<div id="subchart2" style="display:none">
		<?php $chart->chart($dataarranswer,'Column3D','chartanswer');?>
		</div>

		<div id="subchart3" style="display:none">
		<?php $chart->chart($dataarrreview,'Column3D','chartreview');?>
		</div>
	</div>
</div>
<?php
}else{
?>
<center>数据不足,不提供图表.</center>
<?php
}
?>
</div>
</div>
<script>
function changeday(daystate){
	var dayparam = '';
	if(daystate==5){
		var dayfrom = $('#dfrom').val();
		var dayto = $('#dto').val();
		dayparam = '&dayfrom='+dayfrom+'&dayto='+dayto;
	}
	var url = '/myroom/analysis/active.html?daystate='+daystate+dayparam;
	location.href = url;
}
function showother(index){
	if($('#subchart'+index).css('display') == 'none'){
		$('#subchart'+index).css('display','block');
		$('#expand'+index).removeClass('lightlanbtn');
		$('#expand'+index).addClass('darklanbtn');
		var showindex = Math.min(($('.subchart').height()-50)/355,index);
		parent.$('body,html').animate({scrollTop: 663+50+355*(showindex-1)}, 500);
	}else{
		$('#subchart'+index).css('display','none');
		$('#expand'+index).removeClass('darklanbtn');
		$('#expand'+index).addClass('lightlanbtn');
	}
	parent.resetmain();
}
</script>
<?php $this->display('myroom/page_footer'); ?>
