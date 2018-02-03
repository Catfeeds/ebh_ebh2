<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $codepath = $this->uri->codepath;
	if($codepath=='help'){
		$title = '首页'; 
	}elseif($codepath=='faq'){
		$title = '常见问题';
	}elseif($codepath=='service'){
		$title = '联系客服';
	}
?>
<title><?= $title?>-帮助中心</title>
<meta name="keywords" content="$keywords" />
<meta name="description" content="$description" />
<meta name="viewport"  content="user-scalable=no">
<script src="http://static.ebanhui.com/ebh/js/jquery.js" type="text/javascript"></script>
<script src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui-1.8.1.custom.min.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/default/jquery-ui-1.8.1.custom.css" />
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/base.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css" />
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2014/css/ebhportal.css" />
<!--[if lte IE 6]>  
<script type="text/javascript" src="/static/js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.bottom,.cservice img,.roomtit,.ui_ico,img,background');
</script>
<![endif]-->
</head>
<body>
<div class="ebhcceud" style="z-index:8;position:relative">
<div class="pass_e" style="z-index:8">
<div class="login-info" style="padding:0;height:33px;line-height:34px">
<a  style="float:left;margin-left:8px;color:#333;" href="javascript:void(0);" onclick="AddFavorite(window.location, document.title)">收藏我们</a>
<?php if(empty($user)){?>
<span class="huanying">| 欢迎来到e板会！</span>
<a href="javascript:tologinn('/login.html?returnurl=__url__');" style="color:#333;">登录</a>
<a href="/register.html" style="color:#333;">注册</a>
<?php }else{?>
     <span style="width:170px; ">您好 <?= $user['username']?> 欢迎来到e板会！</span>
            <?php
                if($user['groupid'] == 6) {
            ?>
                <a href="http://www.ebh.net/member.html" style="color:#ff0000;">个人中心</a>
            <?php
            } else {
            ?>
                <a href="http://www.ebh.net/teacher/choose.html" style="color:#ff0000;">个人中心</a>
            <?php
            }
            ?>
    <a href="http://www.ebanhui.com/" style="color:#333;">返回首页</a>&nbsp;&nbsp;<a href="/logout.html" style="color:#333;">安全退出</a>
<?php }?>
</div>
<ul class="quick-menu">
<li class="">
<a  href="javascript:void(0);" onclick="SetHome(this, window.location);" class="cent">设为主页</a>
</li>
<li class="">|
<a class="cent" href="http://www.ebh.net/yun1.html">云教学平台</a>
</li>
<li class="last" style="text-align: left;width:100px;">|
<a target="_blank" href="http://weibo.com/ebanhui">关注e板会微博
</a>
</li>
<li>
<a href="http://weibo.com/ebanhui" target="_blank">
<img src="http://static.ebanhui.com/portal/images/sina.png">
</a>
</li>
</ul>
</div>
</div>
<div class="log">
<div class="con">
<div style="position: relative;">
<a href="http://www.ebh.net/" style="height: 59px;position: absolute;width: 248px;cursor:pointer;display: block;"></a></div>
<div class="logleft">
<ul id="menu">
<?php $codepath = $this->uri->codepath?>
<li <?= $codepath=='help'?' class="index1"':' class="index"'?>><a href="<?= geturl('help')?>" onclick=""></a></li>
<li <?= $codepath=='faq'?' class="faq1"':' class="faq"'?>><a href="<?= geturl('faq')?>"></a></li>
<li <?= $codepath=='service'?' class="service1"':' class="service"'?>><a href="<?= geturl('service')?>"></a></li>

</ul>
</div>
<div class="seek">

<?php $keywords = $this->input->get('q');?>
<span class="soutico">搜索问题</span>
	<input  id="keywords" class="seekku" type="text" name="textfield" value="<?= $keywords?>"/>
    <input class="seekbtn" type="button" onmouseover="this.className='seekbtn2'" onmouseout="this.className='seekbtn'" name="selec" value="搜 索" onclick="listsearch()"/>
  </div>
</div>

</div>

<script type="text/javascript">
<!--
	 function listsearch(){		 
		var keywords= $.trim($("#keywords").val()=='请输入您的问题'?'':$("#keywords").val());
		var url = '/faq.html?q='+keywords;
		window.location.href=url;
	}
	 var tologinn = function(url){
    url = url.replace('__url__',encodeURIComponent(location.href));
    location.href=url;
    }
//-->
</script>
