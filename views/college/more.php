<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />
	<meta name="viewport"  content="user-scalable=no">
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css<?=getv()?>"/>
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<style>
		.cmain_top_r .esukang{width:100% !important;}
	</style>
</head>
<body style="background:none">
<?php
        $roominfo = Ebh::app()->room->getcurroom();
        $roominfo['crid'] = empty($roominfo['crid'])?0:$roominfo['crid'];
        if(!empty($roominfo['crid'])){
        	$appsetting = Ebh::app()->getConfig()->load('othersetting');
	        $appsetting['zjdlr'] = !empty($appsetting['zjdlr']) ? $appsetting['zjdlr'] : 0;
	        $appsetting['newzjdlr'] = !empty($appsetting['newzjdlr']) ? $appsetting['newzjdlr'] : array();
	        $is_zjdlr = ($roominfo['crid'] == $appsetting['zjdlr']) || (in_array($roominfo['crid'],$appsetting['newzjdlr']));
	        $is_newzjdlr = in_array($roominfo['crid'],$appsetting['newzjdlr']); 
        }
?>
<div class="cmain_bottoms ">
	<h3>更多>></h3>
	<ul>
		<?php foreach($modulelist as $module){
			$url = str_replace('[crid]',$roominfo['crid'],$module['url']);
			$url = str_replace('[domain]',$roominfo['domain'],$url);
			$url = str_replace('[uid]',$user['uid'],$url)
			?>
			<li class="<?=$module['classname']?> fl"><a href="<?=$url?>" target="<?= empty($module['target']) ? '' : $module['target'] ?>"><img src="http://static.ebanhui.com/ebh/tpl/2016/images/titleico/myroom/90/<?=$module['classname']?>.png"/><p><?=!empty($module['nickname'])?$module['nickname']:$module['modulename']?></p></a></li>
		<?php }?>
		<!--
		<li class="gerenxinxi fl"><a href="/homev2/profile/profile.html?ht=1"></a></li>
		<li class="jifenjihua fl"><a href="/home/score.html"></a></li>
		<?php if($this->uri->uri_domain() != 'zjgxedu' && (!$is_zjdlr)) { ?>
			<li class="chengzhjl fl"><a href="/college/ghrecord.html"></a></li>
		<?php } ?>
		<?php if(!$is_zjdlr){ ?>
		<li class="wodekongjian fl"><a href="http://sns.ebh.net" target="_blank"></a></li>
		<?php }?>
		<?php if($this->uri->uri_domain() != 'zjgxedu' && (!$is_zjdlr)) { ?>
			<li class="wodewangxiao fl"><a href="/homev2.html" target="_top"><span id="myspan"><?=$roomcount?></span></a></li>
		<?php } ?>
		<li class="wodetongxue fl"><a href="/college/classmate.html"></a></li>
		<li class="myclass fl"><a href="/college/myclass.html"></a></li>
		-->
	</ul>
</div>




</body>
<script>
	$(function(){
		top.$('#mainFrame').width(1000);
		top.$('.rigksts').hide();
	});
</script>
</html>