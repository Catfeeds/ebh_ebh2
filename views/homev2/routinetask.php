<?php $this->display('homev2/header'); ?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/jfxt.css" rel="stylesheet" type="text/css" />
<?php $this->display('homev2/top'); ?>
<div class="divcontent">
<div class="conentlft">
<div class="topbaad">
<div class="rule" style="width:auto;">
	<div class="lefrig" style="background:#fff;margin-top:10px;float:left;">
		<div class="work_menu" style="width:786px; position:relative;margin-top:0px;margin-bottom:10px;">
			<ul>
				 <li class="workcurrent"><a href="/homev2/score/routinetask.html" style="font-size:16px;"><span>常规任务</span></a></li>
				 <li><a href="/homev2/score/credit.html" style="font-size:16px;"><span>积分明细</span></a></li>
				 <li><a href="/homev2/score/record.html" style="font-size:16px;"><span>兑换记录</span></a></li>
				<li><a href="/homev2/score/description.html" style="font-size:16px;"><span>积分说明</span></a></li>
				<!-- <li><a href="/homev2/score/lottery.html" style="font-size:16px;"><span>积分兑换</span></a></li> -->
			</ul>
		</div>
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
		$homeurl = 'www'.'.'.$this->uri->curdomain;
		if(!empty($room)) {
			$homeurl = empty($room['fulldomain']) ? $room['domain'].'.'.$this->uri->curdomain : $room['fulldomain'];
		}
		if(substr($tl['url'],0,8)=='[domain]'){
			$tl['url'] = 'http://'.$homeurl.'/'.substr($tl['url'],8).'.html';
		}
		else{
			$tl['url'] = 'http://'.$homeurl.'/'.$tl['url'].'.html';
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
	$tl['url'] = preg_replace('/\/myroom\/settings/', '/homev2/profile', $tl['url']);
	$tl['url'] = preg_replace('/\/home\//', '/homev2/', $tl['url']);
?>
<?php
	if(!$tl['isactive']){
	?>
<a href="<?=$tl['url']?>" class="jobbtn" >去做任务</a>
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
</div>
<div class="cotentrgt">
<img src="http://static.ebanhui.com/ebh/tpl/2016/images/rgtimg.jpg" />
</div>
</div>
<?php $this->display('homev2/footer');?>