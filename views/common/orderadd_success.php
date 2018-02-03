<?php $this->display('common/site_header');?>
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/open.css" rel="stylesheet" type="text/css" />
<div style="background:url(http://static.ebanhui.com/ebh/tpl/2012/images/bg12511.jpg) repeat-y scroll 0 0; height:auto;">
<div class="main" style="height:auto;overflow:hidden;">
<div class="aed"><p>欢迎开通【<?= $roominfo['crname']?>】服务</p></div>
<div class="slst" style="height:420px;">
<div class="suc">
	<p style="padding-top:80px;">您好 <?= $user['username'] ?> ，您已成功提交汇款资料，请耐心等待客服审核</p>
	<p style="line-height:3">现在您可以点击
	<label>
		<input style="cursor:pointer;margin:0;" type="button" onclick="window.location.href='<?= '/myroom.html'?>'" name="dengl" class="dengl"  value="马上学习" />
	</label> 进入学习中心。
	</p>	 
</div>
</div>
<?php $this->display('common/site_right'); ?>
</div>
  <div class="footlintbg">
<img width="970" height="16" src="http://static.ebanhui.com/ebh/tpl/2012/images/doot5111.jpg">
</div>
</div>
<div style="clear:both;"></div>
<?php $this->display('common/site_footer'); ?>