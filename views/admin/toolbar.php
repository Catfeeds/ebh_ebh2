<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Toolbar</title>
<link href="http://static.ebanhui.com/ebh/admin/skins/orange/images/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/js/easyui/themes/metro-orange/easyui.css">
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="http://static.ebanhui.com/ebh/admin/include/admin.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/easyui/jquery.easyui.min.js"></script>
</head>

<body id="header">
<div class="headPage">
<div id="sitetitle">
	<a href="?action=main" target="mainframe"><img src="http://static.ebanhui.com/ebh/admin/images/logo.gif" border="0"></a>
</div>

<div id="topmenu">
	<ul>
		<?php
		foreach($topmenulist as $listitem){
		$aclass = $listitem==$topmenulist[0]?' class="current"' : '';
		
		$alink = '/admin/'.(empty($listitem['redir']) ? $listitem['identifier'] : $listitem['redir']);
		
		$alink.='.html'
		?>
		<li><a href="<?php echo $alink;?>" target="mainframe" onclick="channelNav(this, '$childids'); parent.leftframe.location='/admin.html?action=sidemenu&upaction=<?php echo $listitem['identifier']?>'" <?php echo $aclass;?>><?php echo $listitem['name'];?></a></li>
		<?php }?>
		
		
	</ul>
</div>

<a href="javascript:;" onclick="sideSwitch();" id="sideswitch" class="opened">关闭侧栏</a>

<div id="topinfo">
	<ul>
		<li class="sitehomelink"><a href="/" target="_blank">查看网站首页</a></li>
		<li class="logout">欢迎您！<?php echo $username;?> &nbsp;
		<em style="background: #993300;padding:5px;color:#fff">[<a href="?action=logout" target="_parent">退出</a>] </em>&nbsp;
		<a href="/admin/innerchangepwd.html" target="mainframe">修改密码</a>&nbsp;
		上次登录: <?php echo $lastlogintime.'('.$logincount.'次)'?>
		</li>
		<li style="display: none"><a href="/" target="_blank">当前版本: {S_VER} Final <em>(20080128)</em></a></li>
	</ul>
</div>
</div>
</body>
</html>
