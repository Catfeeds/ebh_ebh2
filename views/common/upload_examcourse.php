<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base target="_self" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<title>课件上传-e板会在线作业</title>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/css/upload.css" rel="stylesheet" />	
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/upload.js"></script>
<style>
body,td{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin:0px;padding:0px;font-size:12px;}
#up_upprogressbox{margin-top:-50px;margin-left:-101px;}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function uploadcallback(obj){
		$('form').submit();
	}
//-->
</SCRIPT>
</head>
<body>
<div id="main" style="font-size:12px;padding-top:50px;padding-left:101px;">
<form action="<?= geturl('uploadexamcourse')?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="qid" value="<?= $qid ?>" >
		<?php $upcontrol->upcontrol('up',$type=10,$valueparam=array(),$uptype='courseware',array('button_image_url'=>'http://static.ebanhui.com/ebh/images/TestImageNoText_127x29.png','button_width'=>'127','button_text'=>'&nbsp;&nbsp;上传解析课件')); ?>
</form>
</div>
</body>
</html>