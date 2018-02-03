<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">

<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/wap/css/jest.css" />
<title>优惠码 - e板会</title>
<meta name="keywords" content="优惠码" />
<meta name="description" content="优惠码是e板会网校平台的优惠凭证。开通e板会平台所有课程尊享优惠价格。" />
</head>

<body>
<div class="tost">
    <a href="/" class="ksrtabtn"></a>
</div>
<?php if (!empty($mycoupon['code'])){?>
<div class="tswthe">
    <span class="eretewt">优惠码：<?=$mycoupon['code']?></span>
    <span class="kehsner"><?=empty($roominfo['crname']) ? '&nbsp;' : '<a class="jatlink" target="_blank" href="http://'.$roominfo['domain'].'.ebh.net/"><span class="lstlshei">进入 </span>'.$roominfo['crname'].' ></a>'?>
    </span>
</div>
<?php }?>
<div class="linvsr1">
</div>
<div class="linvsr2">
</div>
<div class="linvsr3">
</div>
<div class="linvsr4">
</div>
<div class="linvsr5">
</div>
</body>
</html>
