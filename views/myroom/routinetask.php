<?php $this->display('myroom/page_header'); ?>
<div class="topbaad">
<?php
$this->assign('menuid',3);
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css" rel="stylesheet" type="text/css" />
<div class="rule" style="width:auto;">
	<div class="ter_tit" style="position: relative;">
	当前位置 > 我的积分 > 常规任务
	</div>
	<div class="lefrig" style="background:#fff;border:solid 1px #cdcdcd;margin-top:15px;float:left;">
<?php
$this->assign('type','score');
$this->display('member/simplate_menu');
?>
<div class="nave">
<h2>新手任务</h2>
<ul>
<?php
$i=1;
foreach($tasklist as $tl){
	$xiaxia='';
	//$active=1;
	$activeclass = 'class="rigsize"';
	if($tl['type']==1){
		if($i%2==0)
			$xiaxia='class="xiaxia"';
		if(substr($tl['url'],0,8)=='[domain]')
			$tl['url'] = 'http://'.(!empty($room)?$room['domain']:'www').'.'.$this->uri->curdomain.'/'.substr($tl['url'],8).'.html';
		else 
			$tl['url'] = 'http://'.$room['domain'].'.'.$this->uri->curdomain.'/'.$tl['url'].'.html';
		if(!$tl['isactive'])
			$activeclass = 'class="weijob"';
?>
<li <?=$xiaxia?>>
<div class="leftu1 sdcd" style="background:url('http://static.ebanhui.com/ebh<?=$tl['image']?>') no-repeat scroll center 15px transparent"></div>
<div <?=$activeclass?>>
<h3><?=$tl['name']?></h3>
<p>目标：<?=$tl['description']?></p>
<p>奖励：<?=$tl['reward']?></p>
</div>
<?php
	if(!$tl['isactive']){
	?>
<a href="<?=$tl['url']?>" class="jobbtn" target="_blank">去做任务</a>
<?php
}
?>
</li>
<?php
	$i++;
	}
}
?>
</ul>
</div>

<div class="nave">
<h2>学习任务</h2>
<ul>
<?php
$i=1;
foreach($tasklist as $tl){
	$xiaxia='';
	//$active=1;
	$activeclass = 'class="rigsize"';
	if($tl['type']==3){
		if($i%2==0)
			$xiaxia='class="xiaxia"';
		if(substr($tl['url'],0,8)=='[domain]'){
			$tl['url'] = 'http://'.(!empty($room)?$room['domain']:'www').'.'.$this->uri->curdomain.'/'.substr($tl['url'],8).'.html';
			if(!empty($room) && $room['isschool']==2)
				$tl['url'] = str_replace('stusubject','subject',$tl['url']);
		}
		else 
			$tl['url'] = 'http://'.$room['domain'].'.'.$this->uri->curdomain.'/'.$tl['url'].'.html';
		if(!$tl['isactive'])
			$activeclass = 'class="weijob"';
?>
<li <?=$xiaxia?>>
<div class="leftu5 sdcd"style="background:url('http://static.ebanhui.com/ebh<?=$tl['image']?>') no-repeat scroll center 15px transparent"></div>
<div <?=$activeclass?>>
<h3><?=$tl['name']?></h3>
<p>目标：<?=$tl['description']?></p>
<p>奖励：<?=$tl['reward']?></p>
</div>
	<?php
	if(!$tl['isactive']){
		if(empty($room)){
	?>
	<a href="javascript:alert('对不起，此任务需要您至少开通一个平台才能完成。')" class="jobbtn">去做任务</a>
	<?php 
		}else{
	?>
	<a href="<?=$tl['url']?>" class="jobbtn" target="_blank">去做任务</a>
	<?php
		}
	}
	?>
</li>
<?php
	$i++;
	}
}
?>

</ul>
</div>
</div>
</div>
</div>
<div style="clear:both;"></div>