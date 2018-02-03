<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"  content="user-scalable=no">
<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/common.css">
<link type="text/css" rel="stylesheet" href="http://static.ebanhui.com/portal/css/ebhportal.css?version=20150210001">
<link href="http://static.ebanhui.com/ebh/tpl/2012/css/user.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/header.js"></script>
<script src="http://static.ebanhui.com/ebh/js/common.js?version=20150528001" type="text/javascript"></script>
<link type="text/css" href="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/css/custom/jquery-ui.min.css" rel="stylesheet" /> 
<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery/jquery-ui/jquery-ui.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title?></title>
<meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
<meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
</head>
<body>
<div class="ebhcceud">
<div class="pass_e">
<div class="login-info" style="padding:0;height:42px;line-height:42px">
<!-- <a href="/" style="float:left;width:65px;"><img src="http://static.ebanhui.com/portal/images/enshrineico.jpg" /></a> -->
<div class="headerleft" style="float:left;">
<a href="javascript:void(0);" onclick="AddFavorite(window.location, document.title)" style="margin-left:8px;color:#333;">收藏我们</a>
<?php if(empty($user)){?>
<span class="huanying">|&nbsp;欢迎来到e板会！</span>
<a style="color:#333;" href="#" onclick="_login();">登录</a>
<a style="color:#333;" href="/register.html">注册</a>
<?php }else{?>
     <span style="width:170px; ">您好 <?= $user['username']?> 欢迎来到e板会！</span>
            <?php
                if($user['groupid'] == 6) {
            ?>
                <a  style="color:#ff0000;" href="<?= geturl('home')?>">个人中心</a>
            <?php
            } else {
            ?>
                <a  style="color:#ff0000;" href="<?= geturl('teacher/choose')?>">个人中心</a>
            <?php
            }
            ?>
    <a  style="color:#333;" href="http://www.ebh.net/">返回首页</a>&nbsp;&nbsp;<a style="color:#333;" href="/logout.html">安全退出</a>
<?php }?>
</div>
</div>
<ul class="quick-menu">
<li class="">
<a   href="javascript:void(0);" onclick="SetHome(this, window.location);" class="cent">设为主页</a>
</li>
<li>|
<a class="cent" href="/yun1.html">云教学平台</a>
</li>
<li>|
<a class="cent" href="http://pay.ebh.net" target="_blank">充值中心</a>
</li>
<li>|
<a target="_blank" href="http://weibo.com/ebanhui">
关注e板会微博
</a>
</li>
<li>
<a target="_blank" href="http://weibo.com/ebanhui">
    <img src="http://static.ebanhui.com/portal/images/sina.png">
</a>
</li>
</ul>
</div>
</div>
<div class="pass_e2"></div>
<div style="background:#4fcffd;">
<div class="header swbgt">
<a class="logoebh" style="margin:0;" href="/"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/new_log.jpg"></a>

<div style="margin:10px 0 0 340px;width:394px;float:right;" class="sulo"> 
<form id="frm_search" action="/main.html" method="get" >
<?php
    $typename = $this->input->get('typename');
    $q = $this->input->get('q');
    if($typename=='course'){
        $typevalue = '课 件';
        $tip = '请输入课件名称的关键字';
    }else if($typename=='school'){
        $typevalue = '网 校';
        $tip = '请输入网校的关键字';
    }else if($typename == 'article'){
        $typevalue = '文 章';
        $tip = '请输入文章的关键字';
    }else{
        $typename ='school';
        $typevalue = '网 校';
        $tip = '请输入网校的关键字';
    }
    $color = "#1895E9";
?>
<div class="kuangwai" style="z-index:3">
<a  id="head_searchTypeSelecte" class="l_f" style=" text-decoration: none;left: 8px;background-color:white;" show="0" href="javascript:void(0);"><?=$typevalue?></a>
<ul id="head_searchType" class="s_fields_select" show="0" style="display:none;height:auto;">
<li>
<a style="text-decoration: none;color:#1895E9;" onclick="beforesearch('school')" type="school" href="javascript:void(0);">网 校</a>
</li>
<li>
<a style="text-decoration: none;color:#1895E9;" onclick="beforesearch('course')" type="course" href="javascript:void(0);">课 件</a>
</li>
<li>
<a style="text-decoration: none;color:#1895E9;" onclick="beforesearch('article')" type="article" href="javascript:void(0);">文 章</a>
</li>
</ul>
<?php if(!empty($q)){?>
<input id="search_title" tip="<?=$tip?>" class="kuangbg" type="text" style="color:#000;_margin-top:3px;" onfocus="if (this.value == $(this).attr('tip')) this.value = ''; this.style.color = '#000';" onblur="if ($.trim(this.value).length == 0) { this.value = $(this).attr('tip'); this.style.color = '#e3e3e3'; }" value="<?=$q?>" name="q">
<? }else{?>
<input id="search_title" tip="<?=$tip?>" class="kuangbg" type="text" style="color:#e3e3e3;_margin-top:3px;" onfocus="if (this.value == $(this).attr('tip')) this.value = ''; this.style.color = '#000';" onblur="if ($.trim(this.value).length == 0) { this.value = $(this).attr('tip'); this.style.color = '#e3e3e3'; }" value="<?=$tip?>" name="q">
<? }?>
<input id="typename" type="hidden" value="<?=$typename?>" name="typename">
</div>
<a style="background:#23a1f2;" href="javascript:funsub('search_title');" class="solobtn">搜 索</a>
</form>
</div>
</div>
<!-- <div class="newtopd">
<a class="logoebh" style="margin:0;" href="/"><img src="http://static.ebanhui.com/ebh/tpl/2014/images/new_ad001.jpg"></a>
</div> -->
</div>
<div class="wrapper">
<script type="text/JavaScript">
    var tologinn = function(url){
    url = url.replace('__url__',encodeURIComponent(location.href));
    location.href=url;
    }
    $('#frm_search').bind('keypress',function(event){
            if(event.keyCode == "13")    
            {  
               funsub('search_title');
               return false;
            }
    });
    function funsub(keyid){
    var typename = $("#typename").val();
    // if($("#head_searchTypeSelecte").length > 0) {
    // var curtype = $.trim($("#head_searchTypeSelecte").text());
    // if(curtype == "课 件") {
    // typename = "course";
    // } else if(curtype == "网 校") {
    // typename = "school";
    // } else if(curtype == "文 章") {
    // typename = "article";
    // }
    // }
    if(typename == 'course'){
    $("#"+keyid).val($("#"+keyid).val()=='请输入课件名称的关键字'?'':$("#"+keyid).val());
    $("#frm_search").submit();
    }
    else if(typename == 'school'){// wangxiao                
    var search_title=encodeURIComponent($.trim($("#"+keyid).val()=='请输入网校的关键字'?'':$("#"+keyid).val()));
    var url = '/cloudlist.html';
    url = url+"?q="+search_title+'&typename=school';
    window.location.href=url;
    }else{
    var search_title=encodeURIComponent($.trim($("#"+keyid).val()=='请输入文章的关键字'?'':$("#"+keyid).val()));
    var url = '/articlesearch.html';
    url = url+"?q="+search_title+'&typename=article';
    window.location.href=url;
    }
    }
    $('div.header').ready(function(){
        $('.navblock a[upid=0]').parent('div')
        .css({cursor:'pointer'})
        .mouseover(function(){
            $(this).attr('id','navmouse');
        })
        .mouseleave(function(){
            $(this).removeAttr('id');
        });
    });

    function _login(){
        // var url = location.href;
        // $.loginDialog(url);
        // return false;
        tologinn('/login.html?returnurl=__url__');
    }
    function beforesearch(tagname){
        $search_title = $("#search_title");
        if(tagname == 'course'){
            $search_title.val("请输入课件名称的关键字");
            $search_title.attr('tip',"请输入课件名称的关键字");
        }else if(tagname == 'school'){
            $search_title.val("请输入网校的关键字");
            $search_title.attr('tip',"请输入网校的关键字");
        }else if(tagname == 'article'){
            $search_title.val("请输入文章的关键字");
            $search_title.attr('tip',"请输入文章的关键字");
        }
         $search_title.attr('style','color:#e3e3e3');
        $('#typename').val(tagname);
    }
</script>