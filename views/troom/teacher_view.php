<?php $this->display('troom/page_header'); ?>
<?php
if ($teacher['sex'] == 1) {
    $default = 'http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
} else {
    $default = 'http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
}
$face = empty($teacher['face']) ? $default : $teacher['face'];
$face = getthumb($face, '120_120');
?>
	 <div class="ter_tit">
		当前位置 > <a href="<?= geturl('troom/teacher') ?>">教师管理</a> > 修改教师
  </div>
	<div class="lefrig">
<div class="user_left">
	<div class="usertx"><img width="120px" height="120px" src="<?= $face ?>" /></div>
</div>
<div class="user_right">
	<div class="user_info_tit">基本信息</div>
	<dl>
		<dt>登录账号：</dt>
		<dd><?= $teacher['username'] ?></dd>
		<dt>昵　　称：</dt>
		<dd><?= $teacher['nickname'] ?></dd>
		<dt>真实姓名：</dt>
		<dd><?= $teacher['realname'] ?></dd>
		<dt>性　　别：</dt>
		<dd><?= $teacher['sex'] == 1 ? '女':'男' ?></dd>
		<dt>教　　龄：</dt>
		<dd><?= $teacher['schoolage'] ?></dd>
	</dl>
	<div class="clear"></div>
	<div class="user_info_tit"><span style="float:right; padding-right:10px;"></span>相关介绍</div>
	<dl>
		<dt>相关介绍：</dt>
		<dd><?= $teacher['profile'] ?></dd>
	</dl>
</div>
</div>
<div class="clear"></div>
<?php $this->display('troom/page_footer'); ?>