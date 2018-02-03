<?php $this->display('home/page_header'); ?>
<div class="topbaad">
<?php
$this->assign('menuid',3);
?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<div class="rule" style="width:auto;">
	<div class="lefrig" style="background:#fff;margin-top:15px;float:left;">
<?php
$this->assign('type','score');
$this->display('home/simplate_menu');
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
		if($i%2==0){
			$xiaxia='class="xiaxia"';
		}
			
		if(substr($tl['url'],0,8)=='[domain]'){
			$tl['url'] = 'http://'.(!empty($room)?$room['domain']:'www').'.'.$this->uri->curdomain.'/'.substr($tl['url'],8).'.html';
		}
		else{
			$tl['url'] = 'http://'.(!empty($room)?$room['domain']:'www').'.'.$this->uri->curdomain.'/'.$tl['url'].'.html';
		} 
			
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
	$tl['url'] = preg_replace('/\/myroom\/settings/', '/home/profile', $tl['url']);
?>
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

</div>
</div>
</div>
<div style="clear:both;"></div>