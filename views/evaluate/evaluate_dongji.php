<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/psytest.js"></script>
<div class="redsrt">
<h2 class="hrrty">学习动机测试</h2>
<p class="rgiege">学习动机是直接推动学生进行学习的内在原因，是激励和指引学生学习的强大动力。学习动机的主要成分是学习自觉性与认识兴趣，学生一旦产生了自觉性，他就会对学习迸发出极大地热情，表现出坚毅精神，产生积极行动。因此，了解和重视学生的学习动机，培养和激发学习动机，是一个非常重要的事情！赶紧来测试一下，你的学习动机有多强吧！</p>
<p class="dgeod">请你对以下每种情况与自己的<span style="color:#FF0000;">是否</span>符合作一个判断：</p>
<form id="mainform" action="/myroom/evaluate/result.html?ttype=0" method="post">
<input type="hidden" id="page"  name="page" value="1"  autocomplete="off" />
<input type="hidden"  id="maxpage"  name="maxpage" value="<?=ceil(count($evaluate_dongji)/10)?>" autocomplete="off"  />
<ul>
<?php
foreach($evaluate_dongji as $k=>$q){
	$yesvalue = !($k%2 && 1);
	$novalue = !$yesvalue;
	$hideclass = '';
	if($k/10 > 1)
		$hideclass = 'inithide';
?>
<li class="fgngr <?=$hideclass?> page<?=ceil($k/10)?>" id="li<?=$k?>">
<p ><?=$k?>.<?=$q?></p>
<label><span class="greigd"><input name="q<?=$k?>" type="radio" value="<?=$yesvalue?>" class="radios"/> 是</span></label>
<label><span class="greigd"><input name="q<?=$k?>" type="radio" value="<?=$novalue?>" class="radios"/> 否</span></label>
</li>
<?php
}
?>
</ul>
<div class="pagebtndiv">
<div id="feeds_more" class="feeds-more" >
<a href="javascript:void(0)"><span class="feeds-loading">加载更多</span></a>
</div>
</div>
</form>
<a href="javascript:void(0)" class="brifbtn"  style="display:none" onclick="submit()"></a>
</div>