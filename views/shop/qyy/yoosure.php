<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=1200, user-scalable=no" name="viewport"/>
    <title>名企游学</title>
    <meta name="description" content="企业云网校平台企业云网校平台" />
	<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/ebh2/css/qyy.css<?=getv()?>" />
	<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="http://static.ebanhui.com/ebh/js/common.js<?=getv()?>"></script>
    <script type="text/javascript" src="http://static.ebanhui.com/ebh/js/xform.js?v=1"></script>
    <script src="http://static.ebanhui.com/ebh/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>
</head>
</script>
<body>
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
    //登录
    function _login(){
			$.loginDialog();
    }
</script>
<body>

<!--<div class="right-fixed">-->
<!--    <a class="click-ask" href="javascript:;"></a>-->
<!--</div>-->
<!--系统更新提示>
<div style="position: fixed;background:#ff8800;font-size:14px;color:#fff;z-index: 10;height:30px;line-height:30px;width:100%;text-align:center;"><img style="vertical-align: text-bottom;" src="http://static.ebanhui.com/ebh/tpl/2016/images/zhuyi01.jpg" />亲爱的用户：为了给您提供更优质的服务，系统将于12月27号22点30分进行升级，期间可能会出现服务中断情况，敬请谅解！</div><!-->
<div id="video" class="">
	<a class="tiaoto" href="#top"></a>
</div>
<div class="yousure_banner">	
	<div class="qyy_head">
		<ul class="nav">
			<li>
				<a class="rsizer" onfocus="this.blur();" href="/" target="_blank">企业云</a>
			</li>
			<li>
				<a class="rsizer" onfocus="this.blur();" href="javascript:void(0)">课程</a>
				<div class="box">
					<a onfocus="this.blur();" class="menu_item" href="http://ytzk.ebh.net" target="_blank">
						CIT核心课程
						<span></span>
					</a>
					<a onfocus="this.blur();" class="menu_item" href="http://powerplus.ebh.net" target="_blank">
						powerplus
						<span></span>
					</a>
                </div>
			</li>
			<li>
				<a class="rsizer" onfocus="this.blur();" href="/yoosure.html">名企游学</a>
			</li>
			<li>
				<a class="rsizer" onfocus="this.blur();" href="/cooperate.html"> 商务合作 </a>
			</li>
			<li>
				<a class="rsizer" onfocus="this.blur();" href="http://china500.org/" target="_blank"> 亚投智库 </a>
			</li>
		</ul>
		<ul class="signin">
			<?php if(empty($user)){?>
			<li class="login"><a class="rsizer" href="javascript:void(0);" onclick="_login()"><i class="humserr"></i>登录</a></li>
			<li><a class="rsizer" target="_blank"  href="/register.html">注册</a></li>
			<?php }else{ ?>
				<?php $homeurl = geturl('homev2');?>
					<li class="login"><a class="rsizer"  target="_blank" href="<?=$homeurl?>"><i class="humserr"></i><?= substr($user['username'],0,12	)?></a></li>
					<li style="margin-right:0px;"><a class="rsizer" href="<?=geturl('logout')?>">退出</a></li>
			<?php }?>
		</ul>
	</div>
</div>
<div class="qyy_sure">
	<div class="mainjs">
    <a class="ebhintro" href="http://svnlan.ebh.net/course/115036.html" target="_blank">
        <img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/qyy_shre.jpg">
    </a>
    <div class="rishtdt">
    	<h2 class="titrise">企业游学能学到什么？</h2>
        <p class="prit">企业家企业游学既不是单纯的旅游也不是纯粹的培训学习，它的内容贯穿了企业培训和参观游览，介于游与学之间，同时又融合了学与游的内容。企业家企业游学，拓宽国际化视野，提高国际化水平，锻炼企业家们的多项专业知识技能。</p>
        <p class="prit">企业家游学可以激发企业家自身内部的动力，促使他们不断地完善自己。一个成功的企业家不仅需要通过自我反省、社会比较、心理测评等方式对自己的性格特点、兴趣特长等有清楚的了解，还需要对社会现实及发展趋势有清晰的认识，这可以帮助企业家重新审视自己，结合社会实际，给自己一个合理的定位。</p>
    </div>
</div>
</div>
<div class="chdetd">
	<div class="footer_bottom">
		<div class="main">
			<div class="main_left">
				<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/logo.png?v=01">
				<p class="icon-address">浙江省杭州市江干区钱江新城五星路188号荣安中心大厦25F</p>
				<p class="icon-phone">0571-87757303</p>
				<p class="icon-about"><a target="_blank" style="color:#fff;" href="http://www.ebh.net/about.html">关于我们</a></p>
			</div>
			<div class="border1px"></div>
			<div class="main_right">
				<div class="left">
					<p>"e板会" -APP</p>
					<div class="content">
						<div class="imgbox">
							<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_appcode.jpg" />
						</div>
						<div class="buttonbox">
							<a class="iosdown" target="_blank" href="https://itunes.apple.com/us/app/yun-jiao-xue-ping-tai/id975445987?l=zh&amp;ls=1&amp;mt=8"<i></i> 苹果下载</a>
							<a class="anddown" target="_blank" href="http://soft.ebh.net/ebanhuipad.apk"><i></i> 安卓下载</a>
						</div>
					</div>
				</div>
				<div class="right">
					<p>微信公众号</p>
					<div class="content">
						<div class="imgbox">
							<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/ebh3_ebhcode.jpg?v=01">
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="footer_bottom_text">
		<div class="main">
			<p>
				<div style="text-align:center">
					<span style="color:#a4a9aa">
					<i></i>
					浙公网安备 33010602003467号
					</span>
					<a href="http://www.miibeian.gov.cn/" target="_blank" style="color:#a4a9aa">浙B2-20160787</a>
					<span style="color:#a4a9aa">Copyright © 2011-<?=date('Y')?> ebh.net All Rights Reserved </span></span>
					<br>
				</div>
			</p>
		</div>
	</div>
	<div class="clear">

	</div>
</div>

<!-- 统计代码开始 -->
<?php EBH::app()->lib('Analytics')->get('baidu','www_ebh')?>
<!-- 统计代码结束 -->
</body>
</html>
