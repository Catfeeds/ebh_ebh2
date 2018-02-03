
<style type="text/css">
    #kanjia{
        position:fixed;
        left:0;
        top:38%;
        margin-top:-90px;
        z-index:1;
        font-size:16px;
        color:#333;
}
</style>
<!--[if lt IE 10]>
<style type="text/css">
	.back {display:none;}
		.nav {
		background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/tsoube.png);
	}
</style>
<![endif]-->
<!--[if lt IE 9]>
<style type="text/css">
	.nav {background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/tsoube.png);}
	.nav a.menu_item span {border:none;}
	a.menu_item:hover span,a.menu_item.onhover span{border-bottom: 2px solid #fff;}
	.cteff .shade {background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/tsoube.png);}
	.slideup .slide {background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/tsoube.png);}
	.slideups .slide {background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/tsoube.png);}
	.cteff:hover .shade, .cteff:hover .bd {display:none;}
	.txttask {display:none;}
	.taskes:hover .txttask {display:block;}
	.shichasrs .chst3s {display:none;}
	.shichasrs:hover .chst3s {display:block;}
	.dilanbgs {display:none;}
	.shrsre1s:hover .dilanbgs, .shrsre2s:hover .dilanbgs, .shrsre3s:hover .dilanbgs, .shrsre4s:hover .dilanbgs {display:block;	background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/isrner.png);}
	.shichasr .chst3 {display:none;}
	.shichasr:hover .chst3 {display:block;}
	.dilanbg {display:none;}
	.shrsre1:hover .dilanbg, .shrsre2:hover .dilanbg, .shrsre3:hover .dilanbg, .shrsre4:hover .dilanbg {display:block;	background:url(http://static.ebanhui.com/ebh/tpl/ebh2/images/isrner.png);}
</style>
<![endif]-->
<script type="text/javascript">

    $(function(){
        $.each($('.easingobj'),function(k,v){
            if($(window).height() - ($(this).offset().top-$(window).scrollTop()) > 150)
                $(this).addClass("easing");
        })
    });
    window.onscroll = function(){
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        var top_div = document.getElementById( "video" );
		if( t >= 30 ) {
		$("#video").addClass("video-float")
    } else {
		$("#video").removeClass("video-float")
		$("#videotemp").attr('id','video');
    }
        $.each($('.easingobj'),function(k,v){
            if($(window).height() - ($(this).offset().top-$(window).scrollTop()) > 150)
                $(this).addClass("easing");
        })
    }
function closew(){
	$("#video").removeClass("video-float");
	$("#video").attr('id','videotemp');
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
    //登录
    function _login(){
        tologin('/login.html?returnurl=__url__');
    }
$(function () {
	var href = location.href;
	if(href=="http://intro.ebh.net/")
		$(".links a:[href='"+href+"?p=1']").addClass("onhover");
	else
		$(".links a:[href='"+href+"']").addClass("onhover");

});
</script>
<body>

<!--<div class="right-fixed">-->
<!--    <a class="click-ask" href="javascript:;"></a>-->
<!--</div>-->
<!--系统更新提示>
<div style="position: fixed;background:#ff8800;font-size:14px;color:#fff;z-index: 10;height:30px;line-height:30px;width:100%;text-align:center;"><img style="vertical-align: text-bottom;" src="http://static.ebanhui.com/ebh/tpl/2016/images/zhuyi01.jpg" />亲爱的用户：为了给您提供更优质的服务，系统将于12月27号22点30分进行升级，期间可能会出现服务中断情况，敬请谅解！</div><!-->
<div class="dingtop">
	<div class="nadtop">
		<a onfocus="this.blur();" class="meitem" href="http://ebhdemo.ebh.net" target="_blank">演示网校</a>
		<a onfocus="this.blur();" href="http://www.ebh.net/createroom.html" class="cloudfreebulid" target="_blank" >免费创建网校</a>
		<div class="toprisr">
			<div class="search">
				<input class="searchtxt" name="textarea" x_hit="搜索网校" type="text" style="color:#fff;" id="searchfm" value="<?= !empty($q)?$q:'' ?>" />
				<a class="searchbtn" href="javascript:;" onclick="dosearch()"> </a>
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
					<a class="rsizer"  target="_blank" href="<?=$homeurl?>"> <i class="humserr"></i><?= substr($user['username'],0,16	)?> </a>
					<a class="rsizer" target="_blank" href="<?=$homeurl?>">个人中心</a>
					<a class="rsizer" href="<?=geturl('logout')?>">退出</a>
					<a class="rsizer"  href="/moreapp.html">更多...</a>
			<?php }?>
		</div>
	</div>
</div>
<div id="video">
	<div class="nav">
		<div class="neinaver">
			<div class="logo">
				<a onfocus="this.blur();"  href="http://www.ebh.net">
				<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/logo.png?v=01">
				</a>
			</div>
			<div class="links">
				<a onfocus="this.blur();" class="menu_item" href="http://www.ebh.net/intro/livesystem.html" target="_blank">
					在线直播
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/?p=1" target="_blank">
					在线录播
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/?p=2" target="_blank">
					微课工具
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/interaction.html" target="_blank">
					互动课堂
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/homework.html" target="_blank">
					作业系统
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/interactquer.html" target="_blank">
					互动答疑
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/connection.html" target="_blank">
					微校讯通
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/cloud.html" target="_blank">
					网校云盘
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/community.html" target="_blank">
					社区圈子
					<span></span>
				</a>
				<a onfocus="this.blur();" class="menu_item" href="http://intro.ebh.net/intro/schoolshop.html" target="_blank">
					网校商城
					<span></span>
				</a>
			</div>
		</div>
	</div>
	<a class="tiaoto" href="#top"></a>
</div>

