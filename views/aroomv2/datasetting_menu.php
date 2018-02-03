<?php
$pcode = 'aroom/datasetting';
$menus = array(
	array('codepath'=>$pcode,'name'=>'公告管理'),
	array('codepath'=>$pcode.'/information','name'=>'资讯管理'),
	array('codepath'=>$pcode.'/advertisement','name'=>'广告管理')
);

?>
<div class="tab_menu" style="margin-top: 10px;height: 40px;">
	<ul>
		<?php foreach($menus as $menu) {?>
		<li <?= $this->uri->codepath==$menu['codepath'] ? 'class="workcurrent"':'' ?>><a href="<?= geturl($menu['codepath'])?>"><?= $menu['name'] ?></a></li>
		<?php } ?>
	</ul>
</div>