<div class="matchtitle"><?=$actdetail['subject']?></div>
	<?php 
	$indexarr = array('','','','','');
	$indexarr[$index] = ' class="workcurrent" ';
	?>
	<div class="work_menu" style="position:relative;margin-top:0;">
		<ul>
			<li <?=$indexarr[1]?>><a href="/college/activity/intro/<?=$actdetail['aid']?>.html"><span>活动介绍</span></a></li>
			<li <?=$indexarr[2]?>><a href="/college/activity/rank/<?=$actdetail['aid']?>.html"><span>我的排名</span></a></li>
			<li <?=$indexarr[3]?>><a href="/college/activity/credit/<?=$actdetail['aid']?>.html"><span>积分记录</span></a></li>
			<li <?=$indexarr[4]?>><a href="/college/activity/descriptioninact/<?=$actdetail['aid']?>.html"><span>积分规则</span></a></li>
		</ul>
	</div>