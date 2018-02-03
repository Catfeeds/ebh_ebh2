<?php
$pcode = 'troomv2/tplsetting';
$menus = array(
	array('codepath'=>$pcode,'name'=>'公告管理'),
	array('codepath'=>$pcode.'/teacherteam','name'=>'师资团队'),
	array('codepath'=>$pcode.'/information','name'=>'资讯管理'),
	array('codepath'=>$pcode.'/advertisement','name'=>'广告管理'),
	array('codepath'=>$pcode.'/contact','name'=>'联系方式')
);

?>
<div class="tab_menu" style="margin-top: 10px;height: 40px;">
	<ul>
		<?php foreach($menus as $menu) {?>
		<li <?= $this->uri->codepath==$menu['codepath'] ? 'class="workcurrent"':'' ?>><a href="<?= geturl($menu['codepath'])?>"><?= $menu['name'] ?></a></li>
		<?php } ?>
	</ul>
</div>