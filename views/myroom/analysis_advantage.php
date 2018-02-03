<?php
$this->display('myroom/page_header');
?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/analy.css" />
<script language="JavaScript" src="http://static.ebanhui.com/ebh/js/AnalysisCharts/JSClass/FusionCharts.js"></script>
<body>
<div class="cright_cher">
<div class="ter_tit"> 当前位置 > <a href="/myroom/analysis.html" >学习分析表</a></div>
<div class="lefrig">
<div class="annotate" style="height:30px;">
<span class="lemare">日期：</span>
<a href="javascript:void(0)" onclick="changeday(1)" class="<?=$daystate==1?'darklanbtn':'lightlanbtn'?>">今 天</a>
<a href="javascript:void(0)" onclick="changeday(2)" class="<?=$daystate==2?'darklanbtn':'lightlanbtn'?>">昨 天</a>
<a href="javascript:void(0)" onclick="changeday(3)" class="<?=$daystate==3?'darklanbtn':'lightlanbtn'?>">本 周</a>
<a href="javascript:void(0)" onclick="changeday(4)" class="<?=$daystate==4?'darklanbtn':'lightlanbtn'?>">本 月</a>
<a href="javascript:void(0)" onclick="changeday(0)" class="<?=$daystate==0?'darklanbtn':'lightlanbtn'?>">全 部</a>
<span class="lemare">从&nbsp;</span><input class="calendar" name="textarea" type="text" value="" /><span class="lemare">&nbsp;至&nbsp;</span><input class="calendar" name="textarea" type="text" value=""/>
<a href="javascript:void(0)" onclick="changeday(5)" class="lightlanbtn" style="margin-left:10px;margin-right:0px;">确 定</a>
</div>
<div class="analysis">
<div class="biaoxian">
<img class="futu" src="http://static.ebanhui.com/ebh/tpl/default/images/dalefico.jpg" />
<span class="tongping">这段时间里，你的解题能力XX！</span><img style="float:left;margin-top:5px;" src="http://static.ebanhui.com/ebh/tpl/default/images/yiban.jpg" />
</div>
<div class="lefping">
<?php $daydescription = array('从全部来看','今天1天内','昨天1天内','本周内','本月内');?>
<p class="tixiang"><?=$daydescription[$daystate]?>，您的活跃度表现</p>
<p class="tixiang">与全国同学比，位于XX水平</p>
<p class="tixiang">与江苏省同学比，位于XX水平</p>
</div>
<div class="rigping">
<p class="tixiang"><?=$daystate==0?'':$daydescription[$daystate].','?>您总共完成了 次作业，登录了x次！</p>
<p class="tixiang">全国同学平均(总共)完成了 次作业，登录了x次！</p>
<p class="tixiang">江苏省同学平均回答了 x 道题，登录了x次！</p>
</div>
</div>
<div class="fenxitu" style="position:relative;">
<h2 class="tittu">完成题量对比图（最近一周）</h2>
<div style="position:absolute;top:150px;left:40px;font-size:14px;width:15px;font-weight:bold;">答题数</div>
<?php
// $chart->chart($dataarr);
?>
</div>
</div>
</div>
<script>
function changeday(daystate){
	var url = '/myroom/analysis/advantage.html?daystate='+daystate;
	location.href = url;
}
</script>
<?php $this->display('myroom/page_footer'); ?>
