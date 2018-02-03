<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/newschoolindex/css/courseware.css">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<title>我的单课列表</title>
<style>
.return {width:20px;height:20px;vertical-align: sub;margin-right:10px;}
</style>
</head>

<body style="background:none">
<div class="ement" >
	<div class="stktitl">
	<h3 class="lstfd" style="margin-top:10px;"><a class="return" href="javascript:history.go(-1)" title="返回上级"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/return.png" /></a>我的单课列表</h3>
	<div style="clear:both;"></div>
	<div class="diles">
	<input id="title" class="newsou" name="txtname" value="<?=empty($q)?'':$q?>" style="color: rgb(165, 165, 165);" type="text">
	<input id="ser" class="soulico" value="" type="button">
	</div>
	</div>
	
<table class="datatabes" width="100%">
	<?php $this->display('college/cwlist_cwpay')?>
	
</table>
</div>

</body>
<script>

var init;
$(function(){
	
	top.$('#mainFrame').width(1000);
	top.$('.rigksts').hide();

});


var searchtext = "请输入搜索关键字";
$(function(){
	initsearch("title",searchtext);
});
$("#ser").click(function(){
		var title = $("#title").val();
		if(title == searchtext)
			title = "";
		var url = '<?= geturl('myroom/college/study/mycws') ?>' + '?q='+title;
		
		document.location.href = url;
	});


function initsearch(id,value) {
   if($("#"+id).val() == "") {
       $("#"+id).val(value);
       $("#"+id).css("color","#A5A5A5");
   }
   if($("#"+id).val() == value) {
       $("#"+id).css("color","#A5A5A5");
   }
   $("#"+id).click(function(){
       if($("#"+id).val() == value) {
           $("#"+id).val("");
           $("#"+id).css("color","#323232");
       }
   });
   $("#"+id).blur(function(){
       if($("#"+id).val() == "") {
           $("#"+id).val(value);
           $("#"+id).css("color","#A5A5A5");
       }
   });
}

</script>
</html>
