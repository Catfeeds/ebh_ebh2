<?php $this->display('troom/page_header'); ?>
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/css/statch.css" />
<div class="ter_tit"> 当前位置 > <a href="<?= geturl('troom/weixin') ?>">微家校通</a> > <a href="<?= geturl('troom/weixin/list_msg') ?>">发信历史</a> >内容浏览</div>
<div class="lefrig"  style="background:#fff;float:left;margin-top:15px;width:788px;">
<div class="waiyry">
<div class="chouad" style="height:auto">
<span class="shyten">收件人：</span>
<div class="ewater">
<ul id="wrap2">
<?php foreach ($msgInfo['classnames'] as $classname) {?>
  <li class="lantewu"><?=$classname?></li>
<?php }?>
<?php foreach ($msgInfo['usernames'] as $username) {?>
  <li class="lvtewu"><?=$username?></li>
<?php }?>
</ul>
</div>
</div>
<div style="width:697px; margin:0 auto;"><textarea class="txttiantl" name="summary" disabled=true><?=$msgInfo['content']?></textarea></div>
<div class="wtkkr">
<a href="javascript:window.history.go(-1)" class="tjewkc">返 回</a>
</div>
</div>
</div>
</div>
<?php $this->display('troom/page_footer');?>