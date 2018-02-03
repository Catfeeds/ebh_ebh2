<?php
$this->display('myroom/page_header');
?>
<style>
.annuato a.fabtns {
	width:76px;
	height:23px;
	line-height:23px;
	color:#fff;
	text-decoration:none;
	font-size:12px;
	float:right;
	background:#4fcffd;
	border:solid 1px #108ed4;
	text-align:center;
}
.rertk {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/lanicoo.jpg) no-repeat 0px 30px;
	padding-left:20px;
	margin-top:12px;
	margin-left:20px;
	height:49px;
}
.keutsu {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/jindubg.jpg) no-repeat;
	width:680px;
	padding:1px;
	height:24px;
	float:left;
}
.lanbg {
	background:#4f8df0;
	height:12px;
	float:left;
}
.lefrig {
	color:#7a7a7a;
}
.rertkss {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/chengicoo.jpg) no-repeat 0px 30px;
	padding-left:20px;
	margin-top:12px;
	margin-left:20px;
	height:45px;
}
.keutsus {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/jindubg.jpg) no-repeat;
	width:580px;
	padding:1px;
	height:24px;
	float:left;
}
.keute {
	background:url(http://static.ebanhui.com/ebh/tpl/default/images/wejitue.jpg) no-repeat;
	width:680px;
	padding:1px;
	height:13px;
	margin-top:6px;
	float:left;
}
.dengbg {
	background:#f39c0a;
	height:24px;
	float:left;
}
.wekrr {
	margin-bottom:4px;
	float:left;
}
.waispan{
	width:500px;
	float:left;
}
</style>

<body>
<div class="ter_tit" style="margin-bottom:15px;"> 当前位置 > <a href="<?=geturl('myroom/analysis')?>">学习分析表</a> > <a href="<?=geturl('myroom/progress')?>">课程学习进度</a> > 进度详情 </div>
<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;">
<div class="annuato" style="line-height:28px;padding-left:20px;position: relative;border-bottom:dashed 1px #e2e2e2;"><a href="javascript:history.go(-1)" class="fabtns">返 回</a></div>
<div class="rertkss">
<span class="waispan">
<span class="wekrr" style="color:#3d3d3d;"><?=$folder['foldername']?> 总进度：</span>
</span>
<div class="keutsu">
<span class="dengbg" style="width:<?=$percentavg?>%;"></span>
</div>
<span style="float:left;height:23px;line-height:23px;margin-left:10px;font-size:14px;"><?=$percentavg?>%</span>
</div>

<?php 
if(!empty($coursewarelist)){
foreach($sectionlist as $section){
if(count($section)>1){
?>

<h2 style="font-weight:bold;margin-top:20px;margin-left:20px;color:#2696F0"><?=$section['name']?></h2>
<?php }?>
<ul>
<?php 
foreach($section as $k=>$cw){
	if(is_array($cw)){
$arr = explode('.',$cw['cwurl']);
$type = $arr[count($arr)-1]; 
?>

<li class="rertk">
<span class="waispan">
<a href="<?=geturl('myroom/mycourse/'.$cw['cwid'])?>" class="wekrr" target="<?= (empty($cw['cwurl']) || $type == 'flv') ? '_blank' : '' ?>"><?=$cw['title']?></a></span>
<div class="keute">
<span class="lanbg" style="width:<?=$cw['percent']?>%;"></span>
</div>
<span style="float:left;height:23px;line-height:23px;margin-left:10px;font-size:14px;"><?=$cw['percent']?>%</span>
</li>
<?php }}?>
</ul><?php }?>
<?php }?>
</div>

</body>
</html>
