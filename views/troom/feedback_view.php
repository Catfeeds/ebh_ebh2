<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="http://static.ebanhui.com/ebh/js/AnalysisCharts/JSClass/FusionCharts.js"></script>
<style>
.waifg {
	width:928px;margin-left:10px;float:left;margin-bottom:10px;
}
.waifg h2 {
margin:20px 0;font-size:14px;font-weight:bold;float:left;
}
.ekwt {
width:928px;float:left;
}
.ewjtt {
float:left;width:150px;margin-left:15px;
}
.ektrr {
float:left;margin-top:4px;
}
.eryekx {
float:left;height:20px;line-height:20px;margin-left:6px;font-size:14px;
}
.cright {float:none;display: block;margin: 0 auto;width:980px;margin-bottom:20px;}
.classbox {width:988px;background: #FFF;}
.classboxmore {width:928px;margin-left:6px;border-bottom:1px solid #cdcdcd}
</style>
</head>
<body>
<div class="cright">
<div style="width:980px;margin:0 auto;">
<div class="cright">
	<div class="lefrig" style="margin-top:10px;float:none;">
		<div class="classbox">
		<h1><?= $course['title']?></h1>
		<div class="classboxmore">
			<p>主讲：<?= empty($course['realname'])?$course['username']:$course['realname'] ?>    <span>时间：<?= date('Y.m.d',$course['dateline'])?></span><span>人气：<?= $course['viewnum']?></span></p>
			<p>摘要：<?= $course['summary'] ?></p>
		</div>
			<input type="hidden" name="cwid" value="<?=$course['cwid']?>"/>
			<div class="waifg">
			<h2>听课反馈:</h2>
			<div class="ekwt">
				<?php $chart->chart($feedback,'Pie2D','d1',700,250)?>
			</div>
			<h2>难易度:</h2>
			<div class="ekwt">
				<?php $chart->chart($difficulty,'Pie2D','d2',700,250)?>
			</div>
			<h2>课程质量:</h2>
			<div class="ekwt">
				<?php $chart->chart($quality,'Pie2D','d3',700,250)?>
			</div>
			<h2>讲课水平:</h2>
			<div class="ekwt">
				<?php $chart->chart($level,'Pie2D','d4',700,250)?>
			</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
		
	function closew(){
		var opened=parent.window.open(' ','_self');
		opened.close();
	}
</script>
</body>
</html>
