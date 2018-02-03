<?php $indexarr = array('','','','','','','','');
	$indexarr[$currentindex] = 'xhusre';
	$classid = $this->input->get('classid');
	?>
<div class="lishnrt">
	<a class="hietse <?=$indexarr[0]?>" href="/troomv2/classsubject/coursecount/cw.html?folderid=<?=$folderid?>&classid=<?=$classid?>">课件学习统计</a>
	<a class="hietse <?=$indexarr[1]?>" href="/troomv2/classsubject/coursecount/exam.html?folderid=<?=$folderid?>&classid=<?=$classid?>">作业统计</a>
	<a class="hietse <?=$indexarr[2]?>" href="/troomv2/classsubject/coursecount/ask.html?folderid=<?=$folderid?>&classid=<?=$classid?>">答疑统计</a>
	<?php if(!empty($roominfo) && $roominfo['property'] == 3){?>
	<a class="hietse <?=$indexarr[3]?>" href="/troomv2/classsubject/coursecount/credit.html?folderid=<?=$folderid?>&classid=<?=$classid?>">学分统计</a>
	<?php }?>
	<!--
	<a class="hietse <?=$indexarr[3]?>" href="/troomv2/classsubject/coursecount/iclass.html?folderid=<?=$folderid?>">互动统计</a>
	-->
</div>