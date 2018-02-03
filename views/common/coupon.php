<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/base.css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2016/css/personal.css<?=getv()?>" />
<title>优惠码 - e板会</title>
<meta name="keywords" content="优惠码" />
<meta name="description" content="优惠码是e板会网校平台的优惠凭证。开通e板会平台所有课程尊享优惠价格。" />
<style>
.fldty {
    margin: 50px auto 20px;
    width: 100%;
}
</style>
</head>

<body>
<div class="fffwaist hei90" style="background: #fff">
	<div class="headswe">
        <a class="lortebh" href="/">
        	<img src="http://static.ebanhui.com/portal/images/ebh_logo.jpg?v=20160405001">
        </a>
        <img src="http://static.ebanhui.com/portal/images/ebh_wenlogo.jpg?v=20160405001">
    </div>
</div>
<?php if (!empty($mycoupon['code'])){?>
<div class="khtgfs">
	<div class="headswe">
        <span class="ljetewt">优惠码：<?=$mycoupon['code']?></span>
        <span class="kehrtt"><?=empty($roominfo['crname']) ? '&nbsp;' : '<a class="kjret" href="http://'.$roominfo['domain'].'.ebh.net/" target="_blank"><span class="lstrjsr">进入 </span>'.$roominfo['crname'].' ></a>'?></span>
    </div>
</div>
<?php }?>
<div class="fffwaist">
	<div class="headswe">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jkwet2.jpg?v=20160405001" />
    </div>
</div>
<div class="khuster">
	<div class="kereyre">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jkwet3.jpg?v=20160405001" />
    </div>
</div>
<div class="fffwaist">
	<div class="headswe">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jkwet4.jpg?v=20160405001" />
    </div>
</div>
<div class="khuster">
	<div class="kereyre">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jkwet5.jpg?v=20160405001" />
    </div>
</div>
<div class="fffwaist">
	<div class="headswe">
    	<img src="http://static.ebanhui.com/ebh/tpl/2016/images/jkwet6.jpg?v=20160405001" />
    </div>
</div>
<div class="khuster">
<?php $this->display('common/footer');?>
</div>