<?php
$this->display('shop/one/header');
?>
<script language="JavaScript" src="http://static.ebanhui.com/ebh/js/AnalysisCharts/JSClass/FusionCharts.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/portal/css/ebhportal.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/citytpl/stores/css/wxind.css" />
<style>
.porny {
    background-color: #fff;
    border: 1px solid #cdcdcd;
    height: auto;
    padding: 25px 15px;
    width: 928px;
}
.zzind {
    margin: 10px auto 0;
    width: 960px;
}
.titete {
	font-size:24px;
	margin-bottom:25px;
	font-weight:bold;
	text-align:center;
}
.ereyk {
	margin-left:15px;
	height:20px;
	line-height:20px;
}
.sexqueue0{
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/sexqueue0.jpg) no-repeat;
	display: inline-block;
	height: 51px;
	position: relative;
	width: 355px;
	bottom: 2px;
}
.sexqueuefull0{
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/sexqueuefull0.jpg) no-repeat;
	display: block;
	height: 51px;
	float: right;
}
.sexqueue1{
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/sexqueue1.jpg) no-repeat;
	display: inline-block;
	height: 51px;
	position: relative;
	width: 355px;
	bottom: 2px;
}
.sexqueuefull1{
	background: url(http://static.ebanhui.com/ebh/tpl/2014/images/sexqueuefull1.jpg) no-repeat;
	display: block;
	height: 51px;
	float: left;
}
.sexvaluemale{
	width:365px;
	text-align:right;
	margin-right:30px;
	font-size:24px;
	font-weight:bold;
	float:left;
}
.sexvaluefemale{
	width:360px;
	text-align:left;
	font-size:24px;
	font-weight:bold;
	float:left;
}
.lxdhs1s{
    word-break: break-all;
}
</style>
<title>无标题文档</title>
</head>

<body>
    <!--增加客服系统sta-->
    <div class="clear"></div>
    <div class="kfxt">
        <?php $this->display('shop/drag/kf')?>
    </div>
    <!--增加客服系统end-->
<?php $jx = $room['domain'] == 'jx';?>
<?php if(!$jx){?>
<div class="dhtop">
<?php }else{?>
<div class="dhtop4">
<?php }?>
<ul style="margin-left:55px;">
<li class="dhdan"><a href="/"></a></li>
<li class="dhdan"><a href="<?= geturl('introduce')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('dyinformation')?>"></a></li>
<li class="dhdan"><a href="<?= geturl('cloud')?>"><img src="http://static.ebanhui.com/ebh/tpl/default/images/dhcloud_20141209.jpg"/></a></li>
<?php if(!$jx){?>
<li class="dhdan"><a href="<?= geturl('platform')?>"></a></li>
<?php }?>
<li class="dhdan"><a href="<?= geturl('contacts')?>"></a></li>
</ul>
</div>
<div class="zzind">
<div class="porny">
<h2 class="titete">云教学平台数据图表</h2>

<div style="width:928px;height:36px;line-height:36px;">
<h3 class="xiaobiao" style="float:left;margin-top:8px;">
<span>男女人数比</span>
</h3>
<span class="sexvaluemale" style=""><?=$sexpercent[0]?>%</span>    <span class="sexvaluefemale" style=""><?=$sexpercent[1]?>%</span>
</div>

<?php 
	$moresex = ($sexpercent[0]>$sexpercent[1])?0:1;
	$sexpercent[$moresex] = round($sexpercent[$moresex],-1);
	$sexpercent[!$moresex] = 100 - $sexpercent[$moresex];
		
?>

<div style="width:928px;height:40px;line-height:40px;">
<h3 class="xiaobiao" style="float:left;margin-top:12px;">
<span>学业勤奋度</span>
</h3>
<span class="sexvaluemale" style="font-size:32px"><?=$loginpercent[0]?>%</span>
<span class="sexvaluefemale" style="font-size:32px;"><?=$loginpercent[1]?>%</span>
</div>
<div style="width:928px;">
<span class="sexqueue0" style="margin-left:110px;margin-right:10px;">
	<span class="sexqueuefull0" style="width:<?=$sexpercent[0]?>%;"></span>
</span>
<span class="sexqueue1">
	<span class="sexqueuefull1" style="width:<?=$sexpercent[1]?>%;"></span>
</span>
</div>

<h3 class="xiaobiao" style="margin-top:30px">
<span>全时动态表</span>
</h3>
<p class="ereyk">记录了所有学员在每个时段的学习数总量</p>
<?php $chart->chart($datastudypeak,'Line','peak',700,350,0);?>
<h3 class="xiaobiao" style="margin-top:30px">
<span>活跃度</span>
</h3>
<p class="ereyk">本网校与其他网校的活跃对比度</p>
<div style="float:left;width:928px;height:310px">
<div style="float:left;width:305px">
<?php $chart->chart($datacw,'Column3D','cw',300,300,0,1)?>
</div>
<div style="float:left;width:305px">
<?php $chart->chart($dataexam,'Column3D','exam',300,300,0,1)?>
</div>
<div style="float:left;width:305px">
<?php $chart->chart($dataanswer,'Column3D','answer',300,300,0,1)?>
</div>
</div>
&nbsp;
</div>
</div>

<?php
$this->display('common/footer');
?>