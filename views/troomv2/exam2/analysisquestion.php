<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="width=1000, user-scalable=no" name="viewport"/>
<title>题库分析</title>
<?php $v=getv();?>
<?php $systemsetting = Ebh::app()->room->getSystemSetting();?>
<meta name="keywords" content="<?=empty($systemsetting['metakeywords'])?'':$systemsetting['metakeywords']?>" />
<meta name="description" content="<?=empty($systemsetting['metadescription'])?'':$systemsetting['metadescription']?>" />
<?php if (!empty($systemsetting['favicon'])) {?><link rel="shortcut icon" href="<?=$systemsetting['favicon']?>" mce_href="<?=$systemsetting['favicon']?>" type="image/x-icon">
<?php }?>
<meta http-equiv="X-UA-Compatible" content="IE=7,IE=9">  
<meta http-equiv="X-UA-Compatible" content="IE=7,9">  
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico');
</script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/base.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/public.bak.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/jqtransform.css<?=$v?>">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/tikutop.css<?=$v?>"/>
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css<?=$v?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/wussyu.css<?=$v?>"/>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/exam/css/kuque.css<?=$v?>"/>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-migrate-1.2.1.min.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/template/template-native-debug.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-3d.js<?=$v?>"></script>
<script src="http://static.ebanhui.com/ebh/js/Highcharts/js/highcharts-more.js<?=$v?>"></script>
<script type="text/javascript" src="http://static.ebanhui.com/exam/js/myquestion2.js<?=$v?>"></script>
</head>
<body>
<title>我的题库</title>
</head>

<body>
	<div class="lefrig">
		<div class="waitite">
			<div class="work_menu" style="position:relative;margin-top:0">
				<ul>
					<li class="workcurrent"><a href="javascript:void(0)" class="title-a"><span class="jnisrso"><?=$pagemodulename?></span></a></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div style="float:right;display:inline;margin-right: 200px;">
			
			</div>
		</div>
		<div class="workol">
			<div id="icategory" class="clearfix" style="border-top:none;">
				<dl style="float:left;display:inline;width:595px; *width:500px;">
				<dd>
					<div class="category_cont1">
						<div><a href="/troomv2/kuque.html" >我的题库</a></div>
						<div><a href="/troomv2/kuque/schquestion.html" class="network">网校题库</a></div>
						<div><a href="/troomv2/kuque/vFavquestion.html" class="myshouc">我收藏的</a></div>
						<div><a href="/troomv2/kuque/kufenxi.html" class="curr">题库分析</a></div>                
					</div>
				</dd>
				</dl>
			</div>
			<div style="clear:both;"></div>
			<div class="workdata" style="float:left;margin-top:0px;">
				<div class="workdata" style="float:left;margin-top:0px;">
		    		<h2 class="ferygur" style="margin-bottom: 10px;">
				        <span>我的题库分析</span>
				    </h2>
				    <div id="analycharts" style="width:920px;height:520px;margin-left: 40px;float: left;">
				    	
				    </div>
				    <h2 class="ferygur" style="margin-bottom: 10px;">
				        <span>网校题库分析</span>
				    </h2>
				     <div id="networkcharts" style="width:920px;height:520px;margin-left: 40px;float: left;">
				    	
				    </div>
    			</div>
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
    <input type="hidden" id="crid" value="<?=$crid?>" />
<script type="text/javascript">
var crid = "<?=$crid?>";
var k = "<?=$k?>";
var myque = new Myquestion();
$(function(){
	myque.getanalyquestion();
});
</script>
</body>
</html>
