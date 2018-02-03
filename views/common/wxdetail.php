<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2014/css/stbact.css" />
<title>详细消息</title>
<style>
	.goback{
		color:#2aa0e6;margin-left: 2%;text-align:left;width:98%;height:30px;line-height:30px;font-size:16px;font-weight:bold;
	}
</style>
</head>

<body>
<?php if(!empty($frompage)){?>
<p class="goback" onclick="goback()"> < 返回</p>
<?php  }?>
<div class="eawut">
<div class="lietas" style="border:none;">
<div class="wtekss">
<?php 
	$face = getthumb($detail['send_uid_face'],'50_50');
	if(empty($face)){
		if($detail['sex']==1){
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
		 }else{ 
			$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
		 }

		 $face = getthumb($defaulturl,'50_50');
	}
?>
<img src="<?=$face?>" />
</div>
<p class="sneitx" style="margin-top:10px;">发布人：<?=$detail['send_uid_name']?></p>
<p class="sneitx">时　间：<?= date("Y年m月d日H:i",$detail['dateline']);?></p>
</div>
<div class="xiangset">
<?=$detail['weixin_content']?>
</div>
</div>

<script>
	function goback(){
		history.go(-1);
	}
</script>
</body>
</html>
