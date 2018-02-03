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
<div class="ter_tit"> 当前位置 > <a href="/myroom/analysis.html" >学习分析表</a> > 学习峰值</div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;">
<div class="annotate" style="height:30px;">
记录了所有学员在每个小时段的学习数总量.
</div>
<div class="charts">
<?php $chart->chart($dataarr,'Line');?>
<div style="position:absolute;top:180px;left:10px;font-size:14px;width:15px;font-weight:bold;">该时段学习数总量</div>

<div style="position:absolute;top:480px;left:350px;font-size:14px;font-weight:bold;">24小时时段</div>
	
	<div style="width:740px;height:50px;margin-top:10px">
		<a id="expand1" style="cursor:pointer;width:80px" class="lightlanbtn" onclick="showother(1)">我的峰值表</a>
	</div>
	<div class="subchart">
		<div id="subchart1" style="display:none">
		<?php $chart->chart($dataarrmy,'Line','mypeak');?>
		</div>
	</div>
</div>
</div>

<script>
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
