<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base target="_self" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<title>主观题上传-e板会在线作业</title>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<style>
body,td{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:#FCFDFD;color:#666666;margin:0px;padding:0px;font-size:12px;}
#up_upprogressbox{margin-top:-50px;margin-left:-101px;}
.fileinput {
    position: absolute;
}
.centerBtn3 {
    background: url("http://static.ebanhui.com/ebh/images/TestImageNoText_127x29.png") repeat scroll 0 0 transparent;
    width: 127px;
	border: 0 none;
    cursor: pointer;
    font-size: 14px;
    height: 29px;
    line-height: 29px;
    outline: medium none;
	position: absolute;
}
.fileinput{
	position:relative;display:block;zoom:1;cursor:pointer;overflow:hidden;vertical-align:middle; width: 127px;height:29px;
	margin-left:95px;
	margin-top:50px;
}
.upiptfile{
	/*filter:Alpha(Opacity=0);opacity:0;width:127px;height:29px;cursor: pointer;*/
	position:absolute;right:0;top:0;_zoom:30;font-size:300px\9;height:29px;_height:29px;opacity:0;filter:alpha(opacity=0);-ms-filter:"alpha(opacity=0)";cursor:pointer;
}
.loadfile{
	margin-left: 50px;
    margin-top: 50px;
	display:none;
}
</style>
<script type="text/javascript">
<!--
	function uploadcallback(obj){
		$('form').submit();
	}
	function checktype(val){
//		if(!val.match(/.*\.(jpg|jpeg|gif|bmp|ebhp)/i)){
		 if(!val.match(/.*\.(jpg|jpeg|gif)/i)){
			alert("仅支持JPG和GIF图片格式！");
			return;
		}
		$('.fileinput').hide();
		$('.loadfile').show();
		document.uploadfile.submit()
	} 
		$(function(){
			$('.upiptfile').mouseover(function(){
				$('.centerBtn3').css({'background-position':'0 29px'});
			}).mouseout(function(){
				$('.centerBtn3').css({'background-position':'0 0'});
			}).click(function(){
				$('.centerBtn3').css({'background-position':'0 58px'});
			});
		});
//-->
</script>
</head>
<body>
<div id="main">
<form id="uploadfile" name="uploadfile" action="<?= geturl('uploadsubjective') ?>" method="post" enctype="multipart/form-data">
	<div class="fileinput">
		<input type="hidden" name="qid" value="<?= $qid ?>" target="uploadframe" >
		<input class="centerBtn3" type="button" value="上传主观题" style="">
		<input id="UpFile" class="upiptfile" type="file" name="upfile" size="40" onchange="checktype(this.value)" style="">
	</div>
	<div class="loadfile">
		<img src="http://static.ebanhui.com/ebh/tpl/default/images/uploadfile.gif">
	</div>
</form>
<iframe id="uploadframe" name="uploadframe" style="display:none;"></iframe>
</div>
</body>
</html>