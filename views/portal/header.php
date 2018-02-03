<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$seoInfo['title']?></title>
<meta name="keywords" content="<?=$seoInfo['keyword']?>" />
<meta name="description" content="<?=$seoInfo['description']?>" />
<meta name="viewport"  content="user-scalable=no">
<link href="http://static.ebanhui.com/portal/css/ebhportal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/portal/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/header.js"></script>
<script src="http://static.ebanhui.com/portal/js/jquery.imgScroll2.js" type="text/javascript"></script>
<script src="http://static.ebanhui.com/portal/js/MogFocus.js" type="text/javascript"></script>
<script src="http://static.ebanhui.com/ebh/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
	$('.fcsub .brandList').bxCarousel({
		display_num: 12, 
		move: 2, 
		auto: true,
		prev_image: 'http://static.ebanhui.com/portal/images/arrow_left.gif',
		next_image: 'http://static.ebanhui.com/portal/images/arrow_right.gif',
		margin: 0 ,
		auto_hover: true
	});	
	// $("#slider").slider();
	// $(".proQuick").tabPic();
	$(".i_news .fctit").mouseover(function(){
		$("#newsWin").show();
	});
	$(".i_bodyer").mouseleave(function(){
		$("#newsWin").hide();
	});
});
</script>
</head>
<body>
<div class="ebhcceud">
<div class="pass_e">
<div class="login-info">
<a href="/" style="float:left;"><img style="float:left;" src="http://static.ebanhui.com/portal/images/enshrineico.jpg" /></a>
<a href="/" style="float:left;margin-left:8px;">收藏我们</a>
<?php if(empty($user)){?>
<span class="huanying">&nbsp;| 欢迎来到e板会！</span>
<a href="javascript:tologinn('/login.html?returnurl=__url__');">登录</a>
<a href="/register.html">注册</a>
<?php }else{?>
     <span style="width:170px; ">您好 <?= $user['username']?> 欢迎来到e板会！</span>
            <?php
                if($user['groupid'] == 6) {
            ?>
                <a href="<?= geturl('homev2')?>">个人中心</a>
            <?php
            } else {
            ?>
                <a href="<?= geturl('teacher/choose')?>">个人中心</a>
            <?php
            }
            ?>
    <a href="http://www.ebanhui.com/">返回首页</a>&nbsp;&nbsp;<a href="/logout.html">安全退出</a>
<?php }?>
</div>
<ul class="quick-menu">
<li class="">
<a class="cent" href="#">设为主页</a>
</li>
<li class="">|
<a class="cent" href="#">云教育平台</a>
</li>
<li class="last">|
<a target="_blank" href="http://weibo.com/ebanhui">
关注e板会微博&nbsp;<img src="http://static.ebanhui.com/portal/images/sina.png">
</a>
</li>
</ul>
</div>
</div>
<div class="pass_e2"></div>
<div class="wrapper">
<div class="header">
<a href="/portal.html" class="logoebh"><img src="http://static.ebanhui.com/portal/images/ebhlogo.jpg" /></a>
<iframe style="float:left;" name="weather_inc" src="http://tianqi.xixik.com/cframe/2" width="350" height="48" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
<div class="sulo">
<div class="kuangwai">
<a onclick="showselect()" id="head_searchTypeSelecte" class="l_f" style=" text-decoration: none;left: 8px;background-color:white;" show="0" href="javascript:;">网 校</a>
<ul id="head_searchType" class="s_fields_select" show="0" style="display:none">
<li>
<a style="text-decoration: none;color:#1895E9;" onclick="$('#typename').val('kejian')" type="course" href="javascript:;">课 件</a>
</li>
<li>
<a style="text-decoration: none;color:#1895E9;" onclick="$('#typename').val('wangxiao')" type="school" href="javascript:;">网 校</a>
</li>
<!-- <li>
<a style="text-decoration: none;color:#1895E9;" onclick="$('#typename').val('wenzhang')" type="school" href="javascript:;">文 章</a>
</li> -->
</ul>
<input id="search_title" class="kuangbg" type="text" style="color:#999999;_margin-top:3px;" onfocus="if (this.value == '请输入网校或课件名称的关键字') this.value = ''; this.style.color = '#000';" onblur="if ($.trim(this.value).length == 0) { this.value = '请输入网校或课件名称的关键字'; this.style.color = '#999999'; }" value="请输入网校或课件名称的关键字" name="q">
<input id="typename" type="hidden" value="wangxiao" name="typename">
</div>
<a class="solobtn" href="javascript:funsub('search_title');">搜 索</a>
</div>
<div class="clear"></div>
<div class="nav2014">
<?php foreach($m as $v){?>
<?php if(count($v['child'])>3){?>
        <div class="navblock" style="width:151px;">
        <div class="navtitle" style="border-left:solid 1px #02b7ec;">
        <?php if(empty($v['caturl'])){?>
            <a catid="<?=$v['catid']?>" upid="<?=$v['upid']?>" href="/portal-1-0-0-<?=$v['catid']?>.html" target="_blank"><?=$v['name']?></a>
        <?php }else{?>
            <a catid="<?=$v['catid']?>" upid="<?=$v['upid']?>" href="<?=$v['caturl']?>" target="_blank"><?=$v['name']?></a>
        <?php }?>
        </div>
        <ul style="border-left: 1px solid #fff0e1;">
    <?php for($i=0;$i<count($v['child']);$i++){?>
        <li>
        <?php if(!empty($v['child'][$i]['caturl'])){?>
            <a catid="<?=$v['child'][$i]['catid']?>" upid="<?=$v['child'][$i]['upid']?>" href="<?=$v['child'][$i]['caturl']?>" target="_blank"><?=$v['child'][$i]['name']?></a>
        <?php }else{?>
            <a catid="<?=$v['child'][$i]['catid']?>" upid="<?=$v['child'][$i]['upid']?>" target="_blank" href="/portal-1-0-0-<?=$v['child'][$i]['catid']?>.html"><?=$v['child'][$i]['name']?></a>
        <?php }?>
        <?php if(!empty($v['child'][$i+1])){?>
            <?php if(!empty($v['child'][$i+1]['caturl'])){?>
                <a catid="<?=$v['child'][1+$i]['catid']?>" upid="<?=$v['child'][1+$i]['upid']?>" target="_blank" href="<?=$v['child'][1+$i]['caturl']?>" style="padding:0 11px;*padding:0 10px;"><?=$v['child'][++$i]['name']?></a>
            <?php }else{?>
               <a catid="<?=$v['child'][1+$i]['catid']?>" upid="<?=$v['child'][1+$i]['upid']?>" target="_blank" href="/portal-1-0-0-<?=$v['child'][1+$i]['catid']?>.html" style="padding:0 11px;*padding:0 10px;"><?=$v['child'][++$i]['name']?></a>
            <?php }?>
        <?php }?>
        </li>
    <? }?>
    </ul>
    </div>
<?php }else{?>
        <div class="navblock" style="width:99px;">
        <div class="navtitle" style="border-left:solid 1px #02b7ec;">
        <?php if(empty($v['caturl'])){?>
            <a catid="<?=$v['catid']?>" upid="<?=$v['upid']?>" href="/portal-1-0-0-<?=$v['catid']?>.html" target="_blank"><?=$v['name']?></a>
        <?php }else{?>
            <a catid="<?=$v['catid']?>" upid="<?=$v['upid']?>" href="<?=$v['caturl']?>" target="_blank"><?=$v['name']?></a>
        <?php }?>
        </div>
        <ul style="border-left: 1px solid #fff0e1;">
    <?php for($i=0;$i<count($v['child']);$i++){?>
        <li>
         <?php if(!empty($v['child'][$i]['caturl'])){?>
            <a catid="<?=$v['child'][$i]['catid']?>" upid="<?=$v['child'][$i]['upid']?>" href="<?=$v['child'][$i]['caturl']?>" target="_blank"><?=$v['child'][$i]['name']?></a>
        <?php }else{?>
            <a catid="<?=$v['child'][$i]['catid']?>" upid="<?=$v['child'][$i]['upid']?>" target="_blank" href="/portal-1-0-0-<?=$v['child'][$i]['catid']?>.html"><?=$v['child'][$i]['name']?></a>
        <?php }?>
        </li>       
    <? }?>
    </ul>
    </div>
<?php }?>
<?php }?>
</div>
</div>
<script type="text/JavaScript">
    var tologinn = function(url){
    url = url.replace('__url__',encodeURIComponent(location.href));
    location.href=url;
    }
    function submitSearchForms(e) {
    e = window.event || e;
    //e = event ? event :(window.event ? window.event : null);
    if (e.keyCode == 13) { 
    funsub('search_title');
    //alert('回车检测到了');
    }
    }
    function funsub(keyid){
    var typename = $("#typename").val();
    if($("#head_searchTypeSelecte").length > 0) {
    var curtype = $.trim($("#head_searchTypeSelecte").text());
    if(curtype == "课 件") {
    typename = "kejian";
    } else if(curtype == "网 校") {
    typename = "wangxiao";
    }
    }
    if(typename == 'kejian'){
    $("#"+keyid).val($("#"+keyid).val()=='请输入网校或课件名称的关键字'?'':$("#"+keyid).val());
    $("#frm_search").submit();
    }
    else{// wangxiao                
    var search_title=encodeURIComponent($.trim($("#"+keyid).val()=='请输入网校或课件名称的关键字'?'':$("#"+keyid).val()));
    var url = '/cloudlist.html';
    url = url+"?q="+search_title;
    window.location.href=url;
    }
    }
</script>