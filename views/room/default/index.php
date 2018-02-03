<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= $room['crname'] ?></title>
<meta name="keywords" content="<?= $room['crlabel'] ?>" />
<meta name="description" content="<?= $room['summary'] ?>" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" rel="stylesheet" />	
<link type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/classroom_login.css" rel="stylesheet" />	
<!--[if lte IE 6]>  
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/DD_belatedPNG_0.0.7a.js"></script>  
<script type="text/javascript">  
  DD_belatedPNG.fix('.head-logo,.head-logo a ,.current-city,.cservice img,.cbuyclass,.head-logo-text,.primg,.header-area span,.bottom,.qtlol img');   
</script>  
<![endif]-->
<script type="text/javascript">
<!--
	var sitecpurl ='#getsitecpurl()#';
//-->
</script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001"></script>
</head>

<body>
<div class="index">
<div class="top-login">
    <div class="login_block">
        <span class="welcome">欢迎来到e板会电子教室</span>
        <ul class="login">
        <li><a href="http://www.ebanhui.com" target="_blank">e板会主页</a></li>
        <li><a href="javascript:;" onclick="SetHome(this,window.location);">设为首页</a></li>
        <li><a href="javascript:;" onclick="AddFavorite(window.location,'e板会-电子教室')">加入收藏</a></li>
        <li><a href="http://www.ebanhui.com/help.html" target="_blank">帮助中心</a></li>
        </ul>
    </div>
</div>
<div class="head">
    <div class="headbox">
        <div class="logo"><a href="/"><img border="0" src="http://static.ebanhui.com/ebh/tpl/default/images/home_ebh_logo.gif"></a></div>
        <span id="webLogoTxt">电子教室</span>
    </div>
</div>

<div class="top">
<div class="box960">
    	<div style="height:35px;">&nbsp;</div>
    <div id="mainLeft">
    	<a style="display:block"><img src="http://static.ebanhui.com/ebh/tpl/default/images/class_login_img01.jpg" /></a>
        <h4><a>成长于教育、发展于教育、服务于教育</a></h4>
        <ul id="mainimg">
        <li><img src="http://static.ebanhui.com/ebh/tpl/default/images/li_img01.jpg" /></li>
        <li><img src="http://static.ebanhui.com/ebh/tpl/default/images/li_img03.jpg" /></li>
        <li><img src="http://static.ebanhui.com/ebh/tpl/default/images/li_img04.jpg" /></li>
        <li><img src="http://static.ebanhui.com/ebh/tpl/default/images/li_img02.jpg" /></li>
        </ul>
    </div>
    <div id="mainRight">
    <form id="form1" name="form1" action="/login.html?inajax=1&login_from=classroom" onsubmit="form_submit();return false;">
			<input type="hidden" name="formhash" value="<!--{eval echo formhash()}-->" />
			<input type="hidden" name="loginsubmit" value="1" />
    	<table width="330" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="85" height="180">&nbsp;</td>
            <td width="245">&nbsp;</td>
          </tr>
          <tr>
            <td height="28">&nbsp;</td>
            <td align="left"><input type="text" name="username" id="username" class="inputxt" /></td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td></td>
          </tr>
          <tr>
            <td height="28">&nbsp;</td>
            <td align="left"><input type="password" name="password" id="password" class="inputxt" /></td>
          </tr>
          <tr>
            <td height="72">&nbsp;</td>
            <td align="left"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="120" rowspan="2" valign="top"><input type="submit" class="btn" id="loginsubmit" value="用户登录" /></td>
				<td width="85"><span class="txtBlock1"><a class="wrent" href="<?= geturl('forget')?>">忘记密码？</a></span></td>
              </tr>
            </table></td>
          </tr>
        </table>
		 <div class="qtlol" style="width:240px;margin-top:-5px;"><span style="color:#000;">用其他账号登录：</span>
		 <a href="<?=geturl('otherlogin/qq')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/qqico0830.png" /></a>
		 <a href="<?=geturl('otherlogin/sina')?>"><img src="http://static.ebanhui.com/ebh/tpl/2012/images/sianico0830.png" /></a>
		 </div>
    </form>
    </div>
    <div class="clear"></div>
</div>
</div>
</div>
<?php $this->display('common/footer'); ?>
