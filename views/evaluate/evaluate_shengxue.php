<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/psytest.js"></script>
<div class="redsrt">
<h2 class="hrrty">升学择业测评</h2>
<p class="rgiege">高考临近，考前摸底测试、模拟测试也逐渐增多，这些考分一定程度上反映出了学生在不久后高考的分数，而高考分数对学生的未来有很重要的影响。有一些学生很容易因为测试成绩的好坏造成情绪的波动，严重的甚至产生了心里问题。有资料显示，20%的高考生存在着考前焦虑综合征。提前预防，防患未然迫在眉睫。赶紧来自测下，你是否有焦虑症吧。
<br />下面有33道题，每道题都有4个备选答案，请根据自己的实际情况，在题目后面圈出相应字母，每题只能选择一个答案。</p>
<form id="mainform" action="/myroom/evaluate/result.html?ttype=3" method="post">
<input type="hidden" id="page"  name="page" value="1"  autocomplete="off" />
<input type="hidden"  id="maxpage"  name="maxpage" value="<?=ceil(count($evaluate_shengxue)/10)?>" autocomplete="off"  />
<ul>
<?php
foreach($evaluate_shengxue as $k=>$q){
	if(!is_array($q)){
	$hideclass = '';
	if($k/10 > 1)
		$hideclass = 'inithide';
?>
<li class="fgngr <?=$hideclass?> page<?=ceil($k/10)?>" id="li<?=$k?>">
<p><?=$k?>.<?=$q?></p>
<label><span class="greigd"><input name="q<?=$k?>" type="radio" value="1" class="radios"/> 是</span></label>
<label><span class="greigd"><input name="q<?=$k?>" type="radio" value="0" class="radios"/> 否</span></label>
</li>
<?php
	}
}
?>
</ul>
<div class="pagebtndiv">
<div id="feeds_more" class="feeds-more">
<a href="javascript:void(0)"><span class="feeds-loading">加载更多</span></a>
</div>
</div>
</form>
<a href="javascript:void(0)" class="brifbtn"   style="display:none" onclick="submit()"></a>
</div>
