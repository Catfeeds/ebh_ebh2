<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=1200, user-scalable=no" name="viewport"/>
    <title>商务合作</title>
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
<div class="cooperate_banner">	
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
				<a class="rsizer" onfocus="this.blur();" href="/yoosure.html" target="_blank">名企游学</a>
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
<div class="cooperate_toe">
	<h2 class="toe_title">合作宗旨</h2>
	<img class="toe_img" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/cooperate_tu01.jpg" />
	<p class="toe_txt">我们相信联合将会使我们更加强大。通过资源共享，优势互补，</p>
	<p class="toe_txt">我们一定能够让我们的服务更趋完善，取长补短，</p>
	<p class="toe_txt">利益共享是我们的合作宗旨！选择优秀的合作伙伴，</p>
	<p class="toe_txt">提升双方的社会效益。</p>
</div>
<div class="cooperate_way easingobj">
	<div class="gverue">
		<h2 class="way_h2">合作方式</h2>
		<div class="qyy_studt_up">
			<div class="way_list">
				<img class="way_img" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/cooperate_tu02.jpg" />
				<span class="way_txt">企业采购、定制</span>
			</div>
			<div class="way_list">
				<img class="way_img" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/cooperate_tu03.jpg" />
				<span class="way_txt">市场活动合作</span>
			</div>
			<div class="way_list" style="margin-right:0px;">
				<img class="way_img" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/cooperate_tu04.jpg" />
				<span class="way_txt">广告媒体合作 </span>
			</div>
			<div class="way_list">
				<img class="way_img" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/cooperate_tu05.jpg" />
				<span class="way_txt">同业流量交换和用户共享</span>
			</div>
			<div class="way_list">
				<img class="way_img" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/cooperate_tu06.jpg" />
				<span class="way_txt">销售合作分成</span>
			</div>
			<div class="way_list" style="margin-right:0px;">
				<img class="way_img" src="http://static.ebanhui.com/ebh/tpl/ebh2/images/cooperate_tu07.jpg" />
				<span class="way_txt">您有更好的合作方式敬请联系</span>
			</div>
		</div>
	</div>	
</div>
<div class="cooperate_basic easingobj">
	<h2 class="basic_h2">合作基础</h2>
	<div class="basic_left">
		<p class="basic_txt">真诚、合法、优质、实事求是</p>
	</div>
	<div class="basic_main">
		<p class="basic_txt">把长期合作发展作前提，有高度的责任心和远大的目标</p>
	</div>
	<div class="basic_rig">
		<p class="basic_txt">有广泛的合作优势以及多样化的合作方式</p>
	</div>
</div>
<div class="cooperate_contact">
	<div class="gverue">
		<h2 class="contact_h2">市场合作联系方式</h2>
		<div class="contact_lef">
			<p class="contact_txt">管杨敏：158-5828-2857</p>
			<p class="contact_txt">王明伟：182-5718-8781</p>
			<p class="contact_txt">汤&nbsp;&nbsp;文：187-5889-7058</p>
		</div>
		<div class="contact_rig">
			<img src="http://static.ebanhui.com/ebh/tpl/ebh2/images/qyy_kefu.jpg" />
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
