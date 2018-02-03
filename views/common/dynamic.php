<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=1200, user-scalable=no" name="viewport"/>
    <title>e板会-互动课堂</title>
    <meta name="keywords" content="<?=empty($seoInfo['keyword'])?$this->get_keywords():$seoInfo['keyword']?>" />
    <meta name="description" content="<?=empty($seoInfo['description'])?$this->get_description():$seoInfo['description']?>" />
    <link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/ebh2/css/intro.css?v=2016122201" />
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/jquery.js"></script>
    <script src="http://static.ebanhui.com/ebh/js/common.js?version=20160523001" type="text/javascript"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
    <script src="http://static.ebanhui.com/ebh/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
<style type="text/css">
    .nav {background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/tsoube.png);}
    .nav a.menu_item span {border:none;}
    a.menu_item:hover span {border-bottom: 2px solid #fff;}
	.shichasrs .chst3s {display:none;}
	.shichasrs:hover .chst3s {display:block;}
	.dilanbgs {display:none;}
	.shrsre1s:hover .dilanbgs, .shrsre2s:hover .dilanbgs, .shrsre3s:hover .dilanbgs, .shrsre4s:hover .dilanbgs {display:block;	background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/isrner.png);}
	
</style>
<![endif]-->
<style type="text/css">.rishtdt .prit {margin-top: 22px;}.rishtdt .titrise{margin-top:0px;}</style>
</head>

<body>
<div class="right-fixed">
    <a class="click-ask" href="javascript:;"></a>
</div>
<div class="nav">
    <div class="neinaver">
        <div class="logo">
            <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/logo.png">
        </div>
        <div class="links">
            <a onfocus="this.blur();" class="menu_item" href="http://ebhdemo.ebh.net" target="_blank">
                演示网校
                <span></span>
            </a>
            <a onfocus="this.blur();" class="menu_item" href="http://www.ebh.net/intro/livesystem.html" target="_blank">
                在线直播
                <span></span>
            </a>
            <a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net" target="_blank">
                在线录播
                <span></span>
            </a>
            <a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net" target="_blank">
                微课工具
                <span></span>
            </a>
            <a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/dynamic.html" target="_blank">
                互动课堂
                <span></span>
            </a>
        </div>
        <div class="toprisr">
            <div class="search">
                <input class="searchtxt" name="textarea" x_hit="搜索" type="text" id="searchfm" value="<?= !empty($q)?$q:'' ?>" />
                <a class="searchbtn" href="javascript:;" onclick="dosearch()"></a>
                    <form action="#" method="get" id="searchhide" target="_blank" style="display:none;">
                        <input id="q" type="hidden" name="q" value="<?= !empty($q)?$q:'' ?>" />
                    </form>
            </div>
            <?php if(empty($user)){?>
            <a class="rsizer" href="javascript:void(0);" onclick="_login()"><i class="humserr"></i>登录</a>
            <a class="rsizer" target="_blank"  href="/register.html">注册</a>
            <a class="rsizer"  href="/moreapp.html">更多...</a>
            <?php }else{ ?>
                <?php $homeurl = geturl('homev2');?>
                    <a class="rsizer"  target="_blank" href="<?=$homeurl?>"> <i class="humserr"></i><?= substr($user['username'],0,9)?> </a>
                    <a class="rsizer" target="_blank" href="<?=$homeurl?>">个人中心</a>
                    <a class="rsizer" href="<?=geturl('logout')?>">退出</a>
                    <a class="rsizer"  href="/moreapp.html">更多...</a>
            <?php }?>

        </div>
    </div>
</div>
<div class="introtops">
</div>
<div class="mainjs">
    <a class="ebhintro" href="http://svnlan.ebh.net/course/79902.html" target="_blank">
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/inter02.jpg" />
    </a>
    <div class="rishtdt">
    	<h2 class="titrise">互动课堂能做什么？</h2>
        <p class="eplsies prit">过大数据分析，<br />向用户端提供精准数据，提高学生学习效率和成绩。</p>
        <p class="prit">教师在课堂上利用“互动课堂”向学生布置随堂练习，学生在自己的移动端完成后提交，系统能够实时统计出提交名单、完成时间、各选项分布情况、学生手写内容轨迹等数据并同步生成各类图表的形式呈现出来，以方便教师随时调整教学思路，提高课堂效率。</p>
        <p class="prit">此外，教师还可针对具体某位学生单独查看答题情况，“集体互动”结合“因材施教”，充分利用课堂时间，让课堂教学真正“活”起来。</p>
    </div>
</div>
<div class="shrites easingobj">
	<div class="nsireshis">
        <h2 class="titbsce">场景步骤</h2>
        <div class="shrsre1s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">第一步</p>
                <p class="chst2s">布置</p>
                <p class="chst3s">支持单选、多选、主观、文字各类题型。</p>
                <p class="chst3s">更支持直接上传题目图片，免去编辑题目的繁琐过程</p>
            </div>
        </div>
        <div class="shrsre2s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">第二步</p>
                <p class="chst2s">参与</p>
                <p class="chst3s">学生可在移动终端（PAD、手机）参与互动，</p>
                <p class="chst3s">同步支持手写、输入法编辑内容，完美保留答题轨迹，让答题过程更便捷</p>
            </div>
        </div>
        <div class="shrsre3s">
        	<div class="dilanbgs"></div>
            <div class="shichasrs">
                <p class="chst1s">第三步</p>
                <p class="chst2s">统计</p>
                <p class="chst3s">学生的作答情况实时统计到教师端，</p>                
                <p class="chst3s">以动态图表的形式生动展示互动情况，让课堂效率指数上升</p>
            </div>
        </div>
    </div>
</div>

<div class="zhusre easingobj">
	<div class="cnasrse">
    	<h2 class="zhusertit">产品案例</h2>
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/inter08.jpg" />
    </div>
</div>
<div class="falsrfe">
    <div class="ebhcode"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/code.png" /><span>微信公众号“e板会”</span></div>
    <div class="ebhapp"><img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/code1.png" /><span>“e板会”-APP</span></div>
    <div class="srzrder">
        <ul>
            <li class="lsrret">浙江省杭州市江干区钱江新城五星路188号荣安大厦25F</li>
            <li class="ewtser">0571-87757303</li>
            <li class="reyrde">
                <a target="_blank" href="<?=geturl('about')?>">关于</a>&nbsp;&nbsp;&nbsp;
                <a target="_blank" href="<?=geturl('conour')?>">业务联系</a>
            </li>
        </ul>
    </div>
    <div class="fldty">
        <div style="text-align:center">
            <span style="color:#555">
            <i></i>
            浙公网安备 33010602003467号
            </span>
            <a href="http://www.miibeian.gov.cn/" target="_blank" style="color:#555">浙ICP备11027462号</a>
            <span style="color:#555">Copyright © 2011-<?=date('Y')?> ebh.net All Rights Reserved </span></span>
            <br>
        </div>
    </div>
</div>

<script type="text/javascript">
//页面下拉加载样式//
$(function(){
	$.each($('.easingobj'),function(k,v){
		if($(window).height() - ($(this).offset().top-$(window).scrollTop()) > 150)
			$(this).addClass("easing");
	})
});
window.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop; 
    var top_div = document.getElementById( "easing1" );
	$.each($('.easingobj'),function(k,v){
		if($(window).height() - ($(this).offset().top-$(window).scrollTop()) > 150)
			$(this).addClass("easing");
	})
}
function closew(){
	$("#easing1").removeClass("easing");
	$("#easing1").attr('id','videotemp');
}
var timer;
$(function(){
    xForm.hit($("#searchfm"));
    $(".askter h2").attr({style:"cursor:pointer;"});
    $("div.askter").bind('mouseleave',function(){
        $(".askter").slideUp();
    }).bind('mouseover',function(){
        clearTimeout(timer);
    });
    $("#searchfm").bind('keypress',function(e){
        if(e.which == 13){
            dosearch();
        }
    });
});
//搜索
function dosearch(){
    var $search = $("#searchfm");
    $search.val($.trim($search.val()));
    var q = $search.val();
    if(q == $search.attr('x_hit')){
        q = "";
    }
    if(q == ""){
        alert("请输入关键字");
        return;
    }
    $("#q").val(q);
    var url = "/searchs.html";
    xredirect(url);
}
function xredirect(url){
    $("#searchhide").attr("action",url);
    $("#searchhide").submit();
}
    xForm.hit = function($dom){
        var oldstyle = ($dom.attr('style') || "");
        var sobj = xForm.Utils.strToObj(oldstyle);
        if(typeof sobj.color == "undefined"){
            oldstyle += "color:#000;";
            oldstyle += "width:146px;";
            oldstyle += "background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/topamend2.png) no-repeat;";
        }
        sobj.color = '#999';
        var newstyle = xForm.Utils.objToStr(sobj);
        var x_hit = $dom.attr('x_hit');
        $dom.bind('blur',function(){
            $dom.val($.trim($dom.val()));
            if($dom.val() == "" || $dom.val() == x_hit){
                $dom.attr({'style':newstyle});
                $dom.val(x_hit);
            }else{
                $dom.attr({'style':oldstyle});
            }
        }).bind('focus',function(){
            $dom.val($.trim($dom.val()));
            if($dom.val()==x_hit){
                $dom.attr({'style':oldstyle});
                $dom.val("");
            }
        });
        $dom.blur();
    }
//登录
function _login(){
    tologin('/login.html?returnurl=__url__');
}   
</script>
<?php EBH::app()->lib('Analytics')->get('baidu','www_ebh')?>
</body>
</html>
