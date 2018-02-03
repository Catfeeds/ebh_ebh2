<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/creport.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<title>网校信息统计</title>
</head>
<body>
<div class="ter_tit">
当前位置 > <a href="<?=geturl('croom/creport')?>">网校信息统计</a>
</div>

<?php if(!empty($curcity)){
	$cityname = $curcity['cityname'];
	$cityname = (strlen($curcity['citycode']) == 4 && strpos($cityname,'市') === false) ? $cityname.'市' : $cityname;
	}else{$cityname='';}?>
<div class="lefrig">
<div class="annotate"><?=$cityname?> 内共有云教育网校 <span class="cujia"><?=$reportinfo['crnum']?></span> 所，教师 <span class="cujia"><?=$reportinfo['teanum']?></span> 名，学生 <span class="cujia"><?=$reportinfo['stunum']?></span> 名。<br />
截止目前，共有课件 <span class="cujia"><?=$reportinfo['coursenum']?></span> 个，作业 <span class="cujia"><?=$reportinfo['examnum']?></span> 个，答疑 <span class="cujia"><?=$reportinfo['asknum']?></span> 题。</div>
<div class="xiapai">

<div id="icategory" class="clearfix">
<dt>所属区县：</dt>
<dd>
<div class="category_cont1">
<div>
<?php $scitycode = empty($scitycode) ? $citycode : $scitycode;
$cityselect[$scitycode] = 'curr'?>
<a class="<?=empty($cityselect[$citycode])?'':$cityselect[$citycode]?>" href="<?=geturl('croom/creport')?>">所有区县</a>
</div>

<?php foreach($citylist as $city){
$cityurl = geturl('croom/creport-0-0-0-'.$city['citycode']);
?>
<div>
<a class="<?=empty($cityselect[$city['citycode']])?'':$cityselect[$city['citycode']]?>" href="<?=$cityurl?>"><?=$city['cityname']?></a>
</div>
<?php }?>

<div>
</div>
</dd>
</div>


<div class="soles">
<span>关键词：</span>
<input name="textfield" type="text" class="txtlan" value="<?=$q?>" />
<input class="sobtn" type="button" name="Submit" value="" />
</div>
<div class="derste">
<?php if(!empty($classroomlist)){?>
<ul>


<?php foreach($classroomlist as $myreport){
$logo=empty($myreport['cface'])?'http://static.ebanhui.com/ebh/tpl/default/images/elist_tx.jpg':$myreport['cface']
?>
<li>
<div class="jianame">
<img src="<?=$logo?>" />
</div>
<div class="rigjiao">
<h2 class="titxue"><?=$myreport['crname']?></h2>
<p class="zicol"><?=ssubstrch($myreport['summary'],0,180)?>...</p>
<p>教师数量：<span class="lanse"><?=$myreport['teanum']?></span><span class="huixian">|</span>学员数量：<span class="lanse"><?=$myreport['stunum']?></span><span class="huixian">|</span>课件数量：<span class="lanse"><?=$myreport['coursenum']?></span><span class="huixian">|</span>作业数量：<span class="lanse"><?=$myreport['examnum']?></span><span class="huixian">|</span>答疑数量：<span class="lanse"><?=$myreport['asknum']?></span></p>
</div>
</li>
<?php }?>

</ul>
<?=show_page($classroomcount)?>
<?php }else{?>

<ul>
<li>
对不起，暂无数据
</li>
</ul>
<?php }?>

</div>
</div>
</div>
<script type="text/javascript">
$(function(){
if($.trim($(".txtlan").val()) == "") {
$(".txtlan").val("请输入网校名称");
}
$(".txtlan").focus(function(){
if($.trim($(".txtlan").val()) == "请输入网校名称")
$(".txtlan").val("");
});
$(".txtlan").blur(function(){
if($.trim($(".txtlan").val()) == "")
$(".txtlan").val("请输入网校名称");
});
$(".sobtn").click(function(){
	var keyword = $.trim($(".txtlan").val());
	if(keyword == "请输入网校名称") {
		keyword = "";
	}
	keyword = keyword.replace(/,/g,"");
	keyword = keyword.replace(/\'/g,"");
	keyword = keyword.replace(/\"/g,"");
	keyword = keyword.replace(/\//g,"");
	keyword = keyword.replace(/%/g,"");
	keyword = keyword.replace(/_/g,"");
	keyword = keyword.replace(/#/g,"");
	keyword = keyword.replace(/\?/g,"");
	keyword = keyword.replace(/\\/g,"");
	var url = "/croom/creport-0-0-0-<?=$scitycode?>.html";
	url+= '?q='+keyword;
	document.location.href = url;
	});
});
</script>
</body>
</html>