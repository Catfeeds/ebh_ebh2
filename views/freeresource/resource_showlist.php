<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://static.ebanhui.com/portal/css/ebhportal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/custom/jquery-ui.min.css" rel="stylesheet" /> 
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui.min.js"></script>
<title><?=empty($seoInfo['title'])?$this->get_title():$seoInfo['title']?></title>
<meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
<meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
</head>
<body>

<!--list start-->
<div class="rgjuet">
<?=$topStr?>
<div class="sotuds">
<?php if($showSearchInput) {?>
<input type="text" value="<?=empty($q)?'输入名称':$q?>" id="listsearch" name="listsearch" class="txtnamte">
<a href="javascript:void(0)" onclick="_search()" class="dsoubtn"></a>
<?php }?>
</div>
</div>

<div class="birute" style="width:796px;">
<table class="datader" width="100%">
<thead class="tabhead">
<tr class="">
<th>序号</th>
<th>资源名称</th>
<th>浏览/下载</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($resourceList as $key => $value) {?>  
<tr class="<?php if ($key%2 != 0) echo 'huist';?>">
<td width="7%"><?=$offset+$key+1?></td>
<td width="53%" style="text-align:left"><?=$value['title']?></td>
<td width="19%"><?=$value['viewnum']?>/<?=$value['downloadnum']?></td>
<td width="21%">
<a class="krgebtn" style="margin-right:10px;" target="_blank" href="/freeresource/resource/<?=$value['resid']?>.html">预览</a>
<a class="krgebtn" href="/freeresource/resource/attach.html?attachid=<?=$value['resid']?>" target="_blank">下载</a>
</td>
</tr>    
<?php }?>
</tbody>
</table>
</div>
<!--list and-->

<div>    
    <p><?=$pageStr?></p>
</div>
<?php if($showSearchInput) {?>
<script>
	$(function(){
		initsearch("listsearch","输入名称");
	});
	function _search(){
		var q = $("#listsearch").val();
		if(q=='输入名称'){
			location.href="<?=$searchPath?>";
		}else{
			location.href="<?=$searchPath?>?q="+q;
		}
		
	}
</script>
<?php }?>

<?php
debug_info();
?>
<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu')?>
<!-- 统计代码结束 -->
</body>
</html>