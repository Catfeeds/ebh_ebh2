<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $course['title']?></title>
<meta name="keywords" content="<?= empty($subkeywords) ? $this->get_keywords() : $subkeywords ?>" />
<meta name="description" content="<?= empty($subdescription) ? $this->get_description() : $subdescription?>" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css<?=getv()?>" type="text/css" rel="stylesheet">
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js?v=0514"></script>
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
.classbox {width:978px;background: #FFF;border:solid 1px #cdcdcd;}
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
			<?php if(!empty($nodata)){?>
			<div class="nodata"></div>
			<?php }else{?>
			<div class="waifg">
			<h2>听课反馈:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer1" style="height:300px;margin-left:100px;"></div>
			</div>
			<h2>难易度:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer2" style="height:300px;margin-left:100px;"></div>
			</div>
			<h2>课程质量:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer3" style="height:300px;margin-left:100px;"></div>
			</div>
			<h2>讲课水平:</h2>
			<div class="ekwt">
				<div class="mt50" id="chartcontainer4" style="height:300px;margin-left:100px;"></div>
			</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function(){
	<?php if(empty($nodata)){?>

	tochart('1',<?=$feedback['datas']?>);
	tochart('2',<?=$difficulty['datas']?>);
	tochart('3',<?=$quality['datas']?>);
	tochart('4',<?=$level['datas']?>);
	<?php }?>
});
function tochart(index,datas){
	var dataarr = new Array();
	$.each(datas,function(k,v){
		dataarr.push([k,v]);
	})
	$('#chartcontainer'+index).highcharts({
		chart: {
			type: 'pie'
		},
		series:[{
			name:'反馈次数',
			data: dataarr
		}],
		yAxis: {
			allowDecimals:false,
			title:{
				text:null
			}
		},
		title: {
			text: null
		},
		credits:{
			enabled:false 
		},
		legend:{
			enabled:false
		}
	});
}
</script>
</body>
</html>
