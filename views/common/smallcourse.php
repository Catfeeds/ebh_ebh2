<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="$keywords" />
<meta name="description" content="$description" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/citytpl/huihua/css/base.css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>  
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<style type="text/css">
.cqliebiao {
	float: left;
	width: 748px;
	border: 1px solid #cdcdcd;
	 margin-bottom: 10px;
}
.cqliebiao .cqlite {
	background-color: #77c3b9;
	text-align: center;
	font-weight: bold;
	color: #FFFFFF;
	font-size: 12px;
	height: 22px;
	line-height: 22px;
	margin-top: 8px;
	margin-right: 5px;
	margin-left: 5px;
}
.cqliebiao .cqmain {
	margin-left: 12px;
	width: 700px;
}
.cqliebiao .cqmain .lanbiaot {
	font-size: 14px;
	color: #0033ff;
	font-weight: bold;
	margin-top: 12px;
	margin-bottom: 12px;
}
.cqliebiao .cqmain ul {
	width: 700px;
	float: left;
	margin-bottom:10px;
}
.cqliebiao .cqmain .liess {
	width: 680px;
	overflow: hidden;
	white-space: nowrap;
	line-height: 25px;
	height: 25px;
	display: block;
}


.cqliebiao .cqmain .liess .yema {
	position: relative;
	float: left;
	line-height: 25px;
	height: 25px;
	margin-left: 5px;
}
.sa {
	text-decoration: none;
	padding-left: 5px;
	white-space: nowrap;
	overflow: hidden;
	width: 600px;
	line-height: 25px;
	height: 25px;
	display: block;
	float: left;
	color:#333;
}
.sa:hover {
	color: #ff5500;
	text-decoration: none;
	padding-left: 5px;
	width: 600px;
	white-space: nowrap;
	overflow: hidden;
	line-height: 25px;
	height: 25px;
	background-color: #dfe98f;
	display: block;
}
.fujianico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/free.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.zuoyeico {
	background: url("http://static.ebanhui.com/ebh/tpl/default/images/listen.jpg") no-repeat;
	height: 16px;
	width: 16px;
}
.liess i {
	display: inline;
    float: right;
    margin: 5px 5px 0 0;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(function(){
		if($.browser.msie&&$.browser.version=="6.0"&&$("html")[0].scrollHeight>$("html").height())
			$("html").css("overflowY","scroll");
	});
//-->
</SCRIPT>
</head>

<body>
<div class="cqliebiao">
<div class="cqlite">
<?= $folder['foldername']?>（目录）
</div>

<div class="cqmain">
<?php $i = 1; ?>
<?php foreach($sectionlist as $section) { ?>
		<h2 class="lanbiaot"><?= $section[0]['sname'] ?></h2>
		<ul>
		<?php foreach($section as $course) { 
		if($course['isfree'] == 0) {
		?>
		<li class="liess"><span style="float:left;width:42px;"><a href="javascript:;" onclick="javascript:tparent.showdialogs()"><i class="fujianico" title="开通学习"></i><i></i></a></span><a style="cursor: pointer;" class="sa" href="javascript:;" onclick="javascript:parent.showdialogs()"><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema"><?php echo $i ++ ?></em></li>
		<?php } else { ?>
		<li class="liess"><span style="float:left;width:42px;"><a href="javascript:freeplay('<?= $course['cwsource'] ?>','$v[cwid]','<?= str_replace("'"," ",$course['title']) ?>',1);"><i class="zuoyeico" title="免费试听"></i><i></i></a></span><a style="cursor: pointer;" class="sa" href="javascript:freeplay('<?= $course['cwsource']?>','<?= $course['cwid'] ?>','<?= str_replace("'"," ",$course['title']) ?>',1);"><?= $course['title'] ?><span>…………………………………………………………………………………………………………………………………………………………………………</span></a><em class="yema"><?php echo $i ++ ?></em></li>
		
<?php 
			}
		}
		?>
		</ul>
<?php } ?>
	</ul>
</div>
</div>
<?= $pagestr ?>
<?php $this->display('common/player'); ?>
</body>
</html>

