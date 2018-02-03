<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/point.css" />
<link type="text/css" href="/static/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<script src="http://static.ebanhui.com/ebh/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
<title>您的服务已过期~~~</title>
</head>
<?php $this->display('common/public_header'); ?>
<body style="background-color:#ebebeb;">
<div class="point">
	<div class="main">
		<div class="zhonn">
			<div class="lefnn">
				<div class="tuku">
					<img src="http://static.ebanhui.com/ebh/tpl/2012/images/xiang1229.jpg" />
				</div>
				<div class="tsyu">
					<p style="color:#aaa7a7"><span class="lansize"><?= empty($user['realname']) ? $user['username']:$user['realname'] ?></span> 您好！ 欢迎登录<?= $room['crname'] ?>！</p>
					<p class="waits">温馨提示：<span style="color:#f27245;">您的服务已到期！</span></p>
				</div>
				<div class="foncz">
					<h3 class="titcz"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/titjixu0104.jpg" /></h3>
					<ul>
					<li class="chongzhi"><a href="<?=geturl('classactive') ?>" class="tsbtn" style="color:#fff;">充值缴费</a></li>
					<li class="guanli"><a href="<?=geturl('member') ?>" class="tsbtn" style="color:#fff;">个人中心</a></li>
					<li class="shouye"><a href="<?= 'http://'.$room['domain'].'.ebanhui.com/' ?>" class="tsbtn" style="color:#fff;">平台首页</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<?php $this->display('common/footer'); ?>